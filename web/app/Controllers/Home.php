<?php

namespace App\Controllers;

use App\Model\ProductModel;

class Home extends BaseController
{
    public function index()
    {
        // return view('welcome_message');
        return view('home');
    }
}
