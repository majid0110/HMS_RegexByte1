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
                    <th>Contact</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Added By</th>
                    <th>Date</th>
                    <th>FEE</th>
                    <!-- <th>Nationality</th> -->
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
                            <?= $test['contact']; ?>
                        </td>
                        <td>
                            <?= $test['gender']; ?>
                        </td>
                        <td>
                            <?= $test['age']; ?>
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
                        <!-- <td>
                            <?= $test['country']; ?>
                        </td> -->
                        <td>
                            <a href="<?= base_url('generateTestInvoice/' . $test['test_id']); ?>"
                                class="btn btn-primary btn-sm"><i class="mdi mdi-ticket-confirmation"></i>
                            </a>

                            <a href="<?= base_url('viewTestDetails/' . $test['test_id']); ?>"
                                class="btn btn-info btn-sm">View Details</a>

                            <a href="<?= base_url('deleteTest/' . $test['test_id']); ?>"
                                onclick="return confirm('Are you sure you want to delete this Record?');"
                                class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</div>