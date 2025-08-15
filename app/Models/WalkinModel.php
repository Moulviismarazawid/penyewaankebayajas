<?php
namespace App\Models;
use CodeIgniter\Model;

class WalkinModel extends Model {
    protected $table = 'walkins';
    protected $allowedFields = ['admin_id','customer_name','phone','note','created_at'];
    public $timestamps = false;
}
