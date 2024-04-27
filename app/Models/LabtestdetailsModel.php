<?php

namespace App\Models;

use CodeIgniter\Model;

class LabtestdetailsModel extends Model
{
    protected $table = 'labtestdetails';
    protected $primaryKey = 'labtest_id';
    protected $allowedFields = ['labTestID', 'testTypeID', 'fee', 'createdAT'];

    // public function savedetails($responseData)
    // {
    //     //$this->db->table('labtest')->insert($data);
    //     return $this->insert($responseData);
    // }

    public function getTestDetails($testId)
    {
        return $this->db->table('labtestdetails')
            ->join('test_type', 'test_type.testTypeId = labtestdetails.testTypeID')
            ->where('labTestID', $testId)
            ->select('labtestdetails.*, test_type.title as testTypeName')
            ->get()
            ->getResultArray();
    }

    // public function getlabdetails()
    // {
    //     return $this->db->table('labtestdetails')
    //         ->join('test_type', 'test_type.testTypeId = labtestdetails.testTypeID')
    //         ->select('labtestdetails.*, test_type.title as testTypeName')
    //         ->get()
    //         ->getResultArray();
    // }

    public function getTestTypes()
    {
        return $this->db->table('test_type')
            ->get()
            ->getResultArray();
    }


    public function getTotalLabDetailFee($clientName, $search, $testName, $fromDate, $toDate)
    {
        // $businessId = session()->get('businessID');
        $builder = $this->db->table('labtestdetails');
        $builder->selectSum('labtestdetails.fee');
        $builder->join('test_type', 'test_type.testTypeId = labtestdetails.testTypeID');
        $builder->join('labtest', 'labtest.test_id = labtestdetails.labTestID');
        $builder->join('client', 'client.idClient = labtest.clientId');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('test_type.title', $search)
                ->orLike('labtestdetails.fee', $search)
                ->orLike('client.client', $search)
                ->like('client.contact', $search)
                ->orLike('client.age', $search)
                ->orLike('client.gender', $search)
                ->like('client.state', $search)
                ->like('client.clientUniqueId', $search)
                ->orLike('labtest.CreatedAT', $search)
                ->groupEnd();
        }

        if (!empty($testName)) {
            $builder->where('test_type.title', $testName);
        }

        if (!empty($clientName)) {
            $builder->where('client.client', $clientName);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('labtest.CreatedAT >=', $fromDate)
                ->where('labtest.CreatedAT <=', $toDate);
        }

        $query = $builder->get();
        $result = $query->getRowArray();
        return $result['fee'] ?? 0;
    }
    public function searchLabReports($search = null, $testName = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $offset = 0)
    {
        $builder = $this->db->table('labtestdetails');
        $builder->join('test_type', 'test_type.testTypeId = labtestdetails.testTypeID');
        $builder->join('labtest', 'labtest.test_id = labtestdetails.labTestID');
        $builder->join('client', 'client.idClient = labtest.clientId');
        $builder->select('labtestdetails.*,client.clientUniqueId as unique, client.client as clientName, client.contact as contact, client.age as age, client.gender as gender, client.state as country ,test_type.title as testTypeName, labtest.CreatedAT');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('test_type.title', $search)
                ->orLike('labtestdetails.fee', $search)
                ->orLike('client.client', $search)
                ->like('client.contact', $search)
                ->orLike('client.age', $search)
                ->orLike('client.gender', $search)
                ->like('client.state', $search)
                ->like('client.clientUniqueId', $search)
                ->orLike('labtest.CreatedAT', $search)
                ->groupEnd();
        }

        if (!empty($testName)) {
            $builder->where('test_type.title', $testName);
        }

        if (!empty($clientName)) {
            $builder->where('client.client', $clientName);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('labtest.CreatedAT >=', $fromDate)
                ->where('labtest.CreatedAT <=', $toDate);
        }
        $builder->orderBy('labtest.CreatedAT', 'DESC');
        $builder->limit($perPage, $offset);

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getPager($search = null, $userName = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $currentPage = 1)
    {
        $builder = $this->db->table('labtestdetails');
        $builder->join('test_type', 'test_type.testTypeId = labtestdetails.testTypeID');
        $builder->join('labtest', 'labtest.test_id = labtestdetails.labTestID');
        $builder->join('client', 'client.idClient = labtest.clientId');
        $builder->select('labtestdetails.*,client.clientUniqueId as unique, client.client as clientName, client.contact as contact, client.age as age, client.gender as gender, client.state as country ,test_type.title as testTypeName, labtest.CreatedAT');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('test_type.title', $search)
                ->orLike('labtestdetails.fee', $search)
                ->orLike('client.client', $search)
                ->like('client.contact', $search)
                ->orLike('client.age', $search)
                ->orLike('client.gender', $search)
                ->like('client.state', $search)
                ->like('client.clientUniqueId', $search)
                ->orLike('labtest.CreatedAT', $search)
                ->groupEnd();
        }

        if (!empty($testName)) {
            $builder->where('test_type.title', $testName);
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

        // $total = isset($totalResult['total']) ? (int) $totalResult['total'] : 0;
        $total = $builder->countAllResults(false);

        $pager = service('pager');
        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return $pagerLinks;
    }

}