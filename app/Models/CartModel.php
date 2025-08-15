<?php
namespace App\Models;
use CodeIgniter\Model;

class CartModel extends Model {
    protected $table = 'carts';
    protected $allowedFields = ['user_id','payload','created_at'];
    public $timestamps = false;
}
