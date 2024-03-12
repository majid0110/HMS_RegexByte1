<?php
namespace App\Models;

use CodeIgniter\Model;

class salesModel extends Model
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

    public function getpayment()
    {
        return $this->db->table('paymentmethods')
            ->select('idPaymentMethods, Method')
            ->get()
            ->getResultArray();
    }

    public function getCurrancy()
    {
        return $this->db->table('currency')
            ->select('id, Currency')
            ->get()
            ->getResultArray();
    }

    public function getServices()
    {
        return $this->db->table('artmenu')
            ->select('idArtMenu, Name, Price, idCatArt')
            ->get()
            ->getResultArray();
    }

    public function getCategories()
    {
        return $this->db->table('catart')
            ->select('idCatArt, name, idSector')
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

    public function insertInvoice($data)
    {
        $result = $this->db->table('invoices')->insert($data);
        if ($result) {
            return $this->db->insertID();
        } else {
            return false;
        }
    }

    public function getSales()
    {

        return $this->db->table('invoices')
            ->join('client', 'client.idClient = invoices.idClient')
            ->join('currency', 'currency.id = invoices.idCurrency')
            ->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod')
            ->select('invoices.*, client.client as clientName, currency.Currency, paymentmethods.Method as PaymentMethod')
            ->get()
            ->getResultArray();
    }

    public function deleteSales($idReceipts)
    {
        $this->db->table('invoicedetail')
            ->where('idReceipts', $idReceipts)->delete();

        return $this->db->table('invoices')
            ->where('idReceipts', $idReceipts)->delete();
    }

    public function getSalesDetails($idReceipts)
    {
        return $this->db->table('invoicedetail')
            ->join('artmenu', 'artmenu.idArtMenu = invoicedetail.idArtMenu')
            ->join('invoices', 'invoices.idReceipts = invoicedetail.idReceipts')
            ->join('client', 'client.idClient = invoices.idClient')
            ->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod', 'left') // Join with paymentmethods table
            ->join('currency', 'currency.id = invoices.idCurrency', 'left') // Join with currency table
            ->where('invoicedetail.idReceipts', $idReceipts)
            ->select('invoicedetail.*, artmenu.Name as ServiceTypeName,invoices.Notes, invoices.invOrdNum, invoices.Status, invoices.Value, invoices.invoice_period_end_date as due, invoices.Date as InvoiceDate, invoices.Time as InvoiceTime, client.*, paymentmethods.Method as PaymentMethod, currency.Currency as Currency')
            ->get()
            ->getResultArray();
    }

    // Inside your salesModel

    public function updateServiceToZero($idReceipts)
    {
        $data = [
            'Quantity' => 0,
            'Price' => 0,
            'Sum' => 0,
        ];

        $this->db->table('invoicedetail')
            ->where('idReceipts', $idReceipts)
            ->update($data);

        $invoicedata = [
            'Value' => 0,
            'Status' => 'closed',
        ];

        $this->db->table('invoices')
            ->where('idReceipts', $idReceipts)
            ->update($invoicedata);
        return $this->db->affectedRows() > 0;
    }



    // public function getSalesDetails($idReceipts)
    // {
    //     return $this->db->table('invoicedetail')
    //         ->join('artmenu', 'artmenu.idArtMenu = invoicedetail.idArtMenu')
    //         ->join('invoices', 'invoices.idReceipts = invoicedetail.idReceipts')
    //         ->join('client', 'client.idClient = invoices.idClient')
    //         ->where('invoicedetail.idReceipts', $idReceipts)
    //         ->select('invoicedetail.*, artmenu.Name as ServiceTypeName, invoices.Status, invoices.Value, invoices.invoice_period_end_date as due, invoices.Date as InvoiceDate, invoices.Time as InvoiceTime, client.*')
    //         ->get()
    //         ->getResultArray();
    // }

    public function getSalesReport($search = null, $paymentInput = null, $clientName = null, $fromDate = null, $toDate = null)
    {
        $builder = $this->db->table('invoices');
        $builder->join('client', 'client.idClient = invoices.idClient');
        $builder->join('currency', 'currency.id = invoices.idCurrency');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod');
        $builder->select('invoices.*, client.client as clientName, currency.Currency, paymentmethods.Method as PaymentMethod');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('invoices.invOrdNum', $search)
                ->orLike('client.client', $search)
                ->orLike('currency.Currency', $search)
                ->orLike('paymentmethods.Method', $search)
                ->groupEnd();
        }

        if (!empty($paymentInput)) {
            $builder->where('invoices.paymentMethod', $paymentInput);
        }

        if (!empty($clientName)) {
            $builder->like('client.client', $clientName);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('invoices.Date >=', $fromDate)
                ->where('invoices.Date <=', $toDate);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }
}
