<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./public/assets/vendors_s/select2/select2.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./public/assets/vendors_s/select2/select2.min.js"></script>
    </style>

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
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- partial -->
        <div class="container-fluid page-body-wrapper" style="padding-right: unset;padding-left: unset;">
            <?php include 'include_common/sidebar.php'; ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <form class="pt-3" method="POST" action="<?php echo base_url() . "saveitems"; ?>"
                                        enctype="multipart/form-data">
                                        <p class="card-description">
                                            Items Details
                                        </p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">BarCode</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="bcode" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Code</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="code"
                                                            value="<?= esc($newCode) ?>" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="name" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="card-description">
                                            Price Details
                                        </p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Cost</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="cost"
                                                            Value="0" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Minimun</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" Value="0"
                                                            name="min" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="card-description">
                                            Other Details
                                        </p>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Category</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <select class="form-control" name="category" required>
                                                                <?php foreach ($categories as $category): ?>
                                                                    <option value="<?= $category['idCatArt'] ?>">
                                                                        <?= $category['name'] ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <div class="input-group-append">
                                                                <button style="height: 2.1rem;" class="btn btn-primary"
                                                                    type="button" data-toggle="modal"
                                                                    data-target="#addCategoryModal">
                                                                    <i class="mdi mdi-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Notes</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="notes" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Units</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="Unit">
                                                            <?php foreach ($units as $unit): ?>
                                                                <option value="<?= $unit['idUnit'] ?>">
                                                                    <?= $unit['name'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Warehouse</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="warehouse">
                                                            <?php foreach ($warehouse as $warehouse): ?>
                                                                <option value="<?= $warehouse['idWarehouse'] ?>">
                                                                    <?= $warehouse['name'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Taxes</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="tax">
                                                            <?php foreach ($tax as $taxes): ?>
                                                                <option value="<?= $taxes['tax_id'] ?>">
                                                                    <?= $taxes['value'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Status</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="cstatus" required>
                                                            <option value="Active">Active</option>
                                                            <option value="Inactive">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Characteristic1</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="char_1" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Characteristic2</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="char_2" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Inventory</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="inventory" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php if ($isExpiry == 1): ?>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Item Expiry</label>
                                                            <div class="col-sm-9">
                                                                <input type="date" class="form-control" name="expiry"
                                                                    required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                    </form>

                                    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"
                                        aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php include 'cat_dialog_For_items.php'; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function () {
                $('.select2').select2();

                // Close button click event
                $('#closeAddClientModal').click(function (e) {
                    e.preventDefault(); // Prevent the default anchor behavior
                    // Assuming your form is wrapped in a modal, you can close it like this:
                    $('#addItemModal').modal('hide');
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#addCategoryModal').on('shown.bs.modal', function () {
                    var iframeContent = $('#categoryFormIframe').contents();
                    iframeContent.find('form').on('submit', function (e) {
                        e.preventDefault();
                        $('#addCategoryModal').modal('hide');
                    });
                });

                $('#addCategoryModal').on('hidden.bs.modal', function () {
                    var iframeContent = $('#categoryFormIframe').contents();
                    iframeContent.find('form').off('submit');
                });
            });
        </script>
</body>

</html>