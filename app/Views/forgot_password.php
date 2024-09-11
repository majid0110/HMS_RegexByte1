<?php
$session = session();
if ($session->has('error')) {
?>
<?php
}
?>

<!-- Display flash messages for success -->
<?php
if ($session->has('success')) {
?>
<?php
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HMS RegexByte </title>
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
    <link rel="shortcut icon" href="./public/assets/images_s/regexbyte.png" />

    <style>
        .toast {
            position: fixed;
            top: 12rem;
            right: 25rem;
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
        <?php $successMessage = session()->getFlashdata('success');
        $errorMessage = session()->getFlashdata('error'); ?>
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="./public/assets/images/regexbyte.png" alt="logo">
                            </div>
                            <h4>Reset Password</h4>

                            <!-- forgot_password.php -->
                            <form method="POST" action="<?php echo base_url('forgot-password/send'); ?>">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Enter your email"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Reset Code</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="./public/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="./public/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
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
        });
    </script>
    <!-- endinject -->
</body>

</html>