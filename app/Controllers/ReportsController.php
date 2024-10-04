<?php

namespace App\Controllers;

use App\Models\itemsModel;
use App\Models\LabtestdetailsModel;
use CodeIgniter\Controller;

use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\TestModel;
use App\Models\LoginModel;
use App\Models\salesModel;
use App\Models\ServicesModel;
use App\Models\ExpenseModel;
use App\Models\OpdModel;
use App\Models\purchaseInvoiceModel;
use App\Models\SupplierModel;
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
        $businessID = session()->get('businessID');

        $businessModel = new LoginModel('business');
        $business = $businessModel->find($businessID);
        $businessTypeID = $business['businessTypeID'];

        $businessTypeModel = new LoginModel('businesstype');
        $businessType = $businessTypeModel->find($businessTypeID);
        $isHospital = strtolower($businessType['businessType']) === 'hospital';
        $data['isHospital'] = $isHospital;

        return view('reports_form.php', $data);
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


    //------------------------------------Camp Appointment
    public function camp_report()
    {

        $Model = new OpdModel();
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
        $reportType = $this->request->getPost('reportType');

        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;

        $data['pager'] = $Model->getPager($search, $doctor, $client, $fromDate, $toDate, $perPage, $currentPage);

        $data['Campdata'] = $Model->getCampDetails($search, $doctor, $client, $fromDate, $toDate, $reportType, $perPage, ($currentPage - 1) * $perPage);

        $data['totalHospitalCharges'] = $Model->getTotalCampcharges($doctor, $client, $fromDate, $toDate, $reportType);
        $data['totalFeeByClient'] = $Model->getTotalFeeByClient($client, $fromDate, $toDate);
        $data['totalFeeByDateRange'] = $Model->getTotalFeeByDateRange($fromDate, $toDate);

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('Camp_Report_Partial', $data);
                return $this->response->setJSON([
                    'success' => true,
                    'tableContent' => $tableContent,
                    // 'totalFeeByDoctor' => $data['totalFeeByDoctor'],
                    // 'totalFeeByClient' => $data['totalFeeByClient'],
                    'totalHospitalCharges' => $data['totalHospitalCharges'],
                    'totalFeeByDateRange' => $data['totalFeeByDateRange'],
                    'pager' => $data['pager']
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            return view('camp_details', $data);
        }
    }

    public function generateExcelCampReport()
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

        $Model = new OpdModel();
        $search = $this->request->getPost('search');
        $doctor = $this->request->getPost('doctor');
        $client = $this->request->getPost('client');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');
        $reportType = $this->request->getPost('reportType'); // New reportType filter

        $campData = $Model->getCampDetails($search, $doctor, $client, $fromDate, $toDate, $reportType);

        if (empty($campData)) {
            return redirect()->back()->with('error', 'No data available to generate report.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $session = \Config\Services::session();
        $businessName = session()->get('businessName');
        $sheet->setCellValue('A1', 'Hospital Name: ' . $businessName);
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);

        $generatedBy = session()->get('fName');
        $generatedDate = date('Y-m-d H:i:s');
        $sheet->setCellValue('A2', "Generated by: $generatedBy");
        $sheet->getStyle('A2')->applyFromArray($headerStyle);
        $sheet->setCellValue('D2', "Generated Date: $generatedDate");
        $sheet->getStyle('D2')->applyFromArray($headerStyle);
        $sheet->mergeCells('A2:C2');
        $sheet->mergeCells('D2:F2');
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
        if ($reportType !== null && $reportType !== '') {
            $reportTypeName = $reportType == '0' ? 'OPD' : 'Free Camp';
            $sheet->setCellValue('A' . $filterRow, 'Filter by Report Type: ' . $reportTypeName);
            $filterRow++;
        }

        $headers = ['Client Name', 'Doctor Name', 'Appointment Type', 'Appointment Date', 'Fee', 'Total Fee'];
        foreach ($headers as $col => $header) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . ($filterRow);
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
            $sheet->getStyle($cell)->applyFromArray($headerFill);
            $sheet->getStyle($cell)->applyFromArray($borderStyle);
        }

        $row = $filterRow + 1;
        foreach ($campData as $camp) {
            $sheet->setCellValue('A' . $row, $camp['clientName']);
            $sheet->setCellValue('B' . $row, $camp['doctorFirstName'] . ' ' . $camp['doctorLastName']);
            $sheet->setCellValue('C' . $row, $camp['appointmentTypeName']);
            $sheet->setCellValue('D' . $row, $camp['appointmentDate']);
            $sheet->setCellValue('E' . $row, $camp['appointmentFee']);
            $sheet->setCellValue('F' . $row, $camp['appointmentFee']);  // Assuming total fee is the same as appointment fee
            $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($borderStyle);
            $row++;
        }

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $lastRow = $row;
        $sheet->setCellValue('D' . $lastRow, 'Total Fee:');
        $sheet->setCellValue('E' . $lastRow, '=SUM(E' . ($filterRow + 1) . ':E' . ($lastRow - 1) . ')');
        $sheet->setCellValue('F' . $lastRow, '=SUM(F' . ($filterRow + 1) . ':F' . ($lastRow - 1) . ')');
        $sheet->getStyle('D' . $lastRow . ':F' . $lastRow)->applyFromArray($borderStyle);

        foreach (range('D', 'F') as $col) {
            $sheet->getStyle($col . $lastRow)->applyFromArray($headerStyle);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'camp_report.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }


    //------------------------------------ Service Report + Excel
    public function services_report()
    {
        // $clientModel = new ClientModel();
        // $data['client_names'] = $clientModel->getClientNames();

        // $sales = new SalesModel();
        // $data['payments'] = $sales->getpayment();
        // // $data['Invoice'] = $sales->getInvoiceNO();
        // $data['Invoice'] = $sales->getInvoice();



        // $Model = new ServicesModel();
        // $Model = new SalesModel();
        // $search = $this->request->getPost('search');
        // $paymentInput = $this->request->getPost('paymentInput');
        // $clientName = $this->request->getPost('clientName');
        // $fromDate = $this->request->getPost('fromDate');
        // $toDate = $this->request->getPost('toDate');
        // $invoice = $this->request->getPost('invoice');
        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $sales = new SalesModel();
        $data['payments'] = $sales->getpayment();
        $data['Invoice'] = $sales->getInvoice();


        $Model = new SalesModel();
        $search = $this->request->getPost('search');
        $paymentInput = $this->request->getPost('paymentInput');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');
        $invoice = $this->request->getPost('invoice');


        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;
        $offset = ($currentPage - 1) * $perPage;

        $data['totalServiceFee'] = $sales->gettotalServiceFee($search, $invoice, $clientName, $paymentInput, $fromDate, $toDate, $perPage, $offset);

        $data['Sales'] = $Model->getSalesReport($search, $invoice, $paymentInput, $clientName, $fromDate, $toDate, $perPage, $offset);
        $data['pager'] = $Model->getPager1($search, $paymentInput, $invoice, $clientName, $fromDate, $toDate, $perPage, $currentPage);


        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('ReportService', $data);
                return $this->response->setJSON([
                    'success' => true,
                    'tableContent' => $tableContent,
                    'pager' => $data['pager'],
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

        // $services = $Model->abc($search, $paymentInput, $clientName, $fromDate, $toDate);

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
            $sheet->setCellValue('G' . $row, $service['Value']);
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

    // -------------------------------------------- Summary Invoice
    public function SummaryInvoice_Report()
    {
        $clientModel = new ClientModel();
        $data['client_names'] = $clientModel->getClientNames();

        $sales = new SalesModel();
        $data['payments'] = $sales->getpayment();
        $data['tables'] = $sales->getTableName();


        $Model = new ServicesModel();
        $Model = new SalesModel();
        $search = $this->request->getPost('search');
        $paymentInput = $this->request->getPost('paymentInput');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');
        $invoice = $this->request->getPost('invoice');


        $data['totalServiceFee'] = $Model->gettotalSummaryFee($search, $invoice, $clientName, $paymentInput, $fromDate, $toDate);
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;
        $offset = ($currentPage - 1) * $perPage;
        $data['Sales'] = $Model->getSummaryReport($search, $invoice, $paymentInput, $clientName, $fromDate, $toDate, $perPage, $offset);
        $totalSales = count($Model->getSalesReport($search, $invoice, $paymentInput, $clientName, $fromDate, $toDate));
        $pager = service('pager');
        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $totalSales);
        $data['pager'] = $pagerLinks;

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('ReportSummary', $data);
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
            return view('SummaryInvoiceReport', $data);
        }
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


        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;
        $offset = ($currentPage - 1) * $perPage;

        $data['totalLabFee'] = $testModel->getTotalLabFee($clientName, $search, $userName, $fromDate, $toDate, $perPage, $offset);

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

        $Model = new ServicesModel();
        $data['Items'] = $Model->getItemsName();

        $search = $this->request->getPost('search');
        $item = $this->request->getPost('item');
        $payment = $this->request->getPost('payment');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');

        $Model = new SalesModel();
        $data['ServiceDetailFee'] = $Model->getTotalServiceDetailFee($clientName, $item, $search, $payment, $fromDate, $toDate);

        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;
        $offset = ($currentPage - 1) * $perPage;


        $data['Sales'] = $Model->getSalesDetailsReport($search, $item, $payment, $clientName, $fromDate, $toDate, $perPage, $offset);
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

    public function generateExcelServiceDetailReport()
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

        $Model = new SalesModel();
        $search = $this->request->getPost('search');
        $payment = $this->request->getPost('payment');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');

        $Sales = $Model->getSalesDetailsReport($search, $payment, $clientName, $fromDate, $toDate);

        if (empty($Sales)) {
            return redirect()->back()->with('error', 'No data available to generate report.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $businessName = session()->get('businessName');
        $sheet->setCellValue('A1', 'Hospital Name: ' . $businessName);
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);

        $generatedBy = session()->get('fName');
        $sheet->setCellValue('A2', "Generated by: $generatedBy");
        $sheet->getStyle('A2')->applyFromArray($headerStyle);
        $sheet->setCellValue('G2', 'Generated On: ' . date('Y-m-d H:i:s'));
        $sheet->getStyle('A2')->applyFromArray($headerStyle);
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('G2:K2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->applyFromArray($headerStyle);
        $sheet->getStyle('G2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('G2')->applyFromArray($headerStyle);

        $filterRow = 3;
        if (!empty($clientName)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Client: ' . $clientName);
            $sheet->mergeCells('A3:K3');
            $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3')->applyFromArray($headerStyle);
            $filterRow++;
        }
        if (!empty($payment)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Payment Method: ' . $payment);
            $sheet->mergeCells('A3:K3');
            $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3')->applyFromArray($headerStyle);
            $filterRow++;
        }
        if (!empty($fromDate) && !empty($toDate)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Date Range: ' . $fromDate . ' to ' . $toDate);
            $sheet->mergeCells('A3:K3');
            $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3')->applyFromArray($headerStyle);
            $filterRow++;
        }

        $headers = ['Invoice', 'Code', 'Service', 'Price', 'Quantity', 'Sum', 'Discount', 'Client', 'Gender', 'State', 'Method'];
        $dataStartRow = $filterRow + 1;

        foreach ($headers as $col => $header) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . ($filterRow);
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
            $sheet->getStyle($cell)->applyFromArray($headerFill);
            $sheet->getStyle($cell)->applyFromArray($borderStyle);
        }

        $row = $dataStartRow;
        foreach ($Sales as $Sale) {
            $sheet->setCellValue('A' . $row, $Sale['Order']);
            $sheet->setCellValue('B' . $row, $Sale['idInvoiceDetail']);
            $sheet->setCellValue('C' . $row, $Sale['name']);
            $sheet->setCellValue('D' . $row, $Sale['Price']);
            $sheet->setCellValue('E' . $row, $Sale['Quantity']);
            $sheet->setCellValue('F' . $row, $Sale['Sum']);
            $sheet->setCellValue('G' . $row, $Sale['Discount']);
            $sheet->setCellValue('H' . $row, $Sale['clientName']);
            $sheet->setCellValue('I' . $row, $Sale['gender']);
            $sheet->setCellValue('J' . $row, $Sale['country']);
            $sheet->setCellValue('K' . $row, $Sale['PaymentMethod']);
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
        $sheet->getStyle('F' . $lastRow . ':F' . $lastRow)->applyFromArray($borderStyle);

        $sheet->mergeCells('G' . $lastRow . ':G' . $lastRow);

        $writer = new Xlsx($spreadsheet);
        $filename = 'service_detail_report.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    //------------------------------------- Service Details Report
    public function expenses_report()
    {
        $expenseModel = new ExpenseModel();
        $clientModel = new ClientModel();

        $filters = [
            'clientName' => $this->request->getGet('clientName'),
            'userName' => $this->request->getGet('userName'),
            'projectId' => $this->request->getGet('projectId'),
            'fromDate' => $this->request->getGet('fromDate'),
            'toDate' => $this->request->getGet('toDate'),
            'search' => $this->request->getGet('search')
        ];

        $expenses = $expenseModel->getExpenses($filters);

        $totalAmount = 0;
        foreach ($expenses as $expense) {
            $totalAmount += $expense['amount'];
        }

        $data['expenses'] = $expenses;
        $data['totalAmount'] = $totalAmount;
        $data['client_names'] = $clientModel->getClientNames();
        $data['users'] = $expenseModel->getUsers();
        $data['projects'] = $expenseModel->getExpenseProject();

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data['expenses']);
        }

        return view('expenses_report.php', $data);
    }

    public function generateExcelExpensesReport()
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

        $expenseModel = new ExpenseModel();
        $clientName = $this->request->getPost('clientName');
        $userName = $this->request->getPost('userName');
        $projectId = $this->request->getPost('projectId');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');
        $search = $this->request->getPost('search');

        $filters = [
            'clientName' => $clientName,
            'userName' => $userName,
            'projectId' => $projectId,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'search' => $search
        ];

        $expenses = $expenseModel->getExpenses($filters);

        if (empty($expenses)) {
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
        $sheet->getStyle('E2')->getAlignment()->setHorizontal('center');

        $filterRow = 3;
        if (!empty($clientName)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Client: ' . $clientName);
            $sheet->mergeCells('A3:H3');
            $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3')->applyFromArray($headerStyle);
            $filterRow++;
        }
        if (!empty($userName)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by User: ' . $userName);
            $sheet->mergeCells('A' . $filterRow . ':H' . $filterRow);
            $sheet->getStyle('A' . $filterRow)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A' . $filterRow)->applyFromArray($headerStyle);
            $filterRow++;
        }
        if (!empty($projectId)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Project: ' . $projectId);
            $sheet->mergeCells('A' . $filterRow . ':H' . $filterRow);
            $sheet->getStyle('A' . $filterRow)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A' . $filterRow)->applyFromArray($headerStyle);
            $filterRow++;
        }
        if (!empty($fromDate) && !empty($toDate)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Date Range: ' . $fromDate . ' to ' . $toDate);
            $sheet->mergeCells('A' . $filterRow . ':H' . $filterRow);
            $sheet->getStyle('A' . $filterRow)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A' . $filterRow)->applyFromArray($headerStyle);
            $filterRow++;
        }

        $headers = ['Name', 'Client', 'User', 'Project', 'Description', 'Category', 'Amount', 'Date'];
        $dataStartRow = $filterRow + 1;

        foreach ($headers as $col => $header) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . ($filterRow);
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
            $sheet->getStyle($cell)->applyFromArray($headerFill);
            $sheet->getStyle($cell)->applyFromArray($borderStyle);
        }

        $row = $dataStartRow;
        foreach ($expenses as $expense) {
            $sheet->setCellValue('A' . $row, $expense['title']);
            $sheet->setCellValue('B' . $row, $expense['clientName']);
            $sheet->setCellValue('C' . $row, $expense['userName']);
            $sheet->setCellValue('D' . $row, $expense['project_id']);
            $sheet->setCellValue('E' . $row, $expense['description']);
            $sheet->setCellValue('F' . $row, $expense['Category']);
            $sheet->setCellValue('G' . $row, $expense['amount']);
            $sheet->setCellValue('H' . $row, $expense['expense_date']);

            $row++;
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $lastRow = $row;
        $sheet->setCellValue('F' . $lastRow, 'Total Amount:');
        $sheet->getStyle('F' . $lastRow)->applyFromArray($headerStyle);

        $sheet->setCellValue('G' . $lastRow, '=SUM(G' . $dataStartRow . ':G' . ($lastRow - 1) . ')');
        $sheet->getStyle('G' . $lastRow)->applyFromArray($headerStyle);
        $sheet->getStyle('F' . $lastRow . ':F' . $lastRow)->applyFromArray($borderStyle);

        $sheet->mergeCells('G' . $lastRow . ':G' . $lastRow);

        $writer = new Xlsx($spreadsheet);
        $filename = 'expenses_report.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    //-------------------------------------------- Purchase report
    public function purchase_report()
    {
        $Model = new purchaseInvoiceModel();
        $data['totalHospitalFee'] = 100;

        $SupplierModel = new SupplierModel();
        $data['Suppliers'] = $SupplierModel->getSupplierNames();

        $sales = new SalesModel();
        $data['payments'] = $sales->getpayment();

        $data['Invoice'] = $Model->getInvoice();

        $search = $this->request->getPost('search');
        $invoice = $this->request->getPost('invoiceValue');
        $paymentValue = $this->request->getPost('payment');
        $SupplierName = $this->request->getPost('clientValue');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');


        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;
        $offset = ($currentPage - 1) * $perPage;

        $data['totalPurchaseFee'] = $Model->getPurchaseFee($SupplierName, $search, $paymentValue, $invoice, $fromDate, $toDate, $perPage, $offset);

        $data['Purchases'] = $Model->getPurchaseReport($search, $SupplierName, $paymentValue, $invoice, $fromDate, $toDate, $perPage, $offset);
        $data['pager'] = $Model->getPager($search, $paymentValue, $invoice, $SupplierName, $fromDate, $toDate, $perPage, $currentPage);

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('PurchasePartialReport', $data);
                return $this->response->setJSON([
                    'success' => true,
                    'tableContent' => $tableContent,
                    'pager' => $data['pager'],
                    'totalPurchaseFee' => $data['totalPurchaseFee'],

                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            return view('purchase_report', $data);

        }
    }

    public function generateExcelPurchaseReport()
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

        $Model = new purchaseInvoiceModel();

        $search = $this->request->getPost('search') ?? '';
        $invoice = $this->request->getPost('invoice') ?? '';
        $paymentValue = $this->request->getPost('PaymentMethod') ?? '';
        $SupplierName = $this->request->getPost('clientName') ?? '';
        $fromDate = $this->request->getPost('fromDate') ?? '';
        $toDate = $this->request->getPost('toDate') ?? '';

        $purchases = $Model->getPurchaseReport($search, $SupplierName, $paymentValue, $invoice, $fromDate, $toDate);

        if (empty($purchases)) {
            return redirect()->back()->with('error', 'No data available to generate report.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $session = \Config\Services::session();
        $businessName = session()->get('businessName');
        $sheet->setCellValue('A1', $businessName);
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
        if (!empty($SupplierName)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Supplier: ' . $SupplierName);
            $filterRow++;
        }
        if (!empty($paymentValue)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Payment Method: ' . $paymentValue);
            $filterRow++;
        }
        if (!empty($fromDate) && !empty($toDate)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Date Range: ' . $fromDate . ' to ' . $toDate);
            $filterRow++;
        }

        $headers = ['Receipt ID', 'Supplier Name', 'Currency', 'Payment Method', 'Status', 'Date', 'Value'];
        foreach ($headers as $col => $header) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . ($filterRow);
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
            $sheet->getStyle($cell)->applyFromArray($headerFill);
            $sheet->getStyle($cell)->applyFromArray($borderStyle);
        }

        $row = $filterRow + 1;
        foreach ($purchases as $purchase) {
            $sheet->setCellValue('A' . $row, $purchase['idReceipts']);
            $sheet->setCellValue('B' . $row, $purchase['SupplierName']);
            $sheet->setCellValue('C' . $row, $purchase['Currency']);
            $sheet->setCellValue('D' . $row, $purchase['PaymentMethod']);
            $sheet->setCellValue('E' . $row, $purchase['Status']);
            $sheet->setCellValue('F' . $row, $purchase['Date']);
            $sheet->setCellValue('G' . $row, $purchase['Value']);
            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $lastRow = $row;
        $sheet->setCellValue('F' . $lastRow, 'Total Value:');
        $sheet->setCellValue('G' . $lastRow, '=SUM(G' . ($filterRow + 1) . ':G' . ($lastRow - 1) . ')');
        $sheet->getStyle('F' . $lastRow)->applyFromArray($headerStyle);
        $sheet->getStyle('F' . $lastRow)->applyFromArray($borderStyle);
        $sheet->getStyle('G' . $lastRow)->applyFromArray($headerStyle);
        $sheet->getStyle('G' . $lastRow)->applyFromArray($borderStyle);

        $writer = new Xlsx($spreadsheet);
        $filename = 'purchase_report.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }



    //---------------------------
    public function Purchase_details()
    {

        $SupplierModel = new SupplierModel();
        $data['Suppliers'] = $SupplierModel->getSupplierNames();
        $test = $SupplierModel->getSupplierNames();

        $sales = new SalesModel();
        $data['payments'] = $sales->getpayment();

        $ITModel = new itemsModel();
        $data['Items'] = $ITModel->getItemsName();

        $search = $this->request->getPost('search');
        $item = $this->request->getPost('item');
        $payment = $this->request->getPost('payment');
        $clientName = $this->request->getPost('clientName'); // clientName --> Supplier Name
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');

        $Model = new SalesModel();
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $perPage = 20;
        $offset = ($currentPage - 1) * $perPage;

        $PIModel = new purchaseInvoiceModel();
        $data['ServiceDetailFee'] = $PIModel->getTotalPurchaseDetailFee($search, $item, $clientName, $payment, $fromDate, $toDate);
        $data['Sales'] = $PIModel->getPurchaseDetailsReport($search, $item, $payment, $clientName, $fromDate, $toDate, $perPage, $offset);
        $data['pager'] = $PIModel->getdetailPager($search, $payment, $clientName, $fromDate, $toDate, $perPage, $currentPage);

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('PurchasePartialDeteailReport', $data);
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
            return view('purchase_details_report.php', $data);

        }


    }


    public function generateExcelPurchaseDetailsReport()
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

        $PIModel = new purchaseInvoiceModel();
        $search = $this->request->getPost('search');
        $item = $this->request->getPost('item');
        $payment = $this->request->getPost('payment');
        $clientName = $this->request->getPost('clientName');
        $fromDate = $this->request->getPost('fromDate');
        $toDate = $this->request->getPost('toDate');

        $purchases = $PIModel->getPurchaseDetailsReport($search, $item, $payment, $clientName, $fromDate, $toDate);

        if (empty($purchases)) {
            return redirect()->back()->with('error', 'No data available to generate report.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $businessName = session()->get('businessName');
        $sheet->setCellValue('A1', $businessName);
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);

        $sheet->setCellValue('A2', 'Generated Date: ' . date('Y-m-d H:i:s'));
        $sheet->mergeCells('A2:I2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->applyFromArray($headerStyle);

        $filterRow = 3;
        if (!empty($search)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Search: ' . $search);
            $filterRow++;
        }
        if (!empty($clientName)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Supplier: ' . $clientName);
            $filterRow++;
        }
        if (!empty($item)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Item: ' . $item);
            $filterRow++;
        }
        if (!empty($payment)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Payment Method: ' . $payment);
            $filterRow++;
        }
        if (!empty($fromDate) && !empty($toDate)) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Date Range: ' . $fromDate . ' to ' . $toDate);
            $filterRow++;
        }

        $headers = ['Receipt ID', 'Name', 'Price', 'Quantity', 'Sum', 'Discount', 'Supplier Name', 'Country', 'Payment Method'];
        foreach ($headers as $col => $header) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . ($filterRow);
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
            $sheet->getStyle($cell)->applyFromArray($headerFill);
            $sheet->getStyle($cell)->applyFromArray($borderStyle);
        }

        $row = $filterRow + 1;
        foreach ($purchases as $purchase) {
            $sheet->setCellValue('A' . $row, $purchase['idReceipts']);
            $sheet->setCellValue('B' . $row, $purchase['name']);
            $sheet->setCellValue('C' . $row, $purchase['Price']);
            $sheet->setCellValue('D' . $row, $purchase['Quantity']);
            $sheet->setCellValue('E' . $row, $purchase['Sum']);
            $sheet->setCellValue('F' . $row, $purchase['Discount']);
            $sheet->setCellValue('G' . $row, $purchase['clientName']);
            $sheet->setCellValue('H' . $row, $purchase['country']);
            $sheet->setCellValue('I' . $row, $purchase['PaymentMethod']);
            $row++;
        }

        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $lastRow = $row;
        $sheet->setCellValue('D' . $lastRow, 'Total:');
        $sheet->setCellValue('E' . $lastRow, '=SUM(E4:E' . ($lastRow - 1) . ')');
        $sheet->setCellValue('F' . $lastRow, '=SUM(F4:F' . ($lastRow - 1) . ')');
        $sheet->getStyle('D' . $lastRow)->applyFromArray($headerStyle);
        $sheet->getStyle('E' . $lastRow)->applyFromArray($headerStyle);
        $sheet->getStyle('F' . $lastRow)->applyFromArray($borderStyle);

        $writer = new Xlsx($spreadsheet);
        $filename = 'purchase_details_report.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }


}