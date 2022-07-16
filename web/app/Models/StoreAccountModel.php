<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreAccountModel extends Model
{
    protected $table = 'store_account';
    protected $primaryKey = 'account_id';
    protected $useAutoIncrement = true;
}