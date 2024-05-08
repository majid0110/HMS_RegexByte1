<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemsInventoryModel extends Model
{
    protected $table = 'itemsinventory';
    protected $primaryKey = 'idInventory';
    protected $allowedFields = ['idItem', 'inventory', 'idWarehouse'];

    public function updateInventory($idInventory, $inventory)
    {
        $this->set('inventory', $inventory)
            ->where('idInventory', $idInventory)
            ->update();
    }

    public function getRatioDataForServices($idArtMenus, $businessID)
    {

        $builder = $this->db->table('ratio');
        $builder->where('idArtMenu', $idArtMenus);
        $result = $builder->get()->getResultArray();

        return $result;

    }

    public function getRatio($idArtMenu, $idBusiness)
    {
        return $this->db->table('ratio')
            ->select('idItem, ratio')
            ->where('idArtMenu', $idArtMenu)
            ->where('idBusiness', $idBusiness)
            ->get()
            ->getResult();
    }

    public function subtractFromInventory($idItem, $quantity)
    {
        $this->db->table('itemsinventory')
            ->where('idItem', $idItem)
            ->set('inventory', 'inventory - ' . $quantity, FALSE)
            ->update();
    }


}
