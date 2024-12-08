<?php
namespace App\Controllers;

use App\Models\SupplierModel;

class SupplierController extends BaseController
{
    protected $session;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }
    public function create()
    {
        return view('supplier_form');
    }

    public function supplierTable()
    {
        $model = new SupplierModel();

        $data['suppliers'] = $model->getSuppliers();
        return view('supplier_table.php', $data);
    }

    public function edit_supplier($idSupplier)
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
        $model = new SupplierModel();
        $data['supplier'] = $model->get_Supplier($idSupplier);

        return view('edit_supplier.php', $data);
    }
    public function SaveSupplier()
    {
        $request = \Config\Services::request();
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $model = new SupplierModel();

        $data = [
            'supplier' => $this->request->getPost('supplier'),
            'contact' => $this->request->getPost('contact'),
            'notes' => $this->request->getPost('notes'),
            'idBusiness' => $businessID,
            'address' => $this->request->getPost('address'),
            'cnic' => $this->request->getPost('cnic'),
            'city' => $this->request->getPost('city'),
            'status' => $this->request->getPost('status'),
        ];

        $model->save($data);

        return redirect()->to(base_url("/supplierTable"));
    }

    public function edit($id)
    {
        $model = new SupplierModel();
        $data['supplier'] = $model->find($id);

        return view('supplier_form', $data);
    }

    public function update_Supplier($id)
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $model = new SupplierModel();

        $data = [
            'supplier' => $this->request->getPost('supplier'),
            'contact' => $this->request->getPost('contact'),
            'notes' => $this->request->getPost('notes'),
            'idBusiness' => $businessID,
            'address' => $this->request->getPost('address'),
            'cnic' => $this->request->getPost('cnic'),
            'city' => $this->request->getPost('city'),
            'status' => $this->request->getPost('status'),
        ];

        $model->update($id, $data);

        return redirect()->to(base_url("/supplierTable"));
    }

    public function delete_Supplier($id)
    {

        try {
            $businessID = $this->session->get('businessID');
            $model = new SupplierModel();
            $model->deleteSupplier($id);
            session()->setFlashdata('success', 'Service deleted...!!');

            return redirect()->to(base_url("/supplierTable"));

        } catch (\Exception $e) {
            log_message('error', 'Error retrieving data: ' . $e->getMessage());
            session()->setFlashdata('error', 'DataBase Error: ' . $e->getMessage());
            return redirect()->to(base_url("/supplierTable"));
        }
    }
}
