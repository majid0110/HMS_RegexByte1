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

    // public function getServices()
    // {
    //     return $this->db->table('artmenu')
    //         > join('units', 'units.idUnit = artmenu.idUnit')
    //             ->select('artmenu.*,units.name')
    //             ->get()
    //             ->getResultArray();
    // }

    public function getServices()
    {
        $businessID = session()->get('businessID');
        $builder = $this->db->table('artmenu');
        return $builder->join('units', 'units.idUnit = artmenu.idUnit')
            ->select('artmenu.*,units.name')
            ->where('artmenu.idBusiness', $businessID)
            ->orderBy('artmenu.idArtMenu', 'DESC')
            ->get()
            ->getResultArray();
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

    // public function insertBatch(?array $data = null, ?bool $escape = null, int $batchSize = 100, bool $testing = false)
    // {
    //     $builder = $this->db->table('artmenu');
    //     return $builder->insertBatch($data, $escape, $batchSize);
    // }

    public function insertBatch(?array $data = null, ?bool $escape = null, int $batchSize = 100, bool $testing = false)
    {
        $builder = $this->db->table('artmenu');

        // Perform batch insertion
        $builder->insertBatch($data, $escape, $batchSize);

        // Retrieve the last inserted IDs manually
        $insertedIds = [];
        $lastInsertId = $this->db->insertID();
        $numInsertedRows = count($data);
        for ($i = 0; $i < $numInsertedRows; $i++) {
            $insertedIds[] = $lastInsertId - $numInsertedRows + $i + 1;
        }

        // Return the insertion IDs
        return $insertedIds;
    }


    public function insertBatchRatio(?array $data = null, ?bool $escape = null, int $batchSize = 100, bool $testing = false)
    {
        $builder = $this->db->table('ratio');
        return $builder->insertBatch($data, $escape, $batchSize);
    }



    public function deleteService($idArtMenu)
    {
        return $this->where('idArtMenu', $idArtMenu)->delete();
    }

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
}
