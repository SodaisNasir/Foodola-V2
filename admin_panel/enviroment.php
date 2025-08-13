<?php include('assets/header.php') ?>

<?php 

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

 include_once('connection.php');
//  $sql = "SELECT key_name, key_value, mode FROM enviroments";
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

//         $key = $conn->real_escape_string($key);
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
  
  
  $currentMode = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentMode = isset($_POST['mode']) && $_POST['mode'] === '1' ? 1 : 0;

    // Update all key values
    foreach ($_POST as $key => $value) {
        if ($key !== 'submit' && $key !== 'mode') {
            $safeKey = mysqli_real_escape_string($conn, $key);
            $safeValue = mysqli_real_escape_string($conn, $value);
            $query = "UPDATE enviroments SET key_value = '$safeValue' WHERE key_name = '$safeKey' AND mode = $currentMode";
            mysqli_query($conn, $query);
        }
    }

    // Optionally: update all rows' mode if you want to switch mode globally
    mysqli_query($conn, "UPDATE enviroments SET mode = $currentMode");
}

// Load data from DB
// $sql = "SELECT key_name, key_value, mode FROM enviroments";
// $result = mysqli_query($conn, $sql);

// $apiKeys = [];
// if ($result && mysqli_num_rows($result) > 0) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $apiKeys[] = $row;
//         $currentMode = $row['mode']; // override with latest mode found
//     }
// }


$sql = "SELECT key_name, key_value, mode FROM enviroments";
$result = mysqli_query($conn, $sql);

$apiKeys = [];
$currentMode = 0; // default to Sandbox

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $apiKeys[] = $row;
        if (isset($row['mode'])) {
            $currentMode = $row['mode']; // assuming mode is same for all rows
        }
    }
}



if (isset($_POST['update_auth_token'])) {
    $token = $_POST['auth_token'];
    $authTokenId = $_POST['auth_token_id']; 

    $updateSql = "UPDATE auth_token SET token = '$token' WHERE id = $authTokenId";
     $result  = mysqli_query($conn,$updateSql);
        if ($result === true) {
            header('location:enviroment.php');
        } else {
              echo "Error updating record: " . $conn->error;
        }

    $conn->close();
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

<style>
    .switch-toggle {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }

    .switch-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0;
        right: 0; bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #0d6efd;
    }

    input:checked + .slider:before {
        transform: translateX(30px);
    }

    .mode-label {
        margin-left: 15px;
        font-weight: 500;
    }
</style>

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
                <h2 class="content-header-title float-left mb-0">Enviroment</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Enviroment
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
                        <div class="content-body">
                      <section id="basic-form-layouts">
                        <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manage API Keys</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <label>Update Authentication Token</label>
                        <div class="form-group d-flex align-items-center">
                            <?php 
                                $authTokenId = 1;
                                $authToken = '';
                                $sql = "SELECT token FROM auth_token WHERE id = $authTokenId";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $authToken = $row['token'];
                                }
                            ?>
                            <input type="hidden" name="auth_token_id" value="<?php echo $authTokenId; ?>">
                            <input type="text" class="form-control w-50" id="auth_token" name="auth_token" value="<?php echo htmlspecialchars($authToken); ?>" required>
                            <button type="button" onclick="generatePassword()" class="btn btn-outline-primary ml-2">Generate Password</button>
                        </div>
                        <button type="submit" name="update_auth_token" class="btn btn-primary">Update Auth Token</button>
                    </form>
                    
                    
                    <form method="POST" id="apiKeyForm">
                        <div class="row d-flex flex-column ">
                    
                            <?php
                            foreach ($apiKeys as $apiKey) {
                                echo '<div class="col-md-6 d-flex flex-column justify-content-center align-items-center">';
                                echo '<div class="form-group w-100">';
                                echo '<label for="' . $apiKey['key_name'] . '">' . ucwords(str_replace('_', ' ', $apiKey['key_name'])) . '</label>';
                                echo '<input type="text" class="form-control" id="' . $apiKey['key_name'] . '" name="' . $apiKey['key_name'] . '" value="' . htmlspecialchars($apiKey['key_value']) . '" required>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                    
                            <!-- Toggle Switch -->
                            <div class="mb-4 d-flex align-items-center">
                                <label class="switch-toggle">
                                    <input type="checkbox" id="modeSwitch" name="mode" value="1" <?= $currentMode == 1 ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                </label>
                                <span class="mode-label" id="modeLabel"><?= $currentMode == 1 ? 'Live Mode' : 'Sandbox Mode' ?></span>
                            </div>
                    
                        </div>
                      <button type="button" id="startOtpProcess" class="btn btn-primary">Update Keys</button>
                    
                    </form>

                    
                    
                </div>
            </div>
        </div>
    </div>
</section>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- OTP Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="otpForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Enter OTP</h5>
        </div>
        <div class="modal-body">
          <p>An OTP has been sent to the admin's email.</p>
          <input type="text" class="form-control" name="entered_otp" id="entered_otp" placeholder="Enter OTP" required>
          <input type="hidden" name="actual_otp" id="actual_otp">
          <input type="hidden" name="api_data" id="api_data">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Verify & Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

    
    
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

function generatePassword() {
    const length = 60;
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
    let password = '';
    for (let i = 0; i < length; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('auth_token').value = password;
}
</script>



<script>
    document.getElementById('modeSwitch').addEventListener('change', function () {
        document.getElementById('modeLabel').textContent = this.checked ? 'Live Mode' : 'Sandbox Mode';
    });
</script>


<script>
document.getElementById('startOtpProcess').addEventListener('click', function () {
   const form = document.getElementById('apiKeyForm'); // ✅ This ensures correct form
    const formData = new FormData(form);

    fetch('../API/send_otp.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show OTP modal
            document.getElementById('actual_otp').value = data.otp;
            document.getElementById('api_data').value = JSON.stringify(Object.fromEntries(formData));
            $('#otpModal').modal('show');
        } else {
            alert('Failed to send OTP.');
        }
    });
});

document.getElementById('otpForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const enteredOtp = document.getElementById('entered_otp').value;
    const actualOtp = document.getElementById('actual_otp').value;
    const formDataJson = JSON.parse(document.getElementById('api_data').value);

    if (enteredOtp === actualOtp) {
        // Create form and submit
        const tempForm = document.createElement('form');
        tempForm.method = 'POST';

        for (const key in formDataJson) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = formDataJson[key];
            tempForm.appendChild(input);
        }

        document.body.appendChild(tempForm);
        tempForm.submit();
    } else {
        alert('Invalid OTP. Please try again.');
    }
});
</script>

  </body>
  <!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:58 GMT -->
</html>