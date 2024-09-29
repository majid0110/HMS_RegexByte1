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
use App\Models\purchaseInvoiceModel;
use App\Models\PurchaseDetailsInvoice;
use App\Models\SupplierModel;
use App\Models\PurPaymentDetailsModel;
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
            $PurchaseDetailModel = new PurchaseDetailsInvoice();
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
            $db->transBegin();

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

            $purchaseModel = new purchaseInvoiceModel();
            $lastInvoiceNumber = $purchaseModel->select('invOrdNum')->orderBy('invOrdNum', 'DESC')->limit(1)->first();
            $newInvoiceNumber = $lastInvoiceNumber ? $lastInvoiceNumber['invOrdNum'] + 1 : 1;
            $invoiceData = [
                'idSupplier' => $Supplierid,
                'Value' => $discountedTotal,
                'actual_Value' => $totalFee,
                'idUser' => $UserID,
                'Status' => 'open',
                'idBusiness' => $businessID,
                'idCancellation' => 0,
                'invOrdNum' => $newInvoiceNumber,
                'idWarehouse' => 1,
                'FIC' => 0,
                'ValueTVSH' => $totalTax,
                'idCurrency' => $currency,
                'rate' => $exchange,
                'paymentMethod' => $paymentMethodID,
                'isImport' => 0,
                'idPoint_of_sale' => 0,
                'transporterId' => 0,
                'invoiceType' => 0,
                'Contract' => 0,
                'invoice_period_start_date' => 0,
                'invoice_period_end_date' => 0,
                'InvoiceNotes' => '',
            ];


            $model = new purchaseInvoiceModel();
            $model->insertPurchaseInvoice($invoiceData);
            $idPayment = $model->getInsertID();

            $discountedTotal = $totalFee;

            foreach ($services as $service) {
                $discount = $service['discount'];
                $quantity = (int) $service['quantity'];
                $fee = (float) $service['fee'];

                $discountedPrice = $fee - ($fee * ($discount / 100));
                $sum = $quantity * $discountedPrice;

                $expiryDate = $service['expiryDate'];
                $serviceData = [
                    'idReceipts' => $idPayment,
                    'Nr' => 0,
                    'idItem' => $service['serviceTypeId'],
                    'Quantity' => $quantity,
                    'Price' => $discountedPrice,
                    'actual_Price' => $fee,
                    'Sum' => $sum,
                    'idBusiness' => $businessID,
                    'IdTax' => 1,
                    'ValueTax' => $service['calculatedTax'],
                    'idMag' => 1,
                    'name' => $service['serviceName'],
                    'idSummaryInvoice' => 0,
                    'Discount' => $discount,
                ];
                $PurchaseDetailModel->insert($serviceData);


            }
            $db->transCommit();

            $businessID = session()->get('businessID');

            $businessModel = new LoginModel('business');
            $business = $businessModel->find($businessID);
            $businessTypeID = $business['businessTypeID'];

            $businessTypeModel = new LoginModel('businesstype');
            $businessType = $businessTypeModel->find($businessTypeID);
            $isHospital = strtolower($businessType['businessType']) === 'hospital';

            $clientModel = new ClientModel();
            $purModel = new SupplierModel();

            $Contact = $purModel->getsupplierContact($businessID, $Supplierid);
            $Gender = 'Male';
            $clientUnique = 11;
            // $clientName1 = $clientModel->getclientName($businessID, $clientId);
            $InvoiceNumber = $model->getPurchaseInvoiceNumber($businessID, $idPayment);
            $operatorName = session()->get('fName');

            $mpdf = new \Mpdf\Mpdf();
            $pdfContent = view('pdf_invoicePurchase', [
                'invoiceData' => $invoiceData,
                'services' => $services,
                'paymentDetailsData' => 'Not Set',
                'clientName' => $SupplierName,
                'currencyName' => $currencyName,
                'paymentMethodName' => $paymentMethodName,
                'Contact' => $Contact,
                'clientUnique' => $clientUnique,
                'Gender' => $Gender,
                'InvoiceNumber' => $InvoiceNumber,
                'operatorName' => $operatorName,
                'discountedTotal' => $discountedTotal,
                'isHospital' => $isHospital
            ]);
            $mpdf->WriteHTML($pdfContent);
            $pdfBinary = $mpdf->Output('', 'S');
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data inserted successfully',
                'pdfContent' => base64_encode($pdfBinary),
            ]);

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error retrieving data: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error retrieving data.', 'message' => $e->getMessage()]);
        }
    }

    public function submitPurchaseServices()
    {
        $db = \Config\Database::connect();
        try {
            $invoice = new InvoiceModel();
            $PurchaseDetailModel = new PurchaseDetailsInvoice();
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
            $selectedTableId = $this->request->getPost('selectedTableId') ?? null;

            $totalTax = $this->request->getPost('totalTax');
            $discountedTotal = $this->request->getPost('discountedTotal');

            $session = \Config\Services::session();
            $businessID = $session->get('businessID');
            $UserID = $session->get('ID');
            $db->transBegin();

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
                'idUser' => $UserID,
                'Status' => 'open',
                'idBusiness' => $businessID,
                'idCancellation' => 0,
                'invOrdNum' => $newInvoiceNumber,
                'idWarehouse' => 1,
                'FIC' => 0,
                'ValueTVSH' => $totalTax,
                'idCurrency' => $currency,
                'rate' => $exchange,
                'paymentMethod' => $paymentMethodID,
                'isImport' => 0,
                'idPoint_of_sale' => 0,
                'transporterId' => 0,
                'invoiceType' => 0,
                'Contract' => 0,
                'invoice_period_start_date' => 0,
                'invoice_period_end_date' => 0,

                'InvoiceNotes' => '',
            ];

            $model = new purchaseInvoiceModel();
            $model->insertPurchaseInvoice($invoiceData);
            $idPayment = $model->getInsertID();

            $discountedTotal = $totalFee;

            foreach ($services as $service) {
                $discount = $service['discount'];
                $quantity = (int) $service['quantity'];
                $fee = (float) $service['fee'];

                $discountedPrice = $fee - ($fee * ($discount / 100));
                $sum = $quantity * $discountedPrice;

                $expiryDate = $service['expiryDate'];
                $serviceData = [
                    'idReceipts' => $idPayment,
                    'Nr' => 0,
                    'idItem' => $service['serviceTypeId'],
                    'Quantity' => $quantity,
                    'Price' => $discountedPrice,
                    'actual_Price' => $fee,
                    'Sum' => $sum,
                    'idBusiness' => $businessID,
                    'IdTax' => 1,
                    'ValueTax' => $service['calculatedTax'],
                    'idMag' => 1,
                    'name' => $service['serviceName'],
                    'idSummaryInvoice' => 0,
                    'Discount' => $discount,
                ];
                $PurchaseDetailModel->insert($serviceData);

                $idItem = $service['serviceTypeId'];
                $Model = new PurchaseModel();
                $Model->subtractFromInventory([$idItem], $quantity, $businessID, $expiryDate);
            }

            $paymentDetailsModel = new PurPaymentDetailsModel();
            $paymentDetailsData = [
                'value' => $totalFee,
                'idUser' => $UserID,
                'idAnullim' => 0,
                'method' => $paymentMethod,
                'idPaymentMethod' => $paymentMethodID,
                'exchange' => $exchange,
                'nr_serial' => 0,
            ];
            $paymentDetailsModel->insert($paymentDetailsData);
            $idReceipt = $paymentDetailsModel->getInsertID();

            $InvoicePayment = [
                'idReceipt' => $idPayment,
                'idPayment' => $idReceipt,

            ];
            $paymentDetailsModel->insertPurInvoicePayment($InvoicePayment);

            $db->transCommit();

            $businessID = session()->get('businessID');

            $businessModel = new LoginModel('business');
            $business = $businessModel->find($businessID);
            $businessTypeID = $business['businessTypeID'];

            $businessTypeModel = new LoginModel('businesstype');
            $businessType = $businessTypeModel->find($businessTypeID);
            $isHospital = strtolower($businessType['businessType']) === 'hospital';

            $clientModel = new ClientModel();
            $purModel = new SupplierModel();

            $Contact = $purModel->getsupplierContact($businessID, $Supplierid);
            $Gender = 'Male';
            $clientUnique = 11;
            // $clientName1 = $clientModel->getclientName($businessID, $clientId);
            $InvoiceNumber = $model->getPurchaseInvoiceNumber($businessID, $idPayment);
            $operatorName = session()->get('fName');

            $mpdf = new \Mpdf\Mpdf();
            $pdfContent = view('pdf_invoicePurchase', [
                'invoiceData' => $invoiceData,
                'services' => $services,
                'paymentDetailsData' => 'Not Set',
                'clientName' => $SupplierName,
                'currencyName' => $currencyName,
                'paymentMethodName' => $paymentMethodName,
                'Contact' => $Contact,
                'clientUnique' => $clientUnique,
                'Gender' => $Gender,
                'InvoiceNumber' => $InvoiceNumber,
                'operatorName' => $operatorName,
                'discountedTotal' => $discountedTotal,
                'isHospital' => $isHospital
            ]);
            $mpdf->WriteHTML($pdfContent);
            $pdfBinary = $mpdf->Output('', 'S');
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data inserted successfully',
                'pdfContent' => base64_encode($pdfBinary),
            ]);

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error retrieving data: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error retrieving data.', 'message' => $e->getMessage()]);
        }
    }

}