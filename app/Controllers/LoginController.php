<?php

namespace App\Controllers;

use App\Models\ClientModel;
use CodeIgniter\Controller;

use App\Models\LoginModel;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;
use App\Models\RoleModel;
use App\Models\itemsModel;
use App\Models\ConfigModel;
use App\Models\ItemsInventoryModel;
use App\Models\ExpenseModel;
use App\Models\InvoiceModel;
use App\Models\OpdModel;
use App\Models\TestModel;
use App\Models\UserModel;



class LoginController extends Controller
{


    public function show()
    {
        return view('login.php');
    }

    public function session_expired()
    {
        return view('session_expired.php');
    }

    public function view_role()
    {
        $roleModel = new RoleModel();
        $rolesWithPermissions = $roleModel->getAllRolesWithPermissions();
        return view('view_role', ['rolesWithPermissions' => $rolesWithPermissions]);
    }

    public function edit_role($roleID)
    {
        $moduleModel = new LoginModel('modules');
        $data['moduleNames'] = $moduleModel->getModuleNames();
        $rolesModel = new LoginModel('role');
        $modulePermissionsModel = new LoginModel('role_permissions');

        $data['role'] = $rolesModel->find($roleID);
        // $data['moduleNames'] = $rolesModel->getModuleNames();
        $data['rolePermissions'] = $modulePermissionsModel->getRolePermission($roleID);

        // print_r($data);

        return view('edit_role', $data);
    }

    public function role_form()
    {
        $moduleModel = new LoginModel('modules');
        $data['moduleNames'] = $moduleModel->getModuleNames();

        return view('add_role.php', $data);
    }


    public function business_table()
    {
        $businessModel = new LoginModel('business');
        $data['businessData'] = $businessModel->getBusinessTable();

        return view('business_table', $data);
    }
    public function user_form()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
        $Model = new LoginModel('businesstype');
        $data['business'] = $Model->getAllBusinessTypes();

        return view('add_business.php', $data);
    }

    public function user_form2()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
        $Model = new LoginModel('role');
        $data['roleName'] = $Model->getAllRoles('role');

        return view('add_user.php', $data);
    }


    public function users_table()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
        $model = new LoginModel('users');
        $data['userDetails'] = $model->getuserprofile();
        return view('users_table.php', $data);
    }

    public function edit_user($user_id)
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
        $model = new LoginModel('users');
        $data['userData'] = $model->get_user_by_id($user_id);
        $Model = new LoginModel('role');
        $data['roleName'] = $Model->getAllRoles('role');
        return view('edit_user.php', $data);
    }
    public function update_role($roleID)
    {

        $roleName = $this->request->getPost('role_name');
        $roleDescription = $this->request->getPost('role_description');
        $modulePermissions = $this->request->getPost('module_permissions');

        $roleModel = new RoleModel();
        $role = $roleModel->find($roleID);
        if (!$role) {
            return redirect()->to(base_url('roles'))->with('error', 'Role not found.');
        }
        $roleData = [
            'role_name' => $roleName,
            'role_description' => $roleDescription,
        ];
        $roleModel->update($roleID, $roleData);
        $rolePermissions = [];
        foreach ($modulePermissions as $moduleID => $permissions) {
            $rolePermissions[] = [
                'roleID' => $roleID,
                'moduleID' => $moduleID,
                'can_view' => isset($permissions['view']) ? 1 : 0,
                'can_insert' => isset($permissions['add']) ? 1 : 0,
                'can_update' => isset($permissions['update']) ? 1 : 0,
                'can_delete' => isset($permissions['delete']) ? 1 : 0,
            ];
        }
        $permissionModel = new LoginModel('role_permissions');
        $permissionModel->updateRolePermissions($roleID, $rolePermissions);
        return redirect()->to(base_url('view_role'))->with('success', 'Role updated successfully.');
    }


    //------------------------------------------------------------------------------------------------------------------------
