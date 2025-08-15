<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\BannerModel;

class Home extends BaseController
{
    public function index()
    {
        $prod = new ProductModel();
        $latest = $prod->where('is_active',1)->orderBy('created_at','DESC')->limit(8)->find();
        $banners = (new BannerModel())->where('is_active',1)->orderBy('sort_order','ASC')->findAll();

        return view('home', [
            'title'=>'Sewa Kebaya Jas Bandar Lampung — Home',
            'description'=>'Sewa kebaya & jas di Bandar Lampung. Koleksi lengkap, harga ramah, proses mudah.',
            'products'=>$latest,
            'banners'=>$banners
        ]);
    }

    public function about()
    {
        return view('about', [
            'title'=>'Tentang Kami — Sewa Kebaya Jas Bandar Lampung',
            'description'=>'Profil usaha, alamat, jam operasional dan kontak WA.'
        ]);
    }
}
