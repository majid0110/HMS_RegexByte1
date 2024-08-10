<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
    <link rel="stylesheet" href="./public/assets/vendors_s/select2-bootstrap-theme/select2-bootstrap.min.css">

</head>

<body>
    <div class="container-scroller">
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            <!-- partial -->
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
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Configuration</h4>
                                    <form method="POST" action="<?= base_url('updateConfig'); ?>">
                                        <input type="hidden" name="businessID"
                                            value="<?= session()->get('businessID'); ?>" />
                                        <div>
                                            <input type="checkbox" id="isExpiry" name="isExpiry" value="1"
                                                <?= $configData['isExpiry'] == 1 ? 'checked' : ''; ?>>
                                            <label for="isExpiry" style="margin-left: 1rem;">Enable Expiry</label>
                                        </div>

                                        <div>
                                            <input type="checkbox" id="istable" name="isTable" value="1"
                                                <?= $configData['isTable'] == 1 ? 'checked' : ''; ?>>
                                            <label for="isExpiry" style="margin-left: 1rem;">IsTable</label>
                                        </div>

                                        <div>
                                            <input type="checkbox" id="istable" name="enableService" value="1"
                                                <?= $configData['enableService'] == 1 ? 'checked' : ''; ?>>
                                            <label for="isExpiry" style="margin-left: 1rem;">Enable Services</label>
                                        </div>

                                        <div style="margin-top: 2rem;">
                                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php if ($configData['isTable'] == 1): ?>
                            <div class="col-12 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Create Tables</h4>
                                        <form method="POST" action="<?= base_url('createTables'); ?>">
                                            <input type="hidden" name="businessID"
                                                value="<?= session()->get('businessID'); ?>" />

                                            <div style="margin-top: 1rem;">
                                                <label>Select Type:</label><br>
                                                <input type="radio" id="table" name="type" value="Table" checked>
                                                <label for="table">Table</label><br>
                                                <input type="radio" id="room" name="type" value="Room">
                                                <label for="room">Room</label>
                                            </div>

                                            <div id="tableForm" style="margin-top: 1rem;">
                                                <label for="noOfTables">Enter No of Tables/Rooms:</label>
                                                <input type="number" id="noOfTables" name="noOfTables" class="form-control">
                                            </div>

                                            <div style="margin-top: 2rem;">
                                                <button type="submit" class="btn btn-primary btn-sm">Create</button>
                                            </div>
                                        </form>
                                        <div class="table-responsive" style="hight: 10rem; ">
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Size</th>
                                                    <th>Notes</th>
                                                    <th>Status</th>

                                                </tr>

                                                <?php foreach ($Tables as $Table): ?>
                                                    <tr>
                                                        <td>
                                                            <?= $Table['name']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $Table['size']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $Table['notes']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $Table['Status']; ?>
                                                        </td>

                                                    <?php endforeach; ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>


                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:../../partials/_footer.html -->
                <?php include 'include_common/footer.php'; ?>
                <!-- partial -->
            </div>

            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="./public/assets/vendors_s/js/vendor.bundle.base.js"></script>

    <script>
        function toggleTableForm(isChecked) {
            document.getElementById('tableForm').style.display = isChecked ? 'block' : 'none';
        }
    </script>
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