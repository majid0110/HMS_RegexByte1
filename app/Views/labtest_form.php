<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css" />
  <link rel="stylesheet" href="./public/assets/vendors_s/select2-bootstrap-theme/select2-bootstrap.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


  <style>
    .badge-pill:hover {
      background-color: #52CDFF;
      color: #fff;
      cursor: pointer;
      font-weight: bolder;
      border: #52CDFF;
    }

    #clientDetails {
      font-weight: 750;
      font-family: monospace;
    }

    .twitter-typeahead {
      max-width: 100%;
      width: 100%;

    }

    #serviceTableBodyContainer {
      max-height: 300px;
      overflow-y: auto;
    }

    #summaryTableContainer {
      max-height: 300px;
      overflow-y: auto;
    }

    .active {
      background: #52CDFF;
      color: #fff;

    }

    .table thead th,
    .table tbody td {
      padding: 8px;
    }

    .table thead,
    .table tbody {
      display: table;
      width: 100%;
      table-layout: fixed;
    }

    .table tbody tr {
      height: 0px;
    }

    .table thead tr {
      height: 0px;

    }

    .table-container {
      max-height: 220px;
      overflow-y: auto;
    }

    .form-groups {
      margin-top: 2%;
      font-size: 0.913rem;
    }

    @media screen and (max-width: 768px) {
      .form-group {
        margin-top: -2%;
      }
    }

    @media screen and (min-width: 1200px) {
      .form-group {}
    }

    .center-dropdown .select2-dropdown {
      text-align: left;
    }



    .select2-container .select2-selection--single {
      height: 2rem;
      text-align: left;
      padding: 0;
    }

    .select2-selection--single {
      height: 33px;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
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
  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
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
          <div class="row" style="margin-top: -2%;">
            <div class="col-md-6">
              <div class="card h-100">
                <div class="card-body">
                  <p class="card-description"
                    style="margin-top: -19px; margin-bottom: -10px; font-weight: bold; color: black;">
                    Add Test
                  </p>
                  <form class="pt-3" method="POST" action="<?php echo base_url() . "submitTests"; ?>"
                    enctype="multipart/form-data">
                    <div class="form-group row" style="margin-bottom: 6px;">
                      <div class="col">
                        <label for="clientName">Client Name</label>
                        <div class="input-group">
                          <select class="form-control select2" name="clientName" id="clientName">
                            <?php foreach ($client_names as $client): ?>
                              <option value="<?= $client['idClient']; ?>">
                                <?= $client['clientUniqueId']; ?> - <?= $client['client']; ?>   <?= $client['contact']; ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col">
                        <label for="appointment">Appointment</label>
                        <div class="input-group">
                          <select style="margin-top: 0.2rem;" class="form-control" id="appointment" name="appointment">
                            <!-- Appointments will be loaded dynamically here -->
                          </select>
                          <div id="appointmentStatus"></div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row" style="margin-bottom: 6px;">
                      <div class="col">
                        <label for="clientName">Doctor Name</label>
                        <div class="input-group">
                          <select class="form-control select2" name="doctorName" id="doctorName">
                            <?php foreach ($doctor_names as $doctor): ?>
                              <option value="<?= $doctor['DoctorID']; ?>">
                                <?= $doctor['FirstName']; ?>   <?= $doctor['LastName']; ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col">
                        <label for="appointment">Registration Date</label>
                        <div class="input-group">
                          <input class="typeahead form-control" type="date" name="registration" id="registrationDate">
                        </div>
                      </div>
                    </div>

                    <div class="form-group row" style="margin-bottom: 6px;">
                      <div class="col">
                        <label for="appointment">Collected At</label>
                        <div class="input-group">
                          <input class="typeahead form-control" type="date" name="collected" id="collectedDate">
                        </div>
                      </div>
                      <div class="col">
                        <label for="search">Search:</label>
                        <input type="text" style="margin-top: 0.2rem;" class="form-control" id="testTypeSearch"
                          placeholder="Search..">
                      </div>
                    </div>


                    <!-- <div class="form-groups">
                      <label for="testType">Search Test Type</label>
                      <input type="text" style="margin-top: 0.2rem;" class="form-control" id="testTypeSearch"
                        placeholder="Search..">
                    </div> -->

                    <div class="form-groups">
                      <div class="table-responsive">
                        <div class="table-container">
                          <table class="table" id="testTypeList">
                            <thead>
                              <tr>
                                <th>Test Type</th>
                                <th>Test Fee</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($test_types as $testType): ?>
                                <tr data-test-type-id="<?= $testType['testTypeId']; ?>">
                                  <td class="title">
                                    <?= $testType['title']; ?>
                                  </td>
                                  <td class="fee" contenteditable="true">
                                    <?= $testType['test_fee']; ?>
                                  </td>
                                  <td>
                                    <span class="badge badge-primary badge-pill hover-effect"
                                      onclick="addTest()">ADD</span>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>

                          </table>
                        </div>
                      </div>
                    </div>

                  </form>

                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100">
                <div class="card-body">
                  <p class="card-description"
                    style="margin-top: -19px; margin-bottom: -1px; font-weight: bold; color: black;">
                    SUMMARY
                  </p>
                  <p class="card-description" id="clientDetails"></p>
                  <hr style="margin-top: -3%;margin-bottom: 2%;">
                  <div id="summaryTableContainer">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Test Type</th>
                          <th>Test Fee</th>
                          <th>Discount (%)</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody id="testTableBody">
                      </tbody>
                    </table>
                  </div>
                </div>
                <div style="margin-left: 65%; font-weight: 900; font-size: 150px">
                  <p>Total Fee: <span id="totalFee">0</span></p>
                  <p>Total Discount: <span id="totalDiscount">0</span></p>
                  <p>Discounted Total: <span id="discountedTotal">0</span></p>
                </div>
                <div style="height: 58px; margin-left: 1.4em; font-weight: 900; font-size: 150px">
                  <!-- <button class="btn btn-primary btn-fw" id="insertBtn">Save</button> -->
                  <button type="button" class="btn btn-outline-info btn-icon-text" id="insertBtn">Print
                    <i class="ti-printer btn-icon-append"></i>
                  </button>
                </div>
              </div>
            </div>

          </div>

          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script src="../../vendors/js/vendor.bundle.base.js"></script>
          <script>
            const now = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Karachi" }));
            const formattedDate = now.toISOString().split('T')[0];
            document.getElementById('collectedDate').value = formattedDate;
          </script>
          <script>
            $(document).ready(function () {

              $('#clientName').select2({
                // placeholder: 'Select a client',
                // allowClear: true
              });

              var initialClientId = $('#clientName').val();
              loadAppointments(initialClientId);

              $('#clientName').change(function () {
                var clientId = $(this).val();
                updateClientDetails(clientId);
                loadAppointments(clientId);
              });
              var initialClientId = $('#clientName').val();
              loadAppointments(initialClientId);

              $('#clientName').change(function () {
                var clientId = $(this).val();
                updateClientDetails(clientId);
                loadAppointments(clientId);
              });

              function updateClientDetails(clientId) {
                var clientName = $('#clientName option:selected').text();
                var appointment = $('#appointment option:selected').text();
                $('#clientDetails').html('Client: ' + clientName + '<br>Appointment: ' + appointment);
              }

              // function loadAppointments(clientId) {
              //   $.ajax({
              //     method: 'POST',
              //     url: '<?= site_url('LabController/getAppointmentsForClient') ?>',
              //     dataType: "json",
              //     data: {
              //       clientId: clientId,
              //       _cache: new Date().getTime()
              //     },
              //     async: false,
              //     success: function (response) {
              //       console.log('Appointments Response:', response);

              //       var appointmentDropdown = $('#appointment');
              //       appointmentDropdown.empty();

              //       if (response.success && response.appointments.length > 0) {
              //         $.each(response.appointments, function (index, appointment) {
              //           appointmentDropdown.append('<option value="' + appointment.appointmentID + '">' + appointment.appointmentID + '</option>');
              //         });

              //         updateClientDetails(clientId);
              //       } else {
              //         appointmentDropdown.append('<option value="">No appointments available</option>');
              //         updateClientDetails(clientId);
              //       }
              //     },
              //     error: function (error) {
              //       console.error('Error loading appointments:', error);
              //     }
              //   });
              // }

              function loadAppointments(clientId) {
                $.ajax({
                  method: 'POST',
                  url: '<?= site_url('LabController/getAppointmentsForClient') ?>',
                  dataType: "json",
                  data: {
                    clientId: clientId,
                    _cache: new Date().getTime()
                  },
                  async: false,
                  success: function (response) {
                    console.log('Appointments Response:', response);

                    var appointmentDropdown = $('#appointment');
                    var doctorDropdown = $('#doctorName');
                    appointmentDropdown.empty();

                    if (response.success && response.appointments.length > 0) {
                      $.each(response.appointments, function (index, appointment) {
                        appointmentDropdown.append('<option value="' + appointment.appointmentID + '">' + appointment.appointmentID + '</option>');


                        if (index === 0) {
                          doctorDropdown.val(appointment.doctorID).trigger('change');
                        }
                      });

                      updateClientDetails(clientId);
                    } else {
                      appointmentDropdown.append('<option value="">No appointments available</option>');
                      updateClientDetails(clientId);
                    }
                  },
                  error: function (error) {
                    console.error('Error loading appointments:', error);
                  }
                });
              }



              // function setDoctor(doctorId) {
              //   $('#doctorName').val(doctorId).trigger('change');
              // }

              // $('#appointment').change(function () {
              //   var selectedDoctorId = $(this).find(':selected').data('doctor-id');
              //   if (selectedDoctorId) {
              //     setDoctor(selectedDoctorId);
              //   }
              // });

              $('#testTypeSearch').on('input', function () {
                var searchText = $(this).val().toLowerCase();
                $('#testTypeList tbody tr').each(function () {
                  var testType = $(this).find('.title').text().toLowerCase();
                  if (testType.includes(searchText)) {
                    $(this).show();
                  } else {
                    $(this).hide();
                  }
                });
              });

              function addTestRow(testType, testTypeId, testFee) {
                var newRow = '<tr><td data-test-type-id="' + testTypeId + '">' + testType + '</td>' +
                  '<td contenteditable="true" class="editable-fee">' + testFee + '</td>' +
                  '<td contenteditable="true" class="editable-discount">0</td>' +
                  '<td><button class="btn btn-danger btn-sm remove-btn" onclick="removeTestRow(this)">Remove</button></td></tr>';
                $('#testTableBody').append(newRow);

                $('#testTableBody').off('input', '.editable-fee, .editable-discount').on('input', '.editable-fee, .editable-discount', function () {
                  calculateTotalFee();
                });

                calculateTotalFee();
              }


              function addTest(testType, testTypeId) {
                var testRow = $('#testTypeList tr[data-test-type-id="' + testTypeId + '"]');
                var testFee = testRow.find('.fee').text();

                if (testType && testFee) {
                  var existingRow = $('#testTableBody td[data-test-type-id="' + testTypeId + '"]').closest('tr');
                  if (existingRow.length > 0) {
                    existingRow.find('.editable-fee').text(testFee);
                  } else {
                    addTestRow(testType, testTypeId, testFee);
                  }
                }

                calculateTotalFee();
              }


              $('#testTypeList .badge-pill').mouseenter(function () {
                $(this).addClass('hover-effect');
              });

              $('#testTypeList .badge-pill').mouseleave(function () {
                $(this).removeClass('hover-effect');
              });

              $('#testTypeList .badge').click(function () {
                var testTypeRow = $(this).closest('tr');
                var testTypeId = testTypeRow.data('test-type-id');
                var testType = testTypeRow.find('.title').text().trim();
                var testFee = testTypeRow.find('.fee').text();
                console.log("Test Type: ", testType);
                console.log("Test Type ID: ", testTypeId);
                console.log("Test Fee: ", testFee);
                addTest(testType, testTypeId);
              });

              function addTestRow(testType, testTypeId, testFee) {
                var newRow = '<tr><td data-test-type-id="' + testTypeId + '">' + testType + '</td>' +
                  '<td contenteditable="true" class="editable-fee">' + testFee + '</td>' +
                  '<td contenteditable="true" class="editable-discount">0</td>' +
                  '<td><button class="btn btn-danger btn-sm remove-btn" onclick="removeTestRow(this)">Remove</button></td></tr>';
                $('#testTableBody').append(newRow);

                $('#testTableBody').off('input', '.editable-fee, .editable-discount').on('input', '.editable-fee, .editable-discount', function () {
                  calculateTotalFee();
                });

                calculateTotalFee();
              }

              $('#testTableBody').on('click', '.remove-btn', function () {
                var row = $(this).closest('tr');
                var testFee = parseFloat(row.find('td:eq(1)').text());
                row.remove();
                calculateTotalFee(-testFee);
              });


              function calculateTotalFee() {
                var totalFee = 0;
                var totalDiscount = 0;

                $('#testTableBody tr').each(function () {
                  var fee = parseFloat($(this).find('td:eq(1)').text());
                  var discount = parseFloat($(this).find('td:eq(2)').text());
                  if (!isNaN(fee) && !isNaN(discount)) {
                    var discountAmount = fee * (discount / 100);
                    totalFee += fee;
                    totalDiscount += discountAmount;
                  }
                });

                var discountedTotal = totalFee - totalDiscount;

                $('#totalFee').text(totalFee.toFixed(2));
                $('#totalDiscount').text(totalDiscount.toFixed(2));
                $('#discountedTotal').text(discountedTotal.toFixed(2));
              }

              $('#insertBtn').click(function () {
                insertData();
              });


              function insertData() {
                var clientId = $('#clientName').val();
                var clientName = $('#clientName option:selected').text();
                var appointmentId = $('#appointment').val();
                var totalFee = parseFloat($('#totalFee').text());
                var totalDiscount = parseFloat($('#totalDiscount').text());
                var discountedTotal = parseFloat($('#discountedTotal').text());
                var doctorId = $('#doctorName').val();
                var registrationDate = $('#registrationDate').val();
                var collectedDate = $('#collectedDate').val();

                console.log(doctorId);
                console.log(registrationDate);
                console.log(collectedDate);



                if (!clientId || isNaN(totalFee) || isNaN(totalDiscount) || isNaN(discountedTotal)) {
                  alert('Invalid data for insertion.');
                  return;
                }

                var tests = [];

                $('#testTableBody tr').each(function () {
                  var testTypeId = $(this).find('td:eq(0)').data('test-type-id');
                  var testName = $(this).find('td:eq(0)').text();
                  var fee = parseFloat($(this).find('td:eq(1)').text());
                  var discount = parseFloat($(this).find('td:eq(2)').text());

                  tests.push({
                    testTypeId: testTypeId,
                    testName: testName,
                    fee: fee,
                    discount: discount,
                    appointmentId: appointmentId
                  });
                });

                $.ajax({
                  method: 'POST',
                  url: '<?= site_url('LabController/submitTests') ?>',
                  dataType: "json",
                  data: {
                    clientId: clientId,
                    clientName: clientName,
                    appointmentId: appointmentId,
                    totalFee: totalFee,
                    totalDiscount: totalDiscount,
                    discountedTotal: discountedTotal,
                    doctorId: doctorId,
                    registrationDate: registrationDate,
                    collectedDate: collectedDate,
                    tests: tests
                  },
                  success: function (response) {
                    console.log('Data inserted successfully:', response);
                    if (response.pdfContent) {
                      var decodedPdfContent = atob(response.pdfContent);
                      var blob = new Blob([new Uint8Array(decodedPdfContent.split('').map(function (c) {
                        return c.charCodeAt(0);
                      }))], {
                        type: 'application/pdf'
                      });

                      var link = document.createElement('a');
                      link.href = window.URL.createObjectURL(blob);
                      //   link.download = 'your_file_name.pdf'; // Specify the desired file name
                      link.click();
                    }

                    $('#testTableBody').empty();
                    $('#totalFee').text('0');
                  },


                  error: function (error) {
                    console.error('Error inserting data:', error);
                  }
                });
              }
            });
          </script>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
        <?php include 'include_common/footer.php'; ?>
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

<!-- Mirrored from demo.bootstrapdash.com/star-admin2-free/template/pages/forms/basic_elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2024 05:42:34 GMT -->

</html>