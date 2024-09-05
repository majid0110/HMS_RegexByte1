<?php

namespace App\Models;

use CodeIgniter\Model;

class TaxModel extends Model
{
    protected $table = 'taxtype';
    protected $primaryKey = 'tax_id';
    protected $allowedFields = [
        'value',
        'start_date',
        'status',
        'idBusiness'
    ];

    public function getTaxByValueAndBusiness($value, $businessID)
    {
        return $this->where('value', $value)
            ->where('idBusiness', $businessID)
            ->where('status', 'Active')
            ->first();
    }

    public function insertTax($data)
    {
        $this->insert($data);

        return $this->getInsertID();
    }
}