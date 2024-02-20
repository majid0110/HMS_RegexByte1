<?php

namespace App\Controllers;

use CodeIgniter\Controller;


use App\Models\InvoiceDetailModel;
use App\Models\ClientModel;
use App\Models\InvoiceModel;
use App\Models\InvoiceDetailsModel;
use App\Models\salesModel;
use Mpdf\Mpdf;

class SalesController extends Controller
{

    //-------------------------------------------------------------------------------------------------------------------------
//                                                 Returning Views
//-------------------------------------------------------------------------------------------------------------------------

    public function sales_form()
    {
        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();


        $sales = new salesModel();
        $data['payments'] = $sales->getpayment();
        $data['currencies'] = $sales->getCurrancy();
        $data['services'] = $sales->getServices();
        $data['categories'] = $sales->getCategories();

        return view('sales_form.php', $data);
    }

    public function Sales_table()
    {
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
    //         $clientId = $this->request->getPost('clientName');
    //         $exchange = $this->request->getPost('exchange');
    //         $currency = $this->request->getPost('currency');
    //         $paymentMethod = $this->request->getPost('paymentMethodName');
    //         $paymentMethodID = $this->request->getPost('paymentMethodId');
    //         $totalFee = $this->request->getPost('totalFee');
    //         $services = $this->request->getPost('services');

    //         $session = \Config\Services::session();
    //         $businessID = $session->get('businessID');
    //         $UserID = $session->get('ID');
    //         $clientId = $this->request->getPost('clientId');

    //         $totalFee = 0;
    //         foreach ($services as $service) {
    //             $totalFee += $service['fee'];
    //         }

    //         $lastInvoiceNumber = $invoice->select('invOrdNum')->orderBy('invOrdNum', 'DESC')->limit(1)->first();
    //         $newInvoiceNumber = $lastInvoiceNumber ? $lastInvoiceNumber['invOrdNum'] + 1 : 1;

    //         $db->transBegin();
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

    //         // Output JavaScript code to log $invoiceData to the console
    //         // echo "<script>console.log(" . json_encode($invoiceData) . ");</script>";
    //         $invoice->insertInvoice($invoiceData);
    //         $idPayment = $invoice->getInsertID();


    //         foreach ($services as $service) {
    //             $quantity = 1;
    //             $sum = $quantity * $service['fee'];
    //             $serviceData = [
    //                 'idReceipts' => $invoice->getInsertID(),
    //                 'Nr' => 0,
    //                 'idArtMenu' => $service['serviceTypeId'],
    //                 'Quantity' => $quantity,
    //                 'Price' => $service['fee'],
    //                 'Sum' => $sum,
    //                 'idBusiness' => $businessID,
    //                 'IdTax' => 1,
    //                 'ValueTax' => 0,
    //                 'idMag' => 1,
    //                 'name' => $service['serviceName'],
    //                 'idSummaryInvoice' => 0,
    //                 'Discount' => 0
    //             ];
    //             $invoiceDetailModel->insert($serviceData);
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

    //         $paymentDetailsModel = new InvoiceDetailsModel();
    //         $paymentDetailsModel->insertInvoicePayment([
    //             'idReceipt' => $idPayment,
    //             'idPayment' => $idReceipt,
    //         ]);

    //         $db->transCommit();

    //         return $this->response->setJSON(['status' => 'success', 'message' => 'Data inserted successfully']);

    //     } catch (\Exception $e) {
    //         $db->transRollback();
    //         log_message('error', 'Error retrieving data: ' . $e->getMessage());
    //         return $this->response->setJSON(['error' => 'Error retrieving data.', $e->getMessage()]);
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
                    $totalFee += $service['fee'];
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
            foreach ($services as $service) {
                $quantity = 1;
                $sum = $quantity * $service['fee'];
                $serviceData = [
                    'idReceipts' => $invoice->getInsertID(),
                    'Nr' => 0,
                    'idArtMenu' => $service['serviceTypeId'],
                    'Quantity' => $quantity,
                    'Price' => $service['fee'],
                    'Sum' => $sum,
                    'idBusiness' => $businessID,
                    'IdTax' => 1,
                    'ValueTax' => 0,
                    'idMag' => 1,
                    'name' => $service['serviceName'],
                    'idSummaryInvoice' => 0,
                    'Discount' => 0,
                ];
                $invoiceDetailModel->insert($serviceData);
            }
            $invoiceDetailModel->insert($serviceData);
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
            $paymentDetailsModel = new InvoiceDetailsModel();
            $paymentDetailsModel->insertInvoicePayment([
                'idReceipt' => $idPayment,
                'idPayment' => $idReceipt,
            ]);
            $db->transCommit();
            $mpdf = new Mpdf();
            $pdfContent = view('pdf_invoice', [
                'invoiceData' => $invoiceData,
                'services' => $services,
                'paymentDetailsData' => $paymentDetailsData,
                'clientName' => $clientName,
                'currencyName' => $currencyName,
                'paymentMethodName' => $paymentMethodName,
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
        return view('Sale_details', $data);
    }

    // Assuming this is part of your SalesController
    // public function deleteService($idReceipts)
    // {
    //     $model = new salesModel();
    //     $result = $model->updateServiceToZero($idReceipts);
    //     sleep(20);
    //     return redirect()->to(base_url("/Sales_table"));
    //     // if ($result) {
    //     //     return redirect()->to(base_url("/Sales_table"));
    //     // } else {
    //     //     return redirect()->back()->with('error', 'Error deleting service');
    //     // }
    // }
    public function deleteService($idReceipts)
    {
        $model = new salesModel();

        // Add your logic to update values to zero
        $result = $model->updateServiceToZero($idReceipts);

        if ($result) {
            // Successful deletion
            return $this->response->setJSON(['success' => true]);
        } else {
            // Error in deletion
            return $this->response->setJSON(['success' => false, 'error' => 'Error message']);
        }
    }


}