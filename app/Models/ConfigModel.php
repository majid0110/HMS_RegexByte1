<?php
namespace App\Models;

use CodeIgniter\Model;

class ConfigModel extends Model
{
    protected $table = 'config';
    protected $primaryKey = 'id';
    protected $allowedFields = ['businessID', 'isExpiry'];

    public function updateConfig($businessID, $data)
    {
        $existingConfig = $this->where('businessID', $businessID)->first();

        if ($existingConfig) {
            $this->where('businessID', $businessID)
                ->set($data)
                ->update();
        } else {
            $data['businessID'] = $businessID;
            $this->insert($data);
        }
    }
}

