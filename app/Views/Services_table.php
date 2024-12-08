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
    <link rel="stylesheet" href="../public/assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="../public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../public/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../public/assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="../public/assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../public/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../public/assets/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../public/assets/images/favicon.png" />

    <style>
        .toast {
            position: fixed;
            top: 10rem;
            right: 20px;
            background-color: orange;
            color: #fff;
            padding: 16px 24px;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transform: translateY(-100%);
            transition: all 0.5s ease-in-out;
            z-index: 999;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 500;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast.success {
            background-color: #6495ED;
        }

        .toast.error {
            background-color: #dc3545;
        }

        .toast::before {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            border-width: 10px;
            border-style: solid;
            border-color: transparent transparent transparent transparent;
        }

        .toast.success::before {
            border-top-color: #6495ED;
        }

        .toast.error::before {
            border-top-color: #dc3545;
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

        .modal-lg {
            max-width: 100%;
        }

        .text-bg-success {
            background-color: #73ad31;
            color: white;
            padding: 0.2rem 0.4rem;
            border-radius: 0.2rem;
        }

        .text-bg-danger {
            background-color: red;
            color: white;
            padding: 0.2rem 0.4rem;
            border-radius: 0.2rem;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:./public/assets/partials/_navbar.html -->

        <!-- partial -->
        <div class="container-fluid page-body-wrapper" style="padding-left:unset; padding-right: unset;">
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
                                <?php
                                $successMessage = session()->getFlashdata('success');
                                $errorMessage = session()->getFlashdata('error');
                                ?>
                                <h4 class="card-title">Services Table</h4>

                                <span>
                                    <form id="importForm" action="<?= base_url('transferServices') ?>" method="post"
                                        enctype="multipart/form-data">
                                        <div class="form-group d-flex align-items-end"
                                            style="margin-left: 30rem; margin-bottom: -4rem;">
                                            <input type="file" name="excel_file" class="form-control" required
                                                style="width: auto; height: auto;">
                                            <button type="submit" class="btn btn-primary ms-2">Import Excel</button>
                                        </div>
                                    </form>

                                    <div class="modal fade" id="progressModal" tabindex="-1"
                                        aria-labelledby="progressModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="progressModalLabel">Importing Services
                                                    </h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="progress">
                                                        <div id="progressBar" class="progress-bar" role="progressbar"
                                                            style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                                            aria-valuemax="100">0%</div>
                                                    </div>
                                                    <div id="progressStatus" class="mt-3">Starting import...</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <a href="<?= base_url('ServicesForm'); ?>" class="btn btn-primary">Add</a>
                                    <!-- <button type="button" class="btn btn-primary" id="openMainModalBtn">Add</button> -->
                                    <a href="<?= base_url('transferItemsToServices'); ?>" class="btn btn-dark">Transfer
                                        Items</a>
                                    <hr>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-sm-9">
                                                    <input type="text" id="searchInputService" class="form-control"
                                                        placeholder="Search by name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <div class="col-sm-9">
                                                    <select id="statusFilterService" class="form-control">
                                                        <option value="">All</option>
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="mainModal" tabindex="-1"
                                        aria-labelledby="mainModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="mainModalLabel">Add Service</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" id="mainModalContent">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Code</th>
                                                    <th>Service Name</th>
                                                    <th>Price</th>
                                                    <th>Unit</th>
                                                    <th>IsService</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="itemsTableBody">
                                                <?php
                                                $serialNumber = ($currentPage - 1) * $perPage + 1;
                                                ?>
                                                <?php foreach ($Services as $Service): ?>
                                                    <tr>
                                                        <td><?= $serialNumber++ ?></td>
                                                        <td><?= $Service['Code']; ?></td>
                                                        <td><?= $Service['Name']; ?></td>
                                                        <td><?= $Service['Price']; ?></td>

                                                        <td><?= $Service['unit']; ?></td>
                                                        <td><?= $Service['isService']; ?></td>
                                                        <td>
                                                            <span
                                                                class="<?= $Service['status'] == 'Active' ? 'text-bg-success' : 'text-bg-danger'; ?>">
                                                                <?= $Service['status']; ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url('editService/' . $Service['idArtMenu']); ?>"
                                                                class="btn btn-info btn-sm">Edit</a>
                                                            <a href="<?= base_url('deleteService/' . $Service['idArtMenu']); ?>"
                                                                onclick="return confirm('Are you sure you want to delete this Service?');"
                                                                class="btn btn-danger btn-sm">Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="pagination-container">
                                        <div class="pagination">
                                            <?= $pager ?>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include 'include_common/footer.php'; ?>
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="./public/assets/vendors/js/vendor.bundle.base.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="./public/assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="./public/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <!-- Include jQuery and Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


        <script>
            $(document).ready(function () {
                function showProgressModal() {
                    $('#progressModal').modal('show');
                }

                function updateProgressBar(percentComplete, status) {
                    $('#progressBar').width(percentComplete + '%');
                    $('#progressBar').attr('aria-valuenow', percentComplete);
                    $('#progressBar').text(percentComplete + '%');
                    $('#progressStatus').text(status);
                }

                $('#importForm').on('submit', function (e) {
                    e.preventDefault();

                    var formData = new FormData(this);
                    showProgressModal();
                    updateProgressBar(0, 'Starting import...');

                    $.ajax({
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function (e) {
                                if (e.lengthComputable) {
                                    var percentComplete = Math.round((e.loaded / e.total) * 100);
                                    updateProgressBar(percentComplete, 'Uploading file...');
                                }
                            }, false);

                            xhr.addEventListener('progress', function (e) {
                                if (e.lengthComputable) {
                                    var percentComplete = Math.round((e.loaded / e.total) * 100);
                                    updateProgressBar(percentComplete, 'Processing file...');
                                }
                            }, false);

                            return xhr;
                        },
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.success) {
                                updateProgressBar(100, 'Import complete!');
                                setTimeout(function () {
                                    $('#progressModal').modal('hide');
                                    location.reload();
                                }, 2000);
                            } else {
                                updateProgressBar(100, 'Import failed: ' + (response.error || 'Unknown error'));
                            }
                        },
                        error: function (xhr, status, error) {
                            updateProgressBar(100, 'An error occurred: ' + (xhr.responseText || error));
                        }
                    });
                });
            });
        </script>



        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var openMainModalBtn = document.getElementById('openMainModalBtn');
                if (openMainModalBtn) {
                    openMainModalBtn.addEventListener('click', function () {
                        fetch('ServicesForm')
                            .then(response => response.text())
                            .then(data => {
                                document.getElementById('mainModalContent').innerHTML = data;
                                $('#mainModal').modal('show');
                                initNestedModal();
                            })
                            .catch(error => console.error('Error:', error));
                    });
                }
            });

            function initNestedModal() {
                $('#linkItemsBtn').click(function () {
                    $('#linkItemsModal').modal('show');
                });

                $('#linkItemsModal').on('shown.bs.modal', function () {
                    $(this).find('.modal-body').focus();
                });
            }
        </script>

        <script>
            $(document).ready(function () {
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
                        }, 500);
                    }, 5000);
                }
                <?php if ($successMessage = session()->getFlashdata('success')): ?>
                    showToast('<?= $successMessage ?>', 'success');
                <?php endif; ?>
                <?php if ($errorMessage = session()->getFlashdata('error')): ?>
                    showToast('<?= $errorMessage ?>', 'error');
                <?php endif; ?>

                function filterServiceTable() {
                    var searchValue = $('#searchInputService').val().toLowerCase();
                    var statusValue = $('#statusFilterService').val().toLowerCase();

                    $('table tbody tr').filter(function () {
                        var nameMatch = $(this).find('td:nth-child(3)').text().toLowerCase().indexOf(searchValue) > -1;
                        var statusMatch = statusValue === "" || (
                            (statusValue === "active" && $(this).find('td:nth-child(8) span').hasClass('text-bg-success')) ||
                            (statusValue === "inactive" && $(this).find('td:nth-child(8) span').hasClass('text-bg-danger'))
                        );
                        $(this).toggle(nameMatch && statusMatch);
                    });
                }
                $('#searchInputService').on('keyup', filterServiceTable);
                $('#statusFilterService').on('change', filterServiceTable);
            });

        </script>




        <script src="../public/assets/js/off-canvas.js"></script>
        <script src="../public/assets/js/hoverable-collapse.js"></script>
        <script src="../public/assets/js/template.js"></script>
        <script src="../public/assets/js/settings.js"></script>
        <script src="../public/assets/js/todolist.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <!-- End custom js for this page-->
</body>


<!-- Mirrored from demo.bootstrapdash.com/star-admin2-free/template/pages/tables/basic-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2024 05:42:35 GMT -->

</html>