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
        'actual_Price',
        'Sum',
        'idBusiness',
        'IdTax',
        'ValueTax',
        'idMag',
        'name',
        'idSummaryInvoice',
        'Discount'
    ];

    public function updateItemInventory($idItem, $quantity)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('itemsinventory');

        $builder->set('inventory', 'inventory - ' . $quantity, false)
            ->where('idItem', $idItem)
            ->update();
    }

    public function getServicesByInvoice($idReceipts)
    {
        $db = \Config\Database::connect();
        return $db->table('invoicedetail')
            ->select('invoicedetail.*, artmenu.Name as serviceName')
            ->join('artmenu', 'invoicedetail.idArtMenu = artmenu.idArtMenu')
            ->where('invoicedetail.idReceipts', $idReceipts)
            ->get()
            ->getResultArray();
    }
    public function getIdItemByIdArtMenu($idArtMenu, $idBusiness)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ratio');

        return $builder->select('idItem, ratio')
            ->where('idArtMenu', $idArtMenu)
            ->where('idBusiness', $idBusiness)
            ->get()
            ->getRowArray();
    }


}
