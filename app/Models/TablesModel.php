<?php
namespace App\Models;

use CodeIgniter\Model;

class TablesModel extends Model
{
    protected $table = 'tables';
    protected $primaryKey = 'idTables';
    protected $allowedFields = [
        'name',
        'pozX',
        'pozY',
        'Status',
        'notes',
        'idBusiness',
        'Def',
        'idUserActive',
        'size',
        'idPoint_of_sale',
        'booking_status'
    ];
}