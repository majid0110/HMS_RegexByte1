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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
                                <div class="profile"><img src="./public/assets/images_s/faces/face1.jpg"
                                        alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Thomas Douglas</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">19 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="./public/assets/images_s/faces/face2.jpg"
                                        alt="image"><span class="offline"></span></div>
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
                                <div class="profile"><img src="./public/assets/images_s/faces/face3.jpg"
                                        alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Daniel Russell</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">14 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="./public/assets/images_s/faces/face4.jpg"
                                        alt="image"><span class="offline"></span></div>
                                <div class="info">
                                    <p>James Richardson</p>
                                    <p>Away</p>
                                </div>
                                <small class="text-muted my-auto">2 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="./public/assets/images_s/faces/face5.jpg"
                                        alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Madeline Kennedy</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">5 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="./public/assets/images_s/faces/face6.jpg"
                                        alt="image"><span class="online"></span></div>
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
                                    <button type="button" class="btn btn-outline-success btn-fw" data-toggle="modal"
                                        data-target="#expiryModal" id="toggle-expiry-table"
                                        style="margin-left: 50rem;margin-bottom: -2rem;">Manage
                                        Expiry</button>

                                    <h4 class="card-title">Edit ITEMS</h4>
                                    <!-- EditService_form.php -->
                                    <form method="POST" action="<?= base_url('updateitem/' . $item['idItem']); ?>"
                                        enctype="multipart/form-data">
                                        <p class="card-description">
                                            Items Details
                                        </p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">BarCode</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="bcode"
                                                            value="<?= isset($item['barcode']) ? $item['barcode'] : ''; ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Code</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="code"
                                                            value="<?= $item['Code']; ?>" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="name"
                                                            value="<?= $item['Name']; ?>" required />
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
                                                            value="<?= $item['Cost']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Minimun</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="min"
                                                            value="<?= $item['Minimum']; ?>" />
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
                                                        <select class="form-control" name="category">
                                                            <?php foreach ($categories as $category): ?>
                                                                <option value="<?= $category['idCatArt'] ?>"
                                                                    <?= ($item['idCategories'] == $category['idCatArt']) ? 'selected' : '' ?>>
                                                                    <?= $category['name'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Notes</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="notes"
                                                            value="<?= $item['Notes']; ?>" />
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
                                                                <option value="<?= $unit['idUnit'] ?>"
                                                                    <?= ($item['Unit'] == $unit['idUnit']) ? 'selected' : '' ?>>
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
                                                                <option value="<?= $taxes['tax_id'] ?>"
                                                                    <?= (isset($item['idTAX']) && $item['idTAX'] == $taxes['tax_id']) ? 'selected' : '' ?>>
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
                                                            <option value="Active" <?= (isset($item['status']) && $item['status'] == 'Active') ? 'selected' : '' ?>>
                                                                Active</option>
                                                            <option value="Inactive" <?= (isset($item['status']) && $item['status'] == 'Inactive') ? 'selected' : '' ?>>
                                                                Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Characteristic1</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="char_1"
                                                            value="<?= isset($item['Characteristic1']) ? $item['Characteristic1'] : ''; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Characteristic2</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="char_2"
                                                            value="<?= isset($item['Characteristic2']) ? $item['Characteristic2'] : ''; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Inventory</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="inventory"
                                                            value="<?= isset($item['inventory']) ? $item['inventory'] : ''; ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-bottom: 1rem;">
                                                <div class="col-md-6">
                                                    <button type="submit"
                                                        class="btn btn-outline-info btn-fw">Update</button>
                                                </div>
                                            </div>
                                    </form>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="modal" id="expiryModal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h7 class="modal-title">Update Expiry</h7>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action="<?= base_url('updateExpiry/' . $item['idItem']); ?>">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <p class="card-description">Expiry Details</p>
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Inventory</th>
                                                                                    <th>Expiry Date</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php if (!empty($expiries)): ?>
                                                                                    <?php foreach ($expiries as $expiry): ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <input type="number"
                                                                                                    class="form-control expiry-inventory"
                                                                                                    name="expiry_inventory[<?= $expiry['expiryID']; ?>]"
                                                                                                    value="<?= $expiry['inventory']; ?>" />
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="date"
                                                                                                    class="form-control"
                                                                                                    name="expiry_date[<?= $expiry['expiryID']; ?>]"
                                                                                                    value="<?= $expiry['expiryDate']; ?>" />
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php endforeach; ?>
                                                                                <?php else: ?>
                                                                                    <!-- Provide empty fields for adding new expiry data -->
                                                                                    <tr>
                                                                                        <td>
                                                                                            <input type="number"
                                                                                                class="form-control expiry-inventory"
                                                                                                name="expiry_inventory[new_1]"
                                                                                                value="" />
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="date"
                                                                                                class="form-control"
                                                                                                name="expiry_date[new_1]"
                                                                                                value="" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <input type="number"
                                                                                                class="form-control expiry-inventory"
                                                                                                name="expiry_inventory[new_2]"
                                                                                                value="" />
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="date"
                                                                                                class="form-control"
                                                                                                name="expiry_date[new_2]"
                                                                                                value="" />
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php endif; ?>
                                                                            </tbody>
                                                                        </table>
                                                                        <button type="button" class="btn btn-secondary"
                                                                            id="add-expiry-row"
                                                                            <?= (isset($item['inventory'])) ? 'disabled' : '' ?>>Add More</button>
                                                                    </div>
                                                                </div>
                                                                <!-- Modal Footer -->
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Save</button>
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
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


                <!-- content-wrapper ends -->
                <!-- partial:../../partials/_footer.html -->
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


    <script>
        const mainInventoryInput = document.querySelector('input[name="inventory"]');
        const addMoreButton = document.getElementById('add-expiry-row');
        const expiryInventoryInputs = document.querySelectorAll('.expiry-inventory');

        function updateAddMoreButtonState() {
            const mainInventory = parseInt(mainInventoryInput.value, 10) || 0;
            const totalExpiryInventory = Array.from(expiryInventoryInputs)
                .reduce((sum, input) => sum + parseInt(input.value, 10) || 0, 0);

            if (totalExpiryInventory >= mainInventory) {
                addMoreButton.disabled = true;
            } else {
                addMoreButton.disabled = false;
            }
        }

        function showWarningDialog() {
            const mainInventory = parseInt(mainInventoryInput.value, 10) || 0;
            const totalExpiryInventory = Array.from(expiryInventoryInputs)
                .reduce((sum, input) => sum + parseInt(input.value, 10) || 0, 0);

            if (totalExpiryInventory > mainInventory) {
                alert('Warning: The total expiry inventory exceeds the main inventory. Please update your inventory.');
            }
        }

        expiryInventoryInputs.forEach((input) => {
            input.addEventListener('input', () => {
                updateAddMoreButtonState();
                showWarningDialog();
            });
        });

        mainInventoryInput.addEventListener('input', () => {
            updateAddMoreButtonState();
            showWarningDialog();
        });

        document.getElementById('add-expiry-row').addEventListener('click', function () {
            const tbody = document.querySelector('#expiryModal table tbody');
            const rowCount = tbody.children.length + 1;
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
            <td>
                <input type="number" class="form-control expiry-inventory" name="expiry_inventory[new_${rowCount}]" value="" />
            </td>
            <td>
                <input type="date" class="form-control" name="expiry_date[new_${rowCount}]" value="" />
            </td>
        `;

            const newExpiryInput = newRow.querySelector('.expiry-inventory');
            newExpiryInput.addEventListener('input', () => {
                updateAddMoreButtonState();
                showWarningDialog();
            });

            tbody.appendChild(newRow);
            updateAddMoreButtonState();
            showWarningDialog();
        });

        updateAddMoreButtonState();
        showWarningDialog();
    </script>

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

</html>