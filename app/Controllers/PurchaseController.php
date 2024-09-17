<?php

namespace App\Controllers;

use App\Models\TablesModel;
use CodeIgniter\Controller;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;


use App\Models\InvoiceDetailModel;
use App\Models\ClientModel;
use App\Models\InvoiceModel;
use App\Models\InvoiceDetailsModel;
use App\Models\ItemsInventoryModel;
use App\Models\salesModel;
use App\Models\LoginModel;
use App\Models\ServicesModel;
use App\Models\ConfigModel;
use App\Models\BusinessModel;
use App\Models\PurchaseModel;
use App\Models\itemsModel;
use Mpdf\Mpdf;

class PurchaseController extends Controller
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

    //-------------------------------------------------------------------------------------------------------------------------
//                                                 Returning Views
//-------------------------------------------------------------------------------------------------------------------------


    public function Purchase_form()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }

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
        // $data['isTable'] = $config ? $config['isTable'] : 0;
        // $data['enableService'] = $config ? $config['enableService'] : 0;

        $data['isTable'] = 0;
        $enableService = $this->enableService;

        $purchase = new PurchaseModel();
        $data['suppliers'] = $purchase->getSupplierNames();
        $data['items'] = $purchase->getitems();
        // print_r($test);
        // die();
        $data['categories'] = $sales->getCategories();
        $data['PurchaseModel'] = $purchase;

        if ($data['isTable']) {
            $tableModel = new TablesModel();
            $data['tables'] = $tableModel->where('idBusiness', $businessID)->findAll();
        }

        return view('purchase_form.php', $data);
    }

    public function filteritems()
    {
        $categoryId = $this->request->getPost('categoryId');

        if (empty($categoryId)) {
            $categoryId = null;
        }

        $model = new PurchaseModel();

        // $enableService = $this->enableService;

        // $data['services'] = $sales->getServices2($enableService);
        $data['items'] = $model->getItemsByCategory($categoryId);

        echo view('New_item_table_partial.php', $data);
    }


    public function submitPurchaseInvoice()
    {
        $db = \Config\Database::connect();
        try {
            $invoice = new InvoiceModel();
            $invoiceDetailModel = new InvoiceDetailModel();
            $Supplierid = $this->request->getPost('clientId');
            $SupplierName = $this->request->getPost('clientName');
            $exchange = $this->request->getPost('exchange');
            $currency = $this->request->getPost('currency');
            $currencyName = $this->request->getPost('currencyName');
            $paymentMethod = $this->request->getPost('paymentMethodName');
            $paymentMethodName = $this->request->getPost('paymentName');
            $paymentMethodID = $this->request->getPost('paymentMethodId');
            $totalFee = $this->request->getPost('totalFee');
            $services = $this->request->getPost('services');

            $totalTax = $this->request->getPost('totalTax');
            $discountedTotal = $this->request->getPost('discountedTotal');

            $selectedTableId = $this->request->getPost('selectedTableId') ?? null;


            $session = \Config\Services::session();
            $businessID = $session->get('businessID');
            $UserID = $session->get('ID');
            // $db->transBegin();

            if (!is_null($services)) {
                $totalFee = 0;
                foreach ($services as $service) {
                    if (isset($service['fee']) && isset($service['quantity'])) {
                        $fee = (float) $service['fee'];
                        $quantity = (int) $service['quantity'];
                        $totalFee += $fee * $quantity;
                    } else {
                        throw new \Exception('Service fee or quantity is not set.');
                    }
                }
            } else {
                throw new \Exception('Services data is null.');
            }

            $lastInvoiceNumber = $invoice->select('invOrdNum')->orderBy('invOrdNum', 'DESC')->limit(1)->first();
            $newInvoiceNumber = $lastInvoiceNumber ? $lastInvoiceNumber['invOrdNum'] + 1 : 1;
            $invoiceData = [
                'idSupplier' => $Supplierid,
                'Value' => $discountedTotal,
                'actual_Value' => $totalFee,
                // 'idTable' => $selectedTableId,
                'idUser' => $UserID,
                'Status' => 'open',
                'serial_number' => 0,
                'idBusiness' => $businessID,
                'idCancellation' => 0,
                'invOrdNum' => $newInvoiceNumber,
                'idWarehouse' => 0,
                'FIC' => 0,
                'ValueTVSH' => $totalTax,
                'idCurrency' => $currency,
                'rate' => $exchange,
                'paymentMethod' => $paymentMethodID,
                'closeShift' => 0,
                'isSummaryInvoice' => 0,
                'isImport' => 0,
                'idPoint_of_sale' => 0,
                'transporterId' => 0,
                'invoiceType' => 0,
                'isReverseCharge' => 0,
                'Contract' => 0,
                // 'deliveryid' => 0,
                'invoice_period_start_date' => 0,
                'invoice_period_end_date' => 0,
                'filename' => 0,
                'dokumenti' => 0,
                'lloji_fatures_id' => 0,
                'InvoiceNotes' => '',
            ];


            $model = new PurchaseModel();
            $model->insertPurchaseInvoice($invoiceData);
            $idPayment = $invoice->getInsertID();


            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data inserted successfully'

            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error retrieving data: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error retrieving data.', 'message' => $e->getMessage()]);
        }
    }

}