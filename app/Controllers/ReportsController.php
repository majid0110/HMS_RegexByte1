<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\TestModel;
use App\Models\LoginModel;
use App\Models\ConfigureModel;
use CodeIgniter\CLI\Console;
use App\Models\ClientModel;

class ReportsController extends Controller
{
    public function reports_form()
    {
        return view('reports_form.php');
    }

    // public function appointment_report()
    // {

    //     $clientModel = new ClientModel();
    //     $data['client_names'] = $clientModel->getClientNames();

    //     $Model = new AppointmentModel();
    //     $data['Appointments'] = $Model->getAppointments();
    //     return view('appointment_report.php', $data);
    // }
    // public function lab_report()
    // {
    //     $clientModel = new ClientModel();
    //     $data['client_names'] = $clientModel->getClientNames();
    //     $user = new AppointmentModel();
    //     $data['user_names'] = $user->getuserprofile();
    //     $Model = new TestModel();
    //     $data['Tests'] = $Model->TestReports();
    //     return view('lab_report.php', $data);
    // }

    // public function searchlabReport()
    // {
    // $Model = new AppointmentModel();
    // $search = $this->request->getPost('search');
    // log_message('debug', 'Search Value: ' . $search);
    // $data['Appointments'] = $Model->getAppointments($search);
    // return view('lab_report', $data);
    // }



    public function services_report()
    {
        $Model = new AppointmentModel();
        $search = $this->request->getPost('search');
        // log_message('debug', 'Search Value: ' . $search);
        $data['Appointments'] = $Model->getAppointments($search);
        return view('lab_report', $data);
    }

    public function searchAppointments()
    {
        $Model = new AppointmentModel();
        $search = $this->request->getPost('search');
        // log_message('debug', 'Search Value: ' . $search);

        $data['Appointments'] = $Model->getAppointments($search);
        return view('appointment_report', $data);
    }


    public function appointment_report()
    {
        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $model = new DoctorModel();
        $data['doctor_names'] = $model->getDoctorNames();

        $Model = new AppointmentModel();
        $data['totalHospitalFee'] = $Model->getTotalHospitalFee();
        $data['totalAppointmentFee'] = $Model->getTotalAppointmentFee();
    
        $search = $this->request->getPost('search');
        $doctor = $this->request->getPost('doctor');
        $client = $this->request->getPost('client');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');
        $data['Appointments'] = $Model->getAppointments($search, $doctor, $client, $fromDate, $toDate);

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('ReportApp', $data);
                return $this->response->setJSON(['success' => true, 'tableContent' => $tableContent]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {

            return view('appointment_report', $data);
        }
    }
    // public function lab_report()
    // {
    //     $clientModel = new ClientModel();
    //     $data['client_names'] = $clientModel->getClientNames();

    //     $user = new AppointmentModel();
    //     $data['user_names'] = $user->getuserprofile();

    //     $testModel = new TestModel();
    //     $fromDate = $this->request->getPost('fromDate');
    //     $toDate = $this->request->getPost('toDate');
    //     $userName = $this->request->getPost('userName');
    //     $clientName = $this->request->getPost('clientName');
    //     $search = $this->request->getPost('search');

    //     $data['Tests'] = $testModel->getReports($fromDate, $toDate, $userName, $clientName, $search);
    //     if ($this->request->isAJAX()) {
    //         try {
    //             $tableContent = view('Reporttest', $data);
    //             return $this->response->setJSON(['success' => true, 'tableContent' => $tableContent]);
    //         } catch (\Exception $e) {
    //             return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
    //         }
    //     } else {

    //         return view('lab_report', $data);
    //     }
    // }
//--------------------------------------------------------------------------
// public function lab_report()
// {
//     $clientModel = new ClientModel();
//     $data['client_names'] = $clientModel->getClientNames();

//     $user = new AppointmentModel();
//     $data['user_names'] = $user->getuserprofile();

//     $search = $this->request->getPost('search');
//     $userName = $this->request->getPost('userName');
//     $clientName = $this->request->getPost('clientName');
//     $fromDate = $this->request->getPost('fromDate');
//     $toDate = $this->request->getPost('toDate');

//     $testModel = new TestModel();
//     $data['Tests'] = $testModel->searchLabReports($search, $userName, $clientName, $fromDate, $toDate);
//     return view('lab_report', $data);
// }
public function lab_report()
{
    $clientModel = new ClientModel();
    $data['client_names'] = $clientModel->getClientNames();

    $user = new AppointmentModel();
    $data['user_names'] = $user->getuserprofile();

    $search = $this->request->getPost('search');
    $userName = $this->request->getPost('userName');
    $clientName = $this->request->getPost('clientName');
    $fromDate = $this->request->getPost('fromDate');
    $toDate = $this->request->getPost('toDate');

    $testModel = new TestModel();
    $data['Tests'] = $testModel->searchLabReports($search, $userName, $clientName, $fromDate, $toDate);
    if ($this->request->isAJAX()) {
        try {
            $tableContent = view('ReportLab', $data);
            return $this->response->setJSON(['success' => true, 'tableContent' => $tableContent]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        return view('lab_report', $data);
    }
}

}