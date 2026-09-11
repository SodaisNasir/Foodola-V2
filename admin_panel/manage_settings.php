<?php include('assets/header.php') ?>

<?php
include_once("connection.php");
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

// Fetch settings
$result = mysqli_query($conn, "SELECT * FROM system_setting LIMIT 1");
$settings = mysqli_fetch_assoc($result);
$currency = json_decode($settings['currency'], true);

// Handle update settings
if (isset($_POST['update'])) {
    $is_open = intval($_POST['is_open']);
    $sign = mysqli_real_escape_string($conn, $_POST['sign']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);

    $ios_link = mysqli_real_escape_string($conn, $_POST['ios_link']);
    $android_link = mysqli_real_escape_string($conn, $_POST['android_link']);
    $report_lang = mysqli_real_escape_string($conn, $_POST['report_lang']);
    $duration_minutes = intval($_POST['duration_minutes']);
    $currency = json_encode([
        "sign" => $sign,
        "position" => $position
    ], JSON_UNESCAPED_UNICODE);

    $sql = "UPDATE system_setting SET
                is_open='$is_open',
                currency='$currency',
                ios_link='$ios_link',
                android_link='$android_link',
                report_lang='$report_lang',
                duration_minutes='$duration_minutes'
            WHERE id=" . intval($settings['id']);

    mysqli_query($conn, $sql);

    header("Location: ".$_SERVER['PHP_SELF']."?success=1");
    exit;
}

// ==========================================
// HANDLE SHOPS (ADD, EDIT & DELETE)
// ==========================================

// Handle Add Shop
if (isset($_POST['add_shop'])) {
    $shop_name = mysqli_real_escape_string($conn, trim($_POST['shop_name']));
    $child_url = mysqli_real_escape_string($conn, trim($_POST['child_url'])); // Added child_url
    
    // Checkbox values
    $show_name = isset($_POST['show_name']) ? 1 : 0;
    $show_logo = isset($_POST['show_logo']) ? 1 : 0;
    
    // Logo Upload Logic
    $logo_path = "";
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'Uploads/'; 
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_extension = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
        $new_filename = time() . '_' . uniqid() . '.' . $file_extension;
        $target_file = $upload_dir . $new_filename;
        
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            $logo_path = $target_file;
        }
    }
    
    if (!empty($shop_name)) {
        $access_token = bin2hex(random_bytes(16));
        $sql = "INSERT INTO shops (shop_name, logo, show_name, show_logo, access_token, child_url) 
                VALUES ('$shop_name', '$logo_path', $show_name, $show_logo, '$access_token', '$child_url')";
        mysqli_query($conn, $sql);
        header("Location: ".$_SERVER['PHP_SELF']."?shop_success=added");
        exit;
    }
}

// Handle Edit Shop
if (isset($_POST['edit_shop'])) {
    $shop_id = intval($_POST['shop_id']);
    $shop_name = mysqli_real_escape_string($conn, trim($_POST['shop_name']));
    $child_url = mysqli_real_escape_string($conn, trim($_POST['child_url'])); // Added child_url
    
    $show_name = isset($_POST['show_name']) ? 1 : 0;
    $show_logo = isset($_POST['show_logo']) ? 1 : 0;
    
    $update_logo_sql = ""; // Default: empty (do nothing with logo if not uploaded)
    
    // Check if a new logo is uploaded
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'Uploads/'; 
        if (!is_dir($upload_dir)) { mkdir($upload_dir, 0777, true); }
        
        $file_extension = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
        $new_filename = time() . '_' . uniqid() . '.' . $file_extension;
        $target_file = $upload_dir . $new_filename;
        
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            // Delete old logo file from server first
            $res = mysqli_query($conn, "SELECT logo FROM shops WHERE id = $shop_id");
            if ($row = mysqli_fetch_assoc($res)) {
                if (!empty($row['logo']) && file_exists($row['logo'])) {
                    unlink($row['logo']);
                }
            }
            // Prepare update string for logo
            $update_logo_sql = ", logo='$target_file'";
        }
    }
    
    if (!empty($shop_name)) {
        $sql = "UPDATE shops SET 
                    shop_name='$shop_name', 
                    show_name=$show_name, 
                    show_logo=$show_logo,
                    child_url='$child_url'
                    $update_logo_sql 
                WHERE id=$shop_id";
        mysqli_query($conn, $sql);
        
        header("Location: ".$_SERVER['PHP_SELF']."?shop_success=updated");
        exit;
    }
}

// Handle Delete Shop
if (isset($_GET['delete_shop_id'])) {
    $delete_id = intval($_GET['delete_shop_id']);
    
    // Fetch logo path to delete the file from the server
    $res = mysqli_query($conn, "SELECT logo FROM shops WHERE id = $delete_id");
    if ($row = mysqli_fetch_assoc($res)) {
        if (!empty($row['logo']) && file_exists($row['logo'])) {
            unlink($row['logo']);
        }
    }
    
    $sql = "DELETE FROM shops WHERE id = $delete_id";
    mysqli_query($conn, $sql);
    
    header("Location: ".$_SERVER['PHP_SELF']."?shop_success=deleted");
    exit;
}

