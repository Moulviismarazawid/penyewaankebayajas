<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use CodeIgniter\I18n\Time;

class Products extends BaseController
{
    protected string $uploadDir = FCPATH . 'uploads/products';

    public function index()
    {
        $pm = new ProductModel();
        $rows = $pm->select('products.*, categories.name as category_name')
                   ->join('categories','categories.id=products.category_id','left')
                   ->orderBy('products.created_at','DESC')->findAll();
        $categories = (new CategoryModel())->orderBy('name','ASC')->findAll();
        return view('admin/products', [
            'title'=>'Produk','rows'=>$rows,'categories'=>$categories
        ]);
    }

    public function store()
    {
        // Validasi field teks saja (gambar kita validasi manual)
        $rules = [
            'name'          => 'required|min_length[2]',
            'price_per_day' => 'required|is_natural',
            'stock'         => 'required|is_natural',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                   ->with('error', implode(' | ', $this->validator->getErrors()));
        }

        // Pastikan folder upload ada
        if (!is_dir($this->uploadDir)) {
            @mkdir($this->uploadDir, 0775, true);
        }

        // Ambil file multiple & filter yang valid Gambar
        $files = $this->request->getFileMultiple('images');
        $valid = [];
        if ($files) {
            foreach ($files as $f) {
                if ($f && $f->isValid() && !$f->hasMoved()
                    && in_array($f->getMimeType(), ['image/jpeg','image/png','image/webp'])) {
                    $valid[] = $f;
                }
            }
        }

        // Wajib minimal 1 gambar? -> aktifkan if di bawah
        if (empty($valid)) {
            return redirect()->back()->withInput()
                ->with('error','Minimal unggah 1 gambar (jpg/jpeg/png/webp).');
        }

        // Upload & dapatkan path relatif
        $paths = $this->handleUploads($valid);

        $name = $this->request->getPost('name');
        (new ProductModel())->insert([
            'sku'           => $this->request->getPost('sku'),
            'slug'          => url_title($name,'-',true),
            'name'          => $name,
            'category_id'   => $this->request->getPost('category_id'),
            'size'          => $this->request->getPost('size'),
            'color'         => $this->request->getPost('color'),
            'price_per_day' => $this->request->getPost('price_per_day'),
            'stock'         => $this->request->getPost('stock'),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
            'meta_title'    => $this->request->getPost('meta_title'),
            'meta_desc'     => $this->request->getPost('meta_desc'),
            'images'        => $paths ? json_encode($paths) : null,
        ]);

        return redirect()->back()->with('success','Produk ditambahkan.');
    }

    public function update($id)
    {
        $pm   = new ProductModel();
        $prod = $pm->find($id);
        if (!$prod) return redirect()->back()->with('error','Produk tidak ditemukan.');

        // Ambil daftar gambar lama
        $existing = [];
        if (!empty($prod['images'])) {
            $tmp = json_decode($prod['images'], true);
            if (is_array($tmp)) $existing = $tmp;
        }

        // Hapus yang dicentang
        $remove = (array) $this->request->getPost('remove_images');
        if ($remove) {
            foreach ($existing as $k => $path) {
                if (in_array($path, $remove, true)) {
                    $this->tryDeletePhysical($path);
                    unset($existing[$k]);
                }
            }
            $existing = array_values($existing);
        }

        // Upload baru (opsional, validasi manual)
        $files = $this->request->getFileMultiple('images');
        $valid = [];
        if ($files) {
            foreach ($files as $f) {
                if ($f && $f->isValid() && !$f->hasMoved()
                    && in_array($f->getMimeType(), ['image/jpeg','image/png','image/webp'])) {
                    $valid[] = $f;
                }
            }
        }
        $newPaths = $this->handleUploads($valid);

        $name = $this->request->getPost('name');
        $pm->update($id, [
            'sku'           => $this->request->getPost('sku'),
            'slug'          => url_title($name,'-',true),
            'name'          => $name,
            'category_id'   => $this->request->getPost('category_id'),
            'size'          => $this->request->getPost('size'),
            'color'         => $this->request->getPost('color'),
            'price_per_day' => $this->request->getPost('price_per_day'),
            'stock'         => $this->request->getPost('stock'),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
            'meta_title'    => $this->request->getPost('meta_title'),
            'meta_desc'     => $this->request->getPost('meta_desc'),
            'images'        => ($existing || $newPaths) ? json_encode(array_values(array_merge($existing,$newPaths))) : null,
            'updated_at'    => Time::now(),
        ]);

        return redirect()->back()->with('success','Produk diperbarui.');
    }

    public function delete($id)
    {
        $pm = new ProductModel();
        $prod = $pm->find($id);
        if ($prod && !empty($prod['images'])) {
            $paths = json_decode($prod['images'], true) ?: [];
            foreach ($paths as $p) $this->tryDeletePhysical($p);
        }
        $pm->delete($id);
        return redirect()->back()->with('success','Produk dihapus.');
    }

    /** ==== Helpers ==== */

    private function handleUploads(array $files): array
    {
        $paths = [];
        foreach ($files as $file) {
            if (!$file || !$file->isValid()) continue;
            $ext = strtolower($file->getExtension() ?: 'jpg'); // fallback
            $new = date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $file->move($this->uploadDir, $new, true);
            $paths[] = '/uploads/products/' . $new; // simpan path relatif
        }
        return $paths;
    }

    private function tryDeletePhysical(string $relPath): void
    {
        $abs = FCPATH . ltrim($relPath, '/');
        if (is_file($abs)) @unlink($abs);
    }
}
