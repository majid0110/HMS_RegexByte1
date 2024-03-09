<?php

namespace App\Controllers;

use CodeIgniter\Controller;


use App\Models\InvoiceDetailModel;
use App\Models\ClientModel;
use App\Models\InvoiceModel;
use App\Models\ServicesModel;
use App\Models\itemsModel;
use Mpdf\Mpdf;

class itemsController extends Controller
{

    //-------------------------------------------------------------------------------------------------------------------------
//                                                 Returning Views
//-------------------------------------------------------------------------------------------------------------------------

    public function Managment_form()
    {
        return view('Managment_form.php');
    }
    public function items_form()
    {
        $servicesModel = new ServicesModel();
        $data = [
            'units' => $servicesModel->getUnits(),
            'categories' => $servicesModel->getCategories(),
            'tax' => $servicesModel->getTaxes(),
        ];
        $Model = new itemsModel();
        $data['warehouse'] = $Model->getIdWarehouse();
        return view('items_form.php', $data);
    }

    public function category_table()
    {
        $itemsModel = new itemsModel();
        $data['catart'] = $itemsModel->getCatartItems();

        return view('category_table', $data);
    }

    public function additem()
    {
        $servicesModel = new ServicesModel();
        $data = [
            'units' => $servicesModel->getUnits(),
            'categories' => $servicesModel->getCategories(),
            'tax' => $servicesModel->getTaxes(),
        ];
        $Model = new itemsModel();
        $data['warehouse'] = $Model->getIdWarehouse();
        return view('items_form.php', $data);
    }

    public function addcat()
    {

        return view('cat_form.php');
    }


    // public function items_table()
    // {
    //     $Model = new itemsModel();
    //     $data['items'] = $Model->getitem();
    //     return view('items_table.php', $data);
    // }

    public function items_table()
    {
        $model = new itemsModel();
        $data['items'] = $model->getItems();
        return view('items_table', $data);
    }


    public function edititem($idItem)
    {
        $servicesModel = new ServicesModel();
        $data = [
            'units' => $servicesModel->getUnits(),
            'categories' => $servicesModel->getCategories(),
            'tax' => $servicesModel->getTaxes(),
        ];
        $Model = new itemsModel();
        $data['warehouse'] = $Model->getIdWarehouse();

        // Fetch the data of the item to be edited
        $data['item'] = $Model->find($idItem);

        return view('edit_item_form.php', $data);
    }



    //-------------------------------------------------------------------------------------------------------------------------
//                                                 Main Logic
//-------------------------------------------------------------------------------------------------------------------------
    public function saveitems()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $businessID = $session->get('businessID');

        $formData = [
            'barcode' => $this->request->getPost('bcode'),
            'Code' => $this->request->getPost('code'),
            'Name' => $this->request->getPost('name'),
            'Cost' => $this->request->getpost('cost'),
            'Minimum' => $this->request->getpost('min'),
            'Notes' => $this->request->getPost('notes'),
            'idBusiness' => $businessID,
            'idTAX' => $this->request->getPost('tax'),
            'idCategories' => $this->request->getPost('category'),
            'Unit' => $this->request->getPost('Unit'),
            'idWarehouse' => 1,
            'status' => $this->request->getPost('cstatus'),
            'characteristic1' => $this->request->getPost('char_1'),
            'Characteristic2' => $this->request->getPost('char_2'),
            'isSendEmail' => 1,
            'isSendExpire' => 0,

        ];


        $servicesModel = new itemsModel();
        $servicesModel->insert($formData);

        session()->setFlashdata('success', 'Item Added..!!');
        return redirect()->to(base_url("/items_table"));
    }

    public function deleteitem($idItem)
    {

        try {
            $Model = new itemsModel();
            $Model->deleteitem($idItem);
            session()->setFlashdata('success', 'Service deleted...!!');

            return redirect()->to(base_url("/items_table"));

        } catch (\Exception $e) {
            log_message('error', 'Error retrieving data: ' . $e->getMessage());
            session()->setFlashdata('error', 'DataBase Error: ' . $e->getMessage());
            return redirect()->to(base_url("/items_table"));
        }
    }

    public function updateitem($idItem)
    {
        $request = \Config\Services::request();
        $Model = new itemsModel();

        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        $formData = [
            'barcode' => $this->request->getPost('bcode'),
            'Code' => $this->request->getPost('code'),
            'Name' => $this->request->getPost('name'),
            'Cost' => $this->request->getpost('cost'),
            'Minimum' => $this->request->getpost('min'),
            'Notes' => $this->request->getPost('notes'),
            'idBusiness' => $businessID,
            'idTAX' => $this->request->getPost('tax'),
            'idCategories' => $this->request->getPost('category'),
            'idWarehouse' => 1,
            'status' => $this->request->getPost('cstatus'),
            'characteristic1' => $this->request->getPost('char_1'),
            'Characteristic2' => $this->request->getPost('char_2'),
            'isSendEmail' => 1,
            'isSendExpire' => 0,
        ];

        $Model->update($idItem, $formData);

        session()->setFlashdata('success', 'Service updated successfully..!!');
        return redirect()->to(base_url("/items_table"));
    }

    public function saveCatart()
    {
        $itemsModel = new itemsModel();
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $businessID = $session->get('businessID');

        $data = [
            'name' => $this->request->getPost('name'),
            'idSector' => $this->request->getPost('id_sec'),
            'notes' => $this->request->getPost('notes'),
            'idBusiness' => $businessID,
        ];
        $itemsModel->insertCatart($data);

        session()->setFlashdata('success', 'Item Added..!!');
        return redirect()->to(base_url("/category_table"));
    }


}