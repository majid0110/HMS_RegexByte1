<!DOCTYPE html>
<html>
<!-- <html lang="ar"> for arabic only -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Lab Test Invoice</title>

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
                    <?= $InvoiceNumber; ?>
                </b> </td>
            <td style="padding-left:13%;text-align: right;">Patient MR# <b>
                    <?= $clientUnique; ?>
                </b> </td>
        </tr>
        <tr style="text-align: left">
            <td style="padding-left: 7% ; text-align: left;">Date:<b>
                    <?= $date; ?>
                </b></td>
            <td style="padding-left: 11%;text-align: right;">Time:<b>
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
            <tr>
                <td style=" width: 50%; white-space: nowrap;">Patient:<b>
                        <?= $clientName1; ?>
                        <!-- <?= $data['clientName'] ?> -->
                    </b></td>
                <td style=" width: 50%; white-space: nowrap;text-align: right;padding-left:13%;">Gender:<b>
                        <?= $Gender; ?>
                    </b></td>
            </tr>
            <tr>
                <td style=" width: 50%; white-space: nowrap;">Age:<b>
                        <?= $Age; ?>
                    </b></td>
                <td style=" width: 50%; white-space: nowrap;text-align: right;padding-left:13%;">Operator:<b>
                        <?= $operatorName; ?>
                    </b></td>
            </tr>

            <?php if ($appointment !== 'Non'): ?>
                <tr>
                    <td style=" width: 50%; white-space: nowrap;">AppointmentID:<b>
                            <?= $appointment; ?>
                        </b></td>
                    <td style=" width: 50%; white-space: nowrap;text-align: right;padding-left:13%;">Doctor:<b>
                            <?= $doctorName; ?>
                        </b></td>
                </tr>
                <tr>
                    <td style=" width: 50%; white-space: nowrap;">AppointmentType:<b>
                            <?= $appointmentType; ?>
                        </b></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td style=" width: 100%; white-space: nowrap;">AppointmentID:<b>
                            <?= $appointment; ?>
                        </b></td>
                </tr>
            <?php endif; ?>

            <tr>
                <td colspan="2"></td>
            </tr>
        </table>
        <hr>
        <table>
            <tr>
                <td style="text-align: left;"><b>Test</b></td>
                <td style="text-align: right; padding-left:40%;"><b>Quantity</b></td>
                <td style="text-align: right;padding-left:4%;"><b>Fee</b></td>
                <!-- <td style="text-align: right;padding-left:4%;"><b>%</b></td> -->
                <td style="text-align: right;padding-left:4%;"><b>Total</b></td>


            </tr>

            <?php

            if (!empty($detailsData)) {
                foreach ($detailsData as $testItem) {
                    $discount_value = ($testItem['actual_fee'] * $testItem['discount']) / 100;

                    echo '<tr>';
                    echo '<td style="margin-left: 10px; width: 50px;">' . $testItem['testName'] . '</td>';
                    echo '<td  style="text-align: right;padding-left:10%;">1</td>';
                    echo '<td style="text-align: right; padding-left:4%;">' . number_format($testItem['actual_fee'], 2) . '</td>';
                    // echo '<td style="text-align: right; padding-left:4%;">' . number_format($discount_value, 2) . '</td>';
                    echo '<td style="text-align: right; padding-left:4%;">' . number_format($testItem['fee'], 2) . '</td>';

                    echo '</tr>';
                }
            } else {
                echo '<tr>';
                echo '<td colspan="2">No test details available.</td>';
                echo '</tr>';
            }
            ?>
        </table>

        <hr>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; text-align: left;">&nbsp;</td>
                <td style="width: 100%; text-align: right; padding-right:6px;"><b>Total :</b>
                    <?= $data['actual_fee']; ?>.00
                </td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: left;">&nbsp;</td>
                <td style="width: 100%; text-align: right; padding-right:6px;"><b>Total Discount :</b>
                    <?= $TotalDiscount; ?>.00
                </td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: left;">&nbsp;</td>

                <td style="width: 100%; text-align: right; padding-right:6px;"><b>Discounted Total :</b>
                    <?= $data['fee']; ?>.00
                </td>
            </tr>
            </tr>
        </table>
        <br>


        <div style="text-align:center">
            <a style="text-decoration:none" href="www.regexbyte.com">www.regexbyte.com</a>
        </div>

    </div>
</body>

</html>