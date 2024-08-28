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
        $this->insert($data);
        return $this->insertID();
    }

    public function saveReportAttributes($data)
    {
        return $this->db->table('lab_report_attributes')->insert($data);
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
    public function deleteTest($test_id)
    {
        $this->db->table('labtestdetails')
            ->where('labTestID', $test_id)
            ->delete();

        $this->db->table('labtest')
            ->where('test_id', $test_id)
            ->delete();

    }

    public function saveLabReportAttribute($data)
    {
        $this->db->table('lab_report_attributes')->insert($data);
        return $this->db->insertID();
    }

    public function getLabTestDetails($test_id)
    {
        $labTestData = $this->db->table('labtest')
            ->select('labtest.*,users.fName as user, client.client as patient, client.age as patientage, client.gender as patientsex,client.clientUniqueId as MR, doctorprofile.FirstName as doctor')
            ->join('users', 'users.ID = labtest.userId')
            ->join('client', 'client.idClient = labtest.clientId')
            ->join('doctorprofile', 'doctorprofile.DoctorID = labtest.doctorID', 'left')
            ->where('test_id', $test_id)
            ->get()
            ->getRowArray();

        $labTestDetailsData = $this->db->table('labtestdetails')
            ->select('labtestdetails.*,test_type.title as TestName')
            ->join('test_type', 'test_type.testTypeId = labtestdetails.testTypeID')
            ->where('labTestID', $test_id)
            ->get()
            ->getResultArray();

        // $labReportData = $this->db->table('lab_report')
        //     ->select('lab_report.*, lab_report_attributes.title as attributeTitle,lab_report_attributes.referenceValue reference, lab_report_attributes.unit as unit')
        //     ->join('lab_report_attributes', 'lab_report.labAttribute_id = lab_report_attributes.id')
        //     ->join('labtestdetails', 'labtestdetails.testTypeID = lab_report_attributes.labTestID')
        //     ->where('labtestdetails.labTestID', $test_id)
        //     ->get()
        //     ->getResultArray();

        $labReportData = $this->db->table('lab_report')
            ->select('lab_report.*, lab_report_attributes.title as attributeTitle, lab_report_attributes.referenceValue as reference, lab_report_attributes.unit as unit')
            ->join('lab_report_attributes', 'lab_report.labAttribute_id = lab_report_attributes.id')
            ->join('labtestdetails', 'labtestdetails.labTestID = lab_report.labTestID AND labtestdetails.testTypeID = lab_report_attributes.labTestID')
            ->where('lab_report.labTestID', $test_id)
            ->get()
            ->getResultArray();

        return [
            'labTest' => $labTestData,
            'labTestDetails' => $labTestDetailsData,
            'labReport' => $labReportData,
        ];
    }

    public function getAttributes($testTypeId)
    {
        $query = $this->db->table('lab_report_attributes')
            ->select('title, referenceValue, unit')
            ->where('labTestID', $testTypeId)
            ->get();

        return $query->getResultArray();
    }
}