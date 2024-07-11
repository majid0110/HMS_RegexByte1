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
    <link rel="stylesheet" href="<?= base_url('public/assets/vendors_s/select2/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/vendors_s/select2-bootstrap-theme/select2-bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/vendors_s/bootstrap/css/bootstrap.min.css') ?>">
</head>

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

                                        <span style=" font-family: fantasy;font-size: larger; color: <?= $ServiceDetails[0]['Notes'] === 'Cancelled' ? 'red' : 'green'; ?>"> <?= $ServiceDetails[0]['Notes']; ?></span>

                                      


                                        <a href="<?= base_url('SalesController/cancelInvoice/' . $ServiceDetails[0]['idReceipts']); ?>"
                                            class="btn btn-danger text-white me-0" style="margin-left: 48%;">
                                            Cancel
                                        </a>
<!-- 
                                        <a href="<?= base_url('correctInvoice/' . $ServiceDetails[0]['idReceipts']); ?>"
                                            class="btn btn-info text-white me-0"
                                            style="margin-left: 10px; height: 1.6rem; padding: 0%; width: 6rem; font-size: medium; background: #17a2b8;">
                                            Correct
                                        </a> -->

                                        <a href="#" class="btn btn-primary text-white me-0" data-toggle="modal"
                                            data-target="#correctModal">
                                            Correct
                                        </a>


                                        <!-- <a href="<?= base_url('SalesController/downloadPDF/' . $ServiceDetails[0]['idReceipts']); ?>"
                                            class="btn btn-primary">Download PDF</a> -->

                                        <a href="<?= base_url('SalesController/downloadPDF/' . $ServiceDetails[0]['idReceipts']); ?>"
                                            class="btn btn-primary text-white me-0"><i
                                                class="icon-File"></i>
                                            Download PDF</a>

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


                                        <?php if ($ServiceDetails[0]['Status'] == 'open'): ?>
                                           
                                            <!-- <button type="button" style="margin-top: -3rem;margin-left: 89%;"
                                                class="btn btn-primary" data-toggle="modal" data-target="#payModal"
                                                onclick="loadPayInvoice('<?= $ServiceDetails[0]['invOrdNum']; ?>')">Pay</button> -->

                                                <button type="button" style="margin-top: -3rem;margin-left: 89%;" class="btn btn-primary" data-toggle="modal" data-target="#serviceDetailsModal">Pay</button>
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
                                                    <div class="reference-invoices" style="margin-top: 0px ;">
                                                        <table class="table" style = "width: 20px;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Receipt Reference</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (!empty($referenceInvoices)): ?>
                                                                    <?php foreach ($referenceInvoices as $reference): ?>
                                                                        <tr>
                                                                            <td style="padding:0%;">Reference Invoice#<a href="<?= base_url('viewServiceDetails/' . $reference['idReceipt']); ?>" class="btn btn-link"  target="_blank">
                                                                                <?= $reference['idReceipt']; ?>
                                                                            <i class="mdi mdi-open-in-new"></i></a></td>
                           
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <tr>
                                                                        <td colspan="3">No reference invoices found.</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
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
                                <?php
                                $total = 0;
                                foreach ($ServiceDetails as $detail) {
                                    $total += $detail['Price'] * $detail['Quantity'];
                                }
                                ?>

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
                                    <td>Total: <?= $total; ?></td>
                                </tr>

                            </table>
                            <h3>Payment Records</h3>
                            <table cellpadding="0" cellspacing="0">
                                <tr class="heading">
                                    <td>ID Payment</td>
                                    <td>Value</td>
                                    <td>Date</td>
                                    <td>Method</td>
                                    <td>Currency</td>
                                    <td>Exchange</td>

                                </tr>
                                <?php foreach ($PaymentDetails as $payment): ?>
                                    <tr class="item">
                                        <td>
                                            <?= $payment['idPayment']; ?>
                                        </td>
                                        <td>
                                            <?= $payment['value']; ?>
                                        </td>
                                        <td>
                                            <?= $payment['date']; ?>
                                        </td>
                                        <td>
                                            <?= $payment['PaymentMethodName']; ?>
                                        </td>
                                        <td>
                                            <?= $payment['Currency']; ?>
                                        </td>
                                        <td>
                                            <?= $payment['exchange']; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </table>

                            <div class="modal fade" id="serviceDetailsModal" tabindex="-1" role="dialog" aria-labelledby="serviceDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceDetailsModalLabel">Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="pt-3" method="POST" action="<?= base_url('Payment') ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col">
                                <label>Value to Pay</label>
                                <div>
                                    <input type="text" class="form-control" name="valueToPay" value="<?= isset($valueToPay) ? $valueToPay : '' ?>" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <label>Value</label>
                                <div>
                                    <input class="typeahead form-control" type="number" name="Value" placeholder="Value">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Currency</label>
                                <div id="the-basics">
                                    <select class="typeahead form-control" name="Currency">
                                        <?php foreach ($currencies as $currency): ?>
                                            <option value="<?= $currency['id'] ?>"><?= $currency['Currency'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label>Payment Method</label>
                                <div id="the-basics">
                                    <select class="typeahead form-control" name="Payment">
                                        <?php foreach ($payments as $payment): ?>
                                            <option value="<?= $payment['idPaymentMethods'] ?>" data-payment-id="<?= $payment['idPaymentMethods'] ?>"><?= $payment['Method'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Exchange</label>
                                <div id="bloodhound">
                                    <input class="typeahead form-control" type="number" name="exchange" value='1.0' id="exchangeInput" placeholder="Exchange Rate">
                                </div>
                            </div>
                            <div class="col">
                                <input type="hidden" name="client" class="form-control" value="<?= isset($client) ? $client : '' ?>" readonly>
                            </div>
                        </div>
                        <input type="hidden" name="idReceipts" value="<?= isset($idReceipts) ? $idReceipts : '' ?>">

                        <div class="row" style="margin-top: 1rem;">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Pay</button>
                            </div>
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
        <!-- content-wrapper ends -->
        <!-- partial:./public/assets/partials/_footer.html -->
        <?php include 'include_common/footer.php'; ?>
        <!-- partial -->
    </div>

    <!-- Correct Modal -->
    <div class="modal fade" id="correctModal" tabindex="-1" role="dialog" aria-labelledby="correctModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="correctModalLabel">Correct Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="correctInvoiceForm" action="<?= base_url('SalesController/UpdateInvoice'); ?>"
                        method="post">
                        <input type="hidden" name="invoiceId" value="<?= $ServiceDetails[0]['idReceipts']; ?>">

                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client">Client</label>
                                    <select class="form-control" id="client" name="client" required>
                                        <?php foreach ($clients as $client): ?>
                                            <option value="<?= $client['idClient']; ?>" <?= $client['idClient'] == $ServiceDetails[0]['idClient'] ? 'selected' : ''; ?>>
                                                <?= $client['client']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="currency">Currency</label>
                                        <select class="form-control" id="currency" name="currency" required>
                                            <?php foreach ($currencies as $currency): ?>
                                                <option value="<?= $currency['id']; ?>" <?= $currency['Currency'] == $ServiceDetails[0]['Currency'] ? 'selected' : ''; ?>>
                                                    <?= $currency['Currency']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="invoiceDate">Invoice Date</label>
                                    <input type="date" class="form-control" id="invoiceDate" name="invoiceDate"
                                        value="<?= (new DateTime($ServiceDetails[0]['InvoiceDate']))->format('Y-m-d'); ?>"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="paymentMethod">Payment Method</label>
                                        <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                                            <?php foreach ($payments as $method): ?>
                                                <option value="<?= $method['idPaymentMethods']; ?>" <?= $method['Method'] == $ServiceDetails[0]['PaymentMethod'] ? 'selected' : ''; ?>>
                                                    <?= $method['Method']; ?>
                                                </option>
                                            <?php endforeach; ?>    
                                        </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="notes"
                                ><?= $ServiceDetails[0]['Notes']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <h4>Service Details</h4>
                            <button type="button" class="btn btn-primary" id="addRowBtn">+</button>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Service Type</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($ServiceDetails as $index => $detail): ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="ServiceDetails[<?= $index; ?>][idArtMenu]" value="<?= $detail['idArtMenu']; ?>">
                                            <input type="text" class="form-control" id="serviceType_<?= $index; ?>"
                                            value="<?= $detail['ServiceTypeName']; ?>" readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="quantity_<?= $index; ?>"
                                            name="ServiceDetails[<?= $index; ?>][Quantity]"
                                            value="<?= $detail['Quantity']; ?>" required
                                            oninput="calculateTotalValue()">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="price_<?= $index; ?>"
                                            name="ServiceDetails[<?= $index; ?>][Price]"
                                            value="<?= $detail['Price']; ?>" required
                                            oninput="calculateTotalValue()">
                                        </td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <label for="totalValue">Value:</label>
                                    <input type="text" class="form-control" name="totalValue" id="totalValue" readonly>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </form>

                </div>


            </div>
        </div>
    </div>


    <script>
document.addEventListener('DOMContentLoaded', function() {
    function calculateTotalValue() {
        let totalValue = 0;
        document.querySelectorAll('input[name^="ServiceDetails"][name$="[Quantity]"]').forEach((quantityInput, index) => {
            let priceInput = document.querySelector(`input[name="ServiceDetails[${index}][Price]"]`);
            let quantity = parseFloat(quantityInput.value) || 0;
            let price = parseFloat(priceInput.value) || 0;
            totalValue += quantity * price;
        });
        document.getElementById('totalValue').value = totalValue.toFixed(2);
    }

    document.getElementById('addRowBtn').addEventListener('click', function() {
        var tableBody = document.querySelector('#correctModal table tbody');
        var rowCount = tableBody.rows.length;
        var newRow = tableBody.insertRow();

        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);

        cell1.innerHTML = `<input type="hidden" name="ServiceDetails[${rowCount}][idArtMenu]" value="">
                           <select class="form-control" id="serviceType_${rowCount}" name="ServiceDetails[${rowCount}][ServiceTypeName]" required>
                               <?php foreach ($services as $service): ?>
                                   <option value="<?= $service['idArtMenu']; ?>"><?= $service['Name']; ?></option>
                               <?php endforeach; ?>
                           </select>`;
        cell2.innerHTML = `<input type="number" class="form-control" id="quantity_${rowCount}" name="ServiceDetails[${rowCount}][Quantity]" required>`;
        cell3.innerHTML = `<input type="number" class="form-control" id="price_${rowCount}" name="ServiceDetails[${rowCount}][Price]" required>`;

        newRow.querySelector('input[name^="ServiceDetails"][name$="[Quantity]"]').addEventListener('input', calculateTotalValue);
        newRow.querySelector('input[name^="ServiceDetails"][name$="[Price]"]').addEventListener('input', calculateTotalValue);
    });

    calculateTotalValue();

    function loadCorrectInvoice(invOrdNum) {
        $('#correctInvoiceContent').load('/HMS_RegexByte/CorrectInvoice?invOrdNum=' + invOrdNum);
    }

    $(document).on('click', '[data-target="#correctModal"]', function () {
        var invOrdNum = '<?= $ServiceDetails[0]['invOrdNum']; ?>';
        loadCorrectInvoice(invOrdNum);
    });

    document.querySelectorAll('input[name^="ServiceDetails"]').forEach(input => {
        input.addEventListener('input', calculateTotalValue);
    });
});
</script>





    <!-- <script>
document.getElementById('addRowBtn').addEventListener('click', function() {
    var tableBody = document.querySelector('#correctModal table tbody');
    var rowCount = tableBody.rows.length;
    var newRow = tableBody.insertRow();

    var cell1 = newRow.insertCell(0);
    var cell2 = newRow.insertCell(1);
    var cell3 = newRow.insertCell(2);

    cell1.innerHTML = `<input type="hidden" name="ServiceDetails[${rowCount}][idArtMenu]" value="">
                       <select class="form-control" id="serviceType_${rowCount}" name="ServiceDetails[${rowCount}][ServiceTypeName]" required>
                           <?php foreach ($services as $service): ?>
                               <option value="<?= $service['idArtMenu']; ?>"><?= $service['Name']; ?></option>
                           <?php endforeach; ?>
                       </select>`;
    cell2.innerHTML = `<input type="number" class="form-control" id="quantity_${rowCount}" name="ServiceDetails[${rowCount}][Quantity]" required oninput="calculateTotalValue()">`;
    cell3.innerHTML = `<input type="number" class="form-control" id="price_${rowCount}" name="ServiceDetails[${rowCount}][Price]" required oninput="calculateTotalValue()">`;
});
</script>



    <script>
        function calculateTotalValue() {
            var totalValue = 0;
            <?php foreach ($ServiceDetails as $index => $detail): ?>
                var quantity = parseFloat(document.getElementById('quantity_<?= $index; ?>').value) || 0;
                var price = parseFloat(document.getElementById('price_<?= $index; ?>').value) || 0;
                totalValue += quantity * price;
            <?php endforeach; ?>
            document.getElementById('totalValue').value = totalValue.toFixed(2);
        }

        window.onload = function() {
            calculateTotalValue();
        };
    </script> -->

<script>
    $(document).ready(function() {
        // Assuming you have a way to trigger this modal
        $('#payModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var invOrdNum = button.data('invordnum'); // Extract info from data-* attributes

            // If necessary, you can make an AJAX call to fetch additional data based on invOrdNum
            // and populate the modal form fields. Since we're not using AJAX here, this is just an example:
            /*
            $.ajax({
                url: '<?= base_url("getInvoiceDetails"); ?>',
                method: 'POST',
                data: { invOrdNum: invOrdNum },
                success: function(response) {
                    $('#valueToPay').val(response.valueToPay);
                    // Populate other fields as necessary
                }
            });
            */
        });
    });
