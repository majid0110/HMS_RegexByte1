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
                                    <h4 class="card-title">Expenses</h4>
                                    <form class="pt-3" method="POST" action="<?php echo base_url() . "save_expense"; ?>"
                                        enctype="multipart/form-data">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Date of Expense</label>
                                                    <div class="col-sm-9">
                                                        <input type="date" class="form-control" name="date_exp"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Category</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="category">
                                                            <?php foreach ($categories as $category): ?>
                                                                <option value="<?= $category['id'] ?>">
                                                                    <?= $category['title'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Amount</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="amount" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Project</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="project" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Title</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="title" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label"
                                                        name="cemail">Description</label>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" name="description"
                                                            ?></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Client</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="client" />
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Client Name</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="client">
                                                            <?php foreach ($client_names as $client): ?>
                                                                <option value="<?= $client['idClient']; ?>">
                                                                    <?= $client['clientUniqueId']; ?> -
                                                                    <?= $client['client']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Team Member</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="teamMember">
                                                            <?php foreach ($users as $user): ?>
                                                                <option value="<?= $user['ID'] ?>">
                                                                    <?= $user['fName'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">TAX</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="tax_1"
                                                            Value="0.0" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Secound TAX</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="tax_2"
                                                            Value="0.0" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <input type="checkbox" class="form-check-input" name="recurring"
                                                        style="    margin-left: 9rem; display=flex">
                                                    <span style="margin-left: 11rem;margin-top: -19px;">Recurring</span>
                                                    </input>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label"></label>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control-file" name="image" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <?php include 'include_common/footer.php'; ?>
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