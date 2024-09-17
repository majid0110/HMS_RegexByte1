<?php
namespace App\Models;

use CodeIgniter\Model;

class PurchaseModel extends Model
{
    protected $table = 'itemswarehouse';
    protected $primaryKey = 'idItem';

    protected $allowedFields = [
        'Code',
        'Name',
        'Unit',
        'Cost',
        'Minimum',
        'Notes',
        'idBusiness',
        'idTAX',
        'idCategories',
        'barcode',
        'idWarehouse',
        'status',
        'characteristic1',
        'characteristic2',
        'isSendEmail',
        'isSendExpire',
    ];

    public function getitems()
    {
        $builder = $this->db->table('itemswarehouse')
            ->select('itemswarehouse.*, taxtype.value as tax_value, taxtype.tax_id as idTVSH')
            ->join('taxtype', 'itemswarehouse.idTAX = taxtype.tax_id', 'left')
            ->where('itemswarehouse.status', 'Active');

        // if ($enableService != 1) {
        //     $builder->where('artmenu.isService', 0);
        // }
        return $builder->get()->getResultArray();
    }

    public function getServiceExpiry($serviceId, $businessID)
    {
        $db = \Config\Database::connect();
        $ratioQuery = $db->table('ratio')
            ->select('idItem')
            ->where('idItem', $serviceId)
            ->where('idBusiness', $businessID)
            ->get();
        $ratioResult = $ratioQuery->getResultArray();
        if (empty($ratioResult)) {
            return [];
        }
        $idItem = array_column($ratioResult, 'idItem');
        $inventoryQuery = $db->table('itemsinventory')
            ->select('idInventory')
            ->whereIn('idItem', $idItem)
            ->get();
        $inventoryResult = $inventoryQuery->getResultArray();
        if (empty($inventoryResult)) {
            return [];
        }
        $idInventory = array_column($inventoryResult, 'idInventory');
        $expiryQuery = $db->table('itemsexpiry')
            ->select('expiryDate')
            ->whereIn('idInventory', $idInventory)
            ->get();
        return $expiryQuery->getResultArray();
    }

    public function getItemsByCategory($categoryId)
    {
        $builder = $this->db->table('itemswarehouse');
        $builder->select('itemswarehouse.*, taxtype.value as tax_value');
        $builder->join('taxtype', 'taxtype.tax_id = itemswarehouse.idTAX', 'left');

        if ($categoryId !== null) {
            $builder->where('itemswarehouse.idCategories', $categoryId);
        }

        // if ($enableService != 1) {
        //     $builder->where('isService', 0);
        // }

        return $builder->get()->getResultArray();
    }

    public function getSupplierNames()
    {
        $businessId = session()->get('businessID');
        return $this->db->table('supplier')
            ->select('*')
            ->where('status', 'Active')
            ->where('idBusiness', $businessId)
            ->get()
            ->getResult();
    }

    public function insertPurchaseInvoice($data)
    {
        return $this->db->table('purchase_invoices')->insert($data);
    }

}