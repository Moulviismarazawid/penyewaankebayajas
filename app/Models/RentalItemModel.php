<?php
namespace App\Models;
use CodeIgniter\Model;

class RentalItemModel extends Model {
    protected $table         = 'rental_items';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['rental_id','product_id','qty','daily_price_snapshot'];
}
