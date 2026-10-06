<?php include('assets/header.php') ?>

<?php 
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include_once('connection.php');

/* ---------------------------------------------------------
   Helper Function: Ensure keys exist in 'enviroments' table
   --------------------------------------------------------- */
function ensureKeysExist($conn, array $keys, $defaultMode = 1, $paypalSandboxVal = null) {
    foreach ($keys as $key) {
        $safeKey = $conn->real_escape_string($key);
        $check = mysqli_query($conn, "SELECT id FROM enviroments WHERE key_name = '$safeKey'");
        
        if (mysqli_num_rows($check) == 0) {
            if ($paypalSandboxVal !== null) {
                $safeSandbox = $conn->real_escape_string($paypalSandboxVal);
                mysqli_query($conn, "INSERT INTO enviroments (key_name, key_value, mode, paypal_sandbox) VALUES ('$safeKey', '', $defaultMode, '$safeSandbox')");
            } else {
                mysqli_query($conn, "INSERT INTO enviroments (key_name, key_value, mode) VALUES ('$safeKey', '', $defaultMode)");
            }
        }
    }
}

/* ---------------------------------------------------------
   AJAX Route: Master Section Toggles (Enable/Disable DB Rows)
   --------------------------------------------------------- */
if (isset($_POST['ajax_toggle_section'])) {
    $section = $_POST['section_name'];
    $status  = intval($_POST['status']); // 1 = Enable (Add Rows), 0 = Disable

    $response = ['status' => 'success'];

    $keysMap = [
        'stripe'     => ['stripe_client_key', 'stripe_secret_key'],
        'paypal'     => ['paypal_client_key', 'paypal_secret_key'],
        'pixel'      => ['pixel_key', 'pixel_mode'],
        'liefersoft' => ['liefersoft_company_key', 'liefersoft_login_key', 'liefersoft_password_key'],
        'fiskaly'    => ['fiskaly_api_key', 'fiskaly_api_secret', 'fiskaly_tss_id', 'fiskaly_client_id', 'fiskaly_admin_pin', 'fiskaly_admin_punk'],
        'social'     => ['facebook_url', 'instagram_url', 'linkedin_url', 'x_url', 'parent_shop_url', 'access_token', 'shop_access_token']
    ];

    if (isset($keysMap[$section])) {
        if ($status === 1) {
            // Enable hone par mode = 1 aur PayPal sandbox URL insert hoga
            $defaultSandbox = ($section === 'paypal') ? 'https://api-m.sandbox.paypal.com' : null;
            ensureKeysExist($conn, $keysMap[$section], 1, $defaultSandbox);
        }
    }

    echo json_encode($response);
    exit;
}

/* ---------------------------------------------------------
   Handle Auth Token Update
   --------------------------------------------------------- */
if (isset($_POST['update_auth_token'])) {
    $token = $conn->real_escape_string($_POST['auth_token']);
    $authTokenId = intval($_POST['auth_token_id']);

    $updateSql = "UPDATE auth_token SET token = '$token' WHERE id = $authTokenId";
    $res  = mysqli_query($conn, $updateSql);
    if ($res) {
        header('Location: enviroment.php');
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error updating token: " . htmlspecialchars($conn->error) . "</div>";
    }
}

/* ---------------------------------------------------------
   Handle Keys Update (POST)
   --------------------------------------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['update_auth_token']) && !isset($_POST['ajax_toggle_section'])) {

    $paypalMode = isset($_POST['paypal_mode']) && $_POST['paypal_mode'] === '1' ? 1 : 0;
    $pixelMode  = isset($_POST['pixel_mode']) && $_POST['pixel_mode'] === '1' ? 1 : 0;

    // 1) Update PayPal keys' mode and paypal_sandbox URL accordingly
    $paypalMode = intval($paypalMode);
    $paypalSandboxUrl = ($paypalMode === 1) ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';
    mysqli_query($conn, "UPDATE enviroments SET mode = $paypalMode, paypal_sandbox = '$paypalSandboxUrl' WHERE key_name LIKE 'paypal_%'");

    // 2) Update Pixel key's mode
    $pixelMode = intval($pixelMode);
    mysqli_query($conn, "UPDATE enviroments SET mode = $pixelMode WHERE key_name = 'pixel_key'");
    mysqli_query($conn, "UPDATE enviroments SET mode = $pixelMode WHERE key_name = 'pixel_mode'");

    // 3) Update key_value for all posted keys
    foreach ($_POST as $key => $value) {
        if (in_array($key, ['startOtpProcess','entered_otp','actual_otp','api_data','paypal_mode','pixel_mode','update_auth_token','auth_token','auth_token_id'])) continue;

        $safeKey = $conn->real_escape_string($key);
        $safeValue = $conn->real_escape_string($value);

        $updateSql = "UPDATE enviroments SET key_value = '$safeValue' WHERE key_name = '$safeKey'";
        mysqli_query($conn, $updateSql);
    }

    header('Location: enviroment.php');
    exit;
}

/* ---------------------------------------------------------
   Load Keys from DB & Identify Section Presence
   --------------------------------------------------------- */
