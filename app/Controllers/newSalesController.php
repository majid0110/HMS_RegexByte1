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
    protected $enableService;

    public function __construct()
    {
        $this->db = \Config\Database::connect();

        $configModel = new ConfigModel();
        $businessID = session()->get('businessID');
        $config = $configModel->where('businessID', $businessID)->first();
        $data['isExpiry'] = $config ? $config['isExpiry'] : 0;
        $data['isTable'] = $config ? $config['isTable'] : 0;
        // $data['enableService'] = $config ? $config['enableService'] : 0;

        $this->enableService = $config ? $config['enableService'] : 0;


    }

    public function New_SalesFrom()
    {
        $data['baseURL'] = base_url();

        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $sales = new salesModel();
        $data['payments'] = $sales->getpayment();
        $data['currencies'] = $sales->getCurrancy();

        $configModel = new ConfigModel();
        $businessID = session()->get('businessID');
        $config = $configModel->where('businessID', $businessID)->first();
        $data['isExpiry'] = $config ? $config['isExpiry'] : 0;
        $data['isTable'] = $config ? $config['isTable'] : 0;
        // $data['enableService'] = $config ? $config['enableService'] : 0;

        $enableService = $this->enableService;

        $data['services'] = $sales->getServices2($enableService);
        $data['categories'] = $sales->getCategories();
        $data['salesModel'] = $sales;

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

        $enableService = $this->enableService;

        // $data['services'] = $sales->getServices2($enableService);
        $data['services'] = $model->getServicesByCategory2($categoryId, $enableService);
        echo view('New_service_table_partial.php', $data);
    }

    public function getSummaryInvoices()
    {
        $tableId = $this->request->getPost('tableId');

        $InvoiceModel = new InvoiceModel();
        $invoices = $InvoiceModel->getInvoices($tableId);

        return $this->response->setJSON($invoices);
    }

}