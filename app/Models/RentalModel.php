<?php
namespace App\Models;
use CodeIgniter\Model;

class RentalModel extends Model {
    protected $table = 'rentals';
    protected $allowedFields = ['user_id','code','status','start_date','end_date','due_date','returned_at','queued_at','confirmed_at','canceled_at','notes','wa_payload','created_at','updated_at'];
    protected $useTimestamps = true;
}
