<?php namespace App\Controllers\Api;

class Brand extends BaseApiController
{
    protected $modelName = 'App\Models\BrandModel';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }
}