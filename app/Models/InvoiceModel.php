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
}
