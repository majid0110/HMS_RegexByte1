<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\TestModel;
use App\Models\LoginModel;
use App\Models\salesModel;
use App\Models\ServicesModel;
use App\Models\ConfigureModel;
use CodeIgniter\CLI\Console;
use App\Models\ClientModel;

class ReportsController extends Controller
{
    public function reports_form()
    {
        return view('reports_form.php');
    }



    // public function services_report()
    // {
    //     $clientModel = new ClientModel();
    //     $data['client_names'] = $clientModel->getClientNames();
    //     $sales = new salesModel();
    //     $data['payments'] = $sales->getpayment();


    //     $user = new AppointmentModel();
    //     $data['user_names'] = $user->getuserprofile();
    //     $Model = new salesModel();
    //     $data['Sales'] = $Model->getSalesReport();
    //     return view('services_report.php', $data);
    // }

    public function services_report()
    {
        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $sales = new SalesModel();
        $data['payments'] = $sales->getpayment();

        $Model = new ServicesModel();
        $data['totalServiceFee'] = $Model->getTotalServicesFee();

        $Model = new SalesModel();
        //e d $data['Sales'] = $Model->getSales();

        $search = $this->request->getPost('search');
        $paymentInput = $this->request->getPost('paymentInput');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');



        $data['Sales'] = $Model->getSalesReport($search, $paymentInput, $clientName, $fromDate, $toDate);
        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('ReportService', $data);
                return $this->response->setJSON(['success' => true, 'tableContent' => $tableContent]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            // Load the complete view for non-AJAX requests
            return view('services_report', $data);
        }
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

    public function lab_report()
    {
        $testModel = new TestModel();
        $data['totalHospitalFee'] = $testModel->getTotalHospitalFee();
        $data['totalLabFee'] = $testModel->getTotalLabFee();

        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $user = new AppointmentModel();
        $data['user_names'] = $user->getuserprofile();

        $search = $this->request->getPost('search');
        $userName = $this->request->getPost('userName');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');


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