<?php
namespace App\Models;
use CodeIgniter\Model;

class BannerModel extends Model
{
    protected $table = 'banners';
    protected $allowedFields = [
        'title','subtitle','button_text','button_link','image_url','is_active','sort_order','created_at','updated_at'
    ];
    protected $useTimestamps = true;
}
