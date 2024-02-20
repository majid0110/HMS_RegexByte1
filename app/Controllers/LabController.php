<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\LabModel;
use App\Models\DoctorModel;
use App\Models\ClientModel;
use App\Models\AppointmentModel;
use App\Models\TestModel;
use App\Models\LabtestdetailsModel;
use Mpdf\Mpdf;

class LabController extends Controller
{


    public function labServices_form()
    {
        $Model = new LabModel();
        $data['Tests'] = $Model->getTestDetails();
        return view('LabServices_form.php', $data);
    }

    public function editTest($df_id)
    {
        $Model = new LabModel();
        $data['edit_Tests'] = $Model->getTestDetails();
        return view('edit_test', $data);
    }

    public function labtest_table()
    {
        $Model = new TestModel();
        $data['Tests'] = $Model->getTestsWithDetails();
        return view('labtest_table.php', $data);
    }

    public function viewTestDetails($testId)
    {
        $model = new LabtestdetailsModel();
        $data['testDetails'] = $model->getTestDetails($testId);
        return view('test_details', $data);
    }

    public function labtest_form()
    {
        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $labmodel = new LabModel();
        $data['test_types'] = $labmodel->getTestType();

        $appointmentModel = new AppointmentModel();
        $data['appointments'] = $appointmentModel->getAppointments();

        return view('labtest_form.php', $data);
    }

    public function editTestForm($testTypeId)
    {
        $model = new LabModel();
        $data['edit_Test'] = $model->find($testTypeId);

        return view('edit_test', $data);
    }

    public function updateTest($testTypeId)
    {
        $model = new LabModel();

        if ($this->request->getMethod() === 'post') {
            $data = [
                'title' => $this->request->getPost('ls_name'),
                'description' => $this->request->getPost('ls_description'),
                'test_fee' => $this->request->getPost('ls_fee'),
            ];

            $model->updateTest($testTypeId, $data);

            return redirect()->to(base_url('/labServices_form'));
        }
    }



    public function saveLabService()
    {
        $request = \Config\Services::request();
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $UserID = $session->get('ID');


        $data = [
            'title' => $request->getPost('ls_name'),
            'description' => $request->getPost('ls_description'),
            'test_fee' => $request->getPost('ls_fee'),
            'userID' => $UserID,
            'businessID' => $businessID,
        ];

        $model = new LabModel();
        $model->saveLabService($data);

        session()->setFlashdata('success', 'Service Added..!!');

        return redirect()->to(base_url("/labServices_form"));

    }

    public function addTest()
    {
        $testModel = new TestModel();

        if ($this->request->getMethod() === 'post') {

            $clientId = $this->request->getPost('clientId');
            $appointmentId = $this->request->getPost('appointmentId');
            $tests = $this->request->getPost('tests');

            if (!empty($tests)) {
                foreach ($tests as $test) {
                    $data = [
                        'testTypeId' => $test['testTypeId'],
                        'fee' => $test['testFee'],
                        'userId' => 1,
                        'businessId' => 1,
                        'hospitalCharges' => $this->request->getPost('hospitalCharges'),
                        'clientId' => $clientId,
                        'appointmentId' => $appointmentId,
                    ];

                    $testModel->saveTest($data);
                }
            }

            session()->setFlashdata('success', 'Tests added successfully.');

            return redirect()->to(base_url());
        }

        // Fetch necessary data to populate dropdowns or other form elements
        $data['testTypes'] = []; // Replace with the actual data for test types

        return view('add_test_form', $data);
    }

    // public function updateTest($testTypeId)
    // {
    //     $model = new labModel();

    //     if ($this->request->getMethod() === 'post') {
    //         $data = [
    //             'Fee' => $this->request->getPost('fee'),
    //             'FeeTypeId' => $this->request->getPost('fee_type_id'),
    //             'doctorId' => $this->request->getPost('doctor_id'),
    //         ];

    //         $model->updateTest($testTypeId, $data);

    //         return redirect()->to(base_url('/labServices_form'));
    //     }
    // }

    public function getTestTypePrice($testTypeId)
    {
        $labModel = new LabModel();
        $testType = $labModel->find($testTypeId);

        if ($testType) {
            return $this->response->setJSON($testType);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Test type not found.']);
        }
    }

    public function getAppointmentsForClient()
    {
        try {
            $clientId = $this->request->getPost('clientId');
            log_message('info', 'Client ID: ' . $clientId);

            if (empty($clientId)) {
                throw new \Exception('Invalid client ID.');
            }

            $appointmentModel = new AppointmentModel();
            $appointments = $appointmentModel->getAppointmentsForClient($clientId);

            return $this->response->setJSON(['success' => true, 'appointments' => $appointments]);
        } catch (\Exception $e) {
            log_message('error', 'Error: ' . $e->getMessage());
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }


    public function getTestTypeId()
    {
        try {
            $testType = $this->request->getPost('testType');
            $labModel = new LabModel();
            $testTypeInfo = $labModel->where('title', $testType)->first();

            if ($testTypeInfo) {
                return $this->response->setJSON(['testTypeId' => $testTypeInfo['testTypeId']]);
            } else {
                return $this->response->setJSON(['error' => 'Test type not found.']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error retrieving test type ID: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error retrieving test type ID.', 'message' => $e->getMessage()]);
        }
    }




    public function submitTests()
    {
        $db = \Config\Database::connect();
        try {
            $clientId = $this->request->getPost('clientId');
            $appointmentId = $this->request->getPost('appointmentId');
            $tests = $this->request->getPost('tests');
            $clientName = $this->request->getPost('clientName');

            $session = \Config\Services::session();
            $businessID = $session->get('businessID');
            $UserID = $session->get('ID');
            $hospitalcharges = $session->get('hospitalcharges');

            $totalFee = 0;
            foreach ($tests as $test) {
                $totalFee += $test['fee'];
            }

            $db->transBegin();

            $data = [
                'testTypeId' => 2,
                'fee' => $totalFee,
                'userId' => $UserID,
                'businessId' => $businessID,
                'hospitalCharges' => $hospitalcharges,
                'clientId' => $clientId,
                'appointmentId' => $appointmentId,
                'clientName' => $clientName,
            ];

            $labModel = new TestModel();
            $labtestId = $labModel->saveTest($data);




            $detailsModel = new LabtestdetailsModel();
            $detailsData = [];

            foreach ($tests as $test) {
                $detailsData[] = [
                    'labTestID' => $labtestId,
                    'testTypeID' => $test['testTypeId'],
                    'testName' => $test['testName'], // Access test name here
                    'fee' => $test['fee'],
                ];

                $detailsModel->insert([
                    'labTestID' => $labtestId,
                    'testTypeID' => $test['testTypeId'],
                    'fee' => $test['fee'],
                ]);
            }
            $db->transCommit();

            $mpdf = new Mpdf();
            $pdfContent = view('pdf_labTest', ['data' => $data, 'detailsData' => $detailsData]);
            $mpdf->WriteHTML($pdfContent);

            $pdfBinary = $mpdf->Output('', 'S');

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data inserted successfully',
                'pdfContent' => base64_encode($pdfBinary),
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error retrieving data: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error retrieving data.', 'message' => $e->getMessage()]);
        }
    }



}