<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lab Test Report</title>
    <style>
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #000000;
            background-color: #fff;
            margin: 0;
            padding: 1px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .company-details,
        .client-details {
            width: 45%;
        }

        .invoice-details {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .qr-code {
            text-align: center;
            margin: 10px 0;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
        }

        .website-url {
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
        <div class="website-url">www.regexbyte.com</div>
        <div class="header">
            <table style="width: 100%">
                <tr>
                    <td style="width: 33.33%">
                        <?php
                        if ($session->has('businessProfileImage')) {
                            echo '<img
                class="img-xs rounded-circle larger-profile-img"
                style="width: 90px; height: 90px"
                src="' . $session->get('businessProfileImage') . '"
                alt="Profile image" />';
                        } ?>
                    </td>
                    <td style="width: 33.33%; text-align: center">
                        <div class="invoice-details" style="display: inline-block; text-align: left">
                            <p style="font-weight: bold">
                                <?php
                                if (
                                    $session->has('businessName') &&
                                    $session->has('phoneNumber')
                                ) {
                                    echo 'Operator Name: ' .
                                        $session->get('fName') . '<br />';
                                    echo 'Business:' .
                                        $session->get('businessName') . '<br />';
                                    echo 'Phone:' .
                                        $session->get('phoneNumber') . '<br />';
                                    echo 'Address:' .
                                        $session->get('business_address') . '<br />';
                                } ?>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <h4>Lab Test Details</h4>
        <table>
            <tr>
                <th>Patient Name</th>
                <td><?= $labTest['patient']; ?></td>
            </tr>
            <tr>
                <th>Doctor</th>
                <td><?= $labTest['doctor']; ?></td>
            </tr>
            <tr>
                <th>Created By</th>
                <td><?= $labTest['user']; ?></td>
            </tr>

            <tr>
                <th>Fee</th>
                <td><?= $labTest['fee'] + $labTest['hospitalCharges']; ?></td>
            </tr>

            <tr>
                <th>Registered At</th>
                <td><?= $labTest['registered_at']; ?></td>
            </tr>
            <tr>
                <th>Collected At</th>
                <td><?= $labTest['collected_at']; ?></td>
            </tr>
            <tr>
                <th>Reported At</th>
                <td><?= $labTest['reported_at']; ?></td>
            </tr>
        </table>

        <h4>Lab Test Details Breakdown</h4>
        <table>
            <thead>
                <tr>
                    <th>Test</th>
                    <th>Fee</th>
                    <th>Actual Fee</th>
                    <th>Discount</th>
                    <th>Created AT</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($labTestDetails as $detail): ?>
                    <tr>
                        <td><?= $detail['TestName']; ?></td>
                        <td><?= $detail['fee']; ?></td>
                        <td><?= $detail['actual_fee']; ?></td>
                        <td><?= $detail['discount']; ?></td>
                        <td><?= $detail['createdAT']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4>Lab Report Attributes</h4>
        <table>
            <thead>
                <tr>
                    <th>Attribute</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($labReport as $report): ?>
                    <tr>
                        <td><?= $report['attributeTitle']; ?></td>
                        <td><?= $report['result']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="qr-code">
            <img src="<?= $qrDataUri; ?>" alt="QR Code" />
        </div>

        <div class="footer">
            <p>
                Generated on
                <?= date('Y-m-d'); ?>
            </p>
        </div>
    </div>
</body>

</html>