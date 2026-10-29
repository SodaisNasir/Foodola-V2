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
    $status  = intval($_POST['status']); // 1 = Enable (Add Rows), 0 = Disable (Delete Rows)

    $response = ['status' => 'success'];

    $keysMap = [
        'stripe'     => ['stripe_client_key', 'stripe_secret_key', 'stripe_mode'],
        'paypal'     => ['paypal_client_key', 'paypal_secret_key'],
        'pixel'      => ['pixel_key', 'pixel_mode'],
        'liefersoft' => ['liefersoft_company_key', 'liefersoft_login_key', 'liefersoft_password_key'],
        'fiskaly'    => ['fiskaly_api_key', 'fiskaly_api_secret', 'fiskaly_tss_id', 'fiskaly_client_id', 'fiskaly_admin_pin', 'fiskaly_admin_punk', 'fiskaly_mode'],
        'social'     => ['facebook_url', 'instagram_url', 'linkedin_url', 'x_url', 'parent_shop_url', 'access_token', 'shop_access_token']
    ];

    if (isset($keysMap[$section])) {
        if ($status === 1) {
            $defaultSandbox = ($section === 'paypal') ? 'https://api-m.sandbox.paypal.com' : null;
            ensureKeysExist($conn, $keysMap[$section], 1, $defaultSandbox);
        } else {
            $keysList = "'" . implode("', '", array_map([$conn, 'real_escape_string'], $keysMap[$section])) . "'";
            mysqli_query($conn, "DELETE FROM enviroments WHERE key_name IN ($keysList)");
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

    $stripeMode  = isset($_POST['stripe_mode']) && $_POST['stripe_mode'] === '1' ? 1 : 0;
    $paypalMode  = isset($_POST['paypal_mode']) && $_POST['paypal_mode'] === '1' ? 1 : 0;
    $pixelMode   = isset($_POST['pixel_mode']) && $_POST['pixel_mode'] === '1' ? 1 : 0;
    $fiskalyMode = isset($_POST['fiskaly_mode']) && $_POST['fiskaly_mode'] === '1' ? 1 : 0;

    // 1) Update Stripe mode across all stripe keys
    $stripeMode = intval($stripeMode);
    mysqli_query($conn, "UPDATE enviroments SET mode = $stripeMode WHERE key_name LIKE 'stripe_%'");

    // 2) Update PayPal keys' mode and paypal_sandbox URL accordingly
    $paypalMode = intval($paypalMode);
    $paypalSandboxUrl = ($paypalMode === 1) ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';
    mysqli_query($conn, "UPDATE enviroments SET mode = $paypalMode, paypal_sandbox = '$paypalSandboxUrl' WHERE key_name LIKE 'paypal_%'");

    // 3) Update Pixel key's mode
    $pixelMode = intval($pixelMode);
    mysqli_query($conn, "UPDATE enviroments SET mode = $pixelMode WHERE key_name = 'pixel_key'");
    mysqli_query($conn, "UPDATE enviroments SET mode = $pixelMode WHERE key_name = 'pixel_mode'");

    // 4) Update Fiskaly mode across all fiskaly keys
    $fiskalyMode = intval($fiskalyMode);
    mysqli_query($conn, "UPDATE enviroments SET mode = $fiskalyMode WHERE key_name LIKE 'fiskaly_%'");

    // 5) Update key_value for all posted keys
    foreach ($_POST as $key => $value) {
        if (in_array($key, ['stripe_mode','paypal_mode','pixel_mode','fiskaly_mode','update_auth_token','auth_token','auth_token_id'])) continue;

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
$stripeMode = 0;
$paypalMode = 0;
$pixelMode = 0;
$fiskalyMode = 0;

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $apiKeys[] = $row;

        if ($row['key_name'] === 'stripe_client_key' && isset($row['mode'])) {
            $stripeMode = intval($row['mode']);
        }
        if ($row['key_name'] === 'stripe_mode') {
            if ($row['key_value'] !== null && $row['key_value'] !== '') {
                $stripeMode = intval($row['key_value']);
            } elseif (isset($row['mode'])) {
                $stripeMode = intval($row['mode']);
            }
        }
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
        if ($row['key_name'] === 'fiskaly_api_key' && isset($row['mode'])) {
            $fiskalyMode = intval($row['mode']);
        }
        if ($row['key_name'] === 'fiskaly_mode') {
            if ($row['key_value'] !== null && $row['key_value'] !== '') {
                $fiskalyMode = intval($row['key_value']);
            } elseif (isset($row['mode'])) {
                $fiskalyMode = intval($row['mode']);
            }
        }
    }
}

$stripeMode  = intval($stripeMode);
$paypalMode  = intval($paypalMode);
$pixelMode   = intval($pixelMode);
$fiskalyMode = intval($fiskalyMode);

// Group Keys Definitions
$paypalKeys    = ['paypal_client_key','paypal_secret_key'];
$pixelKeys     = ['pixel_key','pixel_mode'];
$stripeKeys    = ['stripe_client_key','stripe_secret_key','stripe_mode'];
$liefersoftKeys= ['liefersoft_company_key', 'liefersoft_login_key', 'liefersoft_password_key'];
$fiskalyKeys   = ['fiskaly_api_key', 'fiskaly_api_secret', 'fiskaly_tss_id', 'fiskaly_client_id', 'fiskaly_admin_pin', 'fiskaly_admin_punk', 'fiskaly_mode'];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        margin-left: 10px;
        margin-right: 15px;
        font-weight: 500;
        font-size: 13px;
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

    /* Page Lock Overlay styling */
    #pageLockOverlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
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
                                <div class="input-group w-50">
                                    <input type="password" class="form-control" id="auth_token" name="auth_token" value="<?php echo htmlspecialchars($authToken); ?>" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="auth_token"><i class="fa fa-eye"></i></button>
                                    </div>
                                </div>
                                <button type="button" onclick="generatePassword()" class="btn btn-outline-primary ml-2">Generate Password</button>
                              </div>
                              <button type="submit" name="update_auth_token" class="btn btn-primary">Update Auth Token</button>
                            </form>

                            <!-- API KEYS FORM -->
                            <form method="POST" id="apiKeyForm">

                              <!-- OTHER / UNGROUPED KEYS -->
                              <div class="row">
                                <?php 
                                foreach ($apiKeys as $index => $apiKey):
                                    if (in_array($apiKey['key_name'], $paypalKeys)) continue;
                                    if (in_array($apiKey['key_name'], $pixelKeys)) continue;
                                    if (in_array($apiKey['key_name'], $stripeKeys)) continue;
                                    if (in_array($apiKey['key_name'], $liefersoftKeys)) continue;
                                    if (in_array($apiKey['key_name'], $fiskalyKeys)) continue;
                                    if (in_array($apiKey['key_name'], $socialKeys)) continue;

                                    $keyName = $apiKey['key_name'];
                                    $keyValue = $apiKey['key_value'];
                                    $fieldId = "field_" . $index;
                                ?>
                                  <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                      <label><?= ucwords(str_replace('_',' ', $keyName)) ?></label>
                                      <div class="input-group">
                                        <input type="password" class="form-control" id="<?= $fieldId ?>" name="<?= htmlspecialchars($keyName) ?>" value="<?= htmlspecialchars($keyValue) ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="<?= $fieldId ?>"><i class="fa fa-eye"></i></button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php endforeach; ?>
                              </div>

                              <!-- ---------------- STRIPE SECTION ---------------- -->
                              <div class="section-header-box">
                                <h5 class="m-0">Stripe Integration</h5>
                                <div class="d-flex align-items-center">
                                  <?php if ($hasStripe): ?>
                                  <label class="switch-toggle mb-0 mr-2">
                                    <input type="checkbox" id="stripeMode" name="stripe_mode" value="1" <?= $stripeMode == 1 ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                  <span class="mode-label" id="stripeLabel"><?= $stripeMode == 1 ? 'Live Mode' : 'Test Mode' ?></span>
                                  <?php endif; ?>

                                  <span class="mode-label"><?= $hasStripe ? 'Enabled' : 'Disabled' ?></span>
                                  <label class="switch-toggle mb-0">
                                    <input type="checkbox" class="section-master-toggle" data-section="stripe" <?= $hasStripe ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                </div>
                              </div>

                              <?php if ($hasStripe): ?>
                              <div class="row">
                                <?php foreach ($apiKeys as $sIdx => $apiKey):
                                  if (!in_array($apiKey['key_name'], $stripeKeys)) continue;
                                  $keyName = $apiKey['key_name'];
                                  $keyValue = $apiKey['key_value'];
                                  $fieldId = "stripe_" . $sIdx;
                                ?>
                                  <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                      <label><?= ucwords(str_replace('_',' ', $keyName)) ?></label>
                                      <div class="input-group">
                                        <input type="password" class="form-control" id="<?= $fieldId ?>" name="<?= htmlspecialchars($keyName) ?>" value="<?= htmlspecialchars($keyValue) ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="<?= $fieldId ?>"><i class="fa fa-eye"></i></button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php endforeach; ?>
                              </div>
                              <?php endif; ?>

                              <!-- ---------------- PAYPAL SECTION ---------------- -->
                              <div class="section-header-box">
                                <h5 class="m-0">PayPal Integration</h5>
                                <div class="d-flex align-items-center">
                                  <?php if ($hasPaypal): ?>
                                  <label class="switch-toggle mb-0 mr-2">
                                    <input type="checkbox" id="paypalMode" name="paypal_mode" value="1" <?= $paypalMode == 1 ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                  <span class="mode-label" id="paypalLabel"><?= $paypalMode == 1 ? 'Live Mode' : 'Sandbox Mode' ?></span>
                                  <?php endif; ?>
                                  
                                  <span class="mode-label"><?= $hasPaypal ? 'Enabled' : 'Disabled' ?></span>
                                  <label class="switch-toggle mb-0">
                                    <input type="checkbox" class="section-master-toggle" data-section="paypal" <?= $hasPaypal ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                </div>
                              </div>

                              <?php if ($hasPaypal): ?>
                              <div class="row">
                                <?php foreach ($apiKeys as $pIdx => $apiKey):
                                  if (!in_array($apiKey['key_name'], $paypalKeys)) continue;
                                  $keyName = $apiKey['key_name'];
                                  $keyValue = $apiKey['key_value'];
                                  $fieldId = "paypal_" . $pIdx;
                                ?>
                                  <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                      <label><?= ucwords(str_replace('_',' ', $keyName)) ?></label>
                                      <div class="input-group">
                                        <input type="password" class="form-control" id="<?= $fieldId ?>" name="<?= htmlspecialchars($keyName) ?>" value="<?= htmlspecialchars($keyValue) ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="<?= $fieldId ?>"><i class="fa fa-eye"></i></button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php endforeach; ?>
                              </div>
                              <?php endif; ?>

                              <!-- ---------------- PIXEL SECTION ---------------- -->
                              <div class="section-header-box">
                                <h5 class="m-0">Pixel</h5>
                                <div class="d-flex align-items-center">
                                  <?php if ($hasPixel): ?>
                                  <label class="switch-toggle mb-0 mr-2">
                                    <input type="checkbox" id="pixelMode" name="pixel_mode" value="1" <?= $pixelMode == 1 ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                  <span class="mode-label" id="pixelLabel"><?= $pixelMode == 1 ? 'Live Mode' : 'Test Mode' ?></span>
                                  <?php endif; ?>

                                  <span class="mode-label"><?= $hasPixel ? 'Enabled' : 'Disabled' ?></span>
                                  <label class="switch-toggle mb-0">
                                    <input type="checkbox" class="section-master-toggle" data-section="pixel" <?= $hasPixel ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
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
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="pixel_key_field" name="pixel_key" value="<?= htmlspecialchars($pixelVal) ?>" placeholder="Enter Pixel Key">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="pixel_key_field"><i class="fa fa-eye"></i></button>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <?php endif; ?>

                              <!-- ---------------- FISKALY SECTION ---------------- -->
                              <?php 
                                $fiskaly_keys = 0; 
                                $fiskalyApiKeyVal = '';
                                $fiskalyApiSecretVal = '';
                                if ($hasFiskaly) {
                                    foreach ($apiKeys as $k) {
                                        if ($k['key_name'] === 'fiskaly_api_key') $fiskalyApiKeyVal = $k['key_value'];
                                        if ($k['key_name'] === 'fiskaly_api_secret') $fiskalyApiSecretVal = $k['key_value'];
                                    }
                                    if (!empty($fiskalyApiKeyVal)) $fiskaly_keys++;
                                    if (!empty($fiskalyApiSecretVal)) $fiskaly_keys++;
                                }
                                $isFiskalyFilled = (!empty($fiskalyApiKeyVal) && !empty($fiskalyApiSecretVal));
                              ?>
                              <div class="section-header-box">
                                <div class="d-flex align-items-center">
                                  <h5 class="m-0 mr-3">Fiskaly Integration</h5>
                                  <?php if ($hasFiskaly && $fiskaly_keys === 2): ?>
                                  <button type="button" id="startFiskaly" class="btn btn-primary btn-sm">Authenticate Fiskaly</button>
                                  <?php endif; ?>
                                </div>
                                <div class="d-flex align-items-center">
                                  <?php if ($hasFiskaly): ?>
                                  <label class="switch-toggle mb-0 mr-2">
                                    <input type="checkbox" id="fiskalyMode" name="fiskaly_mode" value="1" <?= $fiskalyMode == 1 ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                  <span class="mode-label" id="fiskalyLabel"><?= $fiskalyMode == 1 ? 'Online' : 'Offline' ?></span>
                                  <?php endif; ?>

                                  <span class="mode-label"><?= $hasFiskaly ? 'Enabled' : 'Disabled' ?></span>
                                  <label class="switch-toggle mb-0">
                                    <input type="checkbox" class="section-master-toggle" data-section="fiskaly" <?= $hasFiskaly ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                </div>
                              </div>

                              <?php if ($hasFiskaly): ?>
                              <div>
                                <div class="row mb-2">
                                    <?php foreach ($fiskalyKeys as $fIdx => $fKey):
                                        if($fKey === 'fiskaly_mode') continue;
                                        $val = '';
                                        foreach ($apiKeys as $k) { 
                                            if ($k['key_name'] === $fKey) { 
                                                $val = $k['key_value']; 
                                                break; 
                                            } 
                                        }
                                        
                                        $isBottomInput = in_array($fKey, ['fiskaly_tss_id', 'fiskaly_client_id', 'fiskaly_admin_pin', 'fiskaly_admin_punk']);
                                        $isDisabled = ($isBottomInput && $isFiskalyFilled) ? 'disabled' : '';
                                        $fieldId = "fiskaly_" . $fIdx;
                                    ?>
                                      <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                          <label><?= ucwords(str_replace('_',' ', $fKey)) ?></label>
                                          <div class="input-group">
                                            <input type="password" class="form-control" id="<?= $fieldId ?>" name="<?= htmlspecialchars($fKey) ?>" value="<?= htmlspecialchars($val) ?>" placeholder="Enter <?= ucwords(str_replace('_',' ', $fKey)) ?>" <?= $isDisabled ?>>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="<?= $fieldId ?>"><i class="fa fa-eye"></i></button>
                                            </div>
                                          </div>
                                          <?php if($isDisabled): ?>
                                              <input type="hidden" name="<?= htmlspecialchars($fKey) ?>" value="<?= htmlspecialchars($val) ?>">
                                          <?php endif; ?>
                                        </div>
                                      </div>
                                    <?php endforeach; ?>
                                </div>
                              </div>
                              <br>
                              <?php endif; ?>

                              <!-- ---------------- LIEFERSOFT KEYS ---------------- -->
                              <div class="section-header-box">
                                <h5 class="m-0">Liefersoft Integration</h5>
                                <div class="d-flex align-items-center">
                                  <span class="mode-label"><?= $hasLiefersoft ? 'Enabled' : 'Disabled' ?></span>
                                  <label class="switch-toggle mb-0">
                                    <input type="checkbox" class="section-master-toggle" data-section="liefersoft" <?= $hasLiefersoft ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                </div>
                              </div>

                              <?php if ($hasLiefersoft): ?>
                              <!-- Company ID Row -->
                              <div class="row mb-2">
                                  <div class="col-md-6">
                                      <label>Company Id</label>
                                      <div class="input-group">
                                          <input type="password" class="form-control" id="liefersoft_company" name="liefersoft_company_key" 
                                                 value="<?php
                                                     $val = '';
                                                     foreach ($apiKeys as $k) { if($k['key_name'] == 'liefersoft_company_key') { $val = $k['key_value']; break; } }
                                                     echo htmlspecialchars($val);
                                                 ?>" 
                                                 placeholder="Enter Company Key">
                                          <div class="input-group-append">
                                              <button class="btn btn-outline-secondary toggle-password" type="button" data-target="liefersoft_company"><i class="fa fa-eye"></i></button>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <!-- Login & Password Row -->
                              <div class="row mb-2">
                                  <div class="col-md-6">
                                      <label>Login</label>
                                      <div class="input-group">
                                          <input type="password" class="form-control" id="liefersoft_login" name="liefersoft_login_key" 
                                                 value="<?php
                                                     $val = '';
                                                     foreach ($apiKeys as $k) { if($k['key_name'] == 'liefersoft_login_key') { $val = $k['key_value']; break; } }
                                                     echo htmlspecialchars($val);
                                                 ?>" 
                                                 placeholder="Enter Login Key">
                                          <div class="input-group-append">
                                              <button class="btn btn-outline-secondary toggle-password" type="button" data-target="liefersoft_login"><i class="fa fa-eye"></i></button>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="col-md-6">
                                      <label>Password</label>
                                      <div class="input-group">
                                          <input type="password" class="form-control" id="liefersoft_pass" name="liefersoft_password_key" 
                                                 value="<?php
                                                     $val = '';
                                                     foreach ($apiKeys as $k) { if($k['key_name'] == 'liefersoft_password_key') { $val = $k['key_value']; break; } }
                                                     echo htmlspecialchars($val);
                                                 ?>" 
                                                 placeholder="Enter Password Key">
                                          <div class="input-group-append">
                                              <button class="btn btn-outline-secondary toggle-password" type="button" data-target="liefersoft_pass"><i class="fa fa-eye"></i></button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <?php endif; ?>

                              <!-- ---------------- SOCIAL LINKS SECTION ---------------- -->
                              <div class="section-header-box">
                                <h5 class="m-0">Social & Store Links</h5>
                                <div class="d-flex align-items-center">
                                  <span class="mode-label"><?= $hasSocial ? 'Enabled' : 'Disabled' ?></span>
                                  <label class="switch-toggle mb-0">
                                    <input type="checkbox" class="section-master-toggle" data-section="social" <?= $hasSocial ? 'checked' : '' ?>>
                                    <span class="slider"></span>
                                  </label>
                                </div>
                              </div>

                              <?php if ($hasSocial): ?>
                              <div class="row mb-2">
                                <?php foreach ($socialKeys as $socIdx => $sKey): $val = '';
                                    foreach ($apiKeys as $k) { if($k['key_name'] === $sKey) { $val = $k['key_value']; break; } }
                                    $fieldId = "social_" . $socIdx;
                                ?>
                                  <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                      <label><?= ucwords(str_replace('_',' ', $sKey)) ?></label>
                                      <div class="input-group">
                                        <input type="password" class="form-control" id="<?= $fieldId ?>" name="<?= htmlspecialchars($sKey) ?>" value="<?= htmlspecialchars($val) ?>" placeholder="Enter Link/Key">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="<?= $fieldId ?>"><i class="fa fa-eye"></i></button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php endforeach; ?>
                              </div>
                              <?php endif; ?>

                              <!-- Update button direct submission (OTP removed) -->
                              <button type="submit" class="btn btn-primary mt-2">Update</button>

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

    <!-- Fullscreen Dedicated Custom Lock Screen Overlay Modal -->
    <div id="pageLockOverlay">
      <div class="card shadow-lg" style="width: 400px; border-radius: 8px;">
        <div class="card-header bg-primary white text-center">
          <h4 class="card-title white m-0">Admin Authentication Required</h4>
        </div>
        <div class="card-body text-center p-4">
          <p class="mb-3">Security verification required. An OTP has been sent to the admin email.</p>
          <input type="text" class="form-control text-center font-medium-3 mb-2" id="initial_entered_otp" placeholder="Enter OTP" required>
          <input type="hidden" id="initial_actual_otp">
          <button type="button" id="verifyInitialOtp" class="btn btn-primary btn-block mt-2">Verify & Unlock</button>
        </div>
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

// Page Load par automatic OTP send aur Lock Screen show karna
document.addEventListener("DOMContentLoaded", function () {
    // Trigger OTP sending on load
    const formData = new FormData();
    formData.append('send_initial_otp', '1');

    fetch('../API/send_otp.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data && data.success) {
            document.getElementById('initial_actual_otp').value = data.otp;
        } else {
            console.error("Failed to send initial OTP");
        }
    })
    .catch(err => {
        console.error("Error sending initial OTP:", err);
    });

    // Eye button toggle listener
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const inputField = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (inputField.type === "password") {
                inputField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                inputField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    });
});

