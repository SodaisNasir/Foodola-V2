<?php include('assets/header.php') ?>

<!DOCTYPE html>
<!--
Template Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
Author: PixInvent
Website: http://www.pixinvent.com/
Contact: hello@pixinvent.com
Follow: www.twitter.com/pixinvents
Like: www.facebook.com/pixinvents
Purchase: https://1.envato.market/vuexy_admin
Renew Support: https://1.envato.market/vuexy_admin
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.

-->

<?php

if (isset($_GET['Massage'])) {
  if ($_GET['Massage'] == 'Sucessfully updated timings.') {
    echo "<script>alert('Sucessfully updated timings.')</script>";
    header("Refresh: 1; url='managetimings.php'");
  } else {
    echo "<script>alert('There was some issue.')</script>";
  }
}



include('connection.php'); // ensure you have DB connection
$query = "SELECT * FROM holiday_timings ORDER BY date ASC";
$result = mysqli_query($conn, $query);

echo "<script>";
while ($row = mysqli_fetch_assoc($result)) {
  $date = $row['date'];
  $start1 = $row['start_time_1'];
  $end1 = $row['end_time_1'];
  $start2 = $row['start_time_2'];
  $end2 = $row['end_time_2'];

  echo "addHolidayRow('$date', '$start1', '$end1', '$start2', '$end2');";
}
echo "</script>";



?>


<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/form-validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:57 GMT -->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
  <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="PIXINVENT">
  <title><?php
          include('title.php');
          echo $pageTitle

          ?></title>
  <link rel="apple-touch-icon" href="app-assets/images/ico/apple-icon-120.html">
  <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- BEGIN: Vendor CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
  <!-- END: Vendor CSS-->

  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/colors.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/components.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.min.css">

  <!-- BEGIN: Page CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/validation/form-validation.css">
  <!-- END: Page CSS-->

  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <!-- END: Custom CSS-->
  <!-- Flatpickr CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <!-- Add this in your HTML head -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

  <!-- BEGIN: Header-->


  <!-- END: Header-->


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
              <h2 class="content-header-title float-left mb-0">Manage Shedule</h2>
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Home</a>
                  </li>
                  <li class="breadcrumb-item active">Manage Shedule
                  </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--<div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">-->
        <!--  <div class="form-group breadcrum-right">-->
        <!--    <div class="dropdown">-->
        <!--      <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-settings"></i></button>-->
        <!--      <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Chat</a><a class="dropdown-item" href="#">Email</a><a class="dropdown-item" href="#">Calendar</a></div>-->
        <!--    </div>-->
        <!--  </div>-->
        <!--</div>-->
      </div>
      <div class="content-body"><!-- Simple Validation start -->


        <?php
        // Fetch existing working hours from DB
        // include 'connection.php'; // adjust this path if needed
        //     error_reporting(E_ALL);
        // ini_set('display_errors', 1);
        $data = [];
        $query = mysqli_query($conn, "SELECT * FROM tbl_working_hours");
        while ($row = mysqli_fetch_assoc($query)) {
          $data[strtolower(substr($row['day'], 0, 3))] = $row;
        }


        $open_status = 1; // default
        $res = mysqli_query($conn, "SELECT `is_open` FROM `system_setting` LIMIT 1");
        if ($res && mysqli_num_rows($res) > 0) {
          $row = mysqli_fetch_assoc($res);
          $open_status = $row['is_open'];
        }
        ?>

        <section class="simple-validation">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Customize Daily Timings</h4>
                </div>
                <div class="card-body">
                  <form class="form-horizontal" action="phpfiles/insertions.php" method="POST">
                    <div class="table-responsive">




                      <div class="col-md-3 mb-3 ml-2">
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" name="is_open" value="1" id="flexSwitchCheckDefault" <?php echo $open_status ? 'checked' : ''; ?>>
                          <label class="form-check-label" for="flexSwitchCheckDefault">
                            Restaurant Status (<?php echo $open_status ? 'Open' : 'Closed'; ?>)
                          </label>
                        </div>
                      </div>



                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Day</th>
                            <th>From - To (Shift 1)</th>
                            <th>From - To (Shift 2)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                          foreach ($days as $day) {
                            $dayKey = strtolower(substr($day, 0, 3));
                            $timing = isset($data[$dayKey]) ? $data[$dayKey] : [
                              'start_time_1' => '',
                              'end_time_1' => '',
                              'start_time_2' => '',
                              'end_time_2' => '',
                              'is_holiday' => 0
                            ];
                          ?>
                            <tr>
                              <td>
                                <?php echo $day; ?><br>
                                <div class="form-check mt-1">
                                  <input type="checkbox" name="<?php echo $dayKey; ?>_holiday" class="form-check-input" value="1"
                                    <?php echo ($timing['is_holiday'] ?? 0) ? 'checked' : ''; ?>>
                                  <label class="form-check-label">Mark as Holiday</label>
                                </div>
                              </td>
                              <td>
                                <div class="d-flex align-items-center gap-1">
                                  <input type="time" name="<?php echo $dayKey; ?>_from1" class="form-control" value="<?php echo $timing['start_time_1']; ?>">
                                  <span>-</span>
                                  <input type="time" name="<?php echo $dayKey; ?>_to1" class="form-control" value="<?php echo $timing['end_time_1']; ?>">
                                </div>
                              </td>
                              <td>
                                <div class="d-flex align-items-center gap-1">
                                  <input type="time" name="<?php echo $dayKey; ?>_from2" class="form-control" value="<?php echo $timing['start_time_2']; ?>">
                                  <span>-</span>
                                  <input type="time" name="<?php echo $dayKey; ?>_to2" class="form-control" value="<?php echo $timing['end_time_2']; ?>">
                                </div>
                              </td>
                            </tr>
                          <?php
                          }
                          ?>
                        </tbody>

                      </table>
                    </div>


                    <div class="form-group mt-3 text-center">
                      <button type="submit" name="btnSubmit_insertTimings" class="btn btn-success">Save Timings</button>
                    </div>
                  </form>


                  <hr>
                  <div class="text-end mb-3">
                    <button type="button" class="btn btn-primary" onclick="addHolidayRow()">
                      <i class="fas fa-plus-circle me-1"></i> Add Holiday
                    </button>
                  </div>


                  <h5 class="mt-4 mb-3 fs-4 text-dark">
                    <i class="fas fa-calendar-day me-1"></i> Holiday Timings
                  </h5>

                  <form action="phpfiles/insertions.php" method="POST" class="p-3 rounded  bg-white border">
                    <div id="holiday-container" class="row g-3">
                      <!-- Holiday rows will be appended here dynamically -->
                    </div>

                    <div class="text-center mt-4">
                      <button type="submit" name="btnSubmitHolidays" class="btn btn-success px-4">
                        <i class="fas fa-save me-1"></i> Save Holidays
                      </button>
                    </div>
                  </form>




                </div>
              </div>
            </div>
          </div>
        </section>



        <!-- Input Validation end -->


        <!-- Input Validation end -->

      </div>
    </div>
  </div>
  <!-- END: Content-->




  <!--</div>-->
  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>




  <!-- BEGIN: Vendor JS-->
  <script src="app-assets/vendors/js/vendors.min.js"></script>
  <!-- BEGIN Vendor JS-->

  <!-- BEGIN: Page Vendor JS-->
  <script src="app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
  <!-- END: Page Vendor JS-->

  <!-- BEGIN: Theme JS-->
  <script src="app-assets/js/core/app-menu.min.js"></script>
  <script src="app-assets/js/core/app.min.js"></script>
  <script src="app-assets/js/scripts/components.min.js"></script>
  <script src="app-assets/js/scripts/customizer.min.js"></script>
  <script src="app-assets/js/scripts/footer.min.js"></script>
  <!-- END: Theme JS-->

  <!-- BEGIN: Page JS-->
  <script src="app-assets/js/scripts/forms/validation/form-validation.js"></script>
  <!-- END: Page JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

