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
        <table id="service-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Contact</th>
                    <th>UniqueID</th>
                    <th>State</th>
                    <th>Service</th>
                    <th>Currancy</th>
                    <th>Method</th>
                    <th>FEE</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($Sales as $Sale): ?>
                    <tr>
                        <td>
                            <?= $Sale['clientName']; ?>
                        </td>
                        <td>
                            <?= $Sale['gender']; ?>
                        </td>
                        <td>
                            <?= $Sale['age']; ?>
                        </td>
                        <td>
                            <?= $Sale['contact']; ?>
                        </td>
                        <td>
                            <?= $Sale['unique']; ?>
                        </td>
                        <td>
                            <?= $Sale['country']; ?>
                        </td>
                        <td>
                            <?= $Sale['name']; ?>
                        </td>
                        <td>
                            <?= $Sale['Currency']; ?>
                        </td>
                        <td>
                            <?= $Sale['PaymentMethod']; ?>
                        </td>
                        <td>
                            <?= $Sale['Sum']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>