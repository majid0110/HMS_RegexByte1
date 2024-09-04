<?php
namespace App\Models;

use CodeIgniter\Model;

class ServicesModel extends Model
{
    protected $table = 'artmenu';
    protected $primaryKey = 'idArtMenu';

    protected $allowedFields = [
        'Code',
        'Name',
        'Price',
        'Promotional_Price',
        'idCatArt',
        'Image',
        'Notes',
        'idBusiness',
        'idUnit',
        'Cost',
        'Product_mix',
        'idTVSH',
        'status',
        'isService',
        'Barcode',
        'characteristic1',
        'characteristic2',
        'noTvshType',
        'idPoint_of_sale',
    ];

    public function getUnits()
    {
        return $this->db->table('units')
            ->select('idUnit, name')
            ->get()
            ->getResultArray();
    }

    public function getCategories()
    {
        return $this->db->table('catart')
            ->select('idCatArt, name')
            ->get()
            ->getResultArray();
    }

    public function getTaxes()
    {
        return $this->db->table('taxtype')
            ->select('tax_id, value')
            ->get()
            ->getResultArray();
    }

    public function getItemsName()
    {
        return $this->db->table('artmenu')
            ->select('idArtMenu,Name')
            ->get()
            ->getResultArray();
    }

    // public function getServices()
    // {
    //     $businessID = session()->get('businessID');
    //     $builder = $this->db->table('artmenu');
    //     return $builder->join('units', 'units.idUnit = artmenu.idUnit')
    //         ->select('artmenu.*,units.name')
    //         ->where('artmenu.idBusiness', $businessID)
    //         ->orderBy('artmenu.idArtMenu', 'DESC')
    //         ->get()
    //         ->getResultArray();
    // }

    // public function getActiveItems()
    // {
    //     $businessID = session()->get('businessID');
    //     $builder = $this->db->table('itemswarehouse');
    //     return $builder->select('*')
    //         ->where('status', 'active')
    //         ->where('idBusiness', $businessID)
    //         ->get()
    //         ->getResultArray();
    // }

    public function getServices($perPage = 20, $currentPage = 1)
    {
        $businessID = session()->get('businessID');

        $offset = ($currentPage - 1) * $perPage;

        $builder = $this->db->table('artmenu');
        return $builder->join('units', 'units.idUnit = artmenu.idUnit')
            ->select('artmenu.*, units.name as unit')
            ->where('artmenu.idBusiness', $businessID)
            ->orderBy('artmenu.idArtMenu', 'DESC')
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();
    }

    public function getItm($name, $code)
    {
        $builder = $this->db->table('artmenu');
        $builder->where('Code', $code);
        $builder->where('Name', $name);
        return $builder->countAllResults();
    }

    public function getServiceName($businessID, $idService)
    {
        return $this->db->table($this->table)
            ->where('idBusiness', $businessID)
            ->where('idArtMenu', $idService)
            ->select('Name')
            ->get()
            ->getRowArray()['Name'] ?? null;
    }


    public function getServicesCount()
    {
        $businessID = session()->get('businessID');

        $builder = $this->db->table('artmenu');
        $builder->where('artmenu.idBusiness', $businessID);
        return $builder->countAllResults();
    }

    public function getActiveItems()
    {
        $businessID = session()->get('businessID');
        $builder = $this->db->table('itemswarehouse');
        return $builder->select('*')
            ->where('status', 'active')
            ->where('idBusiness', $businessID)
            ->get()
            ->getResultArray();
    }

    public function getRatio()
    {
        $businessID = session()->get('businessID');
        $builder = $this->db->table('ratio');
        return $builder->select('*')
            ->where('idBusiness', $businessID)
            ->get()
            ->getResultArray();
    }



    // public function insertBatch(?array $data = null, ?bool $escape = null, int $batchSize = 100, bool $testing = false)
    // {
    //     $builder = $this->db->table('artmenu');
    //     return $builder->insertBatch($data, $escape, $batchSize);
    // }

    public function insertArtMenu($dataToInsertArtmenu)
    {
        $this->db->table('artmenu')->insert($dataToInsertArtmenu);
        return $this->db->insertID();
    }




    public function insertRatio($ratioData)
    {
        $this->db->table('ratio')->insert($ratioData);
    }
    public function deleteService($idArtMenu)
    {
        $db = \Config\Database::connect();

        $db->transStart();

        $db->table('ratio')->where('idArtMenu', $idArtMenu)->delete();

        $this->where('idArtMenu', $idArtMenu)->delete();

        $db->table('ratio')->where('idArtMenu', $idArtMenu)->delete();

        $db->transComplete();

        return $db->transStatus();
    }

    // public function deleteService($idArtMenu, $code, $name)
    // {
    //     $db = \Config\Database::connect();

    //     $db->transStart(); // Start transaction

    //     // Fetch idItem from itemswarehouse table based on Code and Name
    //     $idItem = $db->table('itemswarehouse')
    //         ->select('idItem')
    //         ->where('Code', $code)
    //         ->where('Name', $name)
    //         ->get()
    //         ->getRowArray()['idItem'];

    //     if (!$idItem) {
    //         // Item not found, return false
    //         return false;
    //     }

    //     $db->table('ratio')->where('idArtMenu', $idArtMenu)->where('idItem', $idItem)->delete();
    //     $this->where('idArtMenu', $idArtMenu)->delete();

    //     // Delete from ratio table where both idArtMenu and idItem match


    //     $db->transComplete(); // Complete transaction

    //     return $db->transStatus(); // Return transaction status
    // }


    public function getAppointments()
    {
        return $this->db->table('appointment')
            ->join('client', 'client.idClient = appointment.clientID')
            ->join('doctorprofile', 'doctorprofile.DoctorID = appointment.doctorID')
            ->join('fee_type', 'fee_type.f_id = appointment.appointmentType')
            ->select('appointment.*, client.client as clientName, doctorprofile.FirstName as doctorFirstName, doctorprofile.LastName as doctorLastName, fee_type.FeeType as appointmentTypeName')
            ->get()
            ->getResultArray();
    }

    public function getTotalServicesFee()
    {
        $businessId = session()->get('businessID');
        $builder = $this->db->table($this->table);
        $builder->selectSum('Price');
        $builder->where('idBusiness', $businessId);
        $result = $builder->get()->getRowArray();
        return $result['Price'];
    }

    public function linkItem($rationData)
    {
        return $this->db->table('ratio')->insert($rationData);
    }

    public function updatelinkItem($rationData)
    {
        $builder = $this->db->table('ratio');
        $existingData = $builder->where('idArtMenu', $rationData['idArtMenu'])
            ->where('idItem', $rationData['idItem'])
            ->get()
            ->getRow();

        if ($existingData) {
            $builder->where('idArtMenu', $rationData['idArtMenu'])
                ->where('idItem', $rationData['idItem'])
                ->update($rationData);
        } else {
            $builder->insert($rationData);
        }

        return true;
    }


    public function getServiceByCodeAndName($serviceCode, $serviceName, $businessID)
    {
        return $this->db->table('artmenu')
            ->select('*')
            ->where('Code', $serviceCode)
            ->where('Name', $serviceName)
            ->where('idBusiness', $businessID)
            ->get()
            ->getRowArray();
    }



    public function updateService($idArtMenu, $formData)
    {
        $this->db->table('artmenu')
            ->where('idArtMenu', $idArtMenu)
            ->update($formData);
    }

    public function insertService($data)
    {
        try {
            $this->db->table('artmenu')->insert($data);
            return $this->db->insertID();
        } catch (\Exception $e) {
            return false;
        }
    }



}
