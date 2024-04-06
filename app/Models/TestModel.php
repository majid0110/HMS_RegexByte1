<?php

namespace App\Models;

use CodeIgniter\Model;

class TestModel extends Model
{
    protected $table = 'labtest';
    protected $primaryKey = 'test_id';
    protected $allowedFields = ['testTypeId', 'fee', 'userId', 'businessId', 'hospitalCharges', 'clientId', 'appointmentId', 'labInvoice', 'CreatedAT'];




    public function saveTest($responseData)
    {
        //$this->db->table('labtest')->insert($data);

        $this->insert($responseData);
        return $this->db->insertID();
    }

    public function getLastLabNo($businessID)
    {
        $query = $this->select('labInvoice')
            ->where('businessID', $businessID)
            ->orderBy('test_id', 'DESC')
            ->limit(1)
            ->get();
        if ($query->getNumRows() > 0) {
            $result = $query->getRow();
            return $result->labInvoice;
        } else {
            return 0;
        }
    }

    public function getinvoiceNumber($businessID, $clientID, $appointmentID)
    {
        return $this->db->table($this->table)
            ->where('businessID', $businessID)
            ->where('clientId', $clientID)
            ->where('appointmentId', $appointmentID)
            ->orderBy('labInvoice', 'DESC')
            ->select('labInvoice')
            ->get()
            ->getRowArray()['labInvoice'] ?? null;
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

    // public function getReports($search = null, $userName = null, $clientName = null, $fromDate = null, $toDate = null)
    // {
    //     $builder = $this->db->table('labtest');
    //     $builder->join('client', 'client.idClient = labtest.clientId');
    //     $builder->join('users', 'users.ID = labtest.userId');
    //     $builder->select('labtest.*, client.client as clientName, users.fName as userName');

    //     if (!empty($search)) {
    //         $builder->groupStart()
    //             ->like('client.client', $search)
    //             ->orLike('users.fName', $search)
    //             ->orLike('labtest.CreatedAT', $search)
    //             ->groupEnd();
    //     }

    //     if (!empty($userName)) {
    //         $builder->where('users.ID', $userName);
    //     }

    //     if (!empty($clientName)) {
    //         $builder->where('client.client', $clientName);
    //     }

    //     if (!empty($fromDate) && !empty($toDate)) {
    //         $builder->where('labtest.CreatedAT >=', $fromDate)
    //             ->where('labtest.CreatedAT <=', $toDate);
    //     }

    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }
    public function getReports($search = null, $userName = null, $clientName = null, $fromDate = null, $toDate = null)
    {
        $builder = $this->db->table('labtest');
        $builder->join('client', 'client.idClient = labtest.clientId');
        $builder->join('users', 'users.ID = labtest.userId');
        $builder->select('labtest.*, client.client as clientName, users.fName as userName');

        // Add conditions based on search parameters
        if (!empty($search)) {
            $builder->groupStart()
                ->like('client.client', $search)
                ->orLike('users.fName', $search)
                ->orLike('labtest.CreatedAT', $search)
                ->groupEnd();
        }

        if (!empty($userName)) {
            $builder->where('users.fName', $userName);
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
    // //--------------------------------------------------------------------------
    // public function searchLabReports($search = null, $userName = null, $clientName = null, $fromDate = null, $toDate = null)
    // {
    //     $builder = $this->db->table('labtest');
    //     $builder->join('client', 'client.idClient = labtest.clientId');
    //     $builder->join('users', 'users.ID = labtest.userId');
    //     $builder->select('labtest.*, client.client as clientName, users.fName as userName');

    //     if (!empty ($search)) {
    //         $builder->groupStart()
    //             ->like('client.client', $search)
    //             ->orLike('users.fName', $search)
    //             ->orLike('labtest.CreatedAT', $search)
    //             ->groupEnd();
    //     }

    //     if (!empty ($userName)) {
    //         $builder->where('users.ID', $userName);
    //     }

    //     if (!empty ($clientName)) {
    //         $builder->where('client.client', $clientName);
    //     }

    //     if (!empty ($fromDate) && !empty ($toDate)) {
    //         $builder->where('labtest.CreatedAT >=', $fromDate)
    //             ->where('labtest.CreatedAT <=', $toDate);
    //     }

    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }

    public function getTotalHospitalFee()
    {
        $businessId = session()->get('businessID');
        $builder = $this->db->table('labtest');
        $builder->selectSum('hospitalCharges');
        $builder->where('businessId', $businessId);
        $result = $builder->get()->getRowArray();
        return $result['hospitalCharges'];
    }

    // public function getTotalLabFee()
    // {
    //     $businessId = session()->get('businessID');
    //     $builder = $this->db->table('labtest');
    //     $builder->selectSum('fee');
    //     $builder->where('businessId', $businessId);
    //     $result = $builder->get()->getRowArray();
    //     return $result['fee'];
    // }

    public function getTotalLabFee($clientName, $search, $userName, $fromDate, $toDate)
    {
        // $businessId = session()->get('businessID');
        $builder = $this->db->table('labtest');
        $builder->selectSum('fee');
        $builder->join('client', 'client.idClient = labtest.clientId');
        $builder->join('users', 'users.ID = labtest.userId');
        // $builder->where('businessId', $businessId);

        if (!empty($clientName)) {
            $builder->like('client.client', $clientName);
        }

        if (!empty($search)) {
            $builder->groupStart()
                ->like('client.client', $search)
                ->orLike('users.fName', $search)
                ->orLike('labtest.CreatedAT', $search)
                ->groupEnd();
        }

        if (!empty($userName)) {
            $builder->like('users.fName', $userName);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('labtest.CreatedAT >=', $fromDate)
                ->where('labtest.CreatedAT <=', $toDate);
        }

        $query = $builder->get();
        $result = $query->getRowArray();
        return $result['fee'] ?? 0;
    }


    // public function getTotalLabFee($userName = null, $fromDate = null, $toDate = null)
    // {
    //     $businessId = session()->get('businessID');
    //     $builder = $this->db->table('labtest');
    //     $builder->selectSum('fee');
    //     $builder->where('businessId', $businessId);

    //     if (!empty($userName)) {
    //         $builder->join('users', 'users.ID = labtest.userId');
    //         $builder->where('users.ID', $userName);
    //     }

    //     if (!empty($fromDate) && !empty($toDate)) {
    //         $builder->where('labtest.CreatedAT >=', $fromDate)
    //             ->where('labtest.CreatedAT <=', $toDate);
    //     }

    //     $result = $builder->get()->getRowArray();
    //     return $result['fee'];
    // }
    //-------------------------------------------------------Pagination
    public function searchLabReports($search = null, $userName = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $offset = 0)
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
            $builder->where('users.fName', $userName);
        }

        if (!empty($clientName)) {
            $builder->where('client.client', $clientName);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('labtest.CreatedAT >=', $fromDate)
                ->where('labtest.CreatedAT <=', $toDate);
        }

        $builder->limit($perPage, $offset);

        $query = $builder->get();
        return $query->getResultArray();
    }
    public function getPager($search = null, $userName = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $currentPage = 1)
    {
        $builder = $this->db->table('labtest');
        $builder->select('COUNT(*) as total');
        $builder->join('client', 'client.idClient = labtest.clientId');
        $builder->join('users', 'users.ID = labtest.userId');

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

        $totalQuery = $builder->get();
        $totalResult = $totalQuery->getRowArray();
        $total = isset($totalResult['total']) ? (int) $totalResult['total'] : 0;

        $pager = service('pager');
        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return $pagerLinks;
    }





}