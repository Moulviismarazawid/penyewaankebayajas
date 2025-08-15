<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PasswordResetModel;
use CodeIgniter\I18n\Time;

class Auth extends BaseController
{
    public function login(){ return view('auth/login',['title'=>'Masuk']); }
        public function google()
    {
        // ====== CONFIG ======
        $clientId     = '864120631159-c7iku0gkd8l4v6l7njk6rj1d2ms8gtkc.apps.googleusercontent.com';
        $redirectUri  = base_url('auth/google/callback');

        // anti-CSRF (OAuth state)
        $state = bin2hex(random_bytes(16));
        session()->set('g_state', $state);

        $params = [
            'client_id'                => $clientId,
            'redirect_uri'             => $redirectUri,
            'response_type'            => 'code',
            'scope'                    => 'openid email profile',
            'access_type'              => 'offline',
            'include_granted_scopes'   => 'true',
            'state'                    => $state,
            'prompt'                   => 'consent', // tampilkan pilih akun/consent eksplisit
        ];

        return redirect()->to('https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params));
    }

    public function googleCallback()
    {
        // ====== CONFIG ======
        $clientId     = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $redirectUri  = env('GOOGLE_REDIRECT_URI') ?? rtrim(site_url('auth/google/callback'), '/');

        // Validasi state & error
        $state = $this->request->getGet('state');
        $code  = $this->request->getGet('code');
        if (!$code || !$state || $state !== session('g_state')) {
            return redirect()->to('/auth/login')->with('error', 'Login Google dibatalkan/invalid.');
        }
        session()->remove('g_state');

        // Tukar authorization code -> access_token
        $tokenResp = $this->httpPost('https://oauth2.googleapis.com/token', [
            'code'          => $code,
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri'  => $redirectUri,
            'grant_type'    => 'authorization_code',
        ]);
        $token = json_decode($tokenResp, true);
        if (!is_array($token) || empty($token['access_token'])) {
            return redirect()->to('/auth/login')->with('error', 'Gagal mengambil token Google.');
        }

        // Ambil user info
        $infoResp = $this->httpGet('https://www.googleapis.com/oauth2/v3/userinfo', $token['access_token']);
        $info = json_decode($infoResp, true);
        if (!is_array($info) || empty($info['email'])) {
            return redirect()->to('/auth/login')->with('error', 'Gagal membaca profil Google.');
        }

        // Upsert user berdasarkan email
        $um = new \App\Models\UserModel();
        $u  = $um->where('email', $info['email'])->first();

        if (!$u) {
            $fullName = $info['name'] ?? trim(($info['given_name'] ?? '') . ' ' . ($info['family_name'] ?? '')) ?: 'Pengguna Google';
            $random   = bin2hex(random_bytes(8)); // jaga-jaga kalau nanti butuh set password
            $id = $um->insert([
                'role'          => 'user',
                'full_name'     => $fullName,
                'email'         => $info['email'],
                'phone'         => null,
                'password_hash' => password_hash($random, PASSWORD_DEFAULT),
                'active'        => 1,
            ]);
            $u = $um->find($id);
        }

        // Sesi & last_login
        session()->set(['user_id' => $u['id'], 'role' => $u['role'], 'name' => $u['full_name']]);
        $um->update($u['id'], ['last_login' => \CodeIgniter\I18n\Time::now()]);

        return redirect()->to('/')->with('success', 'Selamat datang, ' . $u['full_name'] . '!');
    }

    /** --- Helpers tanpa dependency eksternal --- */
    private function httpPost(string $url, array $data): string
    {
        $ctx = stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                'content' => http_build_query($data),
                'ignore_errors' => true,
                'timeout' => 15,
            ],
        ]);
        return file_get_contents($url, false, $ctx) ?: '';
    }

    private function httpGet(string $url, string $accessToken): string
    {
        $ctx = stream_context_create([
            'http' => [
                'method'  => 'GET',
                'header'  => "Authorization: Bearer {$accessToken}\r\n",
                'ignore_errors' => true,
                'timeout' => 15,
            ],
        ]);
        return file_get_contents($url, false, $ctx) ?: '';
    }
    public function attempt()
    {
        $email = trim($this->request->getPost('email'));
        $pass  = $this->request->getPost('password');
        $u = (new UserModel())->where('email',$email)->first();
        if (!$u || !password_verify($pass,$u['password_hash'])) {
            return redirect()->back()->withInput()->with('error','Email/password salah.');
        }
        session()->set(['user_id'=>$u['id'],'role'=>$u['role'],'name'=>$u['full_name']]);
        (new UserModel())->update($u['id'], ['last_login'=>Time::now()]);
        return redirect()->to('/');
    }

    public function register(){ return view('auth/register',['title'=>'Daftar']); }

    public function store()
    {
        $rules = [
            'full_name'=>'required|min_length[3]',
            'email'=>'required|valid_email|is_unique[users.email]',
            'phone'=>'required|min_length[8]|is_unique[users.phone]',
            'password'=>'required|min_length[6]',
            'password_confirm'=>'required|matches[password]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' | ', $this->validator->getErrors()));
        }
        $id = (new UserModel())->insert([
            'role'=>'user','full_name'=>$this->request->getPost('full_name'),
            'email'=>$this->request->getPost('email'),'phone'=>$this->request->getPost('phone'),
            'password_hash'=>password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);
        session()->set(['user_id'=>$id,'role'=>'user','name'=>$this->request->getPost('full_name')]);
        return redirect()->to('/')->with('success','Registrasi berhasil!');
    }

    public function forgot(){ return view('auth/forgot',['title'=>'Lupa Password']); }

    public function sendReset()
    {
        $email = trim($this->request->getPost('email'));
        if (!$email) return redirect()->back()->with('error','Email wajib.');
        $token = bin2hex(random_bytes(16));
        (new PasswordResetModel())->insert(['email'=>$email,'token'=>$token,'created_at'=>Time::now()]);
        return redirect()->to('/auth/reset/'.$token)->with('success','Gunakan form berikut untuk reset password.');
    }

    public function reset($token){ return view('auth/reset',['title'=>'Reset Password','token'=>$token]); }

    public function updatePassword()
    {
        $token = $this->request->getPost('token');
        $pass  = $this->request->getPost('password');
        $conf  = $this->request->getPost('password_confirm');
        if ($pass!==$conf) return redirect()->back()->with('error','Konfirmasi tidak sama.');
        $pr = new PasswordResetModel();
        $row = $pr->where('token',$token)->first();
        if (!$row) return redirect()->to('/auth/forgot')->with('error','Token tidak valid.');
        $u = (new UserModel())->where('email',$row['email'])->first();
        if ($u) (new UserModel())->update($u['id'], ['password_hash'=>password_hash($pass,PASSWORD_DEFAULT)]);
        $pr->where('token',$token)->delete();
        return redirect()->to('/auth/login')->with('success','Password diperbarui.');
    }

    public function logout(){ session()->destroy(); return redirect()->to('/')->with('success','Logout berhasil.'); }


}
