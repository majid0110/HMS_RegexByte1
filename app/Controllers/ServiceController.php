<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\LabModel;
use App\Models\DoctorModel;
use App\Models\ClientModel;
use App\Models\AppointmentModel;
use App\Models\TestModel;
use App\Models\LabtestdetailsModel;
use App\Models\ServicesModel;

class ServiceController extends Controller
{

    //-------------------------------------------------------------------------------------------------------------------------
//                                                 Returning Views
//-------------------------------------------------------------------------------------------------------------------------

    public function Services_form()
    {
        $servicesModel = new ServicesModel();
        $data = [
            'units' => $servicesModel->getUnits(),
            'categories' => $servicesModel->getCategories(),
            'tax' => $servicesModel->getTaxes(),
        ];
        return view('Services_form.php', $data);
    }

    public function Services_table()
    {
        $Model = new ServicesModel();
        $data['Services'] = $Model->getServices();
        return view('Services_table.php', $data);
    }

    public function editService($idArtMenu)
    {
        $servicesModel = new ServicesModel();

        $data = [
            'units' => $servicesModel->getUnits(),
            'categories' => $servicesModel->getCategories(),
            'tax' => $servicesModel->getTaxes(),
            'service' => $servicesModel->find($idArtMenu),
        ];

        return view('EditService_form.php', $data);
    }



    //-------------------------------------------------------------------------------------------------------------------------
//                                                 Main Logic
//-------------------------------------------------------------------------------------------------------------------------

    public function saveArtMenu()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $businessID = $session->get('businessID');


        $img = $request->getFile('img');

        $formData = [
            'BarCode' => $this->request->getPost('bcode'),
            'Code' => $this->request->getPost('code'),
            'Name' => $this->request->getPost('name'),
            'Image' => $img,
            'Price' => $this->request->getPost('price'),
            'Promotional_Price' => $this->request->getPost('pro_price'),
            'idCatArt' => $this->request->getPost('category'),
            'Notes' => $this->request->getPost('notes'),
            'idUnit' => $this->request->getPost('unit'),
            'Product_mix' => $this->request->getPost('p_max'),
            'Tax' => $this->request->getPost('tax'),
            'status' => $this->request->getPost('cstatus'),
            'Characteristic1' => $this->request->getPost('char_1'),
            'Characteristic2' => $this->request->getPost('char_2'),
            'isService' => 1,
            'Barcode' => $this->request->getPost('bcode'),
            'idBusiness' => $businessID,
            'idPoint_of_sale' => 1,
            'Cost' => $this->request->getpost('cost'),
            'idTVSH' => 0,
            'noTvshType' => 0,
        ];

        if ($img && $img->isValid() && !$img->hasMoved()) {
            $newName = $img->getName();
            $img->move(FCPATH . 'uploads', $newName);
            $formData['Image'] = $newName;
        } else {
            $formData['Image'] = 'defaults/download.png';
        }

        $servicesModel = new ServicesModel();
        $servicesModel->insert($formData);

        session()->setFlashdata('success', 'Service Added..!!');
        return redirect()->to(base_url("/Services_form"));
    }

    // public function deleteService($idArtMenu)
    // {

    //     try {
    //         $Model = new ServicesModel();
    //         $Model->deleteService($idArtMenu);
    //         session()->setFlashdata('success', 'Service deleted...!!');

    //         return redirect()->to(base_url("/Services_table"));

    //     } catch (\Exception $e) {
    //         log_message('error', 'Error retrieving data: ' . $e->getMessage());
    //         return $this->response->setJSON(['error' => 'Error retrieving data.', $e->getMessage()]);
    //     }

    // }
    public function deleteService($idArtMenu)
    {

        try {
            $Model = new ServicesModel();
            $Model->deleteService($idArtMenu);
            session()->setFlashdata('success', 'Service deleted...!!');

            return redirect()->to(base_url("/Services_table"));

        } catch (\Exception $e) {
            log_message('error', 'Error retrieving data: ' . $e->getMessage());
            session()->setFlashdata('error', 'DataBase Error: ' . $e->getMessage());
            return redirect()->to(base_url("/Services_table"));
        }
    }

    public function updateService($idArtMenu)
    {
        $request = \Config\Services::request();
        $servicesModel = new ServicesModel();

        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        $img = $request->getFile('img');

        $formData = [
            'BarCode' => $this->request->getPost('bcode'),
            'Code' => $this->request->getPost('code'),
            'Name' => $this->request->getPost('name'),
            'Image' => $img,
            'Price' => $this->request->getPost('price'),
            'Promotional_Price' => $this->request->getPost('pro_price'),
            'idCatArt' => $this->request->getPost('category'),
            'Notes' => $this->request->getPost('notes'),
            'idUnit' => $this->request->getPost('unit'),
            'Product_mix' => $this->request->getPost('p_max'),
            'Tax' => $this->request->getPost('tax'),
            'status' => $this->request->getPost('cstatus'),
            'Characteristic1' => $this->request->getPost('char_1'),
            'Characteristic2' => $this->request->getPost('char_2'),
            'isService' => 1,
            'Barcode' => $this->request->getPost('bcode'),
            'idBusiness' => $businessID,
            'idPoint_of_sale' => 1,
            'Cost' => $this->request->getpost('cost'),
            'idTVSH' => 0,
            'noTvshType' => 0,
        ];
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $newName = $img->getName();
            $img->move(FCPATH . 'uploads', $newName);
            $formData['Image'] = $newName;
        } else {
            $formData['Image'] = 'defaults/download.png';
        }
        $servicesModel->update($idArtMenu, $formData);

        session()->setFlashdata('success', 'Service updated successfully..!!');
        return redirect()->to(base_url("/Services_table"));
    }



}