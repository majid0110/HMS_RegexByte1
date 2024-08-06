<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;


use App\Models\InvoiceDetailModel;
use App\Models\ClientModel;
use App\Models\InvoiceModel;
use App\Models\InvoiceDetailsModel;
use App\Models\ItemsInventoryModel;
use App\Models\salesModel;
use App\Models\TablesModel;
use App\Models\ServicesModel;
use App\Models\ConfigModel;
use Mpdf\Mpdf;

class newSalesController extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function New_SalesFrom()
    {
        $data['baseURL'] = base_url();

        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();
        $sales = new salesModel();
        $data['payments'] = $sales->getpayment();
        $data['currencies'] = $sales->getCurrancy();
        $data['services'] = $sales->getServices();
        $data['categories'] = $sales->getCategories();
        $data['salesModel'] = $sales;

        $configModel = new ConfigModel();
        $businessID = session()->get('businessID');
        $config = $configModel->where('businessID', $businessID)->first();
        $data['isExpiry'] = $config ? $config['isExpiry'] : 0;
        $data['isTable'] = $config ? $config['isTable'] : 0;


        if ($data['isTable']) {
            $tableModel = new TablesModel();
            $data['tables'] = $tableModel->where('idBusiness', $businessID)->findAll();
        }

        return view('New_SalesFrom.php', $data);
    }

    public function filterServices()
    {
        $categoryId = $this->request->getPost('categoryId');

        if (empty($categoryId)) {
            $categoryId = null;
        }

        $model = new salesModel();
        $data['services'] = $model->getServicesByCategory($categoryId);
        echo view('New_service_table_partial.php', $data);
    }

}