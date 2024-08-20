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
  <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">

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
                        <h5 class="modal-title" id="testFormModalLabel">Lab Test Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="testFormModalBody">
                        <!-- Lab Test Form -->
                        <a href="#" id="labTestForm"
                          style="position: absolute; top: 10px; right: 10px; font-size: 20px; color: #333;">
                          <i class="mdi mdi-close"></i>
                        </a>
                        <form class="pt-3" method="POST" action="<?php echo base_url() . "saveLabService"; ?>"
                          enctype="multipart/form-data">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Test Name</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="ls_name" />
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="ls_description" />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Fee</label>
                                <div class="col-sm-9">
                                  <input type="number" class="form-control" name="ls_fee" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- New section for lab report attributes -->
                          <div id="attributesContainer">
                            <div class="attribute-row">
                              <div class="row">
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="attribute_title[]" />
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Reference Value</label>
                                    <input type="text" class="form-control" name="attribute_reference_value[]" />
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <label>Unit</label>
                                    <input type="text" class="form-control" name="attribute_unit[]" />
                                  </div>
                                </div>
                                <div class="col-md-1">
                                  <button type="button" class="btn btn-danger remove-attribute">Remove</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <button type="button" id="addMoreAttribute" class="btn btn-secondary">Add More</button>

                          <div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </form>
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
  <script src="./public/assets/vendors_s/select2/select2.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#openSpecializationFormDialog').click(function () {
        // Open dialog-box with test_form page
        $('#testFormModal').modal('show');
      });

      $('#closeSpecializationForm').click(function (e) {
        e.preventDefault();
      });

      $('.select2').select2();
      $('#addMoreAttribute').click(function () {
        var newRow = $('.attribute-row:first').clone();
        newRow.find('input').val('');
        $('#attributesContainer').append(newRow);
      });
      $('#attributesContainer').on('click', '.remove-attribute', function () {
        if ($('.attribute-row').length > 1) {
          $(this).closest('.attribute-row').remove();
        }
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