<?php

namespace App\Models;

use CodeIgniter\Model;

class OpdModel extends Model
{
    protected $table = 'generalopd';
    protected $primaryKey = 'appointmentOPD';
    protected $allowedFields = ['clientID', 'doctorID', 'appointmentDate', 'appointmentTime', 'appointmentType', 'appointmentFee', 'appointmentNo', 'createdAT', 'updatedAT', 'status', 'isFreeCamp', 'businessID'];

    public function saveOPDAppointment($data)
    {
        return $this->insert($data);
    }


}