<?php

namespace App\Models;

use CodeIgniter\Model;

class PurPaymentDetailsModel extends Model
{
    protected $table = 'purchaseinvoicepaymentdetails';
    protected $primaryKey = 'idPayment';
    protected $allowedFields = ['value', 'idUser', 'date', 'timestamp', 'idAnullim', 'method', 'idPaymentMethod', 'exchange', 'nr_serial'];

    // public function insertInvoicePayment($InvoicePayment)
    // {
    //     $this->table = 'invoicepayment';
    //     $this->primaryKey = 'IdInvPay';
    //     $this->allowedFields = ['idReceipt', 'idPayment'];

    //     return $this->insert($InvoicePayment);
    // }

    public function insertPurInvoicePayment($InvoicePayment)
    {
        $this->db->table('purchaseinvoicepayment')
            ->insert($InvoicePayment);
    }

    public function insertInvoicePayment($InvoicePayment)
    {
        $this->db->table('purchaseinvoicepayment')
            ->insert($InvoicePayment);
    }

    public function getPurchaseInvoiceById($idReceipts)
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        $invoice = $this->db->table('purchase_invoices')
            ->where('idReceipts', $idReceipts)
            ->where('idBusiness', $businessID)
            ->get()
            ->getRow();

        if ($invoice) {
            $payments = $this->db->table('purchaseinvoicepaymentdetails')
                ->selectSum('purchaseinvoicepaymentdetails.value', 'totalPaid')
                ->join('purchaseinvoicepayment', 'purchaseinvoicepayment.idPayment = purchaseinvoicepaymentdetails.idPayment')
                ->where('purchaseinvoicepayment.idReceipt', $invoice->idReceipts)
                ->get()
                ->getRow();

            $invoice->totalPaid = $payments->totalPaid ?? 0;
        }

        return $invoice;
    }

    public function updatePurchaseInvoiceStatus($idReceipts, $status)
    {
        $this->db->table('purchase_invoices')
            ->where('idReceipts', $idReceipts)
            ->update(['status' => $status]);
    }

}