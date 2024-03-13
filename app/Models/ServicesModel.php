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
        $builder = $this->db->table('artmenu');
        return $builder->join('units', 'units.idUnit = artmenu.idUnit')
            ->select('artmenu.*,units.name')
            ->get()
            ->getResultArray();
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
