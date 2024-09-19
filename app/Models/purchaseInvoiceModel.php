<?php

namespace App\Models;

use CodeIgniter\Model;

class purchaseInvoiceModel extends Model
{
    protected $table = 'purchase_invoices';
    protected $primaryKey = 'idReceipts';
    protected $allowedFields = [
        'idSupplier',
        'Value',
        'actual_Value',
        'Date',
        'Time',
        'Notes',
        'idWarehouse',
        'idUser',
        'Status',
        'idBusiness',
        'idCancellation',
        'invOrdNum',
        'FIC',
        'ValueTVSH',
        'idCurrency',
        'rate',
        'paymentMethod',
        'timeStamp',
        'idPoint_of_sale',
        'isImport',
        'Contract',
        'transporterId',
        'invoice_period_start_date',
        'invoice_period_end_date',
        'invoiceType',
        'InvoiceNotes'
    ];

    public function insertPurchaseInvoice($data)
    {
        return $this->insert($data);
    }

    public function getPurchaseInvoiceNumber($businessID, $idPayment)
    {
        return $this->db->table($this->table)
            ->where('idBusiness', $businessID)
            ->where('idReceipts', $idPayment)
            ->select('invOrdNum')
            ->get()
            ->getRowArray()['invOrdNum'] ?? null;
    }

}
