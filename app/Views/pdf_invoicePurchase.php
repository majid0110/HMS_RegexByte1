<!DOCTYPE html>
<html>
<!-- <html lang="ar"> for arabic only -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Services Invoice</title>

    <style>
        @media print {
            @page {
                margin: 0 auto;
                sheet-size: 300px 250mm;
            }

            html {
                direction: rtl;
            }

            html,
            body {
                font-size: 12px;
                margin: 0;
                padding: 0
            }

            #printContainer {
                font-size: 12px;
                width: 250px;
                margin: auto;
                /*padding: 10px;*/
                /*border: 2px dotted #000;*/
                text-align: justify;
            }

            /*span {
                display: inline-block;
                min-width: 350px;
                white-space: nowrap;
                background: red;
            }*/

            .text-center {
                text-align: center;
            }
        }
    </style>
</head>

<body onload="window.print();">
    <?php
    date_default_timezone_set('Asia/Karachi');
    $peshawarTimeZone = new DateTimeZone('Asia/Karachi');
    $currentDateTime = new DateTime('now', $peshawarTimeZone);
    $date = $currentDateTime->format('d-m-Y');
    $time = $currentDateTime->format('h:i:s');
    ?>
    <table style="text-align: left">
        <tr>
            <td style="padding-left: 7% ;text-align: left;">Invoice# <b>
                    <?= $InvoiceNumber ?>
                </b> </td>

        </tr>
        <tr style="text-align: left">
            <td style="padding-left: 7% ; text-align: left;">Date:<b>
                    <?= $date; ?>
                </b></td>
            <td style="padding-left: 7%;text-align: right;">Time:<b>
                    <?= $time; ?>
                </b></td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
    </table>
    <h1 id="logo" class="text-center" style="margin-top: 5px; margin-bottom: 5px;">
        <?php
        $session = session();
        if ($session->has('businessProfileImage')) {
            echo '<img class="img-xs rounded-circle larger-profile-img" style="width: 120px; height: 120px; margin-top: 10px; margin-bottom: 10px;" src="' . $session->get('businessProfileImage') . '" alt="Profile image">';
        } else {
            // Default image or alternative content if the session variable is not set
            echo '<img style="width: 120px; height: 120px; margin-top: 5px; margin-bottom: 5px;" src="' . base_url() . './public/assets/images/regexbyte.png" alt="Default Logo">';
        }
        ?>
    </h1>


    <div id='printContainer'>

        <?php
        $session = session();
        if ($session->has('businessName') && $session->has('phoneNumber') && $session->has('business_address')) {
            echo '<h2 id="slogan" style="margin: 0; font-size: 12px;" class="text-center"><span class="text-black fw-bold" style="font-weight: bold;">' . $session->get('businessName') . '</span></h2>';

            echo '<p id="slogan" class="text-center" style="margin: 0; font-size: 12px;"><span class="text-black fw-bold" style="font-weight: normal;">' . $session->get('phoneNumber') . '</span></p>';
            echo '<p id="slogan" class="text-center" style="margin: 0; font-size: 12px;"><span class="text-black fw-bold" style="font-weight: normal;">' . $session->get('business_address') . '</span></p>';

            echo '<br>';
        }
        ?>

        <table>

            <?php
            date_default_timezone_set('Asia/Karachi');
            $peshawarTimeZone = new DateTimeZone('Asia/Karachi');
            $currentDateTime = new DateTime('now', $peshawarTimeZone);
            $date = $currentDateTime->format('d-m-Y');
            $time = $currentDateTime->format('h:i:s');
            ?>
            <tr>
                <td style=" width: 50%; white-space: nowrap;">Supplier<b>
                        <?= $clientName ?>
                    </b></td>

            </tr>
            <tr>
                <?php if ($isHospital): ?>
                    <td style="width: 50%; white-space: nowrap; text-align: left; padding-right: 5px;">Contact:<b>
                            <?= $Contact; ?>
                        </b>
                    </td>
                <?php else: ?>
                    <td style="width: 50%;"></td>
                <?php endif; ?>
                <td style="width: 50%; white-space: nowrap; text-align: right; padding-left: 7%; padding-right: 10px">
                    Operator:<b>
                        <?= $operatorName; ?>
                    </b>
                </td>
            </tr>
            <tr>

                <td style=" width: 50%; white-space: nowrap;">PaymentMethod:<b>
                        <?= $paymentMethodName; ?>
                    </b></td>
                <td style=" width: 50%; white-space: nowrap;text-align: right;padding-left:7%;padding-right: 10px">
                    Currency:<b>
                        <?= $currencyName; ?>
                    </b></td>
            </tr>

            <tr>
                <td colspan="2"></td>
            </tr>
        </table>
        <hr>

        <table style="font-size: 14px;">
            <tr>
                <td style="text-align: left;"><b>Service</b></td>
                <td style="text-align: right;padding-left:25px;"><b>Fee</b></td>
                <td style="text-align: right; padding-left:4px;"><b>Qty</b></td>
                <!-- <td style="text-align: right; padding-left:4%;"><b>Discount</b></td> -->
                <td style="text-align: right; padding-left:4%;"><b>Tax</b></td>
                <td style="text-align: right;padding-left:4%; padding-right: 10px;"><b>Total</b></td>
            </tr>

            <?php
            if (!empty($services)) {
                foreach ($services as $service) {
                    echo '<tr>';
                    echo '<td style="margin-left: 20px;">' . htmlspecialchars($service['serviceName']) . '</td>';
                    echo '<td style="text-align: right; padding-left:25px;">' . number_format(floatval($service['fee']), 2) . '</td>';
                    echo '<td style="text-align: right;padding-left:4px;">' . intval($service['quantity']) . '</td>';

                    $discountAmount = (floatval($service['fee']) * floatval($service['discount'])) / 100;
                    echo '<td style="text-align: right;padding-left:4%;">' . number_format(floatval($service['calculatedTax']), 2) . '</td>';

                    $total = (floatval($service['fee']) * intval($service['quantity'])) - $discountAmount;
                    echo '<td style="text-align: right; padding-left:4%; padding-right: 10px;">' . number_format($total, 2) . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr>';
                echo '<td colspan="5">No service details available.</td>';
                echo '</tr>';
            }
            ?>

        </table>

        <hr>

        <?php
        $totalTax = 0;
        foreach ($services as $service) {
            $totalTax += floatval($service['calculatedTax']);
        }
        ?>

        <table style="width: 100%; font-size: 20px;">
            <tr>
                <td style="width: 50%; text-align: left;">&nbsp;</td>
                <td style="width: 100%; text-align: right; padding-right:10px; font-size: 18px;"><b>Total :</b>
                    <?php
                    $totalAmount = 0;
                    foreach ($services as $service) {
                        $totalAmount += floatval($service['quantity']) * floatval($service['fee']);
                    }
                    echo number_format($totalAmount, 2);
                    ?>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: left;">&nbsp;</td>
                <?php
                $totalDiscount = 0;
                foreach ($services as $service) {
                    $discountValue = (floatval($service['fee']) * floatval($service['discount'])) / 100;
                    $totalDiscount += $discountValue * floatval($service['quantity']);
                }
                ?>
                <td style="width: 100%; text-align: right; padding-right:10px; font-size: 18px;">
                    <b>Discount :</b> <?= number_format($totalDiscount, 2) ?>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: left;">&nbsp;</td>
                <td style="width: 100%; text-align: right; padding-right:10px; font-size: 18px;"><b>Total Tax :</b>
                    <?= number_format($totalTax, 2) ?>
                </td>
            </tr>
            <tr>
                <td style="width: 30%; text-align: left;">&nbsp;</td>
                <?php
                $totalAmount = 0;
                foreach ($services as $service) {
                    $discountAmount = (floatval($service['fee']) * floatval($service['discount'])) / 100;
                    $totalAmount += floatval($service['quantity']) * (floatval($service['fee']) - $discountAmount);
                }
                ?>
                <td style="width: 110%; text-align: right; padding-right:10px; font-size: 18px;">
                    <b>Receiving Amount :</b>
                    <?= number_format($totalAmount, 2) ?>
                </td>
            </tr>
        </table>

        <br>


        <div style="text-align:center">
            <a style="text-decoration:none" href="www.regexbyte.com">www.regexbyte.com</a>
        </div>

    </div>
</body>

</html>
<?php /*
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice</title>
<style>
table {
width: 100%;
border-collapse: collapse;
margin-top: 20px;
}

th, td {
border: 1px solid black;
padding: 8px;
text-align: left;
}
</style>
</head>
<body>
<h1>Invoice</h1>

<h2>Invoice Details</h2>
<p><strong>Payment:</strong> <?= $paymentDetailsData['idPaymentMethod'] ?></p>
<p><strong>Exchange:</strong> <?= $invoiceData['rate'] ?></p>
<p><strong>paymentMethod:</strong> <?= $invoiceData['paymentMethod'] ?></p>
<p>Client Name: <?= $clientName; ?></p>
<p>Payment Method Name: <?= $paymentMethodName; ?></p>
<p>Currency Name: <?= $currencyName; ?></p>


<p><strong>Total Fee:</strong> <?= $invoiceData['Value'] ?></p>
<!-- Add more details as needed -->

<h2>Services</h2>
<table>
<thead>
<tr>
<th>Service Type</th>
<th>Service Name</th>
<th>Fee</th>
</tr>
</thead>
<tbody>
<?php foreach ($services as $service): ?>
<tr>
<td><?= $service['serviceTypeId'] ?></td>
<td><?= $service['serviceName'] ?></td>
<td><?= $service['fee'] ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</body>
</html>
*/ ?>