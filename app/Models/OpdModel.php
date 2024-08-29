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
        $this->insert($data);
        return $this->InsertId();
    }


    public function getTotalOPDRevenue($businessID)
    {
        $query = $this->selectSum('appointmentFee', 'totalOPDRevenue')
            ->where('businessID', $businessID)
            ->get();

        return $query->getRow()->totalOPDRevenue;
    }
    public function getCampDetails($search = null, $doctor = null, $client = null, $fromDate = null, $toDate = null, $reportType = null, $perPage = 20, $offset = 0)
    {
        $builder = $this->db->table('generalopd');
        $builder->join('doctorprofile', 'doctorprofile.DoctorID = generalopd.doctorID');
        $builder->join('client', 'client.idClient = generalopd.clientID');
        $builder->join('fee_type', 'fee_type.f_id = generalopd.appointmentType');
        $builder->select('generalopd.*, doctorprofile.*, client.client as clientName, doctorprofile.FirstName as doctorFirstName, doctorprofile.LastName as doctorLastName, fee_type.FeeType as appointmentTypeName');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('client.client', $search)
                ->orLike('doctorprofile.FirstName', $search)
                ->orLike('doctorprofile.LastName', $search)
                ->orLike('generalopd.appointmentDate', $search)
                ->orLike('generalopd.appointmentTime', $search)
                ->orLike('fee_type.FeeType', $search)
                ->orLike('(generalopd.appointmentFee)', $search)
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
            $builder->where('generalopd.appointmentDate >=', $fromDate)
                ->where('generalopd.appointmentDate <=', $toDate);
        }

        if ($reportType !== null && $reportType !== '') {
            $builder->where('generalopd.isFreeCamp', $reportType);
        }

        $builder->orderBy('generalopd.appointmentDate', 'DESC');
        $builder->limit($perPage, $offset);

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTotalCampcharges($doctor = null, $client = null, $fromDate = null, $toDate = null, $reportType = null)
    {
        $builder = $this->db->table('generalopd');
        $builder->selectSum('appointmentFee', 'totalHospitalCharges');
        $builder->join('doctorprofile', 'doctorprofile.DoctorID = generalopd.doctorID');
        $builder->join('client', 'client.idClient = generalopd.clientID');

        if (!empty($doctor)) {
            $builder->like('CONCAT(doctorprofile.FirstName, " ", doctorprofile.LastName)', $doctor);
        }

        if (!empty($client)) {
            $builder->like('client.client', $client);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('generalopd.appointmentDate >=', $fromDate)
                ->where('generalopd.appointmentDate <=', $toDate);
        }

        if ($reportType !== null && $reportType !== '') {
            $builder->where('generalopd.isFreeCamp', $reportType);
        }


        $query = $builder->get();
        $result = $query->getRowArray();

        return $result['totalHospitalCharges'] ?? 0;
    }
    public function getTotalFeeByClient($client, $fromDate, $toDate)
    {
        $builder = $this->db->table('generalopd');
        $builder->selectSum('generalopd.appointmentFee', 'totalFee');
        $builder->join('client', 'client.idClient = generalopd.clientID');

        if (!empty($client)) {
            $builder->like('client.client', $client);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('generalopd.appointmentDate >=', $fromDate)
                ->where('generalopd.appointmentDate <=', $toDate);
        }

        $query = $builder->get();
        $result = $query->getRowArray();

        return $result['totalFee'] ?? 0;
    }

    public function getTotalFeeByDateRange($fromDate, $toDate)
    {
        $builder = $this->db->table('generalopd');
        $builder->selectSum('generalopd.appointmentFee', 'totalFee');

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('generalopd.appointmentDate >=', $fromDate)
                ->where('generalopd.appointmentDate <=', $toDate);
        }

        $query = $builder->get();
        $result = $query->getRowArray();

        return $result['totalFee'] ?? 0;
    }

    public function getPager($search = null, $doctor = null, $client = null, $fromDate = null, $toDate = null, $perPage = 20, $currentPage = 1)
    {
        $builder = $this->db->table('generalopd');
        $builder->select('COUNT(*) as total');
        $builder->join('doctorprofile', 'doctorprofile.DoctorID = generalopd.doctorID');
        $builder->join('client', 'client.idClient = generalopd.clientID');
        $builder->join('fee_type', 'fee_type.f_id = generalopd.appointmentType');

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
            $builder->where('generalopd.appointmentDate >=', $fromDate)
                ->where('generalopd.appointmentDate <=', $toDate);
        }

        $totalQuery = $builder->get();
        $totalResult = $totalQuery->getRowArray();
        $total = isset($totalResult['total']) ? (int) $totalResult['total'] : 0;

        $pager = service('pager');
        $pagerConfig = [
            'perPage' => $perPage,
            'total' => $total,
            'uri' => uri_string(),
        ];

        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');
        return $pagerLinks;
    }

    public function getLastOPDAppointmentNo($businessID)
    {
        $query = $this->select('appointmentNo')
            ->where('businessID', $businessID)
            ->orderBy('appointmentOPD', 'DESC')
            ->limit(1)
            ->get();
        if ($query->getNumRows() > 0) {
            $result = $query->getRow();
            return $result->appointmentNo;
        } else {
            return 0;
        }
    }

    public function getAllOPDAppointmentsByBusinessID($businessID)
    {
        return $this->db->table('generalopd')
            ->join('client', 'client.idClient = generalopd.clientID')
            ->join('doctorprofile', 'doctorprofile.DoctorID = generalopd.doctorID')
            ->join('fee_type', 'fee_type.f_id = generalopd.appointmentType')
            ->select('generalopd.*, client.client as clientName, doctorprofile.FirstName as doctorFirstName, doctorprofile.LastName as doctorLastName,fee_type.FeeType as appointmentTypeName')
            ->where('generalopd.businessID', $businessID)
            ->orderBy('generalopd.appointmentDate', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function deleteAppointment($appointmentOPD)
    {
        return $this->where('appointmentOPD', $appointmentOPD)->delete();
    }

    public function findName($AppointmentTypeID)
    {
        $query = $this->db->table('fee_type')
            ->select('FeeType')
            ->where('f_id', $AppointmentTypeID)
            ->get()
            ->getRowArray();

        return $query['FeeType'] ?? null;
    }

    public function getinvoiceNumber($businessID, $appointmentOPD)
    {
        return $this->db->table($this->table)
            ->where('businessID', $businessID)
            ->where('appointmentOPD', $appointmentOPD)
            ->select('appointmentNo')
            ->get()
            ->getRowArray()['appointmentNo'] ?? null;
    }

    public function getPager1($search = null, $doctor = null, $client = null, $fromDate = null, $toDate = null, $perPage = 20, $currentPage = 1)
    {
        $builder = $this->db->table('generalopd');
        $builder->select('COUNT(*) as total');
        $builder->join('doctorprofile', 'doctorprofile.DoctorID = generalopd.doctorID');
        $builder->join('client', 'client.idClient = generalopd.clientID');
        $builder->join('fee_type', 'fee_type.f_id = generalopd.appointmentType');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('client.client', $search)
                ->orLike('doctorprofile.FirstName', $search)
                ->orLike('doctorprofile.LastName', $search)
                ->orLike('generalopd.appointmentDate', $search)
                ->orLike('generalopd.appointmentTime', $search)
                ->orLike('fee_type.FeeType', $search)
                ->orLike('(generalopd.appointmentFee + generalopd.hospitalCharges)', $search)
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
            $builder->where('generalopd.appointmentDate >=', $fromDate)
                ->where('generalopd.appointmentDate <=', $toDate);
        }

        $totalQuery = $builder->get();
        $totalResult = $totalQuery->getRowArray();
        $total = isset($totalResult['total']) ? (int) $totalResult['total'] : 0;

        $pager = service('pager');
        $pagerConfig = [
            'perPage' => $perPage,
            'total' => $total,
            'uri' => uri_string(),
        ];

        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');
        return $pagerLinks;
    }


}