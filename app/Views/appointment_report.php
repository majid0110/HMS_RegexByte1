<?php include 'include_common/head1.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demo.bootstrapdash.com/star-admin2-free/template/pages/tables/basic-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2024 05:42:35 GMT -->

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Appointment-Report </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="./public/assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="./public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="./public/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="./public/assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="./public/assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="./public/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="./public/assets/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="./public/assets/images/favicon.png" />
    <style>
        #total-fee-container {
            background-color: #f2f2f2;
            border: 1px solid #000;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 4px;
            max-width: 29rem;
            margin-left: 31rem;
            height: auto;
            margin-top: -1.3rem;
            font-size: xx-small;
            font-family: 'Roboto', sans-serif;
        }

        #total-fee-container .header-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        #total-fee-container .data-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #total-fee-container .col {
            flex: 1;
            text-align: center;
        }

        #total-fee-container .col:first-child {
            text-align: left;
        }

        #total-fee-container .col:last-child {
            text-align: right;
        }

        #total-fee-container .header-row .col {
            font-weight: bold;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        #total-fee-container .data-row .col {
            font-size: 16px;
            font-weight: 900;
            color: #333;
        }

        #total-fee-by-doctor {
            color: #4CAF50;
        }

        #total-hospital-fee {
            color: #FF9800;
        }

        #total-fee {
            color: #2196F3;
        }

        .table-container {
            max-height: 400px;
            /* Adjust as needed */
            overflow-y: auto;
        }

        .export {
            padding: 17px 20px;

            box-sizing: border-box;
            border-radius: 6px;
            color: #000000;
            font-weight: 500;
            font-size: 12px;
            line-height: 12px;
            margin-bottom: -94px;
            margin-left: 39rem;
            align-items: center;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        /* Pagination Styling */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        /* Pagination Styling */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a {
            display: block;
            padding: 8px 16px;
            text-decoration: none;
            color: #333;
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border-color: #4CAF50;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }

        /* Additional Styling */
        .pagination a {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .pagination a.active {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>

</head>

<body>
    <div class="container-scroller">
        <!-- partial:./public/assets/partials/_navbar.html -->

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:./public/assets/partials/_settings-panel.html -->
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
                                    <button type="submit" class="add btn btn-primary todo-list-add-btn"
                                        id="add-task">Add</button>
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
                            <small
                                class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 fw-normal">See
                                All</small>
                        </div>
                        <ul class="chat-list">
                            <li class="list active">
                                <div class="profile"><img src="./public/assets/images/faces/face1.jpg" alt="image"><span
                                        class="online"></span></div>
                                <div class="info">
                                    <p>Thomas Douglas</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">19 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="./public/assets/images/faces/face2.jpg" alt="image"><span
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
                                <div class="profile"><img src="./public/assets/images/faces/face3.jpg" alt="image"><span
                                        class="online"></span></div>
                                <div class="info">
                                    <p>Daniel Russell</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">14 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="./public/assets/images/faces/face4.jpg" alt="image"><span
                                        class="offline"></span></div>
                                <div class="info">
                                    <p>James Richardson</p>
                                    <p>Away</p>
                                </div>
                                <small class="text-muted my-auto">2 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="./public/assets/images/faces/face5.jpg" alt="image"><span
                                        class="online"></span></div>
                                <div class="info">
                                    <p>Madeline Kennedy</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">5 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="./public/assets/images/faces/face6.jpg" alt="image"><span
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
            <!-- partial:./public/assets/partials/_sidebar.html -->
            <?php include 'include_common/sidebar.php'; ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form action="<?= base_url('generateExcelAppointments'); ?>" method="post">
                                    <div class="form-group row">
                                        <div>
                                            <div
                                                style="width:100%; display: flex; align-items: center; justify-content: flex-end; gap:10px">
                                                <button type="submit" class="btn btn-primary text-white me-0"
                                                    style="align-self: flex-end;color: white;background-color: #172D88;border-color: #172D88;height: 33px;font-size: 12px;font-weight: 500;box-sizing: border-box;border: 1px solid #CADDFF;padding: 8px 15px;border-radius: 6px;align-items: center;">
                                                    <i class=" ti-download"></i>
                                                    Export
                                                </button>
                                                <div class="col-md-3">

                                                    <label>Search</label>
                                                    <input class="form-control" type="text" name="search"
                                                        id="searchInput" placeholder="Search">
                                                </div>

                                            </div>

                                            <!-- <div class="btn-wrapper export" style="height: 20px;">
                                                <button type="submit" class="btn btn-primary text-white me-0">
                                                    <i class="ti-download"></i>
                                                    Export
                                                </button>
                                            </div> -->
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>By Doctor</label>
                                            <select class="form-control" name="doctor" id="doctorInput">
                                                <option value="">All Doctors</option>
                                                <?php foreach ($doctor_names as $doc): ?>
                                                    <option value="<?= $doc['FirstName'] . ' ' . $doc['LastName']; ?>">
                                                        <?= $doc['FirstName'] . ' ' . $doc['LastName']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>By Client</label>
                                            <div id="the-basics">
                                                <select class="form-control" name="clientName" id='clientInput'>
                                                    <option value="">All Client</option>
                                                    <?php foreach ($client_names as $client): ?>
                                                        <option value="<?= $client['client']; ?>">
                                                            <?= $client['client']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>From</label>
                                            <input class="form-control" type="date" name="fromDate" placeholder="From"
                                                id="fromDateInput">
                                        </div>
                                        <div class="col-md-3">
                                            <label>To</label>
                                            <input class="form-control" type="date" name="toDate" placeholder="To"
                                                id="toDateInput">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group row">
                                        <div class="col-md-3 offset-md-9">
                                            <button type="submit" class="btn btn-outline-info btn-icon-text">
                                                <i class="ti-download btn-icon-prepend"></i>
                                                Generate Excel
                                            </button>
                                        </div>
                                    </div> -->
                                </form>
                                <hr>
                                <!-- </div>
                                </div> -->
                                <h4 class="card-title">Appointments Report</h4>
                                <div class="col-12 grid-margin">
                                    <!-- <div class="table-container"> -->
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Client Name</th>
                                                    <th>Doctor Name</th>
                                                    <th>Appointment Date</th>
                                                    <!-- <th>Appointment Time</th> -->
                                                    <th>Appointment Type</th>
                                                    <th>Doctor Fee</th>
                                                    <th>Hospital Fee</th>
                                                    <th>Total Fee</th>
                                                    <!-- <th>Actions</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($Appointments as $appointment): ?>
                                                    <tr>
                                                        <td>
                                                            <?= $appointment['clientName']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $appointment['doctorFirstName'] . ' ' . $appointment['doctorLastName']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $appointment['appointmentDate']; ?>
                                                        </td>
                                                        <!-- <td>
                                                            'appointmentTime'
                                                        </td> -->
                                                        <td>
                                                            <?= $appointment['appointmentTypeName']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $appointment['appointmentFee']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $appointment['hospitalCharges']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $appointment['appointmentFee'] + $appointment['hospitalCharges']; ?>
                                                        </td>

                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                    </div>
                                    <!-- </div> -->
                                </div>

                                <div id="total-fee-container">

                                    <div class="row data-row">
                                        <div class="col">
                                            Total:
                                        </div>
                                        <div class="col" id="total-fee-by-doctor">
                                            <?= $totalFeeByDoctor ?>
                                        </div>
                                        <div class="col" id="total-hospital-fee">
                                            <?= $totalHospitalCharges ?>
                                        </div>
                                        <div class="col" id="total-fee">
                                            <?= $totalFeeByDoctor + $totalHospitalCharges ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="pagination-container">
                                    <div class="pagination">
                                        <?= $pager ?>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:./public/assets/partials/_footer.html -->

                    <!-- partial -->
                </div>
                <?php include 'include_common/footer.php'; ?>
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
        <!-- Add this to your HTML file -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script>
            $(document).ready(function () {
                $('#searchInput, #doctorInput, #clientInput, #fromDateInput, #toDateInput').on('input change', function () {
                    var searchValue = $('#searchInput').val();
                    var doctorValue = $('#doctorInput').val();
                    var clientValue = $('#clientInput').val();
                    var fromDateValue = $('#fromDateInput').val();
                    var toDateValue = $('#toDateInput').val();

                    console.log('Search Value:', searchValue);
                    console.log('Doctor Value:', doctorValue);
                    console.log('Client Value:', clientValue);
                    console.log('From Date Value:', fromDateValue);
                    console.log('To Date Value:', toDateValue);

                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('appointment_report'); ?>',
                        data: {
                            search: searchValue,
                            doctor: doctorValue,
                            client: clientValue,
                            fromDate: fromDateValue,
                            toDate: toDateValue
                        },
                        dataType: 'json', // Specify the expected data type
                        success: function (response) {
                            if (response.success) {
                                $('.table-responsive').html(response.tableContent);
                                // $('#total-fee-by-doctor p').text(response.totalFeeByDoctor);
                                $('#total-fee-by-doctor').text(response.totalFeeByDoctor);
                                $('#total-hospital-fee').text(response.totalHospitalCharges);
                                $('#total-fee-by-client p').text(response.totalFeeByClient);
                                $('#total-fee-by-dates p').text(response.totalFeeByDateRange);
                                var totalFee = parseFloat(response.totalFeeByDoctor) + parseFloat(response.totalHospitalCharges);
                                $('#total-fee').text(totalFee);
                            } else {
                                console.error('Error:', response.error);
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.error('AJAX Error:', textStatus, errorThrown);
                        }
                    });
                });
            });
        </script>



        <!-- <script>

            // $(document).ready(function () {
            //     $('#searchInput, #doctorInput, #clientInput').on('input', function () {
            //         var searchValue = $('#searchInput').val();
            //         var doctorValue = $('#doctorInput').val();
            //         var clientValue = $('#clientInput').val();

            //         console.log('Search Value:', searchValue);
            //         console.log('Doctor Value:', doctorValue);
            //         console.log('Client Value:', clientValue);

            //         $.ajax({
            //             type: 'POST',
            //             url: '<?= base_url('appointment_report'); ?>',
            //             data: { search: searchValue, doctor: doctorValue, client: clientValue },
            //             dataType: 'json', // Specify the expected data type
            //             success: function (response) {
            //                 if (response.success) {
            //                     $('.table-responsive').html(response.tableContent);
            //                 } else {
            //                     console.error('Error:', response.error);
            //                 }
            //             },
            //             error: function (jqXHR, textStatus, errorThrown) {
            //                 console.error('AJAX Error:', textStatus, errorThrown);
            //             }
            //         });
            //     });
            // });




            // $(document).ready(function () {
            //     $('#searchInput, #doctorInput, #clientInput').on('input', function () {
            //         var searchValue = $('#searchInput').val();
            //         var doctorValue = $('#doctorInput').val();
            //         var clientValue = $('#clientInput').val();

            //         console.log('Search Value:', searchValue);
            //         console.log('Doctor Value:', doctorValue);
            //         console.log('Client Value:', clientInput);

            //         $.ajax({
            //             type: 'POST',
            //             url: '<?= base_url('appointment_report'); ?>',
            //             data: { search: searchValue, doctor: doctorValue, clientName: clientValue },
            //             dataType: 'json', // Specify the expected data type
            //             success: function (response) {
            //                 if (response.success) {
            //                     $('.table-responsive').html(response.tableContent);
            //                 } else {
            //                     console.error('Error:', response.error);
            //                 }
            //             },
            //             error: function (jqXHR, textStatus, errorThrown) {
            //                 console.error('AJAX Error:', textStatus, errorThrown);
            //             }
            //         });
            //     });
            // });
        </script> -->
        <!-- <script>
            // Add an event listener to the search input
            $(document).ready(function () {
                $('#searchInput').on('input', function () {
                    // Trigger the form submission when the user types
                    $(this).closest('form').submit();
                });
            });
        </script> -->
        <!-- <script>
            // Add an event listener to the search input
            $(document).ready(function () {
                $('#searchInput').on('input', function () {
                    // Get the search term
                    var searchValue = $(this).val();

                    // Send an AJAX request to update the table content
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('appointment_report'); ?>',
                        data: { search: searchValue },
                        success: function (response) {
                            // Update the table content with the response
                            $('.table-responsive').html(response);
                        }
                    });
                });
            });
        </script> -->
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