$sql = "SELECT id, key_name, key_value, mode, paypal_sandbox FROM enviroments ORDER BY key_name ASC";
$result = mysqli_query($conn, $sql);

$apiKeys = [];
$paypalMode = 0;
$pixelMode = 0;

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $apiKeys[] = $row;

        if ($row['key_name'] === 'paypal_client_key' && isset($row['mode'])) {
            $paypalMode = intval($row['mode']);
        }
        if ($row['key_name'] === 'pixel_key' && isset($row['mode'])) {
            $pixelMode = intval($row['mode']);
        }
        if ($row['key_name'] === 'pixel_mode') {
            if ($row['key_value'] !== null && $row['key_value'] !== '') {
                $pixelMode = intval($row['key_value']);
            } elseif (isset($row['mode'])) {
                $pixelMode = intval($row['mode']);
            }
        }
    }
}

$paypalMode = intval($paypalMode);
$pixelMode  = intval($pixelMode);

// Group Keys Definitions
$paypalKeys    = ['paypal_client_key','paypal_secret_key'];
$pixelKeys     = ['pixel_key','pixel_mode'];
$stripeKeys    = ['stripe_client_key','stripe_secret_key'];
$liefersoftKeys= ['liefersoft_company_key', 'liefersoft_login_key', 'liefersoft_password_key'];
$fiskalyKeys   = ['fiskaly_api_key', 'fiskaly_api_secret', 'fiskaly_tss_id', 'fiskaly_client_id', 'fiskaly_admin_pin', 'fiskaly_admin_punk'];
$socialKeys    = ['facebook_url', 'instagram_url', 'linkedin_url', 'x_url', 'parent_shop_url', 'access_token', 'shop_access_token'];

function hasSectionKeys($apiKeys, $keysSet) {
    foreach ($apiKeys as $k) {
        if (in_array($k['key_name'], $keysSet)) return true;
    }
    return false;
}

$hasStripe     = hasSectionKeys($apiKeys, $stripeKeys);
$hasPaypal     = hasSectionKeys($apiKeys, $paypalKeys);
$hasPixel      = hasSectionKeys($apiKeys, $pixelKeys);
$hasLiefersoft = hasSectionKeys($apiKeys, $liefersoftKeys);
$hasFiskaly    = hasSectionKeys($apiKeys, $fiskalyKeys);
$hasSocial     = hasSectionKeys($apiKeys, $socialKeys);
?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php include('title.php'); echo $pageTitle; ?></title>
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/validation/form-validation.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

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

    .section-header-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 6px;
        margin-top: 20px;
        margin-bottom: 15px;
        border-left: 4px solid #7367f0;
    }
