<?php

namespace App\Models;

use CodeIgniter\Model;

class LabReportAttributesModel extends Model
{
    protected $table = 'lab_report_attributes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['labTestID', 'title', 'referenceValue', 'unit'];

    public function getAttributesByTestId($labTestID)
    {
        return $this->where('labTestID', $labTestID)->findAll();
    }

    public function submitLabAttributeReport($data)
    {
        return $this->db->table('lab_report')->insert($data);
    }

}