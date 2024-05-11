<?php
namespace App\Models;

use CodeIgniter\Model;

class itemsModel extends Model
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

    public function getServices()
    {
        $builder = $this->db->table('artmenu');
        return $builder->join('units', 'units.idUnit = artmenu.idUnit')
            ->select('artmenu.*,units.name')
            ->get()
            ->getResultArray();
    }
    public function getIdWarehouse()
    {
        return $this->db->table('warehouse')
            ->select('idWarehouse, name')
            ->get()
            ->getResultArray();
    }
    public function deletecat($idCatArt)
    {
        return $this->db->table('catart')
            ->where('idCatArt', $idCatArt)
            ->delete();
    }

    public function deleteSector($idSector)
    {
        return $this->db->table('sectors')
            ->where('idSector', $idSector)
            ->delete();
    }

    public function getSector($idSector)
    {
        return $this->db->table('sectors')
            ->select('*')
            ->where('idSector', $idSector)
            ->get()
            ->getRowArray();
    }
    public function deleteitem($idItem)
    {
        return $this->where('idItem', $idItem)->delete();
    }

    public function getItems()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        $builder = $this->db->table('itemswarehouse');
        $result = $builder->join('units', 'units.idUnit = itemswarehouse.Unit')
            ->select('itemswarehouse.*, units.name as unit_name')
            ->where('itemswarehouse.idBusiness', $businessID)
            ->orderBy('itemswarehouse.idItem', 'DESC')
            ->get()
            ->getResultArray();

        return $result;
    }

    // public function getItems()
    // {
    //     $builder = $this->db->table('itemswarehouse');
    //     $result = $builder->join('units', 'units.idUnit = itemswarehouse.Unit')
    //         ->select('itemswarehouse.*, units.name as unit_name')
    //         ->orderBy('itemswarehouse.idItem', 'DESC')
    //         ->get()
    //         ->getResultArray();

    //     return $result;
    // }

    public function getCatartItems()
    {
        $businessId = session()->get('businessID');
        $builder = $this->db->table('catart');
        $builder->where('idBusiness', $businessId);
        $builder->orderBy('idCatArt', 'DESC');
        $result = $builder->get()->getResultArray();

        return $result;
    }

    public function insertCatart($data)
    {
        return $this->db->table('catart')->insert($data);
    }

    public function getCatartCategory($idCatArt)
    {
        return $this->db->table('catart')
            ->where('idCatArt', $idCatArt)
            ->get()
            ->getRowArray();
    }

    public function updateCatart($idCatArt, $data)
    {
        return $this->db->table('catart')
            ->where('idCatArt', $idCatArt)
            ->update($data);
    }

    public function getSectors()
    {
        return $this->db->table('sectors')
            ->select('idSector, name, PrintOutput, notes, TVSH, idBusiness')
            ->get()
            ->getResultArray();
    }

    public function saveSector($data)
    {

        return $this->db->table('sectors')->insert($data);
    }

    public function insertItemWarehouse($data)
    {
        try {
            $this->db->table('itemswarehouse')->insert($data);
            return $this->db->insertID();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function insertItemInventory($formDataInventory)
    {
        try {
            $this->db->table('itemsinventory')->insert($formDataInventory);
            return $this->db->insertID();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function insertItemExpiry($ItemExpiry)
    {
        try {
            $this->db->table('itemsexpiry')->insert($ItemExpiry);
            return $this->db->insertID();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCategoryByName($categoryName, $businessID)
    {
        $result = $this->db->table('catart')
            ->select('*')
            ->where('name', $categoryName)
            ->where('idBusiness', $businessID)
            ->get()
            ->getRowArray();

        return $result ?: null;
    }

    public function insertCategory($newCategory)
    {
        $this->db->table('catart')->insert($newCategory);
        return $this->db->insertID();
    }

    public function getItemByCodeAndName($itemCode, $itemName, $businessID)
    {
        return $this->db->table('itemswarehouse')
            ->select('*')
            ->where('Code', $itemCode)
            ->where('Name', $itemName)
            ->where('idBusiness', $businessID)
            ->get()
            ->getRowArray();
    }


    public function insertOrUpdateItemInventory($formDataInventory)
    {
        $idItem = $formDataInventory['idItem'];
        $idWarehouse = $formDataInventory['idWarehouse'];
        $inventory = $formDataInventory['inventory'];

        $existingInventory = $this->db->table('itemsinventory')
            ->where('idItem', $idItem)
            ->where('idWarehouse', $idWarehouse)
            ->get()
            ->getRow();

        if ($existingInventory) {
            $this->db->table('itemsinventory')
                ->where('idItem', $idItem)
                ->where('idWarehouse', $idWarehouse)
                ->update(['inventory' => $inventory]);
        } else {
            $this->db->table('itemsinventory')->insert($formDataInventory);
        }
    }

    public function updateItemWarehouse($itemId, $formData)
    {
        $this->db->table('itemswarehouse')
            ->where('idItem', $itemId)
            ->update($formData);
    }


}