<script>
  let holidayCount = 0;

  function addHolidayRow(date = '', from1 = '', to1 = '', from2 = '', to2 = '', dbId = null) {
    const container = document.getElementById('holiday-container');

    const row = document.createElement('div');
    row.classList.add('row', 'mb-3', 'holiday-row');

    if (dbId) {
      row.setAttribute('data-id', dbId);
    }

    row.innerHTML = `
  <div class="col-md-3 mb-2">
    <label class="form-label text-dark">Date</label>
    <input type="date" name="holiday_dates[${holidayCount}][date]" class="form-control" value="${date}" required>
  </div>
  <div class="col-md-2 mb-2">
    <label class="form-label text-dark">Shift 1 Start</label>
    <input type="time" name="holiday_dates[${holidayCount}][start1]" class="form-control" value="${from1}">
  </div>
  <div class="col-md-2 mb-2">
    <label class="form-label text-dark">Shift 1 End</label>
    <input type="time" name="holiday_dates[${holidayCount}][end1]" class="form-control" value="${to1}">
  </div>
  <div class="col-md-2 mb-2">
    <label class="form-label text-dark">Shift 2 Start</label>
    <input type="time" name="holiday_dates[${holidayCount}][start2]" class="form-control" value="${from2}">
  </div>
  <div class="col-md-2 mb-2">
    <label class="form-label text-dark">Shift 2 End</label>
    <input type="time" name="holiday_dates[${holidayCount}][end2]" class="form-control" value="${to2}">
  </div>
  <div class="col-md-1 d-flex align-items-end mb-2">
    <button type="button" class="btn btn-danger" onclick="deleteHolidayRow(this, ${dbId ?? 'null'})" title="Remove Holiday">
      <i class="fas fa-trash-alt"></i>
    </button>
  </div>
`;



    container.appendChild(row);
    holidayCount++;
  }


  function deleteHolidayRow(button, id) {
    if (confirm("Are you sure you want to delete this holiday?")) {
      fetch('phpfiles/insertions.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'btn_delete_holiday=1&id=' + id
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === true) {
            button.closest('.holiday-row').remove();
          } else {
            alert("Failed to delete holiday: " + (data.message || "Unknown error"));
          }
        })
        .catch(error => {
          console.error("Fetch error:", error);
          alert("Something went wrong.");
        });
    }
  }
</script>

<?php
include('connection.php');
$res = mysqli_query($conn, "SELECT * FROM holiday_timings ORDER BY date ASC");

if (mysqli_num_rows($res) > 0) {
  echo "<script>";
  while ($row = mysqli_fetch_assoc($res)) {
    echo "addHolidayRow('{$row['date']}', '{$row['start_time_1']}', '{$row['end_time_1']}', '{$row['start_time_2']}', '{$row['end_time_2']}', '{$row['id']}');";
  }
  echo "</script>";
} else {
  echo "<script>";
  echo "document.getElementById('holiday-container').innerHTML = `<div class='text-center text-muted mb-3'>No holiday data found.</div>`;";
  echo "</script>";
}
?>

<!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/form-validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:57 GMT -->

</html>
<script src="jsfiles/functions.js"></script>