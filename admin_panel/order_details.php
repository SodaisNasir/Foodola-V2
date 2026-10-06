<?php 
include('assets/header.php');
include('phpfiles/function.php');
// Report all PHP errors
error_reporting(E_ALL);

// Display errors directly to the browser
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
?>
<!DOCTYPE html>

<?php
if (isset($_GET['Massage'])) {
  if ($_GET['Massage'] == 'Sucessfully updated order.') {
    echo "<script>alert('Sucessfully updated order.')</script>";
    header("Refresh: 1; url='neworders.php'");
  } else {
    echo "<script>alert('The amount was bigger than the required or student got the sponcer!')</script>";
  }
}
?>

<html class="loading" lang="en" data-textdirection="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <title><?php include('title.php'); echo $pageTitle; ?></title>
  
  <link rel="apple-touch-icon" href="app-assets/images/ico/apple-icon-120.html">
  <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
  
  <!-- FontAwesome 6 Icons & Plus Jakarta Sans Font -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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

  <style>
    body {
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
      background-color: #f8fafc;
      color: #0f172a;
    }

    /* Breadcrumb & Header Layout */
    .header-breadcrumb-container {
      display: flex;
      align-items: center;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .page-main-title {
      font-size: 1.6rem;
      font-weight: 400;
      color: #334155;
      margin: 0;
      line-height: 1;
    }

    .title-divider {
      width: 1px;
      height: 22px;
      background-color: #cbd5e1;
      display: inline-block;
    }

    .breadcrumb-nav {
      font-size: 0.9rem;
      color: #64748b;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 400;
    }

    .breadcrumb-nav a {
      color: #7367f0;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .breadcrumb-nav a:hover {
      color: #5e50ee;
      text-decoration: underline;
    }

    .breadcrumb-nav .separator {
      color: #94a3b8;
      font-size: 1.1rem;
      line-height: 1;
    }

    .breadcrumb-nav .current-page {
      color: #64748b;
    }

    /* Modern Card Container */
    .card-modern {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.03);
      margin-bottom: 1.5rem;
      overflow: hidden;
    }

    .card-header-modern {
      padding: 1.1rem 1.5rem;
      background: #ffffff;
      border-bottom: 1px solid #f1f5f9;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .card-title-modern {
      font-size: 1rem;
      font-weight: 700;
      color: #0f172a;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin: 0;
    }

    /* Info Grid Tile */
    .info-tile {
      background: #f8fafc;
      border: 1px solid #f1f5f9;
      border-radius: 8px;
      padding: 0.85rem 1rem;
      height: 100%;
    }

    .tile-label {
      font-size: 0.725rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: #64748b;
      display: flex;
      align-items: center;
      gap: 0.4rem;
      margin-bottom: 0.35rem;
    }

    .tile-value {
      font-size: 0.925rem;
      font-weight: 700;
      color: #0f172a;
    }

    /* Status & User Type Badges */
    .status-pill {
      padding: 0.3em 0.75em;
      font-size: 0.75rem;
      font-weight: 700;
      border-radius: 30px;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      text-transform: capitalize;
    }
    .status-delivered { background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .status-pending { background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .status-canceled { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

    .user-tag {
      font-size: 0.675rem;
      font-weight: 700;
      padding: 0.15rem 0.5rem;
      border-radius: 6px;
      text-transform: uppercase;
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
      margin-left: 0.4rem;
    }
    .tag-guest { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .tag-registered { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

    /* Payment Box */
    .payment-box {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-left: 4px solid #2563eb;
      border-radius: 8px;
      padding: 0.85rem 1.1rem;
    }

    /* Inputs & Buttons Height Matching */
    .form-control-aligned {
      height: 42px !important;
      border-radius: 8px !important;
      font-size: 0.875rem !important;
      border: 1px solid #cbd5e1 !important;
    }

    .form-control-aligned:focus {
      border-color: #2563eb !important;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
    }

    .btn-aligned {
      height: 42px !important;
      border-radius: 8px !important;
      font-size: 0.875rem !important;
      font-weight: 600 !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      gap: 0.4rem !important;
      padding: 0 1.25rem !important;
    }

    /* Minimalist Table */
    .table-modern {
      width: 100%;
      margin-bottom: 0;
      border-collapse: separate;
      border-spacing: 0;
    }

    .table-modern th {
      font-size: 0.725rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: #64748b;
      background-color: #f8fafc;
      border-bottom: 1px solid #e2e8f0;
      font-weight: 700;
      padding: 0.75rem 1.25rem;
      white-space: nowrap;
    }

    .table-modern td {
      padding: 0.9rem 1.25rem;
      border-bottom: 1px solid #f1f5f9;
      font-size: 0.875rem;
      color: #334155;
      vertical-align: middle;
    }

    .table-modern tbody tr:last-child td {
      border-bottom: none;
    }

    .table-modern tbody tr:hover {
      background-color: #f8fafc;
    }

    .qty-chip {
      background-color: #f1f5f9;
      color: #0f172a;
      font-weight: 700;
      padding: 0.2rem 0.55rem;
      border-radius: 6px;
      font-size: 0.8rem;
    }

    .badge-chip {
      background: #f1f5f9;
      color: #475569;
      font-weight: 600;
      padding: 0.2rem 0.5rem;
      border-radius: 6px;
      font-size: 0.75rem;
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
      margin-right: 0.25rem;
    }

    .subtotal-bar {
      background: #ffffff;
      border-top: 1px solid #e2e8f0;
      padding: 1.1rem 1.5rem;
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }

    .subtotal-badge {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 0.5rem 1.25rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1050;
      padding-top: 100px;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(15, 23, 42, 0.4);
    }

    .modal-content-Updated2 {
      background-color: #ffffff;
      margin: auto;
      padding: 24px;
      border: 1px solid #e2e8f0;
      width: 400px;
      border-radius: 12px;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .close {
      color: #94a3b8;
      float: right;
      font-size: 20px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover { color: #0f172a; }
  </style>
</head>

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">
  
  <?php include('assets/Site_Bar.php') ?>

  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
      
      <!-- Top Navigation & Breadcrumb Header -->
      <div class="content-header row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
          
          <div class="header-breadcrumb-container">
            <h2 class="page-main-title">Order Details</h2>
            <span class="title-divider"></span>
            <div class="breadcrumb-nav">
              <a href="dashboard.php">Home</a>
              <span class="separator">&raquo;</span>
              <a href="neworders.php">Orders</a>
              <span class="separator">&raquo;</span>
              <span class="current-page">Order #<?php echo intval($_GET['order_id']); ?></span>
            </div>
          </div>

          <a href="reciept.php?order_id=<?php echo intval($_GET['order_id']); ?>" class="btn btn-outline-secondary btn-aligned">
            <i class="fa-solid fa-print"></i> Print Receipt
          </a>

        </div>
      </div>

      <div class="content-body">
        
        <?php
        include_once('connection.php');
        $order_id = intval($_GET['order_id']);

        // Added additional_notes to SQL query
        $sqlx = "SELECT `table_id`, `status`, `delivered_at`, `order_type`, `user_id`, 
                        `user_name`, `user_email`, `user_phone`, `platform`,
                        `Shipping_Cost`, `total_discount`, `order_total_price`, `ordersheduletype`, 
                        `Shipping_address`, `Shipping_address_2`, `Shipping_postal_code`,`Shipping_area`,`Shipping_state`,`Shipping_city`, 
                        `sheduletime`, `payment_type`, `payment_method`, `transaction_id`, `addtional_notes`
                 FROM `orders_zee` WHERE `id` = $order_id";
        $resultx = mysqli_query($conn, $sqlx);

        $customer_name = 'N/A';
        $customer_email = '-';
        $customer_phone = '-';
        $customer_type = 'guest';
        $platform = 'Web';
        $table_name = 'N/A';
        $order_additional_notes = '';

        if ($rowx = mysqli_fetch_assoc($resultx)) {
          $status = htmlspecialchars($rowx['status'] ?? 'pending');
          $delivered_at = htmlspecialchars($rowx['delivered_at'] ?? 'N/A');
          $orderType = htmlspecialchars($rowx['order_type'] ?? 'N/A');
          $user_id = intval($rowx['user_id']);
          $shippingCost = intval($rowx['Shipping_Cost']);
          $total_discount = htmlspecialchars($rowx['total_discount'] ?? 0);
          $order_total = htmlspecialchars($rowx['order_total_price'] ?? 0);
          $orderscedule = htmlspecialchars($rowx['ordersheduletype'] ?? '');
          $address_1 = htmlspecialchars($rowx['Shipping_address'] ?? '');
          $address_2 = htmlspecialchars($rowx['Shipping_address_2'] ?? '');
          $postal_code = htmlspecialchars($rowx['Shipping_postal_code'] ?? '');
          $shipping_area = htmlspecialchars($rowx['Shipping_area'] ?? '');
          $shipping_state = htmlspecialchars($rowx['Shipping_state'] ?? '');
          $shipping_city = htmlspecialchars($rowx['Shipping_city'] ?? '');
          $table_id = htmlspecialchars($rowx['table_id'] ?? '');
          $scedule = htmlspecialchars($rowx['sheduletime'] ?? '');

          $payment_type = htmlspecialchars($rowx['payment_type'] ?? '');
          $payment_method = htmlspecialchars($rowx['payment_method'] ?? '');
          $transaction_id = htmlspecialchars($rowx['transaction_id'] ?? '');

          // Fetched Order Level Additional Notes
          $order_additional_notes = htmlspecialchars($rowx['addtional_notes'] ?? '');

          if (!empty($rowx['platform'])) {
              $platform = htmlspecialchars($rowx['platform']);
          }

          $guest_name = trim($rowx['user_name'] ?? '');
          $guest_email = trim($rowx['user_email'] ?? '');
          $guest_phone = trim($rowx['user_phone'] ?? '');

          if (!empty($guest_name) || !empty($guest_email) || !empty($guest_phone)) {
              $customer_name = !empty($guest_name) ? $guest_name : 'Guest Customer';
              $customer_email = !empty($guest_email) ? $guest_email : '-';
              $customer_phone = !empty($guest_phone) ? $guest_phone : '-';
              $customer_type = 'guest';
          } else if ($user_id) {
              $sqlUser = "SELECT `name`, `email`, `phone` FROM `users` WHERE `id` = $user_id";
              $resultUser = mysqli_query($conn, $sqlUser);
              if ($rowUser = mysqli_fetch_assoc($resultUser)) {
                  $customer_name = htmlspecialchars($rowUser['name'] ?? 'N/A');
                  $customer_email = htmlspecialchars($rowUser['email'] ?? '-');
                  $customer_phone = htmlspecialchars($rowUser['phone'] ?? '-');
                  $customer_type = 'registered';
              }
          } else if ($table_id) {
              $sqlTable = "SELECT `id`,`table_name` FROM `tables` WHERE `id` = '$table_id'";
              $resultTable = mysqli_query($conn, $sqlTable);
              if ($row = mysqli_fetch_assoc($resultTable)) {
                  $table_name = htmlspecialchars($row['table_name']);
                  $customer_name = 'Table: ' . $table_name;
                  $customer_type = 'table';
              }
          }
        }
        ?>

        <!-- Order Information Card -->
        <div class="card-modern">
          <div class="card-header-modern">
            <h5 class="card-title-modern">
              <i class="fa-solid fa-circle-info text-primary"></i> Order Overview
            </h5>
          </div>

          <div class="card-body p-4">
            
            <!-- Row 1: Order Meta -->
            <div class="row g-3 mb-3">
              <div class="col-md-3 col-6">
                <div class="info-tile">
                  <div class="tile-label"><i class="fa-solid fa-signal text-primary"></i> Status</div>
                  <div>
                    <?php 
                      $badgeClass = 'status-pending';
                      $statusIcon = 'fa-clock';
                      if (strtolower($status) == 'delivered') { $badgeClass = 'status-delivered'; $statusIcon = 'fa-circle-check'; }
                      if (strtolower($status) == 'canceled') { $badgeClass = 'status-canceled'; $statusIcon = 'fa-circle-xmark'; }
                    ?>
                    <span class="status-pill <?php echo $badgeClass; ?>">
                      <i class="fa-solid <?php echo $statusIcon; ?>"></i> <?php echo ucfirst($status); ?>
                    </span>
                  </div>
                </div>
              </div>

              <div class="col-md-3 col-6">
                <div class="info-tile">
                  <div class="tile-label"><i class="fa-solid fa-laptop text-info"></i> Source Platform</div>
                  <div class="tile-value d-flex align-items-center gap-1">
                    <?php 
                      $platLower = strtolower($platform);
                      $platIcon = 'fa-globe text-primary';
                      if (strpos($platLower, 'android') !== false) $platIcon = 'fa-brands fa-android text-success';
                      if (strpos($platLower, 'ios') !== false || strpos($platLower, 'apple') !== false) $platIcon = 'fa-brands fa-apple text-dark';
                      if (strpos($platLower, 'app') !== false) $platIcon = 'fa-solid fa-mobile-screen-button text-purple';
                    ?>
                    <i class="<?php echo $platIcon; ?> me-1"></i>
                    <span><?php echo ucfirst($platform); ?></span>
                  </div>
                </div>
              </div>

              <div class="col-md-3 col-6">
                <div class="info-tile">
                  <div class="tile-label"><i class="fa-solid fa-utensils text-warning"></i> Order Type</div>
                  <div class="tile-value"><?php echo $orderType; ?></div>
                </div>
              </div>

              <div class="col-md-3 col-6">
                <div class="info-tile">
                  <div class="tile-label"><i class="fa-regular fa-calendar-check text-success"></i> Schedule</div>
                  <div class="tile-value">
                    <?php echo ($orderscedule == 'ordernow') ? 'Make ready now' : $scedule; ?>
                  </div>
                </div>
              </div>
            </div>

            <!-- Row 2: Customer Details -->
            <div class="row g-3 mb-3">
              <div class="col-md-4 col-12">
                <div class="info-tile">
                  <div class="tile-label"><i class="fa-regular fa-user text-primary"></i> Customer Name</div>
                  <div class="tile-value d-flex align-items-center">
                    <span><?php echo $customer_name; ?></span>
                    <?php if ($customer_type == 'guest'): ?>
                      <span class="user-tag tag-guest"><i class="fa-solid fa-user-clock"></i> Guest</span>
                    <?php elseif ($customer_type == 'registered'): ?>
                      <span class="user-tag tag-registered"><i class="fa-solid fa-user-check"></i> Registered</span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <div class="col-md-4 col-6">
                <div class="info-tile">
                  <div class="tile-label"><i class="fa-solid fa-phone text-success"></i> Phone Number</div>
                  <div class="tile-value"><?php echo $customer_phone; ?></div>
                </div>
              </div>

              <div class="col-md-4 col-6">
                <div class="info-tile">
                  <div class="tile-label"><i class="fa-regular fa-envelope text-danger"></i> Email Address</div>
                  <div class="tile-value text-truncate" style="max-width: 100%;"><?php echo $customer_email; ?></div>
                </div>
              </div>
            </div>

            <!-- Row 3: Pricing Summary -->
            <div class="row g-3 mb-3">
              <div class="col-md-3 col-6">
                <div class="info-tile">
                  <div class="tile-label"><i class="fa-regular fa-clock text-info"></i> Delivered At</div>
                  <div class="tile-value"><?php echo !empty($delivered_at) ? $delivered_at : '-'; ?></div>
                </div>
              </div>

              <div class="col-md-3 col-6">
                <div class="info-tile">
                  <div class="tile-label"><i class="fa-solid fa-truck text-secondary"></i> Shipping Cost</div>
                  <div class="tile-value"><?php echo formatCurrency($shippingCost); ?></div>
                </div>
              </div>

              <div class="col-md-3 col-6">
                <div class="info-tile">
                  <div class="tile-label"><i class="fa-solid fa-tags text-danger"></i> Total Discount</div>
                  <div class="tile-value text-danger">-<?php echo formatCurrency($total_discount); ?></div>
                </div>
              </div>

              <div class="col-md-3 col-6">
                <div class="info-tile">
                  <div class="tile-label"><i class="fa-solid fa-wallet text-success"></i> Grand Total</div>
                  <div class="tile-value text-success fs-6"><?php echo formatCurrency($order_total); ?></div>
                </div>
              </div>
            </div>

            <!-- Delivery Address -->
            <div class="row g-3 mb-3">
              <div class="col-12">
                <div class="info-tile">
                  <div class="tile-label"><i class="fa-solid fa-map-pin text-danger"></i> Delivery Address</div>
                  <div class="tile-value fw-normal text-secondary">
                    <?php 
                      $full_addr = trim($address_2 . ', ' . $postal_code . ', ' . $shipping_area . ', ' . $shipping_city . ', ' . $shipping_state, ', ');
                      echo !empty($full_addr) ? $full_addr : 'No delivery address specified.';
                    ?>
                  </div>
                </div>
              </div>
            </div>

            <!-- Order Additional Notes Box (From orders_zee) -->
            <div class="row g-3">
              <div class="col-12">
                <div class="info-tile" style="background: #fffbeb; border-color: #fde68a;">
                  <div class="tile-label text-warning" style="color: #b45309 !important;">
                    <i class="fa-regular fa-note-sticky"></i> Order Additional Notes
                  </div>
                  <div class="tile-value fw-normal text-dark">
                    <?php echo !empty($order_additional_notes) ? $order_additional_notes : '<span class="text-muted">No additional notes provided for this order.</span>'; ?>
                  </div>
                </div>
              </div>
            </div>

            <!-- Online Payment Info Box -->
            <?php if (strtolower($payment_type) === 'online'): ?>
              <div class="payment-box mt-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-3">
                  <i class="fa-solid fa-shield-halved text-primary fs-3"></i>
                  <div>
                    <div class="tile-label mb-0"><i class="fa-regular fa-credit-card me-1"></i> Payment Method</div>
                    <div class="tile-value"><?php echo !empty($payment_method) ? $payment_method : 'Online Payment'; ?></div>
                  </div>
                </div>
                <div>
                  <div class="tile-label mb-0"><i class="fa-solid fa-fingerprint me-1"></i> Transaction ID</div>
                  <div class="tile-value font-monospace text-primary"><?php echo !empty($transaction_id) ? $transaction_id : 'N/A'; ?></div>
                </div>
              </div>
            <?php endif; ?>

            <!-- Action Form -->
            <form action="phpfiles/insertions.php" method="POST" class="mt-4 pt-3 border-top">
              <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
              <div class="row align-items-end g-3">
                <div class="col-md-5 col-8">
                  <label for="orderStatus" class="form-label tile-label mb-1">
                    <i class="fa-solid fa-sliders text-muted me-1"></i> Update Status
                  </label>
                  <select name="Action" id="orderStatus" class="form-select form-control-aligned" required>
                    <option value="">Select status</option>
                    <option value="pending">Accept Order</option>
                    <option value="delivered">Delivered</option>
                    <option value="canceled">Cancel Order</option>
                  </select>
                </div>

                <div class="col-md-3 col-4">
                  <button type="submit" name="btnSubmit_Action" class="btn btn-primary btn-aligned w-100">
                    <i class="fa-solid fa-floppy-disk"></i> Update Order
                  </button>
                </div>
              </div>
            </form>

          </div>
        </div>

        <!-- Ordered Items Table Card -->
        <div class="card-modern">
          <div class="card-header-modern">
            <h5 class="card-title-modern">
              <i class="fa-solid fa-boxes-stacked text-primary"></i> Order Line Items
            </h5>
          </div>

          <div class="p-0">
            <?php
            include_once('connection.php');
            
            $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

            $sql = "SELECT o.id, o.order_total_price, od.additional_notes, od.id AS order_detail_id, od.order_id, od.deal_id, od.deal_item_id,
                           od.product_id, od.qty, od.addons, od.types, od.dressing, od.product_name, 
                           od.price, od.cost, od.is_free,
                           p.description, p.img  
                    FROM `orders_zee` o 
                    INNER JOIN `order_details_zee` od ON od.order_id = o.id 
                    LEFT JOIN `products` p ON p.id = od.product_id 
                    WHERE o.id = $order_id";

            $result = mysqli_query($conn,$sql);

            if (!$result) {
                die("Query Failed: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($result) > 0) {$orders = [];
                $deals = [];$combined_total_price = 0;

                while ($row = mysqli_fetch_assoc($result)) {
                    if (!empty($row['deal_id'])) {
                        $deals[] =$row;
                    } else {
                        $orders[] =$row;
                        $combined_total_price +=$row['price'];
                    }
                }

                // Standard Items Table
                if (count($orders) > 0) {
                    echo "<div class='table-responsive'>
                            <table class='table table-modern'>
                                <thead>
                                    <tr>
                                        <th style='width: 40px;'>#</th>
                                        <th>Item Name</th>
                                        <th>Item Notes</th>
                                        <th style='width: 70px;'>QTY</th>
                                        <th>Cost</th>
                                        <th>Price</th>
                                        <th>Addons</th>
                                        <th>Addons Total</th>
                                        <th>Types</th>
                                        <th>Dressing</th>
                                    </tr>
                                </thead>
                                <tbody>";

                    $index = 1;
                    foreach ($orders as$row) {
                        $addons = json_decode($row['addons'] ?? '[]');
                        $types = json_decode($row['types'] ?? '[]');
                        $dressings = json_decode($row['dressing'] ?? '[]');

                        if (!is_array($addons))$addons = [];
                        
                        $price =$row['price'];
                        if ($row['is_free'])$price = 0;

                        echo "<tr>
                                <td class='text-muted small'>" . $index++ . "</td>
                                <td class='fw-bold text-slate-900'>" . htmlspecialchars($row['product_name'] ?? 'N/A') . "</td>
                                <td class='text-muted small'>" . (!empty($row['additional_notes']) ? htmlspecialchars($row['additional_notes']) : '-') . "</td>
                                <td><span class='qty-chip'>" . htmlspecialchars($row['qty']) . "</span></td>
                                <td>" . formatCurrency($row['cost'] ?? 0) . "</td>
                                <td class='fw-semibold text-slate-900'>" . formatCurrency($price) . "</td>
                                <td>";

                        if (count($addons) > 0) {
                            foreach ($addons as$addon) {
                                echo "<div class='small text-slate-700 mb-1'>" 
                                    . htmlspecialchars($addon->as_name) 
                                    . " <span class='text-muted'>x" . htmlspecialchars($addon->quantity) . "</span> " 
                                    . "<strong>(" . formatCurrency($addon->as_price ?? 0) . ")</strong></div>";
                            }
                        } else {
                            echo "<span class='text-muted'>-</span>";
                        }

                        echo "</td><td>";

                        $total_addon = 0;
                        foreach ($addons as $addon) {$total_addon += ($addon->as_price ?? 0) * ($addon->quantity ?? 1);
                        }
                        
                        echo formatCurrency($total_addon) . "</td><td>";

                        if (is_array($types) && !empty($types)) {
                            foreach ($types as$type) {
                                if (!empty($type->ts_name)) {
                                    echo "<span class='badge-chip'>" . htmlspecialchars($type->ts_name) . "</span>";
                                }
                            }
                        } else {
                            echo "<span class='text-muted'>-</span>";
                        }

                        echo "</td><td>";

                        if (is_array($dressings) && count($dressings) > 0) {
                            foreach ($dressings as$dressing) {
                                echo "<span class='badge-chip'>" . htmlspecialchars($dressing->dressing_name) . "</span>";
                            }
                        } else {
                            echo "<span class='text-muted'>-</span>";
                        }

                        echo "</td></tr>";
                    }

                    echo "</tbody></table></div>";
                }

                // Deals Table
                if (count($deals) > 0) {
                    echo "<div class='px-4 py-2 bg-light border-top border-bottom fw-bold text-slate-800 small text-uppercase' style='letter-spacing: 0.05em;'>Deals Breakdown</div>
                          <div class='table-responsive'>
                            <table class='table table-modern'>
                                <thead>
                                    <tr>
                                        <th style='width: 40px;'>#</th>
                                        <th>Deal Name</th>
                                        <th>Item Notes</th>
                                        <th>Deal Item</th>
                                        <th>Product</th>
                                        <th>Cost</th>
                                        <th>Price</th>
                                        <th>Addons</th>
                                        <th>Addons Total</th>
                                        <th>Types</th>
                                        <th>Dressing</th>
                                    </tr>
                                </thead>
                                <tbody>";

                    $index = 1;
                    foreach ($deals as$row) {
                        $addons = json_decode($row['addons'] ?? '[]');
                        $types = json_decode($row['types'] ?? '[]');
                        $dressings = json_decode($row['dressing'] ?? '[]');

                        $sql_deal_name = "SELECT `deal_name`, `deal_cost`, `deal_price` FROM `deals` WHERE `deal_id` = " . intval($row['deal_id']);$sql_exec_deal_name = mysqli_query($conn,$sql_deal_name);
                        $deal_d = mysqli_fetch_array($sql_exec_deal_name);

                        $sql_deal_item_name = "SELECT `di_title` FROM `deal_items` WHERE `di_id` = " . intval($row['deal_item_id']);$sql_exec_deal_item_name = mysqli_query($conn,$sql_deal_item_name);
                        $deal_item = mysqli_fetch_array($sql_exec_deal_item_name);

                        echo "<tr>
                                <td class='text-muted small'>" . $index++ . "</td>
                                <td class='fw-bold text-slate-900'>" . htmlspecialchars($deal_d['deal_name'] ?? '-') . "</td>
                                <td class='text-muted small'>" . (!empty($row['additional_notes']) ? htmlspecialchars($row['additional_notes']) : '-') . "</td>
                                <td>" . htmlspecialchars($deal_item['di_title'] ?? '-') . "</td>
                                <td>" . htmlspecialchars($row['product_name'] ?? 'N/A') . "</td>
                                <td>" . formatCurrency($row['cost'] ?? $deal_d['deal_cost'] ?? 0) . "</td>
                                <td class='fw-semibold text-slate-900'>" . formatCurrency($row['price'] ?? $deal_d['deal_price'] ?? 0) . "</td>
                                <td>";

                        if (is_array($addons) && !empty($addons)) {
                            foreach ($addons as$addon) {
                                echo "<div class='small text-slate-700 mb-1'>" 
                                    . htmlspecialchars($addon->as_name) 
                                    . " <span class='text-muted'>x" . htmlspecialchars($addon->quantity) . "</span> " 
                                    . "<strong>(" . formatCurrency($addon->as_price ?? $addon->price ?? 0) . ")</strong></div>";
                            }
                        } else {
                            echo "<span class='text-muted'>-</span>";
                        }

                        echo "</td><td>";

                        $val_addon_total = 0;
                        if (is_array($addons)) {
                            foreach ($addons as $addon) {$val_addon_total += ($addon->as_price ?? 0) * ($addon->quantity ?? 1);
                            }
                        }
                        echo formatCurrency($val_addon_total) . "</td><td>";

                        if (is_array($types) && !empty($types)) {
                            foreach ($types as$type) {
                                echo "<span class='badge-chip'>" . htmlspecialchars($type->ts_name ?? '') . "</span>";
                            }
                        } else {
                            echo "<span class='text-muted'>-</span>";
                        }

                        echo "</td><td>";

                        if (is_array($dressings) && !empty($dressings)) {
                            foreach ($dressings as$dressing) {
                                echo "<span class='badge-chip'>" . htmlspecialchars($dressing->dressing_name ?? '') . "</span>";
                            }
                        } else {
                            echo "<span class='text-muted'>-</span>";
                        }

                        echo "</td></tr>";

                        $combined_total_price += ($row['price'] ?? $deal_d['deal_price'] ?? 0);
                    }

                    echo "</tbody></table></div>";
                }

                $final_total = (float)$combined_total_price;
                    
                /* Modern Subtotal Footer Bar */
                echo "<div class='subtotal-bar'>
                        <div class='subtotal-badge'>
                          <i class='fa-solid fa-coins text-success fs-5'></i>
                          <div>
                            <div class='tile-label mb-0'>Subtotal</div>
                            <div class='fs-5 fw-bold text-slate-900'>" . formatCurrency($final_total) . "</div>
                          </div>
                        </div>
                      </div>";

            } else {
                echo "<p class='p-4 text-muted text-center mb-0'>No order line items found.</p>";
            }

            mysqli_close($conn);
            ?>
          </div>
        </div>

        <!-- Modal -->
        <div id="myModal" class="modal">
          <div class="modal-content-Updated2">
            <span onclick="closeModel(1)" class="close">&times;</span>
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-user-gear text-primary me-2"></i> Update Status</h5>
            
            <form method="POST" action="assets/Actions.php" enctype="multipart/form-data">
              <input hidden type="text" name="userID">
              <div class="mb-3">
                <select name="Status" id="Status" class="form-select form-control-aligned">
                  <option value="0">Mark as banned</option>
                  <option value="1">Mark as unbanned</option>
                </select>
              </div>
              <button type="submit" name="BtnUopdateOrderStatus" class="btn btn-primary btn-aligned w-100">
                <i class="fa-solid fa-check"></i> Submit
              </button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>

  <!-- JS Vendors -->
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    var modal = document.getElementById("myModal");
    var modal_Add = document.getElementById("myModal_Add");

    function openModal(id) {
      document.getElementsByName('userID')[0].value = id;
      modal.style.display = "block";
    }

    function openAddMore(id, index) {
      if(modal_Add) modal_Add.style.display = "block";
    }

    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      } else if (modal_Add && event.target == modal_Add) {
        modal_Add.style.display = "none";
      }
    }

    function closeModel(id) {
      if (id == 1) {
        modal.style.display = "none";
      } else if(modal_Add) {
        modal_Add.style.display = "none";
      }
    }
  </script>
</body>
</html>