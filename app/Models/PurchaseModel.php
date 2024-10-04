<?php
namespace App\Models;

use CodeIgniter\Model;

class PurchaseModel extends Model
{
    protected $table = 'itemswarehouse';
    protected $primaryKey = 'idItem';

    protected $allowedFields = [
        'Code',
        'Name',
        'Unit',
        'Cost',
        'Minimum',
        'Notes',
        'idBusiness',
        'idTAX',
        'idCategories',
        'barcode',
        'idWarehouse',
        'status',
        'characteristic1',
        'characteristic2',
        'isSendEmail',
        'isSendExpire',
    ];

    public function getitems()
    {
        $builder = $this->db->table('itemswarehouse')
            ->select('itemswarehouse.*, taxtype.value as tax_value, taxtype.tax_id as idTVSH')
            ->join('taxtype', 'itemswarehouse.idTAX = taxtype.tax_id', 'left')
            ->where('itemswarehouse.status', 'Active');

        // if ($enableService != 1) {
        //     $builder->where('artmenu.isService', 0);
        // }
        return $builder->get()->getResultArray();
    }

    public function getServiceExpiry($serviceId, $businessID)
    {
        $db = \Config\Database::connect();
        $ratioQuery = $db->table('ratio')
            ->select('idItem')
            ->where('idItem', $serviceId)
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

    public function getItemsByCategory($categoryId)
    {
        $builder = $this->db->table('itemswarehouse');
        $builder->select('itemswarehouse.*, taxtype.value as tax_value');
        $builder->join('taxtype', 'taxtype.tax_id = itemswarehouse.idTAX', 'left');

        if ($categoryId !== null) {
            $builder->where('itemswarehouse.idCategories', $categoryId);
        }

        // if ($enableService != 1) {
        //     $builder->where('isService', 0);
        // }

        return $builder->get()->getResultArray();
    }

    public function getSupplierNames()
    {
        $businessId = session()->get('businessID');
        return $this->db->table('supplier')
            ->select('*')
            ->where('status', 'Active')
            ->where('idBusiness', $businessId)
            ->get()
            ->getResult();
    }

    public function insertPurchaseInvoice($data)
    {
        return $this->db->table('purchase_invoices')->insert($data);
    }

    // public function subtractFromInventory($idItems, $quantity, $businessID, $expiryDate)
    // {
    //     // $idItems = $itemId;
    //     $ratio = 1;

    //     foreach ($idItems as $idItem) {
    //         $inventorySubtract = $quantity * $ratio;

    //         log_message('debug', 'Updating inventory for item: ' . $idItem . ' with quantity: ' . $inventorySubtract);
    //         $this->db->table('itemsinventory')
    //             ->where('idItem', $idItem)
    //             ->set('inventory', 'inventory - ' . $inventorySubtract, FALSE)
    //             ->update();

    //         if ($this->isExpiryEnabled($businessID)) {

    //             $query = $this->db->table('itemsinventory')
    //                 ->select('idInventory')
    //                 ->where('idItem', $idItem)
    //                 ->get();

    //             if ($query->getNumRows() > 0) {
    //                 $idInventory = $query->getRow()->idInventory;


    //                 $this->db->table('itemsexpiry')
    //                     ->where('idInventory', $idInventory)
    //                     ->where('expiryDate', $expiryDate)
    //                     ->set('inventory', 'inventory - ' . $inventorySubtract, FALSE)
    //                     ->update();
    //             }
    //         }
    //     }
    // }



    public function subtractFromInventory($idItems, $quantity, $businessID, $expiryDate)
    {
        if (!is_array($idItems)) {
            $idItems = [$idItems]; // Convert single ID to array
        }

        $ratio = 1;

        foreach ($idItems as $idItem) {
            $inventorySubtract = $quantity * $ratio;

            log_message('debug', 'Updating inventory for item: ' . $idItem . ' with quantity: ' . $inventorySubtract);
            $this->db->table('itemsinventory')
                ->where('idItem', $idItem)
                ->set('inventory', 'inventory - ' . $inventorySubtract, FALSE)
                ->update();

            if ($this->isExpiryEnabled($businessID)) {
                $query = $this->db->table('itemsinventory')
                    ->select('idInventory')
                    ->where('idItem', $idItem)
                    ->get();

                if ($query->getNumRows() > 0) {
                    $idInventory = $query->getRow()->idInventory;

                    $this->db->table('itemsexpiry')
                        ->where('idInventory', $idInventory)
                        ->where('expiryDate', $expiryDate)
                        ->set('inventory', 'inventory - ' . $inventorySubtract, FALSE)
                        ->update();
                }
            }
        }
    }

    public function addToInventory($idItems, $quantity, $businessID, $warehouseId, $expiryDate)
    {
        if (!is_array($idItems)) {
            $idItems = [$idItems]; // Convert single ID to array
        }

        $ratio = 1; // Assuming ratio is 1 as in the original logic

        foreach ($idItems as $idItem) {
            $inventoryAdd = $quantity * $ratio;

            log_message('debug', 'Updating inventory for item: ' . $idItem . ' in warehouse: ' . $warehouseId . ' with quantity: ' . $inventoryAdd);

            // Add the quantity where idWarehouse matches
            $this->db->table('itemsinventory')
                ->where('idItem', $idItem)
                ->where('idWarehouse', $warehouseId) // Add warehouse matching
                ->set('inventory', 'inventory + ' . $inventoryAdd, FALSE)
                ->update();

            if ($this->isExpiryEnabled($businessID)) {
                $query = $this->db->table('itemsinventory')
                    ->select('idInventory')
                    ->where('idItem', $idItem)
                    ->where('idWarehouse', $warehouseId) // Ensure warehouse matches
                    ->get();

                if ($query->getNumRows() > 0) {
                    $idInventory = $query->getRow()->idInventory;

                    $this->db->table('itemsexpiry')
                        ->where('idInventory', $idInventory)
                        ->where('expiryDate', $expiryDate)
                        ->set('inventory', 'inventory + ' . $inventoryAdd, FALSE) // Add to expiry inventory
                        ->update();
                }
            }
        }
    }

    public function isExpiryEnabled($businessID)
    {
        $query = $this->db->table('config')
            ->select('isExpiry')
            ->where('businessID', $businessID)
            ->get();

        if ($query->getNumRows() > 0) {
            return $query->getRow()->isExpiry == 1;
        }
        return false;
    }

    public function getWareHouse()
    {
        return $this->db->table('warehouse')
            ->select('idWarehouse, name')
            ->get()
            ->getResultArray();
    }

    public function getPurchaseDetails($idReceipts)
    {
        return $this->db->table('purchaseinvoicedetail')
            ->join('itemswarehouse', 'itemswarehouse.idItem = purchaseinvoicedetail.idItem')
            ->join('purchase_invoices', 'purchase_invoices.idReceipts = purchaseinvoicedetail.idReceipts')
            ->join('supplier', 'supplier.idSupplier = purchase_invoices.idSupplier')
            ->join('paymentmethods', 'paymentmethods.idPaymentMethods = purchase_invoices.paymentMethod', 'left') // Join with paymentmethods table
            ->join('currency', 'currency.id = purchase_invoices.idCurrency', 'left')
            ->where('purchaseinvoicedetail.idReceipts', $idReceipts)
            ->select('purchaseinvoicedetail.*, itemswarehouse.Unit as Unit,itemswarehouse.Name as ServiceTypeName,itemswarehouse.Code as Code,purchase_invoices.Notes, purchase_invoices.invOrdNum, purchase_invoices.Status, purchase_invoices.Value, purchase_invoices.invoice_period_end_date as due, purchase_invoices.Date as InvoiceDate, purchase_invoices.Time as InvoiceTime, supplier.*, paymentmethods.Method as PaymentMethod, currency.Currency as Currency')
            ->get()
            ->getResultArray();
    }

    public function getPurchasePaymentDetails($idReceipts)
    {
        return $this->db->table('purchaseinvoicepayment')
            ->join('purchaseinvoicepaymentdetails', 'purchaseinvoicepaymentdetails.idPayment = purchaseinvoicepayment.idPayment')
            ->join('paymentmethods', 'paymentmethods.idPaymentMethods = purchaseinvoicepaymentdetails.method', 'left')
            ->join('currency', 'currency.id = purchaseinvoicepaymentdetails.idPaymentMethod', 'left')
            ->where('purchaseinvoicepayment.idReceipt', $idReceipts)
            ->select('purchaseinvoicepaymentdetails.*, paymentmethods.Method as PaymentMethodName, currency.Currency as Currency')
            ->get()
            ->getResultArray();
    }

    public function getPurchaseItems()
    {
        return $this->db->table('itemswarehouse')
            ->select('itemswarehouse.*, taxtype.value as tax_value, taxtype.tax_id as idTVSH')
            ->join('taxtype', 'itemswarehouse.idTAX = taxtype.tax_id', 'left')
            ->where('itemswarehouse.status', 'Active')
            ->get()
            ->getResultArray();
    }

    public function getPurchaseInvoiceByOrdNum($idReceipts)
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $invoice = $this->db->table('purchase_invoices')
            ->where('idReceipts', $idReceipts)
            ->where('idBusiness', $businessID)
            ->get()
            ->getRow();

        if ($invoice) {
            $payments = $this->db->table('purchaseinvoicepaymentdetails')
                ->selectSum('purchaseinvoicepaymentdetails.value', 'totalPaid')
                ->join('purchaseinvoicepayment', 'purchaseinvoicepayment.idPayment = purchaseinvoicepaymentdetails.idPayment')
                ->where('purchaseinvoicepayment.idReceipt', $invoice->idReceipts)
                ->get()
                ->getRow();

            $totalPaid = $payments->totalPaid ?? 0;
            $invoice->remainingValue = $invoice->Value - $totalPaid;
        }

        return $invoice;
    }

