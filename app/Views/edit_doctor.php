<?php $session = session(); ?>
<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<!-- <head>
    <style>
        body {
            background-color: #f8f9fa;
            color: #495057;
            font-family: 'Arial', sans-serif;
        }

        .card {
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-sample {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #007bff;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .btn-auth {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-auth:hover {
            background-color: #0056b3;
        }
    </style>
</head> -->

<head>
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/public/assets/vendors_s/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="/public/assets/js_s/select.dataTables.min.css">
    <link rel="stylesheet" href="../public/assets/vendors_s/feather/feather.css">
    <link rel="stylesheet" href="../public/assets/vendors_s/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../public/assets/vendors_s/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../public/assets/vendors_s/typicons/typicons.css">
    <link rel="stylesheet" href="../public/assets/vendors_s/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../public/assets/vendors_s/css/vendor.bundle.base.css">
    <!-- endinject -->

    <!-- inject:css -->
    <link rel="stylesheet" href="../public/assets/css_s/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../public/assets/images_s/regexbyte.png" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="ti-settings"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close ti-close"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border me-3"></div>Light
                    </div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border me-3"></div>Dark
                    </div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>

            <?php include 'include_common/sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="pt-3" method="POST" action="<?= base_url('updateDoctor'); ?>"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="DoctorID"
                                            value="<?= $doctorDetails['DoctorID']; ?>" />

                                        <!-- Personal Info -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">First Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="fName"
                                                            value="<?= $doctorDetails['FirstName']; ?>" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Last Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="lName"
                                                            value="<?= $doctorDetails['LastName']; ?>" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contact Info -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Gender</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="gender" required>
                                                            <option value="Male" <?= ($doctorDetails['Gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                                            <option value="Female"
                                                                <?= ($doctorDetails['Gender'] == 'Female') ? 'selected' : ''; ?>>Female
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Date of Birth</label>
                                                    <div class="col-sm-9">
                                                        <input type="date" class="form-control" name="dob"
                                                            value="<?= $doctorDetails['DateOfBirth']; ?>" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Address and Contact -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Phone Number</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="phone"
                                                            value="<?= $doctorDetails['ContactNumber']; ?>" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Email</label>
                                                    <div class="col-sm-9">
                                                        <input type="email" class="form-control" name="email"
                                                            value="<?= $doctorDetails['Email']; ?>" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Professional Info -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Specialization</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="specialization" required>
                                                            <?php foreach ($specializations as $specialization): ?>
                                                                <option value="<?= $specialization['s_id']; ?>"
                                                                    <?= ($specialization['s_id'] == $doctorDetails['Specialization']) ? 'selected' : ''; ?>>
                                                                    <?= $specialization['specialization_N']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Medical License
                                                        Number</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="MLN"
                                                            value="<?= $doctorDetails['MedicalLicenseNumber']; ?>"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Additional Professional Details -->
                                        <!-- ... -->

                                        <!-- Address and Affiliation -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Clinic Address</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="address"
                                                            value="<?= $doctorDetails['ClinicAddress']; ?>" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Hospital Affiliation</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="hos_af"
                                                            value="<?= $doctorDetails['HospitalAffiliation']; ?>"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Education and Experience -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Education</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="education"
                                                            value="<?= $doctorDetails['Education']; ?>" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Experience</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="experience"
                                                            value="<?= $doctorDetails['ExperienceYears']; ?>"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Certification and Image Upload -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Certification</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="certificate"
                                                            value="<?= $doctorDetails['Certification']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Profile Image</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control" name="profile"
                                                            accept="image/*" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit button -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include 'include_common/footer.php'; ?>

                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../public/assets/vendors_s/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../public/assets/vendors_s/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="../public/assets/vendors_s/select2/select2.min.js"></script>
    <script src="../public/assets/vendors_s/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../public/assets/js_s/off-canvas.js"></script>
    <script src="../public/assets/js_s/hoverable-collapse.js"></script>
    <script src="../public/assets/js_s/template.js"></script>
    <script src="../public/assets/js_s/settings.js"></script>
    <script src="../public/assets/js_s/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="../public/assets/js_s/file-upload.js"></script>
    <script src="../public/assets/js_s/typeahead.js"></script>
    <script src="../public/assets/js_s/select2.js"></script>
    <!-- End custom js for this page-->

</body>

</html>