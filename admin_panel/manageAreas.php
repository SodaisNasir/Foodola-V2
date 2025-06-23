
<?php

if(isset($_GET["Message"])){
    if($_GET['Message']){
      echo "<script>alert('Areas updated Successfully')</script>";
      header("Refresh: 1; url='manageAreas.php'");

       
     }else{
        echo "<script>alert('There was some issue.')</script>";
     }}
?>

<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">

<style>
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
    height: 300px;
    border-radius: 10px;
  }

  .modal-content-Updated2 {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    height: 450px;
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

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

  <!-- BEGIN: Header-->
  <?php include('assets/header.php') ?>


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
              <h2 class="content-header-title float-left mb-0">Areas</h2>
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Home</a>
                  </li>
                  <li class="breadcrumb-item active">Areas
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
      <div class="content-body">
        <div class="row">
          <!--<div class="col-12">-->
          <!--    <p>Read full documnetation <a href="../../../../../../external.html?link=https://datatables.net/" target="_blank">here</a></p>-->
          <!--</div>-->
        </div>
        <!-- Zero configuration table -->
        <section id="basic-datatable">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Manage Areas</h4>
                </div>

                <div class="card-content">
                  <div class="card-body card-dashboard">
                    <p class="card-text"></p>
                    <div class="table-responsive">
                      <table id="example" class="table">
                        <thead>
                          <tr>
                            <th>Area ID</th>
                            <th>Area Name</th>
                            <th>Min order price</th>
                            <th>Status</th>
                            <th>Branch Name</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                 <tbody>
  <?php
  include_once('connection.php');
  $sql = "SELECT `id`, `area_name`, `min_order_amount`, `branch_id`, `is_disable`, `created_at` FROM `tbl_areas`";
  $result = mysqli_query($conn, $sql);

  $count = 1;

  while ($row = mysqli_fetch_array($result)) {
      $status = ($row['is_disable'] == '1') ? 'Inactive' : 'Active';

      echo "<tr data-id='{$row['id']}'>";
      echo "<td>{$count}</td>";
      echo "<td class='editable border border-5' contenteditable='true' data-field='area_name' name='area_name'>{$row['area_name']}</td>";
      echo "<td class='editable border border-5' contenteditable='true' data-field='min_order_amount' name='min_order_amount'>{$row['min_order_amount']}</td>";

      // Status select dropdown
      echo "<td class='border border-5'>";
      echo "<select class='form-control status-select' data-field='is_disable' style='min-width: 100px;'>";
      echo "<option value='0' " . ($row['is_disable'] == '0' ? 'selected' : '') . ">Active</option>";
      echo "<option value='1' " . ($row['is_disable'] == '1' ? 'selected' : '') . ">Inactive</option>";
      echo "</select>";
      echo "</td>";

      // Branch select dropdown
      echo "<td class='border border-5'>";
      echo "<select class='form-control branch-select' data-field='branch_id' style='min-width: 100px;'>";
      $branch_result = mysqli_query($conn, "SELECT id, name FROM users where role_id = '1'");
      while ($branch = mysqli_fetch_array($branch_result)) {
          $selected = ($branch['id'] == $row['branch_id']) ? 'selected' : '';
          echo "<option value='{$branch['id']}' {$selected}>{$branch['name']}</option>";
      }
      echo "</select>";
      echo "</td>";

      // Save button
      echo "<td><button class='btn btn-success save-btn' style='display:none; margin-bottom: 5px;'>Save</button></td>";
      echo "</tr>";

      $count++;
  }
  ?>
</tbody>

                        <tfoot>
                          <tr>
                            <th>Area ID</th>
                            <th>Area Name</th>
                            <th>Min order price</th>
                            <th>Status</th>
                            <th>Branch Name</th>
                            <th>Action</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!--/ Zero configuration table -->
        <div id="myModal" class="modal">

          <!-- Modal content -->
          <div class="modal-content-Updated2">

            <span onclick="closeModel(1)" class="close">&times;</span>
            <h2>Update Status</h2>
            <br>
            <br>
            <br>

            <form method="POST" action="assets/Actions.php" enctype="multipart/form-data">
              <input hidden type="text" name="userID">
              <div class="col-sm-12">

                <!--  <div class="form-group">
                    <div class="controls">
                        <input class="form-control"  type="text" name="tracking" placeholder="Tracking Number (Optional)"> 
                    </div>
                  </div> -->
                <div class="form-group">
                  <div class="controls">
                    <select name="Status" id="Status" class="form-control">
                      <option value="0">Mark as banned</option>
                      <option value="1">Mark as unbanned</option>
                    </select>
                  </div>
                </div>
              </div>

              <button type="submit" name="BtnUopdateOrderStatus" class="btn btn-primary">Submit</button>
            </form>
          </div>

        </div>



        <div id="myModal_Add" class="modal ">

          <!-- Modal content -->
          <div class="modal-content-Updated h-auto">

            <span onclick="closeModel(2)" class="close">&times;</span>
            <h2>Update Area</h2>
            <br>


            <div class="modal-body">
              <form method="POST" action="assets/Actions.php" enctype="multipart/form-data">
                <input type="hidden" name="areaid">

                <div class="form-group">
                  <label for="areaname">Area Name</label>
                  <input class="form-control" type="text" name="areaname" id="areaname" placeholder="Enter Area Name" required>
                </div>

                <div class="form-group">
                  <label for="minprice">Minimum Price</label>
                  <input class="form-control" type="number" name="minprice" id="minprice" placeholder="Enter min price" required>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="branchSelect">Select Branch</label>
                    <select name="branch_id"  id="branch_name" class="form-control">
                      <option value="">Select Branch</option>
                      <?php
                      include("connection.php");
                      $query = "SELECT id, name FROM users WHERE role_id = 1";
                      $result = mysqli_query($conn, $query);
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo "<option id='branch_name' value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                        }
                      } else {
                        echo "<option value=''>No branch available</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                
                
                
                
                  <?php
                    include("connection.php"); // your DB connection
                    
                    
                    $current_status = ''; // default if nothing found
                    
                    
                        $query = "SELECT is_disable FROM tbl_areas";
                        $result = mysqli_query($conn, $query);
                    
                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $current_status = $row['is_disable'];
                        }
                    
                    ?>

                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="is_disable">Select Status</label>
                       <select name="is_disable" id="is_disable" class="form-control" data-field="is_disable">
  <option value="">Select status</option>
  <option value="0" <?= $current_status === '0' ? 'selected' : '' ?>>Active</option>
  <option value="1" <?= $current_status === '1' ? 'selected' : '' ?>>Inactive</option>
