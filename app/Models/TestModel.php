<?php

namespace App\Models;

use CodeIgniter\Model;

class TestModel extends Model
{
    protected $table = 'labtest';
    protected $primaryKey = 'test_id';
    protected $allowedFields = ['testTypeId', 'fee', 'userId', 'businessId', 'hospitalCharges', 'clientId', 'appointmentId', 'CreatedAT'];




    public function saveTest($responseData)
    {
        //$this->db->table('labtest')->insert($data);

        $this->insert($responseData);
        return $this->db->insertID();
    }


    public function getTestsWithDetails()
    {
        return $this->db->table('labtest')
            ->join('client', 'client.idClient = labtest.clientId')
            ->join('users', 'users.ID = labtest.userId')
            ->select('labtest.*, client.client as clientName, users.fName as userName')
            ->get()
            ->getResultArray();
    }

    public function TestReports()
    {
        return $this->db->table('labtest')
            ->join('client', 'client.idClient = labtest.clientId')
            ->join('users', 'users.ID = labtest.userId')
            ->select('labtest.*, client.client as clientName, users.fName as userName')
            ->get()
            ->getResultArray();
    }

    public function getReports($search = null, $userName = null, $clientName = null, $fromDate = null, $toDate = null)
    {
        $builder = $this->db->table('labtest');
        $builder->join('client', 'client.idClient = labtest.clientId');
        $builder->join('users', 'users.ID = labtest.userId');
        $builder->select('labtest.*, client.client as clientName, users.fName as userName');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('client.client', $search)
                ->orLike('users.fName', $search)
                ->orLike('labtest.CreatedAT', $search)
                ->groupEnd();
        }

        if (!empty($userName)) {
            $builder->where('users.ID', $userName);
        }

        if (!empty($clientName)) {
            $builder->where('client.client', $clientName);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('labtest.CreatedAT >=', $fromDate)
                ->where('labtest.CreatedAT <=', $toDate);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }


}