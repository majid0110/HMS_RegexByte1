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
use App\Models\InventoryModel;
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
        $data['Warehouses'] = $purchase->getWareHouse();
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
            $warehouseId = $this->request->getPost('warehouseId');

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
                        $quantity = (float) $service['quantity'];
                        $totalFee += $fee * $quantity;
                    } else {
                        throw new \Exception('Service fee or quantity is not set.');
                    }
                }
            } else {
                throw new \Exception('Services data is null.');
            }

            $purchaseModel = new purchaseInvoiceModel();
            $lastInvoiceNumber = $purchaseModel->getLastInvoiceNumber();
            // $purchaseModel->select('invOrdNum')->orderBy('invOrdNum', 'DESC')->limit(1)->first();
            $newInvoiceNumber = $lastInvoiceNumber + 1;
            $invoiceData = [
                'idSupplier' => $Supplierid,
                'Value' => $discountedTotal,
                'actual_Value' => $totalFee,
                'idUser' => $UserID,
                'Status' => 'open',
                'idBusiness' => $businessID,
                'idCancellation' => 0,
                'invOrdNum' => $newInvoiceNumber,
                'idWarehouse' => $warehouseId,
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
                $quantity = (float) $service['quantity'];
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
            $warehouseId = $this->request->getPost('warehouseId');

            $session = \Config\Services::session();
            $businessID = $session->get('businessID');
            $UserID = $session->get('ID');
            $db->transBegin();

            if (!is_null($services)) {
                $totalFee = 0;
                foreach ($services as $service) {
                    if (isset($service['fee']) && isset($service['quantity'])) {
                        $fee = (float) $service['fee'];
                        $quantity = (float) $service['quantity'];
                        $totalFee += $fee * $quantity;
                    } else {
                        throw new \Exception('Service fee or quantity is not set.');
                    }
                }
            } else {
                throw new \Exception('Services data is null.');
            }

            $purchaseModel = new purchaseInvoiceModel();
            $lastInvoiceNumber = $purchaseModel->getLastInvoiceNumber();
            $newInvoiceNumber = $lastInvoiceNumber + 1;
            $invoiceData = [
                'idSupplier' => $Supplierid,
                'Value' => $discountedTotal,
                'actual_Value' => $totalFee,
                'idUser' => $UserID,
                'Status' => 'open',
                'idBusiness' => $businessID,
                'idCancellation' => 0,
                'invOrdNum' => $newInvoiceNumber,
                'idWarehouse' => $warehouseId,
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
                $quantity = (float) $service['quantity'];
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
                $Model->addToInventory([$idItem], $quantity, $businessID, $warehouseId, $expiryDate);
                // $Model->subtractFromInventory([$idItem], $quantity, $businessID, $expiryDate);
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

    public function Purchase_table()
    {
        $Model = new purchaseInvoiceModel();
        $data['totalHospitalFee'] = 100;

        $SupplierModel = new SupplierModel();
        $data['Suppliers'] = $SupplierModel->getSupplierNames();

        $sales = new SalesModel();
        $data['payments'] = $sales->getpayment();

        $data['Invoice'] = $Model->getInvoice();

        $search = $this->request->getPost('search');
        $invoice = $this->request->getPost('invoiceValue');
        $paymentValue = $this->request->getPost('payment');
        $SupplierName = $this->request->getPost('clientValue');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');


        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;
        $offset = ($currentPage - 1) * $perPage;

        $data['totalPurchaseFee'] = $Model->getPurchaseFee($SupplierName, $search, $paymentValue, $invoice, $fromDate, $toDate, $perPage, $offset);

        $data['Purchases'] = $Model->getPurchaseReport($search, $SupplierName, $paymentValue, $invoice, $fromDate, $toDate, $perPage, $offset);
        $data['pager'] = $Model->getPager($search, $paymentValue, $invoice, $SupplierName, $fromDate, $toDate, $perPage, $currentPage);

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('PurchasePartialTable', $data);
                return $this->response->setJSON([
                    'success' => true,
                    'tableContent' => $tableContent,
                    'pager' => $data['pager'],
                    'totalPurchaseFee' => $data['totalPurchaseFee'],

                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            return view('Purchase_table', $data);

        }
    }

    public function viewPurchaseDetails($idReceipts)
    {
        $model = new salesModel();
        // $clientModel = new ClientModel();
        $supplierModel = new SupplierModel();

        $data['payments'] = $model->getpayment();
        $data['currencies'] = $model->getCurrancy();

        $PModel = new PurchaseModel();
        $data['ServiceDetails'] = $PModel->getPurchaseDetails($idReceipts);
        // $data['ServiceDetails'] = $model->getSalesDetails($idReceipts);
        $data['PaymentDetails'] = $PModel->getPurchasePaymentDetails($idReceipts);
        // $data['PaymentDetails'] = $model->getPaymentDetails($idReceipts);
        $data['clients'] = $supplierModel->findAll();
        // $data['clients'] = $clientModel->findAll();

        $data['services'] = $PModel->getPurchaseItems();
        // $data['services'] = $model->getServices();

        $invoice = $PModel->getPurchaseInvoiceByOrdNum($idReceipts);

        // $invoice = $model->getInvoiceByOrdNum($idReceipts);

        if ($invoice) {
            $data['valueToPay'] = $invoice->remainingValue;
            $data['client'] = $invoice->idSupplier;
            $data['idReceipts'] = $invoice->idReceipts;
        } else {
            $data['valueToPay'] = null;
            $data['idReceipts'] = null;
        }

        $data['referenceInvoices'] = $model->getReferenceInvoices($idReceipts);

        return view('Purchase_details', $data);
    }

    public function PurchasePayment()
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

        $paymentDetailsModel = new PurPaymentDetailsModel();

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
        $invoice = $paymentDetailsModel->getPurchaseInvoiceById($idReceipts);

        // $invoice = $invoiceModel->getInvoiceById($idReceipts);

        if ($invoice) {
            $totalPaid = $invoice->totalPaid + $value;
            if ($totalPaid >= $invoice->Value) {
                $paymentDetailsModel->updatePurchaseInvoiceStatus($idReceipts, 'closed');
                echo ('status changed');
            }
        }

        return redirect()->to(base_url("/Purchase_table"));
        // return redirect()->back();

    }

    public function cancelPurchaseInvoice($idReceipts)
    {
        $model = new InvoiceModel();
        $salesModel = new salesModel();
        $inventoryModel = new InventoryModel();
        $itemsWarehouseModel = new itemsModel();

        $PModel = new PurchaseModel();
        $session = \Config\Services::session();
        $currentUserId = $session->get('ID');

        $references = $PModel->getPurchaseReferenceInvoices($idReceipts);
        foreach ($references as $reference) {
            $referencedInvoice = $PModel->getPurchaseInvoiceById($reference->idReceipt ?? $reference['idReceipt']);
            if ($referencedInvoice) {
                $notes = is_object($referencedInvoice) ? $referencedInvoice->Notes : $referencedInvoice['Notes'];
                if ($notes == 'Cancelled') {
                    session()->setFlashdata('error', 'This invoice has already been cancelled...!!');
                    return redirect()->to(base_url('/viewServiceDetails/' . $idReceipts));
                }
            }
        }

        $invoice = $PModel->getPurchaseInvoiceById($idReceipts);
        $invoiceDetails = $PModel->getPurchaseInvoiceDetailsByReceiptId($idReceipts);
        $invoicePayments = $PModel->getPurchaseInvoicePaymentsByReceiptId($idReceipts);

        if ($invoice) {
            $invoiceArray = (array) $invoice;

            $newInvoiceData = $invoiceArray;
            unset($newInvoiceData['idReceipts']);

            $newInvoiceData['Value'] = -$invoiceArray['Value'];
            $newInvoiceData['Notes'] = 'Cancelled';
            $newInvoiceData['timeStamp'] = date('Y-m-d H:i:s');
            $newInvoiceData['invOrdNum'] = $this->getNextInvOrdNum();
            $newInvoiceData['idUser'] = $currentUserId;

            $PImodel = new purchaseInvoiceModel();
            $newInvoiceId = $PImodel->insertPurchaseInvoice1($newInvoiceData);

            if ($newInvoiceId) {
                $referenceData = [
                    'idReceipt' => $newInvoiceId,
                    'receiptReference' => $idReceipts
                ];

                $PImodel->insertPurchaseInvoiceReference($referenceData);

                foreach ($invoiceDetails as $detail) {
                    $detailArray = (array) $detail;
                    unset($detailArray['idInvoiceDetail']);

                    $detailArray['idReceipts'] = $newInvoiceId;
                    $detailArray['Quantity'] = -$detailArray['Quantity'];
                    $detailArray['Sum'] = $detailArray['Quantity'] * $detailArray['Price'];

                    $PImodel->insertPurchaseInvoiceDetail($detailArray);

                    $item = $itemsWarehouseModel->getItemByName($detailArray['name']);
                    if ($item) {
                        $idItem = $item['idItem'];

                        $inventory = $inventoryModel->getInventoryByItem($idItem);
                        if ($inventory) {
                            $newInventory = $inventory['inventory'] - abs($detailArray['Quantity']);
                            $inventoryModel->updateInventory($idItem, $newInventory);
                        }
                    }
                }

                foreach ($invoicePayments as $payment) {
                    $paymentArray = (array) $payment;

                    $paymentDetails = $PImodel->getPurchasePaymentDetailsById($paymentArray['idPayment']);
                    foreach ($paymentDetails as $paymentDetail) {
                        $paymentDetailArray = (array) $paymentDetail;
                        unset($paymentDetailArray['idPayment']);

                        $paymentDetailArray['value'] = -$paymentDetailArray['value'];
                        $paymentDetailArray['timestamp'] = date('Y-m-d H:i:s');

                        $newPaymentId = $PImodel->insertPurchasePaymentDetail($paymentDetailArray);

                        $PImodel->insertPurchaseInvoicePayment([
                            'idReceipt' => $newInvoiceId,
                            'idPayment' => $newPaymentId
                        ]);
                    }
                }

                session()->setFlashdata('success', 'Invoice cancelled...!!');
                return redirect()->to(base_url('/viewPurchaseDetails/' . $newInvoiceId));
            }
        }

        return redirect()->back()->with('error', 'Failed to cancel the invoice.');
    }

    private function getNextInvOrdNum()
    {
        $model = new PurchaseModel();
        $latestInvoice = $model->getLatestPurchaseInvoice();

        if ($latestInvoice) {
            return $latestInvoice['invOrdNum'] + 1;
        }

        return 1;
    }

    // public function UpdatePurchaseInvoice()
    // {
    //     $request = service('request');
    //     $session = \Config\Services::session();
    //     $currentUserId = $session->get('ID');

    //     // $invoiceId = $request->getPost('invoiceId');
    //     $invoiceId = 52;
    //     $idSupplier = $request->getPost('client');
    //     $clientEmail = $request->getPost('email');
    //     $clientContact = $request->getPost('contact');
    //     $currencyId = $request->getPost('currency');
    //     $invoiceDate = $request->getPost('invoiceDate');
    //     $paymentMethodId = $request->getPost('paymentMethod');
    //     $notes = $request->getPost('notes');
    //     $serviceDetails = $request->getPost('ServiceDetails');
    //     $totalValue = $request->getPost('totalValue');

    //     $model = new InvoiceModel();

    //     $PModel = new PurchaseModel();

    //     $originalInvoice = $PModel->getInvoiceById($invoiceId);
    //     $originalInvoiceDetails = $PModel->getPurchaseInvoiceDetailsByReceiptId($invoiceId);
    //     $originalInvoicePayments = $PModel->getPurchaseInvoicePaymentsByReceiptId($invoiceId);

    //     if ($originalInvoice) {
    //         $cancelStatus = $this->cancelPurchaseInvoice($invoiceId);
    //         if (!$cancelStatus) {
    //             return redirect()->back()->with('error', 'Invoice cancellation failed.');
    //         }

    //         $newInvoiceData = (array) $originalInvoice;
    //         unset($newInvoiceData['idReceipts']);

    //         $newInvoiceData['idSupplier'] = $idSupplier;
    //         $newInvoiceData['idCurrency'] = $currencyId;
    //         $newInvoiceData['Date'] = $invoiceDate;
    //         $newInvoiceData['Value'] = $totalValue;
    //         $newInvoiceData['paymentMethod'] = $paymentMethodId;
    //         $newInvoiceData['Notes'] = 'Corrective';
    //         $newInvoiceData['InvoiceNotes'] = $notes;
    //         $newInvoiceData['idUser'] = $currentUserId;
    //         $newInvoiceData['timeStamp'] = date('Y-m-d H:i:s');
    //         $newInvoiceData['invOrdNum'] = $this->getNextInvOrdNum();


    //         $PIModel = new purchaseInvoiceModel();
    //         $newInvoiceId = $PIModel->insertPurchaseInvoice($newInvoiceData);

    //         if ($newInvoiceId) {
    //             $referenceData = [
    //                 'idReceipt' => $newInvoiceId,
    //                 'receiptReference' => $invoiceId
    //             ];
    //             $PIModel->insertPurchaseInvoiceReference($referenceData);

    //             foreach ($serviceDetails as $index => $detail) {
    //                 $newDetail = [];
    //                 $isNewRow = true;

    //                 foreach ($originalInvoiceDetails as $originalDetail) {
    //                     if ($originalDetail->idItem == $detail['idItem']) {
    //                         $newDetail = (array) $originalDetail;
    //                         $isNewRow = false;
    //                         break;
    //                     }
    //                 }

    //                 if ($isNewRow) {
    //                     $newDetail = [
    //                         'idReceipts' => $newInvoiceId,
    //                         'Nr' => $index + 1,
    //                         'idItem' => $detail['ServiceTypeName'],
    //                         'idBusiness' => $originalInvoice->idBusiness,
    //                         'IdTax' => 0,
    //                         'ValueTax' => 0,
    //                         'idMag' => 0,
    //                         'name' => $this->getItemNameById($detail['ServiceTypeName']),
    //                         'idSummaryInvoice' => 0,
    //                         'Discount' => 0,
    //                     ];


    //                 } else {
    //                     unset($newDetail['idInvoiceDetail']);
    //                     $newDetail['idReceipts'] = $newInvoiceId;
    //                 }

    //                 $newDetail['Quantity'] = $detail['Quantity'];
    //                 $newDetail['Price'] = $detail['Price'];
    //                 $newDetail['Sum'] = $detail['Quantity'] * $detail['Price'];

    //                 $PIModel->insertPurchaseInvoiceDetail($newDetail);
    //             }

    //             foreach ($originalInvoicePayments as $payment) {
    //                 $paymentArray = (array) $payment;
    //                 unset($paymentArray['idInvPay']);

    //                 $paymentDetails = $PIModel->getPurchasePaymentDetailsById($paymentArray['idPayment']);
    //                 foreach ($paymentDetails as $paymentDetail) {
    //                     $paymentDetailArray = (array) $paymentDetail;
    //                     unset($paymentDetailArray['idPayment']);

    //                     $paymentDetailArray['value'] = $totalValue;
    //                     $paymentDetailArray['timestamp'] = date('Y-m-d H:i:s');
    //                     $paymentDetailArray['idUser'] = $currentUserId;
    //                     $paymentDetailArray['idPaymentMethod'] = $paymentMethodId;
    //                     $newPaymentId = $PIModel->insertPurchasePaymentDetail($paymentDetailArray);

    //                     $PIModel->insertPurchaseInvoicePayment([
    //                         'idReceipt' => $newInvoiceId,
    //                         'idPayment' => $newPaymentId
    //                     ]);
    //                 }
    //             }

    //             return redirect()->to(base_url('/Purchase_table'));

    //             // return redirect()->to(base_url('/viewPurchaseDetails/' . $newInvoiceId));
    //         }
    //     }

    //     return redirect()->back()->with('error', 'Failed to update the invoice.');
    // }

    private function getItemNameById($serviceId)
    {
        $model = new itemsModel();
        $service = $model->find($serviceId);
        return $service ? $service['Name'] : 'Unknown Item';
    }

    public function UpdatePurchaseInvoice()
    {
        $request = service('request');
        $session = \Config\Services::session();
        $currentUserId = $session->get('ID');

        $invoiceId = $request->getPost('invoiceId');
        $idSupplier = $request->getPost('client');
        $clientEmail = $request->getPost('email');
        $clientContact = $request->getPost('contact');
        $currencyId = $request->getPost('currency');
        $invoiceDate = $request->getPost('invoiceDate');
        $paymentMethodId = $request->getPost('paymentMethod');
        $notes = $request->getPost('notes');
        $serviceDetails = $request->getPost('ServiceDetails');
        $totalValue = $request->getPost('totalValue');

        $model = new InvoiceModel();
        $PModel = new PurchaseModel();

        // Retrieve original invoice
        $originalInvoice = $PModel->getPurchaseInvoiceById($invoiceId);
        if (!$originalInvoice) {
            return redirect()->back()->with('error', 'Original invoice not found.');
        }

        $originalInvoiceDetails = $PModel->getPurchaseInvoiceDetailsByReceiptId($invoiceId);
        if (!$originalInvoiceDetails) {
            return redirect()->back()->with('error', 'Original invoice details not found.');
        }

        $originalInvoicePayments = $PModel->getPurchaseInvoicePaymentsByReceiptId($invoiceId);
        if (!$originalInvoicePayments) {
            return redirect()->back()->with('error', 'Original invoice payments not found.');
        }

        // Attempt to cancel the original invoice
        $cancelStatus = $this->cancelPurchaseInvoice($invoiceId);
        if (!$cancelStatus) {
            return redirect()->back()->with('error', 'Invoice cancellation failed.');
        }

        // Prepare new invoice data
        $newInvoiceData = (array) $originalInvoice;
        unset($newInvoiceData['idReceipts']);

        $newInvoiceData['idSupplier'] = $idSupplier;
        $newInvoiceData['idCurrency'] = $currencyId;
        $newInvoiceData['Date'] = $invoiceDate;
        $newInvoiceData['Value'] = $totalValue;
        $newInvoiceData['paymentMethod'] = $paymentMethodId;
        $newInvoiceData['Notes'] = 'Corrective';
        $newInvoiceData['InvoiceNotes'] = $notes;
        $newInvoiceData['idUser'] = $currentUserId;
        $newInvoiceData['timeStamp'] = date('Y-m-d H:i:s');
        $newInvoiceData['invOrdNum'] = $this->getNextInvOrdNum();

        // Insert new invoice
        $PIModel = new purchaseInvoiceModel();
        $newInvoiceId = $PIModel->insertPurchaseInvoice($newInvoiceData);

        if (!$newInvoiceId) {
            return redirect()->back()->with('error', 'Failed to insert the new invoice.');
        }

        // Insert reference for the new invoice
        $referenceData = [
            'idReceipt' => $newInvoiceId,
            'receiptReference' => $invoiceId
        ];
        $insertRefStatus = $PIModel->insertPurchaseInvoiceReference($referenceData);

        if (!$insertRefStatus) {
            return redirect()->back()->with('error', 'Failed to insert invoice reference.');
        }

        // Insert service details
        foreach ($serviceDetails as $index => $detail) {
            $newDetail = [];
            $isNewRow = true;

            foreach ($originalInvoiceDetails as $originalDetail) {
                if ($originalDetail->idItem == $detail['idItem']) {
                    $newDetail = (array) $originalDetail;
                    $isNewRow = false;
                    break;
                }
            }

            if ($isNewRow) {
                $newDetail = [
                    'idReceipts' => $newInvoiceId,
                    'Nr' => $index + 1,
                    'idItem' => $detail['ServiceTypeName'],
                    'idBusiness' => $originalInvoice->idBusiness,
                    'IdTax' => 0,
                    'ValueTax' => 0,
                    'idMag' => 0,
                    'name' => $this->getItemNameById($detail['ServiceTypeName']),
                    // 'idSummaryInvoice' => 0,
                    'Discount' => 0,
                ];
            } else {
                unset($newDetail['idInvoiceDetail']);
                $newDetail['idReceipts'] = $newInvoiceId;
            }

            $newDetail['Quantity'] = $detail['Quantity'];
            $newDetail['Price'] = $detail['Price'];
            $newDetail['Sum'] = $detail['Quantity'] * $detail['Price'];

            $insertDetailStatus = $PIModel->insertPurchaseInvoiceDetail($newDetail);

            if (!$insertDetailStatus) {
                return redirect()->back()->with('error', 'Failed to insert service details for item ' . $detail['ServiceTypeName']);
            }
        }

        // Insert payment details
        foreach ($originalInvoicePayments as $payment) {
            $paymentArray = (array) $payment;
            unset($paymentArray['idInvPay']);

            $paymentDetails = $PIModel->getPurchasePaymentDetailsById($paymentArray['idPayment']);
            foreach ($paymentDetails as $paymentDetail) {
                $paymentDetailArray = (array) $paymentDetail;
                unset($paymentDetailArray['idPayment']);

                $paymentDetailArray['value'] = $totalValue;
                $paymentDetailArray['timestamp'] = date('Y-m-d H:i:s');
                $paymentDetailArray['idUser'] = $currentUserId;
                $paymentDetailArray['idPaymentMethod'] = $paymentMethodId;
                $newPaymentId = $PIModel->insertPurchasePaymentDetail($paymentDetailArray);

                if (!$newPaymentId) {
                    return redirect()->back()->with('error', 'Failed to insert payment detail.');
                }

                $insertPaymentStatus = $PIModel->insertPurchaseInvoicePayment([
                    'idReceipt' => $newInvoiceId,
                    'idPayment' => $newPaymentId
                ]);

                if (!$insertPaymentStatus) {
                    return redirect()->back()->with('error', 'Failed to insert invoice payment for payment ' . $paymentArray['idPayment']);
                }
            }
        }

        return redirect()->to(base_url('/viewPurchaseDetails/' . $newInvoiceId))->with('success', 'Invoice updated successfully.');
    }

    public function downloadPDF($idReceipts)
    {
        // $model = new salesModel();
        // $data['ServiceDetails'] = $model->getSalesDetails1($idReceipts);

        $PModel = new PurchaseModel();
        $data['ServiceDetails'] = $PModel->getPurchaseDetails1($idReceipts);

        $qrContent = base_url('viewPurchaseDetails/' . $idReceipts);
        $qrCode = new QrCode($qrContent);
        $qrCode->setSize(150);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $qrDataUri = $result->getDataUri();
        $data['qrDataUri'] = $qrDataUri;

        $html = view('purchase_pdf', $data);

        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 14,
            'margin_right' => 11,
            'margin_top' => 11,
            'margin_bottom' => 8,
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output('invoice_' . $idReceipts . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }

}