<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RentalModel;
use App\Models\ProductModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $rm = new RentalModel();
        $pm = new ProductModel();
        $stat = [
            'pending' => $rm->where('status','pending')->countAllResults(),
            'aktif'   => $rm->where('status','aktif')->countAllResults(),
            'selesai' => $rm->where('status','selesai')->countAllResults(),
            'produk'  => $pm->countAllResults(),
        ];
        return view('admin/dashboard', ['title'=>'Admin Dashboard','stat'=>$stat]);
    }
}
