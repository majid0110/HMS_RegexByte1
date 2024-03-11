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
        return $this->findAll(); // Retrieve all sectors from the database
    }

    public function saveSector($data)
    {
        return $this->insert($data); // Insert a new sector into the database
    }

    public function getSectorById($id)
    {
        return $this->find($id); // Retrieve a sector by its ID
    }

    public function updateSector($id, $data)
    {
        return $this->update($id, $data); // Update a sector
    }

    public function deleteSector($id)
    {
        return $this->delete($id); // Delete a sector
    }
}
