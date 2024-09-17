<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['fName', 'lName', 'email', 'password', 'reset_token', 'reset_token_expiry'];

    public function deleteUser($id)
    {
        try {
            $this->db->table('users')
                ->where('ID', $id)
                ->delete();

            if ($this->db->affectedRows() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }



}
