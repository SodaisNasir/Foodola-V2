<?php include('assets/header.php') ?>
<!DOCTYPE html>

<?php
  if(isset($_GET['Massage'])){
      if($_GET['Massage'] == 'Sucessfully updated Addon.'){
         echo "<script>alert('Sucessfully updated Addon.')</script>";
         header("Refresh: 1; url='update_addons.php'");
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
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width:50%;
  height:'auto';
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.4);
}

.modal-content-Updated {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  height:300px;
  border-radius:10px;
}

.modal-content-Updated2 {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  height:250px;
  border-radius:10px;
}

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

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

    <?php include('assets/Site_Bar.php') ?>

    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="header-navbar-shadow"></div>
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
              <div class="col-12">
                <h2 class="content-header-title float-left mb-0">View Types</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">View Types</li>
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
                              <h4 class="card-title">View Types</h4>
                          </div>
                  
                          <div class="card-content">
                              <div class="card-body card-dashboard">
                                  <div class="table-responsive">
                                      <table id="example" class="table">
                                          <thead>
                                              <tr>
                                                  <th>S no.</th>
                                                  <th>Type Title ID</th>
                                                  <th>System Type Title</th>
                                                  <th>Frontend Type Title</th>
                                                  <th>Save</th>
                                                  <th>Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php
                                              include_once('connection.php');
                                              $sql = "SELECT `type_id`, `type_title`, `type_title_user` FROM `types_list`";
                                              $result = mysqli_query($conn, $sql);$index = 0;
                                              while($row = mysqli_fetch_array($result)){
                                                  $sn =$index + 1;
                                                  echo "<tr data-id='{$row['type_id']}'>";
                                                  echo "<td>{$sn}</td>";
                                                  echo "<td>{$row['type_id']}</td>";
                                                  // System Type Title (Editable)
                                                  echo "<td class='editable' contenteditable='true' data-field='type_title'>{$row['type_title']}</td>";
                                                  // Frontend Type Title (Editable)
                                                  echo "<td class='editable' contenteditable='true' data-field='type_title_user'>{$row['type_title_user']}</td>";
                                                  echo "<td><button class='btn btn-success btn-sm save-btn' style='display:none;'>Save</button></td>";  
                                                  echo "<td><a href='update_types.php?id={$row['type_id']}'><button class='btn btn-primary btn-sm'>View</button></a></td>";
                                                  echo "</tr>";
                                                  $index++;
                                              }
                                              ?>
                                          </tbody>
                                          <tfoot>
                                              <tr>
                                                  <th>S no.</th>
                                                  <th>Type Title ID</th>
                                                  <th>System Type Title</th>
                                                  <th>Frontend Type Title</th>
                                                  <th>Save</th>
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
        </div>
      </div>
    </div>

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

    <script>
    $(document).ready(function() {$('#example').DataTable({
            dom: 'Bfrtip',
            buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
        });

        // Dono fields par edit / input hone par Save button show hoga
        $(document).on('input', '.editable', function () {$(this).closest('tr').find('.save-btn').show();
        });

        // AJAX Inline Save Request
        $(document).on('click', '.save-btn', function () {
            const row = $(this).closest('tr');
            const id = row.data('id');
            const type_title = row.find('[data-field="type_title"]').text().trim();
            const type_title_user = row.find('[data-field="type_title_user"]').text().trim();

            $.ajax({
                url: '../API/update_inline_types.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    type_title: type_title,
                    type_title_user: type_title_user
                },
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
</html>