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

}