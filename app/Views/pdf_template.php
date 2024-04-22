<!DOCTYPE html>
<html>
<!-- <html lang="ar"> for arabic only -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Appointment Details</title>
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
    <table style="text-align: left">
        <tr>
            <td style="padding-left: 7% ;text-align: left;">Invoice# <b>
                    <?= $InvoiceNumber ?>
                </b> </td>
            <td style="padding-left:13%;text-align: right;">Patient Unique# <b>
                    <?= $clientUnique ?>
                </b> </td>
        </tr>
        <tr style="text-align: left">
            <td style="padding-left: 7% ; text-align: left;">Date:<b>
                    <?= $appointmentData['appointmentDate']; ?>
                </b></td>
            <td style="padding-left: 11%;text-align: right;">Time:<b>
                    <?= $appointmentData['appointmentTime']; ?>
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
            <tr>
                <td style=" width: 50%; white-space: nowrap;">Patient:<b>
                        <?= $clientName ?>
                    </b></td>
                <td style=" width: 50%; white-space: nowrap;text-align: right;padding-left:13%;">Gender:<b>
                        <?= $Gender; ?>
                    </b></td>
            </tr>
            <tr>
                <td style=" width: 50%; white-space: nowrap;text-align: left;padding-right:15px;">Age:<b>
                        <?= $Age; ?>
                    </b></td>

                <td style=" width: 50%; white-space: nowrap;text-align: right;padding-left:13%;">Operator:<b>
                        <?= $operatorName; ?>
                    </b></td>

            </tr>

            <tr>
                <td style=" width: 50%; white-space: nowrap;">Doctor:<b>
                        <?= $doctorName ?>
                    </b></td>
                <td style=" width: 50%; white-space: nowrap;text-align: right;padding-left:13%;">Specialization:<b>
                        <?= $specializationName; ?>
                    </b></td>
            </tr>

        </table>
        <!-- <p class="text-center"><img src="<?= base_url() ?>global/site/qr.png" alt="QR-code" class="left" /></p> -->
        <hr>

        <table>
            <tr>
                <td><b>Appointment</b></td>
                <td style="text-align: right;padding-left: 50%;"><b>Fee</b></td>
            </tr>

            <tr>
                <td colspan="2">

                </td>
            </tr>
            <tr>
                <td style="margin-left: 20px;">
                    <?= $appointmentTypeName; ?>
                </td>
                <td style="text-align: right;padding-left: 50%;">
                    <?= $appointmentData['appointmentFee']; ?>.00
                </td>
            </tr>


            <!-- <tr>
            <td> eco badge for waterless car washThe service at Detailing Knights is not only unmatched, it is also mobile, waterless and environmentally friendly. </td>
            <td></td>
        </tr> -->
        </table>
        <div style="margin-top: -2%;margin-bottom: -12px;">
            <hr>
        </div>
        <table style="width: 100%;">

            <tr>
                <td style="font-size: 9px; margin-top: 0%; margin-bottom: 0%;"><b>Hospital Fee<b></td>
                <td style="font-size: 9px; text-align: right;padding-left: 50%;margin-top: 0%; margin-bottom: 0%;">
                    <?= $hospitalfee ?>.00
                </td>
            </tr>
        </table>
        <div style="margin-top: -3%;">
            <hr>
        </div>

        <table style="width: 100%;">
            <tr>
                <td style="text-align: left;">&nbsp;</td>

                <td style="text-align:  right; padding-right:8px" colspan="2"><b>Total</b> PKR
                    <?= $total ?>.00
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