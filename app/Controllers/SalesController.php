<?php

namespace App\Controllers;

use CodeIgniter\Controller;


use App\Models\InvoiceDetailModel;
use App\Models\ClientModel;
use App\Models\InvoiceModel;
use App\Models\InvoiceDetailsModel;
use App\Models\ItemsInventoryModel;
use App\Models\salesModel;
use App\Models\LoginModel;
use App\Models\ConfigModel;
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

        $invOrdNum = $this->request->getVar('invOrdNum');

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

    // public function PayInvoice($idReceipts)
    // {
    //     $sales = new SalesModel();
    //     $data['payments'] = $sales->getpayment();
    //     $data['currencies'] = $sales->getCurrancy();

    //     $invoice = $sales->getInvoiceByIdReceipts($idReceipts);

    //     if ($invoice) {
    //         $data['valueToPay'] = $invoice->Value;
    //     } else {
    //         $data['valueToPay'] = null;
    //         log_message('error', "Invoice not found for idReceipts: {$idReceipts}");
    //     }

    //     return view('PayInovice.php', $data);
    // }
    public function Sales_table()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
        $Model = new salesModel();
        $data['Sales'] = $Model->getSales();
        return view('Sales_table.php', $data);
    }


    //-------------------------------------------------------------------------------------------------------------------------
