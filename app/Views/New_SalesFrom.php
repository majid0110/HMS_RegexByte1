<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Management</title>
    <link rel="stylesheet" href="./public/assets/css_s/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="./public/assets/images_s/regexbyte.png" />

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        .body {
            background-color: #007bff;
        }

        .selected-item,
        .selected-category {
            background-color: blue !important;
            color: white !important;
        }

        .table-container {
            height: 300px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        #serviceTable {
            width: 100%;
            border-collapse: collapse;
        }

        #serviceTable th,
        #serviceTable td {
            padding: 10px;
            text-align: left;
        }

        .left-side {
            display: flex;
            flex-direction: row;
            width: 50%;
        }

        .search-container button {
            padding: 5px 10px;
            border: none;
            background-color: #00b5ad;
            color: white;
            border-radius: 5px;
        }

        .search-container {
            width: 100%;
            max-height: 300px;
            margin-left: 15px;
        }

        .search-container input {
            width: calc(100% - 110px);
            padding: 5px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .item-list-container {
            width: 95%;
            margin-top: 10px;
            overflow-y: auto;
        }

        .item-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            height: 255px;
        }

        .item {
            width: 31%;
            height: 6rem;
            box-sizing: border-box;
            padding: 3px;
            font-size: small;
            background-color: whitesmoke;
            border: 1px solid #ddd;
            text-align: center;
            margin-right: 9px;
            margin-bottom: 8px;
            border-radius: 15px;
            cursor: pointer;
        }

        .container-fluid {
            padding: 20px;
        }

        .top-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .Newsidebar {
            width: 35%;
            max-height: 300px;
        }

        .dropdown-buttons {
            height: 300px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            /* Distributes space evenly */
            align-items: center;
            /* Vertically centers items */
            margin-bottom: 10px;
            /* Adds space between rows if needed */
        }

        .form-row .col {
            flex: 1;
            /* Allows columns to grow and shrink */
            margin-right: 10px;
            /* Space between columns */
        }

        .form-row .col:last-child {
            margin-right: 0;
            /* Removes margin from the last column */
        }

        .form-row label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            /* Space between label and input */
        }


        .dropdown-button {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            margin: 5px;
            width: calc(100% - 10px);
            background-color: #f9f9f9;
            cursor: pointer;
            overflow-x: hidden;
        }

        .dropdown-button:hover {
            background-color: #f0f0f0;
        }

        .Newsidebar button {
            width: 95%;
            margin-bottom: 6px;
            background-color: whitesmoke;
            border: none;
            padding: 8px;
            border-radius: 5px;
        }

        .content {
            display: flex;
            justify-content: space-between;
        }

        .top-row {
            display: flex;
            margin-bottom: 10px;
        }

        .top-row .dropdown-container {
            flex: 1;
            margin-right: 10px;
        }

        .top-row .search-container {
            flex: 3;
            display: flex;
            align-items: center;
        }

        .top-row .search-container input {
            flex: 1;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
        }

        .top-row .search-container button {
            border: none;
            background-color: #00b5ad;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .right-side {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* .table-container {
            margin-bottom: 20px;
        } */

        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .form-row select,
        .form-row input {
            flex: 1;
            margin-left: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
        }

        .invoice-info {
            background-color: #172D88;
            color: cornsilk;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            /* flex: 1; */
            width: 60%;
            height: -webkit-fill-available;
        }

        .invoice-info p {
            /* font-family: fantasy; */
            font-width: 900;
            font-size: larger;
        }

        .invoice-info div {
            margin-bottom: 10px;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 40%;
        }

        .buttons .btn {
            flex: 1;
            margin: 0 5px;
        }
    </style>
</head>

