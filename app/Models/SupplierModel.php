<?php
namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'idSupplier';

    protected $allowedFields = [
        'supplier',
        'contact',
        'notes',
        'idBusiness',
        'address',
        'cnic',
        'city',
        'status'
    ];

    protected $useTimestamps = false;

    public function getSuppliers($filters = [])
    {
        $builder = $this->db->table('supplier')
            ->select('*');
        return $builder->get()->getResultArray();
    }
}
