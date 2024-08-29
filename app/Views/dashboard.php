<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>




<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="./public/assets/vendors_s/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="./public/assets/js_s/select.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"> -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


  <style>
    .blinking-name {
      animation: blink-animation 1s steps(5, start) infinite;
      -webkit-animation: blink-animation 1s steps(5, start) infinite;
      background-color: yellow;
    }

    .blinking-days {
      animation: blink-animation 1s steps(5, start) infinite;
      -webkit-animation: blink-animation 1s steps(5, start) infinite;
    }

    @keyframes blink-animation {
      to {
        visibility: hidden;
      }
    }

    @-webkit-keyframes blink-animation {
      to {
        visibility: hidden;
      }
    }

    .table-responsive {
      overflow-x: auto;
    }

    .text-danger {
      color: red;
    }

    .text-warning {
      color: yellow;
    }

    @keyframes blink-animation {
      to {
        visibility: hidden;
      }
    }

    @-webkit-keyframes blink-animation {
      to {
        visibility: hidden;
      }
    }

    .table-responsive {
      overflow-x: auto;
    }

    /* .blinking-name {
      background-color: orange;
      color: darkblue;
      padding: 0.25rem 0.5rem;
      animation: blink-animation 1s steps(5, start) infinite;
    }

    @keyframes blink-animation {
      to {
        visibility: hidden;
      }
    }

    .table-responsive {
      overflow-x: auto;
    }

    .table {
      width: 100%;
      max-width: 100%;
      margin-bottom: 1rem;
      background-color: transparent;
    }

    .table th,
    .table td {
      padding: 0.75rem;
      vertical-align: top;
      border-top: 1px solid #dee2e6;
    }

    .table thead th {
      vertical-align: bottom;
      border-bottom: 2px solid #dee2e6;
    }

    .table tbody+tbody {
      border-top: 2px solid #dee2e6;
    } */
  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->

    <!-- partial -->
    <div class="container-fluid page-body-wrapper" style="padding-top: 7%; padding-left: 0%; padding-right:0%;">
      <!-- partial:partials/_settings-panel.html -->
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
              <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 fw-normal">See All</small>
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
      <!-- partial:partials/_sidebar.html -->
      <?php include 'include_common/sidebar.php'; ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" role="tab"
                        aria-controls="overview" aria-selected="true">Overview</a>
                    </li>
                  </ul>
                  <div>
                    <div class="btn-wrapper">
                      <button class="btn btn-primary text-white me-0" data-toggle="modal"
                        data-target="#expenseModal">Expenses</button>
                    </div>
                  </div>
                </div>
                <div class="tab-content tab-content-basic">
                  <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="statistics-details d-flex align-items-center justify-content-between">

                          <?php if ($isHospital): ?>
                            <div class="d-none d-md-block">
                              <h3 class="statistics-title">Total Doctors</h3>
                              <p class="rate-percentage">
                                <?php echo $totalDoctorCount; ?>
                              </p>
                            </div>
                          <?php else: ?>
                            <div class="d-none d-md-block">
                              <h3 class="statistics-title">Total Items</h3>
                              <p class="rate-percentage">
                                <?php echo $totalItemCount; ?>
                              </p>
                            </div>
                          <?php endif; ?>


                          <?php if ($isHospital): ?>
                            <div class="d-none d-md-block">
                              <h3 class="statistics-title">Total Patients</h3>
                              <p class="rate-percentage">
                                <?php echo $totalClientCount; ?>
                              </p>
                            </div>
                          <?php else: ?>
                            <div class="d-none d-md-block">
                              <h3 class="statistics-title">Total Clients</h3>
                              <p class="rate-percentage">
                                <?php echo $totalClientCount; ?>
                              </p>
                            </div>
                          <?php endif; ?>

                          <?php if ($isHospital): ?>
                            <div>
                              <h3 class="statistics-title">Total Appointments</h3>
                              <p class="rate-percentage">
                                <?php echo $totalAppointmentsCount; ?>
                              </p>
                            </div>

                          <?php endif; ?>

                          <div>
                            <h3 class="statistics-title">Total Inventory</h3>
                            <p class="rate-percentage">
                              <?php echo $totalInventoryCount; ?>
                            </p>
                          </div>

                          <div>
                            <h3 class="statistics-title">Invoice Today</h3>
                            <p class="rate-percentage">
                              <?php echo $totalSalesToday; ?>
                            </p>
                          </div>

                          <div>
                            <h3 class="statistics-title">Sales Today</h3>
                            <p class="rate-percentage">
                              <?php echo $totalSaleValueToday; ?>
                            </p>
                          </div>

                          <div class="d-none d-md-block">
                            <h3 class="statistics-title">Total Expenditure</h3>
                            <p class="rate-percentage">
                              <?php echo $TotalExpenditure; ?>
                            </p>
                          </div>

                          <?php if ($isHospital): ?>
                            <div class="d-none d-md-block">
                              <h3 class="statistics-title">Total Revenue JJ</h3>
                              <p class="rate-percentage">
                                <?php echo $totalRevenue; ?>
                              </p>
                            </div>
                          <?php else: ?>
                            <div class="d-none d-md-block">
                              <h3 class="statistics-title">Total Sales</h3>
                              <p class="rate-percentage">
                                <?php echo $totalRevenue; ?>
                              </p>
                            </div>
                          <?php endif; ?>
                          <!-- <div class="d-none d-md-block">
                            <h3 class="statistics-title">Appointments Revenue</h3>
                            <p class="rate-percentage">
                              <?php echo $totalAppointmentsRevenue; ?>
                            </p>
                          </div> -->

                          <!-- <div class="d-none d-md-block">
                            <h3 class="statistics-title">Total Revenue</h3>
                            <p class="rate-percentage">0</p> -->

                        </div>
                        <!-- <div class="d-none d-md-block">
                            <p class="statistics-title">Avg. Time on Site</p>
                            <h3 class="rate-percentage">2m:35s</h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>+0.8%</span></p>
                          </div> -->
                      </div>
                    </div>
                  </div>
                  <div class="row">


                    <div class="col-lg-8 d-flex flex-column">
                      <div class="row flex-grow">
                        <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                            <div class="card-body">
                              <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                  <h4 class="card-title card-title-dash">Sales Performance</h4>
                                  <h5 class="card-subtitle card-subtitle-dash">Select Period</h5>
                                </div>
                                <div class="dropdown">
                                  <button class="btn btn-secondary dropdown-toggle" type="button" id="periodDropdown"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    This week
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="periodDropdown">
                                    <a class="dropdown-item period-selector" href="#" data-period="week">This week</a>
                                    <a class="dropdown-item period-selector" href="#" data-period="month">This month</a>
                                    <a class="dropdown-item period-selector" href="#" data-period="year">This year</a>
                                  </div>
                                </div>
                              </div>
                              <!-- <div class="chartjs-wrapper mt-5">
                                <canvas id="salesLineChart" width="634" height="150"
                                  style="display: block; width: 634px; height: 150px;"
                                  class="chartjs-render-monitor"></canvas>
                              </div> -->

                              <div class="chartjs-wrapper mt-5">
                                <canvas id="salesPerformanceChart"></canvas>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <script>
                      document.querySelectorAll('.period-selector').forEach(item => {
                        item.addEventListener('click', event => {
                          event.preventDefault();
                          let period = event.target.getAttribute('data-period');
                          document.getElementById('periodDropdown').innerText = `This ${period}`;
                          updateChart(period);
                        });
                      });

                      function updateChart(period) {
                        $.ajax({
                          url: "<?= base_url('/dashboard'); ?>",
                          type: 'GET',
                          data: { period: period },
                          dataType: 'json',
                          success: function (response) {
                            if (response && response.salesData) {
                              let salesData = response.salesData;

                              salesPerformanceChart.data.labels = salesData.map(data => data.label);
                              salesPerformanceChart.data.datasets[0].data = salesData.map(data => parseFloat(data.total));
                              salesPerformanceChart.update();
                            } else {
                              console.error('Invalid response format:', response);
                            }
                          },
                          error: function (xhr, status, error) {
                            console.error('AJAX error:', status, error);
                          }
                        });
                      }

                      var ctx = document.getElementById('salesPerformanceChart').getContext('2d');
                      var salesPerformanceChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                          labels: <?= json_encode(array_column($salesData, 'label')); ?>,
                          datasets: [{
                            label: 'Sales',
                            data: <?= json_encode(array_column($salesData, 'total')); ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            pointRadius: 4,
                            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                            pointBorderColor: 'rgba(255, 255, 255, 1)',
                            pointBorderWidth: 2,
                            lineTension: 0.4,
                          }],
                        },
                        options: {
                          maintainAspectRatio: false,
                          responsive: true,
                          scales: {
                            xAxes: [{
                              beginAtZero: true,
                              ticks: {
                                fontColor: '#333',
                              }
                            }],
                            yAxes: [{
                              beginAtZero: true,
                              ticks: {
                                precision: 0,
                                fontColor: '#333',
                              }
                            }]
                          },
                          legend: {
                            display: true,
                            labels: {
                              fontColor: '#333',
                            }
                          },
                          tooltips: {
                            mode: 'index',
                            intersect: false,
                          }
                        }
                      });
                    </script>


                    <div class="col-lg-4 d-flex flex-column">
                      <div class="row flex-grow">
                        <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                          <div class="card bg-primary card-rounded">
                            <div class="card-body pb-0">
                              <h4 class="card-title card-title-dash text-white mb-4">Revenue Summary</h4>
                              <div class="row">
                                <div class="col-sm-6">
                                  <p class="status-summary-ight-white mb-1">Total Revenue</p>
                                  <h2 class="text-info">
                                    <?php echo $totalRevenue; ?>
                                  </h2>
                                </div>
                                <div class="col-sm-6">
                                  <div class="status-summary-chart-wrapper pb-4">
                                    <canvas id="status-summary"></canvas>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- --------------------------------------------------------------------------- -->

                        <!-- --------------------------------------------------------------------------- -->

                        <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                          <div class="card bg-primary card-rounded">
                            <div class="card-body pb-0">
                              <h4 class="card-title card-title-dash text-white mb-4">Monthly Income vs Expenses</h4>
                              <div class="row">
                                <div class="col-sm-6">
                                  <p class="status-summary-ight-white mb-1">Monthly Income</p>
                                  <h2 style="color: #32CD32;">
                                    <?php echo $MonthlyRevenue; ?>
                                  </h2>
                                  <p class="status-summary-ight-white mt-2 mb-1">Monthly Expenses</p>
                                  <h2 style="color: #FFA500;">
                                    <?php echo $TotalMonthlyExpenditure; ?>
                                  </h2>
                                </div>
                                <div class="col-sm-6">
                                  <div class="status-summary-chart-wrapper pb-4">
                                    <canvas id="incomeExpensesChart"></canvas>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <script>
                          document.addEventListener('DOMContentLoaded', function () {
                            var ctx = document.getElementById('incomeExpensesChart').getContext('2d');
                            var incomeExpensesChart = new Chart(ctx, {
                              type: 'doughnut',
                              data: {
                                labels: ['Income', 'Expenses'],
                                datasets: [{
                                  data: [<?php echo $MonthlyRevenue; ?>, <?php echo $TotalMonthlyExpenditure; ?>],
                                  backgroundColor: ['#36A2EB', '#FF6384'],
                                  hoverBackgroundColor: ['#2693e6', '#ff4d6d']
                                }]
                              },
                              options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                legend: {
                                  display: false
                                },
                                cutoutPercentage: 70,
                                tooltips: {
                                  callbacks: {
                                    label: function (tooltipItem, data) {
                                      var dataset = data.datasets[tooltipItem.datasetIndex];
                                      var total = dataset.data.reduce(function (previousValue, currentValue) {
                                        return previousValue + currentValue;
                                      });
                                      var currentValue = dataset.data[tooltipItem.index];
                                      var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                                      return data.labels[tooltipItem.index] + ": " + currentValue + " (" + percentage + "%)";
                                    }
                                  }
                                }
                              }
                            });
                          });
                        </script>

                        <!-- ---------------------------------------------------------------------------- -->



                        <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                            <?php if ($isHospital): ?>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-6">
                                    <div class="d-flex justify-content-between align-items-center mb-2 mb-sm-0">
                                      <div class="circle-progress-width">
                                        <div id="totalVisitors" class="progressbar-js-circle pr-2"></div>
                                      </div>
                                      <div>
                                        <p class="text-small mb-2">Total Appointment</p>
                                        <h4 class="mb-0 fw-bold">
                                          <?php echo $totalAppointmentsCount; ?>
                                        </h4>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                      <div class="circle-progress-width">
                                        <div id="visitperday" class="progressbar-js-circle pr-2"></div>
                                      </div>
                                      <div>
                                        <p class="text-small mb-2">Total Tests </p>
                                        <h4 class="mb-0 fw-bold">
                                          <?php echo $totalTests; ?>
                                        </h4>


                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <?php endif; ?>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-8 d-flex flex-column">
                      <div class="row ">
                        <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                            <div class="card-body">
                              <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                  <h4 class="card-title card-title-dash">Revenue</h4>
                                  <p class="card-subtitle card-subtitle-dash">Monthly Report</p>
                                </div>
                                <div>
                                  <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle toggle-dark btn-lg mb-0 me-0"
                                      type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                      aria-haspopup="true" aria-expanded="false"> This month </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                      <h6 class="dropdown-header">Settings</h6>
                                      <a class="dropdown-item" href="#">Action</a>
                                      <a class="dropdown-item" href="#">Another action</a>
                                      <a class="dropdown-item" href="#">Something else here</a>
                                      <div class="dropdown-divider"></div>
                                      <a class="dropdown-item" href="#">Separated link</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                <div class="d-sm-flex align-items-center mt-4 justify-content-between">
                                  <h2 class="me-2 fw-bold">PKR:
                                    <?php echo $totalHospitalRevenue; ?>
                                  </h2>


                                </div>
                                <div class="me-3">
                                  <div id="marketing-overview-legend"></div>
                                </div>
                              </div>
                              <div class="chartjs-bar-wrapper mt-3">
                                <canvas id="marketingOverviewGraph"></canvas>
                              </div>

                              <script>
                                var ctx = document.getElementById('marketingOverviewGraph').getContext('2d');
                                var myChart = new Chart(ctx, {
                                  type: 'bar',
                                  data: {
                                    labels: <?= json_encode(array_column($combinedData, 'label')); ?>,
                                    datasets: [{
                                      label: 'Monthly Revenue',
                                      data: <?= json_encode(array_column($combinedData, 'total')); ?>,
                                      backgroundColor: 'rgba(75, 192, 192, 0.7)',
                                      borderColor: 'rgba(75, 192, 192, 1)',
                                      borderWidth: 2,
                                      barPercentage: 0.7,
                                    }]
                                  },
                                  options: {
                                    scales: {
                                      x: {
                                        beginAtZero: true,
                                        title: {
                                          display: true,
                                          text: 'Month',
                                          color: '#333'
                                        },
                                        grid: {
                                          color: 'rgba(0, 0, 0, 0.1)'
                                        },
                                        ticks: {
                                          callback: function (value, index, values) {
                                            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                            return months[value];
                                          }
                                        }
                                      },
                                      y: {
                                        beginAtZero: true,
                                        title: {
                                          display: true,
                                          text: 'Total Revenue',
                                          color: '#333'
                                        },
                                        grid: {
                                          color: 'rgba(0, 0, 0, 0.1)'
                                        }
                                      }
                                    },
                                    plugins: {
                                      legend: {
                                        display: true,
                                        position: 'top',
                                        labels: {
                                          boxWidth: 15,
                                          font: {
                                            size: 12
                                          }
                                        }
                                      },
                                      title: {
                                        display: true,
                                        text: 'Total Monthly Revenue',
                                        color: '#444',
                                        font: {
                                          size: 16,
                                          weight: 'bold'
                                        }
                                      }
                                    }
                                  }
                                });
                              </script>


                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded table-darkBGImg">
                            <div class="card-body">
                              <div class="col-sm-8">
                                <h3 class="text-white upgrade-info mb-0">
                                  Enhance your <span class="fw-bold">Campaign</span> for better outreach
                                </h3>
                                <a href="#" class="btn btn-info upgrade-btn">Upgrade Account!</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <?php if ($isHospital): ?>
                        <div class="row flex-grow">
                          <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                    <h4 class="card-title card-title-dash">Revenue</h4>
                                    <h5 class="card-subtitle card-subtitle-dash">Weekly Report</h5>
                                  </div>
                                  <div id="performance-line-legend"></div>
                                </div>
                                <div class="chartjs-wrapper mt-5">
                                  <canvas id="performanceLine"></canvas>
                                </div>
                                <script>
                                  var appointmentsData = <?php echo json_encode($appointmentsData); ?>;
                                  var dates = appointmentsData.map(appointment => appointment.appointmentDate);
                                  var totalRevenue = appointmentsData.map(appointment => appointment.totalRevenue);
                                  var totalAppointments = appointmentsData.map(appointment => appointment.totalAppointments);
                                  console.log('dates:', dates);
                                  console.log('totalRevenue:', totalRevenue);
                                  console.log('totalAppointments:', totalAppointments);


                                  var ctx = document.getElementById('performanceLine').getContext('2d');

                                  var myChart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                      labels: dates,
                                      datasets: [{
                                        label: 'Total Revenue',
                                        data: totalRevenue,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 2,
                                        pointRadius: 4,
                                        pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                                        pointBorderColor: 'rgba(255, 255, 255, 1)',
                                        pointBorderWidth: 2,
                                        lineTension: 0.4,
                                      },
                                      {
                                        label: 'Total Appointments MKD',
                                        data: totalAppointments,
                                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 2,
                                        pointRadius: 4,
                                        pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                                        pointBorderColor: 'rgba(255, 255, 255, 1)',
                                        pointBorderWidth: 2,
                                        lineTension: 0.4,
                                      },
                                      ],
                                    },
                                    options: {
                                      maintainAspectRatio: false,
                                      responsive: true,
                                      scales: {
                                        xAxes: [{
                                          type: 'time',
                                          time: {
                                            unit: 'day',
                                            displayFormats: {
                                              day: 'MMM DD',
                                            },
                                          },
                                          ticks: {
                                            maxTicksLimit: 8,
                                          },
                                        }],
                                        yAxes: [{
                                          beginAtZero: true,
                                          ticks: {
                                            precision: 0,
                                          },
                                        }]
                                      },
                                      legend: {
                                        display: true,
                                        labels: {
                                          fontColor: 'deepskyblue',
                                        },
                                      },
                                      tooltips: {
                                        mode: 'index',
                                        intersect: false,
                                        callbacks: {
                                          label: function (tooltipItem, data) {
                                            var label = data.datasets[tooltipItem.datasetIndex].label || '';
                                            if (label) {
                                              label += ': ';
                                            }
                                            label += tooltipItem.yLabel;
                                            return label;
                                          },
                                          afterLabel: function (tooltipItem, data) {
                                            var dataset = data.datasets[tooltipItem.datasetIndex];
                                            var total = dataset.data.reduce(function (previousValue, currentValue) {
                                              return previousValue + currentValue;
                                            });
                                            return 'Total: ' + total;
                                          }
                                        }
                                      }
                                    },
                                  });
                                </script>


                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endif; ?>

                      <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded">

                            <div class="card-body">
                              <?php if ($isHospital): ?>
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                    <h4 class="card-title card-title-dash">Doctor Details</h4>
                                    <!-- <p class="card-subtitle card-subtitle-dash">You have 50+ new requests</p> -->
                                  </div>
                                  <div>
                                    <!-- <button class="btn btn-primary btn-lg text-white mb-0 me-0" type="button"><i class="mdi mdi-account-plus"></i>Add new member</button> -->
                                  </div>
                                </div>
                                <div class="table-responsive mt-1">
                                  <table class="table select-table">
                                    <thead>
                                      <tr>
                                        <th>
                                          <div class="form-check form-check-flat mt-0">
                                            <label class="form-check-label">
                                              <!-- <input type="checkbox" class="form-check-input" aria-checked="false"> -->
                                              <i class="input-helper"></i>
                                            </label>
                                          </div>
                                        </th>
                                        <th>Profile</th>
                                        <th>Specialization</th>
                                        <th>Experience(years)</th>
                                        <th>Total Appointments</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach ($doctorDetails as $doctor): ?>
                                        <tr>
                                          <td>
                                            <!-- <div class="form-check form-check-flat mt-0">
                                              <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" aria-checked="false">
                                                <i class="input-helper"></i>
                                              </label>
                                            </div> -->
                                          </td>
                                          <td>
                                            <div class="d-flex ">
                                              <!-- Assuming you have an 'Image' field in your doctor's table -->
                                              <?php
                                              $imagePath = base_url('uploads/') . $doctor['ProfileImageURL'];
                                              ?>
                                              <img src="<?php echo $imagePath; ?>" alt="Profile Image">
                                              <div>
                                                <h6>
                                                  <?php echo $doctor['FirstName'] . ' ' . $doctor['LastName']; ?>
                                                </h6>
                                                <p>
                                                  <?php echo $doctor['ContactNumber']; ?>
                                                </p>
                                              </div>
                                            </div>
                                          </td>
                                          <td>
                                            <p>
                                              <?php echo $doctor['specialization_N']; ?>
                                            </p>
                                          </td>
                                          <td>
                                            <p style="padding-left: 50px;">
                                              <?php echo $doctor['ExperienceYears']; ?>
                                            </p>
                                          </td>
                                          <td>
                                            <!-- Assuming you have a field for total appointments in your doctor's table -->
                                            <p style="padding-left: 50px;" class="rate-percentage">
                                              <?php echo $doctor['totalAppointments']; ?>
                                            </p>
                                          </td>
                                        </tr>
                                      <?php endforeach; ?>
                                    </tbody>
                                  </table>
                                </div>
                              <?php endif; ?>
                            </div>
                          </div>
                        </div>
                      </div>



                      <div class="row flex-grow">

                        <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                          <?php if ($isHospital): ?>
                            <div class="card card-rounded">

                              <div class="card-body card-rounded">


                                <h4 class="card-title card-title-dash">Recent Appointments</h4>

                                <!-- Column Names -->
                                <div class="list align-items-center border-bottom py-2">
                                  <div class="wrapper w-100">
                                    <div class="d-flex justify-content-between align-items-center">
                                      <p class="mb-2 font-weight-medium">Client Name</p>
                                      <p class="mb-2 font-weight-medium">Appointment Date</p>
                                      <p class="mb-2 font-weight-medium">Appointment Fee</p>
                                    </div>
                                  </div>
                                </div>

                                <!-- Data Rows -->
                                <?php foreach ($recentAppointments as $appointment): ?>
                                  <div class="list align-items-center border-bottom py-2">
                                    <div class="wrapper w-100">
                                      <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0 text-small text-muted">
                                          <?= $appointment->clientName; ?>
                                        </p>
                                        <p class="mb-0 text-small text-muted">
                                          <?= $appointment->appointmentDate; ?>
                                        </p>
                                        <p class="mb-0 text-small text-muted">
                                          <?= $appointment->appointmentFee; ?>
                                        </p>
                                      </div>
                                    </div>
                                  </div>
                                <?php endforeach; ?>

                              </div>

                            </div>
                          <?php endif; ?>
                        </div>
                        <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                          <?php if ($isHospital): ?>
                            <div class="card card-rounded">
                              <div class="card-body card-rounded">
                                <h4 class="card-title card-title-dash">Recent Tests</h4>

                                <!-- Column Names -->
                                <div class="list align-items-center border-bottom py-2">
                                  <div class="wrapper w-100">
                                    <div class="d-flex justify-content-between align-items-center">
                                      <p class="mb-2 font-weight-medium">Test Name</p>
                                      <p class="mb-2 font-weight-medium">Test Fee</p>
                                    </div>
                                  </div>
                                </div>

                                <!-- Data Rows -->
                                <?php foreach ($TestDetails as $Detail): ?>
                                  <div class="list align-items-center border-bottom py-2">
                                    <div class="wrapper w-100">
                                      <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0 text-small text-muted">
                                          <?= $Detail['title']; ?>
                                        </p>
                                        <p class="mb-0 text-small text-muted">
                                          <?= $Detail['test_fee']; ?>
                                        </p>
                                      </div>
                                    </div>
                                  </div>
                                <?php endforeach; ?>

                              </div>
                            </div>
                          <?php endif; ?>
                        </div>

                      </div>
                    </div>
                    <div class="col-lg-4 d-flex flex-column">
                      <!-- <div class="row flex-grow"> -->
                      <!-- <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title card-title-dash">Todo list</h4>
                                    <div class="add-items d-flex mb-0">

                                      <button class="add btn btn-icons btn-rounded btn-primary todo-list-add-btn text-white me-0 pl-12p"><i class="mdi mdi-plus"></i></button>
                                    </div>
                                  </div>
                                  <div class="list-wrapper">
                                    <ul class="todo-list todo-list-rounded">
                                      <li class="d-block">
                                        <div class="form-check w-100">
                                          <label class="form-check-label">
                                            <input class="checkbox" type="checkbox"> Lorem Ipsum is simply dummy text of the printing <i class="input-helper rounded"></i>
                                          </label>
                                          <div class="d-flex mt-2">
                                            <div class="ps-4 text-small me-3">24 June 2020</div>
                                            <div class="badge badge-opacity-warning me-3">Due tomorrow</div>
                                            <i class="mdi mdi-flag ms-2 flag-color"></i>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="d-block">
                                        <div class="form-check w-100">
                                          <label class="form-check-label">
                                            <input class="checkbox" type="checkbox"> Lorem Ipsum is simply dummy text of the printing <i class="input-helper rounded"></i>
                                          </label>
                                          <div class="d-flex mt-2">
                                            <div class="ps-4 text-small me-3">23 June 2020</div>
                                            <div class="badge badge-opacity-success me-3">Done</div>
                                          </div>
                                        </div>
                                      </li>
                                      <li>
                                        <div class="form-check w-100">
                                          <label class="form-check-label">
                                            <input class="checkbox" type="checkbox"> Lorem Ipsum is simply dummy text of the printing <i class="input-helper rounded"></i>
                                          </label>
                                          <div class="d-flex mt-2">
                                            <div class="ps-4 text-small me-3">24 June 2020</div>
                                            <div class="badge badge-opacity-success me-3">Done</div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="border-bottom-0">
                                        <div class="form-check w-100">
                                          <label class="form-check-label">
                                            <input class="checkbox" type="checkbox"> Lorem Ipsum is simply dummy text of the printing <i class="input-helper rounded"></i>
                                          </label>
                                          <div class="d-flex mt-2">
                                            <div class="ps-4 text-small me-3">24 June 2020</div>
                                            <div class="badge badge-opacity-danger me-3">Expired</div>
                                          </div>
                                        </div>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div> -->
                      <!-- </div>  -->
                      <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                          <!-- <div class="card card-rounded">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="card-title card-title-dash">Type By Amount</h4>
                                  </div>
                                  <canvas class="my-auto" id="doughnutChart" height="200"></canvas>
                                  <div id="doughnut-chart-legend" class="mt-5 text-center"></div>
                                </div>
                              </div>
                            </div>
                          </div> -->
                          <?php if ($isExpiry == 1): ?>
                            <div class="card card-rounded">
                              <div class="card-body card-rounded">
                                <h4 class="card-title card-title-dash">Items Expiring Soon</h4>

                                <!-- Table -->
                                <div class="table-responsive">
                                  <table class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th scope="col">Days</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Expiry</th>

                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach ($expiringItems as $item): ?>
                                        <?php
                                        $daysUntilExpiry = (strtotime($item->expiryDate) - time()) / (60 * 60 * 24);
                                        $daysUntilExpiry = ceil($daysUntilExpiry);
                                        ?>
                                        <tr>
                                          <td>
                                            <?php if ($daysUntilExpiry <= 7): ?>
                                              <span class="blinking-days text-danger"><?= $daysUntilExpiry; ?> days</span>
                                            <?php elseif ($daysUntilExpiry <= 30): ?>
                                              <span class="text-warning"><?= $daysUntilExpiry; ?> days</span>
                                            <?php else: ?>
                                              <?= $daysUntilExpiry; ?> days
                                            <?php endif; ?>
                                          </td>
                                          <td><?= $item->Name; ?></td>
                                          <td><?= $item->Code; ?></td>
                                          <td><?= date('Y-m-d', strtotime($item->expiryDate)); ?></td>
                                        </tr>
                                      <?php endforeach; ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          <?php endif; ?>




                        </div>
                      </div>
                      <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                      <h4 class="card-title card-title-dash">Leave Report</h4>
                                    </div>
                                    <div>
                                      <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle toggle-dark btn-lg mb-0 me-0"
                                          type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown"
                                          aria-haspopup="true" aria-expanded="false"> Month Wise </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                          <h6 class="dropdown-header">week Wise</h6>
                                          <a class="dropdown-item" href="#">Year Wise</a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="mt-3">
                                    <canvas id="leaveReport"></canvas>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                      <h4 class="card-title card-title-dash">Users Details</h4>
                                    </div>
                                  </div>
                                  <div class="mt-3">
                                    <?php foreach ($userDetails as $user): ?>
                                      <div
                                        class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                        <div class="d-flex">
                                          <img class="img-sm rounded-10"
                                            src="<?php echo base_url('uploads/') . $user['CNIC_img']; ?>" alt="profile">
                                          <div class="wrapper ms-3">
                                            <div>
                                              <h6>
                                                <?php echo $user['fName'] . ' ' . $user['lName']; ?>
                                              </h6>
                                              <p>
                                                <?php echo $user['phone']; ?>
                                              </p>
                                            </div>

                                          </div>
                                        </div>
                                      </div>
                                    <?php endforeach; ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
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
  <!-- partial:partials/_footer.html -->
  <!-- Modal -->
  <div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="expenseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="expenseModalLabel">Add Expense</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="pt-3" method="POST" action="<?php echo base_url() . 'save_expense'; ?>"
            enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Date of Expense</label>
                  <div class="col-sm-9">
                    <input type="date" class="form-control" name="date_exp" value="<?= date('Y-m-d'); ?>" required />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Category</label>
                  <div class="col-sm-9">
                    <select class="form-control" name="category">
                      <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Amount</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="amount" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Project</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="project" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Title</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="title" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Description</label>
                  <div class="col-sm-9">
                    <textarea type="text" class="form-control" name="description"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Client Name</label>
                  <div class="col-sm-9">
                    <select class="form-control" name="client">
                      <option value="">-- Select Client --</option>
                      <?php foreach ($client_names as $client): ?>
                        <option value="<?= $client['idClient']; ?>">
                          <?= $client['clientUniqueId']; ?> - <?= $client['client']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Team Member</label>
                  <div class="col-sm-9">
                    <select class="form-control" name="teamMember">
                      <?php foreach ($users as $user): ?>
                        <option value="<?= $user['ID'] ?>"><?= $user['fName'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">TAX</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="tax_1" value="0.0" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Second TAX</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="tax_2" value="0.0" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <input type="checkbox" class="form-check-input" name="recurring"
                    style="margin-left: 9rem; display:flex">
                  <span style="margin-left: 11rem; margin-top: -19px;">Recurring</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label"></label>
                  <div class="col-sm-9">
                    <input type="file" class="form-control-file" name="image" />
                  </div>
                </div>
              </div>
            </div>
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

  <!-- partial -->
  </div>
  <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="./public/assets/vendors_s/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="./public/assets/vendors_s/chart.js/Chart.min.js"></script>
  <script src="./public/assets/vendors_s/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="./public/assets/vendors_s/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="./public/assets/js_s/off-canvas.js"></script>
  <script src="./public/assets/js_s/hoverable-collapse.js"></script>
  <script src="./public/assets/js_s/template.js"></script>
  <script src="./public/assets/js_s/settings.js"></script>
  <script src="./public/assets/js_s/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="./public/assets/js_s/dashboard.js"></script>
  <script src="./public/assets/js_s/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

<?php include 'include_common/footer.php'; ?>