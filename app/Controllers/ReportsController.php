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

        $data['totalFeeByDoctor'] = $Model->getTotalFeeByDoctor($doctor, $fromDate, $toDate);
        $data['totalFeeByClient'] = $Model->getTotalFeeByClient($client, $fromDate, $toDate);
        $data['totalFeeByDateRange'] = $Model->getTotalFeeByDateRange($fromDate, $toDate);

        if ($this->request->isAJAX()) {
            try {
                $tableContent = view('ReportApp', $data);
                return $this->response->setJSON([
                    'success' => true,
                    'tableContent' => $tableContent,
                    'totalFeeByDoctor' => $data['totalFeeByDoctor'],
                    'totalFeeByClient' => $data['totalFeeByClient'],
                    'totalFeeByDateRange' => $data['totalFeeByDateRange']
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {

            return view('appointment_report', $data);
        }
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