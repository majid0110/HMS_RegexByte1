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
    public function getInventoryId($idItem, $idWarehouse)
    {
        return $this->where('idItem', $idItem)
            ->where('idWarehouse', $idWarehouse)
            ->first();
    }
    public function getInventoryByItemId($idItem)
    {
        return $this->where('idItem', $idItem)->first();
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


    // public function getRatio($idArtMenu, $idBusiness)
    // {
    //     return $this->db->table('ratio')
    //         ->select('idItem, ratio')
    //         ->where('idArtMenu', $idArtMenu)
    //         ->where('idBusiness', $idBusiness)
    //         ->get()
    //         ->getResult();
    // }

    // public function subtractFromInventory($idItem, $quantity)
    // {
    //     $this->db->table('itemsinventory')
    //         ->where('idItem', $idItem)
    //         ->set('inventory', 'inventory - ' . $quantity, FALSE)
    //         ->update();
    // }


    public function subtractFromInventory($idArtMenu, $quantity, $businessID, $expiryDate)
    {
        $idItems = $this->getRatioData($idArtMenu, $businessID);
        $ratio = 1;

        foreach ($idItems as $idItem) {
            $inventorySubtract = $quantity * $ratio;

            log_message('debug', 'Updating inventory for item: ' . $idItem . ' with quantity: ' . $inventorySubtract);
            $this->db->table('itemsinventory')
                ->where('idItem', $idItem)
                ->set('inventory', 'inventory - ' . $inventorySubtract, FALSE)
                ->update();

            if ($this->isExpiryEnabled($businessID)) {

                $query = $this->db->table('itemsinventory')
                    ->select('idInventory')
                    ->where('idItem', $idItem)
                    ->get();

                if ($query->getNumRows() > 0) {
                    $idInventory = $query->getRow()->idInventory;


                    $this->db->table('itemsexpiry')
                        ->where('idInventory', $idInventory)
                        ->where('expiryDate', $expiryDate)
                        ->set('inventory', 'inventory - ' . $inventorySubtract, FALSE)
                        ->update();
                }
            }
        }
    }

    public function isExpiryEnabled($businessID)
    {
        $query = $this->db->table('config')
            ->select('isExpiry')
            ->where('businessID', $businessID)
            ->get();

        if ($query->getNumRows() > 0) {
            return $query->getRow()->isExpiry == 1;
        }
        return false;
    }

    // public function getRatio($idArtMenu, $idBusiness)
    // {
    //     return $this->db->table('ratio')
    //         ->select('idItem, ratio')
    //         ->where('idArtMenu', $idArtMenu)
    //         ->where('idBusiness', $idBusiness)
    //         ->get()
    //         ->getResult();
    // }

    public function getRatioData($idArtMenu, $idBusiness)
    {
        $query = $this->db->table('ratio')
            ->select('idItem')
            ->where('idArtMenu', $idArtMenu)
            ->where('idBusiness', $idBusiness)
            ->get();

        $result = $query->getResultArray();
        $idItems = [];

        foreach ($result as $row) {
            $idItems[] = $row['idItem'];
        }

        return $idItems;
    }

    // public function getRatioData($idArtMenu, $idBusiness)
    // {
    //     $query = $this->db->table('ratio')
    //         ->select('idItem')
    //         ->where('idArtMenu', $idArtMenu)
    //         ->where('idBusiness', $idBusiness)
    //         ->get();

    //     $result = $query->getResultArray();
    //     $idItems = array_column($result, 'idItem');

    //     return $idItems;
    // }


    public function deleteExpiry($expiryID)
    {
        $db = \Config\Database::connect();
        $db->table('itemsexpiry')->where('expiryID', $expiryID)->delete();
        return $db->affectedRows();
    }

    public function countInventoryByBusinessID($businessID)
    {
        $query = $this->db->table('itemsinventory')
            ->selectSum('itemsinventory.inventory', 'totalInventory')
            ->join('itemswarehouse', 'itemsinventory.idItem = itemswarehouse.idItem')
            ->where('itemswarehouse.idBusiness', $businessID)
            ->get();

        return $query->getRow()->totalInventory;
    }



    public function getExpiriesByItemId($idItem)
    {
        $query = $this->db->table('itemsinventory')
            ->select('idInventory')
            ->where('idItem', $idItem)
            ->get();

        if ($query->getNumRows() > 0) {
            $idInventory = $query->getRow()->idInventory;

            return $this->db->table('itemsexpiry')
                ->where('idInventory', $idInventory)
                ->get()
                ->getResultArray();
        }
    }

    // public function updateExpiry($expiryID, $data)
    // {
    //     $this->db->table('itemsexpiry')
    //         ->where('expiryID', $expiryID)
    //         ->update($data);
    // }

    // public function updateExpiry($idInventory, $expiryData)
    // {
    //     $db = \Config\Database::connect();
    //     $builder = $db->table('itemsexpiry');

    //     foreach ($expiryData as $expiryID => $data) {
    //         $record = [
    //             'idInventory' => $idInventory,
    //             'inventory' => $data['inventory'],
    //             'expiryDate' => $data['expiryDate'],
    //         ];
    //         $existingRecord = $builder->where('expiryID', $expiryID)->get()->getRowArray();
    //         if ($existingRecord) {
    //             $builder->where('expiryID', $expiryID)->update($record);
    //         } else {
    //             $builder->insert($record);
    //         }
    //     }
    // }

    public function insertExpiry($data)
    {
        $this->db->table('itemsexpiry')
            ->insert($data);
    }

    public function updateExpiry($expiryID, $expiryData)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('itemsexpiry');

        $builder->where('expiryID', $expiryID)
            ->update($expiryData);
    }

    public function expiryExists($idInventory, $expiryDate)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('itemsexpiry');

        return $builder->where('idInventory', $idInventory)
            ->where('expiryDate', $expiryDate)
            ->countAllResults() > 0;
    }


    public function updateExpiryByInventoryAndDate($idInventory, $expiryDate, $expiryData)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('itemsexpiry');

        $builder->where('idInventory', $idInventory)
            ->where('expiryDate', $expiryDate)
            ->update($expiryData);
    }


    public function getExpiryInventory($idItem, $expiryDate)
    {
        $db = \Config\Database::connect();
        $query = $db->table('itemsexpiry')
            ->select('expiryID, inventory')
            ->where('idItem', $idItem)
            ->where('expiryDate', $expiryDate)
            ->get();

        return $query->getRowArray();
    }

    public function findExpiryByInventoryAndDate($idInventory, $expiryDate)
    {
        $db = \Config\Database::connect();
        return $db->table('itemsexpiry')
            ->where('idInventory', $idInventory)
            ->where('expiryDate', $expiryDate)
            ->get()
            ->getFirstRow('array');
    }

    public function subtractFromInventoryByExpiry($expiryID, $quantity)
    {
        $db = \Config\Database::connect();
        $db->table('itemsexpiry')
            ->where('expiryID', $expiryID)
            ->set('inventory', 'inventory - ' . $quantity, false)
            ->update();
    }

    // public function getRatio($idArtMenu, $idBusiness) {
    //     return $this->db->table('ratio')
    //         ->select('idItem, ratio')
    //         ->where('idArtMenu', $idArtMenu)
    //         ->where('idBusiness', $idBusiness)
    //         ->get()
    //         ->getResult();
    // }

    // public function subtractFromInventory($idItem, $quantity) {
    //     $this->db->table($this->table)
    //         ->where('idItem', $idItem)
    //         ->set('inventory', 'inventory - ' . $quantity, FALSE)
    //         ->update();
    // }

    public function subtractFromExpiryInventory($idItem, $expiryDate, $quantity)
    {
        $this->db->table('itemsexpiry')
            ->where('idInventory', $idItem)
            ->where('expiryDate', $expiryDate)
            ->set('inventory', 'inventory - ' . $quantity, FALSE)
            ->update();
    }


}
