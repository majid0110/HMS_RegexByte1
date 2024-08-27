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
            <th>Appointment Time</th>
            <th>Appointment Type</th>
            <th>Fee</th>
            <th>Total Fee</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($Campdata as $camp): ?>
            <tr>
                <td>
                    <?= $camp['clientName']; ?>
                </td>
                <td>
                    <?= $camp['doctorFirstName'] . ' ' . $camp['doctorLastName']; ?>
                </td>
                <td>
                    <?= $camp['appointmentDate']; ?>
                </td>
                <td>
                    <?= $camp['appointmentTime']; ?>
                </td>
                <td>
                    <?= $camp['appointmentTypeName']; ?>
                </td>
                <td>
                    <?= $camp['appointmentFee']; ?>
                </td>

                <td>
                    <?= $camp['appointmentFee'] ?>
                </td>

                <td>
                    <a href="<?= base_url('OPDAppointmentinvoice/' . $camp['appointmentOPD']); ?>"
                        class="btn btn-info btn-sm">Inoice</a>
                    <a href="<?= base_url('deleteGeneralOPD/' . $camp['appointmentOPD']); ?>"
                        onclick="return confirm('Are you sure you want to delete this Appointment?');"
                        class="btn btn-danger btn-sm">Delete</a>
                </td>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>

</table>