</script>


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


<!-- <script>
        function loadCorrectInvoice(invOrdNum) {
            $('#correctInvoiceContent').load('/HMS_RegexByte/CorrectInvoice?invOrdNum=' + invOrdNum);
        }

        $(document).on('click', '[data-target="#correctModal"]', function () {
            var invOrdNum = '<?= $ServiceDetails[0]['invOrdNum']; ?>';
            loadCorrectInvoice(invOrdNum);
        });
    </script> -->

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
    <script src="<?= base_url('public/assets/vendors_s/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url('public/assets/vendors_s/typeahead.js/typeahead.bundle.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/vendors_s/select2/select2.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/vendors_s/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/vendors_s/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/js_s/off-canvas.js') ?>"></script>
    <script src="<?= base_url('public/assets/js_s/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url('public/assets/js_s/template.js') ?>"></script>
    <script src="<?= base_url('public/assets/js_s/settings.js') ?>"></script>
    <script src="<?= base_url('public/assets/js_s/todolist.js') ?>"></script>
    <script src="<?= base_url('public/assets/js_s/file-upload.js') ?>"></script>
    <script src="<?= base_url('public/assets/js_s/typeahead.js') ?>"></script>
    <script src="<?= base_url('public/assets/js_s/select2.js') ?>"></script>

</body>


<!-- Mirrored from demo.bootstrapdash.com/star-admin2-free/template/pages/tables/basic-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2024 05:42:35 GMT -->

</html>