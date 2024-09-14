<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demo.bootstrapdash.com/star-admin2-free/template/pages/tables/basic-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2024 05:42:35 GMT -->

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RegexByte</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="./public/assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="./public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="./public/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="./public/assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="./public/assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="./public/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

        <div class="container-fluid page-body-wrapper">

            <?php include 'include_common/sidebar.php'; ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Suppliers</h4>
                                <button type="button" class="btn btn-Primary" id="add-item-btn" data-toggle="modal"
                                    data-target="#addcatModal">Add</button>
                                <hr>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>CNIC</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>status</th>
                                            <th>Notes</th>
                                            <th>Action</th>
                                        </tr>
                                        <tbody>

                                            <?php foreach ($suppliers as $supplier): ?>
                                                <tr>
                                                    <td>
                                                        <?= $supplier['supplier']; ?>
                                                    </td>
                                                    <td>
                                                        <?= $supplier['contact']; ?>
                                                    </td>
                                                    <td>
                                                        <?= $supplier['cnic']; ?>
                                                    </td>
                                                    <td>
                                                        <?= $supplier['address']; ?>
                                                    </td>
                                                    <td>
                                                        <?= $supplier['city']; ?>
                                                    </td>
                                                    <td>
                                                        <?= $supplier['status']; ?>
                                                    </td>
                                                    <td>
                                                        <?= $supplier['notes']; ?>
                                                    </td>
                                                    <td>

                                                        <a href="<?= base_url('edit_supplier/' . $supplier['idSupplier']); ?>"
                                                            class="btn btn-info btn-sm">Edit</a>

                                                        <a href="<?= base_url('delete_Supplier/' . $supplier['idSupplier']); ?>"
                                                            onclick="return confirm('Are you sure you want to delete this client?');"
                                                            class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>


                                    </table>
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
    <div class="modal fade" id="addcatModal" tabindex="-1" role="dialog" aria-labelledby="addcatModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header lg">
                    <h5 class="modal-title" id="addcatModalLabel">Add Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm" action="<?= base_url('SaveSupplier') ?>" method="POST">
                        <div class="row">
                            <!-- Supplier Name input -->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Supplier</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="supplier" />
                                    </div>
                                </div>
                            </div>
                            <!-- Contact input -->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Contact</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="contact" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">CNIC</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="cnic" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="status" required>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Address input -->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="address" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">City</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="city" />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Notes</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="notes" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit -->
    <div class="modal fade" id="editcatModal" tabindex="-1" role="dialog" aria-labelledby="editcatModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editcatModalLabel">Edit Expense Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm" action="<?= site_url('updateExpenseCategory') ?>" method="POST">
                        <input type="hidden" id="editCategoryId" name="id">
                        <div class="form-group">
                            <label for="editCategoryTitle">Title</label>
                            <input type="text" class="form-control" id="editCategoryTitle" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="editCategoryDeleted">Deleted</label>
                            <select class="form-control" id="editCategoryDeleted" name="deleted" required>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="./public/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="./public/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->

    <script src="./public/assets/js/off-canvas.js"></script>
    <script src="./public/assets/js/hoverable-collapse.js"></script>
    <script src="./public/assets/js/template.js"></script>
    <script src="./public/assets/js/settings.js"></script>
    <script src="./public/assets/js/todolist.js"></script>

    <!-- <script>
        $(document).ready(function () {
            $('.edit-item-btn').on('click', function () {
                var id = $(this).data('id');
                var title = $(this).data('title');
                var deleted = $(this).data('deleted');

                $('#editCategoryId').val(id);
                $('#editCategoryTitle').val(title);
                $('#editCategoryDeleted').val(deleted);
            });
        });
    </script> -->
    <!-- endinject -->
    <!-- Custom js for this page-->
    <!-- End custom js for this page-->
</body>


<!-- Mirrored from demo.bootstrapdash.com/star-admin2-free/template/pages/tables/basic-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2024 05:42:35 GMT -->

</html>