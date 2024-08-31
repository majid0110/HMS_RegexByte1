<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointment';
    protected $primaryKey = 'appointmentID';
    protected $allowedFields = ['clientID', 'doctorID', 'appointmentDate', 'appointmentTime', 'appointmentType', 'appointmentFee', 'hospitalCharges', 'appointmentNo', 'createdAT', 'updatedAT', 'businessID'];

    public function saveAppointment($data)
    {
        return $this->insert($data);
    }

    // public function getAllAppointmentsByBusinessID($businessID)
    // {
    //     return $this->db->table('appointment')
    //         ->join('client', 'client.idClient = appointment.clientID')
    //         ->join('doctorprofile', 'doctorprofile.DoctorID = appointment.doctorID')
    //         ->join('fee_type', 'fee_type.f_id = appointment.appointmentType')
    //         ->select('appointment.*, client.client as clientName, doctorprofile.FirstName as doctorFirstName, doctorprofile.LastName as doctorLastName, fee_type.FeeType as appointmentTypeName')
    //         ->where('appointment.businessID', $businessID)
    //         ->orderBy('appointment.appointmentDate', 'DESC')
    //         ->get()
    //         ->getResultArray();
    // }

    public function getAllAppointmentsByBusinessID($businessID)
    {
        return $this->db->table('appointment')
            ->join('client', 'client.idClient = appointment.clientID')
            ->join('doctorprofile', 'doctorprofile.DoctorID = appointment.doctorID')
            ->join('fee_type', 'fee_type.f_id = appointment.appointmentType')
            ->select('appointment.*, 
                  client.client as clientName, 
                  doctorprofile.FirstName as doctorFirstName, 
                  doctorprofile.LastName as doctorLastName, 
                  fee_type.FeeType as appointmentTypeName')
            ->where('appointment.businessID', $businessID)
            ->orderBy('appointment.appointmentDate', 'DESC')
            ->get()
            ->getResultArray();
    }



    public function getLastAppointmentNo($businessID)
    {
        $query = $this->select('appointmentNo')
            ->where('businessID', $businessID)
            ->orderBy('appointmentID', 'DESC')
            ->limit(1)
            ->get();
        if ($query->getNumRows() > 0) {
            $result = $query->getRow();
            return $result->appointmentNo;
        } else {
            return 0;
        }
    }

    public function getinvoiceNumber($businessID, $appointmentID)
    {
        return $this->db->table($this->table)
            ->where('businessID', $businessID)
            ->where('appointmentID', $appointmentID)
            ->select('appointmentNo')
            ->get()
            ->getRowArray()['appointmentNo'] ?? null;
    }

    public function getOPDinvoiceNumber($businessID, $appointmentID)
    {
        return $this->db->table('generalopd')
            ->where('businessID', $businessID)
            ->where('appointmentOPD', $appointmentID)
            ->select('appointmentNo')
            ->get()
            ->getRowArray()['appointmentNo'] ?? null;
    }
    public function getDoctorSpecialization($doctorID)
    {
        return $this->db->table('doctorprofile')
            ->join('specialization', 'doctorprofile.Specialization = specialization.s_id')
            ->where('DoctorID', $doctorID)
            ->select('specialization_N')
            ->get()
            ->getRowArray()['specialization_N'] ?? null;
    }


    // public function getAppointments($search = null, $doctor = null, $client = null, $fromDate = null, $toDate = null)
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
    //         $builder->like('client.client', $client);
    //     }

    //     if (!empty($fromDate) && !empty($toDate)) {
    //         $builder->where('appointment.appointmentDate >=', $fromDate)
    //             ->where('appointment.appointmentDate <=', $toDate);
    //     }

    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }

    //----------------------------------------------------------------- Paganation
    public function getAppointments($search = null, $doctor = null, $client = null, $fromDate = null, $toDate = null, $perPage = 20, $offset = 0)
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

        $builder->orderBy('appointment.appointmentDate', 'DESC');
        $builder->limit($perPage, $offset);

        $query = $builder->get();
        return $query->getResultArray();
    }


    public function getPager($search = null, $doctor = null, $client = null, $fromDate = null, $toDate = null, $perPage = 20, $currentPage = 1)
    {
        $builder = $this->db->table('appointment');
        $builder->select('COUNT(*) as total');
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



    public function getTotalHospitalFee()
    {
        $businessId = session()->get('businessID');
        $builder = $this->db->table($this->table);
        $builder->selectSum('hospitalCharges');
        $builder->where('businessID', $businessId);
        $result = $builder->get()->getRowArray();
        return $result['hospitalCharges'];
    }

    public function getTotalHospitalCharges($doctor = null, $client = null, $fromDate = null, $toDate = null)
    {
        $builder = $this->db->table('appointment');
        $builder->selectSum('hospitalCharges', 'totalHospitalCharges');
        $builder->join('doctorprofile', 'doctorprofile.DoctorID = appointment.doctorID');
        $builder->join('client', 'client.idClient = appointment.clientID');

        if (!empty($doctor)) {
            $builder->groupStart()
                ->like('CONCAT_WS(" ", doctorprofile.FirstName, doctorprofile.LastName)', $doctor)
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
        $result = $query->getRowArray();

        return $result['totalHospitalCharges'] ?? 0;
    }

    // public function getTotalHospitalFeeByFilters($search = null, $doctor = null, $client = null, $fromDate = null, $toDate = null)
    // {
    //     $builder = $this->db->table('appointment');
    //     $builder->selectSum('hospitalCharges', 'totalHospitalFee');
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
    //         $builder->like('client.client', $client);
    //     }

    //     if (!empty($fromDate) && !empty($toDate)) {
    //         $builder->where('appointment.appointmentDate >=', $fromDate)
    //             ->where('appointment.appointmentDate <=', $toDate);
    //     }

    //     $query = $builder->get();
    //     $result = $query->getRowArray();

    //     return $result['totalHospitalFee'] ?? 0;
    // }


    // public function getTotalFeeByDoctor($doctor, $fromDate, $toDate)
    // {
    //     $builder = $this->db->table('appointment');
    //     $builder->selectSum('(appointment.appointmentFee + appointment.hospitalCharges)', 'totalFee');
    //     $builder->join('doctorprofile', 'doctorprofile.DoctorID = appointment.doctorID');

    //     if (!empty($doctor)) {
    //         $builder->like('CONCAT(doctorprofile.FirstName, " ", doctorprofile.LastName)', $doctor);
    //     }

    //     if (!empty($fromDate) && !empty($toDate)) {
    //         $builder->where('appointment.appointmentDate >=', $fromDate)
    //             ->where('appointment.appointmentDate <=', $toDate);
    //     }

    //     $query = $builder->get();
    //     $result = $query->getRowArray();

    //     return $result['totalFee'] ?? 0;
    // }

    public function getTotalFeeByDoctor($doctor, $client, $fromDate, $toDate)
    {
        $builder = $this->db->table('appointment');
        $builder->selectSum('appointmentFee', 'totalAppointmentFee');
        $builder->join('doctorprofile', 'doctorprofile.DoctorID = appointment.doctorID');
        $builder->join('client', 'client.idClient = appointment.clientID');

        if (!empty($doctor)) {
            $builder->like('CONCAT(doctorprofile.FirstName, " ", doctorprofile.LastName)', $doctor);
        }

        if (!empty($client)) {
            $builder->like('client.client', $client);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('appointment.appointmentDate >=', $fromDate)
                ->where('appointment.appointmentDate <=', $toDate);
        }

        $query = $builder->get();
        $result = $query->getRowArray();

        return $result['totalAppointmentFee'] ?? 0;
    }

    public function getTotalFeeByClient($client, $fromDate, $toDate)
    {
        $builder = $this->db->table('appointment');
        $builder->selectSum('(appointment.appointmentFee + appointment.hospitalCharges)', 'totalFee');
        $builder->join('client', 'client.idClient = appointment.clientID');

        if (!empty($client)) {
            $builder->like('client.client', $client);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('appointment.appointmentDate >=', $fromDate)
                ->where('appointment.appointmentDate <=', $toDate);
        }

        $query = $builder->get();
        $result = $query->getRowArray();

        return $result['totalFee'] ?? 0;
    }

    public function getTotalFeeByDateRange($fromDate, $toDate)
    {
        $builder = $this->db->table('appointment');
        $builder->selectSum('(appointment.appointmentFee + appointment.hospitalCharges)', 'totalFee');

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('appointment.appointmentDate >=', $fromDate)
                ->where('appointment.appointmentDate <=', $toDate);
        }

        $query = $builder->get();
        $result = $query->getRowArray();

        return $result['totalFee'] ?? 0;
    }


    public function getTotalAppointmentFee()
    {
        $businessId = session()->get('businessID');
        $builder = $this->db->table($this->table);
        $builder->selectSum('appointmentFee');
        $builder->where('businessID', $businessId);
        $result = $builder->get()->getRowArray();
        return $result['appointmentFee'];
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


    // public function getTotalAppointmentsRevenue($businessID)
    // {
    //     $query = $this->selectSum('appointmentFee', 'totalAppointmentsRevenue')
    //         ->where('businessID', $businessID)
    //         ->get();

    //     return $query->getRow()->totalAppointmentsRevenue;
    // }

    public function getTotalAppointmentsRevenue($businessID)
    {
        $query = $this->select('SUM(appointmentFee + hospitalCharges) AS totalAppointmentsRevenue')
            ->where('businessID', $businessID)
            ->get();

        return $query->getRow()->totalAppointmentsRevenue;
    }

    public function getMonthlyAppointmentsRevenue($businessID)
    {
        $query = $this->selectSum('appointmentFee', 'totalAppointmentsRevenue')
            ->where('MONTH(appointmentDate)', date('m'))
            ->where('YEAR(appointmentDate)', date('Y'))
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

    public function getuserprofile()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        return $this->db->table('users')
            ->where('businessID', $businessID)
            ->get()
            ->getResultArray();
    }

    public function getAppointmentDetails($appointmentId)
    {
        return $this->db->table($this->table)
            ->select('appointment.*, doctorprofile.FirstName, doctorprofile.LastName, fee_type.FeeType')
            ->join('doctorprofile', 'doctorprofile.DoctorID = appointment.DoctorID', 'left')
            ->join('fee_type', 'fee_type.f_id = appointment.appointmentType', 'left')
            ->where('appointment.appointmentID', $appointmentId)
            ->get()
            ->getRowArray();
    }

    // public function viewAppointmentDetails($appointmentID)
    // {
    //     return $this->db->table('appointment')
    //         ->join('client', 'client.idClient = appointment.clientID')
    //         ->join('doctorprofile', 'doctorprofile.DoctorID = appointment.doctorID')
    //         ->where('appointment.appointmentID', $appointmentID)
    //         ->select('appointment.*, client.client as client, client.contact as contact, client.email as email, client.clientUniqueId as clientUniqueId, doctorprofile.FirstName as doctorFirstName, doctorprofile.LastName as doctorLastName, doctorprofile.Specialization as Specialization, doctorprofile.ContactNumber as doctorContact')
    //         ->get()
    //         ->getResultArray();
    // }



    public function viewAppointmentDetails($appointmentID)
    {
        return $this->db->table('appointment')
            ->join('client', 'client.idClient = appointment.clientID')
            ->join('doctorprofile', 'doctorprofile.DoctorID = appointment.doctorID')
            ->join('specialization', 'specialization.s_id = doctorprofile.Specialization', 'left')
            ->join('fee_type', 'fee_type.f_id = appointment.appointmentType', 'left')
            ->join('labtest', 'labtest.appointmentId = appointment.appointmentID', 'left')
            ->join('labtestdetails', 'labtestdetails.labTestID = labtest.test_id', 'left')
            ->join('test_type', 'test_type.testTypeId = labtestdetails.testTypeID', 'left')
            ->where('appointment.appointmentID', $appointmentID)
            ->select('appointment.*, client.client as client, client.contact as contact, client.gender as gender,
             client.clientUniqueId as unique, client.clientUniqueId as clientUniqueId, doctorprofile.FirstName as doctorFirstName,
              doctorprofile.LastName as doctorLastName, specialization.specialization_N as Specialization,
              doctorprofile.ContactNumber as doctorContact, labtest.test_id as labTestId, labtestdetails.labtest_id as labTestDetailsId, test_type.title as TestTitle,
              labtestdetails.fee as labTestFee, labtestdetails.createdAT as labTestCreatedAt, labtest.hospitalCharges as labHospitalCharges, fee_type.FeeType as AppointmentType,
              labtest.hospitalCharges as labhospital, labtest.labInvoice as labInvoice, labtest.CreatedAT as labdate')
            ->get()
            ->getResultArray();
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

    public function getMonthlyAppointmentFees($businessID)
    {
        $currentYear = date('Y');

        $builder = $this->db->table($this->table);
        $builder->select("
            MONTH(appointmentDate) as month,
            SUM(appointmentFee + hospitalCharges) as total
        ");
        $builder->where('businessID', $businessID);
        $builder->where('YEAR(appointmentDate)', $currentYear);
        $builder->groupBy('MONTH(appointmentDate)');
        $builder->orderBy('MONTH(appointmentDate)', 'ASC');

        $query = $builder->get();
        $results = $query->getResultArray();

        $monthlyData = array_fill(1, 12, ['month' => 0, 'total' => 0]);

        foreach ($results as $row) {
            $monthlyData[$row['month']] = $row;
        }

        foreach ($monthlyData as $month => &$data) {
            if ($data['month'] === 0) {
                $data['month'] = $month;
            }
        }

        return array_values($monthlyData);
    }

}