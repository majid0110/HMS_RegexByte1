<?php
namespace App\Controllers;

use App\Models\SupplierModel;

class SupplierController extends BaseController
{
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

    public function update($id)
    {
        $model = new SupplierModel();

        $data = [
            'supplier' => $this->request->getPost('supplier'),
            'contact' => $this->request->getPost('contact'),
            'notes' => $this->request->getPost('notes'),
            'idBusiness' => $this->request->getPost('idBusiness'),
            'address' => $this->request->getPost('address'),
            'cnic' => $this->request->getPost('cnic'),
            'city' => $this->request->getPost('city'),
            'status' => $this->request->getPost('status'),
        ];

        $model->update($id, $data);

        return redirect()->to('/suppliers');
    }
}
