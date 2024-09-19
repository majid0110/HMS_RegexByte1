<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseDetailsInvoice extends Model
{
    protected $table = 'purchaseinvoicedetail';
    protected $primaryKey = 'idInvoiceDetail';
    protected $allowedFields = [
        'idReceipts',
        'Nr',
        'idArtMenu',
        'Quantity',
        'Price',
        'actual_Price',
        'Sum',
        'idBusiness',
        'IdTax',
        'ValueTax',
        'idMag',
        'idItem',
        'name',
        'Discount'
    ];


}