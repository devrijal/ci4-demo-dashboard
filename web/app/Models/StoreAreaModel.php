<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreAreaModel extends Model
{
    protected $table = 'store_area';
    protected $primaryKey = 'area_id';
    protected $useAutoIncrement = true;
}