<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="./public/assets/vendors_s/select2-bootstrap-theme/select2-bootstrap.min.css">
    <style>
        /* Add this style to make the cursor change to a pointer when hovering over the card */
        .card {
            cursor: pointer;
        }

        .card:hover {
            background: cornflowerblue;
            color: whitesmoke;
            /* background-image: url("./public/assets/images_s/bg.jpeg"); */
        }

        .card:hover h4 {
            color: whitesmoke;

        }
    </style>
</head>

<body>

    <div class="container-scroller">
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            <!-- partial:../../partials/_sidebar.html -->
            <?php include 'include_common/sidebar.php'; ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <?php
                    $successMessage = session()->getFlashdata('success');
                    $errorMessage = session()->getFlashdata('error');

                    if ($successMessage) {
                        echo '<div class="alert alert-success">' . $successMessage . '</div>';
                    }

                    if ($errorMessage) {
                        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
                    }
                    ?>
                    <div class="row">
                        <!-- ----------------------------------------------------------- -->
                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card" onclick="window.location.href='<?= base_url('items_table'); ?>';">
                                <div class="card-body"
                                    style="display: flex; flex-direction: column; align-items: center;">
                                    <h4 class="card-title" style="text-align:center">Manage Items</h4>
                                    <div class="media">
                                        <i class="icon-lg mdi mdi-cube-outline" style="height:45px; width:45px;"></i>
                                    </div>
                                </div>

                            </div>
                        </div>




                        <!-- ---------------------------------------------------- -->

                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card" onclick="window.location.href='<?= base_url('Services_table'); ?>';">
                                <div class="card-body"
                                    style="display: flex; flex-direction: column; align-items: center;">
                                    <h4 class="card-title" style="text-align:center">Manage Service</h4>
                                    <div class="media">
                                        <i class="icon-lg mdi mdi-bed" style="height:45px; width:45px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card" onclick="window.location.href='<?= base_url('category_table'); ?>';">

                                <div class="card-body"
                                    style="display: flex; flex-direction: column; align-items: center;">
                                    <h4 class="card-title" style="text-align:center">Manage Categories</h4>
                                    <div class="media">
                                        <i class="icon-lg mdi mdi-view-dashboard-outline"
                                            style="height:45px; width:45px;"></i>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card" onclick="window.location.href='<?= base_url('sectors_table'); ?>';">
                                <div class="card-body"
                                    style="display: flex; flex-direction: column; align-items: center;">
                                    <h4 class="card-title" style="text-align:center">Manage Sectors</h4>
                                    <div class="media">
                                        <i class="icon-lg mdi mdi-database" style="height:45px; width:45px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($isHospital): ?>
                            <div class="col-md-3 grid-margin stretch-card">
                                <div class="card" onclick="window.location.href='<?= base_url('specilization_table'); ?>';">
                                    <div class="card-body"
                                        style="display: flex; flex-direction: column; align-items: center;">
                                        <h4 class="card-title" style="text-align:center">Doctor Specialization</h4>
                                        <div class="media">
                                            <i class="icon-lg mdi mdi-stethoscope" style="height:45px; width:45px;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 grid-margin stretch-card">
                                <div class="card" onclick="window.location.href='<?= base_url('appointments_table'); ?>';">
                                    <div class="card-body"
                                        style="display: flex; flex-direction: column; align-items: center;">
                                        <h4 class="card-title" style="text-align:center">Appointments</h4>
                                        <div class="media">
                                            <i class="icon-lg mdi mdi-calendar-clock" style="height:45px; width:45px;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 grid-margin stretch-card">
                                <div class="card" onclick="window.location.href='<?= base_url('GeneralOPD_table'); ?>';">
                                    <div class="card-body"
                                        style="display: flex; flex-direction: column; align-items: center;">
                                        <h4 class="card-title" style="text-align:center">General OPD</h4>
                                        <div class="media">
                                            <i class="icon-lg mdi mdi-calendar-plus" style="height:45px; width:45px;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 grid-margin stretch-card">
                                <div class="card" onclick="window.location.href='<?= base_url('labServices_form'); ?>';">
                                    <div class="card-body"
                                        style="display: flex; flex-direction: column; align-items: center;">
                                        <h4 class="card-title" style="text-align:center">Lab Tests</h4>
                                        <div class="media">
                                            <i class="icon-lg mdi mdi-hospital-building"
                                                style="height:45px; width:45px;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 grid-margin stretch-card">
                                <div class="card" onclick="window.location.href='<?= base_url('labtest_table'); ?>';">
                                    <div class="card-body"
                                        style="display: flex; flex-direction: column; align-items: center;">
                                        <h4 class="card-title" style="text-align:center">Manage Tests</h4>
                                        <div class="media">
                                            <i class="icon-lg mdi mdi-test-tube" style="height:45px; width:45px;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>
                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card" onclick="window.location.href='<?= base_url('Sales_table'); ?>';">
                                <div class="card-body"
                                    style="display: flex; flex-direction: column; align-items: center;">
                                    <h4 class="card-title" style="text-align:center">Sales Table</h4>
                                    <div class="media">
                                        <i class="icon-lg mdi mdi-cash-multiple" style="height:45px; width:45px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card" onclick="window.location.href='<?= base_url('expenses_table'); ?>';">
                                <div class="card-body"
                                    style="display: flex; flex-direction: column; align-items: center;">
                                    <h4 class="card-title" style="text-align:center">Manage Expenses</h4>
                                    <div class="media">
                                        <i class="icon-lg mdi mdi-test-tube" style="height:45px; width:45px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card"
                                onclick="window.location.href='<?= base_url('expenseCategory_table'); ?>';">

                                <div class="card-body"
                                    style="display: flex; flex-direction: column; align-items: center;">
                                    <h4 class="card-title" style="text-align:center">Expense Categories</h4>
                                    <div class="media">
                                        <i class="icon-lg mdi mdi-view-dashboard-outline"
                                            style="height:45px; width:45px;"></i>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:../../partials/_footer.html -->


                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="./public/assets/vendors_s/js/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="./public/assets/vendors_s/typeahead.js/typeahead.bundle.min.js"></script>
        <script src="./public/assets/vendors_s/select2/select2.min.js"></script>
        <script src="./public/assets/vendors_s/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="./public/assets/js_s/off-canvas.js"></script>
        <script src="./public/assets/js_s/hoverable-collapse.js"></script>
        <script src="./public/assets/js_s/template.js"></script>
        <script src="./public/assets/js_s/settings.js"></script>
        <script src="./public/assets/js_s/todolist.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="./public/assets/js_s/file-upload.js"></script>
        <script src="./public/assets/js_s/typeahead.js"></script>
        <script src="./public/assets/js_s/select2.js"></script>
        <!-- End custom js for this page-->
</body>

</html>