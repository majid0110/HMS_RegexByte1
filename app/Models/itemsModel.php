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
}
