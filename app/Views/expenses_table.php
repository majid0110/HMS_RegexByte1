<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">


<body>
    <div class="container-scroller">
        <!-- partial:./public/assets/partials/_navbar.html -->

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            <?php include 'include_common/sidebar.php'; ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Expense</h4>
                                <form class="pt-3" method="POST" action="<?php echo base_url() . "export_expenses"; ?>"
                                    enctype="multipart/form-data">

                                    <div class="form-group row">
                                        <div class="col-md-2">
                                            <label>By Client</label>
                                            <div id="the-basics">
                                                <select class="form-control" name="clientName" id='clientInput'>
                                                    <option value="">All Clients</option>
                                                    <?php foreach ($client_names as $client): ?>
                                                        <option value="<?= $client['client']; ?>">
                                                            <?= $client['client']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>By Users</label>
                                            <div id="the-basics">
                                                <select class="form-control" name="userName" id='userInput'>
                                                    <option value="">All Users</option>
                                                    <?php foreach ($users as $user): ?>
                                                        <option value="<?= $user['fName']; ?>">
                                                            <?= $user['fName']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label>By Users</label>
                                            <div id="the-basics">
                                                <select class="form-control" name="userName" id='projectInput'>
                                                    <option value="">All Projects</option>
                                                    <?php foreach ($projects as $project): ?>
                                                        <option value="<?= $project['project_id']; ?>">
                                                            <?= $project['project_id']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label>From</label>
                                            <input class="form-control" type="date" placeholder="From"
                                                id="fromDateInput" name="fromDate">
                                        </div>
                                        <div class="col-md-2">
                                            <label>To</label>
                                            <input class="form-control" type="date" placeholder="To" id="toDateInput"
                                                name="toDate">
                                        </div>
                                    </div>

                                    <div class="col-md-3">

                                        <label>Search</label>
                                        <input class="form-control" type="text" name="search" id="searchInput"
                                            placeholder="Search">
                                    </div>

                                    <button type="submit" name="export" value="export"
                                        style="align-self: flex-end;color: white;background-color: #172D88;border-color: #172D88;height: 33px;font-size: 12px;font-weight: 500;box-sizing: border-box;border: 1px solid #CADDFF;padding: 8px 15px;border-radius: 6px;align-items: center;">
                                        <i class="ti-download"></i>
                                        Export
                                    </button>
                                </form>
                                <hr>
                                <div class="table-responsive">
                                    <!-- <div class="table-responsive"> -->
                                    <table class="table table-striped" id="expensesTable">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <!-- <th>Project</th> -->

                                                <th>Client</th>
                                                <th>Team Member</th>
                                                <th>Category</th>
                                                <th>Project</th>
                                                <th>Amount</th>
                                                <th>Expense Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($expenses as $expense): ?>
                                                <tr>
                                                    <td>
                                                        <?= $expense['title']; ?>
                                                    </td>
                                                    <td>
                                                        <?= $expense['clientName']; ?>
                                                    </td>
                                                    <td>
                                                        <?= $expense['userName']; ?>
                                                    </td>
                                                    <td>
                                                        <?= $expense['Category']; ?>
                                                    </td>

                                                    <td>
                                                        <?= $expense['project_id']; ?>
                                                    </td>
                                                    <td>
                                                        <?= $expense['amount']; ?>
                                                    </td>

                                                    <td>
                                                        <?= $expense['expense_date']; ?>
                                                    </td>

                                                    <td>

                                                        <a href="<?= base_url('editExpense/' . $expense['id']); ?>"
                                                            class="btn btn-info btn-sm">Edit</a>

                                                        <a href="<?= base_url('deleteExpense/' . $expense['id']); ?>"
                                                            onclick="return confirm('Are you sure you want to delete this Record?');"
                                                            class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:./public/assets/partials/_footer.html -->
                <?php include 'include_common/footer.php'; ?>
                <!-- partial -->
            </div>

            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="./public/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="./public/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            function updateTable() {
                var clientName = $('#clientInput').val();
                var userName = $('#userInput').val();
                var projectId = $('#projectInput').val();
                var fromDate = $('#fromDateInput').val();
                var toDate = $('#toDateInput').val();
                var search = $('#searchInput').val();

                console.log(search);
                console.log(clientName);

                $.ajax({
                    url: '<?= base_url('expenses_table') ?>',
                    type: 'GET',
                    data: {
                        clientName: clientName,
                        userName: userName,
                        projectId: projectId,
                        fromDate: fromDate,
                        toDate: toDate,
                        search: search
                    },
                    success: function (response) {
                        var tableBody = $('#expensesTable tbody');
                        tableBody.empty();

                        $.each(response, function (index, expense) {
                            var row = '<tr>' +
                                '<td>' + expense.title + '</td>' +
                                '<td>' + expense.clientName + '</td>' +
                                '<td>' + expense.userName + '</td>' +
                                '<td>' + expense.Category + '</td>' +
                                '<td>' + (expense.project_id || '') + '</td>' +
                                '<td>' + expense.amount + '</td>' +
                                '<td>' + expense.expense_date + '</td>' +
                                '<td>' +
                                '<a href="<?= base_url('editExpense/') ?>' + expense.id + '" class="btn btn-info btn-sm">Edit</a> ' +
                                '<a href="<?= base_url('deleteExpense/') ?>' + expense.id + '" onclick="return confirm(\'Are you sure you want to delete this Record?\');" class="btn btn-danger btn-sm">Delete</a>' +
                                '</td>' +
                                '</tr>';
                            tableBody.append(row);
                        });
                    }
                });
            }

            $('#clientInput, #userInput, #projectInput, #fromDateInput, #toDateInput').on('change', function () {
                updateTable();
            });

            $('#searchInput').on('input', function () {
                console.log('Search input changed:', $(this).val());
                updateTable();
            });
        });
    </script>
    <script src="./public/assets/js/off-canvas.js"></script>
    <script src="./public/assets/js/hoverable-collapse.js"></script>
    <script src="./public/assets/js/template.js"></script>
    <script src="./public/assets/js/settings.js"></script>
    <script src="./public/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <!-- End custom js for this page-->
</body>


<!-- Mirrored from demo.bootstrapdash.com/star-admin2-free/template/pages/tables/basic-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2024 05:42:35 GMT -->

</html>