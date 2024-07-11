<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseModel extends Model
{
    protected $table = 'expenses';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'expense_date',
        'category_id',
        'description',
        'amount',
        'files',
        'title',
        'project_id',
        'user_id',
        'tax_id',
        'tax_id2',
        'client_id',
        'recurring',
        'recurring_expense_id',
        'repeat_every',
        'repeat_type',
        'no_of_cycles',
        'next_recurring_date',
        'no_of_cycles_completed',
        'deleted'
    ];


    public function getExpenseCategories()
    {
        return $this->db->table('expense_categories')
            ->select('id, title')
            ->get()
            ->getResultArray();
    }

    public function getUsers()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        return $this->db->table('users')
            ->select('ID, fName')
            ->where('businessID', $businessID)
            ->get()
            ->getResultArray();
    }

    public function getExpenses()
    {
        return $this->db->table('expenses')
            ->join('client', 'client.idClient = expenses.client_id')
            ->join('users', 'users.ID = expenses.user_id')
            ->join('expense_categories', 'expense_categories.id = expenses.category_id')
            ->select('expenses.*, client.client as clientName, users.fName as userName, expense_categories.title as Category')
            ->get()
            ->getResultArray();
    }


    public function deleteExpense($id)
    {
        $this->db->table('expenses')
            ->where('id', $id)
            ->delete();

    }

    public function deleteExpenseCat($id)
    {
        $this->db->table('expense_categories')
            ->where('id', $id)
            ->delete();

    }


    public function getExpensedetails($id)
    {
        return $this->db->table('expenses')
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }

    public function getExpenseCategory()
    {
        $builder = $this->db->table('expense_categories');
        $builder->orderBy('id', 'DESC');
        $result = $builder->get()->getResultArray();

        return $result;
    }

    public function insertExpenseCategory($data)
    {

        return $this->db->table('expense_categories')->insert($data);
    }

    public function EditExpenseCategory($id, $data)
    {

        return $this->db->table('expense_categories')
            ->where('id', $id)
            ->update($data);
    }
















}
