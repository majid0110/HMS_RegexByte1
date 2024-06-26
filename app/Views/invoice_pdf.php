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
            padding: 20px;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .company-details,
        .client-details {
            width: 45%;
        }

        .invoice-details {
            text-align: center;
            margin-bottom: 20px;
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
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <?php
    $session = session();
    ?>
    <div>
        <div class="header">
            <table>
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#payModal" onclick="loadPayInvoice('<?= $ServiceDetails[0]['invOrdNum']; ?>')">Pay</button> -->
                <tr>
                    <td class="title">
                        <?php
                        $session = session();
                        if ($session->has('businessProfileImage')) {
                            echo '<img class="img-xs rounded-circle larger-profile-img" style="width: 90px; height: 90px;" src="' . $session->get('businessProfileImage') . '" alt="Profile image">';
                        }
                        ?>
                        <style="width: 100%; max-width: 350px" />
                    </td>

                    <td style="text-align: center;">
                        <div class="invoice-details" style="display: inline-block; text-align: left;">
                            <h2>Invoice <?= $ServiceDetails[0]['invOrdNum']; ?> / <?= date("Y"); ?></h2>
                            <p style="font-weight: bold;">
                                Date: <?= date("Y-m-d H:i:s"); ?><br>
                                <?php
                                $session = session();
                                if ($session->has('businessName') && $session->has('phoneNumber')) {
                                    echo 'Operator Name:' . $session->get('fName') . '<br>';
                                    echo '' . $session->get('businessName') . '<br>';
                                    echo '' . $session->get('phoneNumber') . '<br>';
                                    echo '' . $session->get('business_address') . '<br>';
                                }
                                ?>
                            </p>
                        </div>
                    </td>



                    <td>

                    </td>
                    <td class="title">
                        <?php
                        $session = session();
                        if ($session->has('businessProfileImage')) {
                            echo '<img class="img-xs rounded-circle larger-profile-img" style="width: 90px; height: 90px;" src="' . $session->get('businessProfileImage') . '" alt="Profile image">';
                        }
                        ?>
                        <style="width: 100%; max-width: 300px" />
                    </td>
            </table>
        </div>

        <table>
            <tr>
                <td>

                    <b>Seller:</b><br /> <?= $session->get('businessName') ?? 'Business Name'; ?><br /><br />
                    <b>Address:</b><br /> <?= $session->get('business_address') ?? 'Business Address'; ?><br /><br />
                    <b>Phone No:</b><br /> <?= $session->get('phoneNumber') ?? 'Phone Number'; ?><br />
                </td>
                <td>

                    <b>Buyer:</b><br /> <?= $ServiceDetails[0]['client']; ?><br /><br />
                    <b>Address:</b><br /> <?= $ServiceDetails[0]['address']; ?><br />
                    <b>Contact:</b><br /> <?= $ServiceDetails[0]['contact']; ?><br /><br />

                </td>
            </tr>
        </table>

        <br>

        <table>
            <thead>
                <tr>
                    <th
                        style="padding: 10px; text-align: left; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd;">
                        Code</th>
                    <th
                        style="padding: 10px; text-align: left; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd;">
                        Service Type</th>
                    <th
                        style="padding: 10px; text-align: left; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd;">
                        Quantity</th>
                    <th
                        style="padding: 10px; text-align: left; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd;">
                        Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($ServiceDetails as $detail) {
                    $total += $detail['Price'] * $detail['Quantity'];
                }
                ?>
                <?php foreach ($ServiceDetails as $detail): ?>
                    <tr class="item">
                        <td>
                            <?= $detail['Code']; ?>
                        </td>
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
            </tbody>
        </table>

        <p class="total">VALUE: <?= $total; ?></p>


        <div class="footer">
            <p>Thank you for your business. Please make the payment by the due date.</p>
        </div>
    </div>
</body>

</html>