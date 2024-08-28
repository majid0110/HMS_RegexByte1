<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Plugin css for this page -->
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
</head>


<body>
    <div class="container-scroller">
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->

            <!-- partial:../../partials/_sidebar.html -->
            <?php include 'include_common/sidebar.php'; ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Edit Test</h4>
                                    <!-- Form for editing test details -->
                                    <form class="pt-3" method="POST"
                                        action="<?= base_url('updateTest/' . $edit_Test['testTypeId']); ?>">
                                        <!-- Existing form fields -->
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Test Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="ls_name"
                                                    value="<?= $edit_Test['title']; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Description</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="ls_description"
                                                    value="<?= $edit_Test['description']; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Fee</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="ls_fee"
                                                    value="<?= $edit_Test['test_fee']; ?>" />
                                            </div>
                                        </div>

                                        <!-- Attributes section -->
                                        <div id="attributesContainer">
                                            <table class="table table-borderless">
                                                <tbody id="attributesTableBody">
                                                    <?php foreach ($attributes as $attribute): ?>
                                                        <tr class="attribute-row">
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>Title</label>
                                                                    <input type="text" class="form-control"
                                                                        name="attribute_title[]"
                                                                        value="<?= $attribute['title']; ?>" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>Reference Value</label>
                                                                    <input type="text" class="form-control"
                                                                        name="attribute_reference_value[]"
                                                                        value="<?= $attribute['referenceValue']; ?>" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>Unit</label>
                                                                    <input type="text" class="form-control"
                                                                        name="attribute_unit[]"
                                                                        value="<?= $attribute['unit']; ?>" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-danger remove-attribute">Remove</button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" id="addMoreAttribute" class="btn btn-primary">Add
                                                More</button>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
    <script>
        $(document).ready(function () {
            function createNewRow() {
                return `
            <tr class="attribute-row">
                <td>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="attribute_title[]" value="" />
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <label>Reference Value</label>
                        <input type="text" class="form-control" name="attribute_reference_value[]" value="" />
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <label>Unit</label>
                        <input type="text" class="form-control" name="attribute_unit[]" value="" />
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-attribute">Remove</button>
                </td>
            </tr>`;
            }

            $('#addMoreAttribute').click(function () {
                let newRow;

                if ($('.attribute-row').length > 0) {
                    newRow = $('.attribute-row:first').clone();
                    newRow.find('input').val('');
                } else {
                    newRow = createNewRow();
                }

                $('#attributesTableBody').append(newRow);
            });

            $('#attributesContainer').on('click', '.remove-attribute', function () {
                if ($('.attribute-row').length > 1) {
                    $(this).closest('.attribute-row').remove();
                }
            });
        });

    </script>
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
    <!-- End custom js for this page-->
</body>

</html>