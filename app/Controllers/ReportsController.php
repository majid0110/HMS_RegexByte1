<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\AppointmentModel;
use App\Models\DoctorModel;
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

    // public function appointment_report()
    // {
    //     $clientModel = new ClientModel();
    //     $data['client_names'] = $clientModel->getClientNames();

    //     $Model = new AppointmentModel();

    //     // Get the search input from the request
    //     $search = $this->request->getPost('search');

    //     // Filter appointments based on search criteria
    //     $data['Appointments'] = $Model->getAppointments($search);

    //     return view('appointment_report.php', $data);
    // }

    public function searchAppointments()
    {
        $Model = new AppointmentModel();
        $search = $this->request->getPost('search');

        // Log or echo the search value for debugging
        log_message('debug', 'Search Value: ' . $search);

        $data['Appointments'] = $Model->getAppointments($search);

        // Load the view without the "partials/" prefix
        return view('appointment_report', $data);
    }


    // public function appointment_report()
    // {
    //     $clientModel = new ClientModel();
    //     $data['client_names'] = $clientModel->getClientNames();

    //     $Model = new AppointmentModel();
    //     $search = $this->request->getPost('search');

    //     // Filter appointments based on search criteria
    //     $data['Appointments'] = $Model->getAppointments($search);

    //     return view('appointment_report.php', $data);
    // }

    // public function appointment_report()
    // {
    //     $clientModel = new ClientModel();
    //     $data['client_names'] = $clientModel->getClientNames();

    //     $Model = new AppointmentModel();
    //     $search = $this->request->getPost('search');

    //     // Filter appointments based on search criteria
    //     $data['Appointments'] = $Model->getAppointments($search);

    //     if ($this->request->isAJAX()) {
    //         // Load only the table content for AJAX requests
    //         return view('appointment_table', $data);
    //     } else {
    //         // Load the complete view for non-AJAX requests
    //         return view('appointment_report', $data);
    //     }
    // }

    // public function appointment_report()
    // {
    //     $clientModel = new ClientModel();
    //     $data['client_names'] = $clientModel->getClientNames();

    //     $Model = new AppointmentModel();
    //     $search = $this->request->getPost('search');

    //     $data['Appointments'] = $Model->getAppointments($search);

    //     if ($this->request->isAJAX()) {
    //         try {
    //             $tableContent = view('ReportApp', $data);
    //             return $this->response->setJSON(['success' => true, 'tableContent' => $tableContent]);
    //         } catch (\Exception $e) {
    //             return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
    //         }
    //     } else {
    //         // Load the complete view for non-AJAX requests
    //         return view('appointment_report', $data);
    //     }
    // }

    // public function appointment_report()
    // {
    //     $clientModel = new ClientModel();
    //     $data['client_names'] = $clientModel->getClientNames();

    //     $Model = new AppointmentModel();

    //     // Get the search input and doctor value from the request
    //     $search = $this->request->getPost('search');
    //     $doctor = $this->request->getPost('doctor');

    //     // Filter appointments based on search criteria
    //     $data['Appointments'] = $Model->getAppointments($search, $doctor);

    //     if ($this->request->isAJAX()) {
    //         try {
    //             $tableContent = view('ReportApp', $data);
    //             return $this->response->setJSON(['success' => true, 'tableContent' => $tableContent]);
    //         } catch (\Exception $e) {
    //             return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
    //         }
    //     } else {
    //         // Load the complete view for non-AJAX requests
    //         return view('appointment_report', $data);
    //     }
    // }
    public function appointment_report()
    {
        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $Model = new AppointmentModel();

        // Get the search input and doctor value from the request
        $search = $this->request->getPost('search');
        $doctor = $this->request->getPost('doctor');

        // Filter appointments based on search criteria
        $data['Appointments'] = $Model->getAppointments($search, $doctor);

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('ReportApp', $data);
                return $this->response->setJSON(['success' => true, 'tableContent' => $tableContent]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            // Load the complete view for non-AJAX requests
            return view('appointment_report', $data);
        }
    }


}