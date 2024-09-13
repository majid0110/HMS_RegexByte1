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
use App\Models\InventoryModel;
use App\Models\itemsModel;
use Mpdf\Mpdf;

class SalesController extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    //-------------------------------------------------------------------------------------------------------------------------
//                                                 Returning Views
//-------------------------------------------------------------------------------------------------------------------------

    public function sales_form()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
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

        return view('sales_form.php', $data);
    }

    public function correctInvoice($idReceipts)
    {
        $model = new salesModel();
        $data['invoice'] = $model->getSalesDetails($idReceipts)[0];
        return view('correct_invoice', $data);
    }

    public function getAllServices()
    {
        $model = new salesModel();
        $services = $model->getServices();

        return $this->response->setJSON(['services' => $services]);
    }

    public function PayInvoice()
    {
        $sales = new SalesModel();
        $data['payments'] = $sales->getpayment();
        $data['currencies'] = $sales->getCurrancy();

        // $invOrdNum = $this->request->getVar('invOrdNum');
        $invOrdNum = 3;

        $invoice = $sales->getInvoiceByOrdNum($invOrdNum);

        if ($invoice) {
            $data['valueToPay'] = $invoice->remainingValue;
            $data['client'] = $invoice->idClient;
            $data['idReceipts'] = $invoice->idReceipts;

            // if ($invoice->remainingValue <= 0) {
            //     $this->db->table('invoices')
            //         ->where('idReceipts', $invoice->idReceipts)
            //         ->update(['Status' => 'closed']);
            // }
        } else {
            $data['valueToPay'] = null;
            $data['idReceipts'] = null;
            log_message('error', "Invoice not found for invOrdNum: {$invOrdNum}");
        }
        return view('PayInovice.php', $data);
    }

    public function viewServiceDetails($idReceipts)
    {
        $model = new salesModel();
        $clientModel = new ClientModel();

        $data['payments'] = $model->getpayment();
        $data['currencies'] = $model->getCurrancy();

        $data['ServiceDetails'] = $model->getSalesDetails($idReceipts);
        $data['PaymentDetails'] = $model->getPaymentDetails($idReceipts);
        $data['clients'] = $clientModel->findAll();
        $data['services'] = $model->getServices();

        $invoice = $model->getInvoiceByOrdNum($idReceipts);

        if ($invoice) {
            $data['valueToPay'] = $invoice->remainingValue;
            $data['client'] = $invoice->idClient;
            $data['idReceipts'] = $invoice->idReceipts;
        } else {
            $data['valueToPay'] = null;
            $data['idReceipts'] = null;
        }

        $data['referenceInvoices'] = $model->getReferenceInvoices($idReceipts);

        return view('Sale_details', $data);
    }
    // public function Sales_table()
    // {
    //     $session = session();
    //     if (!$session->get('ID')) {
    //         return redirect()->to(base_url("/session_expired"));
    //     }
    //     $Model = new salesModel();
    //     $data['Sales'] = $Model->getSales();
    //     return view('Sales_table.php', $data);
    // }

    public function Sales_table()
    {
        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $sales = new SalesModel();
        $data['payments'] = $sales->getpayment();
        $data['Invoice'] = $sales->getInvoice();


        $Model = new ServicesModel();
        $Model = new SalesModel();
        $search = $this->request->getPost('search');
        $paymentInput = $this->request->getPost('paymentInput');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');
        $invoice = $this->request->getPost('invoice');


        $data['totalServiceFee'] = $Model->gettotalServiceFee($search, $invoice, $clientName, $paymentInput, $fromDate, $toDate);
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;
        $offset = ($currentPage - 1) * $perPage;
        $data['Sales'] = $Model->getSalesReport($search, $invoice, $paymentInput, $clientName, $fromDate, $toDate, $perPage, $offset);
        $totalSales = count($Model->getSalesReport($search, $invoice, $paymentInput, $clientName, $fromDate, $toDate));
        $pager = service('pager');
        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $totalSales);
        $data['pager'] = $pagerLinks;

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('Sale_Partial_table', $data);
                return $this->response->setJSON([
                    'success' => true,
                    'tableContent' => $tableContent,
                    'pager' => $pagerLinks,
                    'totalServiceFee' => $data['totalServiceFee']
                ]);
            } catch (\Exception $e) {
                log_message('error', 'Error in services_report method: ' . $e->getMessage());
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            return view('Sales_table', $data);
        }
    }

    // public function Sales_table()
    // {
    //     $clientModel = new ClientModel();
    //     $data['client_names'] = $clientModel->getClientNames();

    //     $sales = new SalesModel();
    //     // $data['payments'] = $sales->getpayment();
    //     $data['Invoice'] = $sales->getInvoice();

    //     $Model = new ServicesModel();
    //     $Model = new SalesModel();
    //     // $search = $this->request->getPost('searchValue');
    //     $search = trim($this->request->getPost('search'));

    //     $paymentInput = $this->request->getPost('paymentInput');
    //     $clientName = $this->request->getPost('clientName');
    //     $fromDate = $this->request->getPost('fromDate');
    //     $toDate = $this->request->getPost('toDate');


    //     $data['totalServiceFee'] = $Model->gettotalServiceTableFee($search, $clientName, $paymentInput, $fromDate, $toDate);
    //     $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
    //     $perPage = 2;
    //     $offset = ($currentPage - 1) * $perPage;
    //     $data['Sales'] = $Model->getSalesReport($search, $paymentInput, $clientName, $fromDate, $toDate, $perPage, $offset);
    //     $totalSales = count($Model->getSalesReport($search, $paymentInput, $clientName, $fromDate, $toDate));
    //     $pager = service('pager');
    //     $pagerLinks = $pager->makeLinks($currentPage, $perPage, $totalSales);
    //     $data['pager'] = $pagerLinks;

    //     if ($this->request->isAJAX()) {
    //         try {
    //             $tableContent = view('Sale_Partial_table', $data);
    //             return $this->response->setJSON([
    //                 'success' => true,
    //                 'tableContent' => $tableContent,
    //                 'pager' => $pagerLinks,
    //                 'totalServiceFee' => $data['totalServiceFee']
    //             ]);
    //         } catch (\Exception $e) {
    //             log_message('error', 'Error in services_report method: ' . $e->getMessage());
    //             return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
    //         }
    //     } else {
    //         return view('Sales_table', $data);
    //     }
    // }


    //-------------------------------------------------------------------------------------------------------------------------