    public function getPurchaseReferenceInvoices($idReceipts)
    {
        return $this->db->table('purchaseinvoicerefrences')
            ->select('referenceID, idReceipt, receiptReference')
            ->where('idReceipt', $idReceipts)
            ->orWhere('receiptReference', $idReceipts)
            ->get()
            ->getResultArray();
    }

    public function getPurchaseInvoiceById($idReceipts)
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        $invoice = $this->db->table('purchase_invoices')
            ->where('idReceipts', $idReceipts)
            ->where('idBusiness', $businessID)
            ->get()
            ->getRow();

        if ($invoice) {
            $payments = $this->db->table('purchaseinvoicepaymentdetails')
                ->selectSum('purchaseinvoicepaymentdetails.value', 'totalPaid')
                ->join('purchaseinvoicepayment', 'purchaseinvoicepayment.idPayment = purchaseinvoicepaymentdetails.idPayment')
                ->where('purchaseinvoicepayment.idReceipt', $invoice->idReceipts)
                ->get()
                ->getRow();

            $invoice->totalPaid = $payments->totalPaid ?? 0;
        }

        return $invoice;
    }

    public function getPurchaseInvoiceDetailsByReceiptId($idReceipts)
    {
        return $this->db->table('purchaseinvoicedetail')
            ->where('idReceipts', $idReceipts)
            ->get()
            ->getResult();
    }

    public function getPurchaseInvoicePaymentsByReceiptId($idReceipts)
    {
        return $this->db->table('purchaseinvoicepayment')
            ->where('idReceipt', $idReceipts)
            ->get()
            ->getResult();
    }

    public function getLatestPurchaseInvoice()
    {
        $session = \Config\Services::session();
        $businessID = $session->get('businessID');
        return $this->db->table('purchase_invoices')
            ->orderBy('invOrdNum', 'DESC')
            ->where('idBusiness', $businessID)
            ->limit(1)
            ->get()
            ->getRowArray();
    }

    public function getInvoiceById($idReceipts)
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

            $invoice->totalPaid = $payments->totalPaid ?? 0;
        }

        return $invoice;
    }

    public function getPurchaseDetails1($idReceipts)
    {
        return $this->db->table('purchaseinvoicedetail')
            ->join('itemswarehouse', 'itemswarehouse.idItem = purchaseinvoicedetail.idItem')
            ->join('purchase_invoices', 'purchase_invoices.idReceipts = purchaseinvoicedetail.idReceipts')
            ->join('supplier', 'supplier.idSupplier = purchase_invoices.idSupplier')
            ->join('units', 'units.idUnit = itemswarehouse.Unit')
            ->join('paymentmethods', 'paymentmethods.idPaymentMethods = purchase_invoices.paymentMethod', 'left')
            ->join('currency', 'currency.id = purchase_invoices.idCurrency', 'left')
            ->where('purchaseinvoicedetail.idReceipts', $idReceipts)
            ->select('purchaseinvoicedetail.*, units.name as Unit,itemswarehouse.Name as ServiceTypeName, itemswarehouse.Code as Code, purchase_invoices.Notes, purchase_invoices.invOrdNum, purchase_invoices.Status, purchase_invoices.Value, purchase_invoices.invoice_period_end_date as due, purchase_invoices.timeStamp as InvoiceDate, purchase_invoices.Time as InvoiceTime,purchase_invoices.ValueTVSH as TVSH, supplier.*, paymentmethods.Method as PaymentMethod, currency.Currency as Currency, purchaseinvoicedetail.Discount') // Added invoicedetail.Discount
            ->get()
            ->getResultArray();
    }


}