<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Items Table</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../public/assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="../public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../public/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../public/assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="../public/assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../public/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/assets/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="../public/assets/css/vertical-layout-light/style.css">

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
            max-width: 80%;
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

        <div class="container-fluid page-body-wrapper">
            <?php include 'include_common/sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                $successMessage = session()->getFlashdata('success');
                                $errorMessage = session()->getFlashdata('error');
                                ?>
                                <h4 class="card-title">Items</h4>
                                <span>
                                    <form action="<?= base_url('transferItems') ?>" method="post"
                                        enctype="multipart/form-data">
                                        <div class="form-group d-flex align-items-end"
                                            style="margin-left: 30rem; margin-bottom: -4rem;">
                                            <input type="file" name="excel_file" class="form-control" required
                                                style="width: auto; height: auto;">
                                            <button type="submit" class="btn btn-primary ms-2">Import Excel</button>
                                        </div>
                                    </form>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">Add</button>
                                </span>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-sm-9">
                                                <input type="text" id="searchInput" class="form-control"
                                                    placeholder="Search by name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-sm-9">
                                                <select id="statusFilter" class="form-control">
                                                    <option value="">All</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
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
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Unit</th>
                                                <th>Inventory</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsTableBody">
                                            <?php $serialNumber = 1; ?>
                                            <?php foreach ($items as $item): ?>
                                                <tr>
                                                    <td><?= $serialNumber++ ?></td>
                                                    <td><?= $item['Code'] ?></td>
                                                    <td><?= $item['Name'] ?></td>
                                                    <td><?= $item['Cost'] ?></td>
                                                    <td>
                                                        <span
                                                            class="<?= $item['status'] == 'Active' ? 'text-bg-success' : 'text-bg-danger'; ?>">
                                                            <?= $item['status']; ?>
                                                        </span>
                                                    </td>
                                                    <td><?= $item['unit_name'] ?></td>
                                                    <td><?= $item['inventory'] ?></td>
                                                    <td>
                                                        <!-- Action buttons: Edit, Delete -->
                                                        <a href="<?= base_url('edititem/' . $item['idItem']); ?>"
                                                            class="btn btn-info btn-sm">Edit</a>
                                                        <a href="<?= base_url('deleteitem/' . $item['idItem']); ?>"
                                                            onclick="return confirm('Are you sure you want to delete this item?');"
                                                            class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <div class="pagination-container">
                                        <div class="pagination">
                                            <?= $pager ?>
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

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="addItemModalBody">
                            <?php include ('items_form.php'); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- main-panel ends -->
    <!-- page-body-wrapper ends -->
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

            function filterTable() {
                var searchValue = $('#searchInput').val().toLowerCase();
                var statusValue = $('#statusFilter').val().toLowerCase();

                $('#itemsTableBody tr').filter(function () {
                    var nameMatch = $(this).find('td:nth-child(3)').text().toLowerCase().indexOf(searchValue) > -1;
                    var statusMatch = statusValue === "" || (
                        (statusValue === "active" && $(this).find('td:nth-child(5) span').hasClass('text-bg-success')) ||
                        (statusValue === "inactive" && $(this).find('td:nth-child(5) span').hasClass('text-bg-danger'))
                    );
                    $(this).toggle(nameMatch && statusMatch);
                });
            }

            $('#searchInput').on('keyup', filterTable);
            $('#statusFilter').on('change', filterTable);
        });

    </script>
    <!-- End plugin js for this page -->
</body>

</html>