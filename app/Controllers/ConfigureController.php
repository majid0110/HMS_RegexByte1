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

        $configModel = new ConfigModel();
        $configData = $configModel->getConfig($businessID);

        if (empty($configData)) {
            $configData = ['isExpiry' => 0, 'isTable' => 0];
        }

        return view('Config_Settings', ['configData' => $configData]);
    }


    // public function config_settings()
    // {
    //     $session = \Config\Services::session();
    //     $businessID = $session->get('businessID');

    //     $configModel = new ConfigModel();
    //     $configData = $configModel->getConfig($businessID);

    //     return view('Config_Settings', ['configData' => $configData]);
    // }

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


        $configModel = new ConfigModel();
        $configModel->updateConfig($businessID, ['isExpiry' => $isExpiry, 'isTable' => $isTable]);

        session()->setFlashdata('success', 'Configuration updated successfully!');
        return redirect()->to(base_url('/config_settings'));
    }

    public function createTables()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $noOfTables = $this->request->getPost('noOfTables');
        $tableModel = new TablesModel();
        for ($i = 1; $i <= $noOfTables; $i++) {

            $TableData = [
                'name' => 'Table' . $i,
                'pozX' => 0,
                'pozY' => 0,
                'Status' => 'Active',
                'notes' => 'test',
                'idBusiness' => $businessID,
                'Def' => 0,
                'idUserActive' => 0,
                'size' => 0,
                'idPoint_of_sale' => 1,
                'booking_status' => 1
            ];

            $tableModel->insert($TableData);
        }


        return redirect()->to(base_url('config_settings'));
    }
}
