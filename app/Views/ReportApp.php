<!-- app/Views/appointment_table.php -->

<head>
    <style>
        #appointments-table tfoot {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        #appointments-table tfoot .table-totals td {

            border-top: 2px solid #000;

        }
    </style>
</head>
<table id="appointments-table" class="table table-striped">
    <thead>
        <tr>
            <th>Client Name</th>
            <th>Doctor Name</th>

            <th>Appointment Date</th>
            <!-- <th>Appointment Time</th> -->
            <th>Appointment Type</th>
            <th>Doctor Fee</th>
            <th>Hospital Fee</th>
            <th>Total Fee</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($Appointments as $appointment): ?>
            <tr>
                <td>
                    <?= $appointment['clientName']; ?>
                </td>
                <td>
                    <?= $appointment['doctorFirstName'] . ' ' . $appointment['doctorLastName']; ?>
                </td>

                <td>
                    <?= $appointment['appointmentDate']; ?>
                </td>
                <!-- <td>
                                                            'appointmentTime'
                                                        </td> -->
                <td>
                    <?= $appointment['appointmentTypeName']; ?>
                </td>
                <td>
                    <?= $appointment['appointmentFee']; ?>
                </td>
                <td>
                    <?= $appointment['hospitalCharges']; ?>
                </td>
                <td>
                    <?= $appointment['appointmentFee'] + $appointment['hospitalCharges']; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Total:</td>
            <td>
                <?= $totalFeeByDoctor ?>
            </td>
            <td>
                <?= $totalHospitalCharges ?>
            </td>
            <td>
                <?= $totalFeeByDoctor + $totalHospitalCharges ?>
            </td>
        </tr>
    </tfoot>
</table>