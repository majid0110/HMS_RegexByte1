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
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <!-- <th>Project</th> -->

                                                <th>Client</th>
                                                <th>Team Member</th>
                                                <th>Category</th>
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