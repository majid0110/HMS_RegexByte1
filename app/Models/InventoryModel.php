<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table = 'itemsinventory';
    protected $primaryKey = 'idInventory';
    protected $allowedFields = ['idItem', 'inventory', 'idWarehouse'];

    public function getInventoryByItem($idItem)
    {
        return $this->where('idItem', $idItem)->first();
    }

    public function updateInventory($idItem, $newInventory)
    {
        return $this->where('idItem', $idItem)
            ->set('inventory', $newInventory)
            ->update();
    }

}
