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

    public function get_Supplier($idSupplier)
    {
        return $this->find($idSupplier);
    }

    public function deleteSupplier($id)
    {
        return $this->where('idSupplier', $id)->delete();
    }

    public function getSupplierAge($businessID, $id)
    {
        return $this->db->table($this->table)
            ->where('idBusiness', $businessID)
            ->where('idSupplier', $id)
            ->select('age')
            ->get()
            ->getRowArray()['age'] ?? null;
    }

    public function getsupplierGender($businessID, $clientID)
    {
        return $this->db->table($this->table)
            ->where('idBusiness', $businessID)
            ->where('idClient', $clientID)
            ->select('gender')
            ->get()
            ->getRowArray()['gender'] ?? null;
    }

    public function getsupplierContact($businessID, $id)
    {
        return $this->db->table($this->table)
            ->where('idBusiness', $businessID)
            ->where('idSupplier', $id)
            ->select('contact')
            ->get()
            ->getRowArray()['contact'] ?? null;
    }

    public function getSupplierNames()
    {
        $businessId = session()->get('businessID');
        return $this->select('idSupplier, supplier, contact')->where('status', 'Active')->where('idBusiness', $businessId)->findAll();
    }

}
