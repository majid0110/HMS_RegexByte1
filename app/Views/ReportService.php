<table class="table table-striped">
    <thead>
        <tr>
            <th>Invoice NO #</th>
            <th>Client Name</th>
            <th>Currancy</th>
            <th>Payment Method</th>
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
</table>