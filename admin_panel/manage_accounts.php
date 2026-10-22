<?php 
include('assets/header.php');
include('connection.php');

$message = "";

// --- 1. HANDLE CREATE & UPDATE POST REQUESTS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_account') {
        $id = $_POST['id'] ?? '';
        $platform_userid = mysqli_real_escape_string($conn, $_POST['platform_userid']);
        $role_id = mysqli_real_escape_string($conn, $_POST['role_id']);
        $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
        $company_email = mysqli_real_escape_string($conn, $_POST['company_email']);
        $base_url = mysqli_real_escape_string($conn, $_POST['base_url']);
        $channel_1 = mysqli_real_escape_string($conn, $_POST['channel_1']);
        $channel_2 = mysqli_real_escape_string($conn, $_POST['channel_2']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $url = mysqli_real_escape_string($conn, $_POST['url']);
        $logo_url = mysqli_real_escape_string($conn, $_POST['logo_url']);

        if (!empty($id)) {
            $query = "UPDATE accounts SET 
                        platform_userid='$platform_userid', 
                        role_id='$role_id', 
                        company_name='$company_name', 
                        company_email='$company_email', 
                        base_url='$base_url', 
                        channel_1='$channel_1', 
                        channel_2='$channel_2', 
                        address='$address', 
                        phone='$phone', 
                        url='$url', 
                        logo_url='$logo_url' 
                      WHERE id=$id";
            $msg = "Account Updated Successfully";
        } else {
            $password = mysqli_real_escape_string($conn, $_POST['password'] ?? '');
            $query = "INSERT INTO accounts (platform_userid, role_id, company_name, company_email, password, base_url, channel_1, channel_2, address, phone, url, logo_url) 
                      VALUES ('$platform_userid', '$role_id', '$company_name', '$company_email', '$password', '$base_url', '$channel_1', '$channel_2', '$address', '$phone', '$url', '$logo_url')";
            $msg = "Account Added Successfully";
        }

        if (mysqli_query($conn, $query)) {
            header("Location: manage_accounts.php?Massage=" . urlencode($msg));
            exit();
        } else {
            $message = "Database Error: " . mysqli_error($conn);
        }
    }
}

// --- 2. HANDLE DELETE GET REQUEST ---
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $del_query = "DELETE FROM accounts WHERE id = $delete_id";
    if (mysqli_query($conn, $del_query)) {
        header("Location: manage_accounts.php?Massage=" . urlencode("Account Deleted Successfully"));
        exit();
    }
}