</style>
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
                <h2 class="content-header-title float-left mb-0">Enviroment</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Enviroment</li>
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

                            <!-- AUTH TOKEN FORM -->
                            <form method="POST" class="mb-3">
                              <label>Update Authentication Token</label>
                              <div class="form-group d-flex align-items-center">
                                <?php
                                  $authTokenId = 1;
                                  $authToken = '';
                                  $sqlt = "SELECT token FROM auth_token WHERE id = $authTokenId LIMIT 1";
                                  $rest = $conn->query($sqlt);
                                  if ($rest && $rest->num_rows > 0) {
                                      $rowt = $rest->fetch_assoc();
                                      $authToken = $rowt['token'];
                                  }
                                ?>
                                <input type="hidden" name="auth_token_id" value="<?php echo $authTokenId; ?>">
                                <input type="text" class="form-control w-50" id="auth_token" name="auth_token" value="<?php echo htmlspecialchars($authToken); ?>" required>
                                <button type="button" onclick="generatePassword()" class="btn btn-outline-primary ml-2">Generate Password</button>
                              </div>
                              <button type="submit" name="update_auth_token" class="btn btn-primary">Update Auth Token</button>
                            </form>

                            <!-- API KEYS FORM -->
                            <form method="POST" id="apiKeyForm">

                              <!-- OTHER / UNGROUPED KEYS -->
                              <div class="row">
                                <?php 
                                foreach ($apiKeys as $apiKey):
                                    if (in_array($apiKey['key_name'], $paypalKeys)) continue;
                                    if (in_array($apiKey['key_name'], $pixelKeys)) continue;
                                    if (in_array($apiKey['key_name'], $stripeKeys)) continue;
                                    if (in_array($apiKey['key_name'], $liefersoftKeys)) continue;
                                    if (in_array($apiKey['key_name'], $fiskalyKeys)) continue;
                                    if (in_array($apiKey['key_name'], $socialKeys)) continue;

                                    $keyName = $apiKey['key_name'];
                                    $keyValue = $apiKey['key_value'];
                                ?>
                                  <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                      <label><?= ucwords(str_replace('_',' ', $keyName)) ?></label>
                                      <input type="text" class="form-control" name="<?= htmlspecialchars($keyName) ?>" value="<?= htmlspecialchars($keyValue) ?>">
                                    </div>
                                  </div>
                                <?php endforeach; ?>
                              </div>

                              <!-- ---------------- STRIPE SECTION ---------------- -->
                              <div class="section-header-box">
                                <h5 class="m-0">Stripe Integration</h5>
                                <div class="d-flex align-items-center">
                                  <label class="switch-toggle mb-0">
                                    <input type="checkbox" class="section-master-toggle" data-section="stripe" <?= $hasStripe ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                  <span class="mode-label"><?= $hasStripe ? 'Enabled' : 'Disabled' ?></span>
                                </div>
                              </div>

                              <?php if ($hasStripe): ?>
                              <div class="row">
                                <?php foreach ($apiKeys as $apiKey):
                                  if (!in_array($apiKey['key_name'], $stripeKeys)) continue;
                                  $keyName = $apiKey['key_name'];
                                  $keyValue = $apiKey['key_value'];
                                ?>
                                  <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                      <label><?= ucwords(str_replace('_',' ', $keyName)) ?></label>
                                      <input type="text" class="form-control" name="<?= htmlspecialchars($keyName) ?>" value="<?= htmlspecialchars($keyValue) ?>">
                                    </div>
                                  </div>
                                <?php endforeach; ?>
                              </div>
                              <?php endif; ?>

                              <!-- ---------------- PAYPAL SECTION ---------------- -->
                              <div class="section-header-box">
                                <h5 class="m-0">PayPal Integration</h5>
                                <div class="d-flex align-items-center">
                                  <label class="switch-toggle mb-0">
                                    <input type="checkbox" class="section-master-toggle" data-section="paypal" <?= $hasPaypal ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                  <span class="mode-label"><?= $hasPaypal ? 'Enabled' : 'Disabled' ?></span>
                                </div>
                              </div>

                              <?php if ($hasPaypal): ?>
                              <div class="row">
                                <?php foreach ($apiKeys as $apiKey):
                                  if (!in_array($apiKey['key_name'], $paypalKeys)) continue;
                                  $keyName = $apiKey['key_name'];
                                  $keyValue = $apiKey['key_value'];
                                ?>
                                  <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                      <label><?= ucwords(str_replace('_',' ', $keyName)) ?></label>
                                      <input type="text" class="form-control" name="<?= htmlspecialchars($keyName) ?>" value="<?= htmlspecialchars($keyValue) ?>">
                                    </div>
                                  </div>
                                <?php endforeach; ?>
                              </div>

                              <!-- PayPal Mode Toggle -->
                              <div class="d-flex align-items-center mb-2">
                                <label class="switch-toggle">
                                  <input type="checkbox" id="paypalMode" name="paypal_mode" value="1" <?= $paypalMode == 1 ? 'checked' : '' ?>>
                                  <span class="slider"></span>
                                </label>
                                <span class="mode-label" id="paypalLabel"><?= $paypalMode == 1 ? 'Live Mode' : 'Sandbox Mode' ?></span>
                              </div>
                              <?php endif; ?>

                              <!-- ---------------- PIXEL SECTION ---------------- -->
                              <div class="section-header-box">
                                <h5 class="m-0">Pixel</h5>
                                <div class="d-flex align-items-center">
                                  <label class="switch-toggle mb-0">
                                    <input type="checkbox" class="section-master-toggle" data-section="pixel" <?= $hasPixel ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                  <span class="mode-label"><?= $hasPixel ? 'Enabled' : 'Disabled' ?></span>
                                </div>
                              </div>

                              <?php if ($hasPixel): ?>
                              <div class="row">
                                <?php 
                                  $pixelVal = '';
                                  foreach ($apiKeys as $k) { 
                                      if ($k['key_name'] === 'pixel_key') { $pixelVal = $k['key_value']; break; } 
                                  }
                                ?>
                                <div class="col-md-6 mb-2">
                                  <div class="form-group">
                                    <label>Pixel Key</label>
                                    <input type="text" class="form-control" name="pixel_key" value="<?= htmlspecialchars($pixelVal) ?>" placeholder="Enter Pixel Key">
                                  </div>
                                </div>
                              </div>

                              <div class="mb-3 d-flex align-items-center">
                                <label class="switch-toggle">
                                  <input type="checkbox" id="pixelMode" name="pixel_mode" value="1" <?= $pixelMode == 1 ? 'checked' : '' ?>>
                                  <span class="slider"></span>
                                </label>
                                <span class="mode-label" id="pixelLabel"><?= $pixelMode == 1 ? 'Live Mode' : 'Test Mode' ?></span>
                              </div>
                              <?php endif; ?>

                              <!-- ---------------- FISKALY SECTION ---------------- -->
                              <div class="section-header-box">
                                <h5 class="m-0">Fiskaly Integration</h5>
                                <div class="d-flex align-items-center">
                                  <label class="switch-toggle mb-0">
                                    <input type="checkbox" class="section-master-toggle" data-section="fiskaly" <?= $hasFiskaly ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                  <span class="mode-label"><?= $hasFiskaly ? 'Enabled' : 'Disabled' ?></span>
                                </div>
                              </div>

                              <?php if ($hasFiskaly): ?>
                              <?php $fiskaly_keys = 0; ?> 
                              <div>
                                <div class="row mb-2">
                                    <?php foreach ($fiskalyKeys as $fKey): 
                                        $val = '';
                                        foreach ($apiKeys as $k) { 
                                            if ($k['key_name'] === $fKey) { 
                                                $val = $k['key_value']; 
                                                if ($fKey == 'fiskaly_api_key' || $fKey == 'fiskaly_api_secret') {
                                                    if ($val) { $fiskaly_keys++; }
                                                }
                                                break; 
                                            } 
                                        }
                                    ?>
                                      <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                          <label><?= ucwords(str_replace('_',' ', $fKey)) ?></label>
                                          <input type="text" class="form-control" name="<?= htmlspecialchars($fKey) ?>" value="<?= htmlspecialchars($val) ?>" placeholder="Enter <?= ucwords(str_replace('_',' ', $fKey)) ?>">
                                        </div>
                                      </div>
                                    <?php endforeach; ?>
                                </div>

                                <?php if($fiskaly_keys === 2){ ?>
                                <button type="button" id="startFiskaly" class="btn btn-primary mb-2">Authenticate Fiskaly</button>
                                <?php } ?>
                              </div>
                              <br>
                              <?php endif; ?>

                              <!-- ---------------- LIEFERSOFT KEYS ---------------- -->
                              <div class="section-header-box">
                                <h5 class="m-0">Liefersoft Integration</h5>
                                <div class="d-flex align-items-center">
                                  <label class="switch-toggle mb-0">
                                    <input type="checkbox" class="section-master-toggle" data-section="liefersoft" <?= $hasLiefersoft ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                  <span class="mode-label"><?= $hasLiefersoft ? 'Enabled' : 'Disabled' ?></span>
                                </div>
                              </div>

                              <?php if ($hasLiefersoft): ?>
                              <!-- Company ID Row -->
                              <div class="row mb-2">
                                  <div class="col-md-6">
                                      <label>Company Id</label>
                                      <input type="text" class="form-control" name="liefersoft_company_key" 
                                             value="<?php
                                                 $val = '';
                                                 foreach ($apiKeys as $k) { if($k['key_name'] == 'liefersoft_company_key') { $val = $k['key_value']; break; } }
                                                 echo htmlspecialchars($val);
                                             ?>" 
                                             placeholder="Enter Company Key">
                                  </div>
                              </div>

                              <!-- Login & Password Row -->
                              <div class="row mb-2">
                                  <div class="col-md-6">
                                      <label>Login</label>
                                      <input type="text" class="form-control" name="liefersoft_login_key" 
                                             value="<?php
                                                 $val = '';
                                                 foreach ($apiKeys as $k) { if($k['key_name'] == 'liefersoft_login_key') { $val = $k['key_value']; break; } }
                                                 echo htmlspecialchars($val);
                                             ?>" 
                                             placeholder="Enter Login Key">
                                  </div>

                                  <div class="col-md-6">
                                      <label>Password</label>
                                      <input type="text" class="form-control" name="liefersoft_password_key" 
                                             value="<?php
                                                 $val = '';
                                                 foreach ($apiKeys as $k) { if($k['key_name'] == 'liefersoft_password_key') { $val = $k['key_value']; break; } }
                                                 echo htmlspecialchars($val);
                                             ?>" 
                                             placeholder="Enter Password Key">
                                  </div>
                              </div>
                              <?php endif; ?>

                              <!-- ---------------- SOCIAL LINKS SECTION ---------------- -->
                              <div class="section-header-box">
                                <h5 class="m-0">Social & Store Links</h5>
                                <div class="d-flex align-items-center">
                                  <label class="switch-toggle mb-0">
                                    <input type="checkbox" class="section-master-toggle" data-section="social" <?= $hasSocial ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                  <span class="mode-label"><?= $hasSocial ? 'Enabled' : 'Disabled' ?></span>
                                </div>
                              </div>

                              <?php if ($hasSocial): ?>
                              <div class="row mb-2">
                                <?php foreach ($socialKeys as $sKey): 
                                    $val = '';
                                    foreach ($apiKeys as $k) { if($k['key_name'] === $sKey) { $val = $k['key_value']; break; } }
                                ?>
                                  <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                      <label><?= ucwords(str_replace('_',' ', $sKey)) ?></label>
                                      <input type="text" class="form-control" name="<?= htmlspecialchars($sKey) ?>" value="<?= htmlspecialchars($val) ?>" placeholder="Enter Link/Key">
                                    </div>
                                  </div>
                                <?php endforeach; ?>
                              </div>
                              <?php endif; ?>

                              <!-- Update button triggers OTP flow -->
                              <button type="button" id="startOtpProcess" class="btn btn-primary mt-2">Update</button>

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

