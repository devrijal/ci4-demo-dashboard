<?php namespace App\Controllers\Api;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
// use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

use CodeIgniter\RESTful\ResourceController;

class BaseApiController extends ResourceController
{

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

         // $products = model('App\Models\ProductModel');
        // $reports = model('App\Models\ReportProductModel');
        // $store_areas = model('App\Models\StoreAreaModel');
        // $store_accounts = model('App\Models\StoreAccountModel');



        // $data['reports'] = $reports->findAll();
        // $data['areas'] = $store_areas->findAll();
        // $data['accounts'] = $store_accounts->findAll();
        // $data['products'] = $products->findAll();
    }
}
