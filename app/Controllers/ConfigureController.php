<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ConfigureModel;
use App\Models\TablesModel;
use App\Models\ConfigModel;
use CodeIgniter\CLI\Console;

class ConfigureController extends Controller
{
    public function configure()
    {
        return view('add_config.php');
    }


    public function config_settings()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        if (!$session->get('ID')) {
            return redirect()->to(base_url("/login"));
        }

        $Tmodel = new TablesModel();
        $data['Tables'] = $Tmodel->getTables();

        $configModel = new ConfigModel();
        $configData = $configModel->getConfig($businessID);

        if (empty($configData)) {
            $configData = ['isExpiry' => 0, 'isTable' => 0, 'enableService' => 0];
        }

        return view('Config_Settings', [
            'configData' => $configData,
            'Tables' => $data['Tables']
        ]);
    }

    public function config_form($businessTableID)
    {
        $model = new ConfigureModel('businesstype');
        $data['business'] = $model->getBusinessTypes();
        $configModel = new ConfigureModel('business');
        $data['businessData'] = $configModel->getBusinessData($businessTableID);

        return view('edit_business.php', $data);
    }

    public function update($id)
    {
        $request = \Config\Services::request();
        $model = new ConfigureModel('business');

        $businessID = $id;
        $businessData = [
            'BusinessName' => $request->getPost('BusinessName'),
            'RegName' => $request->getPost('RegName'),
            'Email' => $request->getPost('Email'),
            'Phone' => $request->getPost('Phone'),
            'Address' => $request->getPost('Address'),
            // 'businessTypeID' => $request->getPost('businessType'),
            'charges' => $request->getPost('fee'),
        ];
        //   print_r ($businessData);
        //   die();


        $model->updateBusinessData($businessID, $businessData);

        $nicImage = $request->getFile('image');

        if ($nicImage->isValid() && !$nicImage->hasMoved()) {
            $nicImageName = $nicImage->getName();
            $nicImage->move(FCPATH . 'uploads', $nicImageName);

            $model->updateBusinessImage($businessID, $nicImageName);
        }
        session()->setFlashdata('success', 'Business data updated successfully.');

        return redirect()->to(base_url('/configure'));
    }

    public function updateConfig()
    {
        $session = \Config\Services::session();
        $businessID = $this->request->getPost('businessID');
        $isExpiry = $this->request->getPost('isExpiry') ? 1 : 0;
        $isTable = $this->request->getPost('isTable') ? 1 : 0;
        $enableService = $this->request->getPost('enableService') ? 1 : 0;


        $configModel = new ConfigModel();
        $configModel->updateConfig($businessID, ['isExpiry' => $isExpiry, 'isTable' => $isTable, 'enableService' => $enableService]);

        session()->setFlashdata('success', 'Configuration updated successfully!');
        return redirect()->to(base_url('/config_settings'));
    }


    // public function createTables()
    // {
    //     $session = \Config\Services::session();
    //     $businessID = $session->get('businessID');
    //     $noOfTables = (int) $this->request->getPost('noOfTables');
    //     $tableModel = new TablesModel();

    //     $highestTable = $tableModel->select('name')
    //         ->like('name', 'Table%')
    //         ->orderBy('name', 'DESC')
    //         ->first();

    //     $start = 1;
    //     if ($highestTable) {
    //         $lastNumber = (int) filter_var($highestTable['name'], FILTER_SANITIZE_NUMBER_INT);
    //         $start = $lastNumber + 1;
    //     }

    //     for ($i = $start; $i < $start + $noOfTables; $i++) {
    //         $TableData = [
    //             'name' => 'Table' . $i,
    //             'pozX' => 0,
    //             'pozY' => 0,
    //             'Status' => 'Active',
    //             'notes' => 'test',
    //             'idBusiness' => $businessID,
    //             'Def' => 0,
    //             'idUserActive' => 0,
    //             'size' => 0,
    //             'idPoint_of_sale' => 1,
    //             'booking_status' => 0 // 0 for free, 1 for booked, 2 reserved
    //         ];

    //         $tableModel->insert($TableData);
    //     }

    //     return redirect()->to(base_url('config_settings'));
    // }


    public function createTables()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $noOfTables = (int) $this->request->getPost('noOfTables');
        $type = $this->request->getPost('type');
        $tableModel = new TablesModel();

        $prefix = ($type === 'Room') ? 'Room' : 'Table';

        $highestEntry = $tableModel->select('name')
            ->like('name', $prefix . '%')
            ->orderBy('name', 'DESC')
            ->first();

        $start = 1;
        if ($highestEntry) {
            $lastNumber = (int) filter_var($highestEntry['name'], FILTER_SANITIZE_NUMBER_INT);
            $start = $lastNumber + 1;
        }

        for ($i = $start; $i < $start + $noOfTables; $i++) {
            $data = [
                'name' => $prefix . $i,
                'pozX' => 0,
                'pozY' => 0,
                'Status' => 'Active',
                'notes' => 'test',
                'idBusiness' => $businessID,
                'Def' => 0,
                'idUserActive' => 0,
                'size' => 0,
                'idPoint_of_sale' => 1,
                'booking_status' => 0 // 0 for free, 1 for booked, 2 reserved
            ];

            $tableModel->insert($data);
        }

        return redirect()->to(base_url('config_settings'));
    }


}
