<?php
namespace App\Models;
use CodeIgniter\Model;

class ProductModel extends Model {
    protected $table         = 'products';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'sku','slug','name','category_id','size','color',
        'price_per_day','stock','images','is_active',
        'meta_title','meta_desc','created_at','updated_at'
    ];

    /**
     * Siapkan query list produk dengan filter. Mengembalikan MODEL (bukan builder),
     * supaya bisa dipanggil ->paginate().
     */
    public function searchList($q=null, $cat=null, $size=null, $min=null, $max=null): self
    {
        // clone model agar state query tidak “nyangkut” antar request
        $m = clone $this;

        $m->select('products.*, categories.name as category_name')
          ->join('categories','categories.id = products.category_id','left')
          ->where('products.is_active', 1);

        if ($q)          $m->like('products.name', $q);
        if ($cat)        $m->where('categories.slug', $cat);
        if ($size)       $m->where('products.size', $size);
        if ($min !== '' && $min !== null) $m->where('products.price_per_day >=', (int)$min);
        if ($max !== '' && $max !== null) $m->where('products.price_per_day <=', (int)$max);

        return $m->orderBy('products.created_at','DESC');
    }
}
