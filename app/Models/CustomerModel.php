<?php
namespace App\Models;
use CodeIgniter\Model;

class CustomerModel extends Model {
    protected $table = 'customers';
    protected $allowedFields = ['user_id','nik','full_name','email','phone','address','created_at','updated_at'];
    protected $useTimestamps = true;
}
