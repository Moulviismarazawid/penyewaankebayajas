<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RentalModel;

class Fifo extends BaseController
{
    public function index()
    {
        $queue = (new RentalModel())->where('status','pending')->orderBy('queued_at','ASC')->findAll();
        return view('admin/fifo', ['title'=>'Antrian FIFO','queue'=>$queue]);
    }
}
