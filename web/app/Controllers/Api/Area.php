<?php namespace App\Controllers\Api;

class Area extends BaseApiController
{
    protected $modelName = 'App\Models\StoreAreaModel';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }
}