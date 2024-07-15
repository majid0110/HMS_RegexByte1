<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;


use CodeIgniter\Controller;
use App\Models\ExpenseModel;
use App\Models\ClientModel;
use App\Models\ServicesModel;
use CodeIgniter\CLI\Console;

class ExpenseController extends Controller
{
    public function expenses_form()
    {
        $clientModel = new ClientModel();
        $expenseModel = new ExpenseModel();

        $data['client_names'] = $clientModel->getClientNames();
        $data['categories'] = $expenseModel->getExpenseCategories();
        $data['users'] = $expenseModel->getUsers();

        return view('expenses_form.php', $data);
    }


    public function expenses_form1()
    {
        $clientModel = new ClientModel();
        $expenseModel = new ExpenseModel();

        $data['client_names'] = $clientModel->getClientNames();
        $data['categories'] = $expenseModel->getExpenseCategories();
        $data['users'] = $expenseModel->getUsers();

        return view('testExp.php', $data);
    }


    public function expenses_table()
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

        // log_message('debug', 'Search term in controller: ' . $filters['search']);

        $data['expenses'] = $expenseModel->getExpenses($filters);
        $data['client_names'] = $clientModel->getClientNames();
        $data['users'] = $expenseModel->getUsers();
        $data['projects'] = $expenseModel->getExpenseProject();

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data['expenses']);
        }

        return view('expenses_table.php', $data);
    }

    public function editExpense($id)
    {
        $expenseModel = new ExpenseModel();
        $clientModel = new ClientModel();

        $data['expenses'] = $expenseModel->getExpensedetails($id);
        $data['client_names'] = $clientModel->getClientNames();
        $data['categories'] = $expenseModel->getExpenseCategories();
        $data['users'] = $expenseModel->getUsers();


        return view('editExpense.php', $data);
    }

    public function expenseCategory_table()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/login"));
        }
        $expenseModel = new ExpenseModel();
        $data['category'] = $expenseModel->getExpenseCategory();

        return view('expenseCategory_table', $data);
    }

    //--------------------------------------------------------------------------------------------------------

    public function save_expense()
    {
        $expenseModel = new ExpenseModel();
        $image = $this->request->getFile('image');
        $id = $this->request->getPost('id');


        if ($image->isValid()) {
            $file = $image->getName();
            $image->move(FCPATH . 'uploads', $file);
        } else {

            $file = 0;
        }

        $data = [
            'expense_date' => $this->request->getPost('date_exp'),
            'category_id' => $this->request->getPost('category'),
            'description' => $this->request->getPost('description'),
            'amount' => $this->request->getPost('amount'),
            'files' => $file,
            'title' => $this->request->getPost('title'),
            'project_id' => $this->request->getPost('project'),
            'user_id' => $this->request->getPost('teamMember'),
            'tax_id' => $this->request->getPost('tax_1'),
            'tax_id2' => $this->request->getPost('tax_2'),
            'client_id' => $this->request->getPost('client'),
            'recurring' => $this->request->getPost('recurring') ? 1 : 0,
            'deleted' => 0
        ];

        if ($id) {
            if ($expenseModel->update($id, $data)) {
                return redirect()->to(base_url("/expenses_table"));
            } else {
                return redirect()->to('/expenses_form/' . $id)->with('error', 'Failed to update expense.');
            }
        } else {
            if ($expenseModel->insert($data)) {
                return redirect()->to(base_url("/expenses_form"));
            } else {
                return redirect()->to('/expenses_form')->with('error', 'Failed to save expense.');
            }
        }

    }

    public function exportExpenses()
    {
        $headerStyle = [
            'font' => ['bold' => true],
        ];
        $headerFill = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00'],
            ],
        ];
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $expenseModel = new ExpenseModel();
        $filters = [
            'clientName' => $this->request->getPost('clientName'),
            'userName' => $this->request->getPost('userName'),
            'fromDate' => $this->request->getPost('fromDate'),
            'toDate' => $this->request->getPost('toDate'),
            'search' => $this->request->getPost('search')
        ];

        $expenses = $expenseModel->getExpenses($filters);

        if (empty($expenses)) {
            return redirect()->back()->with('error', 'No data available to generate report.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $session = \Config\Services::session();
        $businessName = $session->get('businessName');
        $sheet->setCellValue('A1', 'Business Name: ' . $businessName);
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);

        $generatedBy = $session->get('fName');
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
        if (!empty($filters['clientName'])) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Client: ' . $filters['clientName']);
            $filterRow++;
        }
        if (!empty($filters['userName'])) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by User: ' . $filters['userName']);
            $filterRow++;
        }
        if (!empty($filters['fromDate']) && !empty($filters['toDate'])) {
            $sheet->setCellValue('A' . $filterRow, 'Filter by Date Range: ' . $filters['fromDate'] . ' to ' . $filters['toDate']);
            $filterRow++;
        }

        $headers = ['ID', 'Client Name', 'User Name', 'Category', 'Title', 'Amount', 'Expense Date'];
        foreach ($headers as $col => $header) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . ($filterRow);
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
            $sheet->getStyle($cell)->applyFromArray($headerFill);
            $sheet->getStyle($cell)->applyFromArray($borderStyle);
        }

        $row = $filterRow + 1;
        foreach ($expenses as $expense) {
            $sheet->setCellValue('A' . $row, $expense['id']);
            $sheet->setCellValue('B' . $row, $expense['clientName']);
            $sheet->setCellValue('C' . $row, $expense['userName']);
            $sheet->setCellValue('D' . $row, $expense['Category']);
            $sheet->setCellValue('E' . $row, $expense['title']);
            $sheet->setCellValue('F' . $row, $expense['amount']);
            $sheet->setCellValue('G' . $row, $expense['expense_date']);
            $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray($borderStyle);
            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $lastRow = $row;
        $sheet->setCellValue('D' . $lastRow, 'Total Amount:');
        $sheet->setCellValue('F' . $lastRow, '=SUM(F' . ($filterRow + 1) . ':F' . ($lastRow - 1) . ')');
        $sheet->getStyle('D' . $lastRow . ':F' . $lastRow)->applyFromArray($borderStyle);
        $sheet->getStyle('D' . $lastRow . ':F' . $lastRow)->applyFromArray($headerStyle);

        $writer = new Xlsx($spreadsheet);
        $filename = 'expenses_report.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function deleteExpense($id)
    {

        $expenseModel = new ExpenseModel();
        $expenseModel->deleteExpense($id);

        return redirect()->to(base_url("/expenses_table"));
    }

    public function addExpenseCategory()
    {
        $expenseModel = new ExpenseModel();

        $title = $this->request->getPost('title');
        $deleted = $this->request->getPost('deleted');

        $data = [
            'title' => $title,
            'deleted' => $deleted
        ];

        if ($expenseModel->insertExpenseCategory($data)) {
            return redirect()->to(base_url("/expenseCategory_table"))->with('success', 'Category added successfully.');
        } else {
            return redirect()->to(base_url("/expenseCategory_table"))->with('error', 'Failed to add category.');
        }
    }

    public function deleteExpenseCat($id)
    {

        $expenseModel = new ExpenseModel();
        $expenseModel->deleteExpenseCat($id);

        return redirect()->to(base_url("/expenseCategory_table"))->with('success', 'Category Deleted successfully.');
    }

    public function updateExpenseCategory()
    {
        $expenseModel = new ExpenseModel();

        $id = $this->request->getPost('id');
        $title = $this->request->getPost('title');
        $deleted = $this->request->getPost('deleted');

        $data = [
            'title' => $title,
            'deleted' => $deleted
        ];

        if ($expenseModel->EditExpenseCategory($id, $data)) {
            return redirect()->to(base_url("/expenseCategory_table"))->with('success', 'Category added successfully.');
        } else {
            return redirect()->to(base_url("/expenseCategory_table"))->with('error', 'Failed to add category.');
        }
    }


}