// Fetch all shops
$shops_result = mysqli_query($conn, "SELECT * FROM shops ORDER BY id DESC");
?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php include('title.php'); echo $pageTitle; ?></title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/apple-icon-120.html">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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
                <h2 class="content-header-title float-left mb-0">Manage Settings</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Manage Settings</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>

        <section id="basic-datatable" class="mt-4">
          <div class="row">
            <div class="col-12">
              <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header text-white">
                  <h5 class="mb-0">System Settings</h5>
                </div>
                <div class="card-body">
                
                  <?php if(isset($_GET['success'])): ?>
                    <div class="alert alert-success">Settings updated successfully!</div>
                  <?php endif; ?>
                
                  <form method="post" class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label fw-bold">Restaurant Status</label>
                      <select name="is_open" class="form-select">
                        <option value="1" <?php if($settings['is_open']==1) echo "selected"; ?>>Open</option>
                        <option value="0" <?php if($settings['is_open']==0) echo "selected"; ?>>Closed</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label fw-bold">Currency Sign</label>
                      <input type="text" name="sign" class="form-control text-center" maxlength="3" value="<?php echo htmlspecialchars($currency['sign']); ?>">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label fw-bold">Currency Position</label>
                      <select name="position" class="form-select">
                        <option value="left" <?php if($currency['position']=="left") echo "selected"; ?>>Left (e.g. $100)</option>
                        <option value="right" <?php if($currency['position']=="right") echo "selected"; ?>>Right (e.g. 100$)</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">iOS App Link</label>
                        <input type="url" name="ios_link" class="form-control" value="<?php echo htmlspecialchars($settings['ios_link']); ?>" placeholder="https://apps.apple.com/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Android App Link</label>
                        <input type="url" name="android_link" class="form-control" value="<?php echo htmlspecialchars($settings['android_link']); ?>" placeholder="https://play.google.com/store/apps/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Duration (Minutes)</label>
                        <input type="number" name="duration_minutes" class="form-control" min="1" value="<?php echo htmlspecialchars($settings['duration_minutes']); ?>" placeholder="e.g. 30">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Report Language</label>
                        <select name="report_lang" class="form-select">
                            <option value="en" <?php if($settings['report_lang'] == "en") echo "selected"; ?>>English</option>
                            <option value="de" <?php if($settings['report_lang'] == "de") echo "selected"; ?>>German</option>
                        </select>
                    </div>
                    <div class="col-12 mt-3">
                      <button type="submit" name="update" class="btn btn-success px-4">Save Settings</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section id="shops-section" class="mt-4 mb-4">
          <div class="row">
            <div class="col-12">
              
              <?php if(isset($_GET['shop_success'])): ?>
                <?php if($_GET['shop_success'] == 'added'): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                    Shop added successfully! Access token generated.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php elseif($_GET['shop_success'] == 'updated'): ?>
                    <div class="alert alert-info alert-dismissible fade show">
                    Shop updated successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php elseif($_GET['shop_success'] == 'deleted'): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                    Shop deleted successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
              <?php endif; ?>

              <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header text-white">
                  <h5 class="mb-0">Add New Shop</h5>
                </div>
                <div class="card-body mt-2">
                  <form method="post" enctype="multipart/form-data" class="row g-3 align-items-end">
                    <div class="col-md-3">
                      <label class="form-label fw-bold">Shop Name</label>
                      <input type="text" name="shop_name" class="form-control" placeholder="Enter shop name" required>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label fw-bold">URL</label>
                      <input type="url" name="child_url" class="form-control" placeholder="https://domain.com">
                    </div>
                    <div class="col-md-2">
                      <label class="form-label fw-bold">Shop Logo</label>
                      <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold d-block">Show On Receipt</label>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="checkbox" name="show_name" id="showName" value="1" checked>
                            <label class="form-check-label" for="showName">Name</label>
                        </div>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="checkbox" name="show_logo" id="showLogo" value="1">
                            <label class="form-check-label" for="showLogo">Logo</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                      <button type="submit" name="add_shop" class="btn btn-primary w-100">Add Shop</button>
                    </div>
                  </form>
                </div>
              </div>

              <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header text-white">
                  <h5 class="mb-0">Shops List</h5>
                </div>
                <div class="card-body mt-2">
                  <div class="table-responsive">
                    <table class="table table-hover align-middle border">
                      <thead class="table-light">
                        <tr>
                          <th style="width: 80px;">ID</th>
                          <th>Shop Name</th>
                          <th>URL </th>
                          <th>Logo</th>
                          <th>Display Settings</th>
                          <th>Access Token</th>
                          <th style="width: 150px;" class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($shops_result && mysqli_num_rows($shops_result) > 0): ?>
                          <?php while ($shop = mysqli_fetch_assoc($shops_result)): ?>
                            <tr>
                              <td><strong>#<?php echo $shop['id']; ?></strong></td>
                              <td><?php echo htmlspecialchars($shop['shop_name']); ?></td>
                              <td>
                                <?php if(!empty($shop['child_url'])): ?>
                                    <a href="<?php echo htmlspecialchars($shop['child_url']); ?>" target="_blank" class="text-truncate d-inline-block" style="max-width: 180px;">
                                        <?php echo htmlspecialchars($shop['child_url']); ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">N/A</span>
                                <?php endif; ?>
                              </td>
                              <td>
                                <?php if (!empty($shop['logo'])): ?>
                                    <img src="<?php echo htmlspecialchars($shop['logo']); ?>" alt="Logo" style="width:40px; height:40px; object-fit:cover; border-radius:4px;">
                                <?php else: ?>
                                    <span class="text-muted small">No Logo</span>
                                <?php endif; ?>
                              </td>
                              <td style="font-size: 0.9rem;">
                                  <div class="mb-1">
                                      <span class="text-muted">Name:</span> 
                                      <span class="badge bg-<?php echo $shop['show_name'] ? 'success' : 'danger'; ?>">
                                          <?php echo $shop['show_name'] ? 'Yes' : 'No'; ?>
                                      </span>
                                  </div>
                                  <div>
                                      <span class="text-muted">Logo:</span> 
                                      <span class="badge bg-<?php echo $shop['show_logo'] ? 'success' : 'danger'; ?>">
                                          <?php echo $shop['show_logo'] ? 'Yes' : 'No'; ?>
                                      </span>
                                  </div>
                              </td>
                              <td>
                                <code class="bg-light p-1 rounded text-dark fs-6"><?php echo htmlspecialchars($shop['access_token']); ?></code>
                              </td>
                              <td class="text-center">
                                  <div class="d-flex justify-content-center align-items-center gap-2">
                                      <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $shop['id']; ?>" title="Edit Shop">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                          </svg>
                                      </button>
                                      
                                      <a href="<?php echo $_SERVER['PHP_SELF']; ?>?delete_shop_id=<?php echo $shop['id']; ?>" 
                                         class="btn btn-danger btn-sm" 
                                         onclick="return confirm('Are you sure you want to delete this shop?');" title="Delete Shop">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                      </a>
                                  </div>
                              </td>
                            </tr>

                            <div class="modal fade" id="editModal<?php echo $shop['id']; ?>" tabindex="-1" aria-hidden="true">
                              <div class="modal-dialog text-start">
                                <div class="modal-content">
                                  <form method="post" enctype="multipart/form-data">
                                    <div class="modal-header">
                                      <h5 class="modal-title text-dark">Edit Shop</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-dark">
                                      <input type="hidden" name="shop_id" value="<?php echo $shop['id']; ?>">
                                      
                                      <div class="mb-3">
                                        <label class="form-label fw-bold">Shop Name</label>
                                        <input type="text" name="shop_name" class="form-control" value="<?php echo htmlspecialchars($shop['shop_name']); ?>" required>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label fw-bold">URL</label>
                                        <input type="url" name="child_url" class="form-control" value="<?php echo htmlspecialchars($shop['child_url'] ?? ''); ?>" placeholder="https://domain.com">
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label fw-bold">Update Logo <span class="text-muted fw-normal text-sm" style="font-size: 11px;">(Leave empty to keep current)</span></label>
                                        <input type="file" name="logo" class="form-control" accept="image/*">
                                        <?php if (!empty($shop['logo'])): ?>
                                            <div class="mt-2">
                                                <small class="text-muted">Current Logo:</small><br>
                                                <img src="<?php echo htmlspecialchars($shop['logo']); ?>" alt="Logo" style="width:60px; height:60px; object-fit:cover; border-radius:4px; border: 1px solid #ccc;">
                                            </div>
                                        <?php endif; ?>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label fw-bold d-block">Show On Receipt</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="show_name" id="editShowName<?php echo $shop['id']; ?>" value="1" <?php echo $shop['show_name'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="editShowName<?php echo $shop['id']; ?>">Name</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="show_logo" id="editShowLogo<?php echo $shop['id']; ?>" value="1" <?php echo $shop['show_logo'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="editShowLogo<?php echo $shop['id']; ?>">Logo</label>
                                        </div>
                                      </div>

                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" name="edit_shop" class="btn btn-success">Save Changes</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="7" class="text-center text-muted py-4">No shops found. Add one above!</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </section>
      </div>
    </div>

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

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
    <script src="app-assets/js/scripts/customizer.min.js"></script>
    <script src="app-assets/js/scripts/footer.min.js"></script>
    <script src="app-assets/js/scripts/datatables/datatable.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>