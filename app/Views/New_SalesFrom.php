<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Management</title>
    <link rel="stylesheet" href="./public/assets/css_s/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="./public/assets/images_s/regexbyte.png" />

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        .body {
            background-image: url('C:\xampp\htdocs\HMS_RegexByte\uploads\defaults\background.jpg');
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

        /* .item-list-container {
            margin-top: 10px;
            overflow-y: auto;
            height: calc(100% - 50px);
        } */

        .item-list-container {
            width: 95%;
            margin-top: 10px;
            overflow-y: auto;
        }

        .item-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-height: 300px;
        }

        .item {

            width: 31%;
            height: 6rem;
            /* width: calc(33.33% - 8px); */
            box-sizing: border-box;
            padding: 3px;
            font-size: small;
            background-color: #b6b5bd;
            border: 1px solid #ddd;
            text-align: center;
            margin-right: 9px;
            margin-bottom: 8px;
            border-radius: 15px;

        }

        .container-fluid {
            padding: 20px;
        }

        .top-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar {
            width: 30%;
            max-height: 300px;
        }

        .dropdown-buttons {
            height: 300px;
            overflow-y: auto;

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

        /* .dropdown-buttons {
            max-height: 300px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .dropdown-button {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            margin: 5px;
            width: calc(100% - 10px);
            background-color: #f9f9f9;
            cursor: pointer;
        }

        .dropdown-button:hover {
            background-color: #f0f0f0;
        } */

        .sidebar button {
            width: 95%;
            margin-bottom: 6px;
            background-color: #ffffff;
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

        .table-container {
            margin-bottom: 20px;
        }

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
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            flex: 1;
        }

        .invoice-info div {
            margin-bottom: 10px;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .buttons .btn {
            flex: 1;
            margin: 0 5px;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="content">
            <div class="left-side">
                <div class="sidebar">
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
                        <!-- <button>Refresh</button> -->
                    </div>
                    <div class="item-list-container">
                        <div class="item-list">
                            <?php foreach ($services as $service): ?>
                                <div class="item">
                                    <div style="font;font-weight: bolder;"><?= $service['Name']; ?></div>
                                    <div style="margin-bottom:auto; font-size: small;"> <?= $service['Price']; ?> pkr</div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>

            <div class="right-side">
                <div class="table-container">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Price Without Vat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Printer A4</td>
                                <td>0.00</td>
                                <td>0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label>Client Name</label>
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
                                    style="padding: 0;line-height: 1;width: 58px;height: 38px;margin-left: -2px;font-size: x-large;">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <label>Payment Method</label>
                        <div id="the-basics">
                            <select class="typeahead form-control" name="Payment">
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
                        <label>Currency</label>
                        <div id="the-basics">
                            <select class="typeahead form-control" name="Currency">
                                <?php foreach ($currencies as $currency): ?>
                                    <option value="<?= $currency['id']; ?>">
                                        <?= $currency['Currency']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <label>Exchange</label>
                        <div id="bloodhound">
                            <input class="typeahead form-control" type="Number" name="exchange" value='1.0'
                                id="exchangeInput" placeholder="Exchange Rate">
                        </div>
                    </div>
                </div>

                <div class="top-row">
                    <div class="invoice-info">
                        <div>Invoice Info</div>
                        <div>Value Without VAT: 0 EUR</div>
                        <div>Total VAT Amount: 0 EUR</div>
                        <div>Total Value: 0 EUR</div>
                    </div>
                    <div class="buttons">
                        <button class="btn btn-danger">Back</button><br>
                        <button class="btn btn-success">Save</button><br>
                        <button class="btn btn-primary">Save & Pay</button><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="dropdown-container">
        <select class="form-control">
            <option>Options</option>
            <option>Option 1</option>
            <option>Option 2</option>
            <option>Option 3</option>
        </select>
    </div> -->


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
</body>

</html>