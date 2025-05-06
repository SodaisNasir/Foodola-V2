<?php include('assets/header.php') ?>

<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

 include_once('connection.php');
//  $sql = "SELECT key_name, key_value FROM enviroments";
//  $result = mysqli_query($conn,$sql);

//   $apiKeys = [];
//   if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//       $apiKeys[] = $row;
//     }
//   }
  
  
  
//   if (isset($_POST['submit'])) {
//     foreach ($_POST as $key => $value) {
//       if ($key !== 'submit') {

        // $key = $conn->real_escape_string($key);
//         $value = $conn->real_escape_string($value);
        
//         $updateSql = "UPDATE enviroments SET key_value = '$value' WHERE key_name = '$key'";
//         $result  = mysqli_query($conn,$updateSql);
//         if ($result === true) {
//             header('location:enviroment.php');
//         } else {
//               echo "Error updating record: " . $conn->error;
//         }
//       }
//     }
//   }
  
  
  
if (isset($_POST['update'])) {
//
$id = $_POST['id'];
$message_key = mysqli_real_escape_string($conn, $_POST['message_key']);
$message_en = mysqli_real_escape_string($conn,$_POST['message_en']);
$message_de = mysqli_real_escape_string($conn,$_POST['message_de']);



$sqlUpt = "UPDATE `messages` SET `message_key`='$message_key',`message_en`='$message_en',`message_de`='$message_de' WHERE `id`= '$id'";
$exec_upt = mysqli_query($conn,$sqlUpt);
if($exec_upt === TRUE){
    // header('Location:manage_messages.php');
    // echo "updated";
}else{
     echo "Error updating record: " . $conn->error;
}
 
}



$sql = "SELECT * FROM messages ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}




?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
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

  <body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">


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
                <h2 class="content-header-title float-left mb-0">Manage Messages</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Manage Messages
                    </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>


      <section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                      <div class="table-responsive">
    <table class="table table-striped table-bordered" id="basic-datatable">
        <thead>
            <tr>
                <th>#</th>
                <th>Message Key</th>
                <th>Message (English)</th>
                <th>Message (German)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $index => $msg): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($msg['message_key']) ?></td>
                    <td><?= htmlspecialchars($msg['message_en']) ?></td>
                    <td><?= htmlspecialchars($msg['message_de']) ?></td>
                    <td>
                        <button
                            class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editMessageModal" data-id="<?= $msg['id'] ?>" data-key="<?= htmlspecialchars($msg['message_key']) ?>"
                            data-en="<?= htmlspecialchars($msg['message_en']) ?>"
                            data-de="<?= htmlspecialchars($msg['message_de']) ?>"
                        >
                            Edit
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    
    
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
<div class="modal fade" id="editMessageModal" tabindex="-1" aria-labelledby="editMessageLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <form method="post" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editMessageLabel">Edit Message</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit-id">
          <div class="mb-1">
            <label for="edit-key" class="form-label">Message Key</label>
            <input type="text" class="form-control" id="edit-key" name="message_key" readonly>
          </div>
          <div class="mb-1">
            <label for="edit-en" class="form-label">Message (English)</label>
            <textarea class="form-control" id="edit-en" name="message_en" rows="3"></textarea>
          </div>
          <div class="mb-1">
            <label for="edit-de" class="form-label">Message (German)</label>
            <textarea class="form-control" id="edit-de" name="message_de" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update" class="btn btn-success">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>



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
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script>
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const editModal = document.getElementById('editMessageModal');
  editModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const key = button.getAttribute('data-key');
    const en = button.getAttribute('data-en');
    const de = button.getAttribute('data-de');

    editModal.querySelector('#edit-id').value = id;
    editModal.querySelector('#edit-key').value = key;
    editModal.querySelector('#edit-en').value = en;
    editModal.querySelector('#edit-de').value = de;
  });
});
</script>

  </body>
  <!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:58 GMT -->
</html>