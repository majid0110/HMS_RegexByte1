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
                    <th>Unique-ID</th>
                    <th>Test type</th>
                    <th>Fee</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($details as $detail): ?>
                    <tr>
                        <td>
                            <?= $detail['clientName']; ?>
                        </td>
                        <td>
                            <?= $detail['contact']; ?>
                        </td>
                        <td>
                            <?= $detail['gender']; ?>
                        </td>
                        <td>
                            <?= $detail['age']; ?>
                        </td>
                        <td>
                            <?= $detail['unique']; ?>
                            </t>
                        <td>
                            <?= $detail['testTypeName']; ?>
                        </td>
                        <td>
                            <?= $detail['fee']; ?>
                        </td>
                        <td>
                            <?= $detail['createdAT']; ?>
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
                        <?= $LabDetailFee ?>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>