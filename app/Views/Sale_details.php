<?php include 'include_common/head1.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demo.bootstrapdash.com/star-admin2-free/template/pages/tables/basic-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2024 05:42:35 GMT -->

<head>
    <!-- <link rel="stylesheet" href="/public/assets/vendors_s/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="/public/assets/js_s/select.dataTables.min.css">
    <link rel="stylesheet" href="../public/assets/vendors_s/feather/feather.css">
    <link rel="stylesheet" href="../public/assets/vendors_s/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../public/assets/vendors_s/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../public/assets/vendors_s/typicons/typicons.css">
    <link rel="stylesheet" href="../public/assets/vendors_s/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../public/assets/vendors_s/css/vendor.bundle.base.css"> -->
    <!-- endinject -->

    <!-- inject:css -->
    <link rel="stylesheet" href="../public/assets/css_s/vertical-layout-light/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- endinject -->
    <!-- <link rel="shortcut icon" href="../public/assets/images_s/regexbyte.png" /> -->

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
            animation: blink 2s infinite;
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

        .invoice-box table tr.heading td {
            background: #eee;
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
                                            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#payModal" onclick="loadPayInvoice('<?= $ServiceDetails[0]['invOrdNum']; ?>')">Pay</button> -->
                                            <tr>
                                                <td class="title">
                                                      <?php
                                                      $session = session();
                                                      if ($session->has('businessProfileImage')) {
                                                          echo '<img class="img-xs rounded-circle larger-profile-img" style="width: 90px; height: 90px;" src="' . $session->get('businessProfileImage') . '" alt="Profile image">';
                                                      }
                                                      ?>
                                                    <style="width: 100%; max-width: 300px" />
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
                                            Status:
                                            <span
                                                style="color: <?= $ServiceDetails[0]['Status'] === 'closed' ? 'green' : 'red'; ?>"
                                                class="<?= $ServiceDetails[0]['Status'] === 'open' ? 'blinking' : ''; ?>">
                                                <?= $ServiceDetails[0]['Status']; ?>
                                            </span><br />
                                            Created: <?= (new DateTime($ServiceDetails[0]['InvoiceDate']))->format('F d, Y'); ?><br />
                                        </p>
                                        

                                        <?php if ($ServiceDetails[0]['Status'] == 'closed'): ?>
                                        <a
                                            href="<?= base_url('sales/deleteService/' . $ServiceDetails[0]['idReceipts']); ?>">

                                            <button onclick="deleteService()" type="button"
                                                class="btn btn-danger btn-icon"
                                                style="margin-left: 23rem;margin-left: 49rem; margin-top: -52px;">
                                                <i class="mdi mdi-delete"></i> 
                                            </button>
                                        </a>

                                            <?php else: ?>
                                                <button type="button" style="margin-top: -3rem;margin-left: 89%;" class="btn btn-primary" data-toggle="modal" data-target="#payModal" onclick="loadPayInvoice('<?= $ServiceDetails[0]['invOrdNum']; ?>')">Pay</button>
                                            <?php endif; ?>
                                    </td>
                                </tr>

                                <tr class="information">
                                    <td colspan="3">
                                        <table>
                                            <tr>
                                                <td>
                                                    <u><b>Invoice Details:</b></u><br />
                                                    Invoice #: <?= $ServiceDetails[0]['invOrdNum']; ?><br />
                                                    Due: <?= $ServiceDetails[0]['due']; ?><br />
                                                    Payment Method: <?= $ServiceDetails[0]['PaymentMethod']; ?><br />
                                                    Currency: <?= $ServiceDetails[0]['Currency']; ?><br />
                                                </td>
                                                <td>
                                                    <u><b>Client Details:</b></u><br />
                                                    Client: <?= $ServiceDetails[0]['client']; ?><br />
                                                    Contact: <?= $ServiceDetails[0]['contact']; ?><br />
                                                    Email: <?= $ServiceDetails[0]['email']; ?><br />
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
    <u><b>Notes:</b></u><br />
                                        <?= $ServiceDetails[0]['Notes']; ?><br />
                                    </td>
                                </tr>
                                <tr class="heading">
                                <td>Service Type</td>
                                <td>Quantity</td>
                                <td>Price</td>
                                
                            </tr>
                            <?php foreach ($ServiceDetails as $detail): ?>
                                        <tr class="item">
                                            <td>
                                                <?= $detail['ServiceTypeName']; ?>
                                                </td>
                                                <td>
                                                    <?= $detail['Quantity']; ?>
                                                </td>
                                                <td>
                                                    <?= $detail['Price']; ?>
                                                </td>
                                            </tr>
                                <?php endforeach; ?>
                                <tr class="total">
                                    <td></td>
                                    <td>Total: <?= $ServiceDetails[0]['Value']; ?></td>
                                </tr>
                            </table>

                            <!-- Modal -->
<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payModalLabel">Pay Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="payInvoiceContent"></div>
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
        <!-- partial:./public/assets/partials/_footer.html -->
        <?php include 'include_common/footer.php'; ?>
        <!-- partial -->
    </div>
    <script>
        function deleteService() {
            var idReceipts = <?= $ServiceDetails[0]['idReceipts']; ?>;

            fetch('/sales/deleteService/' + idReceipts)
                .then(response => {
                    if (response.ok) {
                        console.log('Service deleted successfully');
                        alert('Service deleted successfully');
                    } else {
                        console.error('Error deleting service:', error);
                        alert('Error deleting service');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
    
<script>
    function loadPayInvoice(invOrdNum) {
        $('#payInvoiceContent').load('/HMS_RegexByte/PayInvoice?invOrdNum=' + invOrdNum);
    }
</script>



    <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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