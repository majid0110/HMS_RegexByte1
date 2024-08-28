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
            <th>Invoice NO #</th>
            <th>Client Name</th>
            <th>Currancy</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Date</th>
            <th>FEE</th>
            <th>Notes</th>
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
                    <span class="<?php
                    if ($Sale['Notes'] == 'Cancelled') {
                        echo 'text-bg-cancelled';
                    } elseif ($Sale['Notes'] == 'Corrective') {
                        echo 'text-bg-editted';
                    } else {

                        echo 'text-bg-default';
                    }
                    ?>">
                        <?= $Sale['Notes']; ?>
                    </span>
                </td>
                <td>
                    <a href="<?= base_url('regenerateInvoice/' . $Sale['idReceipts']); ?>"
                        class="btn btn-info btn-sm">Invoice</a>
                    <a href="<?= base_url('viewServiceDetails/' . $Sale['idReceipts']); ?>" class="btn btn-info btn-sm">View
                        Details</a>
                    <a href="<?= base_url('deleteSales/' . $Sale['idReceipts']); ?>"
                        class="btn btn-danger btn-sm delete-button" data-id="<?= $Sale['idReceipts'] ?>"
                        style="pointer-events: none; display: none;">Delete</a>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>