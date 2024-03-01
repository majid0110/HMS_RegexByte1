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


    public function deleteService($idArtMenu)
    {
        return $this->where('idArtMenu', $idArtMenu)->delete();
    }

    public function getitem()
    {
        $builder = $this->db->table('itemswarehouse');
        return $builder->join('units', 'units.idUnit = itemswarehouse.Unit')
            ->select('itemswarehouse.*,units.name')
            ->get()
            ->getResultArray();
    }
}
