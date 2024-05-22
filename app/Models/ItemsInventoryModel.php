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

    public function changeInventory($idItem, $data)
    {
        $existingInventory = $this->where('idItem', $idItem)
            ->where('idWarehouse', $data['idWarehouse'])
            ->first();

        if ($existingInventory) {
            $this->update($existingInventory['idInventory'], $data);
        } else {
            $this->insert($data);
        }
    }

    public function getInventoryByItemId($idItem)
    {
        return $this->where('idItem', $idItem)->first();
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

    public function getExpiriesByInventoryId($idInventory)
    {
        return $this->db->table('itemsexpiry')
            ->where('idInventory', $idInventory)
            ->get()
            ->getResultArray();
    }

    // public function updateExpiry($expiryID, $data)
    // {
    //     $this->db->table('itemsexpiry')
    //         ->where('expiryID', $expiryID)
    //         ->update($data);
    // }

    public function updateExpiry($idInventory, $expiryData)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('itemsexpiry');

        foreach ($expiryData as $expiryID => $data) {
            $record = [
                'idInventory' => $idInventory,
                'inventory' => $data['inventory'],
                'expiryDate' => $data['expiryDate'],
            ];
            $existingRecord = $builder->where('expiryID', $expiryID)->get()->getRowArray();
            if ($existingRecord) {
                $builder->where('expiryID', $expiryID)->update($record);
            } else {
                $builder->insert($record);
            }
        }
    }


}
