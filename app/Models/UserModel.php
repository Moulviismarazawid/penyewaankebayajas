<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['role','full_name','email','phone','password_hash','active','last_login','created_at','updated_at'];
    protected $useTimestamps = true;
}