function generateAdminPin() {
    return Math.floor(10000000 + Math.random() * 90000000).toString();
}

function generateSerial() {
    return crypto.randomUUID().replace(/-/g, '');
}

// Master Toggle Click Listener (AJAX Row Insertion & Auto Refresh UI)
document.querySelectorAll('.section-master-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const section = this.getAttribute('data-section');
        const status = this.checked ? 1 : 0;
        
        const formData = new FormData();
        formData.append('ajax_toggle_section', '1');
        formData.append('section_name', section);
        formData.append('status', status);

        fetch('enviroment.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.reload();
            }
        })
        .catch(err => {
            console.error('Error toggling section:', err);
            window.location.reload();
        });
    });
});

// PayPal & Pixel Toggle Listeners 
document.addEventListener("DOMContentLoaded", function () {
    const paypalMode = document.getElementById('paypalMode');
    if (paypalMode) {
        paypalMode.addEventListener('change', function () {
            document.getElementById('paypalLabel').textContent = this.checked ? 'Live Mode' : 'Sandbox Mode';
        });
    }

    const pixelMode = document.getElementById('pixelMode');
    if (pixelMode) {
        pixelMode.addEventListener('change', function () {
            document.getElementById('pixelLabel').textContent = this.checked ? 'Live Mode' : 'Test Mode';
        });
    }
});

