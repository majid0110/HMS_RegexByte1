<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceDetailsModel extends Model
{
    protected $table = 'invoicepaymentdetails';
    protected $primaryKey = 'idPayment';
    protected $allowedFields = ['value', 'idUser', 'date', 'timestamp', 'idAnullim', 'method', 'idPaymentMethod', 'exchange', 'nr_serial'];


    public function insertInvoicePayment($data)
    {
        $this->table = 'invoicepayment';
        $this->primaryKey = 'IdInvPay';
        $this->allowedFields = ['idReceipt', 'idPayment'];

        return $this->insert($data);
    }

    public function updateItemsWarehouse($idArtMenu, $quantity)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ratio');
        $builder->select('*');
        $builder->where('idArtMenu', $idArtMenu);
        $ratioData = $builder->get()->getRowArray();

        if ($ratioData) {
            $ratio = $ratioData['ratio'];
            $idItem = $ratioData['idItem'];
            $quantityToUpdate = $quantity * $ratio;

            $builder = $db->table('itemswarehouse');
            $builder->where('idItem', $idItem);
            $builder->set('quantity', 'quantity - ' . $quantityToUpdate, false);
            $builder->update();
        }
    }


    
}
