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
                                    <h4 class="card-title">Edit Sector</h4>
                                    <form action="<?= base_url('role/update') ?>" method="post">
                                        <input type="hidden" name="role_id" value="<?= $role['ID'] ?>">
                                        <label for="role_name">Role Name:</label>
                                        <input type="text" id="role_name" name="role_name"
                                            value="<?= $role['role_name'] ?>"><br><br>

                                        <label for="role_description">Role Description:</label>
                                        <input type="text" id="role_description" name="role_description"
                                            value="<?= $role['role_description'] ?>"><br><br>

                                        <h2>Module Permissions</h2>
                                        <?php foreach ($permissions as $permission): ?>
                                            <input type="checkbox" id="can_view_<?= $permission['moduleID'] ?>"
                                                name="permissions[<?= $permission['moduleID'] ?>][can_view]" value="1"
                                                <?= $permission['can_view'] ? 'checked' : '' ?>>
                                            <label for="can_view_<?= $permission['moduleID'] ?>">View</label>

                                            <input type="checkbox" id="can_insert_<?= $permission['moduleID'] ?>"
                                                name="permissions[<?= $permission['moduleID'] ?>][can_insert]" value="1"
                                                <?= $permission['can_insert'] ? 'checked' : '' ?>>
                                            <label for="can_insert_<?= $permission['moduleID'] ?>">Insert</label>

                                            <input type="checkbox" id="can_update_<?= $permission['moduleID'] ?>"
                                                name="permissions[<?= $permission['moduleID'] ?>][can_update]" value="1"
                                                <?= $permission['can_update'] ? 'checked' : '' ?>>
                                            <label for="can_update_<?= $permission['moduleID'] ?>">Update</label>

                                            <input type="checkbox" id="can_delete_<?= $permission['moduleID'] ?>"
                                                name="permissions[<?= $permission['moduleID'] ?>][can_delete]" value="1"
                                                <?= $permission['can_delete'] ? 'checked' : '' ?>>
                                            <label for="can_delete_<?= $permission['moduleID'] ?>">Delete</label>
                                            <br>
                                        <?php endforeach; ?>

                                        <button type="submit">Save</button>
                                    </form>

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