<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
  <link rel="stylesheet" href="./public/assets/vendors_s/select2-bootstrap-theme/select2-bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


  <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"> -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


  <style>
    .table-fixed {
      table-layout: fixed;
      width: 100%;
    }

    .table-fixed th,
    .table-fixed td {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .table-fixed th:hover,
    .table-fixed td:hover {
      overflow: visible;
      white-space: normal;
      word-wrap: break-word;
    }

    /* Adjust these widths as needed */
    .col-name {
      width: 40%;
    }

    .col-price {
      width: 20%;
    }

    .col-expiry {
      width: 20%;
    }

    .col-action {
      width: 20%;
    }

    /* For the summary table */
    .col-service {
      width: 25%;
    }

    .col-amount {
      width: 15%;
    }

    .col-quantity {
      width: 15%;
    }

    .col-discount {
      width: 15%;
    }

    .col-tax {
      width: 15%;
    }

    .col-expiry-summary {
      width: 15%;
    }

    .col-actions {
      width: 15%;
    }

    .badge-pill:hover {
      background-color: #52CDFF;
      color: #fff;
      cursor: pointer;
      font-weight: bolder;
      border: #52CDFF;
    }

    #clientDetails {
      font-weight: 750;
    }

    .quantity-box {
      width: 50px;
      text-align: center;
    }

    .twitter-typeahead {
      max-width: 100%;
      width: 100%;

    }

    #serviceTableBodyContainer {
      max-height: 300px;
      overflow-y: auto;
    }

    #summaryTableContainer {
      max-height: 300px;
      overflow-y: auto;
    }

    .active {
      background: #52CDFF;
      color: #fff;

    }

    .table thead th,
    .table tbody td {
      padding: 8px;
    }

    .table thead,
    .table tbody {
      display: table;
      width: 100%;
      table-layout: fixed;
    }

    .table tbody tr {
      height: 0px;
    }

    .table thead tr {
      height: 0px;

    }

    .table-container {
      max-height: 220px;
      /* Adjust the height as needed */
      overflow-y: auto;
    }

    .center-dropdown .select2-dropdown {
      text-align: left;
    }



    .select2-container .select2-selection--single {
      height: 2rem;
      text-align: left;
      padding: 0;
    }

    .select2-selection--single {
      height: 33px;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
      text-align: left;
      padding: 2%;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: normal;
      /* padding: 0; */
    }

    .select2-container--default .select2-results>.select2-results__options {
      background: #E9ECEF;
    }

    .select2-search--dropdown {
      background: #E9ECEF;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
      background: #E9ECEF;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
      text-align: left;
    }

    .page-body-wrappers {
      min-height: calc(100vh - 97px);
      display: -webkit-flex;
      display: flex;
      -webkit-flex-direction: row;
      flex-direction: row;
      padding-left: 0;
      padding-right: 0;
      padding-top: 75px;
    }

    .select2-selection .select2-selection--single {
      height: 2rem;
    }

    .quantity-input {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .quantity-input span {
      cursor: pointer;
      font-size: 16px;
      padding: 0 5px;
    }

    .quantity-input input {
      width: 50px;
      text-align: center;
      margin: 0 5px;
    }

    #loadingOverlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.7);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }


    #discountAmount,
    #discountedTotal {
      /* font-weight: 900;
      font-size: 150px; */
    }
  </style>

</head>

