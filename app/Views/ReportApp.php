<!-- app/Views/appointment_table.php -->

<table class="table table-striped">
    <thead>
        <tr>
            <th>Client Name</th>
            <th>Doctor Name</th>
            <th>Doctor Fee</th>
            <th>Appointment Date</th>
            <!-- <th>Appointment Time</th> -->
            <th>Appointment Type</th>
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
                    <?= $appointment['appointmentFee']; ?>
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
                    <?= $appointment['hospitalCharges']; ?>
                </td>
                <td>
                    <?= $appointment['appointmentFee'] + $appointment['hospitalCharges']; ?>
                </td>
                <td>
                    <!-- Action buttons: Edit and Delete -->
                    <a href="<?= base_url('deleteAppointment/' . $appointment['appointmentID']); ?>"
                        onclick="return confirm('Are you sure you want to delete this Appointment?');"
                        class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>