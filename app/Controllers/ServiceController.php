<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\LabModel;
use App\Models\DoctorModel;
use App\Models\ClientModel;
use App\Models\itemsModel;
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
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
        $servicesModel = new ServicesModel();
        $data = [
            'units' => $servicesModel->getUnits(),
            'categories' => $servicesModel->getCategories(),
            'tax' => $servicesModel->getTaxes(),
        ];
        return view('Services_form.php', $data);
    }

    public function ServicesForm()
    {
        $servicesModel = new ServicesModel();
        $data = [
            'units' => $servicesModel->getUnits(),
            'categories' => $servicesModel->getCategories(),
            'tax' => $servicesModel->getTaxes(),
        ];
        return view('Services_form1', $data);
    }

    public function getItems()
    {
        $itemModel = new itemsModel();
        $data['items'] = $itemModel->getItems();
        return view('link_Items', $data);
    }

    public function Services_form1()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
        $servicesModel = new ServicesModel();
        $data = [
            'units' => $servicesModel->getUnits(),
            'categories' => $servicesModel->getCategories(),
            'tax' => $servicesModel->getTaxes(),
        ];
        return view('addService.php', $data);
    }

    // public function Services_table()
    // {
    //     $session = session();
    //     if (!$session->get('ID')) {
    //         return redirect()->to(base_url("/session_expired"));
    //     }
    //     $Model = new ServicesModel();
    //     $data['activeItems'] = $Model->getActiveItems();
    //     $data['Services'] = $Model->getServices();
    //     return view('Services_table.php', $data);
    // }

    public function Services_table()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }

        $Model = new ServicesModel();

        $currentPage = $this->request->getVar('page') ? (int) $this->request->getVar('page') : 1;
        $perPage = 20;

        $data['activeItems'] = $Model->getActiveItems();

        $data['Services'] = $Model->getServices($perPage, $currentPage);

        $pager = service('pager');
        $total = $Model->getServicesCount();
        $data['pager'] = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return view('Services_table.php', $data);
    }


    public function editService($idArtMenu)
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
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
        return redirect()->to(base_url("/Services_table"));
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
    // public function deleteService($idArtMenu)
    // {

    //     try {
    //         $Model = new ServicesModel();
    //         $Model->deleteService($idArtMenu);
    //         session()->setFlashdata('success', 'Service deleted...!!');

    //         return redirect()->to(base_url("/Services_table"));

    //     } catch (\Exception $e) {
    //         log_message('error', 'Error retrieving data: ' . $e->getMessage());
    //         session()->setFlashdata('error', 'DataBase Error: ' . $e->getMessage());
    //         return redirect()->to(base_url("/Services_table"));
    //     }
    // }

    public function deleteService($idArtMenu)
    {
        try {
            $Model = new ServicesModel();
            $deleted = $Model->deleteService($idArtMenu);

            if ($deleted) {
                session()->setFlashdata('success', 'Service deleted.');
            } else {
                session()->setFlashdata('error', 'Failed to delete service.');
            }

            return redirect()->to(base_url("/Services_table"));
        } catch (\Exception $e) {
            log_message('error', 'Error deleting service: ' . $e->getMessage());
            session()->setFlashdata('error', 'Database Error: ' . $e->getMessage());
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

    public function transferItemsToServices()
    {
        $db = \Config\Database::connect();
        $servicesModel = new ServicesModel();

        $activeItems = $servicesModel->getActiveItems();

        $existingItems = $servicesModel->getServices();

        $existingRatios = $servicesModel->getRatio();

        $db->transBegin();

        $dataToInsertArtmenu = [];
        $dataToInsertRatio = [];

        foreach ($activeItems as $item) {
            if (!$this->isItemExistsInArtmenu($item, $existingItems) && !$this->isItemExistsInRatio($item, $existingRatios)) {
                $dataToInsertArtmenu[] = [
                    'Barcode' => $item['barcode'],
                    'Code' => $item['Code'],
                    'Name' => $item['Name'],
                    'Image' => 'defaults/download.png',
                    'Cost' => $item['Cost'],
                    'Promotional_Price' => 0,
                    'idCatArt' => $item['idCategories'],
                    'Notes' => $item['Notes'],
                    'idUnit' => $item['Unit'],
                    'Product_mix' => $item['Minimum'],
                    'status' => $item['status'],
                    'Characteristic1' => $item['characteristic1'],
                    'Characteristic2' => $item['characteristic2'],
                    'isService' => 0,
                    'idBusiness' => $item['idBusiness'],
                    'idPoint_of_sale' => 1,
                    'Price' => 0,
                    'idTVSH' => 0,
                    'noTvshType' => 0,
                ];

                $dataToInsertRatio[] = [
                    'idItem' => $item['idItem'],
                    'ratio' => 1,
                    'idBusiness' => $item['idBusiness'],
                ];
            }
        }

        if (!empty($dataToInsertArtmenu)) {
            $insertedIds = $servicesModel->insertBatch($dataToInsertArtmenu, true);
            foreach ($dataToInsertRatio as $key => $ratioData) {
                $dataToInsertRatio[$key]['idArtMenu'] = $insertedIds[$key];
            }

            $servicesModel->insertBatchRatio($dataToInsertRatio, true);

            session()->setFlashdata('success', 'Data Transfered..!!');
        } else {
            session()->setFlashdata('error', 'No data to transfer.');

        }

        $db->transCommit();

        return redirect()->to(base_url('Services_table'));
    }

    private function isItemExistsInRatio($item, $existingRatios)
    {
        foreach ($existingRatios as $existingRatio) {
            if ($existingRatio['idItem'] === $item['idItem'] && $existingRatio['idBusiness'] === $item['idBusiness']) {
                return true;
            }
        }
        return false;
    }


    private function isItemExistsInArtmenu($item, $existingItems)
    {
        foreach ($existingItems as $existingItem) {
            if ($existingItem['Code'] === $item['Code']) {
                return true;
            }
        }
        return false;
    }


}