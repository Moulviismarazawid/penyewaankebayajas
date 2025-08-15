<?php
namespace App\Models;
use CodeIgniter\Model;

class CategoryModel extends Model {
    protected $table = 'categories';
    protected $allowedFields = ['slug','name','created_at','updated_at'];
    protected $useTimestamps = true;
}
