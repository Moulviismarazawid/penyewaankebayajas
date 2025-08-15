<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WalkinModel;

class Walkins extends BaseController
{
    public function index()
    {
        $rows = (new WalkinModel())->orderBy('created_at','DESC')->findAll();
        return view('admin/walkins', ['title'=>'Walk-in','rows'=>$rows]);
    }
    public function store()
    {
        (new WalkinModel())->insert([
            'admin_id'=>session('user_id'),
            'customer_name'=>$this->request->getPost('customer_name'),
            'phone'=>$this->request->getPost('phone'),
            'note'=>$this->request->getPost('note'),
            'created_at'=>date('Y-m-d H:i:s')
        ]);
        return redirect()->back()->with('success','Walk-in dicatat.');
    }
}
