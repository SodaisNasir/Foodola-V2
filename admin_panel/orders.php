<?php 
include('assets/header.php');
include('phpfiles/function.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>

<?php
if (isset($_GET['Massage'])) {
  if ($_GET['Massage'] == 'Sucessfully updated details.') {
    echo "<script>alert('Sucessfully updated details.')</script>";
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
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
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

    .page-main-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: #0f172a;
      margin: 0;
    }

    .breadcrumb-nav {
      font-size: 0.875rem;
      color: #64748b;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .breadcrumb-nav a {
      color: #7367f0;
      text-decoration: none;
    }

    /* Single Modern Card Layout */
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

    /* Filters Inputs Styling */
    .filter-label {
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: #64748b;
      margin-bottom: 0.35rem;
      display: flex;
      align-items: center;
      gap: 0.3rem;
    }

    .form-control-aligned {
      height: 40px !important;
      border-radius: 8px !important;
      font-size: 0.85rem !important;
      border: 1px solid #cbd5e1 !important;
      background-color: #f8fafc !important;
      color: #0f172a !important;
      cursor: pointer;
    }

    .form-control-aligned:focus {
      background-color: #ffffff !important;
      border-color: #7367f0 !important;
      box-shadow: 0 0 0 3px rgba(115, 103, 240, 0.1) !important;
    }

    .btn-aligned {
      height: 40px !important;
      border-radius: 8px !important;
      font-size: 0.85rem !important;
      font-weight: 600 !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      gap: 0.4rem !important;
      padding: 0 1rem !important;
    }

    /* Table Styling */
    .table-modern {
      width: 100% !important;
      margin-bottom: 0 !important;
      border-collapse: separate !important;
      border-spacing: 0 !important;
    }

    .table-modern thead th {
      font-size: 0.725rem !important;
      text-transform: uppercase !important;
      letter-spacing: 0.05em !important;
      color: #64748b !important;
      background-color: #f8fafc !important;
      border-bottom: 1px solid #e2e8f0 !important;
      font-weight: 700 !important;
      padding: 0.85rem 1rem !important;
      white-space: nowrap !important;
    }

    .table-modern tbody td {
      padding: 0.85rem 1rem !important;
      border-bottom: 1px solid #f1f5f9 !important;
      font-size: 0.875rem !important;
      color: #334155 !important;
      vertical-align: middle !important;
    }

    .table-modern tbody tr:hover {
      background-color: #f8fafc !important;
    }

    /* Badges & Pills */
    .status-pill {
      padding: 0.25em 0.7em;
      font-size: 0.75rem;
      font-weight: 700;
      border-radius: 30px;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      text-transform: capitalize;
    }
    .status-delivered { background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .status-pending { background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .status-cancelled, .status-canceled { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .status-neworder { background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

    .badge-chip {
      background: #f1f5f9;
      color: #475569;
      font-weight: 600;
      padding: 0.25rem 0.55rem;
      border-radius: 6px;
      font-size: 0.75rem;
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
      text-transform: lowercase;
    }

    .badge-guest { background-color: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; }
    .badge-registered { background-color: #f0fdf4; color: #15803d; border: 1px solid #dcfce7; }
  </style>
</head>

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

  <?php include('assets/Site_Bar.php') ?>

  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
      
      <!-- Top Title -->
      <div class="content-header row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
          <div>
            <h2 class="page-main-title">Orders Management</h2>
            <div class="breadcrumb-nav mt-1">
              <a href="dashboard.php">Home</a>
              <span>&raquo;</span>
              <span class="text-slate-600">All Orders</span>
            </div>
          </div>
        </div>
      </div>

      <div class="content-body">
        
        <?php
        include_once('connection.php');

        // Fetch Filter Inputs
        $status_filter       = isset($_GET['status_filter']) ? trim($_GET['status_filter']) : '';
        $user_type_filter    = isset($_GET['user_type_filter']) ? trim($_GET['user_type_filter']) : '';$order_type_filter   = isset($_GET['order_type_filter']) ? trim($_GET['order_type_filter']) : '';
        $payment_type_filter = isset($_GET['payment_type_filter']) ? trim($_GET['payment_type_filter']) : '';$platform_filter     = isset($_GET['platform_filter']) ? trim($_GET['platform_filter']) : '';
        $from_date           = isset($_GET['from_date']) ? trim($_GET['from_date']) : '';$to_date             = isset($_GET['to_date']) ? trim($_GET['to_date']) : '';

        // Build Dynamic SQL Query
        $where_clauses = [];

        if (!empty($status_filter)) {$status_f = mysqli_real_escape_string($conn,$status_filter);
            $where_clauses[] = "orders.status = '$status_f'";
        }

        if (!empty($user_type_filter)) {
            if ($user_type_filter === 'registered') {$where_clauses[] = "(orders.user_id IS NOT NULL AND orders.user_id != '' AND orders.user_id != '0')";
            } elseif ($user_type_filter === 'guest') {$where_clauses[] = "(orders.user_id IS NULL OR orders.user_id = '' OR orders.user_id = '0')";
            }
        }

        if (!empty($order_type_filter)) {$type_f = mysqli_real_escape_string($conn, strtolower($order_type_filter));
            $where_clauses[] = "LOWER(orders.order_type) = '$type_f'";
        }

        if (!empty($payment_type_filter)) {$pay_f = mysqli_real_escape_string($conn,$payment_type_filter);
            $where_clauses[] = "orders.payment_type = '$pay_f'";
        }

        if (!empty($platform_filter)) {$plat_f = mysqli_real_escape_string($conn,$platform_filter);
            $where_clauses[] = "orders.platform = '$plat_f'";
        }

        if (!empty($from_date)) {$from_f = mysqli_real_escape_string($conn,$from_date);
            $where_clauses[] = "DATE(orders.created_at) >= '$from_f'";
        }

        if (!empty($to_date)) {$to_f = mysqli_real_escape_string($conn,$to_date);
            $where_clauses[] = "DATE(orders.created_at) <= '$to_f'";
        }

        $where_sql = "";
        if (count($where_clauses) > 0) {
            $where_sql = "WHERE " . implode(" AND ", $where_clauses);
        }

        $sql = "SELECT orders.id, orders.user_id, orders.user_name, orders.user_email, orders.user_phone, orders.Shipping_address, 
                       orders.status, orders.Shipping_address_2, orders.Shipping_city, orders.Shipping_area, orders.payment_type, 
                       orders.Shipping_state, orders.Shipping_postal_code, orders.order_total_price, orders.Shipping_Cost, 
                       orders.created_at, orders.addtional_notes, orders.branch_id, orders.table_id, orders.order_type, orders.platform
                FROM `orders_zee` AS orders 
                $where_sql 
                ORDER BY orders.id DESC";

        $result = mysqli_query($conn,$sql);
        ?>

        <!-- SINGLE MAIN CARD FOR FILTERS & TABLE -->
        <div class="card-modern">
          
          <div class="card-header-modern">
            <h5 class="card-title-modern">
              <i class="fa-solid fa-list-check text-primary"></i> Orders List & Filters
            </h5>
            
            <?php if (!empty(array_filter([$status_filter, $user_type_filter,$order_type_filter, $payment_type_filter,$platform_filter, $from_date,$to_date]))): ?>
              <a href="orders.php" class="btn btn-sm btn-outline-danger btn-aligned">
                <i class="fa-solid fa-rotate-left"></i> Reset Filters
              </a>
            <?php endif; ?>
          </div>

          <div class="card-body p-4">
            
            <!-- Auto Submit Filter Form -->
            <form method="GET" action="orders.php" id="filterForm" class="mb-4">
              <div class="row g-3">
                
                <!-- Status Filter -->
                <div class="col-md-2 col-6">
                  <label class="filter-label"><i class="fa-solid fa-signal"></i> Status</label>
                  <select name="status_filter" class="form-select form-control-aligned">
                    <option value="">All Statuses</option>
                    <option value="neworder" <?php if ($status_filter == 'neworder') echo 'selected'; ?>>Neworder</option>
                    <option value="pending" <?php if ($status_filter == 'pending') echo 'selected'; ?>>Pending</option>
                    <option value="delivered" <?php if ($status_filter == 'delivered') echo 'selected'; ?>>Delivered</option>
                    <option value="cancelled" <?php if ($status_filter == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                  </select>
                </div>

                <!-- User Type Filter -->
                <div class="col-md-2 col-6">
                  <label class="filter-label"><i class="fa-solid fa-users"></i> User Type</label>
                  <select name="user_type_filter" class="form-select form-control-aligned">
                    <option value="">All Users</option>
                    <option value="registered" <?php if ($user_type_filter == 'registered') echo 'selected'; ?>>Registered</option>
                    <option value="guest" <?php if ($user_type_filter == 'guest') echo 'selected'; ?>>Guest</option>
                  </select>
                </div>

                <!-- Order Type Filter -->
                <div class="col-md-2 col-6">
                  <label class="filter-label"><i class="fa-solid fa-utensils"></i> Order Type</label>
                  <select name="order_type_filter" class="form-select form-control-aligned">
                    <option value="">All Types</option>
                    <option value="delivery" <?php if ($order_type_filter == 'delivery') echo 'selected'; ?>>Delivery</option>
                    <option value="takeaway" <?php if ($order_type_filter == 'takeaway') echo 'selected'; ?>>Takeaway</option>
                    <option value="dine_in" <?php if ($order_type_filter == 'dine_in') echo 'selected'; ?>>Dine In</option>
                    <option value="neworder" <?php if ($order_type_filter == 'neworder') echo 'selected'; ?>>New Order</option>
                  </select>
                </div>

                <!-- Payment Type Filter -->
                <div class="col-md-2 col-6">
                  <label class="filter-label"><i class="fa-regular fa-credit-card"></i> Payment</label>
                  <select name="payment_type_filter" class="form-select form-control-aligned">
                    <option value="">All Payments</option>
                    <option value="cash" <?php if ($payment_type_filter == 'cash') echo 'selected'; ?>>Cash</option>
                    <option value="online" <?php if ($payment_type_filter == 'online') echo 'selected'; ?>>Online</option>
                  </select>
                </div>

                <!-- Platform Filter -->
                <div class="col-md-2 col-6">
                  <label class="filter-label"><i class="fa-solid fa-laptop"></i> Platform</label>
                  <select name="platform_filter" class="form-select form-control-aligned">
                    <option value="">All Platforms</option>
                    <option value="website" <?php if ($platform_filter == 'website') echo 'selected'; ?>>Website</option>
                    <option value="android" <?php if ($platform_filter == 'android') echo 'selected'; ?>>Android</option>
                    <option value="ios" <?php if ($platform_filter == 'ios') echo 'selected'; ?>>iOS</option>
                    <option value="pos" <?php if ($platform_filter == 'pos') echo 'selected'; ?>>POS</option>
                  </select>
                </div>

                <!-- Date Range Filters -->
                <div class="col-md-1 col-6">
                  <label class="filter-label"><i class="fa-regular fa-calendar"></i> From</label>
                  <input type="date" name="from_date" class="form-control form-control-aligned" value="<?php echo htmlspecialchars($from_date); ?>">
                </div>

                <div class="col-md-1 col-6">
                  <label class="filter-label"><i class="fa-regular fa-calendar"></i> To</label>
                  <input type="date" name="to_date" class="form-control form-control-aligned" value="<?php echo htmlspecialchars($to_date); ?>">
                </div>

              </div>
            </form>

            <hr class="my-4" style="border-color: #e2e8f0;">

            <!-- Table Container -->
            <div class="table-responsive">
              <table id="example" class="table table-modern">
                <thead>
                  <tr>
                    <th style="width: 50px;">#</th>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>User Type</th>
                    <th>Platform</th>
                    <th>Order Type</th>
                    <th>Total Price</th>
                    <th>Date & Time</th>
                    <th>Shipping</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th style="text-align: center;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($result && mysqli_num_rows($result) > 0) {$index = 1;
                      while ($row = mysqli_fetch_array($result)) {
                          
                          // Customer Identification & Type Logic
                          $customer_name = 'Guest Customer';$user_type_badge = '<span class="status-pill badge-guest"><i class="fa-regular fa-user"></i> Guest</span>';

                          if (!empty($row['user_id']) && $row['user_id'] != '0') {$user_sql = "SELECT name FROM users WHERE id = '" . intval($row['user_id']) . "'";
                              $user_res = mysqli_query($conn,$user_sql);
                              if ($u_row = mysqli_fetch_array($user_res)) {
                                  $customer_name = htmlspecialchars($u_row['name']);
                              } elseif (!empty($row['user_name'])) {
                                  $customer_name = htmlspecialchars($row['user_name']);
                              }
                              $user_type_badge = '<span class="status-pill badge-registered"><i class="fa-solid fa-user-check"></i> Registered</span>';
                          } else {
                              if (!empty($row['user_name'])) {
                                  $customer_name = htmlspecialchars($row['user_name']);
                              } else if (!empty($row['table_id'])) {
                                  $customer_name = "Table #" . htmlspecialchars($row['table_id']);
                              }
                          }

                          $order_total = is_numeric($row['order_total_price']) ?$row['order_total_price'] : 0;
                          $shipping_total = is_numeric($row['Shipping_Cost']) ?$row['Shipping_Cost'] : 0;

                          // Platform Icons
                          $plat = !empty($row['platform']) ? strtolower(trim($row['platform'])) : 'website';$platIcon = 'fa-globe text-primary';
                          if ($plat === 'android')$platIcon = 'fa-brands fa-android text-success';
                          if ($plat === 'ios')$platIcon = 'fa-brands fa-apple text-dark';
                          if ($plat === 'pos')$platIcon = 'fa-cash-register text-info';

                          // Order Type Badge Logic
                          $orderType = !empty($row['order_type']) ? strtolower(trim($row['order_type'])) : 'neworder';$orderTypeClass = 'status-neworder';
                          if ($orderType === 'delivered')$orderTypeClass = 'status-delivered';
                          if ($orderType === 'pending')$orderTypeClass = 'status-pending';
                          if ($orderType === 'cancelled')$orderTypeClass = 'status-cancelled';

                          // Status Class
                          $statusStr = strtolower(trim($row['status']));$statusClass = 'status-neworder';
                          if ($statusStr === 'delivered')$statusClass = 'status-delivered';
                          if ($statusStr === 'pending')$statusClass = 'status-pending';
                          if ($statusStr === 'cancelled')$statusClass = 'status-cancelled';

                          echo "<tr>";
                          echo "<td class='text-muted small'>{$index}</td>";
                          echo "<td class='fw-bold text-slate-900'>#{$row['id']}</td>";
                          echo "<td class='fw-semibold'>{$customer_name}</td>";
                          echo "<td>{$user_type_badge}</td>";
                          echo "<td><span class='badge-chip'><i class='{$platIcon}'></i> {$plat}</span></td>";
                          echo "<td><span class='status-pill {$orderTypeClass}'>" . htmlspecialchars($row['order_type']) . "</span></td>";
                          echo "<td class='fw-bold text-slate-900'>" . formatCurrency($order_total) . "</td>";
                          echo "<td class='text-muted small' style='white-space: nowrap;'>{$row['created_at']}</td>";
                          echo "<td>" . formatCurrency($shipping_total) . "</td>";
                          echo "<td><span class='badge-chip text-uppercase'>" . htmlspecialchars($row['payment_type']) . "</span></td>";
                          echo "<td><span class='status-pill {$statusClass}'>" . htmlspecialchars($row['status']) . "</span></td>";
                          echo "<td class='text-center'>
                                  <a href='order_details.php?order_id={$row['id']}' class='btn btn-sm btn-primary btn-aligned'>
                                    <i class='fa-regular fa-eye'></i> Details
                                  </a>
                                </td>";
                          echo "</tr>";
                          $index++;
                      }
                  }
                  ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>

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

  <script src="app-assets/js/core/app-menu.min.js"></script>
  <script src="app-assets/js/core/app.min.js"></script>
  <script src="app-assets/js/scripts/components.min.js"></script>
  <script src="app-assets/js/scripts/customizer.min.js"></script>
  <script src="app-assets/js/scripts/footer.min.js"></script>

  <script>
    $(document).ready(function() {
      // Auto-submit form on filter change
      $('#filterForm select, #filterForm input[type="date"]').on('change', function() {
        $('#filterForm').submit();
      });

      // DataTables initialization
      $('#example').DataTable({
        dom: '<"d-flex justify-content-between align-items-center mb-3"lBf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
        buttons: [
          { extend: 'copyHtml5', className: 'btn btn-sm btn-outline-secondary me-1' },
          { extend: 'excelHtml5', className: 'btn btn-sm btn-outline-success me-1' },
          { extend: 'csvHtml5', className: 'btn btn-sm btn-outline-info me-1' },
          { extend: 'pdfHtml5', className: 'btn btn-sm btn-outline-danger' }
        ],
        pageLength: 10,
        order: [[1, 'desc']],
        stateSave: false,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search orders..."
        }
      });
    });
  </script>
</body>
</html>