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


    public function submitSummary()
    {
        $db = \Config\Database::connect();
        try {
            $invoice = new InvoiceModel();
            $invoiceDetailModel = new InvoiceDetailModel();

            $selectedTableId = $this->request->getPost('selectedTableId');
            $totalValue = $this->request->getPost('totalValue');

            $session = \Config\Services::session();
            $businessID = $session->get('businessID');
            $UserID = $session->get('ID');

            log_message('debug', 'Selected Table ID: ' . $selectedTableId);
            log_message('debug', 'Total Value: ' . $totalValue);

            $db->transBegin();

            $openInvoices = $invoice->where('idTable', $selectedTableId)
                ->where('isSummaryInvoice', 0)
                ->where('Status', 'open')
                ->orderBy('idReceipts', 'DESC')
                ->findAll();

            if (empty($openInvoices)) {
                throw new \Exception('No open invoices found for this table.');
            }

            $lastInvoiceNumberQuery = $invoice->select('invOrdNum')->orderBy('invOrdNum', 'DESC')->limit(1);
            $lastInvoiceNumberResult = $lastInvoiceNumberQuery->get();
            $lastInvoiceNumber = $lastInvoiceNumberResult->getRow();
            $newInvoiceNumber = $lastInvoiceNumber ? $lastInvoiceNumber->invOrdNum + 1 : 1;

            $lastInvoice = $openInvoices[0];
            $invoiceData = $lastInvoice;
            unset($invoiceData['idReceipts']);
            $invoiceData['Value'] = $totalValue;
            $invoiceData['isSummaryInvoice'] = 1;
            $invoiceData['invOrdNum'] = $newInvoiceNumber;
            $invoiceData['Status'] = 'closed';
            $invoiceData['idUser'] = $UserID;

            $invoice->insert($invoiceData);
            $newIdReceipt = $invoice->getInsertID();

            foreach ($openInvoices as $openInvoice) {
                $invoiceDetails = $invoiceDetailModel->where('idReceipts', $openInvoice['idReceipts'])->findAll();

                foreach ($invoiceDetails as $detail) {
                    $detail['idReceipts'] = $newIdReceipt;
                    unset($detail['idInvoiceDetail']);
                    $invoiceDetailModel->insert($detail);
                }

                $invoice->update($openInvoice['idReceipts'], ['Status' => 'closed']);
            }

            $paymentDetailsModel = new InvoiceDetailsModel();
            $paymentDetailsData = [
                'value' => $totalValue,
                'idUser' => $UserID,
                'idAnullim' => 0,
                'method' => $lastInvoice['paymentMethod'],
                'idPaymentMethod' => $lastInvoice['paymentMethod'],
                'exchange' => $lastInvoice['rate'],
                'nr_serial' => 0,
            ];
            $paymentDetailsModel->insert($paymentDetailsData);
            $idReceipt = $paymentDetailsModel->getInsertID();

            $InvoicePayment = [
                'idReceipt' => $newIdReceipt,
                'idPayment' => $idReceipt,
            ];
            $paymentDetailsModel->insertInvoicePayment($InvoicePayment);

            $TModel = new TablesModel();
            $TModel->updateStatus($selectedTableId, [
                'idUserActive' => $UserID,
                'booking_status' => 0
            ]);

            $db->transCommit();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Payment Successful',
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error creating summary invoice: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error creating summary invoice: ' . $e->getMessage()
            ]);
        }
    }



    // public function submitSummary()
    // {
    //     $db = \Config\Database::connect();
    //     try {
    //         $invoice = new InvoiceModel();
    //         $invoiceDetailModel = new InvoiceDetailModel();

    //         $selectedTableId = $this->request->getPost('selectedTableId');
    //         $totalValue = $this->request->getPost('totalValue');

    //         $session = \Config\Services::session();
    //         $businessID = $session->get('businessID');
    //         $UserID = $session->get('ID');

    //         log_message('debug', 'Selected Table ID: ' . $selectedTableId);
    //         log_message('debug', 'Total Value: ' . $totalValue);

    //         $db->transBegin();

    //         $lastInvoiceResult = $invoice->where('idTable', $selectedTableId)
    //             ->where('isSummaryInvoice', 0)
    //             ->orderBy('idReceipts', 'DESC')
    //             ->limit(1)
    //             ->get();

    //         if ($lastInvoiceResult === false) {
    //             throw new \Exception('Error fetching last invoice for this table.');
    //         }

    //         $lastInvoice = $lastInvoiceResult->getRow();

    //         if (!$lastInvoice) {
    //             throw new \Exception('No previous invoice found for this table.');
    //         }

    //         $lastInvoiceNumberQuery = $invoice->select('invOrdNum')->orderBy('invOrdNum', 'DESC')->limit(1);
    //         $lastInvoiceNumberResult = $lastInvoiceNumberQuery->get();

    //         if ($lastInvoiceNumberResult === false) {
    //             throw new \Exception('Error fetching last invoice number.');
    //         }

    //         $lastInvoiceNumber = $lastInvoiceNumberResult->getRow();
    //         $newInvoiceNumber = $lastInvoiceNumber ? $lastInvoiceNumber->invOrdNum + 1 : 1;

    //         $invoiceData = (array) $lastInvoice;
    //         $invoiceData['Value'] = $totalValue;
    //         $invoiceData['isSummaryInvoice'] = 1;
    //         $invoiceData['invOrdNum'] = $newInvoiceNumber;
    //         $invoiceData['Status'] = 'closed';
    //         $invoiceData['idUser'] = $UserID;

    //         $invoice->insert($invoiceData);
    //         $idPayment = $invoice->getInsertID();

    //         $paymentDetailsModel = new InvoiceDetailsModel();
    //         $paymentDetailsData = [
    //             'value' => $totalValue,
    //             'idUser' => $UserID,
    //             'idAnullim' => 0,
    //             'method' => $lastInvoice->paymentMethod,
    //             'idPaymentMethod' => $lastInvoice->paymentMethod,
    //             'exchange' => $lastInvoice->rate,
    //             'nr_serial' => 0,
    //         ];
    //         $paymentDetailsModel->insert($paymentDetailsData);
    //         $idReceipt = $paymentDetailsModel->getInsertID();

    //         $InvoicePayment = [
    //             'idReceipt' => $idPayment,
    //             'idPayment' => $idReceipt,
    //         ];
    //         $paymentDetailsModel->insertInvoicePayment($InvoicePayment);

    //         $data = [
    //             'idUserActive' => $UserID,
    //             'booking_status' => 0
    //         ];
    //         $TModel = new TablesModel();
    //         $TModel->updateStatus($selectedTableId, $data);

    //         $db->transCommit();

    //         return $this->response->setJSON([
    //             'status' => 'success',
    //             // 'message' => 'Summary invoice created successfully',
    //             'message' => 'Payment Sucessful',
    //         ]);
    //     } catch (\Exception $e) {
    //         $db->transRollback();
    //         log_message('error', 'Error creating summary invoice: ' . $e->getMessage());
    //         return $this->response->setJSON([
    //             'status' => 'error',
    //             'message' => 'Error creating summary invoice: ' . $e->getMessage()
    //         ]);
    //     }
    // }

}