<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
  <link rel="stylesheet" href="./public/assets/vendors_s/select2-bootstrap-theme/select2-bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


  <!-- --------------------------------------------------------- -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- --------------------------------------------------------- -->
  <style>
    .toast {
      position: fixed;
      top: 10rem;
      right: 20px;
      background-color: orange;
      color: darkblue;
      padding: 16px;
      /* border-radius: 4px; */
      radius: 30%;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      opacity: 0;
      transition: opacity 0.3s;
      /* transition: top 0.5s ease-in-out, opacity 0.5s ease-in-out; */
      z-index: 999;
    }

    .toast.show {
      opacity: 1;
    }

    #openAddClientModal:hover {
      background-color: #52CDFF;
    }

    .center-dropdown .select2-dropdown {
      text-align: left;
    }

    .select2-container .select2-selection--single {
      /* height: auto; */
      text-align: left;
      padding: 0;
    }

    .select2-selection--single {
      height: 33px;
    }

    .select2-selection .select2-selection--single .select2-container .select2-selection--single .select2-selection__rendered {
      text-align: left;
      padding: 2%;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: normal;
      /* padding: 0; */
    }

    .select2-container--default .select2-results>.select2-results__options {
      background: #E9ECEF;
    }

    .select2-search--dropdown {
      background: #E9ECEF;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
      background: #E9ECEF;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
      text-align: left;
    }

    .select2-selection .select2-selection--single {
      height: 2rem;
    }

    .select2-container .select2-selection--single {
      height: 2rem;
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
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <?php $successMessage = session()->getFlashdata('success');
                  $errorMessage = session()->getFlashdata('error'); ?>
                  <h4 class="card-title" style="margin-top: -7x;">BOOK APPOINTMENT</h4>
                  <form class="pt-3" id="appointmentForm" method="POST"
                    action="<?php echo base_url() . "saveAppointment"; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="clientName" id="clientNameInput">


                    <div class="row">
                      <!-- <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Patient Name</label>
                          <div class="col-sm-9">
                            <select class="form-control select2" name="clientId" id="clientId">
                              <?php foreach ($client_names as $client): ?>
                                <option value="<?= $client['idClient']; ?>">
                                  <?= $client['clientUniqueId']; ?> - <?= $client['client']; ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      </div> -->

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Patient Name</label>
                          <div class="col-sm-9">
                            <div class="input-group">
                              <select class="form-control select2" name="clientId" id="clientId">
                                <?php foreach ($client_names as $client): ?>
                                  <option value="<?= $client['idClient']; ?>">
                                    <?= $client['clientUniqueId']; ?> - <?= $client['client']; ?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                              <div class="input-group-append">
                                <button class="btn btn-primary text-white" type="button" data-toggle="modal"
                                  data-target="#expenseModal" id="openAddClientModal"
                                  style="padding: 0;line-height: 1;width: 58px;margin-left: -2px;height: 29px;display: flex;align-items: center; justify-content: center;font-size: x-large;">+</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>


                      <!-- <div class="col-md-6">
                        <button type="button" class="btn btn-outline-secondary btn-rounded btn-icon"
                          id="openAddClientModal">
                          <i class="ti-user"> Add</i>
                        </button>
                      </div> -->

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <script>
    $(document).ready(function () {
      $('.select2').select2({
        dropdownAutoWidth: true
      });

      fetchDoctors();

      $('#doctor_id').change(function () {
        updateAppointmentFee();
        updateDoctorNameInput();
      });

      $('#app_type_id').change(function () {
        updateAppointmentFee();
        updateAppointmentTypeNameInput();
      });

      $('#clientId').change(function () {
        updateClientNameInput();
      });

      $('#openAddClientModal').on('click', function (e) {
        $('#addClientModal').modal('show');
        e.preventDefault();
      });

      function updateAppointmentFee() {
        var doctorId = $('#doctor_id').val();
        var feeTypeId = $('#app_type_id').val();

        if (doctorId && feeTypeId) {
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
        } else {
          $('#appointmentFee').val('');
        }
      }

      function fetchDoctors() {
        $.ajax({
          type: 'POST',
          url: '<?= site_url('DoctorController/getDoctors') ?>',
          dataType: 'json',
          success: function (response) {
            populateDoctors(response.doctors);
            updateAppointmentFee();
          },
          error: function (error) {
            console.log(error);
          }
        });
      }

      function populateDoctors(doctors) {
        var doctorDropdown = $('#doctor_id');
        doctorDropdown.empty();

        doctorDropdown.append('<option value="">Select a doctor</option>');

        doctors.forEach(function (doctor) {
          doctorDropdown.append('<option value="' + doctor.DoctorID + '">' + doctor.FirstName + ' ' + doctor.LastName + '</option>');
        });

        doctorDropdown.trigger('change');
      }

      function updateDoctorNameInput() {
        var selectedOption = $('#doctor_id option:selected');
        var doctorName = selectedOption.val() ? selectedOption.text() : 'None';
        $('#doctorNameInput').val(doctorName);
      }

      function updateAppointmentTypeNameInput() {
        var selectedOption = $('#app_type_id option:selected');
        var appointmentTypeName = selectedOption.val() ? selectedOption.text() : 'None';
        $('#appointmentTypeNameInput').val(appointmentTypeName);
      }

      function updateClientNameInput() {
        var selectedOption = $('#clientId option:selected');
        var clientName = selectedOption.text();
        $('#clientNameInput').val(clientName);
      }

      updateDoctorNameInput();
      updateAppointmentTypeNameInput();
      updateClientNameInput();

      $('#appointmentForm').submit(function (e) {
        e.preventDefault();
        submitForm();
      });

      function submitForm() {
        var formData = new FormData($('#appointmentForm')[0]);

        $.ajax({
          type: 'POST',
          url: '<?= site_url('AppointmentController/saveOpdAppointment') ?>',
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          dataType: 'json',
          success: function (response) {
            if (response.status === 'success') {
              viewPdf(response.pdfContent);
              showToast('Appointment booked successfully', 'success');
            } else {
              showToast('Failed to book appointment', 'error');
            }
          },
          error: function (error) {
            console.log(error);
            showToast('An error occurred while booking the appointment', 'error');
          }
        });
      }

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

      function showToast(message, type) {
        const toastContainer = document.createElement('div');
        toastContainer.classList.add('toast', type);
        toastContainer.textContent = message;
        document.body.appendChild(toastContainer);

        toastContainer.classList.add('show');

        setTimeout(function () {
          toastContainer.classList.remove('show');
          setTimeout(function () {
            toastContainer.remove();
          }, 300);
        }, 5000);
      }
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