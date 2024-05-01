<?php

namespace App\Controllers;

use App\Models\LabtestdetailsModel;
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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportsController extends Controller
{
    protected $pager;
    public function __construct()
    {
        $this->pager = service('pager');
    }
    public function reports_form()
    {
        return view('reports_form.php');
    }



    //---------------------------------- Appointment Report + Excel
    public function appointment_report()
    {
        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();
        $model = new DoctorModel();
        $data['doctor_names'] = $model->getDoctorNames();
        $model = new AppointmentModel();

        $search = $this->request->getPost('search');
        $doctor = $this->request->getPost('doctor');
        $client = $this->request->getPost('client');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');

        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;

        $data['pager'] = $model->getPager($search, $doctor, $client, $fromDate, $toDate, $perPage, $currentPage);
        $data['Appointments'] = $model->getAppointments($search, $doctor, $client, $fromDate, $toDate, $perPage, ($currentPage - 1) * $perPage);

        $data['totalHospitalCharges'] = $model->getTotalHospitalCharges($doctor, $client, $fromDate, $toDate);
        $data['totalAppointmentFee'] = $model->getTotalAppointmentFee();
        $data['totalFeeByDoctor'] = $model->getTotalFeeByDoctor($doctor, $client, $fromDate, $toDate);
        $data['totalFeeByClient'] = $model->getTotalFeeByClient($client, $fromDate, $toDate);
        $data['totalFeeByDateRange'] = $model->getTotalFeeByDateRange($fromDate, $toDate);

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('ReportApp', $data);
                return $this->response->setJSON([
                    'success' => true,
                    'tableContent' => $tableContent,
                    'totalFeeByDoctor' => $data['totalFeeByDoctor'],
                    'totalFeeByClient' => $data['totalFeeByClient'],
                    'totalHospitalCharges' => $data['totalHospitalCharges'],
                    'totalFeeByDateRange' => $data['totalFeeByDateRange'],
                    'pager' => $data['pager']
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            return view('appointment_report', $data);
        }
    }

    public function searchAppointments()
    {
        $Model = new AppointmentModel();
        $search = $this->request->getPost('search');

        $data['Appointments'] = $Model->getAppointments($search);
        return view('appointment_report', $data);
    }

    public function generateExcelAppointments()
    {
        $headerStyle = [
            'font' => ['bold' => true],
        ];
        $headerFill = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00'],
            ],
        ];

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $Model = new AppointmentModel();
        $search = $this->request->getPost('search');
        $doctor = $this->request->getPost('doctor');
        $client = $this->request->getPost('client');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');
        $appointments = $Model->getAppointments($search, $doctor, $client, $fromDate, $toDate);

        if (empty($appointments)) {
            return redirect()->back()->with('error', 'No data available to generate report.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $session = \Config\Services::session();
        $businessName = session()->get('businessName');
        $businessTypeName = $businessName;
        $sheet->setCellValue('A1', 'Hospital Name: ' . $businessTypeName);
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);


        $generatedBy = session()->get('fName');
        $generatedDate = date('Y-m-d H:i:s');
        $sheet->setCellValue('A2', "Generated by: $generatedBy");
        $sheet->getStyle('A2')->applyFromArray($headerStyle);
        $sheet->setCellValue('D2', "Generated Date: $generatedDate");
        $sheet->getStyle('D2')->applyFromArray($headerStyle);
        $sheet->mergeCells('A2:C2');
        $sheet->mergeCells('D2:G2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('D2')->getAlignment()->setHorizontal('left');


        $filterRow = 3;
        if (!empty($doctor)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Doctor: ' . $doctor);
            $filterRow++;
        }
        if (!empty($client)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Client: ' . $client);
            $filterRow++;
        }
        if (!empty($fromDate) && !empty($toDate)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Date Range: ' . $fromDate . ' to ' . $toDate);
            $filterRow++;
        }

        $headers = ['Client Name', 'Doctor Name', 'Appointment Type', 'Appointment Date', 'Doctor Fee', 'Hospital Fee', 'Total Fee'];
        foreach ($headers as $col => $header) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . ($filterRow);
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
            $sheet->getStyle($cell)->applyFromArray($headerFill);
            $sheet->getStyle($cell)->applyFromArray($borderStyle);
        }

        $row = $filterRow + 1;
        foreach ($appointments as $appointment) {
            $sheet->setCellValue('A' . $row, $appointment['clientName']);
            $sheet->setCellValue('B' . $row, $appointment['doctorFirstName'] . ' ' . $appointment['doctorLastName']);
            $sheet->setCellValue('C' . $row, $appointment['appointmentTypeName']);
            $sheet->setCellValue('D' . $row, $appointment['appointmentDate']);
            $sheet->setCellValue('E' . $row, $appointment['appointmentFee']);
            $sheet->setCellValue('F' . $row, $appointment['hospitalCharges']);
            $sheet->setCellValue('G' . $row, $appointment['appointmentFee'] + $appointment['hospitalCharges']);
            $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray($borderStyle);
            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $lastRow = $row;
        $sheet->setCellValue('D' . $lastRow, 'Total Fee:');
        $sheet->setCellValue('E' . $lastRow, '=SUM(E4:E' . ($lastRow - 1) . ')');
        $sheet->setCellValue('F' . $lastRow, '=SUM(F4:F' . ($lastRow - 1) . ')');
        $sheet->setCellValue('G' . $lastRow, '=SUM(G4:G' . ($lastRow - 1) . ')');
        $sheet->getStyle('D' . $lastRow . ':G' . $lastRow)->applyFromArray($borderStyle);
        $lastRowRange = 'D' . $lastRow . ':G' . $lastRow;
        $sheet->getStyle($lastRowRange)->applyFromArray($borderStyle);
        foreach (range('D', 'G') as $col) {
            $sheet->getStyle($col . $lastRow)->applyFromArray($headerStyle);
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'appointments_report.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }


    //---------------------------------------- Services Report + Excel

    // public function services_report()
    // {
    //     $clientModel = new ClientModel();
    //     $data['client_names'] = $clientModel->getClientNames();

    //     $sales = new SalesModel();
    //     $data['payments'] = $sales->getpayment();

    //     $Model = new ServicesModel();
    //     $data['totalServiceFee'] = $Model->getTotalServicesFee();

    //     $Model = new SalesModel();
    //     //$data['totalServiceFee'] = $Model->gettotalServiceFee();

    //     $search = $this->request->getPost('search');
    //     $paymentInput = $this->request->getPost('paymentInput');
    //     $clientName = $this->request->getPost('clientName');
    //     $fromDate = $this->request->getPost('fromDate');
    //     $toDate = $this->request->getPost('toDate');

    //     $data['Sales'] = $Model->getSalesReport($search, $paymentInput, $clientName, $fromDate, $toDate);
    //     if ($this->request->isAJAX()) {
    //         try {
    //             $tableContent = view('ReportService', $data);
    //             return $this->response->setJSON(['success' => true, 'tableContent' => $tableContent]);
    //         } catch (\Exception $e) {
    //             return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
    //         }
    //     } else {
    //         return view('services_report', $data);
    //     }
    // }


    public function services_report()
    {
        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $sales = new SalesModel();
        $data['payments'] = $sales->getpayment();

        $Model = new ServicesModel();
        $Model = new SalesModel();
        $search = $this->request->getPost('search');
        $paymentInput = $this->request->getPost('paymentInput');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');


        $data['totalServiceFee'] = $Model->gettotalServiceFee($search, $clientName, $paymentInput, $fromDate, $toDate);
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;
        $offset = ($currentPage - 1) * $perPage;
        $data['Sales'] = $Model->getSalesReport($search, $paymentInput, $clientName, $fromDate, $toDate, $perPage, $offset);
        $totalSales = count($Model->getSalesReport($search, $paymentInput, $clientName, $fromDate, $toDate));
        $pager = service('pager');
        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $totalSales);
        $data['pager'] = $pagerLinks;

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('ReportService', $data);
                return $this->response->setJSON([
                    'success' => true,
                    'tableContent' => $tableContent,
                    'pager' => $pagerLinks,
                    'totalServiceFee' => $data['totalServiceFee']
                ]);
            } catch (\Exception $e) {
                log_message('error', 'Error in services_report method: ' . $e->getMessage());
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            return view('services_report', $data);
        }
    }

    public function generateExcelServiceReport()
    {
        $headerStyle = [
            'font' => ['bold' => true],
        ];
        $headerFill = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00'],
            ],
        ];

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $Model = new salesModel();
        $search = $this->request->getPost('search');
        $paymentInput = $this->request->getPost('paymentInput');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');
        $services = $Model->getSalesReport($search, $paymentInput, $clientName, $fromDate, $toDate);

        if (empty($services)) {
            return redirect()->back()->with('error', 'No data available to generate report.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $session = \Config\Services::session();
        $businessName = session()->get('businessName');
        $businessTypeName = $businessName;
        $sheet->setCellValue('A1', $businessTypeName);
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);

        $sheet->setCellValue('A2', 'Generated Date: ' . date('Y-m-d H:i:s'));
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->applyFromArray($headerStyle);


        $filterRow = 3;
        if (!empty($search)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Search: ' . $search);
            $filterRow++;
        }
        if (!empty($clientName)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Client: ' . $clientName);
            $filterRow++;
        }
        if (!empty($paymentInput)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Payment Method: ' . $paymentInput);
            $filterRow++;
        }
        if (!empty($fromDate) && !empty($toDate)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Date Range: ' . $fromDate . ' to ' . $toDate);
            $filterRow++;
        }

        $headers = ['Invoice NO #', 'Client Name', 'Currency', 'Payment Method', 'Status', 'Date', 'Fee'];
        foreach ($headers as $col => $header) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . ($filterRow);
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
            $sheet->getStyle($cell)->applyFromArray($headerFill);
            $sheet->getStyle($cell)->applyFromArray($borderStyle);
        }

        $row = $filterRow + 1;
        foreach ($services as $service) {
            $sheet->setCellValue('A' . $row, $service['invOrdNum']);
            $sheet->setCellValue('B' . $row, $service['clientName']);
            $sheet->setCellValue('C' . $row, $service['Currency']);
            $sheet->setCellValue('D' . $row, $service['PaymentMethod']);
            $sheet->setCellValue('E' . $row, $service['Status']);
            $sheet->setCellValue('F' . $row, $service['Date']);
            $sheet->setCellValue('G' . $row, $service['Fee']);
            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $lastRow = $row;
        $sheet->setCellValue('F' . $lastRow, 'Total Fee:');
        $sheet->setCellValue('G' . $lastRow, '=SUM(G4:G' . ($lastRow - 1) . ')');
        $sheet->getStyle('F' . $lastRow)->applyFromArray($headerStyle);
        $sheet->getStyle('F' . $lastRow)->applyFromArray($borderStyle);
        $sheet->getStyle('G' . $lastRow)->applyFromArray($headerStyle);
        $sheet->getStyle('G' . $lastRow)->applyFromArray($borderStyle);

        $writer = new Xlsx($spreadsheet);
        $filename = 'service_report.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }




    //-------------------------------------- Lab Reports + Excel
    public function lab_report()
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
                $tableContent = view('ReportLab', $data);
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
            return view('lab_report', $data);

        }
    }

    public function generateExcelLabReport()
    {
        $headerStyle = [
            'font' => ['bold' => true],
        ];
        $headerFill = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00'],
            ],
        ];

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $testModel = new TestModel();
        $search = $this->request->getPost('search');
        $userName = $this->request->getPost('userName');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');
        $tests = $testModel->searchLabReports($search, $userName, $clientName, $fromDate, $toDate);

        if (empty($tests)) {
            return redirect()->back()->with('error', 'No data available to generate report.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $session = \Config\Services::session();
        $businessName = session()->get('businessName');
        $businessTypeName = $businessName;
        $sheet->setCellValue('A1', 'Hospital Name: ' . $businessTypeName);
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);

        $generatedBy = session()->get('fName');
        $sheet->setCellValue('A2', "Generated by: $generatedBy");
        $sheet->getStyle('A2')->applyFromArray($headerStyle);
        $sheet->setCellValue('E2', 'Generated On: ' . date('Y-m-d H:i:s'));
        $sheet->getStyle('A2')->applyFromArray($headerStyle);
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('E2:H2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->applyFromArray($headerStyle);

        $filterRow = 3;
        if (!empty($userName)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by User: ' . $userName);
            $filterRow++;
        }
        if (!empty($clientName)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Client: ' . $clientName);
            $filterRow++;
        }
        if (!empty($fromDate) && !empty($toDate)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Date Range: ' . $fromDate . ' to ' . $toDate);
            $filterRow++;
        }

        $headers = ['Client Name', 'Contact', 'Gender', 'Age', 'Added By', 'Date', 'Nationality', 'Fee'];
        $dataStartRow = $filterRow + 1;

        foreach ($headers as $col => $header) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . ($filterRow);
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
            $sheet->getStyle($cell)->applyFromArray($headerFill);
            $sheet->getStyle($cell)->applyFromArray($borderStyle);
        }


        $row = $dataStartRow;
        foreach ($tests as $test) {
            $sheet->setCellValue('A' . $row, $test['clientName']);
            $sheet->setCellValue('B' . $row, $test['contact']);
            $sheet->setCellValue('C' . $row, $test['gender']);
            $sheet->setCellValue('D' . $row, $test['age']);
            $sheet->setCellValue('E' . $row, $test['userName']);
            $sheet->setCellValue('F' . $row, $test['CreatedAT']);
            $sheet->setCellValue('G' . $row, $test['country']);
            $sheet->setCellValue('H' . $row, $test['fee']);
            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray($borderStyle);
            $row++;
        }

        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $lastRow = $row;
        $sheet->setCellValue('G' . $lastRow, 'Total Fee:');
        $sheet->setCellValue('H' . $lastRow, '=SUM(H' . $dataStartRow . ':H' . ($lastRow - 1) . ')');

        $sheet->getStyle('G' . $lastRow . ':H' . $lastRow)->applyFromArray($borderStyle);

        // Merge cells for total fee
        $sheet->mergeCells('G' . $lastRow . ':G' . $lastRow);

        $writer = new Xlsx($spreadsheet);
        $filename = 'lab_report.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    //-------------------------------------- Lab Details Report
    public function lab_details()
    {
        $Model = new LabtestdetailsModel();
        // $data['details'] = $Model->getlabdetails();
        $data['testType'] = $Model->getTestTypes();

        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $search = $this->request->getPost('search');
        $testName = $this->request->getPost('testName');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');

        $data['LabDetailFee'] = $Model->getTotalLabDetailFee($clientName, $search, $testName, $fromDate, $toDate);

        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;
        $offset = ($currentPage - 1) * $perPage;

        $data['details'] = $Model->searchLabReports($search, $testName, $clientName, $fromDate, $toDate, $perPage, $offset);
        $data['pager'] = $Model->getPager($search, $testName, $clientName, $fromDate, $toDate, $perPage, $currentPage);

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('labDetailsReport', $data);
                return $this->response->setJSON([
                    'success' => true,
                    'tableContent' => $tableContent,
                    'pager' => $data['pager'],
                    'LabDetailFee' => $data['LabDetailFee'],

                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            return view('lab_details.php', $data);

        }

    }

    public function generateExcelLabDetailReport()
    {
        $headerStyle = [
            'font' => ['bold' => true],
        ];
        $headerFill = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00'],
            ],
        ];

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $Model = new LabtestdetailsModel();
        $search = $this->request->getPost('search');
        $testName = $this->request->getPost('testName');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');

        $tests = $Model->searchLabReports($search, $testName, $clientName, $fromDate, $toDate);

        if (empty($tests)) {
            return redirect()->back()->with('error', 'No data available to generate report.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $businessName = session()->get('businessName');
        $sheet->setCellValue('A1', 'Hospital Name: ' . $businessName);
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);

        $generatedBy = session()->get('fName');
        $sheet->setCellValue('A2', "Generated by: $generatedBy");
        $sheet->getStyle('A2')->applyFromArray($headerStyle);
        $sheet->setCellValue('E2', 'Generated On: ' . date('Y-m-d H:i:s'));
        $sheet->getStyle('A2')->applyFromArray($headerStyle);
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('E2:H2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->applyFromArray($headerStyle);


        $filterRow = 3;
        if (!empty($clientName)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Client: ' . $clientName);
            $filterRow++;
        }
        if (!empty($testName)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Test Name: ' . $testName);
            $filterRow++;
        }
        if (!empty($fromDate) && !empty($toDate)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Date Range: ' . $fromDate . ' to ' . $toDate);
            $filterRow++;
        }

        $headers = ['Client Name', 'Contact', 'Gender', 'Age', 'Unique-ID', 'Test Type', 'Fee', 'Date'];
        $dataStartRow = $filterRow + 1;

        foreach ($headers as $col => $header) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . ($filterRow);
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
            $sheet->getStyle($cell)->applyFromArray($headerFill);
            $sheet->getStyle($cell)->applyFromArray($borderStyle);
        }

        $row = $dataStartRow;
        foreach ($tests as $test) {
            $sheet->setCellValue('A' . $row, $test['clientName']);
            $sheet->setCellValue('B' . $row, $test['contact']);
            $sheet->setCellValue('C' . $row, $test['gender']);
            $sheet->setCellValue('D' . $row, $test['age']);
            $sheet->setCellValue('E' . $row, $test['unique']);
            $sheet->setCellValue('F' . $row, $test['testTypeName']);
            $sheet->setCellValue('G' . $row, $test['fee']);
            $sheet->setCellValue('H' . $row, $test['createdAT']);
            for ($i = 1; $i <= 8; $i++) {
                $sheet->getStyle(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i) . $row)->applyFromArray($borderStyle);
            }
            $row++;
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $lastRow = $row;
        $sheet->setCellValue('F' . $lastRow, 'Total Fee:');
        $sheet->getStyle('F' . $lastRow)->applyFromArray($headerStyle);

        $sheet->setCellValue('G' . $lastRow, '=SUM(G' . $dataStartRow . ':G' . ($lastRow - 1) . ')');
        $sheet->getStyle('G' . $lastRow)->applyFromArray($headerStyle);
        $sheet->getStyle('F' . $lastRow . ':G' . $lastRow)->applyFromArray($borderStyle);

        $sheet->mergeCells('G' . $lastRow . ':G' . $lastRow);

        $writer = new Xlsx($spreadsheet);
        $filename = 'lab_Detailed_report.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    //------------------------------------- Service Details Report

    public function services_details()
    {
        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $sales = new SalesModel();
        $data['payments'] = $sales->getpayment();

        $search = $this->request->getPost('search');
        $payment = $this->request->getPost('payment');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');

        $Model = new SalesModel();
        $data['ServiceDetailFee'] = $Model->getTotalServiceDetailFee($clientName, $search, $payment, $fromDate, $toDate);

        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;
        $offset = ($currentPage - 1) * $perPage;


        $data['Sales'] = $Model->getSalesDetailsReport($search, $payment, $clientName, $fromDate, $toDate, $perPage, $offset);
        $data['pager'] = $Model->getdetailPager($search, $payment, $clientName, $fromDate, $toDate, $perPage, $currentPage);

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('serviceDetailsReport', $data);
                return $this->response->setJSON([
                    'success' => true,
                    'tableContent' => $tableContent,
                    'pager' => $data['pager'],
                    'ServiceDetailFee' => $data['ServiceDetailFee'],

                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            return view('services_details.php', $data);

        }


    }






}