<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <?php
                                $session = session();
                                if ($session->has('businessProfileImage')) {
                                    echo '<img class="img-xs rounded-circle larger-profile-img" style="width: 90px; height: 90px;" src="' . $session->get('businessProfileImage') . '" alt="Profile image">';
                                }
                                ?>
                                <style="width: 100%; max-width: 300px" />
                            </td>

                            <td>
                                <?php
                                $session = session();
                                if ($session->has('businessName') && $session->has('phoneNumber')) {

                                    echo '<strong>' . $session->get('businessName') . '<br>';
                                    echo '<strong>' . $session->get('phoneNumber') . '<br>';
                                    echo '<strong>' . $session->get('business_address') . '<br>';
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
        <hr>
        <table>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <u><b>Invoice Details:</b></u><br />
                                Invoice #: <?= $ServiceDetails[0]['invOrdNum']; ?><br />
                                Due: <?= $ServiceDetails[0]['due']; ?><br />
                                Payment Method: <?= $ServiceDetails[0]['PaymentMethod']; ?><br />
                                Currency: <?= $ServiceDetails[0]['Currency']; ?><br />
                            </td>
                            <td>
                                <u><b>Client Details:</b></u><br />
                                Client: <?= $ServiceDetails[0]['client']; ?><br />
                                Contact: <?= $ServiceDetails[0]['contact']; ?><br />
                                Email: <?= $ServiceDetails[0]['email']; ?><br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Service Type</td>
                <td>Quantity</td>
                <td>Price</td>

            </tr>
            <?php
            $total = 0;
            foreach ($ServiceDetails as $detail) {
                $total += $detail['Price'] * $detail['Quantity'];
            }
            ?>

            <?php foreach ($ServiceDetails as $detail): ?>
                <tr class="item">
                    <td>
                        <?= $detail['ServiceTypeName']; ?>
                    </td>
                    <td>
                        <?= $detail['Quantity']; ?>
                    </td>
                    <td>
                        <?= $detail['Price']; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr class="total">
                <td></td>
                <td>Total: <?= $total; ?></td>
            </tr>



        </table>
    </div>
</body>

</html>