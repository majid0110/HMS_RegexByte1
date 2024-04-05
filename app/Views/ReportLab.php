<div class="col-12 grid-margin">
    <div class="table-responsive">
        <table class="table table-striped">
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
        </table>
    </div>
</div>