if (isset($_GET['Massage'])) {
    $message = $_GET['Massage'];
    echo "<script>alert('" . addslashes($message) . "');</script>";
}
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php include('title.php'); echo $pageTitle ?? 'Manage Accounts'; ?></title>
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600&display=swap" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Theme CSS-->

    <style>
        .table-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #ddd;
        }
        .table thead th {
            background-color: #f8f9fa;
            color: #5e5873;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }
        .table td {
            font-size: 0.85rem;
            vertical-align: middle;
            white-space: nowrap;
        }
        .action-btn {
            width: 30px;
            height: 30px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu-modern semi-dark-layout 12-columns navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="12-columns" data-layout="semi-dark-layout">

    <!-- BEGIN: Main Menu-->
    <?php include('assets/Site_Bar.php') ?>
    <!-- END: Main Menu-->

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            
            <!-- Header Section -->
            <div class="content-header row mb-1">
                <div class="content-header-left col-md-8 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0 font-weight-bold">Manage Accounts</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb bg-transparent p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active">Manage Accounts</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-4 col-12">
                    <button type="button" class="btn btn-primary shadow-sm font-weight-bold" onclick="openAddModal()">
                        <i class="feather icon-plus mr-50"></i> Add New Account
                    </button>
                </div>
            </div>

            <!-- Table Section -->
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title font-weight-bold text-primary">
                                        <i class="feather icon-list mr-50"></i> Manage Accounts
                                    </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-bordered table-hover text-center mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Platform UserID</th>
                                                        <th>Role ID</th>
                                                        <th>Company Name</th>
                                                        <th>Company Email</th>
                                                        <th>Password</th>
                                                        <th>BaseUrl</th>
                                                        <th>Channel 1</th>
                                                        <th>Channel 2</th>
                                                        <th>Address</th>
                                                        <th>Phone</th>
                                                        <th>Url</th>
                                                        <th>Logo Url</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT * FROM accounts ORDER BY id DESC";
                                                    $result = mysqli_query($conn, $query);
                                                    if ($result && mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $jsonRow = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                                                            ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($row['platform_userid']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['role_id']); ?></td>
                                                                <td class="text-left font-weight-bold text-dark"><?php echo htmlspecialchars($row['company_name']); ?></td>
                                                                <td class="text-left text-muted"><?php echo htmlspecialchars($row['company_email']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['password']); ?></td>
                                                                <td class="text-left"><a href="<?php echo htmlspecialchars($row['base_url']); ?>" target="_blank"><?php echo htmlspecialchars($row['base_url']); ?></a></td>
                                                                <td><?php echo htmlspecialchars($row['channel_1']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['channel_2']); ?></td>
                                                                <td class="text-left"><?php echo htmlspecialchars($row['address']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                                                <td class="text-left"><a href="<?php echo htmlspecialchars($row['url']); ?>" target="_blank"><?php echo htmlspecialchars($row['url']); ?></a></td>
                                                                <td>
                                                                    <?php if (!empty($row['logo_url'])): ?>
                                                                        <img src="<?php echo htmlspecialchars($row['logo_url']); ?>" class="table-avatar" onerror="this.src='app-assets/images/portrait/small/avatar-s-1.jpg'">
                                                                    <?php else: ?>
                                                                        <span class="text-muted">N/A</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-center">
                                                                        <button type="button" class="btn btn-sm btn-outline-primary action-btn mr-50" onclick='openEditModal(<?php echo $jsonRow; ?>)' title="Edit">
                                                                            <i class="feather icon-edit-2"></i>
                                                                        </button>
                                                                        <a href="manage_accounts.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger action-btn" onclick="return confirm('Are you sure you want to delete this record?')" title="Delete">
                                                                            <i class="feather icon-trash-2"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php
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
                </section>
            </div>

        </div>
    </div>

    <!-- Simple Bootstrap Modal -->
    <div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="modalTitle">Add New Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="manage_accounts.php" method="POST">
                    <input type="hidden" name="action" value="save_account">
                    <input type="hidden" name="id" id="account_id">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Platform UserID <span class="text-danger">*</span></label>
                                <input type="text" name="platform_userid" id="platform_userid" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Role ID <span class="text-danger">*</span></label>
                                <input type="text" name="role_id" id="role_id" class="form-control" placeholder="e.g. 1" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" id="company_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Company Email <span class="text-danger">*</span></label>
                                <input type="email" name="company_email" id="company_email" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group" id="password_group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="text" name="password" id="password" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Channel 1</label>
                                <input type="text" name="channel_1" id="channel_1" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Channel 2</label>
                                <input type="text" name="channel_2" id="channel_2" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>BaseUrl</label>
                                <input type="text" name="base_url" id="base_url" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Url</label>
                                <input type="text" name="url" id="url" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Logo Url</label>
                                <input type="text" name="logo_url" id="logo_url" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address</label>
                                <input type="text" name="address" id="address" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveButton">Save Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <!-- END: Vendor JS-->

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                scrollX: true,
                dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                language: {
                    search: "",
                    searchPlaceholder: "Search accounts..."
                }
            });
        });

        function openAddModal() {
            $('#modalTitle').text('Add New Account');
            $('#saveButton').text('Save Account');
            $('#account_id').val('');
            $('#platform_userid').val('');
            $('#role_id').val('');
            $('#company_name').val('');
            $('#company_email').val('');
            $('#password').val('');
            $('#password_group').show();
            $('#base_url').val('');
            $('#channel_1').val('');
            $('#channel_2').val('');
            $('#address').val('');
            $('#phone').val('');
            $('#url').val('');
            $('#logo_url').val('');
            $('#accountModal').modal('show');
        }

        function openEditModal(data) {
            $('#modalTitle').text('Edit Account Details');
            $('#saveButton').text('Update Account');
            $('#account_id').val(data.id);
            $('#platform_userid').val(data.platform_userid);
            $('#role_id').val(data.role_id);
            $('#company_name').val(data.company_name);
            $('#company_email').val(data.company_email);
            $('#password').val('');
            $('#password_group').hide();
            $('#base_url').val(data.base_url);
            $('#channel_1').val(data.channel_1);
            $('#channel_2').val(data.channel_2);
            $('#address').val(data.address);
            $('#phone').val(data.phone);
            $('#url').val(data.url);
            $('#logo_url').val(data.logo_url);
            $('#accountModal').modal('show');
        }

        function closeModal() {
            $('#accountModal').modal('hide');
        }
    </script>
</body>
</html>