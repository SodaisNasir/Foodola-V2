<?php 
include('connection.php');
include('assets/header.php');

if (isset($_GET['Massage'])) {
    $message = htmlspecialchars($_GET['Massage'], ENT_QUOTES, 'UTF-8');
    echo "<script>alert('$message')</script>";
}
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php include('title.php'); echo isset($pageTitle) ? $pageTitle : 'Manage Timing'; ?></title>
    
    <!-- Vendor CSS -->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <!-- Custom Modern UI Styles -->
    <style>
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 20px 0 rgba(0,0,0,0.05);
            border: none;
        }
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #f2f2f2;
            padding: 1.5rem;
        }
        .table thead th {
            border-top: none;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6e6b7b;
            background-color: #f8f8f8;
        }
        .table td {
            vertical-align: middle !important;
            font-size: 0.9rem;
        }
        .badge-day {
            background-color: #e0e7ff;
            color: #4338ca;
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 0.75rem;
            font-weight: 600;
            margin: 2px;
            display: inline-block;
        }
        .badge-status-active {
            background-color: #d1fae5;
            color: #065f46;
            padding: 5px 12px;
            border-radius: 50px;
            font-weight: 600;
        }
        .badge-status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 5px 12px;
            border-radius: 50px;
            font-weight: 600;
        }
        /* Custom Modern Checkbox Buttons for Days */
        .day-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .day-selector input[type="checkbox"] {
            display: none;
        }
        .day-selector label {
            padding: 8px 14px;
            background-color: #f3f4f6;
            color: #4b5563;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s ease;
            user-select: none;
            margin: 0;
            border: 1px solid #e5e7eb;
        }
        .day-selector input[type="checkbox"]:checked + label {
            background-color: #7367f0;
            color: #ffffff;
            border-color: #7367f0;
            box-shadow: 0 2px 6px rgba(115, 103, 240, 0.4);
        }
        .modal-content {
            border-radius: 12px;
            border: none;
        }
        .modal-header {
            border-bottom: 1px solid #f2f2f2;
            padding: 1.25rem 1.5rem;
        }
        .modal-body {
            padding: 1.5rem;
        }
        .btn-rounded {
            border-radius: 8px;
        }
        .time-box {
            font-family: monospace;
            background: #f8f9fa;
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid #e9ecef;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu-modern semi-dark-layout 12-columns navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="12-columns" data-layout="semi-dark-layout">

    <!-- BEGIN: Main Menu-->
    <?php include('assets/Site_Bar.php') ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Manage Products Timing</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active">Products Timing Schedule</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title font-weight-bold">Product Schedule Timings</h4>
                                    <button class="btn btn-primary btn-rounded shadow-sm" data-toggle="modal" data-target="#AddTableModal">
                                        <i class="feather icon-plus mr-50"></i> Add New Schedule
                                    </button>
                                </div>

                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-hover">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Schedule Name</th>
                                                        <th>Available Days</th>
                                                        <th>Start Time</th>
                                                        <th>End Time</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $sql = "SELECT * FROM `product_timings` ORDER BY id DESC";
                                                    $result = mysqli_query($conn, $sql);
                                                    $index = 1;

                                                    if ($result && mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $timingName = htmlspecialchars($row['timing_name']);
                                                            $daysStr    = htmlspecialchars($row['days']);
                                                            $startTime  = date("g:i A", strtotime($row['start_time']));
                                                            $endTime    = date("g:i A", strtotime($row['end_time']));
                                                            $status     = strtolower($row['status']);

                                                            // Days Ko Badges Me Convert Krne Ke Liay
                                                            $daysArray = !empty($daysStr) ? explode(',', $daysStr) : [];
                                                            $daysHtml = '';
                                                            foreach ($daysArray as $d) {
                                                                $daysHtml .= "<span class='badge-day'>" . trim($d) . "</span>";
                                                            }

                                                            $statusBadge = ($status == 'active') 
                                                                ? "<span class='badge-status-active'>Active</span>" 
                                                                : "<span class='badge-status-inactive'>Inactive</span>";

                                                            echo "<tr>";
                                                            echo "<td class='font-weight-bold'>{$index}</td>";
                                                            echo "<td class='font-weight-bold text-primary'>{$timingName}</td>";
                                                            echo "<td>" . ($daysHtml ?: "<span class='text-muted'>All Days</span>") . "</td>";
                                                            echo "<td><span class='time-box'>{$startTime}</span></td>";
                                                            echo "<td><span class='time-box'>{$endTime}</span></td>";
                                                            echo "<td>{$statusBadge}</td>";
                                                            echo "<td>
                                                                    <div class='d-flex justify-content-center align-items-center gap-1'>
                                                                        <button class='btn btn-sm btn-outline-primary mr-1 btn-rounded'
                                                                            data-toggle='modal'
                                                                            data-target='#updateTableModal'
                                                                            data-id='{$row['id']}'
                                                                            data-timing_name='{$timingName}'
                                                                            data-days='{$daysStr}'
                                                                            data-start_time='{$row['start_time']}'
                                                                            data-end_time='{$row['end_time']}'
                                                                            data-status='{$status}'
                                                                            onclick='openUpdateModalFromBtn(this)'>
                                                                            <i class='feather icon-edit'></i> Edit
                                                                        </button>

                                                                        <form action='phpfiles/insertions.php' method='POST' class='m-0 p-0'>
                                                                            <input type='hidden' name='ti_id' value='{$row['id']}'>
                                                                            <button type='submit' name='btn_delete_time' class='btn btn-sm btn-outline-danger btn-rounded'
                                                                                onclick='return confirm(\"Are you sure you want to delete this schedule?\")'>
                                                                                <i class='feather icon-trash-2'></i> Delete
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </td>";
                                                            echo "</tr>";
                                                            $index++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ADD TIMING MODAL -->
                <div class="modal fade" id="AddTableModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title font-weight-bold">Add Schedule Timing</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="phpfiles/insertions.php" method="POST">

                                    <div class="form-group mb-2">
                                        <label class="font-weight-bold">Schedule Title / Name</label>
                                        <input type="text" class="form-control" name="timing_name" placeholder="e.g. Breakfast Hours, Night Offer" required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="font-weight-bold d-block">Select Days</label>
                                        <div class="day-selector">
                                            <?php 
                                            $weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                                            foreach($weekDays as $day) {
                                                echo "<input type='checkbox' name='days[]' value='{$day}' id='add_day_{$day}'>
                                                      <label for='add_day_{$day}'>{$day}</label>";
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-2">
                                            <label class="font-weight-bold">Start Time</label>
                                            <input type="time" class="form-control" name="start_time" required>
                                        </div>

                                        <div class="col-md-6 form-group mb-2">
                                            <label class="font-weight-bold">End Time</label>
                                            <input type="time" class="form-control" name="end_time" required>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>

                                    <button type="submit" name="btn_insert_pro_timing" class="btn btn-primary w-100 btn-rounded font-weight-bold py-1">Save Schedule</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- UPDATE TIMING MODAL -->
                <div class="modal fade" id="updateTableModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title font-weight-bold">Update Schedule Timing</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="phpfiles/insertions.php" method="POST">

                                    <input type="hidden" name="timing_id" id="update_id">

                                    <div class="form-group mb-2">
                                        <label class="font-weight-bold">Schedule Title / Name</label>
                                        <input type="text" class="form-control" id="update_timing_name" name="timing_name" required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="font-weight-bold d-block">Select Days</label>
                                        <div class="day-selector">
                                            <?php 
                                            foreach($weekDays as $day) {
                                                echo "<input type='checkbox' class='update-day-cb' name='days[]' value='{$day}' id='update_day_{$day}'>
                                                      <label for='update_day_{$day}'>{$day}</label>";
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-2">
                                            <label class="font-weight-bold">Start Time</label>
                                            <input type="time" class="form-control" id="update_start_time" name="start_time" required>
                                        </div>

                                        <div class="col-md-6 form-group mb-2">
                                            <label class="font-weight-bold">End Time</label>
                                            <input type="time" class="form-control" id="update_end_time" name="end_time" required>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Status</label>
                                        <select class="form-control" id="update_status" name="status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>

                                    <button type="submit" name="btn_update_pro_timing" class="btn btn-primary w-100 btn-rounded font-weight-bold py-1">Update Schedule</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- JS Files -->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>

    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="app-assets/js/scripts/components.min.js"></script>

    <script>
    function openUpdateModalFromBtn(button) {
        let id = $(button).data('id');
        let timingName = $(button).data('timing_name');
        let days = $(button).data('days');
        let startTime = $(button).data('start_time');
        let endTime = $(button).data('end_time');
        let status = $(button).data('status');

        $('#update_id').val(id);
        $('#update_timing_name').val(timingName);
        $('#update_start_time').val(startTime);
        $('#update_end_time').val(endTime);
        $('#update_status').val(status);

        // Clear previous checkbox selections
        $('.update-day-cb').prop('checked', false);

        // Select checkboxes dynamically
        if(days) {
            let selectedDays = days.toString().split(',');
            selectedDays.forEach(function(day) {
                $(`#update_day_${day.trim()}`).prop('checked', true);
            });
        }
    }

    $(document).ready(function() {
        $('#example').DataTable({
            "responsive": true,
            "order": [[ 0, "desc" ]],
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search schedule..."
            }
        });
    });
    </script>

</body>
</html>