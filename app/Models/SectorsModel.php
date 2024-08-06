<?php

namespace App\Models;

use CodeIgniter\Model;

class SectorsModel extends Model
{
    protected $table = 'sectors';
    protected $primaryKey = 'idSector';
    protected $allowedFields = ['name', 'PrintOutput', 'notes', 'TVSH', 'idBusiness'];

    public function getSectors()
    {
        return $this->findAll();
    }

    public function saveSector($data)
    {
        return $this->insert($data);
    }

    public function getSectorById($id)
    {
        return $this->find($id);
    }

    public function updateSector($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteSector($id)
    {
        return $this->delete($id);
    }
}
