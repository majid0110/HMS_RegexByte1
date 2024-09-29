<head>
    <style>
        #lab-table tfoot {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        #lab-table tfoot .table-totals td {

            border-top: 2px solid #000;

        }
    </style>
</head>
<div class="col-12 grid-margin">
    <div class="table-responsive">
        <table id="lab-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Supplier</th>
                    <th>Currancy</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>FEE</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Purchases as $purchase): ?>
                    <tr>
                        <td>
                            <?= $purchase['idReceipts']; ?>
                        </td>
                        <td>
                            <?= $purchase['SupplierName']; ?>
                        </td>
                        <td>
                            <?= $purchase['Currency']; ?>
                        </td>
                        <td>
                            <?= $purchase['PaymentMethod']; ?>
                        </td>
                        <td>
                            <?= $purchase['Status']; ?>
                        </td>
                        <td>
                            <?= $purchase['Date']; ?>
                        </td>
                        <td>
                            <?= $purchase['Value']; ?>
                        </td>

                        <td>
                            <a href="<?= base_url('viewTestDetails/' . $purchase['idReceipts']); ?>"
                                class="btn btn-info btn-sm">View Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-totals">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total:</td>
                    <td>
                        <?= $totalPurchaseFee ?>
                    </td>
                    <td></td>
                </tr>

            </tfoot>
        </table>
    </div>
</div>