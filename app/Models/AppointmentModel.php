<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointment';
    protected $primaryKey = 'appointmentID';
    protected $allowedFields = ['clientID', 'doctorID', 'appointmentDate', 'appointmentTime', 'appointmentType', 'appointmentFee', 'createdAT', 'updatedAT', 'businessID'];

    public function saveAppointment($data)
    {
        return $this->insert($data);
    }



    // public function getAppointments($search = null, $doctor = null, $client = null)
    // {
    //     $builder = $this->db->table('appointment');
    //     $builder->select('appointment.*, doctorprofile.*, client.client as clientName, doctorprofile.FirstName as doctorFirstName, doctorprofile.LastName as doctorLastName, fee_type.FeeType as appointmentTypeName');
    //     $builder->join('doctorprofile', 'doctorprofile.DoctorID = appointment.doctorID');
    //     $builder->join('client', 'client.idClient = appointment.clientID');
    //     $builder->join('fee_type', 'fee_type.f_id = appointment.appointmentType');

    //     if (!empty($search)) {
    //         $builder->groupStart()
    //             ->like('client.client', $search)
    //             ->orLike('doctorprofile.FirstName', $search)
    //             ->orLike('doctorprofile.LastName', $search)
    //             ->orLike('appointment.appointmentDate', $search)
    //             ->orLike('appointment.appointmentTime', $search)
    //             ->orLike('fee_type.FeeType', $search)
    //             ->orLike('(appointment.appointmentFee + appointment.hospitalCharges)', $search)
    //             ->groupEnd();
    //     }

    //     if (!empty($doctor)) {
    //         $builder->groupStart()
    //             ->like('CONCAT(doctorprofile.FirstName, " ", doctorprofile.LastName)', $doctor)
    //             ->groupEnd();
    //     }

    //     if (!empty($client)) {
    //         $builder->groupStart()
    //             ->like('client.client', $client)
    //             ->groupEnd();
    //     }

    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }

    public function getAppointments($search = null, $doctor = null, $client = null, $fromDate = null, $toDate = null)
    {
        $builder = $this->db->table('appointment');
        $builder->select('appointment.*, doctorprofile.*, client.client as clientName, doctorprofile.FirstName as doctorFirstName, doctorprofile.LastName as doctorLastName, fee_type.FeeType as appointmentTypeName');
        $builder->join('doctorprofile', 'doctorprofile.DoctorID = appointment.doctorID');
        $builder->join('client', 'client.idClient = appointment.clientID');
        $builder->join('fee_type', 'fee_type.f_id = appointment.appointmentType');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('client.client', $search)
                ->orLike('doctorprofile.FirstName', $search)
                ->orLike('doctorprofile.LastName', $search)
                ->orLike('appointment.appointmentDate', $search)
                ->orLike('appointment.appointmentTime', $search)
                ->orLike('fee_type.FeeType', $search)
                ->orLike('(appointment.appointmentFee + appointment.hospitalCharges)', $search)
                ->groupEnd();
        }

        if (!empty($doctor)) {
            $builder->groupStart()
                ->like('CONCAT(doctorprofile.FirstName, " ", doctorprofile.LastName)', $doctor)
                ->groupEnd();
        }

        if (!empty($client)) {
            $builder->like('client.client', $client);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('appointment.appointmentDate >=', $fromDate)
                ->where('appointment.appointmentDate <=', $toDate);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }


    public function getAppointmentTypes()
    {
        return $this->db->table('fee_type')->get()->getResultArray();
    }


    public function deleteAppointment($appointmentID)
    {
        return $this->where('appointmentID', $appointmentID)->delete();
    }

    public function getAppointmentsForClient($clientId)
    {
        return $this->where('clientID', $clientId)->findAll();
    }

    public function getAppointmentTypeName($appointmentId)
    {
        return $this->db->table('appointment')
            ->join('fee_type', 'fee_type.f_id = appointment.appointmentType')
            ->where('appointmentID', $appointmentId)
            ->select('fee_type.FeeType as appointmentTypeName')
            ->get()
            ->getRowArray();
    }


    public function countAppointmentsByBusinessID($businessID)
    {
        return $this->db->table('appointment')

            ->where('businessID', $businessID)
            ->countAllResults();
    }

    public function getTotalAppointmentsRevenue($businessID)
    {
        $query = $this->selectSum('appointmentFee', 'totalAppointmentsRevenue')
            ->where('businessID', $businessID)
            ->get();

        return $query->getRow()->totalAppointmentsRevenue;
    }

    public function fetchAppointmentData($businessID)
    {
        $this->select('appointment.appointmentDate, 
                       (SELECT SUM(appointmentFee) FROM appointment a 
                        WHERE a.appointmentDate = appointment.appointmentDate) as totalRevenue, 
                       COUNT(appointment.appointmentID) as totalAppointments');

        $this->where('appointment.businessID', $businessID);


        $this->where('appointment.appointmentDate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)');

        $this->groupBy('appointment.appointmentDate');

        return $this->findAll();
    }






    public function countTotalAppointments()
    {
        return $this->db->table('appointment')->countAll();
    }
    public function getRecentAppointmentsByBusinessID($businessID, $limit = 6)
    {

        $query = $this->db->table('appointment')
            ->join('client', 'appointment.clientID = client.idClient')
            ->where('appointment.businessID', $businessID)
            ->orderBy('appointment.appointmentDate', 'desc')
            ->limit($limit)
            ->select('appointment.*, client.client as clientName');


        $result = $query->get()->getResult();


        return $result;
    }

    public function getTotalChargesRevenue($businessID)
    {
        $query = $this->selectSum('hospitalCharges', 'totalChargesRevenue')
            ->where('businessID', $businessID)
            ->get();

        return $query->getRow()->totalChargesRevenue;
    }

    public function getMonthlyHospitalCharges($businessID)
    {
        $query = $this->db->query(
            "SELECT 
                CONCAT(MONTH(createdAT), '-', YEAR(createdAT)) AS label,
                SUM(hospitalCharges) AS hospitalCharges
            FROM appointment
            WHERE businessID = ?
            GROUP BY YEAR(createdAT), MONTH(createdAT)
            ORDER BY YEAR(createdAT), MONTH(createdAT)",
            [$businessID]
        );

        return $query->getResultArray();
    }

}