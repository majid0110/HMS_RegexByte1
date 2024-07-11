<?php

namespace App\Controllers;

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
        $data['expenses'] = $expenseModel->getExpenses();
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