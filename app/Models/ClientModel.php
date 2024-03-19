<?php
namespace App\Models;

use CodeIgniter\Model;


class ClientModel extends Model
{

    protected $table = 'client';
    protected $primaryKey = 'idClient';
    protected $allowedFields = ['client', 'contact', 'email', 'notes', 'idBusiness', 'Def', 'status', 'CNIC', 'address', 'city', 'state', 'code', 'gender', 'age', 'clientUniqueId', 'identification_type', 'limitExpense', 'discount', 'mainClient'];

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

    public function hasInvoices($idClient)
    {
        return $this->db->table('invoices')
            ->where('idClient', $idClient)
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

    public function getclientAge($businessID, $clientID)
    {
        return $this->db->table($this->table)
            ->where('idBusiness', $businessID)
            ->where('idClient', $clientID)
            ->select('age')
            ->get()
            ->getRowArray()['age'] ?? null;
    }

    public function getclientUnique($businessID, $clientID)
    {
        return $this->db->table($this->table)
            ->where('idBusiness', $businessID)
            ->where('idClient', $clientID)
            ->select('clientUniqueId')
            ->get()
            ->getRowArray()['clientUniqueId'] ?? null;
    }

    public function getclientGender($businessID, $clientID)
    {
        return $this->db->table($this->table)
            ->where('idBusiness', $businessID)
            ->where('idClient', $clientID)
            ->select('gender')
            ->get()
            ->getRowArray()['gender'] ?? null;
    }


}