//                                                 Main Logic
//-------------------------------------------------------------------------------------------------------------------------
    public function saveClientProfile()
    {
        $request = \Config\Services::request();
        $session = \Config\Services::session();

        $model = new ClientModel();
        $businessID = $session->get('businessID');
        $mainClient = $request->getPost('mclient') ? 1 : 0;

        if ($mainClient == 1) {
            $model->resetMainClients();
        }

        $clientUniqueId = $this->generateUniqueClientId($businessID);

        $data = [
            'client' => $request->getPost('cName'),
            'contact' => $request->getPost('cphone'),
            'email' => $request->getPost('cemail'),
            'CNIC' => $request->getPost('CNIC'),
            'status' => $request->getPost('cstatus'),
            'Def' => $request->getPost('cdef'),
            'idBusiness' => $businessID,
            'identification_type' => $request->getPost('idType'),
            'limitExpense' => $request->getPost('expense'),
            'discount' => $request->getPost('discount'),
            'mainClient' => $mainClient,
            'address' => $request->getPost('address'),
            'city' => $request->getPost('city'),
            'state' => $request->getPost('state'),
            'gender' => $request->getPost('gender'),
            'age' => $request->getPost('age'),
            'code' => $request->getPost('code'),
            'clientUniqueId' => $clientUniqueId,
        ];

        $model->saveClient($data);

        session()->setFlashdata('success', 'Client Added..!!');

        return redirect()->to(base_url("/sales_form"));
    }

    private function generateUniqueClientId($businessID)
    {
        $model = new ClientModel();
        $lastClientId = (int) $this->getLastClientId($businessID);
        $nextClientId = sprintf('%04d', $lastClientId + 1);

        return $nextClientId;
    }

    private function getLastClientId($businessID)
    {
        $model = new ClientModel();

        $lastClient = $model
            ->where('idBusiness', $businessID)
            ->orderBy('clientUniqueId', 'DESC')
            ->first();

        return $lastClient ? (int) $lastClient['clientUniqueId'] : 0;
    }


    public function submitServices()
    {
        $db = \Config\Database::connect();
        try {
            $invoice = new InvoiceModel();
            $invoiceDetailModel = new InvoiceDetailModel();
            $clientId = $this->request->getPost('clientId');
            $clientName = $this->request->getPost('clientName');
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
                'idClient' => $clientId,
                'Value' => $discountedTotal,
                'actual_Value' => $totalFee,
                'idTable' => $selectedTableId,
                'idUser' => $UserID,
                'Status' => 'closed',
                'serial_number' => 0,
                'idBusiness' => $businessID,
                'idCancellation' => 0,
                'invOrdNum' => $newInvoiceNumber,
                'selfissue' => 0,
                'FIC' => 0,
                'ValueTVSH' => $totalTax,
                'idCurrency' => $currency,
                'rate' => $exchange,
                'paymentMethod' => $paymentMethodID,
                'closeShift' => 0,
                'isSummaryInvoice' => 0,
                'seial_nr' => 0,
                'idPoint_of_sale' => 0,
                'imported_invoice_number' => 0,
                'isExport' => 0,
                'isReverseCharge' => 0,
                'Contract' => 0,
                'deliveryid' => 0,
                'invoice_period_start_date' => 0,
                'invoice_period_end_date' => 0,
                'filename' => 0,
                'dokumenti' => 0,
                'lloji_fatures_id' => 0,
                'InvoiceNotes' => '',
            ];
            $invoice->insertInvoice($invoiceData);
            $idPayment = $invoice->getInsertID();

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
                    'idArtMenu' => $service['serviceTypeId'],
                    'Quantity' => $quantity,
                    'Price' => $discountedPrice,
                    'actual_Price' => $fee,
                    'Sum' => $sum,
                    'idBusiness' => $businessID,
                    'IdTax' => $service['taxRate'],
                    // 'IdTax' => 1,
                    'ValueTax' => $service['calculatedTax'],
                    'idMag' => 1,
                    'name' => $service['serviceName'],
                    'idSummaryInvoice' => 0,
                    'Discount' => $discount,
                ];
                $invoiceDetailModel->insert($serviceData);

                $idArtMenu = $service['serviceTypeId'];
                $Model = new ItemsInventoryModel();
                $Model->subtractFromInventory($idArtMenu, $quantity, $businessID, $expiryDate);
            }

            $paymentDetailsModel = new InvoiceDetailsModel();
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
            $paymentDetailsModel->insertInvoicePayment($InvoicePayment);
            // $paymentDetailsModel->insertInvoicePayment([
            //     'idReceipt' => $idPayment,
            //     'idPayment' => $idReceipt,
            // ]);

            if ($selectedTableId !== null) {
                $data = [
                    'idUserActive' => $UserID,
                    'booking_status' => 1
                ];

                $TModel = new TablesModel();
                $TModel->updateStatus($selectedTableId, $data);
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
            $Age = $clientModel->getclientAge($businessID, $clientId);
            $Gender = $clientModel->getclientGender($businessID, $clientId);
            $clientUnique = $clientModel->getclientUnique($businessID, $clientId);
            $clientName1 = $clientModel->getclientName($businessID, $clientId);
            $InvoiceNumber = $invoice->getinvoiceNumber($businessID, $idPayment);
            $operatorName = session()->get('fName');

            $mpdf = new \Mpdf\Mpdf();
            $pdfContent = view('pdf_invoice', [
                'invoiceData' => $invoiceData,
                'services' => $services,
                'paymentDetailsData' => $paymentDetailsData,
                'clientName' => $clientName1,
                'currencyName' => $currencyName,
                'paymentMethodName' => $paymentMethodName,
                'Age' => $Age,
                'clientUnique' => $clientUnique,
                'Gender' => $Gender,
                'totaltax' => $totalTax,
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

    public function Payment()
    {
        $session = \Config\Services::session();
        $UserID = $session->get('ID');

        $exchange = $this->request->getPost('exchange');
        $value = $this->request->getPost('Value');
        $currencyName = $this->request->getPost('Currency');
        $paymentMethod = $this->request->getPost('Payment');
        $client = $this->request->getPost('client');
        $idReceipts = $this->request->getPost('idReceipts');
        // $paymentMethodID = $this->request->getPost('paymentMethodId');

        $paymentDetailsModel = new InvoiceDetailsModel();
        $paymentDetailsData = [
            'value' => $value,
            'idUser' => $UserID,
            'idAnullim' => 0,
            'method' => $currencyName,
            'idPaymentMethod' => $paymentMethod,
            'exchange' => $exchange,
            'nr_serial' => 0,
        ];
        $paymentDetailsModel->insert($paymentDetailsData);
        $idPayment = $paymentDetailsModel->getInsertID();

        $InvoicePayment = [
            'idReceipt' => $idReceipts,
            'idPayment' => $idPayment,

        ];
        $paymentDetailsModel->insertInvoicePayment($InvoicePayment);

        $invoiceModel = new InvoiceModel();
        $invoice = $invoiceModel->getInvoiceById($idReceipts);

        if ($invoice) {
            $totalPaid = $invoice->totalPaid + $value;
            if ($totalPaid >= $invoice->Value) {
                $invoiceModel->updateInvoiceStatus($idReceipts, 'closed');
                echo ('status changed');
            }
        }

        return redirect()->to(base_url("/Sales_table"));
        // return redirect()->back();

    }

    public function submitInvoice()
    {
        $db = \Config\Database::connect();
        try {
            $invoice = new InvoiceModel();
            $invoiceDetailModel = new InvoiceDetailModel();
            $clientId = $this->request->getPost('clientId');
            $clientName = $this->request->getPost('clientName');
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

            $lastInvoiceNumber = $invoice->select('invOrdNum')->orderBy('invOrdNum', 'DESC')->limit(1)->first();
            $newInvoiceNumber = $lastInvoiceNumber ? $lastInvoiceNumber['invOrdNum'] + 1 : 1;
            $invoiceData = [
                'idClient' => $clientId,
                'Value' => $discountedTotal,
                'actual_Value' => $totalFee,
                'idTable' => $selectedTableId,
                'idUser' => $UserID,
                'Status' => 'open',
                'serial_number' => 0,
                'idBusiness' => $businessID,
                'idCancellation' => 0,
                'invOrdNum' => $newInvoiceNumber,
                'selfissue' => 0,
                'FIC' => 0,
                'ValueTVSH' => $totalTax,
                'idCurrency' => $currency,
                'rate' => $exchange,
                'paymentMethod' => $paymentMethodID,
                'closeShift' => 0,
                'isSummaryInvoice' => 0,
                'seial_nr' => 0,
                'idPoint_of_sale' => 0,
                'imported_invoice_number' => 0,
                'isExport' => 0,
                'isReverseCharge' => 0,
                'Contract' => 0,
                'deliveryid' => 0,
                'invoice_period_start_date' => 0,
                'invoice_period_end_date' => 0,
                'filename' => 0,
                'dokumenti' => 0,
                'lloji_fatures_id' => 0,
                'InvoiceNotes' => '',
            ];
            $invoice->insertInvoice($invoiceData);
            $idPayment = $invoice->getInsertID();

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
                    'idArtMenu' => $service['serviceTypeId'],
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
                $invoiceDetailModel->insert($serviceData);

                $idArtMenu = $service['serviceTypeId'];
                $Model = new ItemsInventoryModel();
                $Model->subtractFromInventory($idArtMenu, $quantity, $businessID, $expiryDate);
            }

            if ($selectedTableId !== null) {
                $data = [
                    'idUserActive' => $UserID,
                    'booking_status' => 1
                ];

                $TModel = new TablesModel();
                $TModel->updateStatus($selectedTableId, $data);
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
            $Age = $clientModel->getclientAge($businessID, $clientId);
            $Gender = $clientModel->getclientGender($businessID, $clientId);
            $clientUnique = $clientModel->getclientUnique($businessID, $clientId);
            $clientName1 = $clientModel->getclientName($businessID, $clientId);
            $InvoiceNumber = $invoice->getinvoiceNumber($businessID, $idPayment);
            $operatorName = session()->get('fName');

            $mpdf = new \Mpdf\Mpdf();
            $pdfContent = view('pdf_invoice', [
                'invoiceData' => $invoiceData,
                'services' => $services,
                'paymentDetailsData' => 'Not Set',
                'clientName' => $clientName1,
                'currencyName' => $currencyName,
                'paymentMethodName' => $paymentMethodName,
                'Age' => $Age,
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
    public function filterServices()
    {
        $categoryId = $this->request->getPost('categoryId');

        if (empty($categoryId)) {
            $categoryId = null;
        }

        $model = new salesModel();
        $data['services'] = $model->getServicesByCategory($categoryId);
        echo view('service_table_partial', $data);
    }

    public function deleteSales($idReceipts)
    {

        try {
            $Model = new salesModel();
            $Model->deleteSales($idReceipts);
            session()->setFlashdata('success', 'Sales deleted...!!');

            return redirect()->to(base_url("/Sales_table"));

        } catch (\Exception $e) {
            log_message('error', 'Error retrieving data: ' . $e->getMessage());
            session()->setFlashdata('error', 'DataBase Error: ' . $e->getMessage());
            return redirect()->to(base_url("/Sales_table"));
        }
    }


    public function downloadPDF($idReceipts)
    {
        $model = new salesModel();
        $data['ServiceDetails'] = $model->getSalesDetails1($idReceipts);

        $qrContent = base_url('viewServiceDetails/' . $idReceipts);
        $qrCode = new QrCode($qrContent);
        $qrCode->setSize(150);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $qrDataUri = $result->getDataUri();
        $data['qrDataUri'] = $qrDataUri;

        $html = view('invoice_pdf', $data);

        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 14,
            'margin_right' => 11,
            'margin_top' => 11,
            'margin_bottom' => 8,
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output('invoice_' . $idReceipts . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }
    public function deleteService($idReceipts)
    {
        $model = new salesModel();

        $result = $model->updateServiceToZero($idReceipts);

        if ($result) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'Error message']);
        }
    }


    // public function cancelInvoice($idReceipts)
    // {
    //     $model = new InvoiceModel();
    //     $salesModel = new salesModel();
    //     $session = \Config\Services::session();
    //     $currentUserId = $session->get('ID');

    //     $references = $salesModel->getReferenceInvoices($idReceipts);
    //     foreach ($references as $reference) {
    //         $referencedInvoice = $model->getInvoiceById($reference->idReceipt ?? $reference['idReceipt']);
    //         if ($referencedInvoice) {
    //             $notes = is_object($referencedInvoice) ? $referencedInvoice->Notes : $referencedInvoice['Notes'];
    //             if ($notes == 'Cancelled') {
    //                 session()->setFlashdata('error', 'This invoice has already been cancelled...!!');
    //                 return redirect()->to(base_url('/viewServiceDetails/' . $idReceipts));
    //             }
    //         }
    //     }

    //     $invoice = $model->getInvoiceById($idReceipts);
    //     $invoiceDetails = $model->getInvoiceDetailsByReceiptId($idReceipts);
    //     $invoicePayments = $model->getInvoicePaymentsByReceiptId($idReceipts);

    //     if ($invoice) {
    //         $invoiceArray = (array) $invoice;

    //         $newInvoiceData = $invoiceArray;
    //         unset($newInvoiceData['idReceipts']);

    //         $newInvoiceData['Value'] = -$invoiceArray['Value'];
    //         $newInvoiceData['Notes'] = 'Cancelled';
    //         $newInvoiceData['timeStamp'] = date('Y-m-d H:i:s');
    //         $newInvoiceData['invOrdNum'] = $this->getNextInvOrdNum();
    //         $newInvoiceData['idUser'] = $currentUserId;

    //         $newInvoiceId = $model->insertInvoice1($newInvoiceData);

    //         if ($newInvoiceId) {
    //             $referenceData = [
    //                 'idReceipt' => $newInvoiceId,
    //                 'receiptReference' => $idReceipts
    //             ];

    //             $model->insertInvoiceReference($referenceData);

    //             foreach ($invoiceDetails as $detail) {
    //                 $detailArray = (array) $detail;
    //                 unset($detailArray['idInvoiceDetail']);

    //                 $detailArray['idReceipts'] = $newInvoiceId;
    //                 $detailArray['Quantity'] = -$detailArray['Quantity'];
    //                 $detailArray['Sum'] = $detailArray['Quantity'] * $detailArray['Price'];

    //                 $model->insertInvoiceDetail($detailArray);
    //             }

    //             foreach ($invoicePayments as $payment) {
    //                 $paymentArray = (array) $payment;

    //                 $paymentDetails = $model->getPaymentDetailsById($paymentArray['idPayment']);
    //                 foreach ($paymentDetails as $paymentDetail) {
    //                     $paymentDetailArray = (array) $paymentDetail;
    //                     unset($paymentDetailArray['idPayment']);

    //                     $paymentDetailArray['value'] = -$paymentDetailArray['value'];
    //                     $paymentDetailArray['timestamp'] = date('Y-m-d H:i:s');

    //                     $newPaymentId = $model->insertPaymentDetail($paymentDetailArray);

    //                     $model->insertInvoicePayment([
    //                         'idReceipt' => $newInvoiceId,
    //                         'idPayment' => $newPaymentId
    //                     ]);
    //                 }
    //             }

    //             session()->setFlashdata('success', 'Invoice cancelled...!!');
    //             return redirect()->to(base_url('/viewServiceDetails/' . $newInvoiceId));
    //         }
    //     }

    //     return redirect()->back()->with('error', 'Failed to cancel the invoice.');
    // }

    public function cancelInvoice($idReceipts)
    {
        $model = new InvoiceModel();
        $salesModel = new salesModel();
        $inventoryModel = new InventoryModel();
        $itemsWarehouseModel = new itemsModel();
        $session = \Config\Services::session();
        $currentUserId = $session->get('ID');

        $references = $salesModel->getReferenceInvoices($idReceipts);
        foreach ($references as $reference) {
            $referencedInvoice = $model->getInvoiceById($reference->idReceipt ?? $reference['idReceipt']);
            if ($referencedInvoice) {
                $notes = is_object($referencedInvoice) ? $referencedInvoice->Notes : $referencedInvoice['Notes'];
                if ($notes == 'Cancelled') {
                    session()->setFlashdata('error', 'This invoice has already been cancelled...!!');
                    return redirect()->to(base_url('/viewServiceDetails/' . $idReceipts));
                }
            }
        }

        $invoice = $model->getInvoiceById($idReceipts);
        $invoiceDetails = $model->getInvoiceDetailsByReceiptId($idReceipts);
        $invoicePayments = $model->getInvoicePaymentsByReceiptId($idReceipts);

        if ($invoice) {
            $invoiceArray = (array) $invoice;

            $newInvoiceData = $invoiceArray;
            unset($newInvoiceData['idReceipts']);

            $newInvoiceData['Value'] = -$invoiceArray['Value'];
            $newInvoiceData['Notes'] = 'Cancelled';
            $newInvoiceData['timeStamp'] = date('Y-m-d H:i:s');
            $newInvoiceData['invOrdNum'] = $this->getNextInvOrdNum();
            $newInvoiceData['idUser'] = $currentUserId;

            $newInvoiceId = $model->insertInvoice1($newInvoiceData);

            if ($newInvoiceId) {
                $referenceData = [
                    'idReceipt' => $newInvoiceId,
                    'receiptReference' => $idReceipts
                ];

                $model->insertInvoiceReference($referenceData);

                foreach ($invoiceDetails as $detail) {
                    $detailArray = (array) $detail;
                    unset($detailArray['idInvoiceDetail']);

                    $detailArray['idReceipts'] = $newInvoiceId;
                    $detailArray['Quantity'] = -$detailArray['Quantity'];
                    $detailArray['Sum'] = $detailArray['Quantity'] * $detailArray['Price'];

                    $model->insertInvoiceDetail($detailArray);

                    $item = $itemsWarehouseModel->getItemByName($detailArray['name']);
                    if ($item) {
                        $idItem = $item['idItem'];

                        $inventory = $inventoryModel->getInventoryByItem($idItem);
                        if ($inventory) {
                            $newInventory = $inventory['inventory'] + abs($detailArray['Quantity']);
                            $inventoryModel->updateInventory($idItem, $newInventory);
                        }
                    }
                }

                foreach ($invoicePayments as $payment) {
                    $paymentArray = (array) $payment;

                    $paymentDetails = $model->getPaymentDetailsById($paymentArray['idPayment']);
                    foreach ($paymentDetails as $paymentDetail) {
                        $paymentDetailArray = (array) $paymentDetail;
                        unset($paymentDetailArray['idPayment']);

                        $paymentDetailArray['value'] = -$paymentDetailArray['value'];
                        $paymentDetailArray['timestamp'] = date('Y-m-d H:i:s');

                        $newPaymentId = $model->insertPaymentDetail($paymentDetailArray);

                        $model->insertInvoicePayment([
                            'idReceipt' => $newInvoiceId,
                            'idPayment' => $newPaymentId
                        ]);
                    }
                }

                session()->setFlashdata('success', 'Invoice cancelled...!!');
                return redirect()->to(base_url('/viewServiceDetails/' . $newInvoiceId));
            }
        }

        return redirect()->back()->with('error', 'Failed to cancel the invoice.');
    }

    public function UpdateInvoice()
    {
        $request = service('request');
        $session = \Config\Services::session();
        $currentUserId = $session->get('ID');

        $invoiceId = $request->getPost('invoiceId');
        $clientId = $request->getPost('client');
        $clientEmail = $request->getPost('email');
        $clientContact = $request->getPost('contact');
        $currencyId = $request->getPost('currency');
        $invoiceDate = $request->getPost('invoiceDate');
        $paymentMethodId = $request->getPost('paymentMethod');
        $notes = $request->getPost('notes');
        $serviceDetails = $request->getPost('ServiceDetails');
        $totalValue = $request->getPost('totalValue');

        $model = new InvoiceModel();

        $originalInvoice = $model->getInvoiceById($invoiceId);
        $originalInvoiceDetails = $model->getInvoiceDetailsByReceiptId($invoiceId);
        $originalInvoicePayments = $model->getInvoicePaymentsByReceiptId($invoiceId);

        if ($originalInvoice) {
            $this->cancelInvoice($invoiceId);

            $newInvoiceData = (array) $originalInvoice;
            unset($newInvoiceData['idReceipts']);

            $newInvoiceData['idClient'] = $clientId;
            $newInvoiceData['idCurrency'] = $currencyId;
            $newInvoiceData['Date'] = $invoiceDate;
            $newInvoiceData['Value'] = $totalValue;
            $newInvoiceData['paymentMethod'] = $paymentMethodId;
            $newInvoiceData['Notes'] = 'Corrective';
            $newInvoiceData['InvoiceNotes'] = $notes;
            $newInvoiceData['idUser'] = $currentUserId;
            $newInvoiceData['timeStamp'] = date('Y-m-d H:i:s');
            $newInvoiceData['invOrdNum'] = $this->getNextInvOrdNum();


            $newInvoiceId = $model->insertInvoice($newInvoiceData);

            if ($newInvoiceId) {
                $referenceData = [
                    'idReceipt' => $newInvoiceId,
                    'receiptReference' => $invoiceId
                ];
                $model->insertInvoiceReference($referenceData);

                foreach ($serviceDetails as $index => $detail) {
                    $newDetail = [];
                    $isNewRow = true;

                    foreach ($originalInvoiceDetails as $originalDetail) {
                        if ($originalDetail->idArtMenu == $detail['idArtMenu']) {
                            $newDetail = (array) $originalDetail;
                            $isNewRow = false;
                            break;
                        }
                    }

                    if ($isNewRow) {
                        $newDetail = [
                            'idReceipts' => $newInvoiceId,
                            'Nr' => $index + 1,
                            'idArtMenu' => $detail['ServiceTypeName'],
                            'idBusiness' => $originalInvoice->idBusiness,
                            'IdTax' => 0,
                            'ValueTax' => 0,
                            'idMag' => 0,
                            'name' => $this->getServiceNameById($detail['ServiceTypeName']),
                            'idSummaryInvoice' => 0,
                            'Discount' => 0,
                        ];


                    } else {
                        unset($newDetail['idInvoiceDetail']);
                        $newDetail['idReceipts'] = $newInvoiceId;
                    }

                    $newDetail['Quantity'] = $detail['Quantity'];
                    $newDetail['Price'] = $detail['Price'];
                    $newDetail['Sum'] = $detail['Quantity'] * $detail['Price'];

                    $model->insertInvoiceDetail($newDetail);
                }

                foreach ($originalInvoicePayments as $payment) {
                    $paymentArray = (array) $payment;
                    unset($paymentArray['idInvPay']);

                    $paymentDetails = $model->getPaymentDetailsById($paymentArray['idPayment']);
                    foreach ($paymentDetails as $paymentDetail) {
                        $paymentDetailArray = (array) $paymentDetail;
                        unset($paymentDetailArray['idPayment']);

                        $paymentDetailArray['value'] = $totalValue;
                        $paymentDetailArray['timestamp'] = date('Y-m-d H:i:s');
                        $paymentDetailArray['idUser'] = $currentUserId;
                        $paymentDetailArray['idPaymentMethod'] = $paymentMethodId;
                        $newPaymentId = $model->insertPaymentDetail($paymentDetailArray);

                        $model->insertInvoicePayment([
                            'idReceipt' => $newInvoiceId,
                            'idPayment' => $newPaymentId
                        ]);
                    }
                }

                return redirect()->to(base_url('viewServiceDetails/' . $newInvoiceId));
            }
        }

        return redirect()->back()->with('error', 'Failed to update the invoice.');
    }

    private function getServiceNameById($serviceId)
    {
        $model = new ServicesModel();
        $service = $model->find($serviceId);
        return $service ? $service['Name'] : 'Unknown Service';
    }


    private function getNextInvOrdNum()
    {
        $model = new InvoiceModel();
        $latestInvoice = $model->getLatestInvoice();

        if ($latestInvoice) {
            return $latestInvoice['invOrdNum'] + 1;
        }

        return 1;
    }


    public function generateInvoice($idReceipts)
    {
        $session = \Config\Services::session();

        $invoiceModel = new InvoiceModel();
        $serviceModel = new ServicesModel();
        $clientModel = new ClientModel();
        $invDetailModel = new InvoiceDetailModel();
        $businessModel = new LoginModel('business');
        $businessTypeModel = new BusinessModel();

        $invoiceData = $invoiceModel->getInvoiceData($idReceipts);

        if (!$invoiceData) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invoice not found']);
        }

        $services = $invDetailModel->getServicesByInvoice($idReceipts);
        $paymentDetailsData = $invoiceModel->getPaymentDetails($idReceipts);



        $businessID = $session->get('businessID');

        $businessModel = new LoginModel('business');
        $business = $businessModel->find($businessID);
        $businessTypeID = $business['businessTypeID'];

        $businessTypeModel = new LoginModel('businesstype');
        $businessType = $businessTypeModel->find($businessTypeID);
        $isHospital = strtolower($businessType['businessType']) === 'hospital';


        $clientId = $invoiceData['idClient'];
        $clientAge = $clientModel->getClientAge($businessID, $clientId);
        $clientGender = $clientModel->getClientGender($businessID, $clientId);
        $clientUnique = $clientModel->getClientUnique($businessID, $clientId);
        $clientName = $clientModel->getClientName($businessID, $clientId);


        $invoiceNumber = $invoiceData['invOrdNum'] ?? 0;
        $operatorName = session()->get('fName');

        $totalAmount = 0;
        $totalDiscount = 0;
        $totalTax = 0;
        foreach ($services as &$service) {
            $quantity = (float) $service['Quantity'];
            $fee = (float) $service['Price'];
            $discount = (float) ($service['Discount'] ?? 0);
            $tax = (float) ($service['ValueTax'] ?? 0);

            $totalAmount += $quantity * $fee;
            $totalDiscount += ($fee * $discount / 100) * $quantity;
            $totalTax += $tax;
            $idArtMenu = $service['idArtMenu'] ?? '';

            $ServiceName = $serviceModel->getServiceName($businessID, $idArtMenu);


            $service['quantity'] = $quantity;
            $service['fee'] = $fee;
            $service['discount'] = $discount;
            $service['calculatedTax'] = $tax;
            // $service['serviceName'] = 'test';
            $service['serviceName'] = $ServiceName;
        }
        $discountedTotal = $totalAmount - $totalDiscount + $totalTax;

        $idCurrency = $invoiceData['idCurrency'];

        $currencyName = $invoiceModel->getCurrencyName($idCurrency);

        $idPayment = $invoiceData['paymentMethod'];
        $paymentMethodName = $invoiceModel->getPaymentMethodName($idPayment);

        $mpdf = new \Mpdf\Mpdf();
        $pdfContent = view('pdf_invoice', [
            'invoiceData' => $invoiceData,
            'services' => $services,
            'paymentDetailsData' => $paymentDetailsData,
            'clientName' => $clientName,
            'currencyName' => $currencyName,
            'paymentMethodName' => $paymentMethodName,
            'Age' => $clientAge,
            'clientUnique' => $clientUnique,
            'Gender' => $clientGender,
            'InvoiceNumber' => $invoiceNumber,
            'operatorName' => $operatorName,
            'discountedTotal' => $discountedTotal,
            'isHospital' => $isHospital,
            'totalAmount' => $totalAmount,
            'totalDiscount' => $totalDiscount,
            'totalTax' => $totalTax
        ]);

        $mpdf = new \Mpdf\Mpdf();
        $pdfContent = view('pdf_invoice', [
        ]);
        $mpdf->WriteHTML($pdfContent);

        $filename = "Invoice_" . $invoiceNumber . ".pdf";

        $this->response->setHeader('Content-Type', 'application/pdf');
        $this->response->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"');

        return $this->response->setBody($mpdf->Output($filename, 'S'));
    }

}