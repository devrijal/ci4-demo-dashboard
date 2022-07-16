<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreModel extends Model
{
    protected $table = 'store';
    protected $primaryKey = 'store_id';
    protected $useAutoIncrement = true;
}