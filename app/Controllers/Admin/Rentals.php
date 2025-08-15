<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ProductModel;
use App\Models\RentalModel;
use App\Models\RentalItemModel;
use App\Models\FineModel;
use App\Models\CustomerModel;
use CodeIgniter\I18n\Time;

class Rentals extends BaseController
{
    public function index()
    {
        // dropdown user & produk untuk form "Buat Invoice"
        $users = (new UserModel())
            ->select('id, full_name, email')
            ->where('active', 1)
            ->orderBy('full_name', 'ASC')
            ->findAll();

        $products = (new ProductModel())
            ->select('id, name, price_per_day')
            ->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->findAll();

        // daftar transaksi
        $rows = (new RentalModel())
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/rentals', [
            'title'    => 'Rental',
            'users'    => $users,
            'products' => $products,
            'rows'     => $rows,
        ]);
    }

    public function confirm($id)
    {
        $rm = new RentalModel(); 
        $r  = $rm->find($id);
        if (!$r || $r['status'] !== 'pending')
            return redirect()->back()->with('error','Transaksi tidak valid.');

        $items = (new RentalItemModel())->where('rental_id',$id)->findAll();
        $pm    = new ProductModel();

        // validasi stok
        foreach ($items as $it) {
            $p = $pm->find($it['product_id']);
            if (!$p || $p['stock'] < $it['qty']) {
                return redirect()->back()->with('error','Stok kurang untuk '.($p['name'] ?? 'produk'));
            }
        }
        // kurangi stok
        foreach ($items as $it) {
            $p = $pm->find($it['product_id']);
            $pm->update($p['id'], ['stock' => $p['stock'] - $it['qty']]);
        }

        $rm->update($id, [
            'status'       => 'aktif',
            'confirmed_at' => Time::now(),
        ]);

        return redirect()->back()->with('success','Transaksi dikonfirmasi.');
    }

    public function cancel($id)
    {
        (new RentalModel())->update($id, ['status'=>'batal','canceled_at'=>Time::now()]);
        return redirect()->back()->with('success','Transaksi dibatalkan.');
    }

    public function finish($id)
    {
        $rm = new RentalModel(); 
        $r  = $rm->find($id);
        if (!$r || $r['status'] !== 'aktif')
            return redirect()->back()->with('error','Status tidak valid.');

        $now = Time::now();
        $rm->update($id, ['status'=>'selesai','returned_at'=>$now]);

        // denda keterlambatan (Rp25.000/hari)
        if (!empty($r['due_date'])) {
            $due = new \DateTime($r['due_date'].' 00:00:00');
            $ret = new \DateTime($now->toDateTimeString());
            $daysLate = ($ret > $due) ? (int)$due->diff($ret)->format('%a') : 0;

            if ($daysLate > 0) {
                (new FineModel())->insert([
                    'rental_id' => $id,
                    'type'      => 'late',
                    'amount'    => 25000 * $daysLate,
                    'note'      => "Denda telat {$daysLate} hari",
                    'created_at'=> $now,
                ]);
            }
        }

        // kembalikan stok
        $items = (new RentalItemModel())->where('rental_id',$id)->findAll();
        $pm    = new ProductModel();
        foreach ($items as $it) {
            $p = $pm->find($it['product_id']);
            if ($p) $pm->update($p['id'], ['stock' => $p['stock'] + $it['qty']]);
        }

        return redirect()->back()->with('success','Transaksi diselesaikan.');
    }
        public function show($id)
    {
        $rm = new RentalModel();
        $r  = $rm->find($id);
        if (!$r) return redirect()->to('/admin/rentals')->with('error','Transaksi tidak ditemukan.');

        // data pemesan
        $user = (new UserModel())->select('full_name,email,phone')->find($r['user_id']);
        $cust = (new CustomerModel())->where('user_id', $r['user_id'])->first();

        // items + nama produk
        $items = (new RentalItemModel())
            ->select('rental_items.*, products.name as product_name')
            ->join('products','products.id = rental_items.product_id','left')
            ->where('rental_items.rental_id', $id)
            ->findAll();

        // lama sewa (hari)
        $days = 1;
        if (!empty($r['start_date']) && !empty($r['end_date'])) {
            $sd = new \DateTime($r['start_date']);
            $ed = new \DateTime($r['end_date']);
            $days = max(1, (int)$sd->diff($ed)->format('%a'));
        }

        // total sewa
        $rentTotal = 0;
        foreach ($items as $it) {
            $rentTotal += (int)$it['daily_price_snapshot'] * (int)$it['qty'] * $days;
        }

        // denda
        $fines = (new FineModel())->where('rental_id',$id)->findAll();
        $fineTotal = array_sum(array_map(fn($f)=> (int)$f['amount'], $fines));

        $grandTotal = $rentTotal + $fineTotal;

        return view('admin/rentals_show', [
            'title'      => 'Detail Pemesanan',
            'r'          => $r,
            'items'      => $items,
            'days'       => $days,
            'rentTotal'  => $rentTotal,
            'fines'      => $fines,
            'fineTotal'  => $fineTotal,
            'grandTotal' => $grandTotal,
            'cust'       => $cust,
            'user'       => $user,
        ]);
    }
    public function new()
    {
        $users = (new \App\Models\UserModel())
            ->select('id, full_name, email, phone')
            ->where('active', 1)->orderBy('full_name','ASC')->findAll();

        $products = (new \App\Models\ProductModel())
            ->select('id, name, price_per_day')
            ->where('is_active', 1)->orderBy('name','ASC')->findAll();

        // OPTIONAL: kalau punya data walk-in, bisa dipass juga
        $walkins = []; // isi kalau kamu punya model Walkin

        return view('admin/rentals_new', [
            'title'    => 'Buat Order (Admin)',
            'users'    => $users,
            'products' => $products,
            'walkins'  => $walkins,
        ]);
    }

    public function store()
    {
        helper(['text']);

        $source   = $this->request->getPost('customer_source'); // user|manual|walkin (opsional)
        $userIdIn = (int) $this->request->getPost('user_id');

        // data manual/walkin (email/phone boleh kosong)
        $nameIn   = trim((string)$this->request->getPost('full_name'));
        $emailIn  = trim((string)$this->request->getPost('email'));
        $phoneIn  = trim((string)$this->request->getPost('phone'));
        $nikIn    = trim((string)$this->request->getPost('nik'));
        $addrIn   = trim((string)$this->request->getPost('address'));

        $start = $this->request->getPost('start_date');
        $end   = $this->request->getPost('end_date');
        $notes = trim((string)$this->request->getPost('notes'));

        if (!$start || !$end) {
            return redirect()->back()->withInput()->with('error','Lengkapi tanggal mulai & selesai.');
        }
        if (strtotime($end) < strtotime($start)) {
            return redirect()->back()->withInput()->with('error','Tanggal selesai tidak boleh lebih awal dari mulai.');
        }

        // Ambil items: dukung format baru (array) & lama (single)
        $items = $this->request->getPost('items'); // ex: items[0][product_id], items[0][qty]
        if (!is_array($items) || empty($items)) {
            // fallback: dukung single product lama
            $pid = (int) $this->request->getPost('product_id');
            $qty = max(1, (int) $this->request->getPost('qty'));
            if (!$pid) return redirect()->back()->withInput()->with('error','Pilih produk.');
            $items = [['product_id' => $pid, 'qty' => $qty]];
        }

        // Tentukan user_id TANPA mengubah flow lama:
        // - Jika pilih user terdaftar → pakai user itu
        // - Jika manual/walk-in → bikin "shadow user" (active=0) supaya show() lama tetap bisa ambil via user_id
        $finalUserId = $this->ensureUserForCustomer([
            'user_id'   => $userIdIn ?: null,
            'full_name' => $nameIn ?: 'Pelanggan',
            'email'     => $emailIn ?: null,
            'phone'     => $phoneIn ?: null,
        ]);

        // Upsert customers, KUNCI: link-kan ke $finalUserId
        $cm = new \App\Models\CustomerModel();
        $customerId = $this->upsertCustomer($cm, [
            'user_id'   => $finalUserId,
            'full_name' => $nameIn ?: 'Pelanggan',
            'email'     => $emailIn ?: null,
            'phone'     => $phoneIn ?: null,
            'nik'       => $nikIn ?: null,
            'address'   => $addrIn ?: null,
        ]);

        // Buat rental (pending; stok dipotong saat confirm()—logic lama aman)
        $code = 'INV'.date('Ymd').'-'.strtoupper(substr(random_string('alnum', 6),0,6));

        $rm = new \App\Models\RentalModel();
        $rentalId = $rm->insert([
            'code'        => $code,
            'user_id'     => $finalUserId,   // penting agar show() lama tetap kerja
            'customer_id' => $customerId,    // tambahan, tidak mengganggu flow lama
            'status'      => 'pending',
            'start_date'  => $start,
            'due_date'    => $end,
            'notes'       => $notes ?: null,
            'created_at'  => Time::now(),
        ]);

        // Simpan item (snapshot harga per hari)
        $pm  = new \App\Models\ProductModel();
        $rim = new \App\Models\RentalItemModel();

        foreach ($items as $row) {
            $pid = (int)($row['product_id'] ?? 0);
            $qty = max(1, (int)($row['qty'] ?? 1));
            if (!$pid) continue;

            $prod = $pm->select('id, price_per_day')->find($pid);
            if (!$prod) continue;

            $rim->insert([
                'rental_id'            => $rentalId,
                'product_id'           => $prod['id'],
                'qty'                  => $qty,
                'daily_price_snapshot' => (int)$prod['price_per_day'],
            ]);
        }

        return redirect()->to('/admin/rentals/'.$rentalId)->with('success','Order dibuat (pending).');
    }

    /**
     * Pastikan ada user_id untuk setiap order (tanpa mengubah flow lama).
     * - Jika admin memilih user → pakai dia.
     * - Jika manual/walk-in → buat "shadow user" (active=0) supaya show() lama (cari by user_id) tetap jalan.
     */
    private function ensureUserForCustomer(array $data): int
    {
        $um = new \App\Models\UserModel();

        // 1) Jika admin memilih user terdaftar
        if (!empty($data['user_id'])) {
            return (int) $data['user_id'];
        }

        // 2) Kalau ada email dan sudah terdaftar → pakai akun itu
        if (!empty($data['email'])) {
            $ex = $um->where('email', $data['email'])->first();
            if ($ex) return (int) $ex['id'];
        }

        // 3) Buat shadow user (active=0) — tidak mengganggu login normal
        $email = $data['email'] ?: ('walkin+'.uniqid(). '@local.invalid');
        // pastikan unik
        while ($um->where('email',$email)->first()) {
            $email = 'walkin+'.uniqid(). '@local.invalid';
        }

        $uid = $um->insert([
            'role'          => 'user',
            'full_name'     => $data['full_name'] ?? 'Pelanggan',
            'email'         => $email,
            'phone'         => $data['phone'] ?? null,
            'password_hash' => password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT),
            'active'        => 0, // <— shadow; tidak mengganggu daftar user aktif kamu
        ]);

        return (int) $uid;
    }

    /**
     * Buat/ambil customers **tanpa** mengubah logic lama. 
     * Di-link ke user_id hasil ensureUserForCustomer() agar show() lama (by user_id) tetap bisa ambil data.
     */
    private function upsertCustomer(\App\Models\CustomerModel $cm, array $data): int
    {
        // Cari berdasar user_id → email → phone → nik
        if (!empty($data['user_id'])) {
            if ($row = (new \App\Models\CustomerModel())->where('user_id', $data['user_id'])->first()) {
                // update ringan (nama/phone terbaru) tapi opsional; ini tidak ubah flow
                $cm->update($row['id'], array_filter([
                    'full_name' => $data['full_name'] ?? null,
                    'email'     => $data['email'] ?? null,
                    'phone'     => $data['phone'] ?? null,
                    'nik'       => $data['nik'] ?? null,
                    'address'   => $data['address'] ?? null,
                ], fn($v) => $v !== null));
                return (int)$row['id'];
            }
        }
        if (!empty($data['email'])) {
            if ($row = (new \App\Models\CustomerModel())->where('email', $data['email'])->first()) {
                return (int)$row['id'];
            }
        }
        if (!empty($data['phone'])) {
            if ($row = (new \App\Models\CustomerModel())->where('phone', $data['phone'])->first()) {
                return (int)$row['id'];
            }
        }
        if (!empty($data['nik'])) {
            if ($row = (new \App\Models\CustomerModel())->where('nik', $data['nik'])->first()) {
                return (int)$row['id'];
            }
        }

        // Insert baru — link-kan ke user_id (wajib) supaya show() lama yang ambil via user_id tetap kompatibel
        return (int) $cm->insert([
            'user_id'   => $data['user_id'],              // ← kunci kompatibilitas
            'full_name' => $data['full_name'] ?? 'Pelanggan',
            'email'     => $data['email'] ?? null,
            'phone'     => $data['phone'] ?? null,
            'nik'       => $data['nik'] ?? null,
            'address'   => $data['address'] ?? null,
        ]);
}

}
