<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" href="./public/assets/vendors_s/select2/select2.min.css">
  <link rel="stylesheet" href="./public/assets/vendors_s/select2-bootstrap-theme/select2-bootstrap.min.css">
  <style>
    .badge-pill:hover {
      background-color: #52CDFF;
      /* Change this to the desired hover background color */
      color: #fff;
      /* Change this to the desired hover text color */
      cursor: pointer;
    }

    #clientDetails {
      font-weight: 750;
    }

    .twitter-typeahead {
      max-width: 100%;
      width: 100%;

    }

    #cat {
      width: 56%;
      height: 0rem;
      margin-bottom: -28px
    }

    #cat:hover {
      background-color: #800080;
      color: #fff;
      font-weight: 950;
      width: 58%;
      HEIGHT: 0rem;
      margin-bottom: -28px
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


    .table tbody tr {
      height: 30px;
    }

    .table thead tr {
      height: 30px;
    }


    .table tbody td {
      padding: 5px;
    }

    .table thead tr {
      padding: 5px;
    }
  </style>
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
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card" style="margin-bottom: -16px; margin-top: -17px;">
                <div class="card-body">
                  <p class="card-description"
                    style="margin-top: -19px; margin-bottom: 20px; font-weight: bold;color: black">
                    Categories
                  </p>
                  <div class="row" id="categoryButtons">
                    <?php foreach ($categories as $category): ?>
                      <button style="width: auto;height: 41px;margin-top: -19px;margin-bottom: -15px;margin-left: 11px"
                        class="btn btn-outline-secondary btn-category" data-category-id="<?= $category['idCatArt']; ?>">
                        <?= $category['name']; ?>
                      </button>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
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
                          <select class="typeahead form-control" name="clientName">
                            <?php foreach ($client_names as $client): ?>
                              <option value="<?= $client['idClient']; ?>">
                                <?= $client['client']; ?>
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
                        <table class="table" id="serviceTypeList">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Price</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($services as $service): ?>
                              <tr data-service-type-id="<?= $service['idArtMenu']; ?>">
                                <td class="title">
                                  <?= $service['Name']; ?>
                                </td>
                                <td class="fee" contenteditable="true">
                                  <?= $service['Price']; ?>
                                </td>
                                <td><span class="badge badge-primary badge-pill hover-effect"
                                    onclick="addService()">ADD</span></td>
                              </tr>

                            <?php endforeach; ?>
                          </tbody>
                        </table>
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
                  </p>
                  <hr>
                  <div class="row">
                    <div class="col-md-6" id="clientDetailsLeft"></div>
                    <div class="col-md-6" id="clientDetailsRight"></div>
                  </div>
                  <hr>
                  <div id="summaryTableContainer">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Service Type</th>
                          <th>Amount</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody id="serviceTableBody"></tbody>
                    </table>
                  </div>
                </div>
                <div style="margin-left: 400px; font-weight: 900; font-size: 150px">
                  <p>Total Fee: <span id="totalFee">0</span></p>
                </div>
                <div style="height: 50px; margin-left: 1.4em; font-weight: 900; font-size: 150px">
                  <!-- <button class="btn btn-primary btn-fw" id="insertBtn">Save</button> -->
                  <button type="button" class="btn btn-outline-info btn-icon-text" id="insertBtn">Print
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

  <script>

    function addServiceRow(serviceType, serviceTypeId, serviceFee) {
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
          '<td>' + serviceFee + '</td>' +
          '<td><button class="btn btn-danger btn-sm remove-btn" onclick="removeServiceRow(this)">Remove</button></td>' +
          '</tr>';
        $('#serviceTableBody').append(newRow);
        calculateTotalFee();
      } else {
        alert('This service is already added to the summary.');
      }
    }

    $(document).ready(function () {

      $('#serviceTypeList .badge').click(function () {
        var serviceTypeRow = $(this).closest('tr');
        var serviceTypeId = serviceTypeRow.data('service-type-id');
        var serviceType = serviceTypeRow.find('.title').text().trim();
        var serviceFee = serviceTypeRow.find('.fee').text().trim();
        console.log("Service Type: ", serviceType);
        console.log("Service Type ID: ", serviceTypeId);
        console.log("Service Fee: ", serviceFee);
        addServiceRow(serviceType, serviceTypeId, serviceFee);
        calculateTotalFee();
      });

      function attachAddServiceHandler() {
        $('#serviceTypeList .badge').click(function () {
          var serviceTypeRow = $(this).closest('tr');
          var serviceTypeId = serviceTypeRow.data('service-type-id');
          var serviceType = serviceTypeRow.find('.title').text().trim();
          var serviceFee = serviceTypeRow.find('.fee').text().trim();
          console.log("Service Type: ", serviceType);
          console.log("Service Type ID: ", serviceTypeId);
          console.log("Service Fee: ", serviceFee);
          addServiceRow(serviceType, serviceTypeId, serviceFee);
          calculateTotalFee();
        });
      }

      // Filter services based on categories
      // $('.btn-category').click(function () {
      //   var categoryId = $(this).data('category-id');
      //   filterServices(categoryId);
      // });

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

      $('#search').on('input', function () {
        var searchText = $(this).val().toLowerCase();
        $('#serviceTypeList tbody tr').each(function () {
          var serviceName = $(this).find('.title').text().toLowerCase();
          var servicePrice = $(this).find('.fee').text().toLowerCase();
          if (serviceName.includes(searchText) || servicePrice.includes(searchText)) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      });

      $('.btn-category').click(function () {
        var categoryId = $(this).data('category-id');

        $('.btn-category.active').removeClass('active');

        $(this).addClass('active');

        filterServices(categoryId);
      });

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

      function calculateTotalFee() {
        var totalFee = 0;

        $('#serviceTableBody tr').each(function () {
          var fee = parseFloat($(this).find('td:eq(1)').text());
          if (!isNaN(fee)) {
            totalFee += fee;
          }
        });

        $('#totalFee').text(totalFee.toFixed(2));
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

        console.log("Client ID: ", clientId);
        console.log("Client Name: ", clientName);
        console.log("Payment Method ID: ", paymentMethodId);
        console.log("Payment Name: ", paymentName);
        console.log("Currency: ", currency);
        console.log("Exchange: ", exchange);
        console.log("Total Fee: ", totalFee);

        if (!clientId || isNaN(totalFee)) {
          alert('Invalid data for insertion.');
          return;
        }
        var services = [];
        $('#serviceTableBody tr').each(function () {
          //var serviceTypeId = $(this).find('td:eq(0)').data('service-type-id');
          // var serviceTypeId = 12;
          var serviceTypeId = $('#serviceTypeList .badge').closest('tr').data('service-type-id');
          var serviceName = $(this).find('td:eq(0)').text();
          var fee = parseFloat($(this).find('td:eq(1)').text());

          console.log("Service Type ID: ", serviceTypeId);
          console.log("Service Name: ", serviceName);
          console.log("Fee: ", fee);

          services.push({
            serviceTypeId: serviceTypeId,
            serviceName: serviceName,
            fee: fee,
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

////////////////////////////////////////////////////////////////////////
pdf
////////////////////////////////////////////////////////////////////////
<!DOCTYPE html>
<html>
<!-- <html lang="ar"> for arabic only -->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <title>Express Wash Customer Invoice</title>

  <style>
    @media print {
      @page {
        margin: 0 auto;
        sheet-size: 300px 250mm;
      }

      html {
        direction: rtl;
      }

      html,
      body {
        font-size: 12px;
        margin: 0;
        padding: 0
      }

      #printContainer {
        font-size: 12px;
        width: 250px;
        margin: auto;
        /*padding: 10px;*/
        /*border: 2px dotted #000;*/
        text-align: justify;
      }

      /*span {
                display: inline-block;
                min-width: 350px;
                white-space: nowrap;
                background: red;
            }*/

      .text-center {
        text-align: center;
      }
    }
  </style>
</head>

<body onload="window.print();">
  <h1 id="logo" class="text-center" style="margin-top: 5px; margin-bottom: 5px;">
    <?php
    $session = session();
    if ($session->has('businessProfileImage')) {
      echo '<img class="img-xs rounded-circle larger-profile-img" style="width: 120px; height: 120px; margin-top: 10px; margin-bottom: 10px;" src="' . $session->get('businessProfileImage') . '" alt="Profile image">';
    } else {
      // Default image or alternative content if the session variable is not set
      echo '<img style="width: 120px; height: 120px; margin-top: 5px; margin-bottom: 5px;" src="' . base_url() . './public/assets/images/regexbyte.png" alt="Default Logo">';
    }
    ?>
  </h1>


  <div id='printContainer'>

    <?php
    $session = session();
    if ($session->has('businessName') && $session->has('phoneNumber') && $session->has('business_address')) {
      echo '<h2 id="slogan" style="margin: 0; font-size: 12px;" class="text-center"><span class="text-black fw-bold" style="font-weight: bold;">' . $session->get('businessName') . '</span></h2>';

      echo '<p id="slogan" class="text-center" style="margin: 0; font-size: 12px;"><span class="text-black fw-bold" style="font-weight: normal;">' . $session->get('phoneNumber') . '</span></p>';
      echo '<p id="slogan" class="text-center" style="margin: 0; font-size: 12px;"><span class="text-black fw-bold" style="font-weight: normal;">' . $session->get('business_address') . '</span></p>';

      echo '<br>';
    }
    ?>

    <table>

      <?php
      date_default_timezone_set('Asia/Karachi');
      $peshawarTimeZone = new DateTimeZone('Asia/Karachi');
      $currentDateTime = new DateTime('now', $peshawarTimeZone);
      $date = $currentDateTime->format('d-m-Y');
      $time = $currentDateTime->format('h:i:s');
      ?>
      <tr>
        <td style="width: 50%;">Invoice# <b>59867</b> </td>
        <td style="width: 50%; text-align: right;">Date:<b>
            <?= $date; ?>
          </b></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left; margin-right: 5px;">Time:<b>
            <?= $time; ?>
          </b><br></td>
      </tr>

      <tr>
        <td style=" width: 50%; white-space: nowrap;">Patient Name:<b>
            <?= $clientName ?>
          </b></td>
        <td style=" width: 50%; white-space: nowrap;text-align: right;padding-right:15px;">Currency:<b>
            <?= $currencyName; ?>
          </b></td>


      </tr>

      <tr>

        <td style=" width: 50%; white-space: nowrap;">PaymentMethod:<b>
            <?= $paymentMethodName; ?>
          </b></td>
        <td style=" width: 50%; white-space: nowrap;text-align: right;padding-right:23px;">Exchange:<b>
            <?= $invoiceData['rate'] ?>
          </b></td>
      </tr>

      <tr>
        <td colspan="2"></td>
      </tr>
    </table>
    <hr>

    <table>
      <tr>
        <td><b>Service Name</b></td>
        <td style="padding-left: 100px;"><b>Fee</b></td>
      </tr>

      <?php
      if (!empty ($services)) {
        foreach ($services as $service) {
          echo '<tr>';
          echo '<td style="margin-left: 20px;">' . $service['serviceName'] . '</td>';
          echo '<td style="padding-left:100px">' . $service['fee'] . '</td>';
          echo '</tr>';
        }
      } else {
        echo '<tr>';
        echo '<td colspan="2">No service details available.</td>';
        echo '</tr>';
      }
      ?>
    </table>

    <hr>
    <table style="width: 100%;">
      <tr>
        <td style="width: 50%; text-align: left;">&nbsp;</td>
        <td style="width: 25%; text-align: right; padding-right:10px;"><b>Total</b> PKR:
          <?= $invoiceData['Value']; ?>
        </td>
      </tr>
    </table>
    <br>


    <div style="text-align:center">
      <a style="text-decoration:none" href="www.regexbyte.com">www.regexbyte.com</a>
    </div>

  </div>
</body>

</html>