//                                                                     Functions
//------------------------------------------------------------------------------------------------------------------------
    public function dashboard()
    {
        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/session_expired"));
        }
        $businessID = session()->get('businessID');



        $businessModel = new LoginModel('business');
        $business = $businessModel->find($businessID);
        $businessTypeID = $business['businessTypeID'];

        $businessTypeModel = new LoginModel('businesstype');
        $businessType = $businessTypeModel->find($businessTypeID);
        $isHospital = strtolower($businessType['businessType']) === 'hospital';
        $data['isHospital'] = $isHospital;

        $itemModel = new itemsModel();
        $data['expiringItems'] = $itemModel->getExpiringItems($businessID);

        $configModel = new ConfigModel();
        $config = $configModel->where('businessID', $businessID)->first();
        $data['isExpiry'] = $config ? $config['isExpiry'] : 0;

        $model = new DoctorModel();
        $totalDoctorCount = $model->countDoctorsByBusinessID($businessID);
        $data['totalDoctorCount'] = $totalDoctorCount;

        $totalItemCount = $itemModel->countItemsByBusinessID($businessID);
        $data['totalItemCount'] = $totalItemCount;

        $inventoryModel = new ItemsInventoryModel();
        $totalInventoryCount = $inventoryModel->countInventoryByBusinessID($businessID);
        $data['totalInventoryCount'] = $totalInventoryCount;

        $totalSalesToday = $inventoryModel->countInvoicesToday($businessID);
        $data['totalSalesToday'] = $totalSalesToday;

        $totalSaleValueToday = $inventoryModel->sumInvoiceValuesToday($businessID);
        $data['totalSaleValueToday'] = $totalSaleValueToday ?? 0;


        $expenseModel = new ExpenseModel();
        $data['categories'] = $expenseModel->getExpenseCategories();
        $data['users'] = $expenseModel->getUsers();

        $Model = new ClientModel();
        $data['client_names'] = $Model->getClientNames();
        $totalClientCount = $Model->countClientsByBusinessID($businessID);
        $data['totalClientCount'] = $totalClientCount;
        $appointmentModel = new AppointmentModel();
        $totalAppointmentsCount = $appointmentModel->countAppointmentsByBusinessID($businessID);
        $data['totalAppointmentsCount'] = $totalAppointmentsCount;
        // Get most recent appointments countInventoryByBusinessID
        $data['recentAppointments'] = $appointmentModel->getRecentAppointmentsByBusinessID($businessID, 6);
        // Combine the data
        $totalAppointmentsRevenue = $appointmentModel->getTotalAppointmentsRevenue($businessID);
        $data['totalAppointmentsRevenue'] = $totalAppointmentsRevenue;

        $totalChargesRevenue = $appointmentModel->getTotalChargesRevenue($businessID);
        $data['totalChargesRevenue'] = $totalChargesRevenue;
        $labModel = new LoginModel('labtest');
        $totalLabChargesRevenue = $labModel->getTotalLabHospitalRevenue($businessID);
        $data['totalTestHospitalRevenue'] = $totalLabChargesRevenue;
        $appointmentsData = $appointmentModel->fetchAppointmentData($businessID);
        $data['appointmentsData'] = $appointmentsData;
        $totalAppointments = $appointmentModel->countTotalAppointments();
        $data['totalAppointments'] = $totalAppointments;
        $data['doctorDetails'] = $model->getDoctorByBusinessID($businessID);
        $model = new LoginModel('test_type');
        $data['TestDetails'] = $model->getRecentTestsByBusinessID($businessID);
        $getAllBusinessUsers = new LoginModel('users');
        $data['userDetails'] = $getAllBusinessUsers->getuserprofile();
        $model = new LoginModel('labtestdetails');
        $totalTests = $model->getTotalTests($businessID);

        $TotalExpenditure = $model->getTotalExpenditure();
        $data['TotalExpenditure'] = $TotalExpenditure;

        $TotalMonthlyExpenditure = $model->getMonthlyExpenditure();
        $data['TotalMonthlyExpenditure'] = $TotalMonthlyExpenditure;

        // --------------------------------------------
        $period = $this->request->getVar('period') ?? 'week';

        $InvoiceModel = new InvoiceModel();
        $data['period'] = $period;

        switch ($period) {
            case 'month':
                $salesData = $InvoiceModel->getMonthlySalesData($businessID);
                break;
            case 'year':
                $salesData = $InvoiceModel->getYearlySalesData($businessID);
                break;
            default:
                $salesData = $InvoiceModel->getWeeklySalesData($businessID);
                break;
        }

        $data['salesData'] = $salesData;

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['salesData' => $salesData]);
        }
        // ------------------------------------------------

        $opdModel = new OpdModel();
        $totalOPDRevenue = $opdModel->getTotalOPDRevenue($businessID);
        $data['totalOPDRevenue'] = $totalOPDRevenue;

        $data['totalTests'] = $totalTests;
        $InvoiceModel = new LoginModel('invoices');
        $totalServiceRevenue = $InvoiceModel->getTotalServiceRevenue($businessID);
        $data['totalServiceRevenue'] = $totalServiceRevenue;

        $MonthlyServiceRevenue = $InvoiceModel->getMonthlyServiceRevenue($businessID);
        $MonthlyppointmentsRevenue = $appointmentModel->getMonthlyAppointmentsRevenue($businessID);
        $MonthlyOPDRevenue = $opdModel->getMonthlyOPDRevenue($businessID);

        $MonthlyTestRevenue = $InvoiceModel->getMonthlyTestRevenue($businessID);
        $MonthlyRevenue = $MonthlyServiceRevenue + $MonthlyppointmentsRevenue + $MonthlyTestRevenue + $MonthlyOPDRevenue;
        $data['MonthlyRevenue'] = $MonthlyRevenue;

        $labModel = new LoginModel('labtest');
        $totalTestRevenue = $labModel->getTotalTestRevenue($businessID);
        $data['totalTestRevenue'] = $totalTestRevenue;
        $totalRevenue = $totalServiceRevenue + $totalAppointmentsRevenue + $totalTestRevenue + $totalOPDRevenue;
        $data['totalRevenue'] = $totalRevenue;
        $totalHospitalRevenue = $totalServiceRevenue + $totalLabChargesRevenue + $totalChargesRevenue;
        $data['totalHospitalRevenue'] = $totalHospitalRevenue;
        $monthlyData = $appointmentModel->getMonthlyHospitalCharges($businessID);
        $InvoiceModel = new LoginModel('invoices');
        $monthlyHospitalCharges = $InvoiceModel->getMonthlyHospitalCharges($businessID);
        $LabModel = new LoginModel('labtest');
        $monthlyLabCharges = $LabModel->getMonthlyLabHospitalCharges($businessID);

        // --------------------------------------------------------------------------

        $opdModel = new OpdModel();
        $monthlyOPDFees = $opdModel->getMonthlyOPDFees($businessID);

        $invoiceModel = new InvoiceModel();
        $monthlySalesFees = $invoiceModel->getMonthlySalesFees($businessID);

        $labTestModel = new TestModel();
        $monthlyLabFees = $labTestModel->getMonthlyLabFees($businessID);

        $appointmentModel = new AppointmentModel();
        $monthlyAppointmentFees = $appointmentModel->getMonthlyAppointmentFees($businessID);

        $combinedData = [];
        foreach (range(1, 12) as $month) {
            $combinedData[$month] = [
                'label' => date('F', mktime(0, 0, 0, $month, 1)),
                'appointment' => 0,
                'lab' => 0,
                'sales' => 0,
                'opd' => 0
            ];
        }

        foreach ($monthlyAppointmentFees as $item) {
            $combinedData[$item['month']]['appointment'] = $item['total'];
        }
        foreach ($monthlyLabFees as $item) {
            $combinedData[$item['month']]['lab'] = $item['total'];
        }
        foreach ($monthlySalesFees as $item) {
            $combinedData[$item['month']]['sales'] = $item['total'];
        }
        foreach ($monthlyOPDFees as $item) {
            $combinedData[$item['month']]['opd'] = $item['total'];
        }

        $data['combinedData'] = array_values($combinedData);


        $session = session();
        if (!$session->get('ID')) {
            return redirect()->to(base_url("/login"));
        }
        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $this->response->setHeader('Pragma', 'no-cache');
        return view('dashboard.php', $data);
    }


    public function save_role()
    {
        $db = \Config\Database::connect();
        $request = service('request');
        $roleTitle = $request->getPost('role_title');
        $roleDescription = $request->getPost('role_description');
        $modulePermissions = $request->getPost('module_permissions');
        $session = session();
        $businessID = $session->get('businessID');

        $db->transBegin();

        $data = [
            'role_name' => $roleTitle,
            'role_description' => $roleDescription,
            'businessID' => $businessID,
        ];

        $rolesModel = new LoginModel('role');
        $roleID = $rolesModel->save_role($data);

        if ($roleID) {
            $permissionsData = [];

            foreach ($modulePermissions as $moduleID => $permissions) {
                $permissionsData[] = [
                    'roleID' => $roleID,
                    'moduleID' => $moduleID,
                    'can_view' => isset($permissions['view']) ? 1 : 0,
                    'can_insert' => isset($permissions['add']) ? 1 : 0,
                    'can_update' => isset($permissions['update']) ? 1 : 0,
                    'can_delete' => isset($permissions['delete']) ? 1 : 0,
                ];
            }


            $permissionModel = new LoginModel('role_permissions');
            $permissionModel->saveRolePermissions($permissionsData);


            $db->transCommit();
            session()->setFlashdata('success', 'Data inserted successfully.');

            return redirect()->to(base_url("/role_form"));
        } else {
            $db->transRollback();
            session()->setFlashdata('error', 'Error inserting data. Please try again.');

            return redirect()->back();
        }
    }
    public function delete_role($roleID)
    {
        $roleModel = new RoleModel();
        $role = $roleModel->find($roleID);

        if (!$role) {
            return redirect()->back()->with('error', 'Role not found.');
        }
        if ($roleModel->delete($roleID)) {

            return redirect()->to(base_url('view_role'))->with('success', 'Role updated successfully.');
        } else {
            return redirect()->to(base_url('view_role'))->with('error', 'Failed to delete role. Please try again.');
        }
    }



    public function loginSave()
    {
        $request = \Config\Services::request();
        $session = session();

        $email = trim($request->getVar('email'));
        $password = trim($request->getVar('password'));

        $loginModel = new LoginModel('users');
        $user = $loginModel->getUserByEmail($email);

        if ($user) {
            if (password_verify($password, $user['password'])) {

                $businessModel = new LoginModel('business');
                $businessData = $businessModel->getBusinessData($user['businessID']);
                $rolePermissionsModel = new LoginModel('role_permissions');
                $userRolePermissions = $rolePermissionsModel->getRolePermissions($user['roleID']);
                $modules = $rolePermissionsModel->getModules();

                $modulePermissions = [];
                foreach ($userRolePermissions as $permission) {
                    $modulePermissions[$permission['moduleID']] = [
                        'can_view' => $permission['can_view'],
                        'can_insert' => $permission['can_insert'],
                        'can_update' => $permission['can_update'],
                        'can_delete' => $permission['can_delete'],
                    ];
                }

                $userData = [
                    'user_permissions' => $userRolePermissions,
                    'module_permissions' => $modulePermissions,
                    'modules' => $modules,

                    'ID' => $user['ID'],
                    'user' => $user['fName'],
                    'businessID' => $user['businessID'],
                    'fName' => $user['fName'],
                    'lName' => $user['lName'],
                    'email' => $user['email'],
                    'roleID' => $user['roleID'],
                    'profileImage' => base_url('uploads/' . $user['CNIC_img']),
                    'businessName' => $businessData['businessName'],
                    'phoneNumber' => $businessData['phone'],
                    'businessProfileImage' => base_url('uploads/' . $businessData['logo']),
                    'businessTableID' => $businessData['ID'],
                    'businessTypeID' => $businessData['businessTypeID'],
                    'hospitalcharges' => $businessData['charges'],
                    'business_address' => $businessData['address'],
                    'business_email' => $businessData['email'],
                ];

                $session->set($userData);


                return redirect()->to(base_url("/dashboard"));
            } else {
                $session->setFlashdata('error', 'Invalid email or password.');
            }
        } else {
            $session->setFlashdata('error', 'User with this email does not exist.');
        }

        return redirect()->to(base_url("/login"));
    }




    public function logout()
    {
        $session = session();
        $session->destroy();

        return redirect()->to(base_url("/login"));
    }






    public function store()
    {
        $request = \Config\Services::request();
        $db = \Config\Database::connect();

        $nicImage = $request->getFile('cnic_image');
        $nicImageName = $nicImage->getName();
        $nicImage->move(FCPATH . 'uploads', $nicImageName);

        $businessImage = $request->getFile('image');
        $businessImageName = $businessImage->getName();
        $businessImage->move(FCPATH . 'uploads', $businessImageName);

        $db->transBegin();

        $businessData = [
            'businessName' => $request->getPost('BusinessName'),
            'regName' => $request->getPost('RegName'),
            'address' => $request->getPost('Address'),
            'phone' => $request->getPost('Phone'),
            'email' => $request->getPost('Email'),
            'businessTypeId' => $request->getPost('businessType'),
            'logo' => $businessImageName,
            'charges' => $request->getPost('fee'),
        ];



        $loginModel = new LoginModel('business');
        $businessID = $loginModel->saveBusiness($businessData);

        if ($businessID) {

            $uniqueLicense = $this->generateUniqueLicense();

            $licenseData = [
                'license' => $uniqueLicense,
                'businessID' => $businessID,
            ];


            $licenseModel = new LoginModel('license');
            $licenseModel->saveLicense($licenseData);


            $hashedPassword = password_hash($request->getPost('user_password'), PASSWORD_DEFAULT);

            $userData = [
                'fName' => $request->getPost('first_name'),
                'lName' => $request->getPost('last_name'),
                'email' => $request->getPost('user_email'),
                'address' => $request->getPost('user_address'),
                'phone' => $request->getPost('user_phone'),
                'password' => $hashedPassword,
                'businessID' => $businessID,
                'roleID' => 13,
                'CNIC' => $request->getPost('cnic_number'),
                'CNIC_img' => $nicImageName,
            ];
            // print_r($userData);

            $userModel = new LoginModel('users');
            $userModel->saveUser($userData);

            $db->transCommit();
            session()->setFlashdata('success', 'Data inserted successfully.');

            return redirect()->to(base_url("/user_form"));
        } else {
            $db->transRollback();
            session()->setFlashdata('error', 'Error inserting data. Please try again.');

            return redirect()->back();
        }
    }


    private function generateUniqueLicense()
    {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $length = 16;

        $randomString = '';
        $max = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $max)];
        }

        $uniqueLicense = $randomString;

        return $uniqueLicense;
    }



    // public function edit_role($role_id)
    // {
    //     $db = \Config\Database::connect();
    //     $rolesModel = new LoginModel('role');
    //     $role = $rolesModel->find($role_id);
    //     $permissionsModel = new LoginModel('role_permissions');
    //     $permissions = $permissionsModel->where('roleID', $role_id)->findAll();

    //     return view('edit_role', [
    //         'role' => $role,
    //         'permissions' => $permissions,
    //     ]);
    // }

    public function save_user()
    {
        $request = \Config\Services::request();
        $session = \Config\Services::session();

        $nicImage = $request->getFile('cnic_image');
        $email = $request->getPost('user_email');
        $userModel = new LoginModel('users');
        $existingUser = $userModel->where('email', $email)->first();

        if ($existingUser) {

            session()->setFlashdata('error', 'Email already exists. Please choose a different email.');
            return redirect()->to(base_url("/user_form2"));
        }


        if ($nicImage->isValid()) {
            $nicImageName = $nicImage->getName();
            $nicImage->move(FCPATH . 'uploads', $nicImageName);
        } else {

            $nicImageName = 'default_image/user-png-icon-16.jpg';
        }



        $password = $request->getPost('user_password');
        $confirmPassword = $request->getPost('confirm_password');

        if ($password !== $confirmPassword) {
            session()->setFlashdata('error', 'Password and Confirm Password  not matching.');
            return redirect()->to(base_url("/user_form2"));
        }

        $businessID = $session->get('businessID');

        $hashedPassword = password_hash($request->getPost('user_password'), PASSWORD_DEFAULT);

        $userData = [
            'fName' => $request->getPost('first_name'),
            'lName' => $request->getPost('last_name'),
            'email' => $request->getPost('user_email'),
            'address' => $request->getPost('user_address'),
            'phone' => $request->getPost('user_phone'),
            'password' => $hashedPassword,
            'businessID' => $businessID,
            'roleID' => $request->getPost('roleID'),
            'CNIC' => $request->getPost('cnic_number'),
            'CNIC_img' => $nicImageName,
        ];

        $userModel = new LoginModel('users');
        $result = $userModel->saveUser($userData);

        session()->setFlashdata('success', 'User Data inserted successfully.');

        return redirect()->to(base_url("/user_form2"));
    }


    // public function update_user($id)
    // {
    //     $request = \Config\Services::request();
    //     $model = new LoginModel('users');

    //     $UserID = $id;
    //     $userData = [
    //         'fName' => $request->getPost('first_name'),
    //         'lName' => $request->getPost('last_name'),
    //         'email' => $request->getPost('user_email'),
    //         'address' => $request->getPost('user_address'),
    //         'phone' => $request->getPost('user_phone'),
    //         'roleID' => $request->getPost('roleID'),
    //         'CNIC' => $request->getPost('cnic_number'),

    //     ];
    //     //   print_r ($businessData);
    //     //   die();


    //     $model->updateUserData($UserID, $userData);

    //     session()->setFlashdata('success', 'User updated successfully');

    //     return redirect()->to(base_url('/users_table'));
    // }

    public function update_user($user_id)
    {
        $request = \Config\Services::request();
        $userModel = new LoginModel('users');

        $userData = $userModel->find($user_id);

        $profileImage = $request->getFile('profile_image');
        if ($profileImage && $profileImage->isValid()) {
            $profileImageName = $profileImage->getName();
            $profileImage->move(FCPATH . 'uploads', $profileImageName);
        } else {
            $profileImageName = $userData['CNIC_img'];
        }

        $password = $request->getPost('user_password');
        $confirmPassword = $request->getPost('confirm_password');
        if ($password !== $confirmPassword) {
            session()->setFlashdata('error', 'Password and Confirm Password not matching.');
            return redirect()->to(base_url("/edit_user/" . $user_id));
        }

        $hashedPassword = $password ? password_hash($password, PASSWORD_DEFAULT) : $userData['password'];

        $userData = [
            'password' => $hashedPassword,
            'CNIC_img' => $profileImageName,
        ];

        $userModel->update($user_id, $userData);
        session()->setFlashdata('success', 'User updated successfully.');
        return redirect()->to(base_url("/edit_user/" . $user_id));
    }

    public function deleteUser($id)
    {
        try {
            $Model = new UserModel();

            $delete = $Model->deleteUser($id);

            if ($delete) {
                session()->setFlashdata('success', 'User deleted successfully!');
            } else {
                session()->setFlashdata('error', 'Clear all records for this user before deletion.');
            }

            return redirect()->to(base_url("/users_table"));

        } catch (\Exception $e) {
            log_message('error', 'Database Error: ' . $e->getMessage());
            session()->setFlashdata('error', 'Clear all records for this user before deletion.');

            return redirect()->to(base_url("/users_table"));
        }
    }



}
