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
use App\Models\TaxModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $businessID = session()->get('businessID');

        $lastCode = $servicesModel->select('Code')->where('idBusiness', $businessID)->orderBy('Code', 'DESC')->limit(1)->first();
        $newCode = $lastCode ? intval($lastCode['Code']) + 1 : 1;

        $data = [
            'units' => $servicesModel->getUnits(),
            'categories' => $servicesModel->getCategories(),
            'tax' => $servicesModel->getTaxes(),
            'newCode' => $newCode,
        ];
        $Model = new itemsModel();
        $data['sectors'] = $Model->getSectors();
        return view('Services_form1', $data);
    }

    public function getItems()
    {
        $itemModel = new itemsModel();
        $data['items'] = $itemModel->getItem();
        return view('link_Items', $data);
    }

    // public function getItemsForEditService($idArtMenu)
    // {
    //     $itemModel = new itemsModel();
    //     $data['items'] = $itemModel->getItemforedit($idArtMenu);

    //     return view('edit_service_linkitem', $data);
    // }

    public function getItemsForEditService($idArtMenu)
    {
        $itemModel = new itemsModel();
        $data['items'] = $itemModel->getItemforedit($idArtMenu);
        $data['service'] = [
            'idArtMenu' => $idArtMenu
        ];
        return view('edit_service_linkitem', $data);
    }
    // public function getItemsForEditService()
    // {
    //     $itemModel = new itemsModel();
    //     $data['items'] = $itemModel->getItem();
    //     return view('edit_service_linkitem', $data);
    // }

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
        $data['currentPage'] = $currentPage;
        $data['perPage'] = $perPage;

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

    // public function saveArtMenu()
    // {
    //     $session = \Config\Services::session();
    //     $request = \Config\Services::request();
    //     $businessID = $session->get('businessID');


    //     $img = $request->getFile('img');
    //     $Service = $this->request->getPost('isService') ? 1 : 0;
    //     print_r($Service);

    //     $formData = [
    //         'BarCode' => $this->request->getPost('bcode'),
    //         'Code' => $this->request->getPost('code'),
    //         'Name' => $this->request->getPost('name'),
    //         'Image' => $img,
    //         'Price' => $this->request->getPost('price'),
    //         'Promotional_Price' => $this->request->getPost('pro_price'),
    //         'idCatArt' => $this->request->getPost('category'),
    //         'Notes' => $this->request->getPost('notes'),
    //         'idUnit' => $this->request->getPost('unit'),
    //         'Product_mix' => $this->request->getPost('p_max'),
    //         'Tax' => $this->request->getPost('tax'),
    //         'status' => $this->request->getPost('cstatus'),
    //         'Characteristic1' => $this->request->getPost('char_1'),
    //         'Characteristic2' => $this->request->getPost('char_2'),
    //         'isService' => $this->request->getPost('isExpiry') ? 1 : 0,
    //         'Barcode' => $this->request->getPost('bcode'),
    //         'idBusiness' => $businessID,
    //         'idPoint_of_sale' => 1,
    //         'Cost' => $this->request->getpost('cost'),
    //         'idTVSH' => 0,
    //         'noTvshType' => 0,
    //     ];

    //     if ($img && $img->isValid() && !$img->hasMoved()) {
    //         $newName = $img->getName();
    //         $img->move(FCPATH . 'uploads', $newName);
    //         $formData['Image'] = $newName;
    //     } else {
    //         $formData['Image'] = 'defaults/download.png';
    //     }


    //     $servicesModel = new ServicesModel();
    //     $servicesModel->insert($formData);
    //     $lastInsertedId = $servicesModel->getInsertID();


    //     if ($Service == 0) {
    //         $selectedItems = $this->request->getPost('selected_items');
    //         $items = $this->request->getPost('items');
    //         $ratio = $this->request->getPost('ratio');

    //         if ($selectedItems) {
    //             $servicesModel = new ServicesModel();

    //             foreach ($selectedItems as $itemId) {
    //                 if (isset($items[$itemId])) {
    //                     $itemDetails = $items[$itemId];
    //                     $idItem = $itemDetails['idItem'];
    //                     // $ratio = $itemDetails['ratio'];

    //                     $rationData = [
    //                         'idArtMenu' => $lastInsertedId,
    //                         'idItem' => $idItem,
    //                         'ratio' => $ratio,
    //                         'idBusiness' => $businessID
    //                     ];
    //                     $servicesModel->linkItem($rationData);
    //                 }
    //             }
    //         }
    //     }
    //     session()->setFlashdata('success', 'Service Added..!!');
    //     return redirect()->to(base_url("/Services_table"));

    // }

    public function saveArtMenu()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $businessID = $session->get('businessID');

        $img = $request->getFile('img');
        $Service = $this->request->getPost('isService') ? 1 : 0;

        $servicesModel = new ServicesModel();
        // $lastCode = $servicesModel->select('Code')->where('idBusiness', $businessID)->orderBy('Code', 'DESC')->limit(1)->first();
        // $newCode = $lastCode ? intval($lastCode['Code']) + 1 : 1;

        $name = $this->request->getPost('name');
        $code = $this->request->getPost('code');

        $existingService = $servicesModel->where('Code', $code)->where('Name', $name)->where('idBusiness', $businessID)->first();
        if ($existingService) {
            session()->setFlashdata('error', 'The same service already exists.');
            return redirect()->to(base_url("/ServicesForm"));
        }

        $formData = [
            'BarCode' => $this->request->getPost('bcode'),
            // 'Code' => $this->request->getPost('code'),
            'Code' => $code,
            'Name' => $name,
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
            'isService' => $this->request->getPost('isService') ? 1 : 0,
            'Barcode' => $this->request->getPost('bcode'),
            'idBusiness' => $businessID,
            'idPoint_of_sale' => 1,
            'Cost' => $this->request->getPost('cost'),
            'idTVSH' => $this->request->getPost('tax'),
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
        $db = \Config\Database::connect();
        $db->transStart();

        $servicesModel->insert($formData);
        $lastInsertedId = $servicesModel->getInsertID();

        if ($Service == 0) {
            $selectedItems = $this->request->getPost('selected_items');
            $items = $this->request->getPost('items');
            $ratio = $this->request->getPost('ratio');

            if (!$selectedItems) {
                $db->transRollback();
                session()->setFlashdata('error', 'You must link this service to an item.');
                return redirect()->to(base_url("/ServicesForm"));
            }

            foreach ($selectedItems as $itemId) {
                if (isset($items[$itemId])) {
                    $itemDetails = $items[$itemId];
                    $idItem = $itemDetails['idItem'];
                    $ratio = $itemDetails['ratio'];


                    $rationData = [
                        'idArtMenu' => $lastInsertedId,
                        'idItem' => $idItem,
                        'ratio' => $ratio,
                        'idBusiness' => $businessID
                    ];

                    $servicesModel->linkItem($rationData);
                }
            }
        }

        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            session()->setFlashdata('error', 'There was an error adding the service.');
        } else {
            $db->transComplete();
            session()->setFlashdata('success', 'Service Added..!!');
        }

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
        $Service = $this->request->getPost('service') ? 1 : 0;

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
            'isService' => $Service,
            'Barcode' => $this->request->getPost('bcode'),
            'idBusiness' => $businessID,
            'idPoint_of_sale' => 1,
            'Cost' => $this->request->getPost('cost'),
            'idTVSH' => $this->request->getPost('tax'),
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
        // print_r($formData);
        // die();

        if ($Service == 0) {
            $selectedItems = $this->request->getPost('selected_items');
            $items = $this->request->getPost('items');
            $ratio = $this->request->getPost('ratio');

            if ($selectedItems) {
                $servicesModel = new ServicesModel();

                foreach ($selectedItems as $itemId) {
                    if (isset($items[$itemId])) {
                        $itemDetails = $items[$itemId];
                        $idItem = $itemDetails['idItem'];
                        // $ratio = $itemDetails['ratio'];

                        $rationData = [
                            'idArtMenu' => $idArtMenu,
                            'idItem' => $idItem,
                            'ratio' => $ratio,
                            'idBusiness' => $businessID
                        ];
                        // print_r($rationData);

                        $servicesModel->updatelinkItem($rationData);
                    }
                }
            }
        }
        return redirect()->to(base_url("/Services_table"));
    }

    public function transferItemsToServices()
    {
        $db = \Config\Database::connect();
        $servicesModel = new ServicesModel();

        $activeItems = $servicesModel->getActiveItems();
        $existingItems = $servicesModel->getServices();

        $dataInserted = false;

        foreach ($activeItems as $item) {
            $Code = $item['Code'];
            $Name = $item['Name'];

            $existing = $servicesModel->getItm($Name, $Code);

            if ($existing == 0) {
                $dataToInsertArtmenu = [
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
                    'Price' => $item['Cost'],
                    'idTVSH' => 0,
                    'noTvshType' => 0,
                ];

                $insertedId = $servicesModel->insertArtMenu($dataToInsertArtmenu);

                if ($insertedId) {
                    $dataInserted = true;

                    $ratioData = [
                        'idArtMenu' => $insertedId,
                        'idItem' => $item['idItem'],
                        'ratio' => 1,
                        'idBusiness' => $item['idBusiness'],
                    ];
                    $servicesModel->insertRatio($ratioData);
                }
            }
        }

        if ($dataInserted) {
            session()->setFlashdata('success', 'Data Transferred Successfully!');
        } else {
            session()->setFlashdata('error', 'No new data to transfer.');
        }

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

    public function transferServices()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $file = $this->request->getFile('excel_file');

        if ($file->isValid() && !$file->hasMoved()) {
            $fileExtension = $file->getClientExtension();
            if ($fileExtension != 'xlsx' && $fileExtension != 'xls') {
                return $this->response->setJSON(['success' => false, 'error' => 'Only Excel files are allowed.']);
            }

            try {
                $excelReader = IOFactory::createReaderForFile($file->getTempName());
                $spreadsheet = $excelReader->load($file->getTempName());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                $Model = new ServicesModel();
                $itemsModel = new ItemsModel();
                $totalRows = count($rows);
                $processedRows = 0;

                foreach ($rows as $key => $row) {

                    if ($key === 0 || empty(array_filter($row))) {
                        continue;
                    }

                    $serviceName = $row[1];
                    $serviceCode = $row[2];


                    $existingService = $Model->getServiceByCodeAndName($serviceCode, $serviceName, $businessID);

                    if ($existingService) {
                        $insertedServiceId = $existingService['idArtMenu'];

                        $unitName = $row[5];
                        $unit = $itemsModel->getUnitByName($unitName, $businessID);

                        $tvshValue = $row[7];
                        $taxModel = new TaxModel();
                        $taxID = $this->getTaxIdByValue($taxModel, $tvshValue, $businessID);

                        if ($unit) {
                            $idUnit = $unit['idUnit'];
                        } else {
                            $newUnit = [
                                'name' => $unitName,
                                'notes' => null,
                                'idBusiness' => $businessID,
                                'unitCode' => 000,
                            ];
                            $idUnit = $itemsModel->insertUnit($newUnit);
                        }

                        $formDataWarehouse = [
                            'Barcode' => $row[0],
                            'Name' => $serviceName,
                            'Notes' => $row[3],
                            'idCatArt' => $existingService['idCatArt'],
                            'idTVSH' => $taxID,
                            'Cost' => $row[6],
                            'idUnit' => $idUnit,
                            'Price' => $row[8],
                            'Product_mix' => $row[9],
                            'characteristic1' => $row[10],
                            'characteristic2' => $row[11],
                            'Code' => $serviceCode,
                            'idBusiness' => $businessID,
                            'status' => $row[12] ?? 'Active',
                            'noTvshType' => 1,
                            'idPoint_of_sale' => 0,
                            'isService' => 1,
                        ];

                        $Model->updateService($insertedServiceId, $formDataWarehouse);
                        session()->setFlashdata('success', 'Data updated successfully!');
                    } else {

                        $tvshValue = $row[7];
                        $taxModel = new TaxModel();
                        $taxID = $this->getTaxIdByValue($taxModel, $tvshValue, $businessID);
                        $categoryName = $row[4];
                        $category = $itemsModel->getCategoryByName($categoryName, $businessID);

                        if ($category) {
                            $idCatArt = $category['idCatArt'];
                        } else {
                            $newCategory = [
                                'name' => $categoryName,
                                'idSector' => 3,
                                'notes' => null,
                                'idBusiness' => $businessID,
                            ];
                            $idCatArt = $itemsModel->insertCategory($newCategory);
                        }

                        $unitName = $row[5];
                        $unit = $itemsModel->getUnitByName($unitName, $businessID);

                        if ($unit) {
                            $idUnit = $unit['idUnit'];
                        } else {
                            $newUnit = [
                                'name' => $unitName,
                                'notes' => null,
                                'idBusiness' => $businessID,
                                'unitCode' => 000,
                            ];
                            $idUnit = $itemsModel->insertUnit($newUnit);
                        }

                        $formDataWarehouse = [
                            'Barcode' => $row[0],
                            'Name' => $serviceName,
                            'Notes' => $row[3],
                            'idCatArt' => $idCatArt,
                            'idTVSH' => $taxID,
                            'Cost' => $row[6],
                            'idUnit' => $idUnit,
                            'Price' => $row[8],
                            'Product_mix' => $row[9],
                            'characteristic1' => $row[10],
                            'characteristic2' => $row[11],
                            'Code' => $serviceCode,
                            'idBusiness' => $businessID,
                            'status' => $row[12] ?? 'Active',
                            'noTvshType' => 1,
                            'idPoint_of_sale' => 0,
                            'isService' => 1,
                        ];

                        $insertedServiceId = $Model->insertService($formDataWarehouse);
                        session()->setFlashdata('success', 'Data imported successfully!');
                    }

                    $processedRows++;
                    $progress = ($processedRows / $totalRows) * 100;
                    $session->set('import_progress', $progress);
                }

                return $this->response->setJSON(['success' => true]);
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => 'Error reading the Excel file: ' . $e->getMessage()]);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'error' => 'An unexpected error occurred: ' . $e->getMessage()]);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'Error uploading the Excel file.']);
        }
    }
    private function getTaxIdByValue($taxModel, $tvshValue, $businessID)
    {
        $existingTax = $taxModel->getTaxByValueAndBusiness($tvshValue, $businessID);

        if ($existingTax) {
            return $existingTax['tax_id'];
        } else {
            $newTax = [
                'value' => $tvshValue,
                'start_date' => date('Y-m-d'),
                'status' => 'Active',
                'idBusiness' => $businessID,
            ];

            return $taxModel->insertTax($newTax);
        }
    }

}