<head>
    <style>
        #service-table tfoot {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        #service-table tfoot .table-totals td {

            border-top: 2px solid #000;

        }
    </style>
</head>
<table id="service-table" class="table table-striped">
    <thead>
        <tr>
            <th>NO #</th>
            <th>Client</th>
            <th>Table</th>
            <th>Currancy</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Date</th>
            <th>FEE</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($Sales as $Sale): ?>
            <tr>
                <td>
                    <?= $Sale['invOrdNum']; ?>
                </td>
                <td>
                    <?= $Sale['clientName']; ?>
                </td>
                <td>
                    <?= $Sale['table']; ?>
                </td>
                <td>
                    <?= $Sale['Currency']; ?>
                </td>
                <td>
                    <?= $Sale['PaymentMethod']; ?>
                </td>
                <td>
                    <?= $Sale['Status']; ?>
                </td>
                <td>
                    <?= $Sale['Date']; ?>
                </td>
                <td>
                    <?= $Sale['Value']; ?>
                </td>
                <td>
                    <a href="<?= base_url('viewServiceDetails/' . $Sale['idReceipts']); ?>" class="btn btn-info btn-sm">View
                        Details</a>
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
            <td></td>
            <td>Total:</td>
            <td>
                <?= $totalServiceFee ?>
            </td>
            <td></td>
        </tr>
    </tfoot>
</table>