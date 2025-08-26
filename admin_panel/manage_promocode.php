<?php include('assets/header.php');
if (isset($_GET['Massage'])) {
  $message = $_GET['Massage'];
  echo "<script>alert('$message')</script>";
}

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<style>
  @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");

  .modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    padding-top: 100px;
    /* Location of the box */
    left: 0;
    top: 0;
    width: 50%;
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
  }

  /* Modal Content */

  .modal-content-Updated {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    height: 350px;
    border-radius: 10px;
  }

  .modal-content-Updated2 {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    height: 250px;
    border-radius: 10px;
  }

  /* The Close Button */
  .close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;

  }
</style>

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

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
              <h2 class="content-header-title float-left mb-0">Manage Promocodes</h2>
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Home</a>
                  </li>
                  <li class="breadcrumb-item active">Manage Promocodes
                  </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="content-body">
        <div class="row">

        </div>
        <!-- Zero configuration table -->
        <section id="basic-datatable">
          <div class="row">
            <div class="col-12">
              <div class="card p-2">
                <div class="card-header">
                  <h4 class="card-title">Manage Promo Codes</h4>
                  <button class="btn btn-primary" data-toggle="modal" data-target="#addTableModal">Add Code</button>
                </div>


                <div class="card-content">
                  <div class="table-responsive">
                    <table id="example" class="table">
                      <thead class="text-center">
                        <tr>
                          <th>Sno</th>
                          <th>Code</th>
                          <th>Value</th>
                          <th>Limit</th>
                          <th>Used Count</th>
                          <th>Min Order</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Eligible Date</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody class="text-center">
                        <?php
                        include_once('connection.php');

                        $sql = "SELECT * FROM `promo_codes`";
                        $result = mysqli_query($conn, $sql);
                        $index = 1;

                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<tr>";
                          echo "<td>{$index}</td>";
                          echo "<td>{$row['code']}</td>";
                          echo "<td>{$row['value']}</td>";
                          echo "<td>{$row['usage_limit']}</td>";
                          echo "<td>{$row['used_count']}</td>";
                          echo "<td>{$row['min_order']}</td>";
                          echo "<td>{$row['start_date']}</td>";
                          echo "<td>{$row['end_date']}</td>";
                          echo "<td>" . ($row['eligible_users_date'] ?? '-') . "</td>";
                          echo "<td>{$row['status']}</td>";



                          echo "<td class='d-flex justify-content-around'>
                                        <i class='bi bi-pencil-square' style='cursor: pointer;' data-toggle='modal' data-target='#updateTableModal'  
                                           onclick='openUpdateModal(\"{$row['id']}\", \"{$row['code']}\", \"{$row['value']}\", \"{$row['usage_limit']}\", \"{$row['used_count']}\", \"{$row['min_order']}\", \"{$row['start_date']}\", \"{$row['end_date']}\", \"{$row['status']}\", \"{$row['eligible_users_date']}\", \"{$row['start_date_order']}\", \"{$row['end_date_order']}\")'>
                                        </i>

                                        <form action='phpfiles/insertions.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this promo code?\")'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <button type='submit' name='btn_delete_code' style='border: none; background: none; cursor: pointer;'>
                                                <i class='bi bi-trash text-danger'></i>
                                            </button>
                                        </form>
                                      </td>";

                          echo "</tr>";
                          $index++;
                        }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Sno</th>
                          <th>Code</th>
                          <th>Value</th>
                          <th>Limit</th>
                          <th>Used Count</th>
                          <th>Min Order</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Eligible Date</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Update Promocode Modal -->

        <div class="modal fade" id="updateTableModal" tabindex="-1" role="dialog" aria-labelledby="updateDealModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="updateDealModalLabel">Update Promo Codes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="phpfiles/insertions.php" method="POST" enctype="multipart/form-data">
                  <input type="hidden" class="form-control" name="id" id="id">
                  <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" id="Code" name="code" required>
                  </div>
                  <div class="form-group">
                    <label for="value">Value</label>
                    <input type="number" class="form-control" id="Value" name="value" required>
                  </div>
                  <div class="form-group">
                    <label for="usage_limit">Per User Usage Limit</label>
                    <input type="number" class="form-control" id="UsageLimit" name="usage_limit" required>
                  </div>

                   <!--Start & End Date Fields (Side by Side) -->
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="StartDate" name="start_date" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="EndDate" name="end_date" required>
                      </div>
                    </div>
                  </div>

                   <!--Checkbox to Show "User Order Between" Date Fields -->
                  <div class="form-group">
                    <input type="checkbox" id="toggleDateFieldss">
                    <label for="toggleDateFields">User Order Between</label>
                  </div>

                   <!--Hidden Date Fields for "User Order Between" -->
                  <div id="orderBetweenFieldss" style="display: none;">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="start_date_order">Start Date</label>
                          <input type="date" class="form-control" id="start_date_order" name="start_date_order">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="end_date_order">End Date</label>
                          <input type="date" class="form-control" id="end_date_order" name="end_date_order">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                        <label for="min_order">Minimum Order</label>
                        <input type="number" class="form-control" id="minOrder" name="min_order" required>
                      </div>
                    </div>
                      
                    </div>
                  </div>

                   <!--Checkbox to Show "Eligible User Date" -->
                  <div class="form-group">
                    <input type="checkbox" id="toggleEligibleUserr">
                    <label for="toggleEligibleUser">Register User Date</label>
                  </div>

                   <!--Hidden Date Field for "Eligible User Date" -->
                  <div id="eligibleUserFieldd" style="display: none;">
                    <div class="form-group">
                      <label for="eligible_users_date">Register User Date</label>
                      <input type="date" class="form-control" id="eligible_users_date" name="eligible_users_date">
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="Status">Status</label>
                    <select class="form-control" id="Status" name="status" >
                      <option value="active">Active</option>
                      <option value="expired">Expired</option>
                    </select>
                  </div>

                  <button type="submit" name="btn_update_code" class="btn btn-primary w-100">Update</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Add Promocode Modal -->
        <div class="modal fade" id="AddTableModal" tabindex="-1" role="dialog" aria-labelledby="updateDealModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="AddTableModal">Add Promocode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="phpfiles/insertions.php" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" id="Code" name="code" required>
                  </div>
                  <div class="form-group">
                    <label for="value">Value</label>
                    <input type="number" class="form-control" id="Value" name="value" required>
                  </div>
                  <div class="form-group">
                    <label for="usage_limit">Per User Usage Limit</label>
                    <input type="number" class="form-control" id="UsageLimit" name="usage_limit" required>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="StartDate" name="start_date" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="EndDate" name="end_date" required>
                      </div>
                    </div>
                  </div>

                  <!-- Checkbox to Show "User Order Between" Date Fields -->
                  <div class="form-group">
                    <input type="checkbox" id="toggleDateFields">
                    <label for="toggleDateFields">User Order Between</label>
                  </div>

                  <!-- Hidden Date Fields for "User Order Between" -->
                  <div id="orderBetweenFields" style="display: none;">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="start_date_order">From Date</label>
                          <input type="date" class="form-control" id="start_date_order" name="start_date_order">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="end_date_order">To Date</label>
                          <input type="date" class="form-control" id="end_date_order" name="end_date_order">
                        </div>
                      </div>
                        <div class="col-md-12">
                        <div class="form-group">
                        <label for="min_order">Minimum Order</label>
                        <input type="number" class="form-control" id="minOrder" name="min_order">
                      </div>
                        </div>  
                    </div>
                  </div>

                  <!-- Checkbox to Show "Eligible User Date" -->
                  <div class="form-group">
                    <input type="checkbox" id="toggleEligibleUser">
                    <label for="toggleEligibleUser">Register User Date</label>
                  </div>

                  <!-- Hidden Date Field for "Eligible User Date" -->
                  <div id="eligibleUserField" style="display: none;">
                    <div class="form-group">
                      <label for="eligible_users_date">Register User Date</label>
                      <input type="date" class="form-control" id="eligible_users_date" name="eligible_users_date">
                    </div>
                  </div>

             

                  <div class="form-group">
                    <label for="Status">Status</label>
                    <select class="form-control" id="Status" name="status" required>
                      <option value="active">Active</option>
                      <option value="expired">Expired</option>
                    </select>
                  </div>

                  <button type="submit" name="btn_insert_code" class="btn btn-primary w-100">Add Code</button>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>

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
  <script src="app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
  <script src="app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
  <script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
  <script src="app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
  <script src="app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
  <script src="app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
  <script src="app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
  <script src="app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
  <!-- END: Page Vendor JS-->

  <!-- BEGIN: Theme JS-->
  <script src="app-assets/js/core/app-menu.min.js"></script>
  <script src="app-assets/js/core/app.min.js"></script>
  <script src="app-assets/js/scripts/components.min.js"></script>
  <script src="app-assets/js/scripts/customizer.min.js"></script>
  <script src="app-assets/js/scripts/footer.min.js"></script>
  <!-- END: Theme JS-->

  <!-- BEGIN: Page JS-->
  <script src="app-assets/js/scripts/datatables/datatable.min.js"></script>
  <!-- END: Page JS-->

  </script>

  <script>
    function openUpdateModal(id, code, value, usage_limit, used_count, min_order, start_date, end_date, status, eligible_users_date, start_date_order, end_date_order) {
      $('#id').val(id);
      $('#Code').val(code);
      $('#Value').val(value);
      $('#UsageLimit').val(usage_limit);
      $('#UsedCount').val(used_count);
      $('#minOrder').val(min_order);
      $('#StartDate').val(start_date);
      $('#EndDate').val(end_date);
      $('#Status').val(status);
      $('#eligible_users_date').val(eligible_users_date);
      $('#start_date_order').val(start_date_order);
      $('#end_date_order').val(end_date_order);
     
      
      
           if (start_date_order != '0000-00-00' || end_date_order != '0000-00-00' || min_order != '0') {
               console.log(start_date_order, end_date_order,min_order)
            $('#toggleDateFieldss').prop('checked', true);
            $('#orderBetweenFieldss').show();
        } else {
            $('#toggleDateFieldss').prop('checked', false);
            $('#orderBetweenFieldss').hide();
        }
        
        if (eligible_users_date != '0000-00-00') {
            $('#toggleEligibleUserr').prop('checked', true);
            $('#eligibleUserFieldd').show();
        } else {
            $('#toggleEligibleUserr').prop('checked', false);
            $('#eligibleUserFieldd').hide();
        }

     
    }
  </script>
  <script>
    $(document).ready(function() {
      $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
          'copyHtml5',
          'excelHtml5',
          'csvHtml5',
          'pdfHtml5'
        ]
      });
    });
  </script>
  <script>
    document.getElementById("toggleDateFieldss").addEventListener("change", function() {
      let fields = document.getElementById("orderBetweenFieldss");
      if (this.checked) {
        fields.style.display = "block";
        document.getElementById("StartDate").setAttribute("required", "required");
        document.getElementById("EndDate").setAttribute("required", "required");
      } else {
        fields.style.display = "none";
        document.getElementById("StartDate").removeAttribute("required");
        document.getElementById("EndDate").removeAttribute("required");
      }
    });

    // Toggle Eligible User Date Field
    document.getElementById("toggleEligibleUserr").addEventListener("change", function() {
      let field = document.getElementById("eligibleUserFieldd");
      if (this.checked) {
        field.style.display = "block";
        document.getElementById("eligible_users_date").setAttribute("required", "required");
      } else {
        field.style.display = "none";
        document.getElementById("eligible_users_date").removeAttribute("required");
      }
    });
    
    
    
      document.getElementById("toggleDateFields").addEventListener("change", function() {
      let fields = document.getElementById("orderBetweenFields");
      if (this.checked) {
        fields.style.display = "block";
        document.getElementById("StartDate").setAttribute("required", "required");
        document.getElementById("EndDate").setAttribute("required", "required");
      } else {
        fields.style.display = "none";
        document.getElementById("StartDate").removeAttribute("required");
        document.getElementById("EndDate").removeAttribute("required");
      }
    });

    // Toggle Eligible User Date Field
    document.getElementById("toggleEligibleUser").addEventListener("change", function() {
      let field = document.getElementById("eligibleUserField");
      if (this.checked) {
        field.style.display = "block";
        document.getElementById("eligible_users_date").setAttribute("required", "required");
      } else {
        field.style.display = "none";
        document.getElementById("eligible_users_date").removeAttribute("required");
      }
    });
  </script>
</body>

</html>