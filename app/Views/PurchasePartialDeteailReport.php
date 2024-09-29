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
                    <th>Invoice</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Sum</th>
                    <th>discount</th>
                    <th>Client</th>
                    <th>State</th>
                    <th>Method</th>

                </tr>
            </thead>
            <tbody>

                <?php foreach ($Sales as $Sale): ?>
                    <tr>

                        <td>
                            <?= $Sale['idReceipts']; ?>
                        </td>
                        <td>
                            <?= $Sale['name']; ?>
                        </td>
                        <td>
                            <?= $Sale['Price']; ?>
                        </td>
                        <td>
                            <?= $Sale['Quantity']; ?>
                        </td>
                        <td>
                            <?= $Sale['Sum']; ?>
                        </td>
                        <td>
                            <?= $Sale['Discount']; ?>
                        </td>
                        <td>
                            <?= $Sale['clientName']; ?>
                        </td>

                        <td>
                            <?= $Sale['country']; ?>
                        </td>

                        <td>
                            <?= $Sale['PaymentMethod']; ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-totals">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total:</td>
                    <td>
                        <?= $ServiceDetailFee ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
            </tfoot>
        </table>
    </div>
</div>