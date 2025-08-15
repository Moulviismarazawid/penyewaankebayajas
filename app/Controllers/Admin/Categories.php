<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use CodeIgniter\I18n\Time;

class Categories extends BaseController
{
    public function index()
    {
        return view('admin/categories', ['title'=>'Kategori', 'rows'=>(new CategoryModel())->orderBy('name','ASC')->findAll()]);
    }
    public function store()
    {
        $name = trim($this->request->getPost('name')); if (!$name) return redirect()->back()->with('error','Nama wajib.');
        (new CategoryModel())->insert(['slug'=>url_title($name,'-',true),'name'=>$name]);
        return redirect()->back()->with('success','Kategori ditambahkan.');
    }
    public function update($id)
    {
        $name = trim($this->request->getPost('name')); if (!$name) return redirect()->back()->with('error','Nama wajib.');
        (new CategoryModel())->update($id, ['slug'=>url_title($name,'-',true),'name'=>$name,'updated_at'=>Time::now()]);
        return redirect()->back()->with('success','Kategori diperbarui.');
    }
    public function delete($id)
    {
        (new CategoryModel())->delete($id);
        return redirect()->back()->with('success','Kategori dihapus.');
    }
}
