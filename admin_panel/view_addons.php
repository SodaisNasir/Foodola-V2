<?php include('assets/header.php') ?>
<!DOCTYPE html>

<?php
  if(isset($_GET['Massage'])){
      if($_GET['Massage'] == 'Sucessfully updated Addon.'){
         echo "<script>alert('Sucessfully updated Addon.')</script>";
         header("Refresh: 1; url='view_addons.php'");
       }else{
          echo "<script>alert('changes made to data successfully!')</script>";
       }
  }   
?>

<html class="loading" lang="en" data-textdirection="ltr">

<style>
.modal {
  display: none; 
  position: fixed; 
  z-index: 1000; 
  padding-top: 100px; 
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto; 
  background-color: rgba(0,0,0,0.5); 
}

/* Modal Content */
.modal-content-Updated {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 40%;
  height: auto;
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
    <title><?php include('title.php'); echo $pageTitle; ?></title>
    
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  </head>

  <body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

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
                <h2 class="content-header-title float-left mb-0">View Addon</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">View Addon</li>
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
                          <div class="card-header">
                              <h4 class="card-title">View Addon</h4>
                          </div>
                  
                          <div class="card-content">
                              <div class="card-body card-dashboard">
                                  <div class="table-responsive">
                                      <table id="example" class="table">
                                          <thead>
                                              <tr>
                                                  <th>S no.</th>
                                                  <th>Addon Name</th>
                                                  <th>Front End Addon Title</th>
                                                  <th>Update</th>
                                                  <th>Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          include_once('connection.php');

                                          $sql = "SELECT `ao_id`, `ao_title` FROM `addon_list` ";
                                          $result = mysqli_query($conn, $sql);$index = 0;

                                          if ($result && mysqli_num_rows($result) > 0) {
                                              while ($row = mysqli_fetch_assoc($result)) {
                                                  $ao_id =$row['ao_id'];
                                                  
                                                  // addon_sublist se title fetch karna
                                                  $sqlfetch_subaddon = "SELECT `ao_title` FROM `addon_sublist` WHERE `ao_id` = '$ao_id' LIMIT 1";
                                                  $exec_sqlfetch_subaddon = mysqli_query($conn, $sqlfetch_subaddon);$frontend_title = '-';
                                                  if ($exec_sqlfetch_subaddon && $subaddon = mysqli_fetch_assoc($exec_sqlfetch_subaddon)) {
                                                      $frontend_title =$subaddon['ao_title'];
                                                  }
                                                  
                                                  $sn =$index + 1;

                                                  echo "<tr>";
                                                  echo "<td>{$sn}</td>";
                                                  echo "<td name='subname'>" . htmlspecialchars($row['ao_title']) . "</td>";
                                                  echo "<td name='subname'>" . htmlspecialchars($frontend_title) . "</td>";
                                                  // Button me system title aur frontend title dono pass kiye gaye hain
                                                  echo '<td><button class="btn btn-primary" onclick="openAddMore(\''. $row['ao_id'] .'\' ,\''. htmlspecialchars($row['ao_title'], ENT_QUOTES) .'\', \''. htmlspecialchars($frontend_title, ENT_QUOTES) .'\')">Update</button></td>';
                                                  echo "<td><a href='update_addons.php?id={$row['ao_id']}'><button class='btn btn-primary'>View</button></a></td>";
                                                  echo "</tr>";
                                                  
                                                  $index++;
                                              }
                                          }
                                          ?>
                                          </tbody>
                                          <tfoot>
                                               <tr>
                                                  <th>S no.</th>
                                                  <th>Addon Name</th>
                                                  <th>Front End Addon Title</th>
                                                  <th>Update</th>
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

          <!-- Update Modal -->
          <div id="myModal_Add" class="modal">
            <div class="modal-content-Updated">
              <span onclick="closeModel(2)" class="close">&times;</span>
              <h2>Update Addons Title</h2>
              <br>
              <form method="POST" action="phpfiles/insertions.php" enctype="multipart/form-data">
                <div class="col-sm-12">
                  <!-- Hidden ID Field -->
                  <input class="form-control" value="" type="hidden" name="ao_id" id="ao_id"> 
                  
                  <!-- System Addon Title (addon_list) -->
                  <div class="form-group mb-2">
                    <label>System Addon Title (Backend)</label>
                    <div class="controls">
                      <input class="form-control" value="" type="text" name="ao_title" id="ao_title" placeholder="Enter System Addon Title" required> 
                    </div>
                  </div>

                  <!-- Frontend Addon Title (addon_sublist) -->
                  <div class="form-group mb-2">
                    <label>Frontend Addon Title (User Show)</label>
                    <div class="controls">
                      <input class="form-control" value="" type="text" name="frontend_ao_title" id="frontend_ao_title" placeholder="Enter Frontend Addon Title" required> 
                    </div>
                  </div>

                  <button type="submit" name="updateAddonTitle" class="btn btn-primary mt-1">Save Changes</button>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="app-assets/js/scripts/components.min.js"></script>
    <script src="app-assets/js/scripts/footer.min.js"></script>

    <script>
    var modal_Add = document.getElementById("myModal_Add");

    // Modal mein values load hone ka function
    function openAddMore(id, systemTitle, frontendTitle){
        document.getElementById('ao_id').value = id;
        document.getElementById('ao_title').value = systemTitle;
        document.getElementById('frontend_ao_title').value = (frontendTitle === '-') ? '' : frontendTitle;
        
        modal_Add.style.display = "block";
    }

    function closeModel(id) {
        modal_Add.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal_Add) {
            modal_Add.style.display = "none";
        }
    }

    $(document).ready(function() {$('#example').DataTable({
            dom: 'Bfrtip',
            buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
        });
    });
    </script>    
  </body>
</html>