</select>

                      </div>
                    </div>

                

                <div class="modal-footer">

                  <div class="col-md-12">
                    <button type="submit" name="btnUpdateRiderStatus" class="btn btn-primary w-100">Update</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

        </div>



        <!--/ Scroll - horizontal and vertical table -->

      </div>
    </div>
  </div>
  <!-- END: Content-->



  <!-- End: Customizer-->

  <!-- Buynow Button-->
  <!--<div class="buy-now"><a href="../../../../../../external.html?link=https://1.envato.market/vuexy_admin" target="_blank" class="btn btn-danger">Buy Now</a>-->

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

  <script>
    var modal = document.getElementById("myModal");
    var modal_Add = document.getElementById("myModal_Add");

    function openModal(id) {
      document.getElementsByName('userID')[0].value = id;
      modal.style.display = "block";
    }

  function openAddMore(id, area_name, min_order_amount, name, status) {
  modal_Add.style.display = "block";
  document.getElementById('minprice').value = min_order_amount;
  document.getElementById('areaname').value = area_name;
  document.getElementsByName('areaid')[0].value = id;

  // Set Branch by name (find matching option by text)
  const branchSelect = document.getElementById('branch_name');
  for (let i = 0; i < branchSelect.options.length; i++) {
    if (branchSelect.options[i].text === name) {
      branchSelect.selectedIndex = i;
      break;
    }
  }

}
  // Set Status
  document.getElementById('is_disable').value = status === 'Inactive' ? '1' : '0';
    var span = document.getElementsByClassName("close")[0];
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";

      } else if (event.target == modal_Add) {
        modal_Add.style.display = "none";
      }
    }

    function closeModel(id) {
      if (id == 1) {
        modal.style.display = "none";
      } else {
        modal_Add.style.display = "none";
      }

    }

    function deleteRow(id) {
      var req = new XMLHttpRequest();
      req.open("get", "assets/Actions.php?FunctionName=DeleteCampaignPro&id=" + id, true);
      req.send();
      req.onreadystatechange = function() {
        if (req.readyState == 4 && req.status == 200) {
          alert('Row has been deleted!');
          location.reload();

        }
      };
    }

    function toggle(status, id) {
      var req = new XMLHttpRequest();
      req.open("get", "assets/Actions.php?FunctionName=ToggleCampaignPro&id=" + id + "&status=" + status, true);
      req.send();
      req.onreadystatechange = function() {
        if (req.readyState == 4 && req.status == 200) {
          alert('Status has been updated!');
          location.reload();

        }
      };
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
$(document).ready(function () {

    // Event delegation for dynamically loaded content
    $(document).on('input', '.editable', function () {
        $(this).closest('tr').find('.save-btn').show();
    });

    $(document).on('change', '.status-select', function () {
        $(this).closest('tr').find('.save-btn').show();
    });

    $(document).on('click', '.save-btn', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const area_name = row.find('[data-field="area_name"]').text().trim();
        const min_order_amount = row.find('[data-field="min_order_amount"]').text().trim();
        const branch_id = row.find('[data-field="branch_id"]').text().trim();
        const is_disable = row.find('[data-field="is_disable"]').val();

        const dataToSend = {
            id: id,
            area_name: area_name,
            min_order_amount: min_order_amount,
            is_disable: is_disable,
            branch_id: branch_id,
        };

        console.log('Sending inline update data:', dataToSend); // Debug log

        $.ajax({
            url: '../API/update_inline_area.php',
            method: 'POST',
            dataType: 'json',
            data: dataToSend,
            success: function (response) {
                if (response.status) {
                    alert(response.message);
                    row.find('.save-btn').hide();
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function (xhr) {
                alert("Request failed: " + xhr.responseText);
            }
        });
    });

});
</script>

  
  
  
</body>
<!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:58 GMT -->

</html>