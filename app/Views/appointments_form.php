<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
  <link rel="stylesheet" href="./public/assets/vendors_s/select2-bootstrap-theme/select2-bootstrap.min.css">

  <!-- --------------------------------------------------------- -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- --------------------------------------------------------- -->
  <style>
    #openAddClientModal:hover {
      background-color: #52CDFF;
    }
  </style>
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
      <div id="right-sidebar" class="settings-panel">
        <i class="settings-close ti-close"></i>
        <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab"
              aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab"
              aria-controls="chats-section">CHATS</a>
          </li>
        </ul>
        <div class="tab-content" id="setting-content">
          <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel"
            aria-labelledby="todo-section">
            <div class="add-items d-flex px-3 mb-0">
              <form class="form w-100">
                <div class="form-group d-flex">
                  <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                  <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                </div>
              </form>
            </div>
            <div class="list-wrapper px-3">
              <ul class="d-flex flex-column-reverse todo-list">
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Team review meeting at 3.00 PM
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Prepare for presentation
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Resolve all the low priority tickets due today
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li class="completed">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Schedule meeting for next week
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li class="completed">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Project review
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
              </ul>
            </div>
            <h4 class="px-3 text-muted mt-5 fw-light mb-0">Events</h4>
            <div class="events pt-4 px-3">
              <div class="wrapper d-flex mb-2">
                <i class="ti-control-record text-primary me-2"></i>
                <span>Feb 11 2018</span>
              </div>
              <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
              <p class="text-gray mb-0">The total number of sessions</p>
            </div>
            <div class="events pt-4 px-3">
              <div class="wrapper d-flex mb-2">
                <i class="ti-control-record text-primary me-2"></i>
                <span>Feb 7 2018</span>
              </div>
              <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
              <p class="text-gray mb-0 ">Call Sarah Graves</p>
            </div>
          </div>
          <!-- To do section tab ends -->
          <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
            <div class="d-flex align-items-center justify-content-between border-bottom">
              <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
              <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 fw-normal">See All</small>
            </div>
            <ul class="chat-list">
              <li class="list active">
                <div class="profile"><img src="./public/assets/images_s/faces/face1.jpg" alt="image"><span
                    class="online"></span></div>
                <div class="info">
                  <p>Thomas Douglas</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">19 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="./public/assets/images_s/faces/face2.jpg" alt="image"><span
                    class="offline"></span></div>
                <div class="info">
                  <div class="wrapper d-flex">
                    <p>Catherine</p>
                  </div>
                  <p>Away</p>
                </div>
                <div class="badge badge-success badge-pill my-auto mx-2">4</div>
                <small class="text-muted my-auto">23 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="./public/assets/images_s/faces/face3.jpg" alt="image"><span
                    class="online"></span></div>
                <div class="info">
                  <p>Daniel Russell</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">14 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="./public/assets/images_s/faces/face4.jpg" alt="image"><span
                    class="offline"></span></div>
                <div class="info">
                  <p>James Richardson</p>
                  <p>Away</p>
                </div>
                <small class="text-muted my-auto">2 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="./public/assets/images_s/faces/face5.jpg" alt="image"><span
                    class="online"></span></div>
                <div class="info">
                  <p>Madeline Kennedy</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">5 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="./public/assets/images_s/faces/face6.jpg" alt="image"><span
                    class="online"></span></div>
                <div class="info">
                  <p>Sarah Graves</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">47 min</small>
              </li>
            </ul>
          </div>
          <!-- chat tab ends -->
        </div>
      </div>
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
                  <h4 class="card-title" style="margin-top: -7x;">BOOK APPOINTMENT</h4>
                  <form class="pt-3" id="appointmentForm" method="POST"
                    action="<?php echo base_url() . "saveAppointment"; ?>" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Patient Name</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="clientId" id="clientId">
                              <?php foreach ($client_names as $client): ?>
                                <option value="<?= $client['idClient']; ?>">
                                  <?= $client['client']; ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <input type="hidden" name="clientName" id="clientNameInput">


                      <div class="col-md-6">
                        <!-- <a href="#" class="btn btn-rounded btn-fw" id="openAddClientModal">
                          <i class="mdi mdi-account-plus"> Add Client</i>
                        </a> -->
                        <button type="button" class="btn btn-outline-secondary btn-rounded btn-icon"
                          id="openAddClientModal">
                          <i class="ti-user"> Add</i>
                        </button>
                      </div>

                    </div>
                    <div class="row" style="margin-top: -16px;">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Doctor Name</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="doctor_id" id="doctor_id">
                            </select>
                          </div>
                        </div>
                      </div>

                      <input type="hidden" name="doctorName" id="doctorNameInput">

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label" name="ftype">Appointment Type</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="app_type_id" id="app_type_id">
                              <?php foreach ($fee_types as $fee_type): ?>
                                <option value="<?= $fee_type->f_id; ?>"
                                  data-appointment-type="<?= $fee_type->FeeType; ?>">
                                  <?= $fee_type->FeeType; ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <input type="hidden" name="appointmentTypeName" id="appointmentTypeNameInput">
                    </div>
                    <div class="row" style="margin-top: -26px;">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Appointment Fee</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control" name="appointmentFee" id="appointmentFee"
                              required />
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Hospital Fee</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control" name="hospitalFee" id="hospitalFee" required <?php echo isset($_SESSION['hospitalcharges']) ? 'value="' . $_SESSION['hospitalcharges'] . '"' : ''; ?> />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="margin-top: -26px;">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Appointment Date</label>
                          <div class="col-sm-9">
                            <input type="date" class="form-control" name="appointmentDate"
                              value="<?= date('Y-m-d'); ?>" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Appointment Time</label>
                          <div class="col-sm-9">
                            <input type="time" class="form-control" name="appointmentTime"
                              value="<?= date('H:i'); ?>" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="margin-top: -16px;">
                      <div class="col-md-6">
                        <!-- <button type="submit" class="btn btn-primary">BOOK</button> -->
                        <button type="submit" class="btn btn-outline-info btn-icon-text">BOOK
                        </button>
                      </div>
                    </div>
                  </form>
                  <div class="modal fade" id="addClientModal" tabindex="-1" role="dialog"
                    aria-labelledby="addClientModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <!-- Include your client form here -->
                        <div class="modal-body">
                          <?php include 'tst_client.php'; ?>
                        </div>
                      </div>
                    </div>
                  </div>

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
      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {

      var appointmentTypeSelect = document.getElementById('app_type_id');
      var appointmentTypeNameInput = document.getElementById('appointmentTypeNameInput');

      appointmentTypeSelect.addEventListener('change', function () {
        var selectedOption = appointmentTypeSelect.options[appointmentTypeSelect.selectedIndex];
        var appointmentTypeName = selectedOption.getAttribute('data-appointment-type');

        appointmentTypeNameInput.value = appointmentTypeName;
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {

      var clientIdSelect = document.getElementById('clientId');
      var clientNameInput = document.getElementById('clientNameInput');


      clientIdSelect.addEventListener('change', function () {
        var selectedOption = clientIdSelect.options[clientIdSelect.selectedIndex];
        var clientName = selectedOption.text;

        clientNameInput.value = clientName;
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var doctorIdSelect = document.getElementById('doctor_id');
      var doctorNameInput = document.getElementById('doctorNameInput');

      doctorIdSelect.addEventListener('change', function () {
        var selectedOption = doctorIdSelect.options[doctorIdSelect.selectedIndex];
        var doctorName = selectedOption ? selectedOption.text : '';

        doctorNameInput.value = doctorName;
      });
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      $('#openAddClientModal').on('click', function () {
        $('#addClientModal').modal('show');
        e.preventDefault();
      });
    });
  </script>

  <script>
    $(document).ready(function () {

      fetchDoctors();

      $('#doctor_id').change(function () {
        updateAppointmentFee();
      });

      $('#app_type_id').change(function () {
        updateAppointmentFee();
      });

      function updateAppointmentFee() {
        var doctorId = $('#doctor_id').val();
        var feeTypeId = $('#app_type_id').val();

        $.ajax({
          type: 'POST',
          url: '<?= site_url('DoctorController/fetchDoctorFee') ?>',
          data: {
            doctorID: doctorId,
            feeTypeID: feeTypeId
          },
          dataType: 'json',
          success: function (response) {

            $('#appointmentFee').val(response.fee);
          },
          error: function (error) {
            console.log(error);
          }
        });
      }

      function fetchDoctors() {
        $.ajax({
          type: 'POST',
          url: '<?= site_url('DoctorController/getDoctors') ?>',
          dataType: 'json',
          success: function (response) {
            populateDoctors(response.doctors);
          },
          error: function (error) {
            console.log(error);
          }
        });
      }
      function populateDoctors(doctors) {
        var doctorDropdown = $('#doctor_id');
        doctorDropdown.empty();

        doctors.forEach(function (doctor) {
          doctorDropdown.append('<option value="' + doctor.DoctorID + '">' + doctor.FirstName + ' ' + doctor.LastName + '</option>');
        });
      } z
    });
  </script>
  <script>
    $(document).ready(function () {
      $('.select2').select2();
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      function viewPdf(pdfContent) {
        const byteCharacters = atob(pdfContent);
        const byteNumbers = new Array(byteCharacters.length);

        for (let i = 0; i < byteCharacters.length; i++) {
          byteNumbers[i] = byteCharacters.charCodeAt(i);
        }

        const byteArray = new Uint8Array(byteNumbers);
        const blob = new Blob([byteArray], { type: 'application/pdf' });

        const newWindow = window.open();
        newWindow.document.write('<iframe width="100%" height="100%" src="' + URL.createObjectURL(blob) + '"></iframe>');
      }

      function submitForm() {
        var formData = new FormData($('#appointmentForm')[0]);

        $.ajax({
          type: 'POST',
          url: '<?= site_url('AppointmentController/saveAppointment') ?>',
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          dataType: 'json',
          success: function (response) {
            if (response.status === 'success') {
              viewPdf(response.pdfContent);
            } else {

              console.error('Failed to generate PDF.');
            }
          },
          error: function (error) {
            console.log(error);
          }
        });
      }
      $('#appointmentForm').submit(function (e) {
        e.preventDefault();
        submitForm();
      });

    });
  </script>
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