// Verify Initial OTP Button Click to Unlock Page
document.getElementById('verifyInitialOtp').addEventListener('click', function() {
    const entered = document.getElementById('initial_entered_otp').value.trim();
    const actual = document.getElementById('initial_actual_otp').value.trim();

    if (entered === actual && entered !== "") {
        document.getElementById('pageLockOverlay').style.display = 'none';
    } else {
        alert("Invalid OTP! Please enter correct OTP.");
    }
});

// Master Toggle Click Listener with Delete Confirmation Alert
document.querySelectorAll('.section-master-toggle').forEach(toggle => {
    toggle.addEventListener('change', function(e) {
        const isChecked = this.checked;
        
        if (!isChecked) {
            const confirmDelete = confirm("Are you sure you want to delete the keys?");
            if (!confirmDelete) {
                this.checked = true;
                return;
            }
        }

        const section = this.getAttribute('data-section');
        const status = isChecked ? 1 : 0;
        
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

// Mode Toggle Listeners (Stripe, PayPal, Pixel, Fiskaly)
document.addEventListener("DOMContentLoaded", function () {
    const stripeMode = document.getElementById('stripeMode');
    if (stripeMode) {
        stripeMode.addEventListener('change', function () {
            document.getElementById('stripeLabel').textContent = this.checked ? 'Live Mode' : 'Test Mode';
        });
    }

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

    const fiskalyMode = document.getElementById('fiskalyMode');
    if (fiskalyMode) {
        fiskalyMode.addEventListener('change', function () {
            document.getElementById('fiskalyLabel').textContent = this.checked ? 'Online' : 'Offline';
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

            response = await fetch(`https://kassensichv-middleware.fiskaly.com/api/query/v2/tss/${tssid}/admin/auth`, {
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
            
            
            response = await fetch(`https://kassensichv-middleware.fiskaly.com/api/v2/tss/${tssid}`, {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${access_token}`
                },
                body: JSON.stringify({
                    description: "Taking this permission for our setup",
                    state: "INITIALIZED"
                })
            });

            await response.json();
            
            alert("Fiskaly Authenticated Successfully!");

        } catch (error) {
            console.error("Error:", error);
            alert("Fiskaly Error: " + error.message);
        }
    });
}

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