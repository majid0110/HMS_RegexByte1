<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceDetailsModel extends Model
{
    protected $table = 'invoicepaymentdetails';
    protected $primaryKey = 'idPayment';
    protected $allowedFields = ['value', 'idUser', 'date', 'timestamp', 'idAnullim', 'method', 'idPaymentMethod', 'exchange', 'nr_serial'];


    public function insertInvoicePayment($data)
    {
        $this->table = 'invoicepayment';
        $this->primaryKey = 'IdInvPay';
        $this->allowedFields = ['idReceipt', 'idPayment'];

        return $this->insert($data);
    }
}
