<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FineModel;

class Fines extends BaseController
{
    public function store($rentalId)
    {
        $amount = (int)$this->request->getPost('amount');
        $note   = $this->request->getPost('note');
        if ($amount<=0) return redirect()->back()->with('error','Nominal denda tidak valid.');
        (new FineModel())->insert(['rental_id'=>$rentalId,'type'=>'damage','amount'=>$amount,'note'=>$note,'created_at'=>date('Y-m-d H:i:s')]);
        return redirect()->back()->with('success','Denda kerusakan ditambahkan.');
    }
}
