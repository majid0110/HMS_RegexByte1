<?php

namespace App\Models;

use CodeIgniter\Model;

class LabModel extends Model
{
    protected $table = 'test_type';
    protected $primaryKey = 'testTypeId';
    protected $allowedFields = ['title', 'description', 'test_fee', 'userID', 'businessID', 'createdAt'];
    // protected $useTimestamps = true; 
    // protected $dateFormat = 'datetime';

    public function saveLabService($data)
    {
        return $this->insert($data);
    }

    public function getTestDetails()
    {
        return $this->db->table('test_type')
            ->select('*')
            ->get()
            ->getResultArray();
    }

    public function updateTest($testTypeId, $data)
    {
        $this->db->table('test_type')
            ->where('testTypeId', $testTypeId)
            ->update($data);
    }

    public function getTestType()
    {
        $query = $this->select('testTypeId, title, test_fee')->findAll();
        return $query;
    }



}