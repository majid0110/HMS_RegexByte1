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

    public function getInvoice()
    {
        return $this->db->table('invoices')
            ->select('idReceipts')
            ->get()
            ->getResultArray();
    }

    public function getInvoiceNO()
    {
        return $this->db->table('invoices')
            ->select('idReceipts,invOrdNum')
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

    // public function getServices2($enableService)
    // {
    //     $builder = $this->db->table('artmenu')
    //         ->select('idArtMenu, Name, Price, idCatArt, idTVSH')
    //         ->where('status', 'Active');

    //     if ($enableService != 1) {
    //         $builder->where('isService', 0);
    //     }

    //     return $builder->get()->getResultArray();
    // }

    public function getServices2($enableService)
    {
        $builder = $this->db->table('artmenu')
            ->select('artmenu.*, taxtype.value as tax_value, taxtype.tax_id as idTVSH')
            ->join('taxtype', 'artmenu.idTVSH = taxtype.tax_id', 'left')
            ->where('artmenu.status', 'Active');

        if ($enableService != 1) {
            $builder->where('artmenu.isService', 0);
        }
        return $builder->get()->getResultArray();
    }
    // public function getServices()
    // {
    //     return $this->db->table('artmenu')
    //         ->select('idArtMenu, Name, Price, idCatArt, idTVSH')
    //         ->where('status', 'Active')
    //         ->get()
    //         ->getResultArray();
    // }

    public function getServices()
    {
        return $this->db->table('artmenu')
            ->select('artmenu.*, taxtype.value as tax_value, taxtype.tax_id as idTVSH')
            ->join('taxtype', 'artmenu.idTVSH = taxtype.tax_id', 'left')
            ->where('artmenu.status', 'Active')
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
            ->orderBy('invoices.invOrdNum', 'DESC')
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
            ->join('currency', 'currency.id = invoices.idCurrency', 'left')
            ->where('invoicedetail.idReceipts', $idReceipts)
            ->select('invoicedetail.*, artmenu.idUnit as Unit,artmenu.Name as ServiceTypeName,artmenu.Code as Code,invoices.Notes, invoices.invOrdNum, invoices.Status, invoices.Value, invoices.invoice_period_end_date as due, invoices.Date as InvoiceDate, invoices.Time as InvoiceTime, client.*, paymentmethods.Method as PaymentMethod, currency.Currency as Currency')
            ->get()
            ->getResultArray();
    }

    public function getSalesDetails1($idReceipts)
    {
        return $this->db->table('invoicedetail')
            ->join('artmenu', 'artmenu.idArtMenu = invoicedetail.idArtMenu')
            ->join('invoices', 'invoices.idReceipts = invoicedetail.idReceipts')
            ->join('client', 'client.idClient = invoices.idClient')
            ->join('units', 'units.idUnit = artmenu.idUnit')
            ->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod', 'left')
            ->join('currency', 'currency.id = invoices.idCurrency', 'left')
            ->where('invoicedetail.idReceipts', $idReceipts)
            ->select('invoicedetail.*, units.name as Unit,artmenu.Name as ServiceTypeName, artmenu.Code as Code, invoices.Notes, invoices.invOrdNum, invoices.Status, invoices.Value, invoices.invoice_period_end_date as due, invoices.timeStamp as InvoiceDate, invoices.Time as InvoiceTime,invoices.ValueTVSH as TVSH, client.*, paymentmethods.Method as PaymentMethod, currency.Currency as Currency, invoicedetail.Discount') // Added invoicedetail.Discount
            ->get()
            ->getResultArray();
    }


    public function getPaymentDetails($idReceipts)
    {
        return $this->db->table('invoicepayment')
            ->join('invoicepaymentdetails', 'invoicepaymentdetails.idPayment = invoicepayment.idPayment')
            ->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoicepaymentdetails.method', 'left')
            ->join('currency', 'currency.id = invoicepaymentdetails.idPaymentMethod', 'left')
            ->where('invoicepayment.idReceipt', $idReceipts)
            ->select('invoicepaymentdetails.*, paymentmethods.Method as PaymentMethodName, currency.Currency as Currency')
            ->get()
            ->getResultArray();
    }

    public function duplicateInvoice($idReceipts)
    {
        $invoice = $this->db->table('invoices')->where('idReceipts', $idReceipts)->get()->getRowArray();
        $data = [
            'Quantity' => 0,
            'Price' => 0,
            'Sum' => 0,
        ];

        $this->db->table('invoicedetail')
            ->where('idReceipts', $idReceipts)
            ->update($data);

        if ($invoice) {
            unset($invoice['idReceipts']);
            // $invoice['Status'] = 'canceled';

            return $this->db->table('invoices')->insert($invoice);
        }

        return false;
    }

    public function UpdateInvoice($idReceipts, $data)
    {
        $invoice = $this->db->table('invoices')->where('idReceipts', $idReceipts)->get()->getRowArray();
        $this->db->table('invoices')
            ->where('idReceipts', $idReceipts)
            ->update($data);

        if ($invoice) {
            unset($invoice['idReceipts']);

            return $this->db->table('invoices')->insert($invoice);
        }


    }

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

    // public function getSalesReport($search = null, $paymentInput = null, $clientName = null, $fromDate = null, $toDate = null)
    // {
    //     $builder = $this->db->table('invoices');
    //     $builder->join('client', 'client.idClient = invoices.idClient');
    //     $builder->join('currency', 'currency.id = invoices.idCurrency');
    //     $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod');
    //     $builder->select('invoices.*, client.client as clientName, currency.Currency, paymentmethods.Method as PaymentMethod');

    //     if (!empty ($search)) {
    //         $builder->groupStart()
    //             ->like('invoices.invOrdNum', $search)
    //             ->orLike('client.client', $search)
    //             ->orLike('currency.Currency', $search)
    //             ->orLike('paymentmethods.Method', $search)
    //             ->groupEnd();
    //     }

    //     if (!empty ($paymentInput)) {
    //         $builder->where('invoices.paymentMethod', $paymentInput);
    //     }

    //     if (!empty ($clientName)) {
    //         $builder->like('client.client', $clientName);
    //     }

    //     if (!empty ($fromDate) && !empty ($toDate)) {
    //         $builder->where('invoices.Date >=', $fromDate)
    //             ->where('invoices.Date <=', $toDate);
    //     }

    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }

    //-----------------------------------------------
    // public function getSalesReport($search = null, $paymentInput = null, $clientName = null, $fromDate = null, $toDate = null)
    // {
    //     $session = \Config\Services::session();
    //     $businessID = $session->get('businessID');
    //     $builder = $this->db->table('invoices');
    //     $builder->join('client', 'client.idClient = invoices.idClient');
    //     $builder->join('currency', 'currency.id = invoices.idCurrency');
    //     $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod');
    //     $builder->select('invoices.*, client.client as clientName, currency.Currency, paymentmethods.Method as PaymentMethod');

    //     $builder->where('invoices.idBusiness', $businessID);

    //     if (!empty($search)) {
    //         $builder->groupStart()
    //             ->like('invoices.invOrdNum', $search)
    //             ->orLike('client.client', $search)
    //             ->orLike('currency.Currency', $search)
    //             ->orLike('paymentmethods.Method', $search)
    //             ->groupEnd();
    //     }

    //     if (!empty($paymentInput)) {
    //         $builder->where('invoices.paymentMethod', $paymentInput);
    //     }

    //     if (!empty($clientName)) {
    //         $builder->like('client.client', $clientName);
    //     }

    //     if (!empty($fromDate) && !empty($toDate)) {
    //         $builder->where('invoices.Date >=', $fromDate)
    //             ->where('invoices.Date <=', $toDate);
    //     }

    //     // Add the fee calculation from invoicedetail table
    //     $builder->select('(SELECT SUM(Sum) FROM invoicedetail WHERE invoicedetail.idReceipts = invoices.idReceipts) as Fee');

    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }
