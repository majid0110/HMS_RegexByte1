<?php
namespace App\Models;

use CodeIgniter\Model;

class TablesModel extends Model
{
    protected $table = 'tables';
    protected $primaryKey = 'idTables';
    protected $allowedFields = [
        'name',
        'pozX',
        'pozY',
        'Status',
        'notes',
        'idBusiness',
        'Def',
        'idUserActive',
        'size',
        'idPoint_of_sale',
        'booking_status'
    ];

    public function updateStatus($id, $data)
    {
        return $this->db->table($this->table)
            ->where('idTables', $id)
            ->update($data);
    }

    public function getTables()
    {
        $businessId = session()->get('businessID');
        $builder = $this->db->table($this->table);
        $builder->where('idBusiness', $businessId);
        $builder->where('Status', 'Active');
        $builder->orderBy('idTables', 'DESC');
        $result = $builder->get()->getResultArray();

        return $result;
    }
}