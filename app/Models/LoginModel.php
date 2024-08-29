<?php
namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table;
    protected $primaryKey;
    protected $allowedFields;

    public function __construct(string $tableName)
    {
        parent::__construct();

        $this->table = "license";

        if ($tableName === "users") {
            $this->table = "users";
            $this->primaryKey = 'ID';
            $this->allowedFields = ['ID', 'fName', 'lName', 'email', 'address', 'phone', 'password', 'businessID', 'profile', 'CNIC', 'CNIC_img'];
        } elseif ($tableName === "business") {
            $this->table = "business";
            $this->primaryKey = 'ID';
            $this->allowedFields = ['ID', 'businessName', 'regName', 'businessTypeID', 'address', 'phone', 'email', 'logo', 'charges'];
        } elseif ($tableName === "license") {
            $this->primaryKey = 'ID';
            $this->allowedFields = ['ID', 'license', 'businessID', 'created_at', 'updated_at'];
        } elseif ($tableName === "role") {
            $this->table = "role";
            $this->primaryKey = 'ID';
            $this->allowedFields = ['ID', 'role_name', 'role_description', 'businessID'];
        } elseif ($tableName === "modules") {
            $this->table = "modules";
            $this->primaryKey = 'id';
            $this->allowedFields = ['module_name'];
        } elseif ($tableName === "role_permissions") {
            $this->table = "role_permissions";
            $this->primaryKey = 'ID';
            $this->allowedFields = ['ID', 'roleID', 'moduleID', 'can_view', 'can_insert', 'can_update', 'can_delete'];
        } elseif ($tableName === "businesstype") {
            $this->table = "businesstype";
            $this->primaryKey = 'ID';
            $this->allowedFields = ['ID', 'businessType'];
        } elseif ($tableName === "labtestdetails") {
            $this->table = "labtestdetails";
            $this->primaryKey = 'labtest_id';
            $this->allowedFields = ['labtest_id', 'lab TestID'];
        } elseif ($tableName === "invoices") {
            $this->table = "invoices";
            $this->primaryKey = 'idReceipts';
            $this->allowedFields = [
                'idClient',
                'Value',
                'idTable',
                'idUser',
                'Status',
                'serial_number',
                'idBusiness',
                'idCancellation',
                'invOrdNum',
                'selfissue',
                'FIC',
                'ValueTVSH',
                'idCurrency',
            ];
        } elseif ($tableName === "labtest") {
            $this->table = "labtest";
            $this->primaryKey = 'test_id';
            $this->allowedFields = ['businessId', 'fee'];
        } elseif ($tableName === "test_type") {
            $this->table = "test_type";
            $this->primaryKey = 'testTypeId';
            $this->allowedFields = ['title', 'description', 'test_fee', 'userID', 'businessID', 'createdAt'];
        }

    }


    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->load->database();
    // }


    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }



    public function getAllBusinessTypes()
    {
        return $this->select('ID, businessType')->findAll();

    }


    public function saveBusiness($data)
    {
        $this->db->table('business')->insert($data);
        return $this->db->insertID();
    }

    public function saveUser($data)
    {
        $this->db->table('users')->insert($data);

    }

    public function saveLicense($data)
    {
        $this->db->table('license')->insert($data);

    }


    public function getBusinessData($businessID)
    {
        return $this->db->table('business')->where('ID', $businessID)->get()->getRowArray();
    }


    public function getBusinessTable()
    {
        $query = $this->select('business.*, businesstype.businessType')
            ->join('businesstype', 'businesstype.ID = business.businessTypeID')
            ->findAll();

        return $query;
    }


    public function getModuleNames()
    {
        return $this->select('ID, module_name')->findAll();
    }



    public function save_role($data)
    {
        $this->db->table('role')->insert($data);
        return $this->db->insertID();
    }

    public function saveRolePermissions($permissionsData)
    {
        $this->insertBatch($permissionsData);
    }
    public function updateRolePermissions($roleID, $permissionsData)
    {
        $this->where('roleID', $roleID)->delete();
        foreach ($permissionsData as $permission) {
            $this->insert($permission);
        }
    }
    public function getAllRoles()
    { {
            $session = \Config\Services::session();
            $businessID = $session->get('businessID');
            return $this->select('ID, role_name')
                ->where('businessID', $businessID)
                ->findAll();

        }
    }



    public function getRolePermissions($roleID)
    {
        return $this->where('roleID', $roleID)->findAll();
    }

    public function getRolePermission($roleID)
    {
        $permissions = $this->where('roleID', $roleID)->findAll();
        $result = [];

        foreach ($permissions as $permission) {
            $result[$permission['moduleID']] = [
                'can_view' => $permission['can_view'],
                'can_insert' => $permission['can_insert'],
                'can_update' => $permission['can_update'],
                'can_delete' => $permission['can_delete'],
            ];
        }

        return $result;
    }

    public function getModules()
    {

        $query = $this->db->table('modules')->get();
        return $query->getResultArray();
    }

    public function getBusinessCharges($businessID)
    {
        return $this->db->table($this->table)
            ->where('ID', $businessID)
            ->select('charges')
            ->get()
            ->getRowArray()['charges'] ?? null;
    }

    public function getuserprofile()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');

        return $this->db->table('users')
            ->where('businessID', $businessID)
            ->orderBy('ID', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function get_user_by_id($user_id)
    {
        return $this->find($user_id);
    }

    public function updateUserData($UserID, $data)
    {
        $this->db->table('users')->where('ID', $UserID)->update($data);

    }

    public function getTotalTests($businessID)
    {
        $query = $this->db->table('labtestdetails')
            ->join('labtest', 'labtestdetails.labTestID = labtest.test_id')
            ->where('labtest.businessId', $businessID)
            ->countAllResults();

        return $query;
    }

    public function getTotalServiceRevenue($businessID)
    {
        $query = $this->db->table('invoices')
            ->selectSum('Value', 'totalRevenue')
            ->where('idBusiness', $businessID)
            ->get();

        $result = $query->getRow();
        return $result->totalRevenue;
    }

    public function getMonthlyServiceRevenue($businessID)
    {
        $query = $this->db->table('invoices')
            ->selectSum('Value', 'totalRevenue')
            ->where('MONTH(Date)', date('m'))
            ->where('YEAR(Date)', date('Y'))
            ->where('idBusiness', $businessID)
            ->get();

        $result = $query->getRow();
        return $result->totalRevenue;
    }

    public function getTotalExpenditure()
    {
        $query = $this->db->table('expenses')
            ->selectSum('amount', 'TotalExpenditure')
            ->get();

        $result = $query->getRow();
        return $result->TotalExpenditure;
    }


    public function getMonthlyExpenditure()
    {
        $query = $this->db->table('expenses')
            ->selectSum('amount', 'TotalExpenditure')
            ->where('MONTH(expense_date)', date('m'))
            ->where('YEAR(expense_date)', date('Y'))
            ->get();

        $result = $query->getRow();
        return $result->TotalExpenditure;
    }


    public function getTotalTestRevenue($businessID)
    {
        $query = $this->db->table('labtest')
            ->selectSum('fee', 'totalRevenue')
            ->where('businessId', $businessID)
            ->get();

        $result = $query->getRow();
        return $result->totalRevenue;
    }

    public function getMonthlyTestRevenue($businessID)
    {
        $query = $this->db->table('labtest')
            ->selectSum('fee', 'totalRevenue')
            ->where('MONTH(CreatedAT)', date('m'))
            ->where('YEAR(CreatedAT)', date('Y'))
            ->where('businessId', $businessID)
            ->get();

        $result = $query->getRow();
        return $result->totalRevenue;
    }

    public function getTotalLabHospitalRevenue($businessID)
    {
        $query = $this->selectSum('hospitalCharges', 'totalChargesRevenue')
            ->where('businessId', $businessID)
            ->get();

        return $query->getRow()->totalChargesRevenue;
    }

    public function getRecentTestsByBusinessID($businessID)
    {
        return $this->select('*')
            ->where('businessID', $businessID)
            ->orderBy('testTypeId', 'DESC')
            ->limit(6)
            ->get()
            ->getResultArray();
    }

    public function getMonthlyHospitalCharges($businessID)
    {
        $query = $this->db->query(
            "SELECT 
            CONCAT(MONTH(Date), '-', YEAR(Date)) AS label,
            COALESCE(SUM(Value), 0) AS hospitalCharges
         FROM invoices 
         WHERE idBusiness = ?
         GROUP BY YEAR(Date), MONTH(Date)
         ORDER BY YEAR(Date), MONTH(Date)",
            [$businessID]
        );

        return $query->getResultArray();
    }

    public function getMonthlyLabHospitalCharges($businessID)
    {
        $query = $this->db->query(
            "SELECT 
            CONCAT(MONTH(createdAT), '-', YEAR(createdAT)) AS label,
            SUM(hospitalCharges) AS totalCharges
        FROM labtest
        WHERE businessId = ?
        GROUP BY YEAR(CreatedAT), MONTH(CreatedAT)
        ORDER BY YEAR(CreatedAT), MONTH(CreatedAT)",
            [$businessID]
        );

        return $query->getResultArray();
    }

    public function getCurrentWeekSalesData($businessID)
    {
        return $this->select("DATE_FORMAT(Date, '%W') as day, SUM(Value) as total_sales")
            ->where('idBusiness', $businessID)
            ->where('WEEKOFYEAR(Date) = WEEKOFYEAR(CURDATE())')
            ->groupBy('day')
            ->orderBy('Date', 'ASC')
            ->findAll();
    }


}

