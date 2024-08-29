<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\LabModel;
use App\Models\DoctorModel;
use App\Models\ClientModel;
use App\Models\AppointmentModel;
use App\Models\TestModel;
use App\Models\LabtestdetailsModel;
use App\Models\LabReportAttributesModel;
use App\Models\ServicesModel;
use Mpdf\Mpdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class LabController extends Controller
{


    public function labServices_form()
    {
        $Model = new LabModel();
        $data['Tests'] = $Model->getTestDetails();
        return view('labServices_form.php', $data);
    }
    public function lab_test_form()
    {
        // $servicesModel = new ServicesModel();
        // $data['categories'] = $servicesModel->getCategories();
        return view('lab_test_form.php');
    }

    public function editTest($df_id)
    {
        $Model = new LabModel();
        $data['edit_Tests'] = $Model->getTestDetails();
        return view('edit_test', $data);
    }

    // public function labtest_table()
    // {
    //     $Model = new TestModel();
    //     $data['Tests'] = $Model->getTestsWithDetails();
    //     return view('labtest_table.php', $data);
    // }

    public function labtest_table()
    {
        $testModel = new TestModel();
        $data['totalHospitalFee'] = $testModel->getTotalHospitalFee();

        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $user = new AppointmentModel();
        $data['user_names'] = $user->getuserprofile();

        $search = $this->request->getPost('search');
        $userName = $this->request->getPost('userName');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');

        $data['totalLabFee'] = $testModel->getTotalLabFee($clientName, $search, $userName, $fromDate, $toDate);

        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;
        $offset = ($currentPage - 1) * $perPage;

        $data['Tests'] = $testModel->searchLabReports($search, $userName, $clientName, $fromDate, $toDate, $perPage, $offset);
        $data['pager'] = $testModel->getPager($search, $userName, $clientName, $fromDate, $toDate, $perPage, $currentPage);

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('Lab_Partial_Table', $data);
                return $this->response->setJSON([
                    'success' => true,
                    'tableContent' => $tableContent,
                    'pager' => $data['pager'],
                    'totalLabFee' => $data['totalLabFee'],

                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            return view('labtest_table', $data);

        }
    }
    public function viewTestDetails($testId)
    {
        $model = new LabtestdetailsModel();
        $data['testDetails'] = $model->getTestDetails($testId);
        $data['testid'] = $testId;

        $attributeModel = new LabReportAttributesModel();
        foreach ($data['testDetails'] as &$detail) {
            $detail['labReportAttributes'] = $attributeModel->getAttributesByTestId($detail['testTypeID']);
        }

        return view('test_details', $data);
    }



    // public function viewTestDetails($testId)
    // {
    //     $model = new LabtestdetailsModel();
    //     $data['testDetails'] = $model->getTestDetails($testId);
    //     return view('test_details', $data);
    // }

    public function labtest_form()
    {
        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $labmodel = new LabModel();
        $data['test_types'] = $labmodel->getTestType();
        $model = new DoctorModel();
        $data['doctor_names'] = $model->getDoctorNames();

        $appointmentModel = new AppointmentModel();
        $data['appointments'] = $appointmentModel->getAppointments();

        return view('labtest_form.php', $data);
    }

    public function editTestForm($testTypeId)
    {
        $model = new LabModel();
        $data['edit_Test'] = $model->find($testTypeId);

        $data['attributes'] = $model->getAttributes($testTypeId);
        return view('edit_test', $data);
    }


    // public function editTestForm($testTypeId)
    // {
    //     $model = new LabModel();
    //     $data['edit_Test'] = $model->find($testTypeId);

    //     return view('edit_test', $data);
    // }

    // public function updateTest($testTypeId)
    // {
    //     $model = new LabModel();

    //     if ($this->request->getMethod() === 'post') {
    //         $data = [
    //             'title' => $this->request->getPost('ls_name'),
    //             'description' => $this->request->getPost('ls_description'),
    //             'test_fee' => $this->request->getPost('ls_fee'),
    //         ];

    //         $model->updateTest($testTypeId, $data);

    //         return redirect()->to(base_url('/labServices_form'));
    //     }
    // }

    public function updateTest($testTypeId)
    {
        $model = new LabModel();
        $data = [
            'title' => $this->request->getPost('ls_name'),
            'description' => $this->request->getPost('ls_description'),
            'test_fee' => $this->request->getPost('ls_fee'),
        ];
        $model->update($testTypeId, $data);

        $attributeTitles = $this->request->getPost('attribute_title');
        $attributeReferenceValues = $this->request->getPost('attribute_reference_value');
        $attributeUnits = $this->request->getPost('attribute_unit');

        $model->db->table('lab_report_attributes')->where('labTestID', $testTypeId)->delete();

        $attributeData = [];
        for ($i = 0; $i < count($attributeTitles); $i++) {
            if (!empty($attributeTitles[$i])) {
                $attributeData[] = [
                    'labTestID' => $testTypeId,
                    'title' => $attributeTitles[$i],
                    'referenceValue' => $attributeReferenceValues[$i],
                    'unit' => $attributeUnits[$i],
                ];
            }
        }

        if (!empty($attributeData)) {
            $model->db->table('lab_report_attributes')->insertBatch($attributeData);
        }

        return redirect()->to(base_url('/labServices_form'));
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
        $insertID = $model->saveLabService($data);

        $attributeTitles = $request->getPost('attribute_title');
        $attributeReferenceValues = $request->getPost('attribute_reference_value');
        $attributeUnits = $request->getPost('attribute_unit');

        for ($i = 0; $i < count($attributeTitles); $i++) {
            $attributeData = [
                'labTestID' => $insertID,
                'title' => $attributeTitles[$i],
                'referenceValue' => $attributeReferenceValues[$i],
                'unit' => $attributeUnits[$i]
            ];
            $model->saveLabReportAttribute($attributeData);
        }

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


        $data['testTypes'] = [];

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
            $totalDiscount = $this->request->getPost('totalDiscount');
            $discountedTotal = $this->request->getPost('discountedTotal');
            $doctorId = $this->request->getPost('doctorId');
            $registrationDate = $this->request->getPost('registrationDate');
            $collectedDate = $this->request->getPost('collectedDate');

            $session = \Config\Services::session();
            $businessID = $session->get('businessID');
            $UserID = $session->get('ID');
            $hospitalcharges = $session->get('hospitalcharges');

            $totalFee = 0;
            foreach ($tests as $test) {
                $totalFee += $test['fee'];
            }

            $testmodel = new TestModel();

            $lastInvoiceNo = $testmodel->getLastLabNo($businessID);
            $testNo = intval($lastInvoiceNo) + 1;


            $db->transBegin();

            $data = [
                'testTypeId' => 2,
                'fee' => $discountedTotal,
                'actual_fee' => $totalFee,
                'userId' => $UserID,
                'businessId' => $businessID,
                'hospitalCharges' => $hospitalcharges,
                'clientId' => $clientId,
                'appointmentId' => $appointmentId,
                'labInvoice' => $testNo,
                'clientName' => $clientName,
                'doctorID' => $doctorId,
                'registered_at' => $registrationDate,
                'collected_at' => $collectedDate,
                'reported_at'
            ];

            $labModel = new TestModel();
            $labtestId = $labModel->saveTest($data);




            $detailsModel = new LabtestdetailsModel();
            $detailsData = [];

            foreach ($tests as $test) {
                $detailsData[] = [
                    'labTestID' => $labtestId,
                    'testTypeID' => $test['testTypeId'],
                    'testName' => $test['testName'],
                    'fee' => $test['fee'] * (1 - $test['discount'] / 100),
                    'actual_fee' => $test['fee'],
                    'discount' => $test['discount']
                ];

                $detailsModel->insert([
                    'labTestID' => $labtestId,
                    'testTypeID' => $test['testTypeId'],
                    'fee' => $test['fee'] * (1 - $test['discount'] / 100),
                    'actual_fee' => $test['fee'],
                    'discount' => $test['discount']
                ]);
            }
            $db->transCommit();

            if (empty($appointmentId)) {
                $appointment = 'Non';
                $appointmentType = 'Non';
                $doctorName = 'Non';
            } else {
                $appointmentModel = new AppointmentModel();
                $appointmentDetails = $appointmentModel->getAppointmentDetails($appointmentId);

                if ($appointmentDetails) {
                    $appointmentType = $appointmentDetails['FeeType'];
                    $doctorName = $appointmentDetails['FirstName'] . ' ' . $appointmentDetails['LastName'];
                } else {
                    $appointmentType = 'Non';
                    $doctorName = 'Non';
                }
                $appointment = $appointmentId;
            }

            $clientID = $this->request->getPost('clientId');
            $clientModel = new ClientModel();
            $Age = $clientModel->getclientAge($businessID, $clientID);
            $Gender = $clientModel->getclientGender($businessID, $clientID);
            $clientName1 = $clientModel->getclientName($businessID, $clientId);
            $clientUnique = $clientModel->getclientUnique($businessID, $clientID);
            $operatorName = session()->get('fName');
            $Model = new TestModel();
            $InvoiceNumber = $Model->getinvoiceNumber($businessID, $clientID, $appointmentId);



            $mpdf = new Mpdf();
            $pdfContent = view('pdf_labTest', [
                'data' => $data,
                'detailsData' => $detailsData,
                'TotalDiscount' => $totalDiscount,
                'Age' => $Age,
                'clientName1' => $clientName1,
                'appointment' => $appointment,
                'Gender' => $Gender,
                'clientUnique' => $clientUnique,
                'operatorName' => $operatorName,
                'InvoiceNumber' => $InvoiceNumber,
                'appointmentType' => $appointmentType,
                'doctorName' => $doctorName,

            ]);
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

    public function deleteTest($test_id)
    {

        $labModel = new LabModel();
        $testType = $labModel->deleteTest($test_id);

        return redirect()->to(base_url("/labtest_table"));
    }


    public function generateTestInvoice($test_id)
    {
        $labModel = new LabModel();
        $testModel = new TestModel();
        $testDetailsModel = new LabtestdetailsModel();
        $clientModel = new ClientModel();

        $test = $testModel->find($test_id);
        if (!$test) {
            return redirect()->to('/tests')->with('error', 'Test not found');
        }

        $detailsData = $testDetailsModel->where('labTestID', $test_id)->findAll();

        $clientData = $clientModel->find($test['clientId']);

        $totalDiscount = 0;
        foreach ($detailsData as &$detail) {
            $testType = $labModel->find($detail['testTypeID']);
            $detail['testName'] = $testType ? $testType['title'] : 'Unknown Test';

            $discount = ($detail['actual_fee'] - $detail['fee']);
            $totalDiscount += $discount;
            $detail['discount'] = ($discount / $detail['actual_fee']) * 100;
        }

        $data = [
            'testTypeId' => $test['testTypeId'],
            'fee' => $test['fee'],
            'actual_fee' => $test['actual_fee'],
            'userId' => $test['userId'],
            'businessId' => $test['businessId'],
            'hospitalCharges' => $test['hospitalCharges'],
            'clientId' => $test['clientId'],
            'appointmentId' => $test['appointmentId'],
            'labInvoice' => $test['labInvoice'],
            'clientName' => 'test',
        ];

        $Age = $clientModel->getclientAge($test['businessId'], $test['clientId']);
        $Gender = $clientModel->getclientGender($test['businessId'], $test['clientId']);
        $clientName1 = $clientModel->getclientName($test['businessId'], $test['clientId']);
        $clientUnique = $clientModel->getclientUnique($test['businessId'], $test['clientId']);
        $operatorName = session()->get('fName');
        $InvoiceNumber = $testModel->getinvoiceNumber($test['businessId'], $test['clientId'], $test['appointmentId']);

        if ($test['appointmentId'] !== 'Non') {
            $appointmentModel = new AppointmentModel();
            $appointment = $appointmentModel->find($test['appointmentId']);
            if ($appointment) {
                $appointmentType = $appointment['appointmentType'];
                $doctorModel = new DoctorModel();
                $doctor = $doctorModel->find($appointment['doctorID']);
                $doctorName = $doctor ? $doctor['FirstName'] : '';
            }
        }

        if (empty($test['appointmentId'])) {
            $appointment = 'Non';
            $appointmentType = 'Non';
            $doctorName = 'Non';
        } else {
            $appointmentDetails = $appointmentModel->getAppointmentDetails($test['appointmentId']);

            if ($appointmentDetails) {
                $appointment = $test['appointmentId'];
                $appointmentType = $appointmentDetails['FeeType'];
                $doctorName = $appointmentDetails['FirstName'] . ' ' . $appointmentDetails['LastName'];
            } else {
                $appointment = $test['appointmentId'];
                $appointmentType = 'Unknown';
                $doctorName = 'Unknown';
            }
        }




        $mpdf = new \Mpdf\Mpdf();
        $pdfContent = view('pdf_labTest', [
            'data' => $data,
            'detailsData' => $detailsData,
            'TotalDiscount' => $totalDiscount,
            'Age' => $Age,
            'clientName1' => $clientName1,
            'appointment' => $test['appointmentId'],
            'Gender' => $Gender,
            'clientUnique' => $clientUnique,
            'operatorName' => $operatorName,
            'InvoiceNumber' => $InvoiceNumber,
            'appointmentType' => $appointmentType,
            'doctorName' => $doctorName,
        ]);

        $mpdf = new \Mpdf\Mpdf();
        $pdfContent = view('pdf_labTest', [
        ]);
        $mpdf->WriteHTML($pdfContent);

        $filename = "Test_Invoice_" . $test_id . ".pdf";

        $this->response->setHeader('Content-Type', 'application/pdf');
        $this->response->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"');

        return $this->response->setBody($mpdf->Output($filename, 'S'));
    }

    public function submitReport($testTypeID)
    {
        $request = \Config\Services::request();
        $model = new LabReportAttributesModel();
        $testID = $this->request->getPost('testID');

        foreach ($request->getPost() as $key => $value) {
            if (strpos($key, 'result_') === 0 && !empty($value)) {
                $labAttributeId = str_replace('result_', '', $key);

                $data = [
                    'labAttribute_id' => $labAttributeId,
                    'result' => $value,
                    'labTestID' => $testID,
                ];


                $model->submitLabAttributeReport($data);
            }
        }
        return redirect()->to(base_url('viewTestDetails/' . $testID));


    }

    // public function downloadLabReportPDF($testid)
    // {


    //     $qrContent = base_url('viewTestDetails/' . $testid);
    //     $qrCode = new QrCode($qrContent);
    //     $qrCode->setSize(150);

    //     $writer = new PngWriter();
    //     $result = $writer->write($qrCode);

    //     $qrDataUri = $result->getDataUri();
    //     $data['qrDataUri'] = $qrDataUri;

    //     $html = view('labTest_pdf', $data);

    //     $mpdf = new \Mpdf\Mpdf([
    //         'margin_left' => 14,
    //         'margin_right' => 11,
    //         'margin_top' => 11,
    //         'margin_bottom' => 8,
    //     ]);

    //     $mpdf->WriteHTML($html);
    //     $mpdf->Output('Report_' . $testid . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    // }

    public function downloadLabReportPDF($test_id)
    {
        $labTestModel = new LabModel();

        $labTestData = $labTestModel->getLabTestDetails($test_id);

        $qrContent = base_url('viewTestDetails/' . $test_id);
        $qrCode = new QrCode($qrContent);
        $qrCode->setSize(150);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $qrDataUri = $result->getDataUri();
        $labTestData['qrDataUri'] = $qrDataUri;

        $html = view('labTest_pdf', $labTestData);

        $mpdf = new Mpdf([
            'margin_left' => 14,
            'margin_right' => 11,
            'margin_top' => 11,
            'margin_bottom' => 1,
        ]);

        $mpdf->WriteHTML($html);
        return $mpdf->Output('Report_' . $test_id . '.pdf', 'D');
    }

}