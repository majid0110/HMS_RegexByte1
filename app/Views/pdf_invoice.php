<!DOCTYPE html>
<html>
<!-- <html lang="ar"> for arabic only -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Express Wash Customer Invoice</title>

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
                <td style="width: 50%;">Invoice# <b>59867</b> </td>
                <td style="width: 50%; text-align: right;">Date:<b><?= $date; ?></b></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left; margin-right: 5px;">Time:<b><?= $time; ?></b><br></td>
            </tr>

            <tr>
                <td style=" width: 50%; white-space: nowrap;">Client:<b><?= $clientName ?></b></td>
                <td style=" width: 50%; white-space: nowrap;text-align: right;padding-right:15px;">Currency:<b><?= $currencyName; ?></b></td>


            </tr>

            <tr>

                <td style=" width: 50%; white-space: nowrap;">PaymentMethod:<b> <?= $paymentMethodName; ?></b></td>
                <td style=" width: 50%; white-space: nowrap;text-align: right;padding-right:23px;">Exchange:<b><?= $invoiceData['rate'] ?></b></td>
            </tr>

            <tr>
                <td colspan="2"></td>
            </tr>
        </table>
        <hr>

        <table>
            <tr>
                <td><b>Service Name</b></td>
                <td style="padding-left: 100px;"><b>Fee</b></td>
            </tr>

            <?php
            if (!empty($services)) {
                foreach ($services as $service) {
                    echo '<tr>';
                    echo '<td style="margin-left: 20px;">' . $service['serviceName'] . '</td>';
                    echo '<td style="padding-left:100px">' . $service['fee'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr>';
                echo '<td colspan="2">No service details available.</td>';
                echo '</tr>';
            }
            ?>
        </table>

        <hr>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; text-align: left;">&nbsp;</td>
                <td style="width: 25%; text-align: right; padding-right:10px;"><b>Total</b> PKR:<?= $invoiceData['Value']; ?></td>
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