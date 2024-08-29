<?php include 'include_common/head.php'; ?>
<?php include 'include_common/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demo.bootstrapdash.com/star-admin2-free/template/pages/tables/basic-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2024 05:42:35 GMT -->

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin2 </title>
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
    <link rel="shortcut icon" href="./public/assets/images/favicon.png" />

    <style>
        #lab-table tfoot {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        #lab-table tfoot .table-totals td {

            border-top: 2px solid #000;

        }

        .table-container {
            max-height: 400px;
            /* Adjust as needed */
            overflow-y: auto;
        }

        @keyframes shine {
            0% {
                left: -50%;
            }

            100% {
                left: 150%;
            }
        }

        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a {
            display: block;
            padding: 8px 16px;
            text-decoration: none;
            color: #333;
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border-color: #4CAF50;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }

        /* Additional Styling */
        .pagination a {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .pagination a.active {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:./public/assets/partials/_navbar.html -->

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:./public/assets/partials/_settings-panel.html -->
            <!-- partial -->
            <!-- partial:./public/assets/partials/_sidebar.html -->
            <?php include 'include_common/sidebar.php'; ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form action="<?= base_url('generateExcelLabReport'); ?>" method="post">
                                    <div class="form-group row">
                                        <div>
                                            <div
                                                style="width:100%; display: flex; align-items: center; justify-content: flex-end; gap:10px">
                                                <button type="submit"
                                                    style="align-self: flex-end;color: white;background-color: #172D88;border-color: #172D88;height: 33px;font-size: 12px;font-weight: 500;box-sizing: border-box;border: 1px solid #CADDFF;padding: 8px 15px;border-radius: 6px;align-items: center;">
                                                    <i class="ti-download"> </i>
                                                    Export
                                                </button>
                                                <div class="col-md-3">

                                                    <label>Search</label>
                                                    <input class="form-control" type="text" name="search"
                                                        id="searchInput" placeholder="Search">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>By Client</label>
                                            <div id="the-basics">
                                                <select class="form-control" name="clientName" id='clientInput'>
                                                    <option value="">All Clients</option>
                                                    <?php foreach ($client_names as $client): ?>
                                                        <option value="<?= $client['client']; ?>">
                                                            <?= $client['client']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>By Users</label>
                                            <div id="the-basics">
                                                <select class="form-control" name="userName" id='userInput'>
                                                    <option value="">All Users</option>
                                                    <?php foreach ($user_names as $user): ?>
                                                        <option value="<?= $user['fName']; ?>">
                                                            <?= $user['fName']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>From</label>
                                            <input class="form-control" type="date" placeholder="From"
                                                id="fromDateInput" name="fromDate">
                                        </div>
                                        <div class="col-md-3">
                                            <label>To</label>
                                            <input class="form-control" type="date" placeholder="To" id="toDateInput"
                                                name="toDate">
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <h4 class="card-title">Lab Report</h4>
                                <div class="col-12 grid-margin">
                                    <!-- <div class="table-container"> -->
                                    <div class="table-responsive">
                                        <table id="lab-table" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Client Name</th>
                                                    <th>Contact</th>
                                                    <th>Gender</th>
                                                    <th>Age</th>
                                                    <th>Added By</th>
                                                    <th>Date</th>
                                                    <th>FEE</th>
                                                    <th>Nationality</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($Tests as $test): ?>
                                                    <tr>
                                                        <td>
                                                            <?= $test['clientName']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $test['contact']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $test['gender']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $test['age']; ?>
                                                        </td>

                                                        <td>
                                                            <?= $test['userName']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $test['CreatedAT']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $test['fee']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $test['country']; ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url('viewTestDetails/' . $test['test_id']); ?>"
                                                                class="btn btn-info btn-sm">View Details</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="table-totals">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Total:</td>
                                                    <td>
                                                        <?= $totalLabFee ?>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- </div> -->
                                </div>

                            </div>
                            <div class="pagination-container">
                                <div class="pagination">
                                    <?= $pager ?>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php include 'include_common/footer.php'; ?>
            </div>
            <!-- plugins:js -->
            <script src="./public/assets/vendors/js/vendor.bundle.base.js"></script>
            <!-- endinject -->
            <!-- Plugin js for this page -->
            <script src="./public/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
            <!-- Add this to your HTML file -->
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

            <!-- End plugin js for this page -->
            <!-- inject:js -->
            <script>
                $(document).ready(function () {
                    $('#searchInput, #userInput, #clientInput, #fromDateInput, #toDateInput').on('input change', function () {
                        var searchValue = $('#searchInput').val();
                        var userName = $('#userInput').val();
                        var clientValue = $('#clientInput').val();
                        var fromDateValue = $('#fromDateInput').val();
                        var toDateValue = $('#toDateInput').val();

                        // console.log('Search Value:', searchValue);
                        // console.log('User Value:', userName);
                        // console.log('Client Value:', clientValue);
                        // console.log('From Date Value:', fromDateValue);
                        // console.log('To Date Value:', toDateValue);

                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url('lab_report'); ?>',
                            data: {
                                search: searchValue,
                                userName: userName,
                                clientName: clientValue,
                                fromDate: fromDateValue,
                                toDate: toDateValue
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    var cleanedTableContent = response.tableContent.trim();
                                    $('.table-responsive').html(cleanedTableContent);
                                    $('#total-lab-fee').text(response.totalLabFee);
                                    console.log(response.totalLabFee);
                                } else {
                                    console.error('Error:', response.error);
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.error('AJAX Error:', textStatus, errorThrown);
                            }
                        });
                    });
                });
            </script>




            <script src="./public/assets/js/off-canvas.js"></script>
            <script src="./public/assets/js/hoverable-collapse.js"></script>
            <script src="./public/assets/js/template.js"></script>
            <script src="./public/assets/js/settings.js"></script>
            <script src="./public/assets/js/todolist.js"></script>
            <!-- endinject -->
            <!-- Custom js for this page-->
            <!-- End custom js for this page-->
</body>


<!-- Mirrored from demo.bootstrapdash.com/star-admin2-free/template/pages/tables/basic-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2024 05:42:35 GMT -->

</html>