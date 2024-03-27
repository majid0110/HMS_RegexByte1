<?php include 'include_common/head1.php'; ?>
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

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        p {
            font-size: medium;
            font-family: math;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            font-family: monospace;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .blinking {
            animation: blink 3s infinite;
            color: darkblue;
            font-weight: bolder;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .total {
            background: bisque;
            font-weight: bold;
        }

        .invoice-box table tr.heading td {
            background: #8299EF;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
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
            <div class="main-panel" style="padding: 20px; background: #F4F5F7">
                <div class="content-wrapper" style="background: #F4F5F7;">

                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="invoice-box"
                            style="max-width: 950px; margin: auto; border-radius: 30px; background: snow; width: 85rem; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-size: 16px; line-height: 24px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #555;">
                            <table cellpadding="0" cellspacing="0">
                                <tr class="top">
                                    <td colspan="3">
                                        <table>
                                            <tr>
                                                <td class="title">
                                                    <?php
                                                    $session = session();
                                                    if ($session->has('businessProfileImage')) {
                                                        echo '<img class="img-xs rounded-circle larger-profile-img" style="width: 90px; height: 90px;" src="' . $session->get('businessProfileImage') . '" alt="Profile image">';
                                                    }
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $session = session();
                                                    if ($session->has('businessName') && $session->has('phoneNumber')) {
                                                        echo '<strong>' . $session->get('businessName') . '<br>';
                                                        echo '<strong>' . $session->get('phoneNumber') . '<br>';
                                                        echo '<strong>' . $session->get('business_address') . '<br>';
                                                    }
                                                    ?>
                                                </td>
                                                <td></td>
                                        </table>
                                        <hr>
                                        <p>

                                            <span class="blinking">
                                                Appointment NO:
                                                <?= $AppointmentDetails[0]['appointmentNo']; ?>
                                            </span><br />
                                            Created:
                                            <?= (new DateTime($AppointmentDetails[0]['createdAT']))->format('F d, Y'); ?><br />
                                            Appointment Time:
                                            <?= $AppointmentDetails[0]['appointmentTime']; ?><br />
                                        </p>
                                        <a
                                            href="<?= base_url('appointment/deleteAppointment/' . $AppointmentDetails[0]['appointmentID']); ?>">
                                            <!-- <button onclick="deleteAppointment()" type="button"
                                                class="btn btn-danger btn-icon"
                                                style="margin-left: 23rem;margin-left: 49rem; margin-top: -52px;">
                                                <svg style="color: #F4F5F7;" xmlns="http://www.w3.org/2000/svg"
                                                    width="18" height="18" fill="currentColor" class="bi bi-trash"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                    <path
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                </svg>
                                            </button> -->
                                        </a>
                                    </td>
                                </tr>

                                <tr class="information">
                                    <td>
                                        <u><b>Client Details:</b></u><br />
                                        <span style="background: gold;">Unique:
                                            <?= $AppointmentDetails[0]['unique']; ?><br />
                                        </span>
                                        Client:
                                        <?= $AppointmentDetails[0]['client']; ?><br />
                                        Gender:
                                        <?= $AppointmentDetails[0]['gender']; ?><br />
                                        Contact:
                                        <?= $AppointmentDetails[0]['contact']; ?><br />


                                    </td>
                                    <td>
                                        <u><b>Doctor Details:</b></u><br />
                                        Doctor:
                                        <?= $AppointmentDetails[0]['doctorFirstName'] . ' ' . $AppointmentDetails[0]['doctorLastName']; ?><br />
                                        Specialization:
                                        <?= $AppointmentDetails[0]['Specialization']; ?><br />
                                        Contact:
                                        <?= $AppointmentDetails[0]['doctorContact']; ?><br />
                                    </td>
                                </tr>
                            </table>
                            </td>
                            </tr>
                            </table>
                            <br>

                            <table cellpadding="0" cellspacing="0">
                                <tr class="heading">
                                    <td>Appointment Type</td>
                                    <td>Hospital Fee</td>
                                    <td>Appointment Fee</td>
                                </tr>
                                <tr class="item">
                                    <td>
                                        <?= $AppointmentDetails[0]['AppointmentType']; ?>
                                    </td>
                                    <td>
                                        <?= $AppointmentDetails[0]['hospitalCharges']; ?>
                                    </td>
                                    <td>
                                        <?= $AppointmentDetails[0]['appointmentFee']; ?>
                                    </td>
                                </tr>
                                <tr class="total">
                                    <td colspan="2">Total:</td>
                                    <td>
                                        <?= $AppointmentDetails[0]['hospitalCharges'] + $AppointmentDetails[0]['appointmentFee']; ?>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <hr>

                            <?php if (!empty ($AppointmentDetails[0]['labTestId'])): ?>
                                <h3>Lab Test Details</h3>
                                <table cellpadding="0" cellspacing="0">
                                    <tr class="information">
                                        <td>
                                            <span style="font-family: math;"> Test Invoice:
                                                <?= $AppointmentDetails[0]['labInvoice']; ?><br />
                                                Created at:
                                                <?= $AppointmentDetails[0]['labdate']; ?><br />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="heading">
                                        <td>Test</td>
                                        <td>Hospital Fee</td>
                                        <td>Test Fee</td>
                                    </tr>

                                    <?php
                                    $totalFee = 0;
                                    foreach ($AppointmentDetails as $detail):
                                        $totalFee += $detail['labhospital'] + $detail['labTestFee'];
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $detail['TestTitle']; ?>
                                            </td>
                                            <td>
                                                <?= $detail['labhospital']; ?>
                                            </td>
                                            <td>
                                                <?= $detail['labTestFee']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <!-- Display total -->
                                    <tr class="total">
                                        <td colspan="2">Total:</td>
                                        <td>
                                            <?= $totalFee; ?>
                                        </td>
                                    </tr>
                                </table>
                            <?php else: ?>
                                <p>No lab record found.</p>
                            <?php endif; ?>



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