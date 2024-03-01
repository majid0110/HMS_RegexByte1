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

    // public function items_table()
    // {
    //     $Model = new itemsModel();
    //     $data['items'] = $Model->getitem();
    //     return view('items_table.php', $data);
    // }
    public function items_table()
    {
        $model = new itemsModel();
        $data['items'] = $model->getItems(); // Updated method name
        return view('items_table.php', $data);
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
        return redirect()->to(base_url("/items_form"));
    }



}