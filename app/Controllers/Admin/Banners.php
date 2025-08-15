<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BannerModel;
use CodeIgniter\I18n\Time;

class Banners extends BaseController
{
    public function index()
    {
        $rows = (new BannerModel())->orderBy('sort_order','ASC')->findAll();
        return view('admin/banners', [
            'title'=>'Banner Home',
            'rows'=>$rows
        ]);
    }

    public function store()
    {
        $bm = new BannerModel();
        $data = [
            'title'=>$this->request->getPost('title') ?: null,
            'subtitle'=>$this->request->getPost('subtitle') ?: null,
            'button_text'=>$this->request->getPost('button_text') ?: null,
            'button_link'=>$this->request->getPost('button_link') ?: null,
            'image_url'=>$this->request->getPost('image_url') ?: null,
            'is_active'=>$this->request->getPost('is_active') ? 1 : 0,
            'sort_order'=>(int)$this->request->getPost('sort_order'),
        ];
        $bm->insert($data);
        return redirect()->back()->with('success','Banner ditambahkan.');
    }

    public function update($id)
    {
        $bm = new BannerModel();
        $data = [
            'title'=>$this->request->getPost('title') ?: null,
            'subtitle'=>$this->request->getPost('subtitle') ?: null,
            'button_text'=>$this->request->getPost('button_text') ?: null,
            'button_link'=>$this->request->getPost('button_link') ?: null,
            'image_url'=>$this->request->getPost('image_url') ?: null,
            'is_active'=>$this->request->getPost('is_active') ? 1 : 0,
            'sort_order'=>(int)$this->request->getPost('sort_order'),
            'updated_at'=>Time::now(),
        ];
        $bm->update($id, $data);
        return redirect()->back()->with('success','Banner diperbarui.');
    }

    public function delete($id)
    {
        (new BannerModel())->delete($id);
        return redirect()->back()->with('success','Banner dihapus.');
    }
}
