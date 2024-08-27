<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demo.bootstrapdash.com/star-admin2-free/template/pages/tables/basic-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2024 05:42:35 GMT -->

<head>
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

<body style="font-family: 'Manrope';">
  <div class="container-scroller">
    <!-- partial:./public/assets/partials/_navbar.html -->

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:./public/assets/partials/_settings-panel.html -->

      <!-- partial -->
      <!-- partial:./public/assets/partials/_sidebar.html -->
      <?php include 'include_common/sidebar.php'; ?>
      <!-- partial -->
      <div class="main-panel" style="padding: 20px; background: #F4F5F7">
        <div class="content-wrapper" style="background: #F4F5F7;">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="invoice-box"
              style="max-width: 950px; margin: auto; border-radius: 30px; background: snow; width: 85rem; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-size: 16px; line-height: 24px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #555;">
              <div class="card-body" style="display: flex; justify-content: space-between; align-items: center;">
                <div class="logo" style="flex: 1;">
                  <!-- Insert your profile image here -->
                  <?php
                  $session = session();
                  if ($session->has('businessProfileImage')) {
                    echo '<img class="img-xs rounded-circle larger-profile-img" style="width: 90px; height: 90px;" src="' . $session->get('businessProfileImage') . '" alt="Profile image">';
                  }
                  ?>
                  <!-- Style your image here -->
                  <style="width: 100%; max-width: 300px" />
                </div>

                <div class="company-details" style="flex: 2; text-align: right;">
                  <?php
                  $session = session();
                  if ($session->has('businessName') && $session->has('phoneNumber')) {
                    echo '<strong>' . $session->get('businessName') . '</strong><br>';
                    echo '<strong>' . $session->get('phoneNumber') . '</strong><br>';
                    echo '<strong>' . $session->get('business_address') . '</strong><br>';
                  }
                  ?>
                </div>
              </div>
              <a href="<?= base_url('LabController/downloadLabReportPDF/' . $testid); ?>"
                class="btn btn-primary text-white me-0"><i class="icon-File"></i>
                Download PDF</a>
              <hr>
              <div class="card-body"
                style="display: flex; justify-content: space-between; align-items: flex-start; font-family: 'Manrope';">

                <!-- Client Information on the left -->
                <div class="client-details" style="flex: 1; margin-right: 20px;">

                  <p style="font-size: 20px; font-weight: 900;"><strong><?= $testDetails[0]['clientName']; ?></strong>
                  </p>
                  <p><strong>Gender:</strong> <?= $testDetails[0]['clientGender']; ?></p>
                  <p><strong>Contact:</strong> <?= $testDetails[0]['clientContact']; ?></p>
                  <p><strong>Email:</strong> <?= $testDetails[0]['clientEmail']; ?></p>
                  <p><strong>Address:</strong> <?= $testDetails[0]['clientAddress']; ?></p>
                </div>

                <!-- Doctor Information on the right -->
                <?php if (!empty($testDetails[0]['doctorFirstName'])): ?>
                  <div class="doctor-details" style="flex: 1; margin-left: 20px; text-align: right;">

                    <p style="font-size: 20px; font-weight: 900;"><strong> Dr. <?= $testDetails[0]['doctorFirstName'] . ' ' . $testDetails[0]['doctorLastName']; ?></strong></p>
                    <p><strong>Specialization:</strong> <?= $testDetails[0]['specialization']; ?></p>
                    <p><strong>Contact:</strong> <?= $testDetails[0]['doctorContact']; ?></p>
                    <p><strong>Email:</strong> <?= $testDetails[0]['doctorEmail']; ?></p>
                  </div>
                <?php endif; ?>
              </div>
              <h4 class="card-title">Test Details Table</h4>
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Test Type</th>
                      <th>Fee</th>
                      <th>Created AT</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($testDetails as $detail): ?>
                      <tr>
                        <td><?= $detail['testTypeID']; ?></td>
                        <td><?= $detail['testTypeName']; ?></td>
                        <td><?= $detail['fee']; ?></td>
                        <td><?= $detail['createdAT']; ?></td>
                        <td>
                          <!-- Add Report Button -->
                          <button class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#reportModal-<?= $detail['testTypeID']; ?>">
                            Add Report
                          </button>
                        </td>
                      </tr>

                      <!-- Modal for the specific report -->
                      <div class="modal fade" id="reportModal-<?= $detail['testTypeID']; ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Add Report for <?= $detail['testTypeName']; ?></h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form action=<?= base_url('submitReport/' . $detail['testTypeID']); ?> method="POST">
                                <?php if (!empty($detail['labReportAttributes'])): ?>
                                  <?php foreach ($detail['labReportAttributes'] as $attribute): ?>

                                    <input type="hidden" name="testID" value="<?= $testid; ?>">
                                    <div class="mb-3">
                                      <label class="form-label">Attribute Name: <b><?= $attribute['title']; ?></label>
                                      <input type="text" class="form-control" name="result_<?= $attribute['id']; ?>"
                                        placeholder="Enter result for <?= $attribute['title']; ?>">
                                    </div>
                                  <?php endforeach; ?>
                                <?php else: ?>
                                  <p>No attributes found for this test.</p>
                                <?php endif; ?>
                                <button type="submit" class="btn btn-success">Submit</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </tbody>

                </table>
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
</body>


<!-- Mirrored from demo.bootstrapdash.com/star-admin2-free/template/pages/tables/basic-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2024 05:42:35 GMT -->

</html>