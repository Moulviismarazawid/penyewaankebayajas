<?php
namespace App\Controllers;

use App\Models\ProductModel;

class Cart extends BaseController
{
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        return view('cart/index', [
            'title'=>'Keranjang — Sewa Kebaya Jas Bandar Lampung',
            'description'=>'Keranjang sewa Anda.',
            'cart'=>$cart
        ]);
    }

    public function add()
    {
        if (!$this->request->is('post')) return redirect()->back();
        $id  = (int)$this->request->getPost('product_id');
        $qty = max(1, (int)$this->request->getPost('qty'));
        $p = (new ProductModel())->find($id);
        if (!$p || !$p['is_active']) return redirect()->back()->with('error','Produk tidak tersedia.');

        $cart = session()->get('cart') ?? [];
        $key = (string)$id;
        if (isset($cart[$key])) $cart[$key]['qty'] += $qty;
        else $cart[$key] = ['product_id'=>$id,'name'=>$p['name'],'price'=>$p['price_per_day'],'qty'=>$qty,'slug'=>$p['slug']];
        session()->set('cart',$cart);

        return redirect()->to('/cart')->with('success','Produk ditambahkan ke keranjang.');
    }

    public function remove()
    {
        $id = (string)$this->request->getPost('product_id');
        $cart = session()->get('cart') ?? [];
        unset($cart[$id]); session()->set('cart',$cart);
        return redirect()->to('/cart')->with('success','Produk dihapus.');
    }

    public function clear()
    {
        session()->remove('cart');
        return redirect()->to('/cart')->with('success','Keranjang dikosongkan.');
    }
}
