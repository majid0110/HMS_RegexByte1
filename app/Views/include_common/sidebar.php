<?php
$modules = $session->get('modules');
$userPermissions = $session->get('user_permissions');
$modulePermissions = $session->get('module_permissions');

?>


<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dashboard'); ?>">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <?php foreach ($modules as $module): ?>
            <?php
            $moduleID = $module['id'];

            $isSalesModule = $module['module_name'] === 'Sales';

            $canView = $isSalesModule && isset($modulePermissions[$moduleID]['can_view']) && $modulePermissions[$moduleID]['can_view'];
            ?>

            <?php if ($canView): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('New_SalesFrom'); ?>">
                        <i class="menu-icon mdi mdi-pharmacy"></i>
                        <span class="menu-title">
                            <?= $module['module_name'] ?>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php foreach ($modules as $module): ?>
            <?php
            $moduleID = $module['id'];

            $isSalesModule = $module['module_name'] === 'Services';

            $canView = $isSalesModule && isset($modulePermissions[$moduleID]['can_view']) && $modulePermissions[$moduleID]['can_view'];
            ?>

            <?php if ($canView): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('sales_form'); ?>">
                        <i class="menu-icon mdi mdi-cash-multiple"></i>
                        <span class="menu-title">
                            <?= $module['module_name'] ?>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- For Appointments module -->
        <?php foreach ($modules as $module): ?>
            <?php
            $moduleID = $module['id'];

            $isAppointmentsModule = $module['module_name'] === 'General-OPD';

            $canView = $isAppointmentsModule && isset($modulePermissions[$moduleID]['can_view']) && $modulePermissions[$moduleID]['can_view'];
            ?>

            <?php if ($canView): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('GenearalOPD'); ?>">
                        <i class="menu-icon mdi mdi-alarm-plus"></i>
                        <span class="menu-title">
                            <?= $module['module_name'] ?>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php foreach ($modules as $module): ?>
            <?php
            $moduleID = $module['id'];

            $isAppointmentsModule = $module['module_name'] === 'Appointments';

            $canView = $isAppointmentsModule && isset($modulePermissions[$moduleID]['can_view']) && $modulePermissions[$moduleID]['can_view'];
            ?>

            <?php if ($canView): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('appointments_form'); ?>">
                        <i class="menu-icon mdi mdi-alarm-check"></i>
                        <span class="menu-title">
                            <?= $module['module_name'] ?>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>



        <!-- For Laboratory Services module -->
        <?php foreach ($modules as $module): ?>
            <?php
            $moduleID = $module['id'];

            $isLaboratoryServicesModule = $module['module_name'] === 'Laboratory Services';

            $canView = $isLaboratoryServicesModule && isset($modulePermissions[$moduleID]['can_view']) && $modulePermissions[$moduleID]['can_view'];
            ?>

            <?php if ($canView): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('labtest_form'); ?>">
                        <i class="menu-icon mdi mdi-hospital-building"></i>
                        <span class="menu-title">
                            <?= $module['module_name'] ?>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>


        <!-- For Expenses module -->
        <?php foreach ($modules as $module): ?>
            <?php
            $moduleID = $module['id'];

            $isSalesModule = $module['module_name'] === 'Expenses';

            $canView = $isSalesModule && isset($modulePermissions[$moduleID]['can_view']) && $modulePermissions[$moduleID]['can_view'];
            ?>

            <?php if ($canView): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('expenses_form'); ?>">
                        <i class="menu-icon mdi mdi-cash-multiple"></i>
                        <span class="menu-title">
                            <?= $module['module_name'] ?>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- For Clients module -->
        <?php foreach ($modules as $module): ?>
            <?php
            $moduleID = $module['id']; // Adjust this based on your actual column name
        
            // Check if the current module is the "Clients" module
            $isClientsModule = $module['module_name'] === 'Clients';

            // Check if the user has permission to view this module
            $canView = $isClientsModule && isset($modulePermissions[$moduleID]['can_view']) && $modulePermissions[$moduleID]['can_view'];
            ?>

            <?php if ($canView): ?>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-<?= $moduleID ?>" aria-expanded="false"
                        aria-controls="ui-basic-<?= $moduleID ?>">
                        <i class="menu-icon mdi mdi-account-circle-outline"></i>
                        <span class="menu-title">
                            <?= $module['module_name'] ?>
                        </span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic-<?= $moduleID ?>">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('clients_form'); ?>">Add
                                    <?= $module['module_name'] ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('clients_table'); ?>">View
                                    <?= $module['module_name'] ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>



        <!-- For Doctors module -->
        <?php foreach ($modules as $module): ?>
            <?php
            $moduleID = $module['id'];

            $isDoctorsModule = $module['module_name'] === 'Doctors';

            $canView = $isDoctorsModule && isset($modulePermissions[$moduleID]['can_view']) && $modulePermissions[$moduleID]['can_view'];
            ?>

            <?php if ($canView): ?>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-<?= $moduleID ?>" aria-expanded="false"
                        aria-controls="ui-basic-<?= $moduleID ?>">
                        <i class="menu-icon mdi mdi-doctor"></i>
                        <span class="menu-title">
                            <?= $module['module_name'] ?>
                        </span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic-<?= $moduleID ?>">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('doctors_form'); ?>">Add
                                    <?= $module['module_name'] ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('doctors_table'); ?>">View
                                    <?= $module['module_name'] ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('doctors_fee'); ?>">Doctors Fee</a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php foreach ($modules as $module): ?>
            <?php
            $moduleID = $module['id'];

            $isUserManagementModule = $module['module_name'] === 'User Management';

            $canView = $isUserManagementModule && isset($modulePermissions[$moduleID]['can_view']) && $modulePermissions[$moduleID]['can_view'];
            ?>

            <?php if ($canView): ?>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-<?= $moduleID ?>" aria-expanded="false"
                        aria-controls="ui-basic-<?= $moduleID ?>">
                        <i class="menu-icon mdi mdi-card-text-outline"></i>
                        <span class="menu-title">
                            <?= $module['module_name'] ?>
                        </span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic-<?= $moduleID ?>">
                        <ul class="nav flex-column sub-menu">
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="pages/forms/basic_elements.html">Create License</a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url() . 'role_form'; ?>">Create Roles</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url() . 'view_role'; ?>">Edit Roles</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url() . 'user_form2'; ?>">Create Users</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('users_table'); ?>">View Users</a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- For Configuration module -->
        <?php foreach ($modules as $module): ?>
            <?php
            $moduleID = $module['id'];

            $isConfigurationModule = $module['module_name'] === 'Configuration';

            $canView = $isConfigurationModule && isset($modulePermissions[$moduleID]['can_view']) && $modulePermissions[$moduleID]['can_view'];
            ?>

            <?php if ($canView): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('configure'); ?>">
                        <i class="menu-icon mdi mdi-lumx"></i>
                        <span class="menu-title">
                            <?= $module['module_name'] ?>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- For Reports module -->
        <?php foreach ($modules as $module): ?>
            <?php
            $moduleID = $module['id'];

            $isReportsModule = $module['module_name'] === 'Reports';

            $canView = $isReportsModule && isset($modulePermissions[$moduleID]['can_view']) && $modulePermissions[$moduleID]['can_view'];
            ?>

            <?php if ($canView): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('reports_form'); ?>">
                        <i class="menu-icon mdi mdi-file-document"></i>
                        <span class="menu-title">
                            <?= $module['module_name'] ?>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Managment Modeule -->
        <?php foreach ($modules as $module): ?>
            <?php
            $moduleID = $module['id'];
            $isManagementModule = $module['module_name'] === 'Managment';
            $canView = $isManagementModule && isset($modulePermissions[$moduleID]['can_view']) && $modulePermissions[$moduleID]['can_view'];
            ?>

            <?php if ($canView): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Managment_form'); ?>">
                        <i class="menu-icon mdi mdi-floor-plan"></i>
                        <span class="menu-title">
                            <?= $module['module_name'] ?>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php foreach ($modules as $module): ?>
            <?php
            $moduleID = $module['id'];

            $isRegisterBusinessModule = $module['module_name'] === 'Register Business';

            $canView = $isRegisterBusinessModule && isset($modulePermissions[$moduleID]['can_view']) && $modulePermissions[$moduleID]['can_view'];
            ?>

            <?php if ($canView): ?>
                <li class="nav-item nav-category">
                    <?= $module['module_name'] ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-<?= $moduleID ?>" aria-expanded="false"
                        aria-controls="ui-basic-<?= $moduleID ?>">
                        <i class="menu-icon mdi mdi-floor-plan"></i>
                        <span class="menu-title">
                            <?= $module['module_name'] ?>
                        </span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic-<?= $moduleID ?>">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('user_form'); ?>">
                                    <?= $module['module_name'] ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('business_table'); ?>">View
                                    <?= $module['module_name'] ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

    </ul>


    <!-- <div class="Version"
        style="text-align: center; font-size: small; font-family: monospace; color: #021326; border-top: #f1e2e2 solid; border-width: thin;">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center" style="margin: 4rem;"> Version
                : 1.0</span>
        </div>
    </div> -->

</nav>