<?php
$session = session();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Test Report</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: black;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* margin-bottom: 20px;
            padding-bottom: 20px; */
        }

        .header img {
            max-height: 90px;
            max-width: 90px;
        }

        .company-info {
            text-align: left;
        }

        .company-info p {
            /* margin: 5px 0; */
            font-size: 14px;
        }

        .company-info h2 {
            margin: 0;
            color: #0091ea;
        }

        .qr-code {
            /* max-width: 150px; */
            text-align: right;
        }

        .divider {
            border-bottom: 7px solid #1424b7;
            width: 100%;
            /* margin: 10px 0; */
            /* position: relative; */
        }

        .divider::before {
            content: '';
            position: absolute;
            width: 75%;
            height: 7px;
            top: -3px;
            left: 0;
            background: linear-gradient(to right, transparent 20%, brown 50%, transparent 80%);
        }

        .section-title {
            color: #0091ea;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 30px; */
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            /* border-bottom: 1px solid #ddd; */
        }

        th {
            /* background-color: #0091ea;
            color: white; */

            background-color: transparent;
            color: black;
            border-top: 2px solid black;
            border-bottom: 2px solid black;

        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .footer {
            text-align: center;
            color: orange;
            border-top: 1px solid #ddd;
            /* padding-top: 20px;
            margin-top: 40px; */

            font-weight: 900;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="header" style="margin-bottom:0px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 15%;">
                    <?php
                    if ($session->has('businessProfileImage')) {
                        echo '<img class="img-xs rounded-circle larger-profile-img" style="width: 90px; height: 90px;" src="' . $session->get('businessProfileImage') . '" alt="Profile image">';
                    }
                    ?>
                </td>
                <td style="width: 55%; text-align: left;">
                    <div class="invoice-details" style="display: inline-block; text-align: left;">

                        <p
                            style="font-weight: bold; color:#0d206d; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">

                            <?php
                            if ($session->has('businessName') && $session->has('phoneNumber')) {

                                echo '' . $session->get('businessName') . '<br>';
                                echo 'Phone : ' . $session->get('phoneNumber') . '<br>';
                                echo 'Address : ' . $session->get('business_address') . '<br>';
                                echo 'Email : ' . $session->get('business_email') . '<br>';
                            }
                            ?>
                        </p>
                    </div>
                </td>
                <td style="width: 30%; text-align: right; ">
                    <img src="<?= $qrDataUri ?>" alt="QR Code" style="width: 110px; height: 110px;">
                </td>
                <!-- <td style=" width: 33.33%;">
                    </td> -->
            </tr>
        </table>
    </div>

    <div class="divider" style="margin-top: 0px;"></div>
    <table style="width: 100%; border-spacing: 0; margin-top: 0px;">
        <tr>
            <td style="width: 33.33%; vertical-align: top;">
                <p><strong><?= $labTest['patient']; ?></strong> </p>
                <p>Age: <?= $labTest['patientage']; ?></p>
                <p>Sex: <?= $labTest['patientsex']; ?></p>
                <p>MR: <?= $labTest['MR']; ?></p>
            </td>

            <td style="width: 2px; background-color: #ccc; padding: 0; margin: 0; border: none; height: 100%;"></td>

            <td style="width: 33.33%; vertical-align: top;">
                <p>Operator Name: <?= $session->get('fName'); ?></p>

                <?php if (!empty($labTest['doctor'])): ?>
                    <p>Referred By: <strong><?= $labTest['doctor']; ?></strong></p>
                <?php endif; ?>
            </td>
            <td style="width: 2px; background-color: #ccc; padding: 0; margin: 0; border: none; height: 100%;"></td>
            <td style="width: 33.33%; vertical-align: top;">
                <p><strong>Registered At:</strong> <?= $labTest['registered_at']; ?></p>
                <p><strong>Collected At:</strong> <?= $labTest['collected_at']; ?></p>
                <p><strong>Reported At:</strong> <?= $labTest['reported_at']; ?></p>
            </td>
        </tr>
    </table>

    <hr>

    <p
        style="color: 0d206d;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-align: center; width: 100%; background-color: burlywood; font-weight: 900;">
        EXAMINATION REPORT</p>


    <h3 class="section-title">Lab Test Details Breakdown</h3>
    <table>
        <thead>
            <tr>
                <th>Test</th>
                <!-- <th>Fee</th>
                <th>Actual Fee</th>
                <th>Discount</th> -->
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($labTestDetails as $detail): ?>
                <tr>
                    <td><?= $detail['TestName']; ?></td>
                    <!-- <td><?= $detail['fee']; ?></td>
                    <td><?= $detail['actual_fee']; ?></td>
                    <td><?= $detail['discount']; ?></td> -->
                    <td><?= $detail['createdAT']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3 class="section-title">Lab Report Attributes</h3>
    <table>
        <thead>
            <tr>
                <th>Attribute</th>
                <th>Result</th>
                <th>Reference Value</th>
                <th>Unit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($labReport as $report): ?>
                <tr>
                    <td><?= $report['attributeTitle']; ?></td>
                    <td><?= $report['result']; ?></td>
                    <td><?= $report['reference']; ?></td>
                    <td><?= $report['unit']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <div
        style="position: fixed; bottom: 8%; left: 0; width: 100%; padding: 10px 0; margin: 0; text-align: center; border-top: 1px solid #ddd;">
        <table style="width: 100%; border-spacing: 0; bottom: 10%;">
            <tr>
                <td style="width: 33.33%; vertical-align: top; text-align: center">
                    <p style="text-decoration: underline;"><strong>Medical Lab Technician</strong></p>
                </td>
                <td style="width: 33.33%; vertical-align: top; text-align: center">
                    <p style="text-decoration: underline;"><strong>Dr. <?= $labTest['doctor']; ?></strong></p>
                </td>
                <td style="width: 33.33%; vertical-align: top;text-align: center">
                    <p style="text-decoration: underline;"><strong>Medical Lab Technician</strong></p>
                </td>
            </tr>
        </table>
        <hr>

    </div>


    <div class="footer"
        style="position: fixed; bottom: 0; left: -8%; width: 100%;  margin-right: -15%; text-align: center; border-top: 1px solid #ddd;">
        <p>Generated on <?= date('Y-m-d'); ?> | www.regexbyte.com</p>
    </div>

</body>

</html>