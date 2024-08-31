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
      <!-- partial:../../partials/_settings-panel.html -->
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      <?php include 'include_common/sidebar.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">DOCTORS FEE</h4>
                  <!-- Form for adding/editing doctor fee -->
                  <form class="pt-3" method="POST"
                    action="<?= isset($editDoctorFeeId) ? base_url('updateDoctorFee/' . $editDoctorFeeId) : base_url('Savedoctorsfee'); ?>"
                    enctype="multipart/form-data">
                    <p class="card-description">Personal info</p>
                    <div class="row">
                      <!-- Fee (Amount) input -->
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Fee (Amount)</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="fee" />
                          </div>
                        </div>
                      </div>
                      <!-- Doctor Name dropdown -->
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label" name="dname">Doctor Name</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="doctor_id">
                              <?php foreach ($doctor_names as $doctor): ?>
                                <option value="<?= $doctor['DoctorID']; ?>">
                                  <?= $doctor['FirstName'] . ' ' . $doctor['LastName']; ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <!-- Fee Type dropdown -->
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label" name="ftype">Fee Type</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="fee_type_id">
                              <?php foreach ($fee_types as $fee_type): ?>
                                <option value="<?= $fee_type->f_id; ?>"><?= $fee_type->FeeType; ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Submit button -->
                    <div class="row">
                      <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                          <?= isset($editDoctorFeeId) ? 'Update' : 'Submit'; ?>
                        </button>
                      </div>
                    </div>
                  </form>

                  <!-- Display Doctor Fee List -->
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Doctor</th>
                            <th>Fee Type</th>
                            <th>Fee</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($doctorFees as $doctorFee): ?>
                            <tr>
                              <td><?= $doctorFee['FirstName'] . ' ' . $doctorFee['LastName']; ?></td>
                              <td><?= $doctorFee['FeeType']; ?></td>
                              <td><?= $doctorFee['Fee']; ?></td>
                              <td>
                                <!-- Edit Button -->
                                <a href="<?= base_url('edit_fee/' . $doctorFee['df_id']); ?>"
                                  class="btn btn-sm btn-info">Edit</a>
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
          </div>
        </div>

        <!-- Include footer -->
        <?php include 'include_common/footer.php'; ?>
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