// Fiskaly Auth Script
const startFiskalyBtn = document.getElementById('startFiskaly');
if (startFiskalyBtn) {
    startFiskalyBtn.addEventListener('click', async function () {
        try {
            const apikey = document.getElementsByName('fiskaly_api_key')[0].value;
            const apisecret = document.getElementsByName('fiskaly_api_secret')[0].value;

            let response = await fetch("https://kassensichv-middleware.fiskaly.com/api/v2/auth", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ api_key: apikey, api_secret: apisecret })
            });

            const authResult = await response.json();
            const access_token = authResult.access_token;

            const tssid = crypto.randomUUID();

            response = await fetch(`https://kassensichv-middleware.fiskaly.com/api/v2/tss/${tssid}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${access_token}`
                },
                body: JSON.stringify({})
            });

            const tssResult = await response.json();
            const admin_puk = tssResult.admin_puk;

            await updateFiskaly("fiskaly_tss_id", tssid);
            await updateFiskaly("fiskaly_admin_punk", admin_puk);

            response = await fetch(`https://kassensichv-middleware.fiskaly.com/api/v2/tss/${tssid}`, {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${access_token}`
                },
                body: JSON.stringify({
                    description: "Taking this permission for our setup",
                    state: "UNINITIALIZED"
                })
            });

            await response.json();
            const admin_pin = generateAdminPin();

            response = await fetch(`https://kassensichv-middleware.fiskaly.com/api/v2/tss/${tssid}/admin`, {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${access_token}`
                },
                body: JSON.stringify({ admin_puk, new_admin_pin: admin_pin })
            });

            await response.json();
            await updateFiskaly("fiskaly_admin_pin", admin_pin);

            response = await fetch(`https://kassensichv-middleware.fiskaly.com/api/v2/tss/${tssid}/admin/auth`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${access_token}`
                },
                body: JSON.stringify({ admin_pin })
            });

            await response.json();

            const client_id = crypto.randomUUID();
            const serial_number = generateSerial();

            response = await fetch(`https://kassensichv-middleware.fiskaly.com/api/v2/tss/${tssid}/client/${client_id}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${access_token}`
                },
                body: JSON.stringify({ serial_number })
            });

            await response.json();
            await updateFiskaly("fiskaly_client_id", client_id);
            alert("Fiskaly Authenticated Successfully!");

        } catch (error) {
            console.error("Error:", error);
            alert("Fiskaly Error: " + error.message);
        }
    });
}

