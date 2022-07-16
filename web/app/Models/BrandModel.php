<?php

namespace App\Models;

use CodeIgniter\Model;

class BrandModel extends Model
{
    protected $table = 'product_brand';
    protected $primaryKey = 'brand_id';
    protected $useAutoIncrement = true;
}