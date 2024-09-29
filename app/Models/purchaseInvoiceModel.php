<?php

namespace App\Models;

use CodeIgniter\Model;

class purchaseInvoiceModel extends Model
{
    protected $table = 'purchase_invoices';
    protected $primaryKey = 'idReceipts';
    protected $allowedFields = [
        'idSupplier',
        'Value',
        'actual_Value',
        'Date',
        'Time',
        'Notes',
        'idWarehouse',
        'idUser',
        'Status',
        'idBusiness',
        'idCancellation',
        'invOrdNum',
        'FIC',
        'ValueTVSH',
        'idCurrency',
        'rate',
        'paymentMethod',
        'timeStamp',
        'idPoint_of_sale',
        'isImport',
        'Contract',
        'transporterId',
        'invoice_period_start_date',
        'invoice_period_end_date',
        'invoiceType',
        'InvoiceNotes'
    ];

    public function insertPurchaseInvoice($data)
    {
        return $this->insert($data);
    }

    public function getPurchaseInvoiceNumber($businessID, $idPayment)
    {
        return $this->db->table($this->table)
            ->where('idBusiness', $businessID)
            ->where('idReceipts', $idPayment)
            ->select('invOrdNum')
            ->get()
            ->getRowArray()['invOrdNum'] ?? null;
    }

    public function getPurchaseFee($SupplierName, $search, $paymentValue, $invoice, $fromDate, $toDate, $perPage, $offset)
    {
        $builder = $this->db->table('purchase_invoices');
        $builder->join('supplier', 'supplier.idSupplier = purchase_invoices.idSupplier');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = purchase_invoices.paymentMethod');
        $builder->select('purchase_invoices.Value');
        // $builder->where('purchase_invoices.idBusiness', $businessID);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('supplier.supplier', $search)
                ->orLike('paymentmethods.Method', $search)
                // ->orLike('labtest.CreatedAT', $search)
                ->groupEnd();
        }

        if (!empty($paymentValue)) {
            $builder->where('paymentmethods.idPaymentMethods', $paymentValue);
        }
        if (!empty($invoice)) {
            $builder->where('purchase_invoices.idReceipts', $invoice);
        }

        if (!empty($SupplierName)) {
            $builder->where('supplier.supplier', $SupplierName);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('purchase_invoices.Date >=', $fromDate)
                ->where('purchase_invoices.Date <=', $toDate);
        }

        $builder->limit($perPage, $offset);

        $query = $builder->get();
        $results = $query->getResultArray();

        $totalFee = 0;
        foreach ($results as $row) {
            $totalFee += $row['Value'];
        }