<body>
  <div class="container-scroller">
    <!-- partial -->
    <div class="container-fluid page-body-wrappers" style="padding-top: 7%">
      <!-- partial:../../partials/_settings-panel.html -->

      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      <?php include 'include_common/sidebar.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row" style="margin-top: -22px;">
            <div class="col-md-6">
              <div class="card h-100">
                <div class="card-body">
                  <p class="card-description"
                    style="margin-top: -19px; margin-bottom: -10px; font-weight: bold; color: black">
                    Services

                    <!-- <button class="btn btn-primary text-white me-0" data-toggle="modal"
                      data-target="#expenseModal">ADD</button> -->
                  </p>
                  <form class="pt-3" method="POST" action="<?php echo base_url() . "submitTests"; ?>"
                    enctype="multipart/form-data">
                    <div class="form-group row" style="margin-bottom: 6px;">

                      <div class="col">
                        <label>Client Name</label>
                        <div class="input-group">
                          <select class="form-control select2" name="clientName" id="clientId">
                            <?php foreach ($client_names as $client): ?>
                              <option value="<?= $client['idClient']; ?>">
                                <?= $client['clientUniqueId']; ?> - <?= $client['client']; ?>   <?= $client['contact']; ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <div class="input-group-append">
                            <button class="btn btn-primary text-white" type="button" data-toggle="modal"
                              data-target="#expenseModal"
                              style="padding: 0;line-height: 1;width: 58px;height: 33px;margin-left: -2px;font-size: x-large;">+</button>
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
                    </div>
                    <div class="form-group row" style="margin-bottom: 6px;">
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
                    <div class="form-group row" style="margin-bottom: 6px;">
                      <div class="col">
                        <label for="categoryDropdown">Category:</label>
                        <select class="form-control" id="categoryDropdown">
                          <option value="">All Categories</option>
                          <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['idCatArt']; ?>">
                              <?= $category['name']; ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col">
                        <label for="search">Search:</label>
                        <input type="text" id="search" class="form-control" placeholder="Enter service type or fee">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 6px;">
                      <div id="serviceTableBodyContainer">
                        <div class="table-container">
                          <table class="table table-fixed" id="serviceTypeList">
                            <thead>
                              <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <?php if ($isExpiry == 1): ?>
                                  <th>Expiry</th>
                                <?php endif; ?>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($services as $service): ?>
                                <tr data-service-type-id="<?= $service['idArtMenu']; ?>"
                                  data-tax-value="<?= $service['tax_value']; ?>">
                                  <td class="title" class="col-name"><?= $service['Name']; ?></td>
                                  <td class="fee" contenteditable="true"><?= $service['Price']; ?></td>
                                  <?php if ($isExpiry == 1): ?>
                                    <td>
                                      <?php
                                      $businessID = session()->get('businessID');
                                      $serviceExpiries = $salesModel->getServiceExpiry($service['idArtMenu'], $businessID);
                                      if (count($serviceExpiries) > 0) {
                                        ?>
                                        <select class="form-control expiry-dropdown">
                                          <option value="">Select Expiry</option>
                                          <?php
                                          $firstExpiryDate = null;
                                          foreach ($serviceExpiries as $expiry) {
                                            $expiryDate = $expiry['expiryDate'];
                                            if ($firstExpiryDate === null) {
                                              $firstExpiryDate = $expiryDate;
                                              echo '<option value="' . $expiryDate . '" selected>' . date('Y-m-d', strtotime($expiryDate)) . '</option>'; // Add selected attribute to the first option
                                            } else {
                                              echo '<option value="' . $expiryDate . '">' . date('Y-m-d', strtotime($expiryDate)) . '</option>';
                                            }
                                          }
                                          ?>
                                        </select>
                                        <?php
                                      } else {
                                        echo '--';
                                      }
                                      ?>
                                    </td>
                                  <?php endif; ?>
                                  <td><span class="badge badge-primary badge-pill hover-effect"
                                      onclick="addService()">ADD</span></td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>

                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100">
                <div class="card-body">
                  <p class="card-description"
                    style="margin-top: -19px; margin-bottom: -10px; font-weight: bold; color: black;">
                    SUMMARY
                    <!-- <button type="button" style="margin-left:64% ;"
                      class="btn btn-outline-info btn-icon-text">Invoice</button> -->

                  </p>
                  <div class="row" style="margin-top: 8px;margin-bottom: -7px;">
                    <div class="col-md-6" id="clientDetailsLeft"></div>
                    <div class="col-md-6" id="clientDetailsRight"></div>
                  </div>
                  <hr>
                  <div id="summaryTableContainer">
                    <table class="table table-fixed">
                      <thead>
                        <tr>
                          <th>Service</th>
                          <th>Amount</th>
                          <th>Quantity</th>
                          <th>Discount</th>
                          <th>Tax</th>
                          <?php if ($isExpiry == 1): ?>
                            <th>Expiry</th>
                          <?php endif; ?>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody id="serviceTableBody"></tbody>
                    </table>
                  </div>
                </div>
                <div style="margin-left: 320px; font-weight: 900; font-size: 150px">
                  <p>Total Fee: <span id="totalFee">0</span></p>
                  <p>Discount: <span id="discountAmount">0</span></p>
                  <p>Total without Tax: <span id="totalWithoutTax">0</span></p>
                  <p>Tax: <span id="taxAmount">0</span></p>
                  <p>Discounted Total: <span id="discountedTotal">0</span></p>
                </div>

                <div style="height: 58px; margin-left: 7.4em; font-weight: 900;">
                  <button type="button" class="btn btn-outline-info btn-icon-text action-btn"
                    id="invoiceBtn">Invoice</button>
                  <button type="button" class="btn btn-outline-info btn-icon-text action-btn" id="insertBtn">Invoice &
                    Pay
                    <i class="ti-printer btn-icon-append"></i>
                  </button>
                </div>
                <!-- <div style="height: 58px; margin-left: 7.4em; font-weight: 900;">
                  <button type="button" class="btn btn-outline-info btn-icon-text" id="invoiceBtn">Invoice</button>
                  <button type="button" class="btn btn-outline-info btn-icon-text" id="insertBtn">Invoice & Pay
                    <i class="ti-printer btn-icon-append"></i>
                  </button>
                </div> -->
              </div>
            </div>
          </div>
        </div>


        <!-- --------------------Model------------------------ -->
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
        <div id="loadingOverlay" class="d-none">
          <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
        <!-- Include footer -->
        <?php include 'include_common/footer.php'; ?>
      </div>

      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


  <script>
    $('.select2').select2({
      dropdownAutoWidth: true,
    });

    // function calculateTotalFee() {
    //   var totalFee = 0;
    //   var discountAmount = 0;
    //   var taxAmount = 0;

    //   $('#serviceTableBody tr').each(function () {
    //     var quantity = parseFloat($(this).find('.editable-quantity').val());
    //     var fee = parseFloat($(this).find('.editable-fee').text());
    //     var discount = parseFloat($(this).find('.editable-discount').text());
    //     // var taxValue = parseFloat($(this).find('.tax-rate').text()) / 100;
    //     var taxValue = parseFloat($(this).find('.tax-rate').text()) || 0;
    //     taxValue = (taxValue / 100) + 1;
    //     // var taxValue = parseFloat($(this).find('.tax-rate').text());

    //     var rowTotal = quantity * fee;
    //     var rowDiscountAmount = rowTotal * (discount / 100);
    //     var rowDiscountedTotal = rowTotal - rowDiscountAmount;
    //     var rowTaxAmount = rowDiscountedTotal * taxValue;

    //     discountAmount += rowDiscountAmount;
    //     taxAmount += rowTaxAmount;
    //     totalFee += rowTotal;

    //     $(this).data('calculatedTax', rowTaxAmount);
    //   });
    //   var discountedTotal = totalFee - discountAmount;
    //   var finalTotal = Math.round(discountedTotal + taxAmount);

    //   $('#totalFee').text(totalFee.toFixed(2));
    //   $('#discountAmount').text(discountAmount.toFixed(2));
    //   $('#taxAmount').text(taxAmount.toFixed(2));
    //   $('#discountedTotal').text(finalTotal.toFixed(2));
    // }


    function calculateTotalFee() {
      var totalFee = 0;
      var discountAmount = 0;
      var taxAmount = 0;
      var totalWithoutTax = 0;
      var discountedTotal = 0;

      $('#serviceTableBody tr').each(function () {
        var quantity = parseFloat($(this).find('.editable-quantity').val());
        var fee = parseFloat($(this).find('.editable-fee').text());
        var discount = parseFloat($(this).find('.editable-discount').text());
        var taxRate = parseFloat($(this).find('.tax-rate').text()) || 0;

        var rowTotal = quantity * fee;
        var rowDiscountAmount = rowTotal * (discount / 100);
        var rowDiscountedTotal = rowTotal - rowDiscountAmount;

        var rowTaxAmount = rowDiscountedTotal * (taxRate / 100);

        totalFee += rowTotal;
        discountAmount += rowDiscountAmount;
        taxAmount += rowTaxAmount;
        totalWithoutTax += rowDiscountedTotal - rowTaxAmount;
        discountedTotal += rowDiscountedTotal;

        $(this).data('calculatedTax', rowTaxAmount);
      });

      totalWithoutTax = Math.round(totalWithoutTax);
      discountedTotal = Math.round(discountedTotal);

      $('#totalFee').text(totalFee.toFixed(2));
      $('#discountAmount').text(discountAmount.toFixed(2));
      $('#taxAmount').text(taxAmount.toFixed(2));
      $('#discountedTotal').text(discountedTotal.toFixed(2));
      $('#totalWithoutTax').text(totalWithoutTax.toFixed(2));
    }

    $('#search').on('input', function () {
      var searchText = $(this).val().toLowerCase();
      $('#serviceTypeList tbody tr').each(function () {
        var serviceType = $(this).find('.title').text().toLowerCase();
        if (serviceType.includes(searchText)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });

    function addServiceRow(serviceType, serviceTypeId, serviceFee, expiryDate, taxValue) {
      var exists = false;
      $('#serviceTableBody tr').each(function () {
        var existingServiceTypeId = $(this).find('td:first').data('service-type-id');
        if (existingServiceTypeId === serviceTypeId) {
          exists = true;
          return false;
        }
      });

      if (!exists) {
        taxValue = parseFloat(taxValue) || 0;
        var newRow = '<tr>' +
          '<td data-service-type-id="' + serviceTypeId + '">' + serviceType + '</td>' +
          '<td contenteditable="true" class="editable-fee" style="text-align: center;">' + serviceFee + '</td>' +
          '<td><div class="quantity-input"><span class="quantity-decrement btn btn-danger btn-sm" style="font-size: 17px;margin-left: 30%; border-radius: 50%; margin-right: -8%;">-</span><input type="text" class="editable-quantity form-control quantity-box" style="width: 40px; padding: 0%;" value="1"><span class="quantity-increment btn btn-success btn-sm" style="margin-right: 30%;font-size: 17px;margin-left: -7%; border-radius: 50%; ">+</span></div></td>' +
          '<td contenteditable="true" class="editable-discount" style="text-align: center;">0</td>' +
          '<td class="tax-rate">' + taxValue + '</td>';

        <?php if ($isExpiry == 1): ?>
          newRow += '<td>' + (expiryDate ? '<input type="hidden" class="expiry-date" value="' + expiryDate + '">' + expiryDate.split(' ')[0] : 'Nil') + '</td>';
        <?php endif; ?>

        newRow += '<td><button class="btn btn-danger btn-sm remove-btn" onclick="removeServiceRow(this)"><i class="mdi mdi-delete"></i></button></td>' +
          '</tr>';

        $('#serviceTableBody').append(newRow);
        calculateTotalFee();

        var newRowElement = $('#serviceTableBody tr:last');
        newRowElement.find('.quantity-increment').click(function () {
          var quantityInput = $(this).closest('td').find('.editable-quantity');
          var currentQuantity = parseInt(quantityInput.val());
          quantityInput.val(currentQuantity + 1);
          calculateTotalFee();
        });

        newRowElement.find('.quantity-decrement').click(function () {
          var quantityInput = $(this).closest('td').find('.editable-quantity');
          var currentQuantity = parseInt(quantityInput.val());
          if (currentQuantity > 1) {
            quantityInput.val(currentQuantity - 1);
            calculateTotalFee();
          }
        });
      } else {
        alert('This service is already added to the summary.');
      }
    }


    $(document).ready(function () {
      $('#serviceTableBody').on('input', 'td[contenteditable="true"]', function () {
        calculateTotalFee();
      });



      $('#serviceTypeList .badge').click(function () {
        var serviceTypeRow = $(this).closest('tr');
        var serviceTypeId = serviceTypeRow.data('service-type-id');
        var serviceType = serviceTypeRow.find('.title').text().trim();
        var serviceFee = serviceTypeRow.find('.fee').text().trim();
        var expiryDate = serviceTypeRow.find('.expiry-dropdown').val();
        var taxValue = serviceTypeRow.data('tax-value');
        addServiceRow(serviceType, serviceTypeId, serviceFee, expiryDate, taxValue);
        calculateTotalFee();
      });

      function attachAddServiceHandler() {
        $('#serviceTypeList .badge').click(function () {
          var serviceTypeRow = $(this).closest('tr');
          var serviceTypeId = serviceTypeRow.data('service-type-id');
          var serviceType = serviceTypeRow.find('.title').text().trim();
          var serviceFee = serviceTypeRow.find('.fee').text().trim();
          addServiceRow(serviceType, serviceTypeId, serviceFee);
          calculateTotalFee();
        });
      }

      $('#categoryDropdown').change(function () {
        var categoryId = $(this).val();
        filterServices(categoryId);
      });

      function filterServices(categoryId) {
        $.ajax({
          url: '<?php echo base_url() . "SalesController/filterServices"; ?>',
          type: 'POST',
          data: { categoryId: categoryId },
          dataType: 'html',
          success: function (data) {
            $('#serviceTableBodyContainer').html(data);
          }
        });
      }

      $('#insertBtn').off('click').on('click', function () {
        insertData();
      });

      $('#invoiceBtn').click(function () {
        submitInvoice();
      });

      $('#serviceTypeList .badge-pill').mouseenter(function () {
        $(this).addClass('hover-effect');
      });

      $('#serviceTypeList .badge-pill').mouseleave(function () {
        $(this).removeClass('hover-effect');
      });

      $('select[name="clientName"]').change(function () {
        updateSelectedDetails();
      });

      $('select[name="Payment"]').change(function () {
        updateSelectedDetails();
      });

      $('select[name="Currency"]').change(function () {
        updateSelectedDetails();
      });

      $('#exchangeInput').on('input', function () {
        updateSelectedDetails();
      });

      function updateSelectedDetails() {
        var selectedClientName = $('select[name="clientName"] option:selected').text();
        var selectedPaymentMethod = $('select[name="Payment"] option:selected').text();
        var selectedCurrency = $('select[name="Currency"] option:selected').text();
        var selectedExchange = $('#exchangeInput').val();

        $('#clientDetailsLeft').html('Client: ' + selectedClientName +
          '<br>Payment Method: ' + selectedPaymentMethod);

        $('#clientDetailsRight').html('Currency: ' + selectedCurrency +
          '<br>Exchange: ' + (selectedExchange !== undefined ? selectedExchange : 'N/A'));
      }



      $('#serviceTableBody').on('click', '.remove-btn', function () {
        var row = $(this).closest('tr');
        var serviceFee = parseFloat(row.find('td:eq(1)').text());
        row.remove();
        calculateTotalFee(-serviceFee);
      });


      function showLoading() {
        $('#loadingOverlay').removeClass('d-none');
      }

      function hideLoading() {
        $('#loadingOverlay').addClass('d-none');
      }

      function disableButtons() {
        $('.action-btn').prop('disabled', true);
      }

      function enableButtons() {
        $('.action-btn').prop('disabled', false);
      }

      $('#insertBtn').off('click').on('click', function (e) {
        e.preventDefault();
        disableButtons();
        showLoading();
        insertData();
      });

      $('#invoiceBtn').off('click').on('click', function (e) {
        e.preventDefault();
        disableButtons();
        showLoading();
        submitInvoice();
      });

      function insertData() {
        // disableButtons();
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
        var discountedTotal = parseFloat($('#discountedTotal').text());
        var selectedTableId = null;

        // var quantity = parseFloat($('#quantityInput').val());

        // console.log("Quantity: ", quantity);
        // console.log("Client ID: ", clientId);
        // console.log("Client Name: ", clientName);
        // console.log("Payment Method ID: ", paymentMethodId);
        // console.log("Payment Name: ", paymentName);
        // console.log("Currency: ", currency);
        // console.log("Exchange: ", exchange);
        // console.log("Total Fee: ", totalFee);

        // console.log("Discounted Fee: ", discountedTotal);


        if (!clientId || isNaN(totalFee)) {
          alert('Invalid data for insertion.');
          return;
        }

        var services = [];
        $('#serviceTableBody tr').each(function () {
          var serviceTypeRow = $(this);
          var serviceTypeId = serviceTypeRow.find('td:first').data('service-type-id');
          var serviceName = serviceTypeRow.find('td:eq(0)').text();
          var fee = parseFloat(serviceTypeRow.find('td:eq(1)').text());
          var quantityInput = serviceTypeRow.find('.editable-quantity');
          var quantity = parseFloat(quantityInput.val());
          // var discount = parseFloat(serviceTypeRow.find('.editable-discount').text());
          var discount = parseFloat(serviceTypeRow.find('.editable-discount').text());
          discount = Math.round(discount);
          serviceTypeRow.find('.editable-discount').text(discount);
          var expiryDate = serviceTypeRow.find('.expiry-date').val();
          var taxRate = parseFloat(serviceTypeRow.find('.tax-rate').text());
          var calculatedTax = serviceTypeRow.data('calculatedTax');

          if (expiryDate === undefined) {
            expiryDate = '1970-01-01';
          }

          // console.log(services);

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
            discountedTotal: discountedTotal,
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
              location.reload();
            }
            $('#serviceTableBody').empty();
            $('#totalFee').text('0');
          },
          error: function (error) {
            console.error('Error inserting data:', error);
          }

        });
      }

      function submitInvoice() {
        // disableButtons();
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
        var discountedTotal = parseFloat($('#discountedTotal').text());
        var selectedTableId = null;

        // var quantity = parseFloat($('#quantityInput').val());

        // console.log("Quantity: ", quantity);
        // console.log("Client ID: ", clientId);
        // console.log("Client Name: ", clientName);
        // console.log("Payment Method ID: ", paymentMethodId);
        // console.log("Payment Name: ", paymentName);
        // console.log("Currency: ", currency);
        // console.log("Exchange: ", exchange);
        // console.log("Total Fee: ", totalFee);

        // console.log("Discounted Fee: ", discountedTotal);


        if (!clientId || isNaN(totalFee)) {
          alert('Invalid data for insertion.');
          return;
        }

        var services = [];
        $('#serviceTableBody tr').each(function () {
          var serviceTypeRow = $(this);
          var serviceTypeId = serviceTypeRow.find('td:first').data('service-type-id');
          var serviceName = serviceTypeRow.find('td:eq(0)').text();
          var fee = parseFloat(serviceTypeRow.find('td:eq(1)').text());
          var quantityInput = serviceTypeRow.find('.editable-quantity');
          var quantity = parseFloat(quantityInput.val());
          // var discount = parseFloat(serviceTypeRow.find('.editable-discount').text());
          var discount = parseFloat(serviceTypeRow.find('.editable-discount').text());
          discount = Math.round(discount);
          serviceTypeRow.find('.editable-discount').text(discount);
          var expiryDate = serviceTypeRow.find('.expiry-date').val();
          var taxRate = parseFloat(serviceTypeRow.find('.tax-rate').text());
          var calculatedTax = serviceTypeRow.data('calculatedTax');

          if (expiryDate === undefined) {
            expiryDate = '1970-01-01';
          }

          // console.log(services);

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
              location.reload();
            }
            $('#serviceTableBody').empty();
            $('#totalFee').text('0');
          },
          error: function (error) {
            console.error('Error inserting data:', error);
          }

        });
      }
    });

  </script>


  <script src="./public/assets/vendors_s/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="./public/assets/vendors_s/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="./public/assets/vendors_s/select2/select2.min.js"></script>
  <script src="./public/assets/vendors_s/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="./public/assets/js_s/off-canvas.js"></script>
  <script src="./public/assets/js_s/hoverable-collapse.js"></script>
  <script src="./public/assets/js_s/template.js"></script>
  <script src="./public/assets/js_s/settings.js"></script>
  <script src="./public/assets/js_s/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="./public/assets/js_s/file-upload.js"></script>
  <script src="./public/assets/js_s/typeahead.js"></script>
  <script src="./public/assets/js_s/select2.js"></script>
  <!-- End custom js for this page-->
</body>

</html>