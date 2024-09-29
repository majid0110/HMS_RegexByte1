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

    // public function getItem()
    // {
    //     return $this->select('idItem, Code, Name')->findAll();
    // }

    public function getItem()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        $builder = $this->db->table('itemswarehouse');
        $result = $builder
            // ->join('ratio', 'ratio.idItem = itemswarehouse.idItem')
            // ->join('itemsinventory', 'itemsinventory.idItem = itemswarehouse.idItem')
            ->select('*')
            ->where('idBusiness', $businessID)
            ->orderBy('idItem', 'DESC')
            ->get()
            ->getResultArray();

        return $result;
    }

    public function getItemByName($name)
    {
        return $this->where('Name', $name)->first();
    }
    public function countItemsByBusinessID($businessID)
    {
        return $this->db->table('itemswarehouse')->where('idBusiness', $businessID)->countAllResults();
    }

    public function getExpiringItems($businessID)
    {
        $builder = $this->db->table('itemswarehouse iw');
        $builder->select('iw.Name, iw.Code, ie.expiryDate');
        $builder->join('itemsinventory ii', 'iw.idItem = ii.idItem', 'inner');
        $builder->join('itemsexpiry ie', 'ii.idInventory = ie.idInventory', 'inner');
        $builder->where('iw.idBusiness', $businessID);
        $builder->where('ie.expiryDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH)');
        $builder->orderBy('ie.expiryDate', 'ASC');

        $result = $builder->get()->getResult();

        return $result;
    }

    public function getItemforedit($idArtMenu)
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        $builder = $this->db->table('itemswarehouse iw');
        $builder->select('iw.*, COALESCE(r.ratio, 0) AS ratio, IF(r.idItem IS NOT NULL, 1, 0) AS is_linked');
        $builder->join('ratio r', 'r.idItem = iw.idItem AND r.idArtMenu = ' . $idArtMenu, 'left');
        $builder->where('iw.idBusiness', $businessID);
        $builder->orderBy('iw.idItem', 'DESC');

        $result = $builder->get()->getResultArray();

        return $result;
    }

    // public function getItemforedit($idArtMenu)
    // {
    //     $session = \Config\Services::session();
    //     $businessID = $session->get('businessID');

    //     $builder = $this->db->table('itemswarehouse');
    //     $builder->select('itemswarehouse.*, r.ratio');
    //     $builder->join('ratio r', 'r.idItem = itemswarehouse.idItem AND r.idArtMenu = ' . $idArtMenu, 'left');
    //     $builder->where('itemswarehouse.idBusiness', $businessID);
    //     $builder->orderBy('itemswarehouse.idItem', 'DESC');

    //     $result = $builder->get()->getResultArray();

    //     $linkedItems = array_column($result, 'idItem', 'idItem');
    //     $ratios = array_column($result, 'ratio', 'idItem');

    //     return [
    //         'items' => $result,
    //         'linkedItems' => $linkedItems,
    //         'ratios' => $ratios,
    //     ];
    // }


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

    // public function getItems()
    // {
    //     $session = \Config\Services::session();
    //     $businessID = $session->get('businessID');

    //     $builder = $this->db->table('itemswarehouse');
    //     $result = $builder->join('units', 'units.idUnit = itemswarehouse.Unit')
    //         ->select('itemswarehouse.*, units.name as unit_name')
    //         ->where('itemswarehouse.idBusiness', $businessID)
    //         ->orderBy('itemswarehouse.idItem', 'DESC')
    //         ->get()
    //         ->getResultArray();

    //     return $result;
    // }

    public function getItems($perPage = 2, $currentPage = 1)
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        $offset = ($currentPage - 1) * $perPage;

        $builder = $this->db->table('itemswarehouse');
        $result = $builder->join('units', 'units.idUnit = itemswarehouse.Unit')
            ->join('itemsinventory', 'itemsinventory.idItem = itemswarehouse.idItem')
            ->select('itemswarehouse.*, units.name as unit_name, itemsinventory.inventory as inventory')
            ->where('itemswarehouse.idBusiness', $businessID)
            ->orderBy('itemswarehouse.idItem', 'DESC')
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();

        return $result;
    }

    public function getItemsCount()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        $builder = $this->db->table('itemswarehouse');
        $builder->where('itemswarehouse.idBusiness', $businessID);
        return $builder->countAllResults();
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

    public function getUnits($unit, $businessID)
    {
        $result = $this->db->table('units')
            ->select('*')
            ->where('name', $unit)
            ->where('idBusiness', $businessID)
            ->get()
            ->getRowArray();

        return $result ?: null;
    }

    public function insertUnit($newUnit)
    {
        $this->db->table('units')->insert($newUnit);
        return $this->db->insertID();
    }

    public function getUnitByName($unitName, $businessID)
    {
        return $this->db->table('units')
            ->where('name', $unitName)
            ->where('idBusiness', $businessID)
            ->get()
            ->getRowArray();
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

    public function isExpiry($businessID)
    {
        $builder = $this->db->table('config');
        $builder->select('isExpiry');
        $builder->where('businessID', $businessID);
        $query = $builder->get();
        $result = $query->getRowArray();
        return isset($result['isExpiry']) ? (int) $result['isExpiry'] : 0;
    }

    public function getItemsName()
    {
        return $this->db->table('itemswarehouse')
            ->select('idItem,Name')
            ->get()
            ->getResultArray();
    }

}