        return $totalFee;
    }

    public function getPurchaseReport($search = null, $SupplierName = null, $paymentValue = null, $invoice = null, $fromDate = null, $toDate = null, $perPage = 20, $offset = 0)
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $builder = $this->db->table('purchase_invoices');
        $builder->join('supplier', 'supplier.idSupplier = purchase_invoices.idSupplier');
        $builder->join('currency', 'currency.id = purchase_invoices.idCurrency');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = purchase_invoices.paymentMethod');
        $builder->select('purchase_invoices.*,  supplier.supplier as SupplierName, currency.Currency, paymentmethods.Method as PaymentMethod');

        $builder->where('purchase_invoices.idBusiness', $businessID);


        if (!empty($search)) {
            $builder->groupStart()
                // ->like('supplier.supplier', $search)
                ->orLike('paymentmethods.Method', $search)
                // ->orLike('labtest.CreatedAT', $search)
                ->groupEnd();
        }

        if (!empty($SupplierName)) {
            $builder->where('supplier.supplier', $SupplierName);
        }
        if (!empty($invoice)) {
            $builder->where('purchase_invoices.idReceipts', $invoice);
        }

        if (!empty($paymentValue)) {
            $builder->where('paymentmethods.idPaymentMethods', $paymentValue);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('purchase_invoices.Date >=', $fromDate)
                ->where('purchase_invoices.Date <=', $toDate);
        }
        // $builder->orderBy('labtest.CreatedAT', 'DESC');
        $builder->limit($perPage, $offset);

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getPager($search = null, $paymentValue = null, $invoice = null, $SupplierName = null, $fromDate = null, $toDate = null, $perPage = 20, $currentPage = 1)
    {
        $builder = $this->db->table('purchase_invoices');
        $builder->select('COUNT(*) as total');
        $builder->join('supplier', 'supplier.idSupplier = purchase_invoices.idSupplier');
        $builder->join('currency', 'currency.id = purchase_invoices.idCurrency');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = purchase_invoices.paymentMethod');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('supplier.supplier', $search)
                ->orLike('paymentmethods.Method', $search)
                // ->orLike('labtest.CreatedAT', $search)
                ->groupEnd();
        }

        if (!empty($SupplierName)) {
            $builder->where('purchase_invoices.idSupplier', $SupplierName);
        }

        if (!empty($invoice)) {
            $builder->where('purchase_invoices.idReceipts', $invoice);
        }

        if (!empty($paymentValue)) {
            $builder->where('paymentmethods.idPaymentMethods', $paymentValue);
        }

        if (!empty($SupplierName)) {
            $builder->where('supplier.supplier', $SupplierName);
        }


        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('purchase_invoices.Date >=', $fromDate)
                ->where('purchase_invoices.Date <=', $toDate);
        }

        $totalQuery = $builder->get();
        $totalResult = $totalQuery->getRowArray();
        $total = isset($totalResult['total']) ? (int) $totalResult['total'] : 0;

        $pager = service('pager');
        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return $pagerLinks;
    }

    public function getInvoice()
    {
        return $this->db->table('purchase_invoices')
            ->select('idReceipts, invOrdNum')
            ->get()
            ->getResultArray();
    }

    //-------------------------------------------------------------
    public function getTotalPurchaseDetailFee($search = null, $item = null, $clientName = null, $payment = null, $fromDate = null, $toDate = null)
    {
        $businessId = session()->get('businessID');
        $builder = $this->db->table('purchaseinvoicedetail');
        $builder->selectSum('purchaseinvoicedetail.Sum');
        $builder->join('purchase_invoices', 'purchase_invoices.idReceipts = purchaseinvoicedetail.idReceipts');
        $builder->join('supplier', 'supplier.idSupplier = purchase_invoices.idSupplier');
        $builder->join('currency', 'currency.id = purchase_invoices.idCurrency');
        $builder->join('itemswarehouse', 'itemswarehouse.idItem = purchaseinvoicedetail.idItem');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = purchase_invoices.paymentMethod');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('paymentmethods.Method', $search)
                ->like('purchaseinvoicedetail.idItem', $search)
                ->like('itemswarehouse.Name', $search)
                ->like('supplier.supplier', $search)
                ->groupEnd();
        }

        if (!empty($item)) {
            $builder->where('purchaseinvoicedetail.idItem', $item);
        }

        if (!empty($payment)) {
            $builder->where('paymentmethods.idPaymentMethods', $payment);
        }

        if (!empty($clientName)) {
            $builder->where('supplier.supplier', $clientName);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('purchase_invoices.Date >=', $fromDate)
                ->where('purchase_invoices.Date <=', $toDate);
        }

        $query = $builder->get();
        $result = $query->getRowArray();
        return $result['Sum'] ?? 0;
    }

    public function getPurchaseDetailsReport($search = null, $item = null, $payment = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $offset = 0)
    {
        $businessId = session()->get('businessID');
        $builder = $this->db->table('purchaseinvoicedetail');
        $builder->join('purchase_invoices', 'purchase_invoices.idReceipts = purchaseinvoicedetail.idReceipts');
        $builder->join('supplier', 'supplier.idSupplier = purchase_invoices.idSupplier');
        $builder->join('currency', 'currency.id = purchase_invoices.idCurrency');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = purchase_invoices.paymentMethod');
        $builder->select('purchaseinvoicedetail.*,  supplier.supplier as clientName, supplier.contact as contact, supplier.city as country , currency.Currency, paymentmethods.Method as PaymentMethod');

        if (!empty($search)) {
            $builder->groupStart()

                ->like('paymentmethods.idPaymentMethods', $search)
                ->like('purchaseinvoicedetail.idItem', $search)
                ->like('supplier.supplier', $search)
                ->groupEnd();
        }

        if (!empty($item)) {
            $builder->where('purchaseinvoicedetail.idItem', $item);
        }

        if (!empty($payment)) {
            $builder->where('paymentmethods.idPaymentMethods', $payment);
        }

        if (!empty($clientName)) {
            $builder->where('supplier.supplier', $clientName);
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('purchase_invoices.Date >=', $fromDate)
                ->where('purchase_invoices.Date <=', $toDate);
        }

        $builder->where('purchase_invoices.idBusiness', $businessId);
        $builder->orderBy('idInvoiceDetail', 'DESC');
        $builder->limit($perPage, $offset);
        $result = $builder->get()->getResultArray();

        return $result;
    }

    public function getdetailPager($search = null, $payment = null, $clientName = null, $fromDate = null, $toDate = null, $perPage = 20, $currentPage = 1)
    {
        $businessId = session()->get('businessID');
        $builder = $this->db->table('purchaseinvoicedetail');
        $builder->join('purchase_invoices', 'purchase_invoices.idReceipts = purchaseinvoicedetail.idReceipts');
        $builder->join('supplier', 'supplier.idSupplier = purchase_invoices.idSupplier');
        $builder->join('currency', 'currency.id = purchase_invoices.idCurrency');
        $builder->join('paymentmethods', 'paymentmethods.idPaymentMethods = purchase_invoices.paymentMethod');
        $builder->select('purchaseinvoicedetail.*,  supplier.supplier as clientName, supplier.contact as contact, supplier.city as country , currency.Currency, paymentmethods.Method as PaymentMethod');

        if (!empty($search)) {
            $builder->groupStart()
                // ->orLike('client.client', $search)
                // ->like('client.contact', $search)
                // ->orLike('client.age', $search)
                // ->orLike('client.gender', $search)
                // ->like('client.state', $search)
                ->like('paymentmethods.idPaymentMethods', $search)
                // ->like('client.clientUniqueId', $search)
                ->groupEnd();
        }

        if (!empty($payment)) {
            $builder->where('paymentmethods.idPaymentMethods', $payment);
        }

        // if (!empty($clientName)) {
        //     $builder->where('client.client', $clientName);
        // }

        if (!empty($fromDate) && !empty($toDate)) {
            $builder->where('purchase_invoices.Date >=', $fromDate)
                ->where('purchase_invoices.Date <=', $toDate);
        }

        $totalQuery = $builder->get();
        $total = $totalQuery->getNumRows();

        $pager = service('pager');
        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $total, 'default_full');

        return $pagerLinks;
    }

}
