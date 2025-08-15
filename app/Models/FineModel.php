<?php
namespace App\Models;
use CodeIgniter\Model;

class FineModel extends Model {
    protected $table         = 'fines';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['rental_id','type','amount','note','created_at'];
    protected $useTimestamps = false; // <— yang benar di CI4
}
