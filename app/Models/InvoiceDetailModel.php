<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceDetailModel extends Model
{
    protected $table = 'invoicedetail';
    protected $primaryKey = 'idInvoiceDetail';
    protected $allowedFields = [
        'idReceipts',
        'Nr',
        'idArtMenu',
        'Quantity',
        'Price',
        'Sum',
        'idBusiness',
        'IdTax',
        'ValueTax',
        'idMag',
        'name',
        'idSummaryInvoice',
        'Discount'
    ];
}
