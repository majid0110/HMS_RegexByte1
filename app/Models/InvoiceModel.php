<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'idReceipts';

    protected $allowedFields = [
        'idClient',
        'Value',
        'actual_Value',
        'idTable',
        'idUser',
        'Status',
        'serial_number',
        'idBusiness',
        'idCancellation',
        'invOrdNum',
        'selfissue',
        'FIC',
        'ValueTVSH',
        'idCurrency',
        'rate',
        'paymentMethod',
        'closeShift',
        'isSummaryInvoice',
        'seial_nr',
        'idPoint_of_sale',
        'imported_invoice_number',
        'isExport',
        'isReverseCharge',
        'Contract',
        'deliveryid',
        'invoice_period_start_date',
        'invoice_period_end_date',
        'filename',
        'dokumenti',
        'lloji_fatures_id',
        'InvoiceNotes',
        'Notes',
    ];

    public function insertInvoice($data)
    {
        return $this->insert($data);
    }
    public function getSalesDetails($idReceipts)
    {
        return $this->db->table('salesdetails')->where('idReceipts', $idReceipts)->get()->getResultArray();
    }

    // public function insertInvoiceDetail($data)
    // {
    //     return $this->db->table('invoicedetail')->insert($data);
    // }
    public function insertInvoice1($data)
    {
        $this->insert($data);
        return $this->insertID();
    }

    public function getInvoicePaymentsByReceiptId($idReceipts)
    {
        return $this->db->table('invoicepayment')
            ->where('idReceipt', $idReceipts)
            ->get()
            ->getResult();
    }

    public function getLatestInvoice()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        return $this->db->table('invoices')
            ->orderBy('invOrdNum', 'DESC')
            ->where('idBusiness', $businessID)
            ->limit(1)
            ->get()
            ->getRowArray();
    }

    public function getPaymentDetailsByReceiptId($idReceipts)
    {
        return $this->db->table('invoicepaymentdetails')
            ->join('invoicepayment', 'invoicepayment.idPayment = invoicepaymentdetails.idPayment')
            ->where('invoicepayment.idReceipt', $idReceipts)
            ->get()
            ->getResult();
    }

    public function getPaymentDetailsById($idPayment)
    {
        return $this->db->table('invoicepaymentdetails')
            ->where('idPayment', $idPayment)
            ->get()
            ->getResult();
    }

    public function insertPaymentDetail($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('invoicepaymentdetails');
        $builder->insert($data);
        return $this->insertID();
    }

    public function insertInvoicePayment($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('invoicepayment');
        return $builder->insert($data);
    }

    public function insertInvoiceReference($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('invoicerefrences');
        return $builder->insert($data);
    }

    public function insertInvoiceDetail($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('invoicedetail');
        return $builder->insert($data);
    }
    public function getInvoiceDetailsByReceiptId($idReceipts)
    {
        return $this->db->table('invoicedetail')
            ->where('idReceipts', $idReceipts)
            ->get()
            ->getResult();
    }

    public function getinvoiceNumber($businessID, $idPayment)
    {
        return $this->db->table($this->table)
            ->where('idBusiness', $businessID)
            ->where('idReceipts', $idPayment)
            ->select('invOrdNum')
            ->get()
            ->getRowArray()['invOrdNum'] ?? null;
    }

    // public function updateItemInventory($idItem, $quantity)
    // {
    //     $builder = $this->db->table('itemsinventory');
    //     $builder->set('inventory', "inventory - $quantity", false); // Subtract $quantity from inventory column
    //     $builder->where('idItem', $idItem);
    //     $builder->update();
    // }

    public function updateItemInventory($idItem, $quantity)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('itemsinventory');

        // First, fetch the current inventory value
        $currentInventory = $builder->select('inventory')
            ->where('idItem', $idItem)
            ->get()
            ->getRowArray();

        if ($currentInventory) {
            $newInventory = $currentInventory['inventory'] - $quantity;

            // Then, update the inventory with the new value
            $builder->set('inventory', $newInventory)
                ->where('idItem', $idItem)
                ->update();
        }
    }

    public function getInvoiceById($idReceipts)
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        $invoice = $this->db->table('invoices')
            ->where('idReceipts', $idReceipts)
            ->where('idBusiness', $businessID)
            ->get()
            ->getRow();

        if ($invoice) {
            $payments = $this->db->table('invoicepaymentdetails')
                ->selectSum('invoicepaymentdetails.value', 'totalPaid')
                ->join('invoicepayment', 'invoicepayment.idPayment = invoicepaymentdetails.idPayment')
                ->where('invoicepayment.idReceipt', $invoice->idReceipts)
                ->get()
                ->getRow();

            $invoice->totalPaid = $payments->totalPaid ?? 0;
        }

        return $invoice;
    }

    public function updateInvoiceStatus($idReceipts, $status)
    {
        $this->db->table($this->table)
            ->where('idReceipts', $idReceipts)
            ->update(['status' => $status]);
    }

    public function getInvoices($tableId)
    {
        return $this->db->table('invoices')
            ->select('client.client as client, invoices.Value as value, invoices.ValueTVSH as Tax, users.fName as user, invoices.invOrdNum as InvoiceOrder, invoices.idTable as Table')
            ->join('client', 'client.idClient = invoices.idClient')
            ->join('users', 'users.ID = invoices.idUser')
            ->where('invoices.idTable', $tableId)
            ->where('invoices.Status', 'open')
            ->get()
            ->getResult();
    }

    public function getInvoiceData($idReceipts)
    {
        return $this->find($idReceipts);
    }

    public function getPaymentDetails($idReceipts)
    {
        $db = \Config\Database::connect();
        return $db->table('invoicepayment')
            ->join('invoicepaymentdetails', 'invoicepayment.idPayment = invoicepaymentdetails.idPayment')
            ->where('invoicepayment.idReceipt', $idReceipts)
            ->get()
            ->getRowArray();
    }

    public function getPaymentMethodName($idPayment)
    {
        return $this->db->table('paymentmethods')
            ->where('idPaymentMethods', $idPayment)
            ->select('Method')
            ->get()
            ->getRowArray()['Method'] ?? null;
    }

    public function getCurrencyName($idCurrency)
    {
        return $this->db->table('currency')
            ->where('id', $idCurrency)
            ->select('Currency')
            ->get()
            ->getRowArray()['Currency'] ?? null;
    }

    public function getWeeklySalesData($businessID)
    {
        return $this->select("DATE_FORMAT(Date, '%Y-%m-%d') as label, SUM(Value) as total")
            ->where('idBusiness', $businessID)
            ->where('WEEKDAY(Date) >=', 0)
            ->where('WEEKDAY(Date) <=', 6)
            ->where('YEARWEEK(Date, 1) = YEARWEEK(CURDATE(), 1)')
            ->groupBy('label')
            ->orderBy('Date')
            ->findAll();
    }

    public function getMonthlySalesData($businessID)
    {
        return $this->select("DATE_FORMAT(Date, '%Y-%m-01') as label, SUM(Value) as total")
            ->where('idBusiness', $businessID)
            ->where('Date >=', date('Y-m-d', strtotime('-12 months')))
            ->groupBy('label')
            ->orderBy('Date')
            ->findAll();
    }

    public function getYearlySalesData($businessID)
    {
        return $this->select("DATE_FORMAT(Date, '%Y-01-01') as label, SUM(Value) as total")
            ->where('idBusiness', $businessID)
            ->where('Date >=', date('Y-m-d', strtotime('-5 years')))
            ->groupBy('label')
            ->orderBy('Date')
            ->findAll();
    }

    public function getMonthlySalesFees($businessID)
    {
        $currentYear = date('Y');

        $builder = $this->db->table($this->table);
        $builder->select("
            MONTH(Date) as month,
            SUM(Value) as total
        ");
        $builder->where('idBusiness', $businessID);
        $builder->where('YEAR(Date)', $currentYear);
        $builder->where('Status', 'closed');
        $builder->where('isSummaryInvoice', 0);
        $builder->groupBy('MONTH(Date)');
        $builder->orderBy('MONTH(Date)', 'ASC');

        $query = $builder->get();
        $results = $query->getResultArray();

        $monthlyData = array_fill(1, 12, ['month' => 0, 'total' => 0]);

        foreach ($results as $row) {
            $monthlyData[$row['month']] = $row;
        }

        foreach ($monthlyData as $month => &$data) {
            if ($data['month'] === 0) {
                $data['month'] = $month;
            }
        }

        return array_values($monthlyData);
    }

}
