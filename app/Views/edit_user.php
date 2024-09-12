<?php $session = session(); ?>
<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">


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
                  <h4 class="card-title">USER DETAILS</h4>
                  <form class="form-sample" method="post"
                    action="<?php echo base_url() . 'update_user/' . $userData['ID']; ?>" enctype="multipart/form-data">
                    <p class="card-description">
                      User Info
                    </p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">First Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="first_name"
                              value="<?= $userData['fName']; ?>" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Last Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="last_name"
                              value="<?= $userData['lName']; ?>" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Email</label>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" name="user_email"
                              value="<?= $userData['email']; ?>" readonly />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Phone</label>
                          <div class="col-sm-9">
                            <input type="tel" class="form-control" name="user_phone"
                              value="<?= $userData['phone']; ?>" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="user_address"
                              value="<?= $userData['address']; ?>" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">CNIC Number</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="cnic_number"
                              value="<?= $userData['CNIC']; ?>" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Password</label>
                          <div class="col-sm-9">
                            <input type="password" class="form-control" name="user_password" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Confirm Password</label>
                          <div class="col-sm-9">
                            <input type="password" class="form-control" name="confirm_password" />
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Profile Image</label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control" name="profile_image" />
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Role</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="roleID">
                              <?php foreach ($roleName as $role): ?>
                                <option value="<?= $role['ID']; ?>" <?php echo ($role['ID'] == $userData['roleID']) ? 'selected' : ''; ?>>
                                  <?= $role['role_name']; ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

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