<?php
namespace App\Models;

use CodeIgniter\Model;


class ClientModel extends Model
{

    protected $table = 'client';
    protected $primaryKey = 'idClient';
    protected $allowedFields = ['client', 'contact', 'email', 'notes', 'idBusiness', 'Def', 'status', 'CNIC', 'address', 'city', 'state', 'code', 'identification_type', 'limitExpense', 'discount', 'mainClient'];

    public function saveClient($data)
    {
        return $this->insert($data);
    }

    public function getclientprofile()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        return $this->db->table('client')
            ->where('idBusiness', $businessID)
            ->get()
            ->getResultArray();
    }

    public function deleteClient($idClient)
    {
        return $this->where('idClient', $idClient)
            ->delete();
    }

    public function resetMainClients()
    {
        $this->db->table('client')
            ->where('mainClient', 1)
            ->update(['mainClient' => 0]);
    }

    public function getDoctorByID($id)
    {
        return $this->db->table('doctorprofile')->where('DoctorID', $id)->get()->getRowArray();
    }

    public function getClientNames()
    {
        return $this->select('idClient, client')->findAll();
    }

    public function hasBookings($idClient)
    {
        return $this->db->table('appointment')
            ->where('clientID', $idClient)
            ->countAllResults() > 0;
    }

    public function countClientsByBusinessID($businessID)
    {
        return $this->db->table('client')->where('idBusiness', $businessID)->countAllResults();
    }

    public function getclientprofileByID($idClient)
    {
        return $this->db->table('client')
            ->where('idClient', $idClient)
            ->get()
            ->getRowArray();
    }

    public function updateClient($idClient, $data)
    {
        return $this->where('idClient', $idClient)->set($data)->update();
    }


}