<body
    style="background-image: url('<?= $baseURL ?>uploads/defaults/bg2.jpg');  background-repeat: no-repeat; background-size: cover;">

    <div class="container-fluid">
        <div class="content">
            <div class="left-side">
                <div class="Newsidebar">
                    <div class="dropdown-buttons">
                        <?php foreach ($categories as $category): ?>
                            <button class="dropdown-button"
                                value="<?= $category['idCatArt']; ?>"><?= $category['name']; ?></button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="search-container">
                    <div>
                        <input type="text" placeholder="Search...">
                        <button>Search</button>
                    </div>
                    <div class="item-list-container">
                        <div class="item-list">
                            <?php foreach ($services as $service):
                                $businessID = session()->get('businessID');
                                $serviceExpiries = $salesModel->getServiceExpiry($service['idArtMenu'], $businessID);
                                ?>
                                <div class="item" data-service-id="<?= $service['idArtMenu']; ?>"
                                    data-service-price="<?= $service['Price']; ?>"
                                    data-service-tax="<?= $service['idTVSH']; ?>"
                                    data-has-expiry="<?= count($serviceExpiries) > 0 ? '1' : '0' ?>">
                                    <div style="font-weight: bolder;"><?= $service['Name']; ?></div>
                                    <div style="margin-bottom:auto; font-size: small;"><?= $service['Price']; ?> pkr</div>
                                    <?php if (count($serviceExpiries) > 0): ?>
                                        <select class="expiry-dropdown" style="display:none;">
                                            <option value="">Select Expiry</option>
                                            <?php foreach ($serviceExpiries as $expiry): ?>
                                                <option value="<?= $expiry['expiryDate'] ?>">
                                                    <?= date('Y-m-d', strtotime($expiry['expiryDate'])) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="right-side">
                <div class="table-container">
                    <table class="table table-bordered" id="serviceTable">
                        <thead style="background: #172D88;color: cornsilk;">
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Discount</th>
                                <th>Tax</th>
                                <?php if ($isExpiry == 1): ?>
                                    <th>Expiry</th>
                                <?php endif; ?>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="serviceTableBody">
                        </tbody>
                    </table>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="clientId">Client Name</label>
                        <div class="input-group">
                            <select class="form-control select2" name="clientName" id="clientId">
                                <?php foreach ($client_names as $client): ?>
                                    <option value="<?= $client['idClient']; ?>">
                                        <?= $client['clientUniqueId']; ?> - <?= $client['client']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary text-white" type="button" data-toggle="modal"
                                    data-target="#expenseModal"
                                    style="padding: 0; line-height: 1; width: 58px; height: 32px; margin-left: -2px; font-size: x-large;">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <label for="paymentMethod">Payment Method</label>
                        <div id="the-basics">
                            <select class="typeahead form-control" name="Payment" id="paymentMethod">
                                <?php foreach ($payments as $payment): ?>
                                    <option value="<?= $payment['idPaymentMethods']; ?>"
                                        data-payment-id="<?= $payment['idPaymentMethods']; ?>">
                                        <?= $payment['Method']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <label for="currency">Currency</label>
                        <div id="the-basics">
                            <select class="typeahead form-control" name="Currency" id="currency">
                                <?php foreach ($currencies as $currency): ?>
                                    <option value="<?= $currency['id']; ?>">
                                        <?= $currency['Currency']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <label for="exchangeInput">Exchange</label>
                        <div id="bloodhound">
                            <input class="typeahead form-control" type="number" name="exchange" value="1.0"
                                id="exchangeInput" placeholder="Exchange Rate">
                        </div>
                    </div>
                </div>


                <div class="top-row">
                    <div class="invoice-info">
                        <p>Total Fee: <span id="totalFee">0</span></p>
                        <p>Discount: <span id="discountAmount">0</span></p>
                        <p>Tax: <span id="taxAmount">0</span></p>
                        <p>Discounted Total: <span id="discountedTotal">0</span></p>
                    </div>
                    <div class="buttons">
                        <button class="btn btn-danger">Back</button><br>
                        <button class="btn btn-success" id="invoiceBtn">Invoice</button><br>
                        <button class="btn btn-primary" id="insertBtn">Invoice & Pay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="expenseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="expenseModalLabel">Add Cient</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="pt-3" method="POST" action="<?php echo base_url() . "saveClientfromSales"; ?>"
                        enctype="multipart/form-data">
                        <p class="card-description">
                            Personal info
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Client Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="cName" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Client Contact</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="cphone" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Identification Type</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="idType" />
                                        <option>CNIC</option>
                                        <option>Passport</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Client CNIC</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="CNIC" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" name="cemail">Client Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="cemail" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" name="gender">Gender</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="gender" required />
                                        <option>Male</option>
                                        <option>Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" name="age">Client Age</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="age" />
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
                                    <label class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="cstatus" required>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Def</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="cdef" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Limit Expense</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="expense" Value="0.0" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Discount</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" Value="0.0" name="discount" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <!-- <label class="col-sm-3 col-form-label">Main Client</label>  -->
                                    <!-- <div class="col-sm-9"> -->
                                    <input type="checkbox" class="form-check-input" name="mclient"
                                        style="    margin-left: 9rem; display=flex">
                                    <span style="margin-left: 11rem;margin-top: -19px;">Main Client</span>
                                    </input>
                                    <!-- <label class="col-sm-3 col-form-label">Main Client</label>  -->
                                </div>
                                <!-- </div> -->
                            </div>
                        </div>


                        <p class="card-description">
                            Address Details
                        </p>
                        <div class="row">
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
                                    <label class="col-sm-3 col-form-label">State</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name='state'>
                                            <option>Pakistan</option>
                                            <option>Others</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Code</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="code" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add a submit button -->
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var isExpiry = <?php echo json_encode($isExpiry); ?>;
        function calculateTotals() {
            var totalFee = 0;
            var totalDiscount = 0;
            var totalTax = 0;

            $('#serviceTableBody tr').each(function () {
                var price = parseFloat($(this).find('.editable-price').text()) || 0;
                var quantity = parseInt($(this).find('.editable-quantity').val()) || 0;
                var discount = parseFloat($(this).find('.editable-discount').val()) || 0;
                var taxRate = parseFloat($(this).find('.tax-rate').text()) || 0;
                var expiryDate = $(this).find('.expiry-date').val();

                var rowTotal = price * quantity;
                var rowDiscount = rowTotal * (discount / 100);
                var rowTaxableAmount = rowTotal - rowDiscount;
                var rowTax = rowTaxableAmount * (taxRate / 100);

                totalFee += rowTotal;
                totalDiscount += rowDiscount;
                totalTax += rowTax;
            });

            var discountedTotal = totalFee - totalDiscount + totalTax;

            $('#totalFee').text(totalFee.toFixed(2));
            $('#discountAmount').text(totalDiscount.toFixed(2));
            $('#taxAmount').text(totalTax.toFixed(2));
            $('#discountedTotal').text(discountedTotal.toFixed(2));
        }



        $(document).ready(function () {

            function addServiceRow(serviceId, serviceName, servicePrice, serviceTax, expiryHtml) {
                var rowHtml = `
            <tr data-service-id="${serviceId}">
                <td>${serviceName}</td>
                <td contenteditable="true" class="editable-price">${servicePrice}</td>
                <td><input type="number" class="editable-quantity" value="1" min="1"></td>
                <td><input type="number" class="editable-discount" value="0" min="0" max="100"></td>
                <td class="tax-rate">${serviceTax}</td>
                ${expiryHtml ? `<td>${expiryHtml}</td>` : '<td>-</td>'}
                <td><button class="delete-button">Delete</button></td>
            </tr>`;

                $('#serviceTableBody').append(rowHtml);
                calculateTotals();
            }

            $(document).off('click', '.item').on('click', '.item', function () {
                $(this).toggleClass('selected-item');

                var serviceId = $(this).data('service-id');
                var serviceName = $(this).find('div:first').text();
                var servicePrice = $(this).data('service-price');
                var serviceTax = $(this).data('service-tax');
                var hasExpiry = $(this).data('has-expiry') === 1;
                var expiryHtml = hasExpiry ? $(this).find('.expiry-dropdown').clone().show().prop('outerHTML') : '-';

                var existingRow = $(`#serviceTableBody tr[data-service-id="${serviceId}"]`);

                if (existingRow.length > 0) {
                    alert(`This item (ID: ${serviceId}) is already added.`);
                } else {
                    addServiceRow(serviceId, serviceName, servicePrice, serviceTax, expiryHtml);
                }
            });


            $('#serviceTableBody').on('click', '.delete-button', function () {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            $('#serviceTableBody').on('input', '.editable-price, .editable-quantity, .editable-discount', function () {
                calculateTotals();
            });

            $('#serviceTableBody').on('blur', '.editable-price', function () {
                calculateTotals();
            });

            $('#insertBtn').off('click').on('click', function () {
                insertData();
            });

            $('#invoiceBtn').off('click').on('click', function () {
                submitInvoice();
            });

            $('.category-tab').click(function () {
                $('.category-tab').removeClass('selected-category');
                $(this).addClass('selected-category');
            });

            $('.dropdown-button').click(function () {
                $(this).addClass('selected-category');
                var categoryId = $(this).val();
                filterServices(categoryId);
            });

            function filterServices(categoryId) {
                $.ajax({
                    url: '<?php echo base_url() . "newSalesController/filterServices"; ?>',
                    type: 'POST',
                    data: { categoryId: categoryId },
                    dataType: 'html',
                    success: function (data) {
                        $('.item-list').html(data);
                        attachItemHandlers();
                    },
                    error: function (xhr, status, error) {
                        console.error("An error occurred: " + error);
                    }
                });
            }

            // function attachItemHandlers() {
            //     $('.item').click(function () {
            //         var serviceId = $(this).data('service-id');
            //         var serviceName = $(this).find('div:first').text();
            //         var servicePrice = $(this).data('service-price');
            //         var serviceTax = $(this).data('service-tax');

            //         addServiceRow(serviceId, serviceName, servicePrice, serviceTax);
            //     });
            // }
            // attachItemHandlers();

            function insertData() {
                var clientId = $('select[name="clientName"]').val();
                var clientName = $('select[name="clientName"] option:selected').text();
                var paymentMethodOption = $('select[name="Payment"] option:selected');
                var paymentMethodId = paymentMethodOption.data('payment-id');
                var paymentName = paymentMethodOption.text();
                var paymentMethodName = paymentMethodOption.text();
                var currency = $('select[name="Currency"]').val();
                var currencyName = $('select[name="Currency"] option:selected').text();
                var exchange = $('#exchangeInput').val();
                var totalFee = parseFloat($('#totalFee').text());
                var totalTax = parseFloat($('#taxAmount').text());

                if (!clientId || isNaN(totalFee)) {
                    alert('Invalid data for insertion.');
                    return;
                }

                var services = [];
                $('#serviceTableBody tr').each(function () {
                    var serviceTypeRow = $(this);
                    var serviceTypeId = serviceTypeRow.data('service-id');
                    var serviceName = serviceTypeRow.find('td:eq(0)').text();
                    var fee = parseFloat(serviceTypeRow.find('.editable-price').text());
                    var quantity = parseInt(serviceTypeRow.find('.editable-quantity').val());
                    var discount = parseFloat(serviceTypeRow.find('.editable-discount').val());
                    var taxRate = parseFloat(serviceTypeRow.find('.tax-rate').text());
                    // var expiryDate = '1970-01-01';
                    // var expiryDate = serviceTypeRow.find('.expiry-date').val();
                    var expiryDate = serviceTypeRow.find('.expiry-dropdown').val() || serviceTypeRow.find('.expiry-date').val() || null;

                    var rowTotal = fee * quantity;
                    var rowDiscount = rowTotal * (discount / 100);
                    var rowTaxableAmount = rowTotal - rowDiscount;
                    var calculatedTax = rowTaxableAmount * (taxRate / 100);

                    services.push({
                        serviceTypeId: serviceTypeId,
                        serviceName: serviceName,
                        fee: fee,
                        quantity: quantity,
                        discount: discount,
                        expiryDate: expiryDate,
                        taxRate: taxRate,
                        calculatedTax: calculatedTax
                    });
                });

                console.log(services);
                $.ajax({
                    method: 'POST',
                    url: '<?= site_url('SalesController/submitServices') ?>',
                    dataType: "json",
                    data: {
                        clientId: clientId,
                        clientName: clientName,
                        currencyName: currencyName,
                        paymentMethodId: paymentMethodId,
                        paymentName: paymentName,
                        paymentMethodName: paymentMethodName,
                        currency: currency,
                        exchange: exchange,
                        totalFee: totalFee,
                        totalTax: totalTax,
                        services: services
                    },
                    success: function (response) {
                        console.log('Data inserted successfully:', response);
                        if (response.pdfContent) {
                            var decodedPdfContent = atob(response.pdfContent);
                            var blob = new Blob([new Uint8Array(decodedPdfContent.split('').map(function (c) {
                                return c.charCodeAt(0);
                            }))], {
                                type: 'application/pdf'
                            });
                            var link = document.createElement('a');
                            var url = window.URL.createObjectURL(blob);
                            link.href = url;
                            link.target = '_blank';
                            link.click();

                            setTimeout(function () {
                                window.URL.revokeObjectURL(url);
                            }, 100);
                        }
                        $('#serviceTableBody').empty();
                        $('#totalFee').text('0');
                        $('#discountAmount').text('0');
                        $('#taxAmount').text('0');
                        $('#discountedTotal').text('0');
                        calculateTotals();
                    },
                    error: function (error) {
                        console.error('Error inserting data:', error);
                    }
                });
            }
            function submitInvoice() {
                var clientId = $('select[name="clientName"]').val();
                var clientName = $('select[name="clientName"] option:selected').text();
                var paymentMethodOption = $('select[name="Payment"] option:selected');
                var paymentMethodId = paymentMethodOption.data('payment-id');
                var paymentName = paymentMethodOption.text();
                var paymentMethodName = paymentMethodOption.text();
                var currency = $('select[name="Currency"]').val();
                var currencyName = $('select[name="Currency"] option:selected').text();
                var exchange = $('#exchangeInput').val();
                var totalFee = parseFloat($('#totalFee').text());
                var totalTax = parseFloat($('#taxAmount').text());

                if (!clientId || isNaN(totalFee)) {
                    alert('Invalid data for insertion.');
                    return;
                }

                var services = [];
                $('#serviceTableBody tr').each(function () {
                    var serviceTypeRow = $(this);
                    var serviceTypeId = serviceTypeRow.data('service-id');
                    var serviceName = serviceTypeRow.find('td:eq(0)').text();
                    var fee = parseFloat(serviceTypeRow.find('.editable-price').text());
                    var quantity = parseInt(serviceTypeRow.find('.editable-quantity').val());
                    var discount = parseFloat(serviceTypeRow.find('.editable-discount').val());
                    var taxRate = parseFloat(serviceTypeRow.find('.tax-rate').text());
                    // var expiryDate = '1970-01-01';
                    // var expiryDate = serviceTypeRow.find('.expiry-date').val();
                    var expiryDate = serviceTypeRow.find('.expiry-dropdown').val() || serviceTypeRow.find('.expiry-date').val() || null;

                    var rowTotal = fee * quantity;
                    var rowDiscount = rowTotal * (discount / 100);
                    var rowTaxableAmount = rowTotal - rowDiscount;
                    var calculatedTax = rowTaxableAmount * (taxRate / 100);

                    services.push({
                        serviceTypeId: serviceTypeId,
                        serviceName: serviceName,
                        fee: fee,
                        quantity: quantity,
                        discount: discount,
                        expiryDate: expiryDate,
                        taxRate: taxRate,
                        calculatedTax: calculatedTax
                    });
                });

                console.log(services);
                $.ajax({
                    method: 'POST',
                    url: '<?= site_url('SalesController/submitInvoice') ?>',
                    dataType: "json",
                    data: {
                        clientId: clientId,
                        clientName: clientName,
                        currencyName: currencyName,
                        paymentMethodId: paymentMethodId,
                        paymentName: paymentName,
                        paymentMethodName: paymentMethodName,
                        currency: currency,
                        exchange: exchange,
                        totalFee: totalFee,
                        totalTax: totalTax,
                        services: services
                    },
                    success: function (response) {
                        console.log('Data inserted successfully:', response);
                        if (response.pdfContent) {
                            var decodedPdfContent = atob(response.pdfContent);
                            var blob = new Blob([new Uint8Array(decodedPdfContent.split('').map(function (c) {
                                return c.charCodeAt(0);
                            }))], {
                                type: 'application/pdf'
                            });
                            var link = document.createElement('a');
                            var url = window.URL.createObjectURL(blob);
                            link.href = url;
                            link.target = '_blank';
                            link.click();

                            setTimeout(function () {
                                window.URL.revokeObjectURL(url);
                            }, 100);
                        }
                        $('#serviceTableBody').empty();
                        $('#totalFee').text('0');
                        $('#discountAmount').text('0');
                        $('#taxAmount').text('0');
                        $('#discountedTotal').text('0');
                        calculateTotals();
                    },
                    error: function (error) {
                        console.error('Error inserting data:', error);
                    }
                });
            }
        });

    </script>


</body>

</html>