//----------------------------------------------------------
    // public function getSalesReport($search = null, $paymentInput = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $offset = 0)
    // {
    //     $session = \Config\Services::session();
    //     $businessID = $session->get('businessID');
    //     $builder = $this->db->table('invoices');
    //     $builder->join('client', 'client.idClient = invoices.idClient');
    //     $builder->join('currency', 'currency.id = invoices.idCurrency');
    //     $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod');
    //     $builder->select('invoices.*, client.client as clientName, currency.Currency, paymentmethods.Method as PaymentMethod');

    //     $builder->where('invoices.idBusiness', $businessID);

    //     if (!empty($search)) {
    //         $builder->groupStart()
    //             ->like('invoices.invOrdNum', $search)
    //             ->orLike('client.client', $search)
    //             ->orLike('currency.Currency', $search)
    //             ->orLike('paymentmethods.Method', $search)
    //             ->groupEnd();
    //     }

    //     if (!empty($paymentInput)) {
    //         $builder->where('invoices.paymentMethod', $paymentInput);
    //     }

    //     if (!empty($clientName)) {
    //         $builder->like('client.client', $clientName);
    //     }

    //     if (!empty($fromDate) && !empty($toDate)) {
    //         $builder->where('invoices.Date >=', $fromDate)
    //             ->where('invoices.Date <=', $toDate);
    //     }

    //     // Add the fee calculation from invoicedetail table
    //     $builder->select('(SELECT SUM(Sum) FROM invoicedetail WHERE invoicedetail.idReceipts = invoices.idReceipts) as Fee');

    //     // Add limit and offset for pagination
    //     $builder->limit($perPage, $offset);

    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }



    // public function getPager($search = null, $paymentInput = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $currentPage = 1)
    // {
    //     $builder = $this->db->table('invoices');
    //     $builder->select('COUNT(*) as total');
    //     $builder->join('client', 'client.idClient = invoices.idClient');
    //     $builder->join('currency', 'currency.id = invoices.idCurrency');
    //     $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod');

    //     if (!empty($search)) {
    //         $builder->groupStart()
    //             ->like('invoices.invOrdNum', $search)
    //             ->orLike('client.client', $search)
    //             ->orLike('currency.Currency', $search)
    //             ->orLike('paymentmethods.Method', $search)
    //             ->groupEnd();
    //     }

    //     if (!empty($paymentInput)) {
    //         $builder->where('invoices.paymentMethod', $paymentInput);
    //     }

    //     if (!empty($clientName)) {
    //         $builder->like('client.client', $clientName);
    //     }

    //     if (!empty($fromDate) && !empty($toDate)) {
    //         $builder->where('invoices.Date >=', $fromDate)
    //             ->where('invoices.Date <=', $toDate);
    //     }

    //     $totalQuery = $builder->get();
    //     $totalResult = $totalQuery->getRowArray();
    //     $total = isset($totalResult['total']) ? (int) $totalResult['total'] : 0;

    //     $pager = service('pager');
    //     $pagerLinks = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

    //     return $pagerLinks;
    // }

    public function gettotalServiceFee($search, $invoice, $clientName, $paymentInput, $fromDate, $toDate)
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $builder = $this->db->table('invoices');
        $builder->selectSum('Value', 'totalServiceFee');
        $builder->join('client', 'client.idClient = invoices.idClient');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod');
        $builder->where('invoices.idBusiness', $businessID);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('invoices.invOrdNum', $search)
                ->orLike('client.client', $search)
                ->orLike('currency.Currency', $search)
                ->orLike('paymentmethods.Method', $search)
                ->groupEnd();
        }

        if (!empty($clientName)) {
            $builder->like('client.client', $clientName);
        }

        if (!empty($paymentInput)) {
            $builder->where('invoices.paymentMethod', $paymentInput);
        }

        if (!empty($invoice)) {
            $builder->where('invoices.idReceipts', $invoice);
        }


        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('invoices.Date >=', $fromDate)
                ->where('invoices.Date <=', $toDate);
        }


        $query = $builder->get();
        $result = $query->getRowArray();
        return $result['totalServiceFee'] ?? 0;
    }

    //--------------------------------------------------

    public function gettotalServiceTableFee($search, $clientName, $paymentInput, $fromDate, $toDate)
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $builder = $this->db->table('invoices');
        $builder->selectSum('Value', 'totalServiceFee');
        $builder->join('client', 'client.idClient = invoices.idClient');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod');
        $builder->where('invoices.idBusiness', $businessID);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('invoices.invOrdNum', $search)
                ->orLike('client.client', $search)
                ->orLike('currency.Currency', $search)
                ->orLike('paymentmethods.Method', $search)
                ->groupEnd();
        }

        if (!empty($clientName)) {
            $builder->like('client.client', $clientName);
        }

        if (!empty($paymentInput)) {
            $builder->where('invoices.paymentMethod', $paymentInput);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('invoices.Date >=', $fromDate)
                ->where('invoices.Date <=', $toDate);
        }


        $query = $builder->get();
        $result = $query->getRowArray();
        return $result['totalServiceFee'] ?? 0;
    }
    public function getServicesByCategory($categoryId)
    {
        $builder = $this->db->table('artmenu');
        if ($categoryId !== null) {
            $builder->where('idCatArt', $categoryId);
        }
        return $builder->get()->getResultArray();
    }

    // public function getServicesByCategory2($categoryId, $enableService)
    // {

    //     $builder = $this->db->table('artmenu');
    //     if ($categoryId !== null) {
    //         $builder->where('idCatArt', $categoryId);
    //     }
    //     if ($enableService != 1) {
    //         $builder->where('isService', 0);
    //     }
    //     return $builder->get()->getResultArray();

    // }

    public function getServicesByCategory2($categoryId, $enableService)
    {
        $builder = $this->db->table('artmenu');
        $builder->select('artmenu.*, taxtype.value as tax_value');
        $builder->join('taxtype', 'taxtype.tax_id = artmenu.idTVSH', 'left');

        if ($categoryId !== null) {
            $builder->where('idCatArt', $categoryId);
        }

        if ($enableService != 1) {
            $builder->where('isService', 0);
        }

        return $builder->get()->getResultArray();
    }



    // public function getSalesReport($search = null, $paymentInput = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $offset = 0)
    // {
    //     $session = \Config\Services::session();
    //     $businessID = $session->get('businessID');
    //     $builder = $this->db->table('invoices');
    //     $builder->join('client', 'client.idClient = invoices.idClient');
    //     $builder->join('currency', 'currency.id = invoices.idCurrency');
    //     $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod');
    //     $builder->select('invoices.*, client.client as clientName, currency.Currency, paymentmethods.Method as PaymentMethod');
    //     $builder->select('(SELECT SUM(Sum) FROM invoicedetail WHERE invoicedetail.idReceipts = invoices.idReceipts) as Fee');

    //     $builder->where('invoices.idBusiness', $businessID);

    //     // if (!empty($search)) {
    //     //     $builder->groupStart()
    //     //         ->like('invoices.invOrdNum', $search)
    //     //         ->orLike('client.client', $search)
    //     //         ->orLike('currency.Currency', $search)
    //     //         ->orLike('paymentmethods.Method', $search)
    //     //         ->groupEnd();
    //     // }

    //     if (!empty($search)) {
    //         $builder->where('client.client', $search);
    //     }


    //     if (!empty($paymentInput)) {
    //         $builder->where('invoices.paymentMethod', $paymentInput);
    //     }

    //     if (!empty($clientName)) {
    //         $builder->like('client.client', $clientName);
    //     }

    //     if (!empty($fromDate) && !empty($toDate)) {
    //         $builder->where('invoices.Date >=', $fromDate)
    //             ->where('invoices.Date <=', $toDate);
    //     }
    //     $builder->orderBy('invoices.idReceipts', 'DESC');
    //     $builder->limit($perPage, $offset);
    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }

    public function getSalesReport($search = null, $invoice = null, $paymentInput = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $offset = 0)
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $builder = $this->db->table('invoices');
        $builder->join('client', 'client.idClient = invoices.idClient');
        $builder->join('currency', 'currency.id = invoices.idCurrency');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod');
        $builder->select('invoices.*, client.client as clientName, currency.Currency, paymentmethods.Method as PaymentMethod');
        $builder->select('(SELECT SUM(Sum) FROM invoicedetail WHERE invoicedetail.idReceipts = invoices.idReceipts) as Fee');

        $builder->where('invoices.idBusiness', $businessID);
        $builder->where('invoices.isSummaryInvoice', 0);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('invoices.invOrdNum', $search)
                ->orLike('client.client', $search)
                ->orLike('currency.Currency', $search)
                ->orLike('paymentmethods.idReceipts', $search)
                ->orLike('invoices.idReceipts', $search)
                ->groupEnd();
        }

        if (!empty($invoice)) {
            $builder->where('invoices.idReceipts', $invoice);
        }

        if (!empty($paymentInput)) {
            $builder->where('paymentmethods.idPaymentMethods', $paymentInput);
        }

        if (!empty($clientName)) {
            $builder->like('client.client', $clientName);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('invoices.Date >=', $fromDate)
                ->where('invoices.Date <=', $toDate);
        }

        $builder->orderBy('invoices.idReceipts', 'DESC');
        $builder->limit($perPage, $offset);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getPager($search = null, $paymentInput = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $currentPage = 1)
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $builder = $this->db->table('invoices');
        $builder->join('client', 'client.idClient = invoices.idClient');
        $builder->join('currency', 'currency.id = invoices.idCurrency');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod');
        $builder->select('invoices.*, client.client as clientName, currency.Currency, paymentmethods.Method as PaymentMethod');
        $builder->select('(SELECT SUM(Sum) FROM invoicedetail WHERE invoicedetail.idReceipts = invoices.idReceipts) as Fee', false);
        $builder->where('invoices.idBusiness', $businessID);

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

        $totalQuery = $builder->get();
        $total = $totalQuery->getNumRows();

        $pager = service('pager');
        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return $pagerLinks;
    }


    public function getSalesDetailsReport($search = null, $item = null, $payment = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $offset = 0)
    {
        $businessId = session()->get('businessID');
        $builder = $this->db->table('invoicedetail');
        $builder->join('invoices', 'invoices.idReceipts = invoicedetail.idReceipts');
        $builder->join('client', 'client.idClient = invoices.idClient');
        $builder->join('currency', 'currency.id = invoices.idCurrency');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod');
        $builder->select('invoicedetail.*, invoices.invOrdNum as Order, client.client as clientName, client.contact as contact, client.age as age, client.gender as gender, client.state as country , currency.Currency, paymentmethods.Method as PaymentMethod');

        if (!empty($search)) {
            $builder->groupStart()
                ->orLike('client.client', $search)
                ->like('client.contact', $search)
                ->orLike('client.age', $search)
                ->orLike('client.gender', $search)
                ->like('client.state', $search)
                ->like('paymentmethods.idPaymentMethods', $search)
                ->like('client.clientUniqueId', $search)
                ->like('invoicedetail.idArtMenu', $search)
                ->groupEnd();
        }

        if (!empty($item)) {
            $builder->where('invoicedetail.idArtMenu', $item);
        }

        if (!empty($payment)) {
            $builder->where('paymentmethods.idPaymentMethods', $payment);
        }

        if (!empty($clientName)) {
            $builder->where('client.client', $clientName);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('invoices.Date >=', $fromDate)
                ->where('invoices.Date <=', $toDate);
        }

        $builder->where('invoices.idBusiness', $businessId);
        $builder->orderBy('idInvoiceDetail', 'DESC');
        $builder->limit($perPage, $offset);
        $result = $builder->get()->getResultArray();

        return $result;
    }

    public function getdetailPager($search = null, $payment = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $currentPage = 1)
    {
        $businessId = session()->get('businessID');
        $builder = $this->db->table('invoicedetail');
        $builder->join('invoices', 'invoices.idReceipts = invoicedetail.idReceipts');
        $builder->join('client', 'client.idClient = invoices.idClient');
        $builder->join('currency', 'currency.id = invoices.idCurrency');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod');
        $builder->select('invoicedetail.*, client.clientUniqueId as unique, client.client as clientName, client.contact as contact, client.age as age, client.gender as gender, client.state as country , currency.Currency, paymentmethods.Method as PaymentMethod');

        if (!empty($search)) {
            $builder->groupStart()
                ->orLike('client.client', $search)
                ->like('client.contact', $search)
                ->orLike('client.age', $search)
                ->orLike('client.gender', $search)
                ->like('client.state', $search)
                ->like('paymentmethods.idPaymentMethods', $search)
                ->like('client.clientUniqueId', $search)
                ->groupEnd();
        }

        if (!empty($payment)) {
            $builder->where('paymentmethods.idPaymentMethods', $payment);
        }

        if (!empty($clientName)) {
            $builder->where('client.client', $clientName);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('invoices.Date >=', $fromDate)
                ->where('invoices.Date <=', $toDate);
        }

        $totalQuery = $builder->get();
        $total = $totalQuery->getNumRows();

        $pager = service('pager');
        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return $pagerLinks;
    }


    public function getTotalServiceDetailFee($search = null, $item = null, $payment = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $offset = 0)
    {
        $businessId = session()->get('businessID');
        $builder = $this->db->table('invoicedetail');
        $builder->selectSum('Sum');
        $builder->join('invoices', 'invoices.idReceipts = invoicedetail.idReceipts');
        $builder->join('client', 'client.idClient = invoices.idClient');
        $builder->join('currency', 'currency.id = invoices.idCurrency');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = invoices.paymentMethod');

        if (!empty($search)) {
            $builder->groupStart()
                ->orLike('client.client', $search)
                ->like('client.contact', $search)
                ->orLike('client.age', $search)
                ->orLike('client.gender', $search)
                ->like('client.state', $search)
                ->like('paymentmethods.idPaymentMethods', $search)
                ->like('client.clientUniqueId', $search)
                ->like('invoicedetail.idArtMenu', $search)
                ->groupEnd();
        }

        if (!empty($item)) {
            $builder->where('invoicedetail.idArtMenu', $item);
        }

        if (!empty($payment)) {
            $builder->where('paymentmethods.idPaymentMethods', $payment);
        }

        if (!empty($clientName)) {
            $builder->where('client.client', $clientName);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('invoices.Date >=', $fromDate)
                ->where('invoices.Date <=', $toDate);
        }

        $query = $builder->get();
        $result = $query->getRowArray();
        return $result['Sum'] ?? 0;
    }
    public function getExpiryData($productId, $businessId)
    {
        $db = \Config\Database::connect();
        $query = $db->table('itemsExpiry')
            ->where('idInventory', $productId)
            ->where('businessID', $businessId)
            ->get();
        return $query->getResultArray();
    }


    // public function getServiceExpiry($serviceId, $businessID)
    // {
    //     $db = \Config\Database::connect();
    //     $query = $db->table('itemsexpiry ie')
    //         ->select('ie.expiryDate')
    //         ->join('ratio r', 'ie.idInventory = r.idItem')
    //         ->join('itemsinventory ii', 'ie.idInventory = ii.idInventory')
    //         ->join('artmenu am', 'r.idArtMenu = am.idArtMenu')
    //         ->where('am.idArtMenu', $serviceId)
    //         ->where('r.idBusiness', $businessID)
    //         ->get();

    //     return $query->getResultArray();
    // }

    public function getServiceExpiry($serviceId, $businessID)
    {
        $db = \Config\Database::connect();
        $ratioQuery = $db->table('ratio')
            ->select('idItem')
            ->where('idArtMenu', $serviceId)
            ->where('idBusiness', $businessID)
            ->get();
        $ratioResult = $ratioQuery->getResultArray();
        if (empty($ratioResult)) {
            return [];
        }
        $idItem = array_column($ratioResult, 'idItem');
        $inventoryQuery = $db->table('itemsinventory')
            ->select('idInventory')
            ->whereIn('idItem', $idItem)
            ->get();
        $inventoryResult = $inventoryQuery->getResultArray();
        if (empty($inventoryResult)) {
            return [];
        }
        $idInventory = array_column($inventoryResult, 'idInventory');
        $expiryQuery = $db->table('itemsexpiry')
            ->select('expiryDate')
            ->whereIn('idInventory', $idInventory)
            ->get();
        return $expiryQuery->getResultArray();
    }

    // public function getInvoiceByOrdNum($invOrdNum)
    // {
    //     $session = \Config\Services::session();
    //     $businessID = $session->get('businessID');
    //     return $this->db->table('invoices')
    //         ->where('invOrdNum', $invOrdNum)
    //         ->where('idBusiness', $businessID)
    //         ->get()
    //         ->getRow();
    // }

    // public function getInvoiceByOrdNum($invOrdNum)
    // {
    //     $session = \Config\Services::session();
    //     $businessID = $session->get('businessID');

    //     $invoice = $this->db->table('invoices')
    //         ->where('invOrdNum', $invOrdNum)
    //         ->where('idBusiness', $businessID)
    //         ->get()
    //         ->getRow();

    //     if ($invoice) {
    //         $payments = $this->db->table('invoicepaymentdetails')
    //             ->selectSum('value')
    //             ->where('idReceipt', $invoice->idReceipts)
    //             ->get()
    //             ->getRow();
    //         $totalPaid = $payments->value ?? 0;
    //         $invoice->remainingValue = $invoice->Value - $totalPaid;
    //     }

    //     return $invoice;
    // }

    public function getInvoiceByOrdNum($idReceipts)
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $invoice = $this->db->table('invoices')
            ->where('idReceipts', $idReceipts)
            ->where('idBusiness', $businessID)
            ->get()
            ->getRow();

        if ($invoice) {
            $payments = $this->db->table('invoicepaymentdetails')
                ->selectSum('invoicepaymentdetails.value', 'totalPaid')
                ->join('invoicepayment', 'invoicepayment.idPayment = invoicepaymentdetails.idPayment')
                ->where('invoicepayment.idReceipt', $invoice->idReceipts)
                ->get()
                ->getRow();

            $totalPaid = $payments->totalPaid ?? 0;
            $invoice->remainingValue = $invoice->Value - $totalPaid;
        }

        return $invoice;
    }


    public function getReferenceInvoices($idReceipts)
    {
        return $this->db->table('invoicerefrences')
            ->select('referenceID, idReceipt, receiptReference')
            ->where('idReceipt', $idReceipts)
            ->orWhere('receiptReference', $idReceipts)
            ->get()
            ->getResultArray();
    }
    public function getInvoiceByIdReceipts($idReceipts)
    {

        return $this->db->table('invoices')
            ->where('idReceipts', $idReceipts)
            ->get()
            ->getRow();
    }

    // public function getpayment()
    // {
    //     return $this->db->table('paymentmethods')
    //         ->select('idPaymentMethods, Method')
    //         ->get()
    //         ->getResultArray();
    // }

    public function cancelInvoice($idReceipts)
    {
        $model = new salesModel();
        $result = $model->duplicateInvoice($idReceipts);

        if ($result) {
            return redirect()->to('/viewServiceDetails/' . $idReceipts)->with('success', 'Invoice duplicated successfully');
        } else {
            return redirect()->to('/viewServiceDetails/' . $idReceipts)->with('error', 'Failed to duplicate invoice');
        }
    }

}
