<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class Products extends BaseController
{
    public function index()
    {
        $q    = $this->request->getGet('q');
        $cat  = $this->request->getGet('kategori');
        $size = $this->request->getGet('ukuran');
        $min  = $this->request->getGet('min');
        $max  = $this->request->getGet('max');

        $pm = new ProductModel();
        // kembalian searchList adalah MODEL, jadi boleh ->paginate()
        $pmQuery  = $pm->searchList($q, $cat, $size, $min, $max);
        $products = $pmQuery->paginate(12, 'products'); // group 'products' biar pager unik
        $pager    = $pmQuery->pager;

        $categories = (new CategoryModel())->orderBy('name','ASC')->findAll();

        return view('products/index', [
            'title'       => 'Katalog Produk — Sewa Kebaya Jas Bandar Lampung',
            'description' => 'Katalog kebaya & jas. Cari nama, kategori, ukuran, dan harga.',
            'products'    => $products,
            'pager'       => $pager,
            'categories'  => $categories,
            'q'           => $q,
            'cat'         => $cat,
            'size'        => $size,
            'min'         => $min,
            'max'         => $max,
        ]);
    }

    public function show($slug)
    {
        $pm = new ProductModel();
        $p = $pm->select('products.*, categories.name as category_name')
                ->join('categories','categories.id=products.category_id','left')
                ->where('products.slug',$slug)->first();

        if (!$p) return redirect()->to('/produk');

        return view('products/show', [
            'title'       => $p['meta_title'] ?: $p['name'].' — Sewa Kebaya Jas Bandar Lampung',
            'description' => $p['meta_desc'] ?: 'Sewa '.$p['name'].' di Bandar Lampung.',
            'product'     => $p
        ]);
    }
}