// OTP Process Trigger
document.getElementById('startOtpProcess').addEventListener('click', function () {
    const form = document.getElementById('apiKeyForm');
    const formData = new FormData(form);

    fetch('../API/send_otp.php', {
        method: 'POST',
        body: formData
    })
    .then(async response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log("OTP Response:", data);
        
        if (data && data.success) {
            document.getElementById('actual_otp').value = data.otp;
            document.getElementById('api_data').value = JSON.stringify(Object.fromEntries(formData));
            
            // Modal Open Call
            if (typeof $!== 'undefined' &&$.fn.modal) {
                $('#otpModal').modal('show');
            } else {
                alert("Bootstrap/jQuery load nahi hua hai!");
            }
        } else {
            alert(data.message || 'Failed to send OTP.');
        }
    })
    .catch(error => {
        console.error('OTP Error:', error);
        alert('Error sending OTP request: ' + error.message + '\nBrowser Console (F12) check karein.');
    });
});

// OTP Submit
document.getElementById('otpForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const enteredOtp = document.getElementById('entered_otp').value;
    const actualOtp = document.getElementById('actual_otp').value;
    const formDataJson = JSON.parse(document.getElementById('api_data').value);

    if (enteredOtp === actualOtp) {
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

async function updateFiskaly(keyName, keyValue) {
    const formdata = new FormData();
    formdata.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");
    formdata.append("key_name", keyName);
    formdata.append("key_value", keyValue);

    const response = await fetch("../API/updateFiskaly.php", {
        method: "POST",
        body: formdata
    });

    if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
    }

    return await response.text();
}
</script>

</body>
</html>