<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\RentalModel;
use App\Models\RentalItemModel;
use App\Models\UserModel;
use App\Models\CustomerModel;
use CodeIgniter\I18n\Time;

class Order extends BaseController
{
  public function quick()
{
    if (!$this->request->is('post')) {
        return redirect()->back();
    }

    $pid = (int) $this->request->getPost('product_id');
    $qty = max(1, (int) $this->request->getPost('qty'));

    $pm = new \App\Models\ProductModel();
    $p  = $pm->where('is_active', 1)->find($pid);
    if (!$p) {
        return redirect()->back()->with('error', 'Produk tidak tersedia.');
    }

    // Simpan ke session cart
    $cart = session()->get('cart') ?? [];
    $key  = (string) $pid;

    if (isset($cart[$key])) {
        $cart[$key]['qty'] += $qty;
    } else {
        $cart[$key] = [
            'product_id' => $pid,
            'name'       => $p['name'],
            'price'      => $p['price_per_day'],
            'qty'        => $qty,
            'slug'       => $p['slug'],
        ];
    }

    session()->set('cart', $cart);

    // Arahkan ke form checkout (wajib diisi)
    return redirect()->to('/order/checkout');
}


    public function checkout()
    {
        $cart = session()->get('cart') ?? [];
        if (!$cart) return redirect()->to('/cart')->with('error','Keranjang kosong.');

        $userId = session('user_id');
        $cust   = (new CustomerModel())->where('user_id',$userId)->first();
        $user   = (new UserModel())->select('id,full_name,email,phone')->find($userId); // ⬅️ ambil email registrasi

        return view('order/checkout', [
            'title'      => 'Checkout',
            'description'=> 'Isi data diri.',
            'cart'       => $cart,
            'customer'   => $cust,
            'user'       => $user, // ⬅️ kirim ke view
        ]);
    }

    public function confirm()
    {
        $userId = session('user_id');
        $cart   = session()->get('cart') ?? [];
        if (!$cart) return redirect()->to('/cart')->with('error','Keranjang kosong.');

        $user = (new UserModel())->select('email')->find($userId);
        if (!$user) return redirect()->back()->with('error','User tidak ditemukan.');

        // Ambil input & PAKSA email dari tabel users (anti-manipulasi)
        $data = $this->request->getPost();
        $data['user_id'] = $userId;
        $data['email']   = $user['email']; // ⬅️ override dari registrasi

        // Validasi – email tak perlu diisi user
        $rules = [
            'nik'        => 'required|min_length[8]|is_unique[customers.nik,user_id,{user_id}]',
            'full_name'  => 'required|min_length[3]',
            'phone'      => 'required|min_length[8]',
            'address'    => 'required|min_length[6]',
            'start_date' => 'required|valid_date[Y-m-d]',
            'end_date'   => 'required|valid_date[Y-m-d]',
            // 'email' tidak divalidasi dari input user, karena dipaksa dari users
        ];

        // Validasi berdasarkan $data yang sudah dipaksa email-nya
        if (!$this->validate($rules, [], $data)) {
            return redirect()->back()->withInput()->with('error', implode(' | ', $this->validator->getErrors()));
        }

        // Upsert Customer (email diisi dari registrasi)
        $cm   = new CustomerModel();
        $cust = $cm->where('user_id',$userId)->first();
        $payloadCust = [
            'nik'       => $data['nik'],
            'full_name' => $data['full_name'],
            'email'     => $data['email'], // ⬅️ dari users
            'phone'     => $data['phone'],
            'address'   => $data['address'],
        ];
        if ($cust) $cm->update($cust['id'], $payloadCust);
        else       $cm->insert($payloadCust + ['user_id'=>$userId]);

        // Buat invoice pending
        $code = generate_invoice_code();
        $rm   = new RentalModel();
        $rid  = $rm->insert([
            'user_id'    => $userId,
            'code'       => $code,
            'status'     => 'pending',
            'start_date' => $data['start_date'],
            'end_date'   => $data['end_date'],
            'due_date'   => $data['end_date'],
            'queued_at'  => Time::now(),
            'notes'      => $this->request->getPost('notes') ?: null,
        ]);

        // Items
        $pm = new ProductModel();
        $lines = [
            "Halo Admin, saya ingin konfirmasi sewa:",
            "Kode: $code",
            "Nama: {$data['full_name']}",
            "NIK: {$data['nik']}",
            "Email: {$data['email']}", // ⬅️ tampilkan juga di WA payload
            "WA: {$data['phone']}",
            "Alamat: {$data['address']}",
            "Tanggal: {$data['start_date']} s/d {$data['end_date']}",
            "Produk:",
        ];
        foreach ($cart as $c) {
            $p = $pm->find($c['product_id']); if (!$p) continue;
            (new RentalItemModel())->insert([
                'rental_id'            => $rid,
                'product_id'           => $p['id'],
                'qty'                  => $c['qty'],
                'daily_price_snapshot' => $p['price_per_day'],
            ]);
            $lines[] = "- {$p['name']} x{$c['qty']}";
        }
        $rm->update($rid, ['wa_payload'=>implode("\n",$lines)]);

        session()->remove('cart');
        return redirect()->to('/order/riwayat')->with('success','Invoice dibuat & masuk riwayat.');
    }

    public function whatsapp($code)
    {
        $waAdmin = '6289602727543';
        $r = (new RentalModel())->where('code',$code)->first();
        if (!$r) return redirect()->to('/order/riwayat')->with('error','Kode tidak ditemukan.');
        return redirect()->to( wa_link($waAdmin, $r['wa_payload'] ?? ('Konfirmasi sewa: '.$code)) );
    }

    public function history()
    {
        $rows = (new RentalModel())->where('user_id',session('user_id'))->orderBy('created_at','DESC')->findAll();
        return view('order/history', ['title'=>'Riwayat Sewa','description'=>'Riwayat transaksi Anda.','rows'=>$rows]);
    }
}
