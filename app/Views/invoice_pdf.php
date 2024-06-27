<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            background-color: #fff;
            margin: 0;
            padding: 1px;
            /* Reduced padding */
        }


        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            /* Reduced margin */
        }

        .company-details,
        .client-details {
            width: 45%;
        }

        .invoice-details {
            text-align: center;
            margin-bottom: 10px;
            /* Reduced margin */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }

        .qr-code {
            text-align: center;
            margin: 10px 0;
            /* Reduced margin */
        }

        .footer {
            text-align: center;
            margin-top: 10px;
        }

        .website-url {
            top: -10px;
            text-align: right;
            font-size: 12px;
            color: blue;
        }
    </style>
</head>

<body>
    <?php
    $session = session();
    ?>
    <div>
        <div class="website-url">www.regegbyte.com</div>
        <div class="header">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 33.33%;">
                        <?php
                        if ($session->has('businessProfileImage')) {
                            echo '<img class="img-xs rounded-circle larger-profile-img" style="width: 90px; height: 90px;" src="' . $session->get('businessProfileImage') . '" alt="Profile image">';
                        }
                        ?>
                    </td>
                    <td style="width: 33.33%; text-align: center;">
                        <div class="invoice-details" style="display: inline-block; text-align: left;">
                            <p style="font-weight: bold;">Invoice <?= $ServiceDetails[0]['invOrdNum']; ?> /
                                <?= date("Y"); ?>
                            </p>
                            <p style="font-weight: bold;">
                                Date: <?= $ServiceDetails[0]['InvoiceDate']; ?><br>
                                <?php
                                if ($session->has('businessName') && $session->has('phoneNumber')) {
                                    echo 'Operator Name: ' . $session->get('fName') . '<br>';
                                    echo '' . $session->get('businessName') . '<br>';
                                    echo '' . $session->get('phoneNumber') . '<br>';
                                    echo '' . $session->get('business_address') . '<br>';
                                }
                                ?>
                            </p>
                        </div>
                    </td>
                    <td style="width: 33.33%;"></td>
                </tr>
            </table>
        </div>

        <table>
            <tr>
                <td>
                    <b>Seller:</b><br /> <span
                        style="font-size: small;"><?= $session->get('businessName') ?? 'Business Name'; ?></span><br /><br />
                    <b>Address:</b><br /> <span
                        style="font-size: small;"><?= $session->get('business_address') ?? 'Business Address'; ?></span><br /><br />
                    <b>Phone No:</b><br /> <span
                        style="font-size: small;"><?= $session->get('phoneNumber') ?? 'Phone Number'; ?></span><br />
                </td>
                <td>
                    <b>Buyer:</b><br /><span
                        style="font-size: small;"><?= $ServiceDetails[0]['client']; ?></span><br /><br />
                    <b>Address:</b><br /> <span
                        style="font-size: small;"><?= $ServiceDetails[0]['address']; ?></span><br />
                    <b>Contact:</b><br /><span style="font-size: small;">
                        <?= $ServiceDetails[0]['contact']; ?><br /></span><br />
                    <b>CNIC:</b><br /> <span
                        style="font-size: small;"><?= $ServiceDetails[0]['CNIC']; ?></span><br /><br />
                </td>
            </tr>
        </table>

        <br>

        <table>
            <thead>
                <tr>
                    <th style="padding: 10px; text-align: left; border-bottom: 2px solid #000000;">
                        CODE</th>
                    <th style="padding: 10px; text-align: left; border-bottom: 2px solid #000000;">
                        ITEM</th>
                    <th style="padding: 10px; text-align: left;  border-bottom: 2px solid #000000;">
                        UNIT</th>
                    <th style="padding: 10px; text-align: left;  border-bottom: 2px solid #000000;">
                        QUANTITY</th>
                    <th style="padding: 10px; text-align: left;  border-bottom: 2px solid #000000;">
                        PRICE</th>
                    <th style="padding: 10px; text-align: left;  border-bottom: 2px solid #000000;">
                        TOTAL</th>
                    <th style="padding: 10px; text-align: left;  border-bottom: 2px solid #000000;">
                        TVSH</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $totalDiscount = 0;
                $newTotal = 0;
                foreach ($ServiceDetails as $detail) {
                    $total += $detail['Price'] * $detail['Quantity'];
                    $totalDiscount += $detail['Discount'];

                }
                $newTotal = $total - $totalDiscount;
                ?>
                <?php foreach ($ServiceDetails as $detail): ?>
                    <tr class="item">
                        <td style="text-align: left; font-size: x-small"><?= $detail['Code']; ?></td>
                        <td style="text-align: left; font-size: x-small"><?= $detail['ServiceTypeName']; ?></td>
                        <td style="text-align: left; font-size: x-small"><?= $detail['Unit']; ?></td>
                        <td style="text-align: left; font-size: x-small"><?= $detail['Quantity']; ?></td>
                        <td style="text-align: left; font-size: x-small"><?= $detail['Price']; ?></td>
                        <td style="text-align: left; font-size: x-small"><?= $detail['Quantity'] * $detail['Price']; ?></td>
                        <td style="text-align: left; font-size: x-small"><?= $detail['TVSH']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p class="total">VALUE: <?= $total; ?></p>
        <p class="total">DISCOUNT: <?= $totalDiscount; ?></p>
        <p class="total">DISCOUNTED PRICE : <?= $newTotal; ?></p>

        <table>
            <tr>

                <td>
                    <b>Currency:</b><br /> <?= $ServiceDetails[0]['Currency']; ?><br /><br />
                </td>
                <td>
                    <b>Payment Method:</b><br /> <?= $ServiceDetails[0]['PaymentMethod']; ?><br /><br />
                </td>
            </tr>
        </table>
    </div>
</body>

</html>