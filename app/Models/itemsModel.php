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
        'Inventory',
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

    // public function getitem()
    // {
    //     $builder = $this->db->table('itemswarehouse');
    //     return $builder->join('units', 'units.idUnit = itemswarehouse.Unit')
    //         ->select('itemswarehouse.*,units.name')
    //         ->get()
    //         ->getResultArray();
    // }
    // public function getItems() // Updated method name
    // {
    //     $builder = $this->db->table('itemswarehouse');
    //     return $builder->join('units', 'units.idUnit = itemswarehouse.Unit')
    //         ->select('itemswarehouse.*, units.name')
    //         ->get()
    //         ->getResultArray();
    // }

    public function getItems()
    {
        $builder = $this->db->table('itemswarehouse');
        $result = $builder->join('units', 'units.idUnit = itemswarehouse.Unit')
            ->select('itemswarehouse.*, units.name as unit_name') // Include the 'unit_name' field
            ->get()
            ->getResultArray();

        return $result;
    }

    public function getCatartItems()
    {
        $builder = $this->db->table('catart');
        $result = $builder->get()->getResultArray();

        return $result;
    }

    public function insertCatart($data)
    {
        return $this->db->table('catart')->insert($data);
    }

    // public function getSectors()
    // {
    //     return $this->db->table('sectors')
    //         ->select('idSector, name')
    //         ->get()
    //         ->getResultArray();
    // }

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
        $this->db->table('itemswarehouse')->insert($data);
        return $this->db->insertID();
    }

    public function insertItemInventory($formDataInventory)
    {
        return $this->db->table('itemsinventory')->insert($formDataInventory);
    }


}
