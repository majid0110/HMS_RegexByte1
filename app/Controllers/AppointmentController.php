<?php

namespace App\Controllers;




use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\ClientModel;
use App\Models\LoginModel;
use App\Models\OpdModel;
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
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
        $session = \Config\Services::session();
        $businessID = session()->get('businessID');
        $Model = new AppointmentModel();
        $data['Appointments'] = $Model->getAllAppointmentsByBusinessID($businessID);
        return view('appointments_table.php', $data);
    }

    public function appointments_form()
    {
        $session = session();
        $model = new AppointmentModel();
        $data['appointment_types'] = $model->getAppointmentTypes();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/login"));
        }
        return view('appointments_form.php', $data);
    }

    public function GenearalOpd_form()
    {
        $session = session();
        $model = new AppointmentModel();
        $data['appointment_types'] = $model->getAppointmentTypes();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/login"));
        }

        $model = new DoctorModel();
        $data['doctor_names'] = $model->getDoctorNames();
        $data['fee_types'] = $model->getFeeTypes();
        $data['doctorFees'] = $model->getDoctorFees();
        $data['doctor_names'] = $model->getDoctorNames();

        $data['fee_types'] = $model->getFeeTypes();
        $appmodel = new AppointmentModel();
        $data['appointment_types'] = $appmodel->getAppointments();
        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        return view('OPD_form.php', $data);
    }
    public function viewAppointmentDetails($appointmentID)
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
        $model = new AppointmentModel();
        $data['AppointmentDetails'] = $model->viewAppointmentDetails($appointmentID);
        return view('appointment_details', $data);
    }
    public function deleteAppointment($appointmentID)
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
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
        $charges = $this->request->getPost('hospitalFee');

        $session = \Config\Services::session();
        $businessID = session()->get('businessID');
        // $charges = $session->get('hospitalcharges');

        $lastAppointmentNo = $appointmentModel->getLastAppointmentNo($businessID);
        $appointmentNo = intval($lastAppointmentNo) + 1;

        $data = [
            'clientID' => $clientID,
            'doctorID' => $doctorID,
            'appointmentDate' => $appointmentDate,
            'appointmentTime' => $appointmentTime,
            'appointmentType' => $appointmentType,
            'appointmentFee' => $doctorFee,
            'hospitalCharges' => $charges,
            'appointmentNo' => $appointmentNo,
            'businessID' => $businessID,
        ];

        $appointmentModel->saveAppointment($data);

        $appointmentID = $appointmentModel->getInsertID();
        $clientID = $this->request->getPost('clientId');
        $clientModel = new ClientModel();
        $Age = $clientModel->getclientAge($businessID, $clientID);
        $Gender = $clientModel->getclientGender($businessID, $clientID);
        $clientUnique = $clientModel->getclientUnique($businessID, $clientID);
        $Model = new AppointmentModel();
        $InvoiceNumber = $Model->getinvoiceNumber($businessID, $appointmentID);
        $specializationName = $Model->getDoctorSpecialization($doctorID);
        $operatorName = session()->get('fName');

        $total = $doctorFee + $charges;

        $mpdf = new Mpdf();
        $pdfContent = view('pdf_template', [
            'appointmentData' => $data,
            'appointmentTypeName' => $appointmentTypeName,
            'clientName' => $clientName,
            'doctorName' => $doctorName,
            'Age' => $Age,
            'Gender' => $Gender,
            'clientUnique' => $clientUnique,
            'InvoiceNumber' => $InvoiceNumber,
            'specializationName' => $specializationName,
            'operatorName' => $operatorName,
            'hospitalfee' => $charges,
            'total' => $total,
        ]);

        $mpdf->WriteHTML($pdfContent);
        $pdfBinary = $mpdf->Output('', 'S');
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data inserted successfully',
            'pdfContent' => base64_encode($pdfBinary),
        ]);
    }


    public function saveOpdAppointment()
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
        // $charges = $this->request->getPost('hospitalFee');
        $isFreeCamp = $this->request->getPost('isFreeCamp') ? 1 : 0;

        $session = \Config\Services::session();
        $businessID = session()->get('businessID');
        // $charges = $session->get('hospitalcharges');

        $lastAppointmentNo = $appointmentModel->getLastAppointmentNo($businessID);
        $appointmentNo = intval($lastAppointmentNo) + 1;

        $data = [
            'clientID' => $clientID,
            'doctorID' => $doctorID,
            'appointmentDate' => $appointmentDate,
            'appointmentTime' => $appointmentTime,
            'appointmentType' => $appointmentType,
            'appointmentFee' => $doctorFee,
            // 'hospitalCharges' => $charges,
            'isFreeCamp' => $isFreeCamp,
            'appointmentNo' => $appointmentNo,
            'businessID' => $businessID,
        ];

        $Model = new OpdModel();
        $Model->saveOPDAppointment($data);

        $appointmentID = $appointmentModel->getInsertID();
        $clientID = $this->request->getPost('clientId');
        $clientModel = new ClientModel();
        $Age = $clientModel->getclientAge($businessID, $clientID);
        $Gender = $clientModel->getclientGender($businessID, $clientID);
        $clientUnique = $clientModel->getclientUnique($businessID, $clientID);
        $Model = new AppointmentModel();
        $InvoiceNumber = $Model->getinvoiceNumber($businessID, $appointmentID);
        $specializationName = $Model->getDoctorSpecialization($doctorID);
        $operatorName = session()->get('fName');

        // $total = $doctorFee + $charges;

        $mpdf = new Mpdf();
        $pdfContent = view('pdf_template', [
            'appointmentData' => $data,
            'appointmentTypeName' => $appointmentTypeName,
            'clientName' => $clientName,
            'doctorName' => $doctorName,
            'Age' => $Age,
            'Gender' => $Gender,
            'clientUnique' => $clientUnique,
            'InvoiceNumber' => $InvoiceNumber,
            'specializationName' => $specializationName,
            'operatorName' => $operatorName,
            'hospitalfee' => $doctorFee,
            'total' => $doctorFee,
        ]);

        $mpdf->WriteHTML($pdfContent);
        $pdfBinary = $mpdf->Output('', 'S');
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data inserted successfully',
            'pdfContent' => base64_encode($pdfBinary),
        ]);
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
