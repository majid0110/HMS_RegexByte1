<?php

namespace App\Controllers;




use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\ClientModel;
use App\Models\LoginModel;
use APP\libraries\EscPos;

// require __DIR__ . '/Config/Autoload.php';
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;


use CodeIgniter\Controller;
use Mpdf\Mpdf;


class AppointmentController extends Controller
{



    //------------------------------------------------Main View 
    public function appointments_table()
    {
        $Model = new AppointmentModel();
        $data['Appointments'] = $Model->getAppointments();
        return view('appointments_table.php', $data);
    }

    // AppointmentsController
    public function appointments_form()
    {
        $model = new AppointmentModel();

        // Fetch appointment types
        $data['appointment_types'] = $model->getAppointmentTypes();



        return view('appointments_form.php', $data);
    }


    // public function fetchDoctorFee($doctorID, $feeTypeID)
    // {
    // $model = new DoctorModel();
    // $doctorFee = $model->getDoctorFee($doctorID, $feeTypeID);

    // return $this->response->setJSON(['fee' => $doctorFee['Fee'] ?? '']);
    // }


    public function deleteAppointment($appointmentID)
    {
        $model = new AppointmentModel();
        $model->deleteAppointment($appointmentID);
        session()->setFlashdata('success', 'Appointment deleted...!!');

        return redirect()->to(base_url("/appointments_table"));
    }

    public function fetchDoctorFee()
    {
        $doctorID = $this->request->getPost('doctorID');
        $feeTypeID = $this->request->getPost('feeTypeID');

        $model = new DoctorModel();
        $doctorFee = $model->getDoctorFee($doctorID, $feeTypeID);

        return $this->response->setJSON(['fee' => $doctorFee['Fee'] ?? '']);
    }

    //------------------------------------------------Functions
    public function saveAppointment()
    {
        $appointmentModel = new AppointmentModel();
        $doctorModel = new DoctorModel();
        $businessModel = new LoginModel("business");

        $clientID = $this->request->getPost('clientId');
        $doctorID = $this->request->getPost('doctor_id');
        $appointmentDate = $this->request->getPost('appointmentDate');
        $appointmentTime = $this->request->getPost('appointmentTime');
        $appointmentType = $this->request->getPost('app_type_id');
        $selectedFeeTypeID = $this->request->getPost('fee_type_id');
        $doctorFee = $this->request->getPost('appointmentFee');


        $appointmentTypeName = $this->request->getPost('appointmentTypeName');
        $clientName = $this->request->getPost('clientName');
        $doctorName = $this->request->getPost('doctorName');

        $businessID = session()->get('businessID');
        $charges = $businessModel->getBusinessCharges($businessID);

        $data = [
            'clientID' => $clientID,
            'doctorID' => $doctorID,
            'appointmentDate' => $appointmentDate,
            'appointmentTime' => $appointmentTime,
            'appointmentType' => $appointmentType,
            'appointmentFee' => $doctorFee,
            'hospitalCharges' => $charges,
            'businessID' => $businessID,
        ];

        $appointmentModel->saveAppointment($data);
        $dataPdf = [
            'appointmentTypeName' => $appointmentTypeName,
            'clientName' => $clientName,
            'doctorName' => $doctorName,
        ];


        $this->generatePdf($dataPdf + $data);

        return redirect()->to(base_url("/appointments_form"));
    }


    private function generatePdf($data)
    {

        $mpdf = new Mpdf();

        $pdfContent = view('pdf_template', $data);
        $mpdf->WriteHTML($pdfContent);

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="appointment_report_' . date('Y_m_d_H_i_s') . '.pdf"');

        echo $mpdf->Output('', 'S');

        flush();
    }

    public function saveClientProfile()
    {
        $request = \Config\Services::request();
        $session = \Config\Services::session();

        $model = new ClientModel();
        $businessID = $session->get('businessID');
        $mainClient = $request->getPost('mclient') ? 1 : 0;

        if ($mainClient == 1) {
            $model->resetMainClients();
        }

        $data = [
            'client' => $request->getPost('cName'),
            'contact' => $request->getPost('cphone'),
            'email' => $request->getPost('cemail'),
            'CNIC' => $request->getPost('CNIC'),
            'status' => $request->getPost('cstatus'),
            'Def' => $request->getPost('cdef'),
            'idBusiness' => $businessID,
            'identification_type' => $request->getPost('idType'),
            'limitExpense' => $request->getPost('expense'),
            'discount' => $request->getPost('discount'),
            'mainClient' => $mainClient,
            'address' => $request->getPost('address'),
            'city' => $request->getPost('city'),
            'state' => $request->getPost('state'),
            'code' => $request->getPost('code'),
        ];

        $model->saveClient($data);

        session()->setFlashdata('success', 'Client Added..!!');

        return redirect()->to(base_url("/appointments_form"));
    }



}
