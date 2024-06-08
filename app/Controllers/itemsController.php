<?php

namespace App\Controllers;

use CodeIgniter\Controller;


use App\Models\InvoiceDetailModel;
use App\Models\ItemsInventoryModel;
use App\Models\InvoiceModel;
use App\Models\ServicesModel;
use App\Models\SectorsModel;
use App\Models\itemsModel;
use App\Models\DoctorModel;
use App\Models\ConfigModel;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

        $session = session();
        $businessID = $session->get('businessID');
        $itemsModel = new itemsModel();
        $lastCode = $itemsModel->select('Code')->where('idBusiness', $businessID)->orderBy('Code', 'DESC')->limit(1)->first();
        $newCode = $lastCode ? intval($lastCode['Code']) + 1 : 1;

        $servicesModel = new ServicesModel();
        $data = [
            'units' => $servicesModel->getUnits(),
            'categories' => $servicesModel->getCategories(),
            'tax' => $servicesModel->getTaxes(),
            'newCode' => $newCode,
        ];
        $Model = new itemsModel();
        $data['warehouse'] = $Model->getIdWarehouse();

        $configModel = new ConfigModel();
        $businessID = session()->get('businessID');
        $config = $configModel->where('businessID', $businessID)->first();
        $data['isExpiry'] = $config ? $config['isExpiry'] : 0;
        return view('items_form.php', $data);
    }

    public function category_table()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/login"));
        }
        $itemsModel = new itemsModel();
        $data['catart'] = $itemsModel->getCatartItems();

        return view('category_table', $data);
    }

    public function additem()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/login"));
        }

        $businessID = $session->get('businessID');
        $itemsModel = new itemsModel();
        $lastCode = $itemsModel->select('Code')->where('idBusiness', $businessID)->orderBy('Code', 'DESC')->limit(1)->first();
        $newCode = $lastCode ? intval($lastCode['Code']) + 1 : 1;

        $servicesModel = new ServicesModel();
        $data = [
            'units' => $servicesModel->getUnits(),
            'categories' => $servicesModel->getCategories(),
            'tax' => $servicesModel->getTaxes(),
            'newCode' => $newCode,
        ];

        $data['warehouse'] = $itemsModel->getIdWarehouse();

        $configModel = new ConfigModel();
        $config = $configModel->where('businessID', $businessID)->first();
        $data['isExpiry'] = $config ? $config['isExpiry'] : 0;

        $data['sectors'] = $itemsModel->getSectors();
        return view('items_form', $data);
    }


    // public function additem()
    // {
    //     $session = session();
    //     if (!$session->get('ID')) {
    //         return redirect()->to(base_url("/login"));
    //     }
    //     $businessID = session()->get('businessID');
    //     $itemsModel = new itemsModel();
    //     $lastCode = $itemsModel->select('Code')->where('idBusiness', $businessID)->orderBy('Code', 'DESC')->limit(1)->first();
    //     $newCode = $lastCode ? intval($lastCode['Code']) + 1 : 1;

    //     $servicesModel = new ServicesModel();
    //     $data = [
    //         'units' => $servicesModel->getUnits(),
    //         'categories' => $servicesModel->getCategories(),
    //         'tax' => $servicesModel->getTaxes(),
    //         'newCode' => $newCode,
    //     ];
    //     $Model = new itemsModel();
    //     $data['warehouse'] = $Model->getIdWarehouse();

    //     $configModel = new ConfigModel();
    //     $businessID = session()->get('businessID');
    //     $config = $configModel->where('businessID', $businessID)->first();
    //     $data['isExpiry'] = $config ? $config['isExpiry'] : 0;

    //     return view('items_form.php', $data);
    // }

    public function addcat()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/login"));
        }
        $Model = new itemsModel();
        $data['sectors'] = $Model->getSectors();

        return view('cat_form.php', $data);
    }

    public function cat_form_dialog()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/login"));
        }
        $Model = new itemsModel();
        $data['sectors'] = $Model->getSectors();

        return view('cat_form_dialog.php', $data);
    }


    // public function items_table()
    // {

    //     $session = session();
    //     if (!$session->get('ID')) {
    //         return redirect()->to(base_url("/login"));
    //     }
    //     $model = new itemsModel();
    //     $data['items'] = $model->getItems();
    //     return view('items_table', $data);
    // }

    public function items_table()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/login"));
        }

        $servicesModel = new ServicesModel();
        $data = [
            'units' => $servicesModel->getUnits(),
            'categories' => $servicesModel->getCategories(),
            'tax' => $servicesModel->getTaxes(),
        ];
        $Model = new itemsModel();
        $data['warehouse'] = $Model->getIdWarehouse();
        $configModel = new ConfigModel();
        $businessID = session()->get('businessID');
        $config = $configModel->where('businessID', $businessID)->first();
        $data['isExpiry'] = $config ? $config['isExpiry'] : 0;


        $model = new itemsModel();

        $currentPage = $this->request->getVar('page') ? (int) $this->request->getVar('page') : 1;
        $perPage = 20;

        $data['items'] = $model->getItems($perPage, $currentPage);

        $pager = service('pager');
        $total = $model->getItemsCount();
        $data['pager'] = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return view('items_table', $data);
    }

    // public function edititem($idItem)
    // {
    //     $servicesModel = new ServicesModel();
    //     $data = [
    //         'units' => $servicesModel->getUnits(),
    //         'categories' => $servicesModel->getCategories(),
    //         'tax' => $servicesModel->getTaxes(),
    //     ];
    //     $Model = new itemsModel();
    //     $data['warehouse'] = $Model->getIdWarehouse();
    //     $data['item'] = $Model->find($idItem);

    //     $inventoryModel = new ItemsInventoryModel();
    //     $inventory = $inventoryModel->getInventoryByItemId($idItem);
    //     $data['item']['inventory'] = $inventory ? $inventory['inventory'] : '';

    //     $data['expiries'] = $inventoryModel->getExpiriesByInventoryId($inventory['idInventory']);

    //     $configModel = new ConfigModel();
    //     $businessID = session()->get('businessID');
    //     $config = $configModel->where('businessID', $businessID)->first();
    //     $data['isExpiry'] = $config ? $config['isExpiry'] : 0;

    //     return view('edit_item_form.php', $data);
    // }

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
        $data['item'] = $Model->find($idItem);

        $inventoryModel = new ItemsInventoryModel();
        $inventory = $inventoryModel->getInventoryByItemId($idItem);

        $data['item']['inventory'] = $inventory ? $inventory['inventory'] : '';
        $idInventory = $inventory['idInventory'] ?? null;

        $data['expiries'] = $inventoryModel->getExpiriesByItemId($idItem);


        $configModel = new ConfigModel();
        $businessID = session()->get('businessID');
        $config = $configModel->where('businessID', $businessID)->first();
        $data['isExpiry'] = $config ? $config['isExpiry'] : 0;

        return view('edit_item_form.php', $data);
    }


    public function editcat($idCatArt)
    {
        $Model = new itemsModel();
        $data['category'] = $Model->getCatartCategory($idCatArt); // Fetch category data to pre-fill the form
        $data['sectors'] = $Model->getSectors();

        return view('edit_cat.php', $data);
    }

    public function sectors_table()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/login"));
        }
        $model = new itemsModel();
        $data['sectors'] = $model->getSectors();
        return view('sectors_table', $data);
    }

    public function sectors_form()
    {
        return view('sector_form.php');
    }

    public function specilization_table()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/login"));
        }
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $model = new DoctorModel();
        $data['Specialization'] = $model->getSpecialization($businessID);
        return view('specilization_table', $data);
    }

    public function specilization_form()
    {
        return view('specialization_form.php');
    }





    //-------------------------------------------------------------------------------------------------------------------------
