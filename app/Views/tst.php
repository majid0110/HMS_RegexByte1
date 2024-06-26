<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
  <link rel="stylesheet" href="./public/assets/vendors_s/select2-bootstrap-theme/select2-bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
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
                  <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
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
              <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 fw-normal">See
                All</small>
            </div>
            <ul class="chat-list">
              <li class="list active">
                <div class="profile"><img src="./public/assets/images_s/faces/face1.jpg" alt="image"><span
                    class="online"></span></div>
                <div class="info">
                  <p>Thomas Douglas</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">19 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="./public/assets/images_s/faces/face2.jpg" alt="image"><span
                    class="offline"></span></div>
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
                <div class="profile"><img src="./public/assets/images_s/faces/face3.jpg" alt="image"><span
                    class="online"></span></div>
                <div class="info">
                  <p>Daniel Russell</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">14 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="./public/assets/images_s/faces/face4.jpg" alt="image"><span
                    class="offline"></span></div>
                <div class="info">
                  <p>James Richardson</p>
                  <p>Away</p>
                </div>
                <small class="text-muted my-auto">2 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="./public/assets/images_s/faces/face5.jpg" alt="image"><span
                    class="online"></span></div>
                <div class="info">
                  <p>Madeline Kennedy</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">5 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="./public/assets/images_s/faces/face6.jpg" alt="image"><span
                    class="online"></span></div>
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
          <div class="row" style="margin-top: -22px;">
            <div class="col-md-6">
              <div class="card h-100">
                <div class="card-body">
                  <p class="card-description"
                    style="margin-top: -19px; margin-bottom: -10px; font-weight: bold; color: black">
                    Services
                  </p>

                  <form class="pt-3" method="POST" action="<?php echo base_url() . "submitTests"; ?>"
                    enctype="multipart/form-data">
                    <div class="form-group row" style="margin-bottom: 6px;">
                      <div class="col">
                        <label>Client Name</label>
                        <div id="the-basics">
                          <select class="typeahead form-control select2" name="clientName" id="clientId">
                            <?php foreach ($client_names as $client): ?>
                              <option value="<?= $client['idClient']; ?>">
                                <?= $client['clientUniqueId']; ?> - <?= $client['client']; ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
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
                          <table class="table" id="serviceTypeList">
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
                                <tr data-service-type-id="<?= $service['idArtMenu']; ?>">
                                  <td class="title"><?= $service['Name']; ?></td>
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
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Service</th>
                          <th>Amount</th>
                          <th>Quantity</th>
                          <th>Discount</th>
                          <!-- <th>Expiry</th> -->
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
                <div style="margin-left: 368px; font-weight: 900; font-size: 150px">
                  <p>Total Fee: <span id="totalFee">0</span></p>
                  <p>Discount: <span id="discountAmount">0</span></p>
                  <p>Discounted Total: <span id="discountedTotal">0</span></p>
                </div>
                <div style="height: 58px; margin-left: 7.4em; font-weight: 900;">
                  <!-- <button class="btn btn-primary btn-fw" id="insertBtn">Save</button> -->
                  <button type="button" class="btn btn-outline-info btn-icon-text">Invoice</button>
                  <button type="button" class="btn btn-outline-info btn-icon-text" id="insertBtn">Invoice & Pay
                    <i class="ti-printer btn-icon-append"></i>
                  </button>
                </div>
              </div>
            </div>
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

    //   $('#serviceTableBody tr').each(function () {
    //     var quantity = parseFloat($(this).find('.editable-quantity').val());
    //     var fee = parseFloat($(this).find('.editable-fee').text());
    //     var discount = parseFloat($(this).find('.editable-discount').text());
    //     var rowTotal = quantity * fee;
    //     var rowDiscountAmount = rowTotal * (discount / 100);
    //     discountAmount += rowDiscountAmount;
    //     totalFee += rowTotal - rowDiscountAmount;
    //   });

    //   $('#totalFee').text(totalFee.toFixed(2));
    //   $('#discountAmount').text(discountAmount.toFixed(2));
    //   $('#discountedTotal').text((totalFee - discountAmount).toFixed(2));
    // }

    function calculateTotalFee() {
      var totalFee = 0;
      var discountAmount = 0;

      $('#serviceTableBody tr').each(function () {
        var quantity = parseFloat($(this).find('.editable-quantity').val());
        var fee = parseFloat($(this).find('.editable-fee').text());
        var discount = parseFloat($(this).find('.editable-discount').text());
        var rowTotal = quantity * fee;
        var rowDiscountAmount = rowTotal * (discount / 100);
        discountAmount += rowDiscountAmount;
        totalFee += rowTotal;
      });

      var discountedTotal = totalFee - discountAmount;

      $('#totalFee').text(totalFee.toFixed(2));
      $('#discountAmount').text(discountAmount.toFixed(2));
      $('#discountedTotal').text(discountedTotal.toFixed(2));
    }



    // $('#search').on('input', function () {
    //   var searchText = $(this).val().toLowerCase();
    //   $('#serviceTypeList tbody tr').each(function () {
    //     var serviceType = $(this).find('.title').text().toLowerCase();
    //     if (serviceTypeType.includes(searchText)) {
    //       $(this).show();
    //     } else {
    //       $(this).hide();
    //     }
    //   });
    // });

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

    function addServiceRow(serviceType, serviceTypeId, serviceFee, expiryDate) {
      var exists = false;

      $('#serviceTableBody tr').each(function () {
        var existingServiceTypeId = $(this).find('td:first').data('service-type-id');
        if (existingServiceTypeId === serviceTypeId) {
          exists = true;
          return false;
        }
      });

      if (!exists) {

        var newRow = '<tr>' +
          '<td data-service-type-id="' + serviceTypeId + '">' + serviceType + '</td>' +
          '<td contenteditable="true" class="editable-fee" style="text-align: center;">' + serviceFee + '</td>' +
          '<td><div class="quantity-input"><span class="quantity-decrement" style="margin-right: -2%; padding: 0%; border-radius: 100%; background:#9da3d5;">-</span><input type="text" class="editable-quantity form-control quantity-box" style="width: 50px; padding: 0%;" value="1"><span class="quantity-increment" style="margin-left: -2%; padding: 0%; border-radius: 100%; margin-right: 1rem; background:#9da3d5;">+</span></div></td>' +
          '<td contenteditable="true" class="editable-discount" style="text-align: center;">0</td>';

        <?php if ($isExpiry == 1): ?>
          newRow += '<td>' + (expiryDate ? '<input type="hidden" class="expiry-date" value="' + expiryDate + '">' + expiryDate.split(' ')[0] : 'Nil') + '</td>';
        <?php endif; ?>

        newRow += '<td><button class="btn btn-danger btn-sm remove-btn" onclick="removeServiceRow(this)"><i class="mdi mdi-delete"></i></button></td>' +
          '</tr>';


        // var newRow = '<tr>' +
        //   '<td data-service-type-id="' + serviceTypeId + '">' + serviceType + '</td>' +
        //   '<td contenteditable="true" class="editable-fee">' + serviceFee + '</td>' +
        //   '<td><div class="quantity-input"><span class="quantity-decrement">-</span><input type="text" class="editable-quantity form-control" value="1"><span class="quantity-increment">+</span></div></td>' +
        //   '<td contenteditable="true" class="editable-discount">0</td>';

        // <?php if ($isExpiry == 1): ?>
          //   newRow += '<td>' + (expiryDate ? '<input type="hidden" class="expiry-date" value="' + expiryDate + '">' + expiryDate : 'Nil') + '</td>';
          // <?php endif; ?>

        // newRow += '<td><button class="btn btn-danger btn-sm remove-btn" onclick="removeServiceRow(this)"><i class="mdi mdi-delete"></i></button></td>' +
        //   '</tr>';
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
        addServiceRow(serviceType, serviceTypeId, serviceFee, expiryDate);
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

        // var quantity = parseFloat($('#quantityInput').val());

        // console.log("Quantity: ", quantity);
        // console.log("Client ID: ", clientId);
        // console.log("Client Name: ", clientName);
        // console.log("Payment Method ID: ", paymentMethodId);
        // console.log("Payment Name: ", paymentName);
        // console.log("Currency: ", currency);
        // console.log("Exchange: ", exchange);
        // console.log("Total Fee: ", totalFee);

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
          var discount = parseFloat(serviceTypeRow.find('.editable-discount').text());
          var expiryDate = serviceTypeRow.find('.expiry-date').val();

          if (expiryDate === undefined) {
            expiryDate = '1970-01-01';
          }

          console.log(expiryDate);

          services.push({
            serviceTypeId: serviceTypeId,
            serviceName: serviceName,
            fee: fee,
            quantity: quantity,
            discount: discount,
            expiryDate: expiryDate
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
            services: services
          },
          success: function (response) {
            // alert('Data inserted successfully!');
            console.log('Data inserted successfully:', response);
            if (response.pdfContent) {
              var decodedPdfContent = atob(response.pdfContent);
              var blob = new Blob([new Uint8Array(decodedPdfContent.split('').map(function (c) {
                return c.charCodeAt(0);
              }))], {
                type: 'application/pdf'
              });
              var link = document.createElement('a');
              link.href = window.URL.createObjectURL(blob);
              //   link.download = 'your_file_name.pdf'; // Specify the desired file name
              link.click();
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

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

<html>

<head>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .invoice-box {
      max-width: 800px;
      margin: auto;
      padding: 30px;
      border: 1px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
      font-size: 16px;
      line-height: 24px;
    }

    .invoice-box table {
      width: 100%;
      line-height: inherit;
      text-align: left;
    }

    .invoice-box table td {
      padding: 5px;
      vertical-align: top;
    }

    .invoice-box table tr.top table td {
      padding-bottom: 20px;
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

    .invoice-box table tr.total td:nth-child(2) {
      border-top: 2px solid #eee;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
      <tr class="top">
        <td colspan="2">
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
            </tr>
          </table>
        </td>
      </tr>

    </table>
    <hr>
    <table>
      <tr class="information">
        <td colspan="2">
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
  </div>
</body>

</html>