<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Invoice</title>
    <style>
        /* Add your custom styles for the PDF here */
    </style>
</head>

<body onload="window.print();">
    <h1>Appointment Invoice</h1>
    <p><strong>Appointment Number:</strong>
        <?= $appointmentNumber; ?>
    </p>
    <p><strong>Client Name:</strong>
        <?= $clientName; ?>
    </p>
    <p><strong>Doctor Name:</strong>
        <?= $doctorName; ?>
    </p>
    <p><strong>Appointment Date:</strong>
        <?= $appointmentDate; ?>
    </p>
    <p><strong>Appointment Time:</strong>
        <?= $appointmentTime; ?>
    </p>
    <p><strong>Appointment Type:</strong>
        <?= $appointmentTypeName; ?>
    </p>
    <p><strong>Doctor Fee:</strong>
        <?= $doctorFee; ?>
    </p>
    <p><strong>Hospital Charges:</strong>
        <?= $charges; ?>
    </p>
</body>

</html>