//                                                 Main Logic
//-------------------------------------------------------------------------------------------------------------------------

    // public function submitServices()
    // {
    //     $db = \Config\Database::connect();
    //     try {
    //         $invoice = new InvoiceModel();
    //         $invoiceDetailModel = new InvoiceDetailModel();
    //         $clientId = $this->request->getPost('clientId');
    //         $clientName = $this->request->getPost('clientName');
    //         $exchange = $this->request->getPost('exchange');
    //         $currency = $this->request->getPost('currency');
    //         $currencyName = $this->request->getPost('currencyName');
    //         $paymentMethod = $this->request->getPost('paymentMethodName');
    //         $paymentMethodName = $this->request->getPost('paymentName');
    //         $paymentMethodID = $this->request->getPost('paymentMethodId');
    //         $totalFee = $this->request->getPost('totalFee');
    //         $services = $this->request->getPost('services');
    //         $session = \Config\Services::session();
    //         $businessID = $session->get('businessID');
    //         $UserID = $session->get('ID');
    //         $db->transBegin();

    //         if (!is_null($services)) {
    //             $totalFee = 0;
    //             foreach ($services as $service) {
    //                 if (isset($service['fee']) && isset($service['quantity'])) {
    //                     $fee = (float) $service['fee'];
    //                     $quantity = (int) $service['quantity'];
    //                     $totalFee += $fee * $quantity;
    //                 } else {
    //                     throw new \Exception('Service fee or quantity is not set.');
    //                 }
    //             }
    //         } else {
    //             throw new \Exception('Services data is null.');
    //         }

    //         $lastInvoiceNumber = $invoice->select('invOrdNum')->orderBy('invOrdNum', 'DESC')->limit(1)->first();
    //         $newInvoiceNumber = $lastInvoiceNumber ? $lastInvoiceNumber['invOrdNum'] + 1 : 1;
    //         $invoiceData = [
    //             'idClient' => $clientId,
    //             'Value' => $totalFee,
    //             'idTable' => 0,
    //             'idUser' => $UserID,
    //             'Status' => 'closed',
    //             'serial_number' => 0,
    //             'idBusiness' => $businessID,
    //             'idCancellation' => 0,
    //             'invOrdNum' => $newInvoiceNumber,
    //             'selfissue' => 0,
    //             'FIC' => 0,
    //             'ValueTVSH' => 0,
    //             'idCurrency' => $currency,
    //             'rate' => $exchange,
    //             'paymentMethod' => $paymentMethodID,
    //             'closeShift' => 0,
    //             'isSummaryInvoice' => 0,
    //             'seial_nr' => 0,
    //             'idPoint_of_sale' => 0,
    //             'imported_invoice_number' => 0,
    //             'isExport' => 0,
    //             'isReverseCharge' => 0,
    //             'Contract' => 0,
    //             'deliveryid' => 0,
    //             'invoice_period_start_date' => 0,
    //             'invoice_period_end_date' => 0,
    //             'filename' => 0,
    //             'dokumenti' => 0,
    //             'lloji_fatures_id' => 0,
    //             'InvoiceNotes' => 0,
    //         ];
    //         $invoice->insertInvoice($invoiceData);
    //         $idPayment = $invoice->getInsertID();

    //         $discountedTotal = $totalFee;
    //         foreach ($services as $service) {
    //             $discount = $service['discount'];
    //             $quantity = (int) $service['quantity'];
    //             $fee = (float) $service['fee'];
    //             $sum = $quantity * $fee;
    //             // $discountedSum = $sum - ($sum * ($discount / 100));
    //             $discountedTotal -= ($sum * ($discount / 100));

    //             $expiryDate = $service['expiryDate'];
    //             $serviceData = [
    //                 'idReceipts' => $idPayment,
    //                 'Nr' => 0,
    //                 'idArtMenu' => $service['serviceTypeId'],
    //                 'Quantity' => $quantity,
    //                 'Price' => $fee,
    //                 'Sum' => $sum,
    //                 'idBusiness' => $businessID,
    //                 'IdTax' => 1,
    //                 'ValueTax' => 0,
    //                 'idMag' => 1,
    //                 'name' => $service['serviceName'],
    //                 'idSummaryInvoice' => 0,
    //                 'Discount' => $discount,
    //             ];
    //             $invoiceDetailModel->insert($serviceData);

    //             $idArtMenu = $service['serviceTypeId'];
    //             $Model = new ItemsInventoryModel();
    //             $ratioData = $Model->getRatio($idArtMenu, $businessID);

    //             foreach ($ratioData as $data) {
    //                 $idItem = $data->idItem;
    //                 $ratio = $data->ratio;
    //                 $inventorySubtract = $quantity * $ratio;

    //                 $Model->subtractFromInventory($idItem, $inventorySubtract);
    //                 $Model->subtractFromExpiryInventory($idItem, $expiryDate, $inventorySubtract);

    //             }
    //         }

    //         $paymentDetailsModel = new InvoiceDetailsModel();
    //         $paymentDetailsData = [
    //             'value' => $totalFee,
    //             'idUser' => $UserID,
    //             'idAnullim' => 0,
    //             'method' => $paymentMethod,
    //             'idPaymentMethod' => $paymentMethodID,
    //             'exchange' => $exchange,
    //             'nr_serial' => 0,
    //         ];
    //         $paymentDetailsModel->insert($paymentDetailsData);
    //         $idReceipt = $paymentDetailsModel->getInsertID();
    //         $paymentDetailsModel->insertInvoicePayment([
    //             'idReceipt' => $idPayment,
    //             'idPayment' => $idReceipt,
    //         ]);

    //         $db->transCommit();

    //         $clientModel = new ClientModel();
    //         $Age = $clientModel->getclientAge($businessID, $clientId);
    //         $Gender = $clientModel->getclientGender($businessID, $clientId);
    //         $clientUnique = $clientModel->getclientUnique($businessID, $clientId);
    //         $InvoiceNumber = $invoice->getinvoiceNumber($businessID, $idPayment);
    //         $operatorName = session()->get('fName');

    //         $mpdf = new \Mpdf\Mpdf();
    //         $pdfContent = view('pdf_invoice', [
    //             'invoiceData' => $invoiceData,
    //             'services' => $services,
    //             'paymentDetailsData' => $paymentDetailsData,
    //             'clientName' => $clientName,
    //             'currencyName' => $currencyName,
    //             'paymentMethodName' => $paymentMethodName,
    //             'Age' => $Age,
    //             'clientUnique' => $clientUnique,
    //             'Gender' => $Gender,
    //             'InvoiceNumber' => $InvoiceNumber,
    //             'operatorName' => $operatorName,
    //             'discountedTotal' => $discountedTotal,
    //         ]);
    //         $mpdf->WriteHTML($pdfContent);
    //         $pdfBinary = $mpdf->Output('', 'S');
    //         return $this->response->setJSON([
    //             'status' => 'success',
    //             'message' => 'Data inserted successfully',
    //             'pdfContent' => base64_encode($pdfBinary),
    //         ]);
    //     } catch (\Exception $e) {
    //         $db->transRollback();
    //         log_message('error', 'Error retrieving data: ' . $e->getMessage());
    //         return $this->response->setJSON(['error' => 'Error retrieving data.', 'message' => $e->getMessage()]);
    //     }
    // }

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
                'Value' => $totalFee,
                'idTable' => 0,
                'idUser' => $UserID,
                'Status' => 'closed',
                'serial_number' => 0,
                'idBusiness' => $businessID,
                'idCancellation' => 0,
                'invOrdNum' => $newInvoiceNumber,
                'selfissue' => 0,
                'FIC' => 0,
                'ValueTVSH' => 0,
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
                'InvoiceNotes' => 0,
            ];
            $invoice->insertInvoice($invoiceData);
            $idPayment = $invoice->getInsertID();

            $discountedTotal = $totalFee;

            foreach ($services as $service) {
                $discount = $service['discount'];
                $quantity = (int) $service['quantity'];
                $fee = (float) $service['fee'];
                $sum = $quantity * $fee;
                $discountedTotal -= ($sum * ($discount / 100));

                $expiryDate = $service['expiryDate'];
                $serviceData = [
                    'idReceipts' => $idPayment,
                    'Nr' => 0,
                    'idArtMenu' => $service['serviceTypeId'],
                    'Quantity' => $quantity,
                    'Price' => $fee,
                    'Sum' => $sum,
                    'idBusiness' => $businessID,
                    'IdTax' => 1,
                    'ValueTax' => 0,
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

            // foreach ($services as $service) {
            //     $discount = $service['discount'];
            //     $quantity = (int) $service['quantity'];
            //     $fee = (float) $service['fee'];
            //     $sum = $quantity * $fee;
            //     $discountedTotal -= ($sum * ($discount / 100));

            //     $expiryDate = $service['expiryDate'];
            //     $serviceData = [
            //         'idReceipts' => $idPayment,
            //         'Nr' => 0,
            //         'idArtMenu' => $service['serviceTypeId'],
            //         'Quantity' => $quantity,
            //         'Price' => $fee,
            //         'Sum' => $sum,
            //         'idBusiness' => $businessID,
            //         'IdTax' => 1,
            //         'ValueTax' => 0,
            //         'idMag' => 1,
            //         'name' => $service['serviceName'],
            //         'idSummaryInvoice' => 0,
            //         'Discount' => $discount,
            //     ];
            //     $invoiceDetailModel->insert($serviceData);

            //     $idArtMenu = $service['serviceTypeId'];
            //     $Model = new ItemsInventoryModel();
            //     $ratioData = $Model->getRatio($idArtMenu, $businessID);

            //     foreach ($ratioData as $data) {
            //         $idItem = $data->idItem;
            //         $ratio = $data->ratio;
            //         $inventorySubtract = $quantity * $ratio;

            //         // Subtracting inventory and expiry inventory for each item
            //         $Model->subtractFromInventory($idItem, $inventorySubtract);
            //         $Model->subtractFromExpiryInventory($idItem, $expiryDate, $inventorySubtract);
            //     }
            // }

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
                'Value' => $totalFee,
                'idTable' => 0,
                'idUser' => $UserID,
                'Status' => 'open',
                'serial_number' => 0,
                'idBusiness' => $businessID,
                'idCancellation' => 0,
                'invOrdNum' => $newInvoiceNumber,
                'selfissue' => 0,
                'FIC' => 0,
                'ValueTVSH' => 0,
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
                'InvoiceNotes' => 0,
            ];
            $invoice->insertInvoice($invoiceData);
            $idPayment = $invoice->getInsertID();

            $discountedTotal = $totalFee;

            foreach ($services as $service) {
                $discount = $service['discount'];
                $quantity = (int) $service['quantity'];
                $fee = (float) $service['fee'];
                $sum = $quantity * $fee;
                $discountedTotal -= ($sum * ($discount / 100));

                $expiryDate = $service['expiryDate'];
                $serviceData = [
                    'idReceipts' => $idPayment,
                    'Nr' => 0,
                    'idArtMenu' => $service['serviceTypeId'],
                    'Quantity' => $quantity,
                    'Price' => $fee,
                    'Sum' => $sum,
                    'idBusiness' => $businessID,
                    'IdTax' => 1,
                    'ValueTax' => 0,
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

    public function viewServiceDetails($idReceipts)
    {
        $model = new salesModel();
        $data['ServiceDetails'] = $model->getSalesDetails($idReceipts);
        $data['PaymentDetails'] = $model->getPaymentDetails($idReceipts);
        return view('Sale_details', $data);
    }

    public function downloadPDF($idReceipts)
    {
        $model = new salesModel();
        $data['ServiceDetails'] = $model->getSalesDetails1($idReceipts);

        $html = view('invoice_pdf', $data);

        // $mpdf = new \Mpdf\Mpdf();
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 11,
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

    public function cancelInvoice($idReceipts)
    {
        $model = new salesModel();
        $result = $model->duplicateInvoice($idReceipts);

        if ($result) {

            return redirect()->to(base_url('/viewServiceDetails/' . $idReceipts));
            // return redirect()->to('/viewServiceDetails/' . $idReceipts)->with('success', 'Invoice duplicated successfully');
        } else {
            return redirect()->to('/viewServiceDetails/' . $idReceipts)->with('error', 'Failed to duplicate invoice');
        }
    }





}