//                                                 Main Logic
//-------------------------------------------------------------------------------------------------------------------------

    public function saveitems()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();

        $businessID = $session->get('businessID');
        $idWarehouse = $this->request->getPost('warehouse');
        $Inventory = $this->request->getPost('inventory');

        $itemsModel = new itemsModel();
        $lastCode = $itemsModel->select('Code')->where('idBusiness', $businessID)->orderBy('Code', 'DESC')->limit(1)->first();
        $newCode = $lastCode ? intval($lastCode['Code']) + 1 : 1;

        $code = $this->request->getPost('code');
        $name = $this->request->getPost('name');

        $existingService = $itemsModel->where('Code', $code)->where('Name', $name)->where('idBusiness', $businessID)->first();
        if ($existingService) {
            session()->setFlashdata('error', 'The same service already exists.');
            return redirect()->to(base_url("/items_table"));
        }


        $formData = [
            'barcode' => $this->request->getPost('bcode'),
            // 'Code' => $this->request->getPost('code'),
            'Code' => $code,
            'Name' => $this->request->getPost('name'),
            'Cost' => $this->request->getpost('cost'),
            'Minimum' => $this->request->getpost('min'),
            'Notes' => $this->request->getPost('notes'),
            'idBusiness' => $businessID,
            'idTAX' => $this->request->getPost('tax'),
            'idCategories' => $this->request->getPost('category'),
            'Unit' => $this->request->getPost('Unit'),
            'idWarehouse' => $idWarehouse,
            'status' => $this->request->getPost('cstatus'),
            'characteristic1' => $this->request->getPost('char_1'),
            'Characteristic2' => $this->request->getPost('char_2'),
            'isSendEmail' => 1,
            'isSendExpire' => 0,
        ];

        $insertedItemId = $itemsModel->insertItemWarehouse($formData);
        $formDataInventory = [
            'idItem' => $insertedItemId,
            'inventory' => $Inventory,
            'idWarehouse' => $idWarehouse,
        ];
        $IdInventory = $itemsModel->insertItemInventory($formDataInventory);


        $isExpiry = $itemsModel->isExpiry($businessID);

        if ($isExpiry == 1) {
            $ItemExpiry = [
                'idInventory' => $IdInventory,
                'inventory' => $Inventory,
                'expiryDate' => $this->request->getPost('expiry'),
            ];
            $itemsModel->insertItemExpiry($ItemExpiry);
        }

        session()->setFlashdata('success', 'Item Added..!!');
        return redirect()->to(base_url("/items_table"));
    }

    // public function transferItems()
    // {
    //     $session = \Config\Services::session();
    //     $businessID = $session->get('businessID');

    //     $file = $this->request->getFile('excel_file');

    //     if ($file->isValid() && !$file->hasMoved()) {
    //         $fileExtension = $file->getClientExtension();
    //         if ($fileExtension != 'xlsx' && $fileExtension != 'xls') {
    //             return $this->response->setJSON(['error' => 'Only Excel files are allowed.']);
    //         }

    //         try {
    //             $excelReader = IOFactory::createReaderForFile($file->getTempName());
    //             $spreadsheet = $excelReader->load($file->getTempName());
    //             $worksheet = $spreadsheet->getActiveSheet();
    //             $rows = $worksheet->toArray();

    //             $totalRows = count($rows);
    //             $itemsModel = new ItemsModel();

    //             foreach ($rows as $key => $row) {
    //                 if ($key === 0 || empty(array_filter($row))) {
    //                     continue;
    //                 }

    //                 $itemName = $row[1];
    //                 $itemCode = $row[14];

    //                 $existingItem = $itemsModel->getItemByCodeAndName($itemCode, $itemName, $businessID);

    //                 if ($existingItem) {
    //                     $insertedItemId = $existingItem['idItem'];

    //                     $unitName = $row[6];
    //                     $unit = $itemsModel->getUnitByName($unitName, $businessID);

    //                     if ($unit) {
    //                         $idUnit = $unit['idUnit'];
    //                     } else {
    //                         $newUnit = [
    //                             'name' => $unitName,
    //                             'notes' => null,
    //                             'idBusiness' => $businessID,
    //                             'unitCode' => 000,
    //                         ];
    //                         $idUnit = $itemsModel->insertUnit($newUnit);
    //                     }

    //                     $formDataWarehouse = [
    //                         'barcode' => $row[0],
    //                         'Name' => $itemName,
    //                         'Notes' => $row[2],
    //                         'idCategories' => $existingItem['idCategories'],
    //                         'idTAX' => $row[4],
    //                         'idWarehouse' => $row[5],
    //                         'Unit' => $idUnit,
    //                         'Cost' => $row[7],
    //                         'Minimum' => $row[9],
    //                         'characteristic1' => $row[10],
    //                         'characteristic2' => $row[11],
    //                         'Code' => $itemCode,
    //                         'idBusiness' => $businessID,
    //                         'status' => 'Active',
    //                         'isSendEmail' => 1,
    //                         'isSendExpire' => 0,
    //                     ];

    //                     $itemsModel->updateItemWarehouse($insertedItemId, $formDataWarehouse);
    //                 } else {
    //                     $categoryName = $row[3];
    //                     $category = $itemsModel->getCategoryByName($categoryName, $businessID);

    //                     if ($category) {
    //                         $idCatArt = $category['idCatArt'];
    //                     } else {
    //                         $newCategory = [
    //                             'name' => $categoryName,
    //                             'idSector' => 3,
    //                             'notes' => null,
    //                             'idBusiness' => $businessID,
    //                         ];
    //                         $idCatArt = $itemsModel->insertCategory($newCategory);
    //                     }

    //                     $unitName = $row[6];
    //                     $unit = $itemsModel->getUnitByName($unitName, $businessID);

    //                     if ($unit) {
    //                         $idUnit = $unit['idUnit'];
    //                     } else {
    //                         $newUnit = [
    //                             'name' => $unitName,
    //                             'notes' => null,
    //                             'idBusiness' => $businessID,
    //                             'unitCode' => 000,
    //                         ];
    //                         $idUnit = $itemsModel->insertUnit($newUnit);
    //                     }

    //                     $formDataWarehouse = [
    //                         'barcode' => $row[0],
    //                         'Name' => $itemName,
    //                         'Notes' => $row[2],
    //                         'idCategories' => $idCatArt,
    //                         'idTAX' => $row[4],
    //                         'idWarehouse' => $row[5],
    //                         'Unit' => $idUnit,
    //                         'Cost' => $row[7],
    //                         'Minimum' => $row[9],
    //                         'characteristic1' => $row[10],
    //                         'characteristic2' => $row[11],
    //                         'Code' => $itemCode,
    //                         'idBusiness' => $businessID,
    //                         'status' => 'Active',
    //                         'isSendEmail' => 1,
    //                         'isSendExpire' => 0,
    //                     ];

    //                     $insertedItemId = $itemsModel->insertItemWarehouse($formDataWarehouse);
    //                 }

    //                 $formDataInventory = [
    //                     'idItem' => $insertedItemId,
    //                     'inventory' => $row[8],
    //                     'idWarehouse' => $row[5],
    //                 ];

    //                 $itemsModel->insertOrUpdateItemInventory($formDataInventory);

    //                 // Send progress update
    //                 $progress = round(($key / $totalRows) * 100);
    //                 echo json_encode(['progress' => $progress]);
    //                 ob_flush();
    //                 flush();
    //             }

    //             // return $this->response->setJSON(['success' => 'Excel file processed successfully.']);
    //             return redirect()->to(base_url("/items_table"));
    //             // return $this->response->setJSON(['success' => 'Excel file processed successfully.', 'redirect' => base_url('/items_table')]);
    //         } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
    //             return $this->response->setJSON(['error' => 'Error reading the Excel file: ' . $e->getMessage()]);
    //         } catch (\Exception $e) {
    //             return $this->response->setJSON(['error' => 'An unexpected error occurred: ' . $e->getMessage()]);
    //         }
    //     } else {
    //         return $this->response->setJSON(['error' => 'Error uploading the Excel file.']);
    //     }
    // }





    public function transferItems()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        $file = $this->request->getFile('excel_file');

        if ($file->isValid() && !$file->hasMoved()) {
            $fileExtension = $file->getClientExtension();
            if ($fileExtension != 'xlsx' && $fileExtension != 'xls') {
                session()->setFlashdata('error', 'Only Excel files are allowed.');
                return redirect()->back();
            }

            try {
                $excelReader = IOFactory::createReaderForFile($file->getTempName());
                $spreadsheet = $excelReader->load($file->getTempName());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                $itemsModel = new ItemsModel();

                foreach ($rows as $key => $row) {
                    if ($key === 0 || empty(array_filter($row))) {
                        continue;
                    }

                    $itemName = $row[1];
                    $itemCode = $row[14];

                    $existingItem = $itemsModel->getItemByCodeAndName($itemCode, $itemName, $businessID);

                    if ($existingItem) {
                        $insertedItemId = $existingItem['idItem'];

                        $unitName = $row[6];
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
                            'barcode' => $row[0],
                            'Name' => $itemName,
                            'Notes' => $row[2],
                            'idCategories' => $existingItem['idCategories'],
                            'idTAX' => $row[4],
                            'idWarehouse' => $row[5],
                            'Unit' => $idUnit,
                            'Cost' => $row[7],
                            'Minimum' => $row[9],
                            'characteristic1' => $row[10],
                            'characteristic2' => $row[11],
                            'Code' => $itemCode,
                            'idBusiness' => $businessID,
                            'status' => 'Active',
                            'isSendEmail' => 1,
                            'isSendExpire' => 0,
                        ];

                        $itemsModel->updateItemWarehouse($insertedItemId, $formDataWarehouse);
                        session()->setFlashdata('success', 'Data updated successfully!');
                    } else {
                        $categoryName = $row[3];
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

                        $unitName = $row[6];
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
                            'barcode' => $row[0],
                            'Name' => $itemName,
                            'Notes' => $row[2],
                            'idCategories' => $idCatArt,
                            'idTAX' => $row[4],
                            'idWarehouse' => $row[5],
                            'Unit' => $idUnit,
                            'Cost' => $row[7],
                            'Minimum' => $row[9],
                            'characteristic1' => $row[10],
                            'characteristic2' => $row[11],
                            'Code' => $itemCode,
                            'idBusiness' => $businessID,
                            'status' => 'Active',
                            'isSendEmail' => 1,
                            'isSendExpire' => 0,
                        ];

                        $insertedItemId = $itemsModel->insertItemWarehouse($formDataWarehouse);
                        session()->setFlashdata('success', 'Data imported successfully!');
                    }

                    $formDataInventory = [
                        'idItem' => $insertedItemId,
                        'inventory' => $row[8],
                        'idWarehouse' => $row[5],
                    ];

                    $itemsModel->insertOrUpdateItemInventory($formDataInventory);
                }

                return redirect()->to(base_url("/items_table"));
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                session()->setFlashdata('error', 'Error reading the Excel file: ' . $e->getMessage());
                return redirect()->back();
            } catch (\Exception $e) {
                session()->setFlashdata('error', 'An unexpected error occurred: ' . $e->getMessage());
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', 'Error uploading the Excel file.');
            return redirect()->back();
        }
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
        $idWarehouse = $this->request->getPost('warehouse');

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
            'idWarehouse' => $idWarehouse,
            'status' => $this->request->getPost('cstatus'),
            'characteristic1' => $this->request->getPost('char_1'),
            'Characteristic2' => $this->request->getPost('char_2'),
            'isSendEmail' => 1,
            'isSendExpire' => 0,
        ];

        $Model->update($idItem, $formData);

        $formDataInventory = [
            'inventory' => $this->request->getPost('inventory'),
            'idWarehouse' => $idWarehouse,
        ];

        $inventoryModel = new ItemsInventoryModel();
        $inventory = $inventoryModel->getInventoryByItemId($idItem);

        if ($inventory) {
            $inventoryModel->updateInventory($inventory['idInventory'], $formDataInventory['inventory']);
        } else {
            $formDataInventory['idItem'] = $idItem;
            $inventoryModel->insert($formDataInventory);
        }

        session()->setFlashdata('success', 'Service updated successfully..!!');
        return redirect()->to(base_url("/items_table"));
    }

    // public function updateExpiry($idItem)
    // {
    //     $request = \Config\Services::request();
    //     $Model = new itemsModel();
    //     $expiryModel = new ItemsInventoryModel();

    //     $session = \Config\Services::session();
    //     $businessID = $session->get('businessID');
    //     $idWarehouse = $this->request->getPost('warehouse');

    //     $expiryInventory = $this->request->getPost('expiry_inventory');
    //     $expiryDates = $this->request->getPost('expiry_date');
    //     $removeExpiryIds = array_filter($this->request->getPost('remove_expiry_ids')); 

    //     $mainInventory = $this->request->getPost('mainInventory');
    //     $totalExpiryInventory = array_sum($expiryInventory);


    //     if ($totalExpiryInventory > $mainInventory) {
    //         session()->setFlashdata('error', 'The total expiry inventory cannot exceed the main inventory.');
    //         return redirect()->to(base_url('edititem/' . $idItem));
    //     }

    //     if ($removeExpiryIds) {
    //         foreach ($removeExpiryIds as $expiryID) {
    //             if (!empty($expiryID)) {
    //                 $affectedRows = $expiryModel->deleteExpiry($expiryID);
    //                 if ($affectedRows === 0) {
    //                     log_message('error', 'Failed to delete expiry record with ID: ' . $expiryID);
    //                 }
    //             }
    //         }
    //     }

    //     if ($expiryInventory && $expiryDates) {
    //         foreach ($expiryInventory as $expiryID => $inventory) {
    //             $expiryDate = $expiryDates[$expiryID];
    //             $expiryData = [
    //                 'idInventory' => $idItem,
    //                 'inventory' => $inventory,
    //                 'expiryDate' => $expiryDate,
    //             ];

    //             if (is_numeric($expiryID) && $expiryID > 0) {
    //                 $expiryModel->updateExpiryByInventoryAndDate($idItem, $expiryDate, $expiryData);
    //             } else {
    //                 $expiryModel->insertExpiry($expiryData);
    //             }
    //         }
    //     }

    //     session()->setFlashdata('success', 'Expiry details updated successfully!');
    //     return redirect()->to(base_url('edititem/' . $idItem));
    // }

    public function updateExpiry($idItem)
    {
        $request = \Config\Services::request();
        $itemModel = new itemsModel();
        $expiryModel = new ItemsInventoryModel();
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $idWarehouse = $this->request->getPost('idWarehouse');


        $inventoryRecord = $expiryModel->getInventoryId($idItem, $idWarehouse);
        $idInventory = $inventoryRecord['idInventory'] ?? null;


        if (!$idInventory) {
            session()->setFlashdata('error', 'Invalid item or warehouse.');
            return redirect()->to(base_url('edititem/' . $idItem));
        }

        $expiryInventory = $this->request->getPost('expiry_inventory');
        $expiryDates = $this->request->getPost('expiry_date');
        $removeExpiryIds = array_filter($this->request->getPost('remove_expiry_ids')); // Filter out empty values

        $mainInventory = $inventoryRecord['inventory'];
        $totalExpiryInventory = array_sum($expiryInventory);

        if ($totalExpiryInventory > $mainInventory) {
            session()->setFlashdata('error', 'The total expiry inventory cannot exceed the main inventory.');
            return redirect()->to(base_url('edititem/' . $idItem));
        }

        if ($removeExpiryIds) {
            foreach ($removeExpiryIds as $expiryID) {
                if (!empty($expiryID)) {
                    $affectedRows = $expiryModel->deleteExpiry($expiryID);
                    if ($affectedRows === 0) {
                        log_message('error', 'Failed to delete expiry record with ID: ' . $expiryID);
                    }
                }
            }
        }

        if ($expiryInventory && $expiryDates) {
            foreach ($expiryInventory as $expiryID => $inventory) {
                $expiryDate = $expiryDates[$expiryID];
                $expiryData = [
                    'idInventory' => $idInventory,
                    'inventory' => $inventory,
                    'expiryDate' => $expiryDate,
                ];

                $existingExpiry = $expiryModel->findExpiryByInventoryAndDate($idInventory, $expiryDate);

                if ($existingExpiry) {
                    $expiryModel->updateExpiryByInventoryAndDate($idInventory, $expiryDate, $expiryData);
                } else {
                    $expiryModel->insertExpiry($expiryData);
                }

                // if (is_numeric($expiryID) && $expiryID > 0) {
                //     $expiryModel->updateExpiryByInventoryAndDate($idInventory, $expiryDate, $expiryData);
                // } else {
                //     $expiryModel->insertExpiry($expiryData);
                // }
            }
        }

        session()->setFlashdata('success', 'Expiry details updated successfully!');
        return redirect()->to(base_url('edititem/' . $idItem));
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

    public function saveCatart_fromDialog()
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

        session()->setFlashdata('success', 'Category Added..!!');
        return redirect()->to(base_url("/ServicesForm"));
    }

    public function saveCatart_fromitemsDialog()
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

        session()->setFlashdata('success', 'Category Added..!!');
        return redirect()->to(base_url("/additem"));
    }
    public function deletecat($idCatArt)
    {

        try {
            $Model = new itemsModel();
            $Model->deletecat($idCatArt);
            session()->setFlashdata('success', 'Category deleted...!!');

            return redirect()->to(base_url("/category_table"));

        } catch (\Exception $e) {
            log_message('error', 'Error retrieving data: ' . $e->getMessage());
            session()->setFlashdata('error', 'DataBase Error: ' . $e->getMessage());
            return redirect()->to(base_url("/category_table"));
        }
    }

    public function updatecat($idCatArt)
    {
        $request = \Config\Services::request();
        $Model = new itemsModel();

        $formData = [
            'name' => $this->request->getPost('name'),
            'idSector' => $this->request->getPost('id_sec'),
            'notes' => $this->request->getPost('notes'),
        ];

        $Model->updateCatart($idCatArt, $formData);

        session()->setFlashdata('success', 'Category updated successfully..!!');
        return redirect()->to(base_url("/category_table"));
    }
    public function saveSector()
    {
        $Model = new SectorsModel();
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $businessID = $session->get('businessID');

        $data = [

            'name' => $this->request->getPost('name'),
            'PrintOutput' => $this->request->getPost('printOutput'),
            'notes' => $this->request->getPost('notes'),
            'TVSH' => $this->request->getPost('TVSH'),
            'idBusiness' => $businessID,
        ];


        $Model->saveSector($data);

        return redirect()->to(base_url('/sectors_table'))->with('success', 'Sector added successfully.');
    }

    public function deletesector($idSector)
    {

        try {
            $Model = new itemsModel();
            $Model->deleteSector($idSector);
            session()->setFlashdata('success', 'Sector deleted...!!');

            return redirect()->to(base_url("/sectors_table"));

        } catch (\Exception $e) {
            log_message('error', 'Error retrieving data: ' . $e->getMessage());
            session()->setFlashdata('error', 'DataBase Error: ' . $e->getMessage());
            return redirect()->to(base_url("/sectors_table"));
        }
    }
    public function editsector($idSector)
    {
        $Model = new itemsModel();
        $data['sector'] = $Model->getSector($idSector);

        return view('edit_Sector', $data);
    }

    public function updateSector($idSector)
    {
        $Model = new SectorsModel();
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $businessID = $session->get('businessID');

        $data = [

            'name' => $this->request->getPost('name'),
            'PrintOutput' => $this->request->getPost('printOutput'),
            'notes' => $this->request->getPost('notes'),
            'TVSH' => $this->request->getPost('TVSH'),
            'idBusiness' => $businessID,
        ];
        $Model->update($idSector, $data);

        session()->setFlashdata('success', 'Sector Updated...!!');

        return redirect()->to(base_url("/sectors_table"));
    }

    public function saveSpecialization()
    {


        $Model = new DoctorModel();
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $businessID = $session->get('businessID');

        $data = [

            'specialization_N' => $this->request->getPost('specialization_name'),
            'Description' => $this->request->getPost('description'),
            'idBusiness' => $businessID,
        ];

        $Model->saveSpecialization($data);
        return redirect()->to(base_url('/specilization_table'))->with('success', 'Sector added successfully.');
    }

}