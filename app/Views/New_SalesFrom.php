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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        #summaryInvoiceTable {
            width: 100%;
        }

        #summaryInvoiceTable th,
        #summaryInvoiceTable td {
            text-align: right;
        }

        #summaryInvoiceTable th:first-child,
        #summaryInvoiceTable td:first-child {
            text-align: left;
        }

        #summaryInvoiceTable tfoot {
            font-weight: bold;
        }

        .select2-dropdown.select2-dropdown--below {
            width: 190px !important;
        }

        .select2-selection__rendered {
            padding: unset !important;
            margin-left: -18px !important;
            margin-top: -13px !important;
            font-size: x-small !important;
        }

        .body {
            background-color: #007bff;
        }

        .table-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
            font-size: 0.9em;
        }

        .table-legend>div {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }

        .table-legend span {
            margin-right: 5px;
        }

        .table-list-container {
            padding-top: 2px;
            padding-left: 5px;
            width: 97%;
            margin-top: 10px;
            overflow-y: auto;
            height: 14rem;
        }

        .table-item.selected .selection-indicator {
            display: block !important;
            color: black !important;
            background: #747c7af7 !important;
        }

        .table-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            height: 255px;
        }

        .table-item {
            width: calc(33.33% - 10px);
            height: 6rem;
            box-sizing: border-box;
            padding: 3px;
            font-size: small;
            /* border: 1px solid #ddd; */
            text-align: center;
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
        }

        .table-item.selected::after {
            content: '✓';
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        .table-item.selectable {
            cursor: pointer;
        }

        .table-item.selectable:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .table-item.selected {
            box-shadow: 0 0 0 2px #007bff;
        }

        .table-item.unselectable {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .table-item[style*="border-color: red"] {
            border-width: 2px;
            border-style: solid;
        }

        .selected-item {
            background-color: blue !important;
            border-color: blue !important;
            color: white !important;
        }

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
            flex-direction: column;
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
            padding-top: 3px;
            padding-left: 5px;
            margin-top: 10px;
            overflow-y: auto;
        }

        .item-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            height: 255px;
        }

        .item {
            width: calc(33.33% - 10px);
            height: 6rem;
            box-sizing: border-box;
            padding: 3px;
            font-size: small;
            background-color: whitesmoke;
            border: 1px solid #ddd;
            text-align: center;
            border-radius: 15px;
            cursor: pointer;
        }



        .item:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
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
            height: 263px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-row .col {
            flex: 1;
            margin-right: 10px;
        }

        .form-row .col:last-child {
            margin-right: 0;
        }

        .form-row label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
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

        .right-side {
            flex: 1;
            display: flex;
            flex-direction: column;
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
            width: 60%;
            height: -webkit-fill-available;
        }

        .invoice-info p {
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

<body style="background: #153e4e47;  background-repeat: no-repeat; background-size: cover;">
    <div id="fullscreen-toggle" style="position: fixed; top: 0px; right: 5px; z-index: 9999; cursor: pointer;">
        <i class="fas fa-expand" style="font-size: 10px; color: #007bff;"></i>
    </div>
    <div class="container-fluid">
        <div class="content">
            <div class="left-side">
                <div class="top-row">
                    <div class="Newsidebar">
                        <div bis_skin_checked="1">
                            <button style="background: blue;" class="btn btn-primary"
                                onclick="window.history.back();">Back</button>
                        </div>
                        <div class="dropdown-buttons">
                            <?php foreach ($categories as $category): ?>
                                <button class="dropdown-button"
                                    value="<?= $category['idCatArt']; ?>"><?= $category['name']; ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="search-container">
                        <div>
                            <input type="text" class="search-input" placeholder="Search...">
                            <button class="search-button">Search</button>
                        </div>
                        <div class="item-list-container">
                            <div class="item-list">
                                <?php foreach ($services as $service):
                                    $businessID = session()->get('businessID');
                                    $serviceExpiries = $salesModel->getServiceExpiry($service['idArtMenu'], $businessID);
                                    ?>
                                    <div class="item" style="align-content: center;"
                                        data-service-id="<?= $service['idArtMenu']; ?>"
                                        data-service-price="<?= $service['Price']; ?>"
                                        data-service-tax-id="<?= $service['idTVSH']; ?>"
                                        data-service-tax-value="<?= $service['tax_value']; ?>"
                                        data-has-expiry="<?= count($serviceExpiries) > 0 ? '1' : '0' ?>">
                                        <div style="font-weight: bolder;"><?= $service['Name']; ?></div>
                                        <div style="margin-bottom:auto; font-size: small;"><?= $service['Price']; ?> pkr
                                        </div>
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
                <?php if ($isTable): ?>

                    <div class="tables-container" style="margin-top: 20px;">
                        <h4>Tables</h4>
                        <div class="table-list-container">
                            <div class="table-list">
                                <?php foreach ($tables as $table):
                                    $borderColor = $table['booking_status'] == 1 ? 'red' : '';
                                    $bgColor = $table['booking_status'] == 2 ? 'gray' : 'whitesmoke';
                                    $isSelectable = $table['booking_status'] == 2 ? 'unselectable' : 'selectable';
                                    ?>
                                    <div class="table-item <?= $isSelectable ?>"
                                        style="align-content: center; background-color: <?= $bgColor ?>; border-color: <?= $borderColor ?>;"
                                        data-table-id="<?= $table['idTables']; ?>">
                                        <div style="font-weight: bolder;"><?= $table['name']; ?></div>
                                        <div style="margin-bottom:auto; font-size: small;">Size: <?= $table['size']; ?></div>
                                        <div style="font-size: small;">Status: <?= $table['Status']; ?></div>
                                        <div class="selection-indicator"
                                            style="display: none; position: absolute; top: 5px; right: 5px; color: #007bff;">✓
                                        </div>
                                        <input type="radio" name="select_table" value="<?= $table['idTables'] ?>"
                                            style="display: none;">
                                    </div>
                                <?php endforeach; ?>


                            </div>
                        </div>
                        <div class="table-legend" style="margin-top: 10px;">
                            <div><span
                                    style="display: inline-block; width: 20px; height: 20px; background-color: whitesmoke; border: 1px solid #ccc;"></span>
                                Available</div>
                            <div><span
                                    style="display: inline-block; width: 20px; height: 20px; border: 2px solid red;"></span>
                                In Use (Selectable)</div>
                            <div><span
                                    style="display: inline-block; width: 20px; height: 20px; background-color: gray;"></span>
                                Unavailable</div>
                            <div><span
                                    style="display: inline-block; width: 20px; height: 20px; box-shadow: 0 0 0 2px #007bff; position: relative;">
                                    <span style="position: absolute; top: 0; right: 0; color: #007bff;">✓</span>
                                </span> Selected</div>
                        </div>
                    </div>
                <?php endif; ?>

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
                                        <?= $client['client']; ?>     <?= $client['contact']; ?>
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
                        <p>Without Tax: <span id="totalWithoutTax">0</span></p>
                        <p>Tax: <span id="taxAmount">0</span></p>

                        <p>Discounted Total: <span id="discountedTotal">0</span></p>
                    </div>
                    <div class="buttons">
                        <button class="btn btn-success" id="invoiceBtn">Invoice</button><br>
                        <button class="btn btn-primary" id="insertBtn">Invoice & Pay
                        </button><br>
                        <!-- <button class="btn btn-primary" id="orderBtn">Order</button> -->

                    </div>
                </div>
                <?php if ($isTable): ?>
                    <div>
                        <button class="btn btn-primary" id="orderBtn">Order</button>
                        <button class="btn btn-primary" id="summaryBtn">Summary Invoice</button>
                    </div>
                <?php endif; ?>
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
    <!-- ===================================================== -->
    <div class="modal fade" id="summaryInvoiceModal" tabindex="-1" role="dialog"
        aria-labelledby="summaryInvoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="summaryInvoiceModalLabel">Summary Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <p> Table Name :</p>
                        <table class="table table-bordered" id="summaryInvoiceTable">
                            <thead>
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Client ID</th>
                                    <th>User ID</th>
                                    <th>Value</th>
                                    <th>TVSH</th>
                                    <th>Table</th>
                                </tr>
                            </thead>
                            <tbody id="summaryInvoiceTableBody">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <th id="totalValue">0</th>
                                    <th id="totalTVSH">0</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="summaryPayBtn">PAY</button>
                </div>
            </div>
        </div>
    </div>

    <div id="loading-overlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border text-primary" role="status">
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#clientId').select2({
                placeholder: " ",
                allowClear: true
            });
        });
    </script>

    <script>
        var isExpiry = <?php echo json_encode($isExpiry); ?>;
        var isTable = <?php echo json_encode($isTable); ?>;


        function calculateTotals() {
            var totalFee = 0;
            var totalDiscount = 0;
            var totalTax = 0;
            var totalWithoutTax = 0;
            var discountedTotal = 0;

            $('#serviceTableBody tr').each(function () {
                var price = parseFloat($(this).find('.editable-price').text()) || 0;
                // var quantity = parseInt($(this).find('.editable-quantity').val()) || 0;
                var quantity = parseFloat($(this).find('.editable-quantity').val()) || 0;
                var discount = parseFloat($(this).find('.editable-discount').val()) || 0;
                var taxRate = parseFloat($(this).find('.tax-rate').text()) || 0;

                var rowTotal = price * quantity;
                var rowDiscountAmount = rowTotal * (discount / 100);
                var rowDiscountedTotal = rowTotal - rowDiscountAmount;

                var rowTaxAmount = rowDiscountedTotal * (taxRate / (100 + taxRate));
                var rowWithoutTax = rowDiscountedTotal - rowTaxAmount;

                totalFee += rowTotal;
                totalDiscount += rowDiscountAmount;
                totalTax += rowTaxAmount;
                totalWithoutTax += rowWithoutTax;
                discountedTotal += rowDiscountedTotal;

                $(this).data('calculatedTax', rowTaxAmount);
                $(this).data('rowTotal', rowTotal);
                $(this).data('rowDiscountAmount', rowDiscountAmount);
                $(this).data('rowDiscountedTotal', rowDiscountedTotal);
                $(this).data('rowWithoutTax', rowWithoutTax);
            });

            $('#totalFee').text(totalFee.toFixed(2));
            $('#discountAmount').text(totalDiscount.toFixed(2));
            $('#taxAmount').text(totalTax.toFixed(2));
            $('#totalWithoutTax').text(totalWithoutTax.toFixed(2));
            $('#discountedTotal').text(discountedTotal.toFixed(2));

            return {
                totalFee: totalFee,
                totalDiscount: totalDiscount,
                totalTax: totalTax,
                totalWithoutTax: totalWithoutTax,
                discountedTotal: discountedTotal
            };
        }

        function toggleFullScreen() {
            if (!document.fullscreenElement &&
                !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {  // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
                $('#fullscreen-toggle i').removeClass('fa-expand').addClass('fa-compress');
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                }
                $('#fullscreen-toggle i').removeClass('fa-compress').addClass('fa-expand');
            }
        }

        $(document).ready(function () {

            $('.search-input').on('keyup', function () {
                var searchTerm = $(this).val().toLowerCase();

                $('.item-list .item').each(function () {
                    var itemName = $(this).find('div:first').text().toLowerCase();
                    if (itemName.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            $('.search-button').on('click', function () {
                var searchTerm = $('.search-input').val().toLowerCase();

                $('.item-list .item').each(function () {
                    var itemName = $(this).find('div:first').text().toLowerCase();
                    if (itemName.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            function addServiceRow(serviceId, serviceName, servicePrice, serviceTax, expiryHtml) {
                var expiryColumn = isExpiry == 1 ? `<td>${expiryHtml}</td>` : '';
                var rowHtml = `
    <tr data-service-id="${serviceId}">
        <td>${serviceName}</td>
        <td contenteditable="true" class="editable-price">${servicePrice}</td>
        <td>
    <div class="quantity-input" style="display: flex;flex-direction: row;justify-content: space-evenly;">
        <span class="quantity-decrement btn btn-danger btn-sm" style="font-size: 17px;border-radius: 50%;">-</span>
      <input type="number" step="0.01" min="0.01" class="editable-quantity form-control quantity-box" style="width: 60px; padding: 2%;" value="1.00">
        <span class="quantity-increment btn btn-success btn-sm" style="border-radius: 50%; ">+</span>
    </div>
</td>
        <td><input type="number" class="editable-discount" value="0" min="0" max="100"></td>
        <td class="tax-rate" data-tax-id="${serviceTax.idTVSH}" data-tax-value="${serviceTax.value}">${serviceTax.value}%</td>
        ${expiryColumn}
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
                var serviceTax = {
                    idTVSH: $(this).data('service-tax-id'),
                    value: $(this).data('service-tax-value')
                };
                var hasExpiry = $(this).data('has-expiry') === 1;
                var expiryHtml = hasExpiry ? $(this).find('.expiry-dropdown').clone().show().prop('outerHTML') : '-';

                var existingRow = $(`#serviceTableBody tr[data-service-id="${serviceId}"]`);

                if (existingRow.length > 0) {
                    alert(`This item (ID: ${serviceId}) is already added.`);
                } else {
                    addServiceRow(serviceId, serviceName, servicePrice, serviceTax, expiryHtml);
                }
            });

            // $('#serviceTableBody').on('click', '.quantity-increment', function () {
            //     var input = $(this).siblings('.editable-quantity');
            //     var currentValue = parseFloat(input.val()) || 0;
            //     input.val((currentValue + 1).toFixed(2));
            //     calculateTotals();
            // });
            $('#serviceTableBody').on('click', '.quantity-increment', function () {
                var input = $(this).siblings('.editable-quantity');
                var currentValue = parseFloat(input.val()) || 0;
                input.val((currentValue + 0.01).toFixed(2));
                calculateTotals();
            });

            // $('#serviceTableBody').on('click', '.quantity-increment', function () {
            //     var input = $(this).siblings('.editable-quantity');
            //     var currentValue = parseFloat(input.val()) || 0;
            //     input.val((currentValue + 1).toFixed(2));
            //     calculateTotals();
            // });

            // $('#serviceTableBody').on('click', '.quantity-decrement', function () {
            //     var input = $(this).siblings('.editable-quantity');
            //     var currentValue = parseFloat(input.val()) || 0;
            //     if (currentValue > 0.01) {
            //         input.val((Math.max(currentValue - 1, 0.01)).toFixed(2));
            //         calculateTotals();
            //     }
            // });

            $('#serviceTableBody').on('click', '.quantity-decrement', function () {
                var input = $(this).siblings('.editable-quantity');
                var currentValue = parseFloat(input.val()) || 0;
                if (currentValue > 0.01) {
                    input.val((Math.max(currentValue - 0.01, 0.01)).toFixed(2));
                    calculateTotals();
                }
            });

            // $('#serviceTableBody').on('click', '.quantity-decrement', function () {
            //     var input = $(this).siblings('.editable-quantity');
            //     var currentValue = parseFloat(input.val()) || 0;
            //     if (currentValue > 1) {
            //         input.val((currentValue - 1).toFixed(2));
            //         calculateTotals();
            //     }
            // });

            $('#serviceTableBody').on('input', '.editable-quantity', function () {
                var inputValue = $(this).val();

                if (!/^[\d.]*$/.test(inputValue)) {
                    $(this).val(inputValue.replace(/[^\d.]/g, ''));
                }

                if ((inputValue.match(/\./g) || []).length > 1) {
                    $(this).val(inputValue.replace(/\.+$/, ''));
                }
            });

            $('#serviceTableBody').on('blur', '.editable-quantity', function () {
                var value = parseFloat($(this).val());
                if (isNaN(value) || value < 0.01) {
                    $(this).val('0.01');
                } else {
                    $(this).val(value.toFixed(2));
                }
                calculateTotals();
            });

            // $('#serviceTableBody').on('input', '.editable-quantity', function () {
            //     var value = parseFloat($(this).val());
            //     if (isNaN(value) || value < 0.01) {
            //         $(this).val('0.01');
            //     } else {
            //         $(this).val(value.toFixed(2));
            //     }
            //     calculateTotals();
            // });

            $('#serviceTableBody').on('click', '.delete-button', function () {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            $('#serviceTableBody').on('input', '.editable-price, .editable-quantity, .editable-discount', function () {
                calculateTotals();
            });

            $('#fullscreen-toggle').click(toggleFullScreen);

            $('#serviceTableBody').on('blur', '.editable-price', function () {
                calculateTotals();
            });

            $('#insertBtn').off('click').on('click', function () {
                insertData();
            });

            $('#orderBtn').off('click').on('click', function () {
                OrderData();
            });

            $('#invoiceBtn').off('click').on('click', function () {
                submitInvoice();
            });

            $('.category-tab').click(function () {
                $('.category-tab').removeClass('selected-category');
                $(this).addClass('selected-category');
            });

            $('.dropdown-button').click(function () {
                $('.dropdown-button').removeClass('selected-category');
                $(this).addClass('selected-category');
                var categoryId = $(this).val();
                filterServices(categoryId);
            });


            $('.table-item').click(function () {
                if (!$(this).hasClass('unselectable')) {
                    $('.table-item').removeClass('selected');
                    $(this).addClass('selected');
                    $(this).find('input[type="radio"]').prop('checked', true);
                }
            });
            function getSelectedTableId() {
                return $('.table-item.selected').data('table-id');
            }


            function isTableSelected() {
                return $('.table-item.selected').length > 0;
            }


            $('#summaryBtn').click(function () {
                if (isTable && !isTableSelected()) {
                    alert('Please select a table first.');
                    return;
                }

                var selectedTableId = isTable ? getSelectedTableId() : null;

                $.ajax({
                    url: '<?= site_url("newSalesController/getSummaryInvoices") ?>',
                    type: 'POST',
                    data: { tableId: selectedTableId },
                    dataType: 'json',
                    success: function (response) {
                        populateSummaryModal(response);
                        $('#summaryInvoiceModal').modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.error("An error occurred: " + error);
                    }
                });
            });

            function populateSummaryModal(invoices) {
                var tableBody = $('#summaryInvoiceTableBody');
                tableBody.empty();
                var totalValue = 0;
                var totalTVSH = 0;

                // $('#summaryInvoiceModal .modal-body p').text('Table Name: ' + tableName);

                invoices.forEach(function (invoice) {
                    var row = `<tr>
            <td>${invoice.InvoiceOrder}</td>
            <td>${invoice.client}</td>
            <td>${invoice.user}</td>
            <td>${invoice.value}</td>
            <td>${invoice.Tax}</td>
            <td>${invoice.Table}</td>
        </tr>`;
                    tableBody.append(row);
                    totalValue += parseFloat(invoice.value);
                    totalTVSH += parseFloat(invoice.Tax);
                });

                $('#totalValue').text(totalValue.toFixed(2));
                $('#totalTVSH').text(totalTVSH.toFixed(2));
            }

            // $('#summaryPayBtn').click(function () {
            //     alert('Processing payment...');
            //     $('#summaryInvoiceModal').modal('hide');
            // });

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

            $('#summaryPayBtn').click(function () {
                var selectedTableId = getSelectedTableId();
                var totalValue = parseFloat($('#totalValue').text());

                if (!selectedTableId) {
                    alert('Please select a table first.');
                    return;
                }

                if (isNaN(totalValue) || totalValue <= 0) {
                    alert('Invalid total value.');
                    return;
                }

                $('#loading-overlay').show();

                $.ajax({
                    url: '<?= site_url("newSalesController/submitSummary") ?>',
                    type: 'POST',
                    data: {
                        selectedTableId: selectedTableId,
                        totalValue: totalValue
                    },
                    dataType: 'json',
                    success: function (response) {
                        $('#loading-overlay').hide();
                        if (response.status === 'success') {
                            alert(response.message);
                            $('#summaryInvoiceModal').modal('hide');
                            // Optionally, refresh the page or update the UI
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#loading-overlay').hide();
                        console.error("An error occurred: " + error);
                        alert('An error occurred while processing the summary invoice.');
                    }
                });
            });

            function insertData() {
                $('#loading-overlay').show();

                var clientId = $('select[name="clientName"]').val();
                var clientName = $('select[name="clientName"] option:selected').text();
                var paymentMethodOption = $('select[name="Payment"] option:selected');
                var paymentMethodId = paymentMethodOption.data('payment-id');
                var paymentName = paymentMethodOption.text();
                var paymentMethodName = paymentMethodOption.text();
                var currency = $('select[name="Currency"]').val();
                var currencyName = $('select[name="Currency"] option:selected').text();
                var exchange = $('#exchangeInput').val();

                var totals = calculateTotals();
                var totalFee = totals.totalFee;
                var totalTax = totals.totalTax;
                var discountedTotal = totals.discountedTotal;
                var totalWithoutTax = totals.totalWithoutTax;

                var selectedTableId = null;

                if (!clientId || isNaN(totalFee)) {
                    alert('Invalid data for insertion.');
                    return;
                }

                var services = [];
                $('#serviceTableBody tr').each(function () {
                    var serviceTypeRow = $(this);
                    var serviceTypeId = serviceTypeRow.data('service-id');
                    var serviceName = serviceTypeRow.find('td:eq(0)').text();
                    var fee = parseFloat(serviceTypeRow.find('.editable-price').text()) || 0;
                    // var quantity = parseInt(serviceTypeRow.find('.editable-quantity').val()) || 0;
                    var quantity = parseFloat(serviceTypeRow.find('.editable-quantity').val()) || 0;
                    var discount = parseFloat(serviceTypeRow.find('.editable-discount').val()) || 0;
                    var discount = parseFloat(serviceTypeRow.find('.editable-discount').val()) || 0;
                    var taxRate = parseFloat(serviceTypeRow.find('.tax-rate').data('tax-value')) || 0;
                    var taxId = serviceTypeRow.find('.tax-rate').data('tax-id');
                    var expiryDate = serviceTypeRow.find('.expiry-dropdown').val() || serviceTypeRow.find('.expiry-date').val() || null;

                    var rowTotal = serviceTypeRow.data('rowTotal');
                    var rowDiscountAmount = serviceTypeRow.data('rowDiscountAmount');
                    var rowDiscountedTotal = serviceTypeRow.data('rowDiscountedTotal');
                    var calculatedTax = serviceTypeRow.data('calculatedTax');
                    var rowWithoutTax = serviceTypeRow.data('rowWithoutTax');

                    services.push({
                        serviceTypeId: serviceTypeId,
                        serviceName: serviceName,
                        fee: fee,
                        quantity: quantity,
                        discount: discount,
                        expiryDate: expiryDate,
                        taxRate: taxRate,
                        taxId: taxId,
                        calculatedTax: calculatedTax,
                        rowTotal: rowTotal,
                        rowDiscountAmount: rowDiscountAmount,
                        rowDiscountedTotal: rowDiscountedTotal,
                        rowWithoutTax: rowWithoutTax
                    });
                });
                console.log('Services', services);

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
                        services: services,
                        selectedTableId: selectedTableId,
                        discountedTotal: discountedTotal
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

                        $('#loading-overlay').hide();
                        location.reload();
                    },
                    error: function (error) {
                        console.error('Error inserting data:', error);
                        $('#loading-overlay').hide();
                    }
                });
            }

            function isTableSelected() {
                return $('input[name="select_table"]:checked').length > 0;
            }



            function OrderData() {
                $('#loading-overlay').show();

                var clientId = $('select[name="clientName"]').val();
                var clientName = $('select[name="clientName"] option:selected').text();
                var paymentMethodOption = $('select[name="Payment"] option:selected');
                var paymentMethodId = paymentMethodOption.data('payment-id');
                var paymentName = paymentMethodOption.text();
                var paymentMethodName = paymentMethodOption.text();
                var currency = $('select[name="Currency"]').val();
                var currencyName = $('select[name="Currency"] option:selected').text();
                var exchange = $('#exchangeInput').val();

                var totals = calculateTotals();
                var totalFee = totals.totalFee;
                var totalTax = totals.totalTax;
                var discountedTotal = totals.discountedTotal;
                var totalWithoutTax = totals.totalWithoutTax;

                if (isTable && !isTableSelected()) {
                    alert('Please select a table before submitting the order.');
                    $('#loading-overlay').hide();
                    return;
                }
                var selectedTableId = isTable ? getSelectedTableId() : null;

                if (!clientId || isNaN(totalFee)) {
                    alert('Invalid data for insertion.');
                    return;
                }

                var services = [];
                $('#serviceTableBody tr').each(function () {
                    var serviceTypeRow = $(this);
                    var serviceTypeId = serviceTypeRow.data('service-id');
                    var serviceName = serviceTypeRow.find('td:eq(0)').text();
                    var fee = parseFloat(serviceTypeRow.find('.editable-price').text()) || 0;
                    // var quantity = parseInt(serviceTypeRow.find('.editable-quantity').val()) || 0;
                    var quantity = parseFloat(serviceTypeRow.find('.editable-quantity').val()) || 0;
                    var discount = parseFloat(serviceTypeRow.find('.editable-discount').val()) || 0;
                    var taxRate = parseFloat(serviceTypeRow.find('.tax-rate').data('tax-value')) || 0;
                    var taxId = serviceTypeRow.find('.tax-rate').data('tax-id');
                    var expiryDate = serviceTypeRow.find('.expiry-dropdown').val() || serviceTypeRow.find('.expiry-date').val() || null;

                    var rowTotal = serviceTypeRow.data('rowTotal');
                    var rowDiscountAmount = serviceTypeRow.data('rowDiscountAmount');
                    var rowDiscountedTotal = serviceTypeRow.data('rowDiscountedTotal');
                    var calculatedTax = serviceTypeRow.data('calculatedTax');
                    var rowWithoutTax = serviceTypeRow.data('rowWithoutTax');

                    services.push({
                        serviceTypeId: serviceTypeId,
                        serviceName: serviceName,
                        fee: fee,
                        quantity: quantity,
                        discount: discount,
                        expiryDate: expiryDate,
                        taxRate: taxRate,
                        taxId: taxId,
                        calculatedTax: calculatedTax,
                        rowTotal: rowTotal,
                        rowDiscountAmount: rowDiscountAmount,
                        rowDiscountedTotal: rowDiscountedTotal,
                        rowWithoutTax: rowWithoutTax
                    });
                });

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
                        discountedTotal: discountedTotal,
                        totalWithoutTax: totalWithoutTax,
                        selectedTableId: selectedTableId,
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

                        $('#loading-overlay').hide();
                        location.reload();
                    },
                    error: function (error) {
                        console.error('Error inserting data:', error);
                        $('#loading-overlay').hide();
                    }
                });
            }

            function submitInvoice() {
                $('#loading-overlay').show();

                var clientId = $('select[name="clientName"]').val();
                var clientName = $('select[name="clientName"] option:selected').text();
                var paymentMethodOption = $('select[name="Payment"] option:selected');
                var paymentMethodId = paymentMethodOption.data('payment-id');
                var paymentName = paymentMethodOption.text();
                var paymentMethodName = paymentMethodOption.text();
                var currency = $('select[name="Currency"]').val();
                var currencyName = $('select[name="Currency"] option:selected').text();
                var exchange = $('#exchangeInput').val();

                var totals = calculateTotals();
                var totalFee = totals.totalFee;
                var totalTax = totals.totalTax;
                var discountedTotal = totals.discountedTotal;
                var totalWithoutTax = totals.totalWithoutTax;

                var selectedTableId = null;

                if (!clientId || isNaN(totalFee)) {
                    alert('Invalid data for insertion.');
                    return;
                }

                var services = [];
                $('#serviceTableBody tr').each(function () {
                    var serviceTypeRow = $(this);
                    var serviceTypeId = serviceTypeRow.data('service-id');
                    var serviceName = serviceTypeRow.find('td:eq(0)').text();
                    var fee = parseFloat(serviceTypeRow.find('.editable-price').text()) || 0;
                    // var quantity = parseInt(serviceTypeRow.find('.editable-quantity').val()) || 0;
                    var quantity = parseFloat(serviceTypeRow.find('.editable-quantity').val()) || 0;
                    var discount = parseFloat(serviceTypeRow.find('.editable-discount').val()) || 0;
                    var taxRate = parseFloat(serviceTypeRow.find('.tax-rate').data('tax-value')) || 0;
                    var taxId = serviceTypeRow.find('.tax-rate').data('tax-id');
                    var expiryDate = serviceTypeRow.find('.expiry-dropdown').val() || serviceTypeRow.find('.expiry-date').val() || null;

                    var rowTotal = serviceTypeRow.data('rowTotal');
                    var rowDiscountAmount = serviceTypeRow.data('rowDiscountAmount');
                    var rowDiscountedTotal = serviceTypeRow.data('rowDiscountedTotal');
                    var calculatedTax = serviceTypeRow.data('calculatedTax');
                    var rowWithoutTax = serviceTypeRow.data('rowWithoutTax');

                    services.push({
                        serviceTypeId: serviceTypeId,
                        serviceName: serviceName,
                        fee: fee,
                        quantity: quantity,
                        discount: discount,
                        expiryDate: expiryDate,
                        taxRate: taxRate,
                        taxId: taxId,
                        calculatedTax: calculatedTax,
                        rowTotal: rowTotal,
                        rowDiscountAmount: rowDiscountAmount,
                        rowDiscountedTotal: rowDiscountedTotal,
                        rowWithoutTax: rowWithoutTax
                    });
                });

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
                        discountedTotal: discountedTotal,
                        totalWithoutTax: totalWithoutTax,
                        selectedTableId: selectedTableId,
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

                        $('#loading-overlay').hide();
                        location.reload();
                    },
                    error: function (error) {
                        console.error('Error inserting data:', error);
                        $('#loading-overlay').hide();
                    }
                });
            }
        });

    </script>


</body>

</html>