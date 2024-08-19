<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demo.bootstrapdash.com/star-admin2-free/template/pages/tables/basic-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2024 05:42:35 GMT -->

<head>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Star Admin2 </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="./public/assets/vendors/feather/feather.css">
  <link rel="stylesheet" href="./public/assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="./public/assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="./public/assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="./public/assets/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="./public/assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="./public/assets/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="./public/assets/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:./public/assets/partials/_navbar.html -->

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:./public/assets/partials/_settings-panel.html -->

      <!-- partial -->
      <!-- partial:./public/assets/partials/_sidebar.html -->
      <?php include 'include_common/sidebar.php'; ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">

                <h4 class="card-title">Lab Tests</h4>
                <button type="button" class="btn btn-primary" id="openSpecializationFormDialog">Add</button>
                <hr>

                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Test Name</th>
                      <th>Description</th>
                      <th>Fee</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($Tests as $Test): ?>
                      <tr>
                        <td>
                          <?= $Test['title']; ?>
                        </td>

                        <td>
                          <?= $Test['description']; ?>
                        </td>
                        <td>
                          <?= $Test['test_fee']; ?>
                        </td>
                        <td>
                          <!-- Edit Button -->
                          <a href="<?= base_url('edit_test/' . $Test['testTypeId']); ?>"
                            class="btn btn-sm btn-info">Edit</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>

                <div class="modal fade" id="testFormModal" tabindex="-1" role="dialog"
                  aria-labelledby="testFormModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="testFormModalLabel">Lab Test
                          Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="testFormModalBody">
                        <?php include 'lab_test_form.php'; ?>
                      </div>
                    </div>
                  </div>
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
      $('#openSpecializationFormDialog').click(function () {
        // Open dialog-box with test_form page
        $('#testFormModal').modal('show');
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