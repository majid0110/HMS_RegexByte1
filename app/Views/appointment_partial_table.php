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
            <th>Patient</th>
            <th>Doctor</th>
            <th>Date / Time</th>
            <th>Appointment Type</th>
            <th>Doctor Fee</th>
            <th>Hospital Fee</th>
            <th>Total Fee</th>
            <th>Actions</th>
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
                    <?= $appointment['appointmentDate']; ?> / <?= $appointment['appointmentTime']; ?>
                </td>
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

                <td>
                    <a href="<?= base_url('viewAppointmentDetails/' . $appointment['appointmentID']); ?>"
                        class="btn btn-info btn-sm">View Details</a>

                    <a href="<?= base_url('Appointmentinvoice/' . $appointment['appointmentID']); ?>"
                        class="btn btn-info btn-sm">Inoice</a>
                    <a href="<?= base_url('deleteAppointment/' . $appointment['appointmentID']); ?>"
                        onclick="return confirm('Are you sure you want to delete this Appointment?');"
                        class="btn btn-danger btn-sm">Delete</a>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>