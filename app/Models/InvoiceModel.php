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

    public function getinvoiceNumber($businessID, $idPayment)
    {
        return $this->db->table($this->table)
            ->where('idBusiness', $businessID)
            ->where('idReceipts', $idPayment)
            ->select('invOrdNum')
            ->get()
            ->getRowArray()['invOrdNum'] ?? null;
    }
}
