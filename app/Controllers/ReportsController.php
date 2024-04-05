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

        // $data['totalHospitalFee'] = $model->getTotalHospitalFee();
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


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $businessTypeName = 'Majid Khan';

        $sheet->setCellValue('A1', 'Hospital Name: ' . $businessTypeName);
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);


        $sheet->setCellValue('A2', 'Generated Date: ' . date('Y-m-d H:i:s'));
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->applyFromArray($headerStyle);

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
        $sheet->setCellValue('F' . $lastRow, 'Total Fee:');
        $sheet->setCellValue('G' . $lastRow, '=SUM(G4:G' . ($lastRow - 1) . ')');
        $sheet->getStyle('F' . $lastRow . ':G' . $lastRow)->applyFromArray($borderStyle);

        $writer = new Xlsx($spreadsheet);
        $filename = 'appointments_report.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    // public function lab_report()
    // {
    //     $testModel = new TestModel();
    //     $data['totalHospitalFee'] = $testModel->getTotalHospitalFee();
    //     $data['totalLabFee'] = $testModel->getTotalLabFee();

    //     $clientModel = new ClientModel();
    //     $data['client_names'] = $clientModel->getClientNames();

    //     $user = new AppointmentModel();
    //     $data['user_names'] = $user->getuserprofile();

    //     $search = $this->request->getPost('search');
    //     $userName = $this->request->getPost('userName');
    //     $clientName = $this->request->getPost('clientName');
    //     $fromDate = $this->request->getPost('fromDate');
    //     $toDate = $this->request->getPost('toDate');


    //     $data['Tests'] = $testModel->searchLabReports($search, $userName, $clientName, $fromDate, $toDate);
    //     if ($this->request->isAJAX()) {
    //         try {
    //             $tableContent = view('ReportLab', $data);
    //             return $this->response->setJSON(['success' => true, 'tableContent' => $tableContent]);
    //         } catch (\Exception $e) {
    //             return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
    //         }
    //     } else {
    //         return view('lab_report', $data);
    //     }
    // }

    //--------------------------------------------pagination
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

        $data['totalLabFee'] = $testModel->getTotalLabFee($clientName);

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
                    'totalLabFee' => $data['totalLabFee']
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            return view('lab_report', $data);
        }
    }

    //---------------------------------------------------
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

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set your business name here
        $businessTypeName = 'Your Business Name';
        $sheet->setCellValue('A1', 'Hospital Name: ' . $businessTypeName);
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);

        $sheet->setCellValue('A2', 'Generated Date: ' . date('Y-m-d H:i:s'));
        $sheet->mergeCells('A2:E2');
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

        $headers = ['Client Name', 'Fee', 'Added By', 'Date'];
        foreach ($headers as $col => $header) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . ($filterRow);
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
            $sheet->getStyle($cell)->applyFromArray($headerFill);
            $sheet->getStyle($cell)->applyFromArray($borderStyle);
        }

        $row = $filterRow + 1;
        foreach ($tests as $test) {
            $sheet->setCellValue('A' . $row, $test['clientName']);
            $sheet->setCellValue('B' . $row, $test['fee']);
            $sheet->setCellValue('C' . $row, $test['userName']);
            $sheet->setCellValue('D' . $row, $test['CreatedAT']);
            $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($borderStyle);
            $row++;
        }

        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $lastRow = $row;
        $sheet->setCellValue('B' . $lastRow, 'Total Fee:');
        $sheet->setCellValue('C' . $lastRow, '=SUM(B4:B' . ($lastRow - 1) . ')');
        $sheet->getStyle('B' . $lastRow . ':C' . $lastRow)->applyFromArray($borderStyle);

        $writer = new Xlsx($spreadsheet);
        $filename = 'lab_report.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }


}