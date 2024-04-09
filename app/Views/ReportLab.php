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
                    <th>Client Name</th>

                    <th>Added By</th>
                    <th>Date</th>
                    <th>FEE</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Tests as $test): ?>
                    <tr>
                        <td>
                            <?= $test['clientName']; ?>
                        </td>

                        <td>
                            <?= $test['userName']; ?>
                        </td>
                        <td>
                            <?= $test['CreatedAT']; ?>
                        </td>
                        <td>
                            <?= $test['fee']; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('viewTestDetails/' . $test['test_id']); ?>"
                                class="btn btn-info btn-sm">View Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-totals">
                    <td></td>
                    <td></td>
                    <td>Total:</td>
                    <td>
                        <?= $totalLabFee ?>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>