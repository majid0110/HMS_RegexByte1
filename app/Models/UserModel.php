<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['fName', 'lName', 'email', 'password', 'reset_token', 'reset_token_expiry'];
}
