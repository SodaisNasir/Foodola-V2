<?php
define('BASE_DIRECTORY', __DIR__ . '/../../API/');

require BASE_DIRECTORY . 'PHPMailer-master/src/PHPMailer.php';
require BASE_DIRECTORY . 'PHPMailer-master/src/SMTP.php';
require BASE_DIRECTORY . 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if(isset($_POST['btn_delete_depart'])){
    include('../assets/connection.php');
    $id = $_POST['dpt_id'];
    $sql = "DELETE FROM `departments` WHERE `id` = '$id'";
    $result = mysqli_query($con, $sql);
    
    if($result){
        header("Location:../manage_departments.php?Massage=Sucessfully Deleted");
    }else{
        echo "<script>alert('Sorry, there was an error uploading your file.');window.location.href='../manage_departments.php'</script>";
    }

}

if (isset($_POST['btn_update_depart'])) {

    include('../assets/connection.php');

    $dpt_id =  $_POST['dpt_id'];

    $subcategory_ids = [];
    $department_name = mysqli_real_escape_string($con, $_POST['department_name']);

    $subcategory_ids = array_map('intval', $_POST['sub_category_ids']);
    $encoded_ids = json_encode($subcategory_ids);
    $status = mysqli_real_escape_string($con, $_POST['status']);
  

    $sql = "UPDATE `departments` SET `department_name`='$department_name', `sub_category_ids` = '$encoded_ids', `status` ='$status'   WHERE `id`='$dpt_id'";
    $result = mysqli_query($con, $sql);

    if ($result) {
     echo "<script>alert('Updated successfully');window.location.href='../manage_departments.php'</script>";
    } else {
        echo "<script>alert('Error updating table: " . mysqli_error($con) . "');window.location.href='../manage_departments.php'</script>";
    }
}

if (isset($_POST['btn_insert_depart'])) {
//     error_reporting(E_ALL);
// ini_set('display_errors', 1);
  include('../assets/connection.php');
  $department_name = $_POST['department_name'];
  $subcategory_ids = $_POST['sub_category_ids'];
  $decoded_ids =  json_encode($subcategory_ids);

    $sql = "INSERT INTO `departments`(`department_name`, `sub_category_ids`,`status`, `created_at`) VALUES ('$department_name', '$decoded_ids', 'active', NOW())";
    
      $result = mysqli_query($con, $sql);
      if ($result) {
          
        header("Location:../manage_departments.php?Massage=Sucessfully Inserted");
      }else {
        echo "<script>alert('Sorry, there was an error uploading your file.');window.location.href='../manage_departments.php'</script>";
      }
}


if (isset($_POST['btn_delete_holiday'])) {
    include('../assets/connection.php'); // Include DB connection

    $id = intval($_POST['id']);
    $query = "DELETE FROM holiday_timings WHERE id = $id";

    if (mysqli_query($con, $query)) {
        echo json_encode(['status' => true]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Query failed']);
    }
}


if (isset($_POST['btnSubmitHolidays'])) {
    
    include('../assets/connection.php');
    foreach ($_POST['holiday_dates'] as $holiday) {
        $date = mysqli_real_escape_string($con, $holiday['date']);
        $start1 = mysqli_real_escape_string($con, $holiday['start1']);
        $end1   = mysqli_real_escape_string($con, $holiday['end1']);
        $start2 = mysqli_real_escape_string($con, $holiday['start2']);
        $end2   = mysqli_real_escape_string($con, $holiday['end2']);

        // Optional: check if already exists
        $check = mysqli_query($con, "SELECT * FROM holiday_timings WHERE date = '$date'");
        if (mysqli_num_rows($check) > 0) {
            // update
            $query = "UPDATE holiday_timings SET start_time_1='$start1', end_time_1='$end1', start_time_2='$start2', end_time_2='$end2' WHERE date='$date'";
        } else {
            // insert
            $query = "INSERT INTO holiday_timings (date, start_time_1, end_time_1, start_time_2, end_time_2) 
                      VALUES ('$date', '$start1', '$end1', '$start2', '$end2')";
        }

        mysqli_query($con, $query);
    }

         header("Location:../managetimings.php?Massage=Sucessfully updated timings."); 
    exit;
}


if(isset($_POST['btnSubmit_imprint'])){
    $imprint = $_POST['imprint'];
    $id = $_POST['id'];

       include('../assets/connection.php');

             $sqladd = "UPDATE `imprint` SET `imprint`='$imprint' WHERE `id` = '$id'";
             $add = mysqli_query($con,$sqladd);
             if($add){
                 header("Location:../imprint.php?Massage=Sucessfully Updated"); 
           
            
        }
        

    
}
if (isset($_POST['btn_update_user'])) {

    include('../assets/connection.php'); // Make sure this defines $con

    // Get data from form
    $user_id    = $_POST['user_id'];
    $full_name  = $_POST['full_name'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $password   = $_POST['password'];

    // Optional: sanitize inputs (recommended for security)
    $user_id    = mysqli_real_escape_string($con, $user_id);
    $full_name  = mysqli_real_escape_string($con, $full_name);
    $email      = mysqli_real_escape_string($con, $email);
    $phone      = mysqli_real_escape_string($con, $phone);
    $password   = mysqli_real_escape_string($con, $password);
      $status     = mysqli_real_escape_string($con, $_POST['status']); // new


    // Prepare the query
    $update_query = "
        UPDATE `users` 
        SET 
            `name` = '$full_name',
            `phone` = '$phone',
            `email` = '$email',
            `password` = '$password',
            `status` = '$status',
            `updated_at` = NOW()
        WHERE `id` = '$user_id'
    ";
    
    
    $update_result = mysqli_query($con, $update_query);

 if ($update_result) {
    echo "<script>alert('User updated successfully'); window.location.href='../manageusers.php';</script>";
} else {
    echo "<script>alert('Error updating user: " . mysqli_error($con) . "'); window.location.href='../manageusers.php';</script>";
}

}




if (isset($_POST['btn_insert_user'])) {

    include('../assets/connection.php');

    $full_name    = $_POST['full_name'];
    $email        = $_POST['email'];
    $phone        = $_POST['phone'];
    $country_code = $_POST['country_code'];
    $password     = $_POST['password'];
    $role_id      = 3;
    $status       = 'active';
    $full_phone   = $country_code . $phone;



    $check_query = "SELECT `id` FROM `users` WHERE `email` = '$email'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('User already exists');window.location.href='../manageusers.php'</script>";
    } else {
        $insert_query = "INSERT INTO `users` (`name`, `phone`, `country_code`, `email`, `password`, `role_id`, `status`, `created_at`, `updated_at`) 
        VALUES ('$full_name', '$full_phone', '$country_code', '$email', '$password', '$role_id', '$status', NOW(), NOW())";

        $insert_result = mysqli_query($con, $insert_query);

        if ($insert_result) {
            echo "<script>alert('User inserted successfully');window.location.href='../manageusers.php'</script>";
        } else {
            echo "<script>alert('Error inserting user: " . mysqli_error($con) . "');window.location.href='../manageusers.php'</script>";
        }
    }
}


if (isset($_POST['btn_Update_slider'])) {
    include('../assets/connection.php');
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $alt_name = mysqli_real_escape_string($con, $_POST['alt_name']);
    $MainCat = mysqli_real_escape_string($con, $_POST['MainCat']);
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);

 
    $sql = "UPDATE `sliders` SET `alt_name`='$alt_name',`type`='$MainCat',`product_id`='$product_id' WHERE  `id` = '$id'";
    $result = mysqli_query($con, $sql);

    if ($result) {
     echo "<script>alert('Updated successfully');window.location.href='../manageSliders.php'</script>";
    } else {
        echo "<script>alert('Error updating slider: " . mysqli_error($con) . "');window.location.href='../manageSliders.php'</script>";
    }
}


if(isset($_POST['btn_insert_code'])){

    include('../assets/connection.php');
    
    $code  = mysqli_real_escape_string($con, $_POST['code']);
    $value = mysqli_real_escape_string($con, $_POST['value']);
    $usage_limit = mysqli_real_escape_string($con, $_POST['usage_limit']);
    // $used_count = mysqli_real_escape_string($con, $_POST['used_count']);
    $start_date = mysqli_real_escape_string($con, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($con, $_POST['end_date']);
    $status = mysqli_real_escape_string($con, $_POST['status']); 
    $eligible_users_date = mysqli_real_escape_string($con, $_POST['eligible_users_date']);
    $min_order = mysqli_real_escape_string($con, $_POST['min_order']);
    $start_date_order = mysqli_real_escape_string($con, $_POST['start_date_order']); 
    $end_date_order = mysqli_real_escape_string($con, $_POST['end_date_order']); 
    
    
 $insert_sql = "INSERT INTO `promo_codes`(`code`, `value`, `usage_limit`, `used_count`, `min_order`, `start_date`, `end_date`,`eligible_users_date`,`start_date_order`, `end_date_order`, `status`) 
                   VALUES ('$code','$value','$usage_limit',0,'$min_order','$start_date','$end_date','$eligible_users_date','$start_date_order', '$end_date_order', '$status')";

    
    $execute = mysqli_query($con, $insert_sql);
    if($execute){
             echo "<script>alert('Promo Code added successfully');window.location.href='../manage_promocode.php'</script>";
    }else{
         echo "<script>alert('Error inserting codes: " . mysqli_error($con) . "');window.location.href='../manage_promocode.php'</script>";
    }
}



if (isset($_POST['btn_update_code'])) {
    include('../assets/connection.php');
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $code = mysqli_real_escape_string($con, $_POST['code']);
    $value = mysqli_real_escape_string($con, $_POST['value']);
    $usage_limit = mysqli_real_escape_string($con, $_POST['usage_limit']);
    $used_count = mysqli_real_escape_string($con, $_POST['used_count']);
    $min_order = mysqli_real_escape_string($con, $_POST['min_order']);
    $start_date = mysqli_real_escape_string($con, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($con, $_POST['end_date']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $eligible_users_date = mysqli_real_escape_string($con, $_POST['eligible_users_date']);
    $start_date_order = mysqli_real_escape_string($con, $_POST['start_date_order']); 
    $end_date_order = mysqli_real_escape_string($con, $_POST['end_date_order']); 
 
    $sql = "UPDATE `promo_codes` SET `code`='$code',`value`='$value',`usage_limit`='$usage_limit',`used_count`='$used_count',`min_order`='$min_order',`start_date`='$start_date',`end_date`='$end_date',`status`='$status', `eligible_users_date` = '$eligible_users_date', `start_date_order`= '$start_date_order', `end_date_order`='$end_date_order' WHERE  `id` = '$id'";
    $result = mysqli_query($con, $sql);

    if ($result) {
     echo "<script>alert('Updated successfully');window.location.href='../manage_promocode.php'</script>";
    } else {
        echo "<script>alert('Error updating codes: " . mysqli_error($con) . "');window.location.href='../manage_promocode.php'</script>";
    }
}


// for the delete of table
if(isset($_POST['btn_delete_code'])){
    include('../assets/connection.php');
    $id = $_POST['id'];
    $sql = "DELETE FROM `promo_codes` WHERE `id` = '$id'";
    $result = mysqli_query($con, $sql);
    if($result){
        header("Location:../manage_promocode.php?Massage=Sucessfully Deleted");
    }
}




if (isset($_POST['btn_setcashback'])) {
     include('../assets/connection.php');
    $cashback = floatval($_POST['cashback_percenatge']); 
    $cashback_status = isset($_POST['status']) ? 1 : 0;
                                    
    $update_sql = "UPDATE cash_back SET cashback_percenatge = '$cashback', status = '$cashback_status'";
    if (mysqli_query($con, $update_sql)) {
        echo "<script>alert('cashback Updated successfully'); window.location.href='../manage_cashback.php';</script>";
        }
}



if (isset($_POST['ProID'])) {
    include('../assets/connection.php');

    $ProdID = intval($_POST['ProID']); // Use intval for better security
    $target_dir = "../Uploads/";
    $originalFileName = basename($_FILES["updatedImage"]["name"]);
    $imageFileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

    // Validate file size
    if ($_FILES["updatedImage"]["size"] > 500000000) {
        echo json_encode(['success' => false, 'message' => 'Sorry, your file is too large.']);
        exit;
    }

    // Allowed file types
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo json_encode(['success' => false, 'message' => 'Only JPG, JPEG, PNG & GIF files are allowed.']);
        exit;
    }

    // Escape $ProdID for use in the SQL query
    $ProdID = mysqli_real_escape_string($con, $ProdID);

    // Get product name and current image
    $get_file_name = "SELECT name, img FROM products WHERE id = '$ProdID'";
    $result = mysqli_query($con, $get_file_name);

    if (mysqli_num_rows($result) > 0) {
        $Data = mysqli_fetch_assoc($result);
        $productName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $Data['name']); // Sanitize product name
        $uniqueID = uniqid(); // Generate a unique ID
        $image_name = $productName . "_" . $ProdID . "_" . $uniqueID . "." . $imageFileType;

        // If a previous image exists, remove it
        if (!empty($Data['img'])) {
            $existingImagePath = $target_dir . $Data['img'];
            if (file_exists($existingImagePath)) {
                if (!unlink($existingImagePath)) {
                    echo json_encode(['success' => false, 'message' => 'Failed to delete old image.']);
                    exit;
                }
            }
        }

        // Attempt to move uploaded file
        if (move_uploaded_file($_FILES["updatedImage"]["tmp_name"], $target_dir . $image_name)) {
            // Update the database with the new image name
            $update = "UPDATE products SET img = '$image_name' WHERE id = '$ProdID'";
            if (mysqli_query($con, $update)) {
                echo json_encode(['success' => true, 'productId' => $ProdID, 'newImageName' => $image_name]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database update failed.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error uploading the file.']);
        }

    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found.']);
    }
}





if (isset($_POST['btn_update_table'])) {

    include('../assets/connection.php');

    $tbl_id = mysqli_real_escape_string($con, $_POST['tbl_id']);
    $tbl_name = mysqli_real_escape_string($con, $_POST['table_name']);
    $tbl_seats = mysqli_real_escape_string($con, $_POST['seats']);
    $tbl_status = mysqli_real_escape_string($con, $_POST['status']);
    $tbl_min = mysqli_real_escape_string($con, $_POST['min']);
    $tbl_maximum = mysqli_real_escape_string($con, $_POST['maximum']);



//  $slotsData = [];
//     if (!empty($_POST['slots']['date'])) {
//         foreach ($_POST['slots']['date'] as $index => $date) {
//             if (!empty($date) && !empty($_POST['slots']['start'][$index]) && !empty($_POST['slots']['end'][$index])) {
//                 $slotsData[] = [
//                     "date"  => $date,
//                     "start" => $_POST['slots']['start'][$index],
//                     "end"   => $_POST['slots']['end'][$index]
//                 ];
//             }
//         }
//     }
//     $time_slots_json = mysqli_real_escape_string($con, json_encode($slotsData));
    
    
    $tbl_img = '';
    $target_dir = "../Uploads/";
    $uploadOk = 1;

    // Check if an image is uploaded
    if (!empty($_FILES["table_image"]["name"])) {
        $target_file = $target_dir . basename($_FILES["table_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file size
        if ($_FILES["table_image"]["size"] > 50000000) {
            echo "<script>alert('Sorry, your file is too large.');window.location.href='../manage_tables.php'</script>";
            $uploadOk = 0;
        }

        // Validate file type
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG, GIF, and WEBP files are allowed.');window.location.href='../manage_tables.php'</script>";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            $filewithnewname = date("YmdHis") . "_Table." . $imageFileType;
            if (move_uploaded_file($_FILES["table_image"]["tmp_name"], $target_dir . $filewithnewname)) {
                $tbl_img = $filewithnewname;
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');window.location.href='../manage_tables.php'</script>";
            }
        }
    }

    // Build SQL query dynamically
    if (!empty($tbl_img)) {
        // Update with table_image if a new image is uploaded
        $sql = "UPDATE `tables` SET `table_name`='$tbl_name', `seats`='$tbl_seats', `status`='$tbl_status', `min` = '$tbl_min', `maximum` = '$tbl_maximum', `table_image`='$tbl_img' WHERE `id`='$tbl_id'";
    } else {
        // Update without modifying table_image if no image is uploaded
        $sql = "UPDATE `tables` SET `table_name`='$tbl_name', `seats`='$tbl_seats', `min` = '$tbl_min', `maximum` = '$tbl_maximum', `status`='$tbl_status' WHERE `id`='$tbl_id'";
    }

    // Execute query
    $result = mysqli_query($con, $sql);

    if ($result) {
     echo "<script>alert('Updated successfully');window.location.href='../manage_tables.php'</script>";
    } else {
        echo "<script>alert('Error updating table: " . mysqli_error($con) . "');window.location.href='../manage_tables.php'</script>";
    }
}


// for the delete of table
if(isset($_POST['btn_delete_tbl'])){
    include('../assets/connection.php');
    $id = $_POST['table_id'];
    $sql = "DELETE FROM `tables` WHERE `id` = '$id'";
    $result = mysqli_query($con, $sql);
    if($result){
        header("Location:../manage_tables.php?Massage=Sucessfully Deleted");
    }else{
        echo "<script>alert('Sorry, there was an error uploading your file.');window.location.href='../manage_tables.php'</script>";
    }

}

// for the insertion of new table 

if (isset($_POST['btn_insert_table'])) {
//     error_reporting(E_ALL);
// ini_set('display_errors', 1);
  include('../assets/connection.php');
session_start();
  $table_name = $_POST['table_name'];
  $table_seats = $_POST['seats'];
  $table_image = $_POST['table_image'];
  $min = $_POST['min'];
  $maximum = $_POST['maximum'];
  $branch_id = $_SESSION['branch_id'];



//  $slotsData = [];
//     if (!empty($_POST['slots']['date'])) {
//         foreach ($_POST['slots']['date'] as $index => $date) {
//             if (!empty($date) && !empty($_POST['slots']['start'][$index]) && !empty($_POST['slots']['end'][$index])) {
//                 $slotsData[] = [
//                     "date"  => $date,
//                     "start" => $_POST['slots']['start'][$index],
//                     "end"   => $_POST['slots']['end'][$index]
//                 ];
//             }
//         }
//     }
//     $time_slots_json = mysqli_real_escape_string($con, json_encode($slotsData));

  $target_dir = "../Uploads/";
  $target_file = $target_dir . basename($_FILES["table_image"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  if ($_FILES["table_image"]["size"] > 8000000) {
    echo "<script>alert('Sorry, your file is too large.');window.location.href='../manage_tables.php'</script>";
    $uploadOk = 0;
  }
  if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
  ) {

    echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');window.location.href='../manage_tables.php'</script>";
    $uploadOk = 0;
  }

  if ($uploadOk == 0) {
    echo "<script>alert('Sorry, your file was not uploaded.');window.location.href='../manage_tables.php'</script>";
  } else {
    $filewithnewname =  date("Ymdis") . "_Table." . $imageFileType;
    if (move_uploaded_file($_FILES["table_image"]["tmp_name"], $target_dir . $filewithnewname)) {
      $table_image = $filewithnewname;
    } else {
      echo "<script>alert('Sorry, there was an error uploading your file.');window.location.href='../manage_tables.php'</script>";
    }
  }
$sql = "INSERT INTO `tables`(`table_name`, `seats`, `table_image`, `branch_id`,`status`,`min`, `maximum`, `created_at`, `updated_at`) 
        VALUES ('$table_name', '$table_seats', '$table_image', '$branch_id', 'available', '$min', '$maximum', NOW(), NOW())";

  $result = mysqli_query($con, $sql);
  if ($result) {

  header("Location:../manage_tables.php?Massage=Sucessfully Inserted");
  } else {
    echo "<script>alert('Sorry, there was an error uploading your file.');window.location.href='../manage_tables.php'</script>";
  }
}


// for the insertion of Sub Categories
if (isset($_POST['btnSubmit_insertCategories'])) {
  include('../assets/connection.php');
//   include('../assets/config.php');
        error_reporting(E_ALL);
ini_set('display_errors', 1);
  $cat_name = $_POST['CatName'];
  $target_dir = "../Uploads/";
  $target_file = $target_dir . basename($_FILES["CatImage"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  if ($_FILES["CatImage"]["size"] > 8000000) {
    echo "<script>alert('Sorry, your file is too large.');window.location.href='../addmaincat.php'</script>";
    $uploadOk = 0;
  }

  if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
  ) {

    echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');window.location.href='../addmaincat.php'</script>";
    $uploadOk = 0;
  }

  if ($uploadOk == 0) {
    echo "<script>alert('Sorry, your file was not uploaded.');window.location.href='../addmaincat.php'</script>";
  } else {
    $filewithnewname =  date("Ymdis") . "_Main_Cat." . $imageFileType;
    if (move_uploaded_file($_FILES["CatImage"]["tmp_name"], $target_dir . $filewithnewname)) {
      // echo "The file ". htmlspecialchars( basename( $_FILES["CatImage"]["name"])). " has been uploaded.";
      
      $cat_name = mysqli_real_escape_string($con, $cat_name);
$filewithnewname = mysqli_real_escape_string($con, $filewithnewname);

      $sql = "INSERT INTO `categories`(`name`, `img`) VALUES ('$cat_name','$filewithnewname')";
      $result = mysqli_query($con, $sql);


      if ($result) {
        $monitor_sql = "INSERT INTO `website_requests` (`website_name`, `status`, `created_at`, `updated_at`) 
                            VALUES ('haveliresturant', '1' ,NOW(),NOW())";
        $monitor_update = mysqli_query($con, $monitor_sql);

        if ($monitor_update) {
          header("Location:../viewcategories.php?Massage=Sucessfully added new category.");
        } else {
          die("Error updating monitoring database: " . mysqli_error($monitor_con));
        }
      }else{
        echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
      }
    } else {

      echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
    }
  }
 
}
  
if(isset($_POST['updateAddonTitle'])){
      include('../assets/connection.php');

     $ao_id = $_POST['ao_id'];
    
    $ao_title = mysqli_real_escape_string($con,$_POST['ao_title']);
   
    echo $sql = "UPDATE `addon_list` SET `ao_title`= '$ao_title' WHERE `ao_id` = $ao_id";
    $update = mysqli_query($con,$sql);
    if($update){
         header("Location:../view_addons.php?&Massage=Sucessfully updated Addons.");
    }
}





if (isset($_POST['btnUpdateImage'])) {
    include('../assets/connection.php');

    $CatID = $_POST['CatID'];
    $target_dir = "../Uploads/";

    $imageFileType = strtolower(pathinfo($_FILES["updatedImage"]["name"], PATHINFO_EXTENSION));
    $newFileName = uniqid("cat_") . "." . $imageFileType;
    $target_file = $target_dir . $newFileName;
    $uploadOk = 1;

    // Validate file size
    if ($_FILES["updatedImage"]["size"] > 500000) {
        echo "<script>alert('Sorry, your file is too large.')</script>";
        $uploadOk = 0;
    }

    // Validate file type
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.')</script>";
    } else {
        $get_file_name = "SELECT `img` FROM `categories` WHERE `id` = $CatID";
        $ex_file_name = mysqli_query($con, $get_file_name);

        if (mysqli_num_rows($ex_file_name) > 0) {
            $Data = mysqli_fetch_array($ex_file_name);
            if (move_uploaded_file($_FILES["updatedImage"]["tmp_name"], $target_file)) {
            
                $update_sql = "UPDATE `categories` SET `img`='$newFileName' WHERE `id` = '$CatID'";
                $exec_update_sql = mysqli_query($con, $update_sql);

                if ($exec_update_sql) {
                                 header("Location: ../viewcategories.php?Massage=Category Updated Successfully");
                } else {
                    echo "<script>alert('Failed to update database.')</script>";
                }

            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
            }
        } else {
            echo "<script>alert('Category not found.')</script>";
        }
    }
}



// if(isset($_POST['btnUpdateProdImage'])){
// include('../assets/connection.php');
//     include('../assets/config.php'); 
 
//   $ProdID = $_POST['ProID'];
//   $target_dir = "../Uploads/";
//   $target_file = $target_dir . basename($_FILES["updatedImage"]["name"]);
//   $uploadOk = 1;
//   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
//   if ($_FILES["updatedImage"]["size"] > 500000) {
//   echo "<script>alert('Sorry, your file is too large.')</script>";
//     $uploadOk = 0;
//   }
  
//   if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"  && $imageFileType != "webp") {
      
//       echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');window.location.href='../manageproducts.php'</script>";
//       $uploadOk = 0;
//     }
    
//   if ($uploadOk == 0) {
//       echo "<script>alert('Sorry, your file was not uploaded.');window.location.href='../manageproducts.php'</script>";
//     } else {
//       $get_file_name = "SELECT  `img` , `name`, `id`  FROM `products` WHERE `id` = $ProdID";
//       $ex_file_name = mysqli_query($con,$get_file_name);
//       if(mysqli_num_rows($ex_file_name)>0){
//           $Data = mysqli_fetch_array($ex_file_name);
//         //   $image_name = $Data['img'];
//           $image_name = $Data['name']."_".$Data['id'].".".$imageFileType;
//           if (move_uploaded_file($_FILES["updatedImage"]["tmp_name"], $target_dir.$image_name)) {
//               $update = "UPDATE `products` SET `img` = '$image_name' WHERE `id` = $ProdID";
//               $update_ex = mysqli_query($con,$update);
//               echo "The file ". htmlspecialchars( basename( $_FILES["updatedImage"]["name"])). " has been updated.";
               
//                 if($update){
//                      $monitor_sql = "INSERT INTO `website_requests` (`website_name`, `status`, `created_at`, `updated_at`) 
//                                     VALUES ('burgerpoint', '1' ,NOW(),NOW())";
//                     $monitor_update = mysqli_query($conn, $monitor_sql);
            
//                     if ($monitor_update) {
//                         header("Location:../manageproducts.php?&Massage=Sucessfully updated product.");
//                     } else {
//                         die("Error updating monitoring database: " . mysqli_error($monitor_con));
//                     }
                    
//                 }
   
            
//           } else {
           
//             echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
//           }
//       }
      
//   }
   
// }



// if(isset($_POST['btnUpdateSubCatImage'])){
// include('../assets/connection.php');
//   session_start();
//   $CatID = $_POST['CatID'];
//   $target_dir = "../Uploads/";
//   $target_file = $target_dir . basename($_FILES["updatedImage"]["name"]);
//   $uploadOk = 1;
//   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
//   if ($_FILES["updatedImage"]["size"] > 500000) {
//   echo "<script>alert('Sorry, your file is too large.')</script>";
//     $uploadOk = 0;
//   }
  
//   if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
//     && $imageFileType != "gif" ) {
      
//       echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
//       $uploadOk = 0;
//     }
    
//   if ($uploadOk == 0) {
//       echo "<script>alert('Sorry, your file was not uploaded.')</script>";
//     } else {
//       $get_file_name = "SELECT  `img`  FROM `sub_categories` WHERE `id` = $CatID";
//       $ex_file_name = mysqli_query($con,$get_file_name);
//       if(mysqli_num_rows($ex_file_name)>0){
//           $Data = mysqli_fetch_array($ex_file_name);
//           $image_name = $Data['img'];
//           if (move_uploaded_file($_FILES["updatedImage"]["tmp_name"], $target_dir.$image_name)) {
//             echo "The file ". htmlspecialchars( basename( $_FILES["CatImage"]["name"])). " has been updated.";
           
//               header("Location:../SubCat.php?Massage=Sucessfully updated sub category.");
            
//           } else {
           
//             echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
//           }
//       }
      
//   }
   
// }


if (isset($_POST['btnUpdateSubCatImage'])) {
    include('../assets/connection.php');
    session_start();

    $CatID = $_POST['CatID'];
    $target_dir = "../Uploads/";
    $timestamp = date("YmdHis"); // Format: 202502282924 (YearMonthDayHourMinuteSecond)
    $imageFileType = strtolower(pathinfo($_FILES["updatedImage"]["name"], PATHINFO_EXTENSION));

    // Validate file size
    if ($_FILES["updatedImage"]["size"] > 5000000) {
        echo "<script>alert('Sorry, your file is too large.')</script>";

    }

    // Allow only specific file types
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
    }

    // Generate the new file name: 202502282924_Sub_Cat.jpg
    $new_image_name = $timestamp . "_Sub_Cat." . $imageFileType;
    $target_file = $target_dir . $new_image_name;

    // Fetch existing image name
    $get_file_name = "SELECT `img` FROM `sub_categories` WHERE `id` = $CatID";
    $ex_file_name = mysqli_query($con, $get_file_name);


        if (move_uploaded_file($_FILES["updatedImage"]["tmp_name"], $target_file)) {
            $update_query = "UPDATE `sub_categories` SET `img` = '$new_image_name' WHERE `id` = $CatID";
            if (mysqli_query($con, $update_query)) {
                header("Location: ../SubCat.php?Message=Successfully updated sub category.");
            } else {
                echo "<script>alert('Database update failed.')</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
        }
   
}



if(isset($_POST['BtnSendpush']))
{
    include('../assets/connection.php');
    $v = $_POST['checkbox'];
    $user_idxx =$_POST['user_id'];
    $purpose = $_POST['purpose'];
    $cont = mysqli_real_escape_string($con, $_POST['content']);
    $playerId = [];
    $subject = '';
    
    foreach($v as $i)
    {
        $user_id = $i;
        
        $insert = "INSERT INTO `notification`(`user_id`, `content`, `purpose`) VALUES ($user_id,'$cont','$purpose')";
         mysqli_query($con,$insert);
        
        $sql_get_token = "SELECT `name`, `notification_token` FROM `users` WHERE `id`=$user_id";
        $ex = mysqli_query($con,$sql_get_token);
        $Data = mysqli_fetch_array($ex);
         $Data['notification_token'];
        array_push($playerId, $Data['notification_token']);   
    }
      $content = array
      (
                    "en" => $cont
                    );
                    

                $fields = array(
                    'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                     'include_player_ids' => $playerId,
                    'data' => array("foo" => "NewMassage","Id" => 1),
                    'large_icon' =>"ic_launcher_round.png",
                    'contents' => $content
                );

                $fields = json_encode($fields);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                              'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebnd7ohwrgq5huhen2yfaytan73n45db4ovkcrwwdr2g4xsmwa3flzui3ih3pk65hgjfsjxo2vwnnagwy'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

                $response = curl_exec($ch);
                curl_close($ch);
                header("Location:../SendNotifications.php?Massage=Sucessfully sent notification.");
    
}



if(isset($_POST['BtnOrderPlaced'])){
    include('../assets/connection.php');
    $v = $_POST['checkbox'];
    $product_idxx =$_POST['product_id'];
    $amount_recieved = $_POST['amount_recieved'];
    $amount_return = $_POST['amount_return'];
    $payment_type = $_POST['payment_type'];

    $insert = "INSERT INTO `order_by_admin`(`product_id`, `amount_recieved`, `amount_return`,`payment_type`) VALUES ('$v','$amount_recieved','$amount_return','$payment_type')";
    mysqli_query($con,$insert);

}


if(isset($_POST['btnSubmit_placeorder'])){
    include('../assets/connection.php');
    $user_id = $_POST['user_id'];
    $total_amount =$_POST['total_amount'];
    $amount_recieved = $_POST['amount_recieved'];
    $amount_return = $_POST['amount_return'];
    $payment_type = $_POST['payment_type'];
    
    $new_user = $_POST['new_user'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    
    if($new_user == 1){
        
        $insert_user = "INSERT INTO `users`(`role_id`, `name`, `phone`, `email`, `password`) VALUES (3,'$name','$phone','$email','$password')";
        $execute_inser_user = mysqli_query($con,$insert_user);
        
         $last_id = $con->insert_id;
        
        if($execute_inser_user){
            
            $insert = "INSERT INTO `orders`(`user_id`, `status`, `order_total_price`, `payment_type`,`amount_recieved`,`amount_return`) VALUES ($last_id,'neworder',$total_amount,'$payment_type','$amount_recieved','$amount_return')";
            $result = mysqli_query($con,$insert);
            
            
        
        }
    }else{
        
        $insert_order = "INSERT INTO `orders`(`user_id`, `status`, `order_total_price`, `payment_type`,`amount_recieved`,`amount_return`) VALUES ($user_id,'neworder',$total_amount,'$payment_type','$amount_recieved','$amount_return')";
        $resultx = mysqli_query($con,$insert_order);
        
        
    }
    
    
    header("Location:../pos_reciept.php?Massage=Sucessfully added new order.");

    
    
}



// if(isset($_POST['btnSubmit_insertSubCategories'])){
// include('../assets/connection.php');
//   session_start();
//   $cat_name = $_POST['CatName'];
//   $main_cat = $_POST['MainCat'];
//   $target_dir = "../Uploads/";
//   $target_file = $target_dir . basename($_FILES["CatImage"]["name"]);
//   $uploadOk = 1;
//   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
//   if ($_FILES["CatImage"]["size"] > 500000) {
//   echo "<script>alert('Sorry, your file is too large.')</script>";
//     $uploadOk = 0;
//   }
  
//   if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
//     && $imageFileType != "gif" ) {
      
//       echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
//       $uploadOk = 0;
//     }
    
//   if ($uploadOk == 0) {
//       echo "<script>alert('Sorry, your file was not uploaded.')</script>";
//     } else {
//       $filewithnewname =  date("Ymdis")."_Sub_Cat.".$imageFileType;    
//       if (move_uploaded_file($_FILES["CatImage"]["tmp_name"], $target_dir.$filewithnewname)) {
//          "The file ". htmlspecialchars( basename( $_FILES["CatImage"]["name"])). " has been uploaded.";
//         $sql = "INSERT INTO `sub_categories`(`category_id`, `name`, `img`) VALUES ($main_cat,'$cat_name','$filewithnewname')";
//         $result = mysqli_query($con,$sql);
//         if($result){
//           header("Location:../addSubCat.php?Massage=Sucessfully added new category.");
//         }
//       } else {
       
//         echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
//       }
//   }
  
  

// }

if (isset($_POST['btnSubmit_insertSubCategories'])) {
    include('../assets/connection.php');
    session_start();
    
  $cat_name = mysqli_real_escape_string($con, $_POST['CatName']);
$main_cat = mysqli_real_escape_string($con, $_POST['MainCat']);
    $target_dir = "../Uploads/";

    // Upload category image
    $catImageName = handleImageUpload($_FILES["CatImage"], $target_dir, "Sub_Cat");

    // Upload banner image
    $bannerImageName = handleImageUpload($_FILES["banner_image"], $target_dir, "Banner");

    if ($catImageName && $bannerImageName) {
        $sql = "INSERT INTO `sub_categories`(`category_id`, `name`, `img`, `banner_image`) VALUES ($main_cat, '$cat_name', '$catImageName', '$bannerImageName')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            header("Location: ../addSubCat.php?Massage=Sucessfully Added New Sub Category.");
        } else {
            echo "<script>alert('Database error: Unable to insert record.')</script>";
        }
    }
}

// Function to handle image uploads
function handleImageUpload($file, $target_dir, $prefix) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Error uploading file: " . $file['name'] . "')</script>";
        return false;
    }

    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    // Validate file size
    if ($file["size"] > 500000) {
        echo "<script>alert('File too large: " . $file['name'] . "')</script>";
        return false;
    }

    // Validate allowed formats
    $allowedTypes = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "<script>alert('Invalid file type for " . $file['name'] . "')</script>";
        return false;
    }

    // Generate unique filename
    $newFileName = date("Ymdis") . "_$prefix." . $imageFileType;

    // Move uploaded file
    if (move_uploaded_file($file["tmp_name"], $target_dir . $newFileName)) {
        return $newFileName;
    } else {
        echo "<script>alert('Failed to upload: " . $file['name'] . "')</script>";
        return false;
    }
}




if (isset($_POST['btnSubmit_insertSliders'])) {
//                 error_reporting(E_ALL);
// ini_set('display_errors', 1);
  include('../assets/connection.php');
  session_start();
  
  
  $cat_name = $_POST['CatName'];
  $main_cat = $_POST['MainCat'];
  $product_id = $_POST['product_id'];
  $target_dir = "../Uploads/";
  $target_file = $target_dir . basename($_FILES["CatImage"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $cat_name = mysqli_real_escape_string($con, $cat_name);
$main_cat = mysqli_real_escape_string($con, $main_cat);
$filewithnewname = mysqli_real_escape_string($con, $filewithnewname);
$product_id = mysqli_real_escape_string($con, $product_id);

  if ($_FILES["CatImage"]["size"] > 500000000) {
    echo "<script>alert('Sorry, your file is too large.')</script>";
    $uploadOk = 0;
  }

  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {

    echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
    $uploadOk = 0;
  }

  if ($uploadOk == 0) {
    echo "<script>alert('Sorry, your file was not uploaded.')</script>";
  } else {
    $filewithnewname =  date("Ymdis") . "_Slider." . $imageFileType;
    if (move_uploaded_file($_FILES["CatImage"]["tmp_name"], $target_dir . $filewithnewname)) {
      "The file " . htmlspecialchars(basename($_FILES["CatImage"]["name"])) . " has been uploaded.";
      
      
      $sql = "INSERT INTO `sliders`(`alt_name`, `type`, `img`, `product_id`) VALUES ('$cat_name','$main_cat','$filewithnewname', '$product_id')";
      $result = mysqli_query($con, $sql);

      if ($result) {
        $monitor_sql = "INSERT INTO `website_requests` (`website_name`, `status`, `created_at`, `updated_at`) 
                     VALUES ('haveliresturant', '1' ,NOW(),NOW())";
        $monitor_update = mysqli_query($con, $monitor_sql);

        if ($monitor_update) {
          header("Location:../addslider.php?Massage=Sucessfully added new slider.");
        } else {
          die("Error updating monitoring database: " . mysqli_error($monitor_con));
        }
      } else {
        echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
      }
    } else {

      echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
    }
  }
}


if(isset($_POST['btnSubmit_insertProduct'])){
include('../assets/connection.php');
  session_start();
  $addon_name = $_POST['addon_name'];
  $addon_price = $_POST['addon_price'];
  $ProName = $_POST['ProName'];
  $ProDes = $_POST['ProDes'];
  $ProCost = $_POST['ProCost'];
  $ProPrice = $_POST['ProPrice'];
  $ProQty = $_POST['ProQty'];
  $ProDiscount = $_POST['ProDiscount'];
  $MainCat = $_POST['MainCat'];
  $target_dir = "../Uploads/";
  $target_file = $target_dir . basename($_FILES["ProImage"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
  if ($_FILES["CatImage"]["size"] > 500000) {
  echo "<script>alert('Sorry, your file is too large.')</script>";
    $uploadOk = 0;
  }
  
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      
      echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
      $uploadOk = 0;
    }
    
  if ($uploadOk == 0) {
      echo "<script>alert('Sorry, your file was not uploaded.')</script>";
    } else {
      $filewithnewname =  date("Ymdis")."_Product.".$imageFileType;    
      if (move_uploaded_file($_FILES["ProImage"]["tmp_name"], $target_dir.$filewithnewname)) {
         "The file ". htmlspecialchars( basename( $_FILES["ProImage"]["name"])). " has been uploaded.";
         
        $sql = "INSERT INTO `products`(`sub_category_id`, `name`, `description`, `cost`, `price`, `discount`, `qty`,`img`) VALUES ($MainCat,'$ProName','$ProDes',$ProCost,$ProPrice,$ProDiscount,$ProQty,'$filewithnewname')";
        $result = mysqli_query($con,$sql);
        
        $last_inserted_id = $con->insert_id;
        if($result){
           $combined = array_combine($addon_name, $addon_price);
           
           foreach($combined as $addon_name => $addon_price) {
                $insert_addon = "INSERT INTO `add_on`(`sub_category_id`,`product_id`, `product_name`, `addon_name`, `addon_price`) VALUES ($MainCat,'$last_inserted_id','$ProName','$addon_name','$addon_price')";
                $result_addon = mysqli_query($con,$insert_addon);
            } 
            
            header("Location:../addnewProduct.php?Massage=Sucessfully added new product.");
            
            
            
        }else{
            echo "<script>alert('Sorry, there was an error while adding product.')</script>";
        }
        
        
        
        
        
        
        // $last_id = mysqli_insert_id($con);
        //  $sql_image = "INSERT INTO `product_images`(`product_id`, `img`) VALUES ($last_id,'$filewithnewname')";
        // $result_image = mysqli_query($con,$sql_image);
        
        // if($result){
        //   header("Location:../addnewProduct.php?Massage=Sucessfully added new product.");
        // }
      } else {
       
        echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
      }
  }


}


// 
// 
// ZEE
// 
// 


// btnSubmit_addDealz
if(isset($_POST['btnSubmit_addDealz'])){
     include('../assets/connection.php');
     include('../assets/config.php');
     


  
     $dealtitle = $_POST['deal_title'];
     $num_freeitems = $_POST['num_free_items'];
     $chk_box = $_POST['checkboxid'];
     $DealQty = $_POST['DealQuantity'];
     
     
     $DealName = mysqli_real_escape_string($con,$_POST['DealName']);
     $DealDes = mysqli_real_escape_string($con,$_POST['DealDes']);
     $DealCost = $_POST['DealCost'];
     $DealPrice = $_POST['DealPrice'];
     $DealQty = $_POST['DealQuantity'];
     
          $target_dir = "../Uploads/";
          $target_file = $target_dir . basename($_FILES["DealImage"]["name"]);
          $uploadOk = 1;
          $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
              if ($_FILES["DealImage"]["size"] > 500000000) {
                echo "<script>alert('Sorry, your file is too large.')</script>";
                $uploadOk = 0;
              } 
             if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                      
                      echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
                      $uploadOk = 0;
              }
              
                         if ($uploadOk == 0) {
                            echo "<script>alert('Sorry, your file was not uploaded.')</script>";
                        } else {
                        $filewithnewname =  date("Ymdis")."_Product.".$imageFileType;    
                  if (move_uploaded_file($_FILES["DealImage"]["tmp_name"], $target_dir.$filewithnewname)) {
                     "The file ". htmlspecialchars( basename( $_FILES["DealImage"]["name"])). " has been uploaded.";
                    //  `deal_id`
                    $sql = "INSERT INTO `deals`(`deal_name`, `deal_description`, `deal_cost`, `deal_price`, `deal_image`, `deal_items_number`) VALUES
                                        ('$DealName','$DealDes','$DealCost','$DealPrice','$filewithnewname','$DealQty')";
                    $result = mysqli_query($con,$sql);
                    
                    $last_inserted_id2 = $con->insert_id;
                    if($result){
                            for($i = 0 ; $i < $DealQty ; $i++ ){
                                
                                $temp = ["product_id"=>$chk_box[$i+1]];
                                
                                //echo $dealtitle[$i].'-'.$num_freeitems[$i].'-'.$i.'@'.json_encode($temp).'|';
                                
                                 $sql_insert_item = "INSERT INTO `deal_items`( `deal_id`, `di_title`, `di_num_free_items`, `deal_subdata`) VALUES
                                                            ('$last_inserted_id2','$dealtitle[$i]','$num_freeitems[$i]','". json_encode($temp) ."')";
                                 $result_item = mysqli_query($con,$sql_insert_item);
                                
                        
                        }
                        if($result_item){
                                header("Location:../insertDeals.php?Massage=Sucessfully added new Deal.");

                        }
                        
                    }else{
                        echo "<script>alert('Sorry, there was an error while adding deal.')</script>";
                    }
            
                  } else {
                   
                    echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
                  }
              }
            
                
         
     
     
}



if(isset($_POST['btnSubmit_test'])){
    
         $dealtitle = $_POST['deal_title'];
        $num_freeitems = $_POST['num_free_items'];
        $chk_box = $_POST['checkboxid'];
        $DealQty = $_POST['DealQuantity'];
     
     
                            for($i = 0 ; $i < $DealQty ; $i++ ){
                                
                           // foreach($chk_box[$i] as $box){
                                $temp = ["product_id"=>$chk_box[$i+1]];
                                echo $dealtitle[$i].'-'.$num_freeitems[$i].'-'.$i.'@'.json_encode($temp).'|';
                            //}
                        }
}


//btnSubmit_insertDeal
if(isset($_POST['btnSubmit_insertDeal'])){
//     include('../assets/connection.php');
    
//     $dealtitle = $_POST['deal_title'];
//     $num_freeitems = $_POST['num_free_items'];
     $chk_box = $_POST['checkboxid'];
    
    
//     $DealName = $_POST['DealName'];
//     $DealDes = $_POST['DealDes'];
//     $DealCost = $_POST['DealCost'];
//     $DealPrice = $_POST['DealPrice'];
    
       $z  = $_POST['moiz'];
     
//     $target_dir = "../Uploads/";
//     $target_file = $target_dir . basename($_FILES["DealImage"]["name"]);
//     $uploadOk = 1;
//     $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//       if ($_FILES["DealImage"]["size"] > 500000) {
//         echo "<script>alert('Sorry, your file is too large.')</script>";
//         $uploadOk = 0;
//       } 
//          if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
//                 && $imageFileType != "gif" ) {
                  
//                   echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
//                   $uploadOk = 0;
//                 }
                
//           if ($uploadOk == 0) {
//                 echo "<script>alert('Sorry, your file was not uploaded.')</script>";
//             } else {
//             $filewithnewname =  date("Ymdis")."_Product.".$imageFileType;    
//       if (move_uploaded_file($_FILES["DealImage"]["tmp_name"], $target_dir.$filewithnewname)) {
//          "The file ". htmlspecialchars( basename( $_FILES["DealImage"]["name"])). " has been uploaded.";
//         //  `deal_id`
//         $sql = "INSERT INTO `deals`(`deal_name`, `deal_description`, `deal_cost`, `deal_price`, `deal_image`) VALUES
//                             ('$DealName','$DealDes','$DealCost','$DealPrice','$filewithnewname')";
//         $result = mysqli_query($con,$sql);
        
//         $last_inserted_id2 = $con->insert_id;
//         if($result){
//         //   $combined = array_combine($deal_title, $num_freeitems);
           
//         //   foreach($combined as $deal_title => $num_free_items) {
//                 for($i = 0; $i < count($z) ; $i++){
//                 $insert_addon = "INSERT INTO `deal_items`( `deal_id`, `di_title`, `di_num_free_items`) VALUES ('$last_inserted_id2','$dealtitle[$i]','$num_freeitems[$i]')";
//                 $result_addon = mysqli_query($con,$insert_addon);
//                 $last_inserted_id3 = $con->insert_id;
//                     foreach($chk_box[$i] as $chk_box_val) {
//                     //echo $chk_box_val;
//                     $insert_bt = "INSERT INTO `bt_deal_items`(`di_id`, `dp_id`) VALUES ('$last_inserted_id3','$chk_box_val')";
//                     $result_bt = mysqli_query($con,$insert_bt);
//                     }
//       //     } 
           
            
//                 }
//              if($result_bt){
//             header("Location:../addDeals.php?Massage=Sucessfully added new Deal.");
                
//             }
            
//         }else{
//             echo "<script>alert('Sorry, there was an error while adding deal.')</script>";
//         }

//       } else {
       
//         echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
//       }
//   }
      
        // for($i = 0; $i < count($z) ; $i++){
        //     echo 'ponka'.$i.'zz';
        //             $val = [];
        //             foreach ($chk_box[$i+1] as $type) {
        //                 $val = '*'.$type[0].'';
        //                 echo $val;
        //             }
                    
        //     }
        
        
        print_r ($z) ;
        print_r(' qqqq ');
        print_r ($chk_box);
        echo '</ br>';
        echo '@';
        for($a = 0 ; $a < count($z) ; $a++){
            echo $a."\r\n";
        }
    


        

}


if(isset($_POST['btnSubmit_insertNewProductZ'])){
    
//             error_reporting(E_ALL);
// ini_set('display_errors', 1);
    
include('../assets/connection.php');
include('../assets/config.php'); 

  session_start();
//   $addon_name = $_POST['addon_name'];
//   $addon_price = $_POST['addon_price'];

  $ProName = mysqli_real_escape_string($con, $_POST['ProName']);
  $ProDes = mysqli_real_escape_string($con, $_POST['ProDes']);
  $ProCost = $_POST['ProCost'];
  $ProPrice = $_POST['ProPrice'];
  $ProQty = $_POST['ProQty']?? 1000;
  $ProDiscount = $_POST['ProDiscount'];
  $MainCat = $_POST['MainCat'];
  $addonCat = $_POST['addonCat'];
  $typeCat = $_POST['typeCat'];
  $dressingCat = $_POST['dressingCat'];
  $sku_id = $_POST['sku_id'];
  $tax = $_POST['tax'];
  $for_deal_only = $_POST['for_deal_only'];
  
  
  
  $target_dir = "../Uploads/";
  $target_file = $target_dir . basename($_FILES["ProImage"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
  if ($_FILES["CatImage"]["size"] > 500000) {
  echo "<script>alert('Sorry, your file is too large.');window.location.href='../insertNewProduct.php'</script>";
    $uploadOk = 0;
  }
  
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      
      echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');window.location.href='../insertNewProduct.php'</script>";
      $uploadOk = 0;
    }
    
  if ($uploadOk == 0) {
      echo "<script>alert('Sorry, your file was not uploaded.');window.location.href='../insertNewProduct.php'</script>";
    } else {
      $filewithnewname =  date("Ymdis")."_Product.".$imageFileType;    
      if (move_uploaded_file($_FILES["ProImage"]["tmp_name"], $target_dir.$filewithnewname)) {
         "The file ". htmlspecialchars( basename( $_FILES["ProImage"]["name"])). " has been uploaded.";
         
         
        $sql = "INSERT INTO `products`(`addon_id`,`type_id`,`dressing_id`, `sub_category_id`,`name`, `sku_id`, `description`, `cost`, `price`, `discount`, `qty`,`img`, `tax`, `for_deal_only`) VALUES 
                                        ($addonCat,$typeCat,$dressingCat,'$MainCat','$ProName','$sku_id','$ProDes',$ProCost,$ProPrice,$ProDiscount,$ProQty,'$filewithnewname', '$tax', '$for_deal_only')";
                                        
        $result = mysqli_query($con,$sql);
            if($result){
                 $monitor_sql = "INSERT INTO `website_requests` (`website_name`, `status`, `created_at`, `updated_at`) 
                                VALUES ('haveliresturant', '1' ,NOW(),NOW())";
                $monitor_update = mysqli_query($con, $monitor_sql);
        
                if ($monitor_update) {
                        header("Location:../insertNewProduct.php?Massage=Sucessfully added new product.");
                } else {
                     header("Location:../insertNewProduct.php?Massage=Sorry, there was an error while adding product.");
                }
                
            }
       
      } else {
       
        echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
      }
  }


}


if(isset($_POST['btnSubmit_insertMoreAddon'])){
include('../assets/connection.php');
  session_start();
   $addon_name = $_POST['addon_name'];
  $addon_price = $_POST['addon_price'];
   $addon_id = $_POST['addon_id'];
  
     
        
          $combined = array_combine($addon_name, $addon_price);
           
          foreach($combined as $addon_name => $addon_price) {
              echo  $insert_addon = "INSERT INTO `addon_sublist`(`ao_id`, `as_name`, `as_price`) VALUES ('$addon_id','$addon_name','$addon_price')";
                $result_addon = mysqli_query($con,$insert_addon);
            } 
            
           
            
            if($result_addon){
                 header("Location:../update_addons.php?id='$addon_id'&Massage=Sucessfully updated Addon.");
            }else{
            echo "<script>alert('Sorry, there was an error while adding addon.')</script>";
            }
            
            
       
       

}

// for addon_type



if (isset($_POST['btnSubmit_insertMoreAddonType'])) {
    include('../assets/connection.php');
    session_start();

    $addon_names = $_POST['addon_name'] ?? [];
    $addon_prices = $_POST['addon_price'] ?? [];
    $addon_id = $_POST['addon_id'] ?? null;

        $get_type_sql = "SELECT * FROM types_list WHERE type_id = '$addon_id'";
        $exec_type = mysqli_query($con, $get_type_sql);
        $type_data = mysqli_fetch_assoc($exec_type);

        if (!$type_data) {
            echo "<script>alert('Invalid Type ID.'); window.location.href='../update_types.php';</script>";
            exit();
        }

        $type_title = mysqli_real_escape_string($con, $type_data['type_title']);
        $type_title_user = mysqli_real_escape_string($con, $type_data['type_title_user']);

        foreach ($addon_names as $index => $add_name) {
            $price = $addon_prices[$index];

            // Escape each value
            $add_name_safe = mysqli_real_escape_string($con, $add_name);
            $price_safe = mysqli_real_escape_string($con, $price);

            $insert_addontype = "INSERT INTO `types_sublist`(`type_id`, `ts_name`, `price`, `type_title`, `type_title_user`) 
                                 VALUES ('$addon_id', '$add_name_safe', '$price_safe', '$type_title', '$type_title_user')";
            $result_addon = mysqli_query($con, $insert_addontype);

            if (!$result_addon) {
                echo "<script>alert('Error while inserting: " . mysqli_error($con) . "'); 
                      window.location.href='../update_types.php?id=$addon_id';</script>";
                exit();
            }
        }
        header("Location: ../update_types.php?id=$addon_id&Massage=Successfully updated Type.");

  
}




// end addon_type




// for addon_dressing


if (isset($_POST['btnSubmit_insertMoreAddonDressing'])) {
//     error_reporting(E_ALL);
// ini_set('display_errors', 1);
    include('../assets/connection.php');
    session_start();

    $addon_name = $_POST['addon_name'];
    $addon_price = $_POST['addon_price'];
    $addon_id = $_POST['addon_id'];
    
    

    // Fetch dressing details once
    $sql = "SELECT * FROM `dressing_list` WHERE `dressing_id`= '$addon_id'";
    $exec = mysqli_query($con, $sql);

    if (mysqli_num_rows($exec) > 0) {
        $data = mysqli_fetch_assoc($exec);
        
        $combined = array_combine($addon_name, $addon_price);
        
        $dressing_title = $data['dressing_title'];
        $dressing_title_user = $data['dressing_title_user'];

       foreach ($combined as  $addon_name => $addon_price) {
    $addtype_name_safe = mysqli_real_escape_string($con, $addon_name);
    $dressing_title_safe = mysqli_real_escape_string($con, $dressing_title);
    $dressing_title_user_safe = mysqli_real_escape_string($con, $dressing_title_user);

    $insert_addontype = "INSERT INTO `dressing_sublist`(`dressing_id`, `dressing_title`, `dressing_title_user`, `dressing_name`, `price`) 
        VALUES ('$addon_id', '$dressing_title_safe', '$dressing_title_user_safe', '$addtype_name_safe', '$addon_price')";
    
    $result_addon = mysqli_query($con, $insert_addontype);
}

        if ($result_addon) {
            header("Location: ../update_dressing.php?id=$addon_id&Massage=Sucessfully updated Dressing.");
            exit();
        } else {
            echo "<script>alert('Sorry, there was an error while adding addon.'); window.location.href='../update_dressing.php?id=$addon_id';</script>";
        }
    } else {
        echo "<script>alert('Invalid dressing ID.'); window.location.href='../update_dressing.php';</script>";
    }
}




if(isset($_POST['btnSubmit_insertAddon']))
{
include('../assets/connection.php');
  session_start();
  $addon_name = $_POST['addon_name'];
  $addon_price = $_POST['addon_price'];
  $addon_title = mysqli_real_escape_string($con,$_POST['addon_title']);
  
        if($addon_title){
        $sql = "INSERT INTO `addon_list`(`ao_title`) VALUES ('$addon_title')";
        $result = mysqli_query($con,$sql);
        
        $last_inserted_id = $con->insert_id;
        if($result){
           $combined = array_combine($addon_name, $addon_price);
           
           foreach($combined as $addon_name => $addon_price) {
               $addon_NAME  = mysqli_real_escape_string($con,$addon_name);
                $insert_addon = "INSERT INTO `addon_sublist`(`ao_id`,`ao_title`, `as_name`, `as_price`) VALUES ('$last_inserted_id','$addon_title','$addon_NAME','$addon_price')";
                $result_addon = mysqli_query($con,$insert_addon);
            } 
            
            header("Location:../addAddons.php?Massage=Sucessfully added new Addon.");
            
            
            
        }else{
            echo "<script>alert('Sorry, there was an error while adding addon.')</script>";
        }
        }else{
             echo "<script>alert('Please insert addon title.')</script>";
        }

}


// add variations

if(isset($_POST['btnSubmit_Variation']))
{
      include('../assets/connection.php');
      
    //   $myarray = array();
      
      session_start();
      $pro_id = $_POST['pro_id'];
      $var_sub_title = $_POST['var_sub_title'];
      $var_title =  mysqli_real_escape_string($con,$_POST['var_title']);
      
    //   print_r($pro_id);
    //   die();
    //   array_push($myarray,$pro_id);
      if(in_array(0 ,$pro_id ))
      {
          ?>
          <script>alert("Please Change Your Product");
          window.location.href="../addVariation.php";
          </script>
          <?php
      }
      else
      {
  
            $sql = "INSERT INTO `variation`(`title`) VALUES ('$var_title')";
            $result = mysqli_query($con,$sql);
            
            $last_inserted_id = $con->insert_id;
            if($result)
            {
               $combined = array_combine($pro_id, $var_sub_title);
               
               foreach($combined as $pro_id => $var_sub_title) {
                   $var_sub_TILTLE =  mysqli_real_escape_string($con,$var_sub_title);
                    $insert_var = "INSERT INTO `variation_with_product`(`product_id`, `sub_title`, `var_id`) VALUES ('$pro_id','$var_sub_TILTLE','$last_inserted_id')";
                    $result_var = mysqli_query($con,$insert_var);
                } 
                
                header("Location:../addVariation.php?Massage=Sucessfully added new Variation.");
                
                
                
            }
            else
            {
                echo "<script>alert('Sorry, there was an error while adding addon.')</script>";
            }
            
      
        
      }

}

// end variation




if(isset($_POST['btnSubmit_insertType'])){
include('../assets/connection.php');
  session_start();
  $type_title = mysqli_real_escape_string($con,$_POST['type_title']);
    $type_title_user = mysqli_real_escape_string($con,$_POST['type_title_user']);
  $add_type = $_POST['add_type'];
  $add_price = $_POST['add_price'];

  
        if($type_title && $type_title_user){
        $sql = "INSERT INTO `types_list` (`type_title`, `type_title_user`) VALUES ('$type_title','$type_title_user')";
        $result = mysqli_query($con,$sql);
        
        $last_inserted_id = $con->insert_id;
        if($result){
          // $combined = array_combine($add_type);
           
           foreach($add_type as $index => $at) {
                   $price = $add_price[$index];
               $add_TYPE_NAME =  mysqli_real_escape_string($con,$at);
                $insert_types = "INSERT INTO `types_sublist`(`type_id`, `type_title`, `type_title_user`, `ts_name`,`price`) VALUES ('$last_inserted_id','$type_title','$type_title_user','$add_TYPE_NAME', '$price')";
                $result_types = mysqli_query($con,$insert_types);
            } 
            
            header("Location:../addTypes.php?Massage=Sucessfully added new Type.");
            
            
            
        }else{
            echo "<script>alert('Sorry, there was an error while adding type.')</script>";
        }
        }else{
             echo "<script>alert('Please insert type title or title for user.')</script>";
        }

}

//btnSubmit_insertDressing


if(isset($_POST['btnSubmit_insertDressing'])){
include('../assets/connection.php');
  session_start();
  $type_title = mysqli_real_escape_string($con,$_POST['dressing_title']);
  $type_title_user = mysqli_real_escape_string($con,$_POST['dressing_title_user']);
  $add_type = $_POST['add_dressing'];
  $add_price = $_POST['add_price'];

  
        if($type_title && $type_title_user){
        $sql = "INSERT INTO `dressing_list`(`dressing_title`, `dressing_title_user`) VALUES ('$type_title','$type_title_user')";
        $result = mysqli_query($con,$sql);
        
        $last_inserted_id = $con->insert_id;
        if($result){
          // $combined = array_combine($add_type);
           
           foreach($add_type as $index =>  $at) {
                   $price = $add_price[$index];
               $dressing_NAME = mysqli_real_escape_string($con,$at);
                $insert_types = "INSERT INTO `dressing_sublist`(`dressing_id`, `dressing_title`, `dressing_title_user`, `dressing_name`, `price`) VALUES ('$last_inserted_id','$type_title','$type_title_user','$dressing_NAME', '$price')";
                $result_types = mysqli_query($con,$insert_types);
            } 
            
               header("Location:../addDressing.php?Massage=Sucessfully added new Dressing.");
            
            
            
        }else{
            echo "<script>alert('Sorry, there was an error while adding Dressing.')</script>";
        }
        }else{
             echo "<script>alert('Please insert Dressing title or title for user.')</script>";
        }

}


// 
// 
// ZEE
// 
// 





if(isset($_POST['btnSubmit_insertuser'])){
include('../assets/connection.php');
  session_start();
  $name = $_POST['name'];
  $email = strtolower($_POST['email']);
  $phone = $_POST['phone'];
  $password = md5('demo1234');
  
  $target_dir = "../Uploads/";
  $target_file = $target_dir . basename($_FILES["img"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  

  
      $filewithnewname =  date("Ymdis")."_Product.".$imageFileType;    
      if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_dir.$filewithnewname)) {
         "The file ". htmlspecialchars( basename( $_FILES["img"]["name"])). " has been uploaded.";
         
         $sql = "INSERT INTO `users`(`role_id`,`name`, `email`, `phone`,`profilepic`,`sbscription_status`,`password`) VALUES (2,'$name','$email','$phone','$filewithnewname',0,'$password')";
        $result = mysqli_query($con,$sql);
        // $last_id = mysqli_insert_id($con);
        //  $sql_image = "INSERT INTO `product_images`(`product_id`, `img`) VALUES ($last_id,'$filewithnewname')";
        // $result_image = mysqli_query($con,$sql_image);
        
        if($result){
          header("Location:../addriders.php?Massage=Sucessfully added new rider.");
        }
      } else {
       
        echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
      }
  


}




if(isset($_POST['updatePoints'])){
    $Type = $_POST['Type'];
    $user_id = $_POST['user_id'];
    $old_amount = $_POST['old_qty'];
    $newamount = $_POST['newqty'];
    $newzzz = $_POST['newqty'];
    if($Type == "add"){
       $newamount = $newamount + $old_amount;
       include('../assets/connection.php');
       $t=time();
       $transation = $t.$user_id.$newamount;
         $sql = "UPDATE `users` SET `amount` = $newamount  WHERE `id` =$user_id";
        $update = mysqli_query($con,$sql);
        if($update){
            
        $sqltaskMembersx = "SELECT `notification_token` FROM `users` WHERE `id` = '$user_id' ";
        $taskMembersx = mysqli_query($con,$sqltaskMembersx);
        $playerIdx = [];
        $subject = '';
        $newstatus = '';
        
        while($row = mysqli_fetch_array($taskMembersx)){
        	     
                 array_push($playerIdx, $row['notification_token']);
                
            }
            
         
             
                    $order_content = 'TID : '.$transation.' Your wallet has been credited with €'  .$newzzz. '. Your new balance is €' .$newamount.'.';
                     $contentx = array(
                    "en" => $order_content
                    );

               
                    $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','$order_content','transaction')";
                    $execute_insert_noti = mysqli_query($con,$insert_noti_details);
                    
                    
                
                        
                $fields = array(
                     'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                     'include_player_ids' => $playerIdx,
                    'data' => array("foo" => "NewMassage","Id" => $taskid),
                    'large_icon' =>"ic_launcher_round.png",
                    'contents' => $contentx
                );

                $fields = json_encode($fields);
               

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                              'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebnd7ohwrgq5huhen2yfaytan73n45db4ovkcrwwdr2g4xsmwa3flzui3ih3pk65hgjfsjxo2vwnnagwy'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

                 $response = curl_exec($ch);
                curl_close($ch);
            
            
            
            
            
             $sqladd = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `old_amount`, `type`, `message`) VALUES ($user_id,$transation,$newamount,$newzzz,'credit','Credited by admin')";
             $add = mysqli_query($con,$sqladd);
             if($add){
                 header("Location:../managePoints.php?Massage=Sucessfully updated amount."); 
             }
            
        }
        
        
    }else if($Type == "sub"){
      if($old_amount >= $newamount){
       $newamount = $old_amount - $newamount;
       include('../assets/connection.php');
       $t=time();
       $transation = $t.$user_id.$newamount;
         $sql = "UPDATE `users` SET `amount` = $newamount  WHERE `id` =$user_id";
        $update = mysqli_query($con,$sql);
        if($update){
            
                  
        $sqltaskMembersx = "SELECT `notification_token` FROM `users` WHERE `id` = '$user_id' ";
        $taskMembersx = mysqli_query($con,$sqltaskMembersx);
        $playerIdx = [];
        $subject = '';
        $newstatus = '';
        
        while($row = mysqli_fetch_array($taskMembersx)){
        	     
                 array_push($playerIdx, $row['notification_token']);
                
            }
            
         
             
                    $order_content = 'TID : '.$transation.' Your wallet has been debited with €'  .$newzzz. '. Your new balance is €' .$newamount.'.';
                     $contentx = array(
                    "en" => $order_content
                    );

               
                    $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$user_id','$order_content','transaction')";
                    $execute_insert_noti = mysqli_query($con,$insert_noti_details);
                    
                

                    
                $fields = array(
                       'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                     'include_player_ids' => $playerIdx,
                    'data' => array("foo" => "NewMassage","Id" => $taskid),
                    'large_icon' =>"ic_launcher_round.png",
                    'contents' => $contentx
                );

                $fields = json_encode($fields);
               

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                              'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebnd7ohwrgq5huhen2yfaytan73n45db4ovkcrwwdr2g4xsmwa3flzui3ih3pk65hgjfsjxo2vwnnagwy'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

                 $response = curl_exec($ch);
                curl_close($ch);

            
            
            
              $sqladd = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `old_amount` ,`type`, `message`) VALUES ($user_id,$transation,$newamount,$newzzz,'debit','Debited by admin')";
             $add = mysqli_query($con,$sqladd);
             if($add){
                 header("Location:../managePoints.php?Massage=Sucessfully updated amount."); 
             }
            
        }
        
    }else{
        header("Location:../managePoints.php?Massage=Do not have this much balance."); 
    }
        
    }
    
}










if(isset($_POST['btnSubmit_insertFeaturedProduct'])){
include('../assets/connection.php');
  session_start();
  $ProName = $_POST['ProName'];
  $ProDes = $_POST['ProDes'];
  $ProCost = $_POST['ProCost'];
  $ProPrice = $_POST['ProPrice'];
  $ProQty = $_POST['ProQty'];
  $ProDiscount = $_POST['ProDiscount'];
  $MainCat = $_POST['MainCat'];
  $target_dir = "../Uploads/";
  $target_file = $target_dir . basename($_FILES["ProImage"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
  if ($_FILES["CatImage"]["size"] > 500000) {
  echo "<script>alert('Sorry, your file is too large.')</script>";
    $uploadOk = 0;
  }
  
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      
      echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
      $uploadOk = 0;
    }
    
  if ($uploadOk == 0) {
      echo "<script>alert('Sorry, your file was not uploaded.')</script>";
    } else {
      $filewithnewname =  date("Ymdis")."_Product.".$imageFileType;    
      if (move_uploaded_file($_FILES["ProImage"]["tmp_name"], $target_dir.$filewithnewname)) {
         "The file ". htmlspecialchars( basename( $_FILES["ProImage"]["name"])). " has been uploaded.";
         
         $sql = "INSERT INTO `featured_products`( `name`, `description`, `cost`, `price`, `discount`, `qty`,`img`) VALUES ('$ProName','$ProDes',$ProCost,$ProPrice,$ProDiscount,$ProQty,'$filewithnewname')";
        $result = mysqli_query($con,$sql);
        // $last_id = mysqli_insert_id($con);
        //  $sql_image = "INSERT INTO `product_images`(`product_id`, `img`) VALUES ($last_id,'$filewithnewname')";
        // $result_image = mysqli_query($con,$sql_image);
        
        if($result){
          header("Location:../addfeatured.php?Massage=Sucessfully added new product.");
        }
      } else {
       
        echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
      }
  }


}
// if(isset($_POST['btnSubmit_Action'])){
//     $status = $_POST['Action'];
//     $order_id = $_POST['order_id'];
//     // $rider_id = $_POST['rider_id'];
//     $datatime = '';
//     include('../assets/connection.php');
//     $sql;
//     if($status == 'shipped'){
//         $sql = "UPDATE `orders_zee` SET `status` = '$status'  , `rider_id` = 0   WHERE `id` = $order_id"; 
//     }else if($status == 'pending'){
//         date_default_timezone_set('Europe/Berlin');
//         $minutes_to_add = 45;
//         $time = new DateTime();
//         $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
//         $datetime = $time->format('Y-m-d g:i A');
 
//         $sql = "UPDATE `orders_zee` SET `status` = '$status'  , `delivered_at` = '$datetime' WHERE `id` = $order_id";
//         //yahan bhi call kr sakty hain
//         // include_once('reciept.php');
//     }
//     else{
//         $sql = "UPDATE `orders_zee` SET `status` = '$status' WHERE `id` = '$order_id'";
//     }
   
   
//     $update = mysqli_query($con,$sql);
    
     

//     //  $sqltaskMembers = "SELECT `notification_token`,`name` FROM `users` WHERE `id` = $rider_id ";
//     //     $taskMembers = mysqli_query($con,$sqltaskMembers);
//     //     $playerId = [];
//     //     $subject = '';
//     //     $ryder_name = '';
//     //     while($row = mysqli_fetch_array($taskMembers)){
//     //     	     $order_id ;
//     //              array_push($playerId, $row['notification_token']);   
//     //             $ryder_name = $row['name'];
//     //         }
            
//     //             $content = array(
//     //                 "en" => ' You have been assigned for an order: '.$order_id.'.'
//     //                 );

//     //             $fields = array(
//     //                  'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
//     //                  'include_player_ids' => $playerId,
//     //                 'data' => array("foo" => "NewMassage","Id" => $taskid),
//     //                 'large_icon' =>"ic_launcher_round.png",
//     //                 'contents' => $content
//     //             );

//     //             $fields = json_encode($fields);
               

//     //             $ch = curl_init();
//     //             curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
//     //             curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
//     //                                                       'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'));
//     //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//     //             curl_setopt($ch, CURLOPT_HEADER, FALSE);
//     //             curl_setopt($ch, CURLOPT_POST, TRUE);
//     //             curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
//     //             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

//     //              $response = curl_exec($ch);
//     //             curl_close($ch);
                

//         $sql_get_user_id ="SELECT `user_id` FROM `orders_zee` WHERE `id` = '$order_id'";
//         $execute_get_user_id = mysqli_query($con,$sql_get_user_id);
//         $user_data = mysqli_fetch_array($execute_get_user_id);
//         $get_user_id = $user_data['user_id'];

        

        
        
//         if($execute_get_user_id){
//         $sqltaskMembersx = "SELECT `notification_token` FROM `users` WHERE `id` = '$get_user_id' ";
//         $taskMembersx = mysqli_query($con,$sqltaskMembersx);
//         $playerIdx = [];
//         $subject = '';
//         $newstatus = '';
        
//         while($row = mysqli_fetch_array($taskMembersx)){
        	     
//                  array_push($playerIdx, $row['notification_token']);
                
//             }
            
//             $order_content = '';
//                 if($status == 'pending'){
                    
//                     $order_content = 'Ihre Bestellung Nr:'  .$order_id. ' wurde angenommen. Die voraussichtliche Lieferzeit für Ihre Bestellung beträgt '.$datetime.".";
//                      $contentx = array(
//                     "en" => $order_content
//                     );
                            

//                 }else if($status == 'shipped')
//                     {
//                         $order_content = ' Ihre Bestellung Nr: '.$order_id.' ist gewesen '.$status.' zum Reiter '.$ryder_name;
//                         $contentx = array(
//                     "en" => $order_content
//                     ); 
//                     }else{
//                         $order_content = ' Ihre Bestellung Nr: '.$order_id.' ist gewesen '.$status.'.';
//                       $contentx = array(
//                     "en" => $order_content
//                     );   
                    
                    
//                 }
               
//                     $insert_noti_details = "INSERT INTO `notification`( `user_id`, `content`, `purpose`) VALUES ('$get_user_id','$order_content','order')";
//                     $execute_insert_noti = mysqli_query($con,$insert_noti_details);
                    
                
//     //  $sql_get_appid = "SELECT  * FROM `enviroments`";
//     //                     $sql = mysqli_query($con,$sql_get_appid);
//     //                     $data = mysqli_fetch_array($sql);
//     //                     $app_id = $data['one_signal_appid'] ?? '2de883ec-be41-4820-a517-558beee8b0ac';
                    
//                 $fields = array(
//                      'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
//                     //  'app_id' => $app_id,
//                      'include_player_ids' => $playerIdx,
//                     'data' => array("foo" => "NewMassage","Id" => $taskid),
//                     'large_icon' =>"ic_launcher_round.png",
//                     'contents' => $contentx
//                 );

//                 $fields = json_encode($fields);
               

//                 $ch = curl_init();
//                 curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
//       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
//                                                               'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'));
//                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//                 curl_setopt($ch, CURLOPT_HEADER, FALSE);
//                 curl_setopt($ch, CURLOPT_POST, TRUE);
//                 curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
//                 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

//                  $response = curl_exec($ch);
//                 curl_close($ch);
//         }        
                
                
  
    
//     if($update){
//          header("Location:../order_details.php?order_id=".$order_id."&Massage=Sucessfully updated order.");
//     }
    
    
// }


if (isset($_POST['btnSubmit_Action'])) {
//             error_reporting(E_ALL);
// ini_set('display_errors', 1);
    $status = $_POST['Action'];
    $order_id = $_POST['order_id'];
    include('../assets/connection.php');

    if ($status == 'shipped') {
        $sql = "UPDATE `orders_zee` SET `status` = '$status' WHERE `id` = $order_id";
    } elseif ($status == 'pending') {
        date_default_timezone_set('Europe/Berlin');
        $minutes_to_add = 45;
        $time = new DateTime();
        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        $datetime = $time->format('Y-m-d g:i A');
        $sql = "UPDATE `orders_zee` SET `status` = '$status', `delivered_at` = '$datetime' WHERE `id` = $order_id";
        $update = mysqli_query($con, $sql);
        
        
        
          $get_user_query = "SELECT user_id FROM orders_zee WHERE id = '$order_id'";
        $result_user = mysqli_query($con, $get_user_query);
        $row_user = mysqli_fetch_assoc($result_user);
        
        if ($row_user) {
            $user_id = $row_user['user_id'];
        
            $get_email_query = "SELECT email, name FROM users WHERE id = '$user_id'";
            $result_email = mysqli_query($con, $get_email_query);
            $row_email = mysqli_fetch_assoc($result_email);
        
            if ($row_email) {
                $email = $row_email['email'];
                $name = $row_email['name'];
                
                $mail = new PHPMailer(true);
        
                   try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'boundedsocial@gmail.com'; 
                        $mail->Password = 'iwumjedakkbledwe';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;
                    
                        $mail->setFrom('support@indianrasoi.de', 'Indian Rasoi');
                        $mail->addAddress($email); 
                    
                        $mail->isHTML(true);
                        
                        
                       $mail->Subject = "Ihre Bestellung wurde angenommen";

                        $mail->Body = '
                        <html>
                        <head>
                            <title>Ihre Bestellung wurde angenommen – Indian Rasoi</title>
                            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
                            <style>
                                body {
                                    font-family: "Poppins", Arial, sans-serif;
                                    line-height: 1.6;
                                    color: #333;
                                    padding: 20px;
                                    background-color: #f7f7f7;
                                }
                                .content {
                                    background-color: rgba(255, 255, 255, 0.95);
                                    padding: 20px;
                                    border-radius: 8px;
                                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                                }
                                h1 {
                                    color: #2B2B29;
                                    font-size: 28px;
                                    margin-bottom: 10px;
                                }
                                h3 {
                                    color: #2B2B29;
                                    font-size: 20px;
                                    margin-top: 20px;
                                }
                                p, li {
                                    color: #555;
                                    font-size: 16px;
                                    margin: 8px 0;
                                }
                                a {
                                    color: #F2AF34;
                                    text-decoration: none;
                                }
                            </style>
                        </head>
                        <body>
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'https://indianrasoi.sassolution.org/API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
                                <tr>
                                    <td align="center">
                                        <table width="100%" class="content" style="max-width: 600px;">
                                            <tr>
                                                <td align="center">
                                                    <img src="https://indianrasoi.sassolution.org/admin_panel/images/logo.png" alt="Indian Rasoi" style="width: 100px; margin-bottom: 20px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h1>Ihre Bestellung wurde angenommen!</h1>
                                                    <p>Hallo <strong>' . htmlspecialchars($name) . '</strong>,</p>
                                                    <p>Vielen Dank für Ihre Bestellung bei <strong></strong>.</p>
                                                    <p><strong>Bestellnummer:</strong> ' . htmlspecialchars($order_id) . '</p>
                                                    <p>Ihre Bestellung wurde erfolgreich angenommen und wird in Kürze bearbeitet.</p>
                                                    <h3>Was kommt als Nächstes?</h3>
                                                    <ul>
                                                        <li>Unser Team bereitet Ihre Bestellung mit größter Sorgfalt zu.</li>
                                                        <li>Sie erhalten eine Benachrichtigung, sobald Ihre Bestellung unterwegs ist.</li>
                                                    </ul>
                                                    <p>Bei Fragen stehen wir Ihnen jederzeit zur Verfügung.</p>
                                                    <p>Mit freundlichen Grüßen,<br>Ihr Indian Rasoi Team</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </body>
                        </html>';
                    
                        $mail->send();
                
                } catch (Exception $e) {
                    $data = [
                        "status" => false,
                        "Response_code" => 500,
                        "Message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
                    ];
                    echo json_encode($data);
                }

            }
        }
        
    }elseif($status == 'delivered'){
    
            $checkcashback = "SELECT * FROM cash_back WHERE status = 1";
            $execute = mysqli_query($con, $checkcashback);
            $row = mysqli_fetch_assoc($execute);
            
            if ($row) { // Check if cashback is active
                $cashback_percentage = $row['cashback_percenatge'];
            
                // Check if cashback_status is already 1
                $check_order_status = "SELECT `cashback_status` FROM `orders_zee` WHERE `id` = '$order_id'";
                $execute_status = mysqli_query($con, $check_order_status);
                $order_status_row = mysqli_fetch_assoc($execute_status);
            
               if ($order_status_row['cashback_status'] == 1) {
                    // Cashback already given, no need to proceed
                    header("Location: ../order_details.php?order_id=$order_id");
                    exit;
                }
                // Update order status and set cashback_status to 1
                $sql = "UPDATE `orders_zee` SET `status` = '$status', `cashback_status` = 1 WHERE `id` = $order_id";
                $update = mysqli_query($con, $sql);
            
                if ($update) {
                    // Fetch order total price
                    $order_details = "SELECT order_total_price FROM orders_zee WHERE `id` = '$order_id'";
                    $execute_order = mysqli_query($con, $order_details);
                    $order_row = mysqli_fetch_assoc($execute_order);
                    $total_order_amount = $order_row['order_total_price'];
            
                    // Calculate cashback amount
                    $cashback_amount = $total_order_amount * ($cashback_percentage / 100);
            
                    // Fetch user ID
                    $sql_user = "SELECT `user_id` FROM `orders_zee` WHERE `id` = '$order_id'";
                    $execute_user = mysqli_query($con, $sql_user);
                    $row_user = mysqli_fetch_assoc($execute_user);
                    $user_id = $row_user['user_id'];
            
                    // Add cashback to user wallet
                    $sqlUpdated = "UPDATE `users` SET `amount` = `amount` + $cashback_amount WHERE `id` = '$user_id'";
                    $amount_added = mysqli_query($con, $sqlUpdated);
            
                    // Insert transaction record
                    if ($amount_added) {
                        $transaction_message = $cashback_amount . ' Cashback erhalten für (Bestell-ID: ' . $order_id . ')';
                        $english_message = $cashback_amount . ' Receive cashback for (order ID: ' . $order_id . ')';
       
                        $transaction_id = rand(100000, 999999);
            
                        $sql = "INSERT INTO `tbl_transaction`(`user_id`, `transaction_id`, `amount`, `type`, `message`, `english_message`) 
                                VALUES ('$user_id','$transaction_id','$cashback_amount','credit','$transaction_message', '$english_message')";
                        $ex_sql = mysqli_query($con, $sql);
                    }
            
                    // Fetch user's notification token
                    $sql_get_user_token = "SELECT `notification_token` FROM `users` WHERE `id` = '$user_id'";
                    $result = mysqli_query($con, $sql_get_user_token);
                    $row = mysqli_fetch_assoc($result);
                    $token = $row['notification_token'];
                    
                }
            }
            
              $sql = "UPDATE `orders_zee` SET `status` = '$status' WHERE `id` = $order_id";
                $update = mysqli_query($con, $sql);

                
         $content = [
                "en" => "Sie haben eine Gutschrift von €$cashback_amount in Ihrer Brieftasche als Cashback für die Bestellung (ID: $order_id) erhalten."
            ];

            $fields = [
                        'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
                        'include_player_ids' => [$token], 
                        'data' => ["foo" => "NewMessage"],
                        'large_icon' => "ic_launcher_round.png",
                        'contents' => $content
                    ];
                    
            $fields = json_encode($fields);
                    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebnd7ohwrgq5huhen2yfaytan73n45db4ovkcrwwdr2g4xsmwa3flzui3ih3pk65hgjfsjxo2vwnnagwy'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    
            $response = curl_exec($ch);
            curl_close($ch);
            
            
            $insert_noti_details = "INSERT INTO `notification` (`user_id`, `content`, `purpose`) VALUES ('$user_id', '$content', 'order')";
            mysqli_query($con, $insert_noti_details);
            
            
            
                            
            $get_user_query = "SELECT user_id FROM orders_zee WHERE id = '$order_id'";
            $result_user = mysqli_query($con, $get_user_query);
            $row_user = mysqli_fetch_assoc($result_user);
            
            if ($row_user) {
                $user_id = $row_user['user_id'];
            
                // Fetch email and name of user from users table
                $get_email_query = "SELECT email, name FROM users WHERE id = '$user_id'";
                $result_email = mysqli_query($con, $get_email_query);
                $row_email = mysqli_fetch_assoc($result_email);
            
                if ($row_email) {
                    $email = $row_email['email'];
                    $name = $row_email['name'];
                    
                    $mail = new PHPMailer(true);
            
                    try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'boundedsocial@gmail.com'; 
                            $mail->Password = 'iwumjedakkbledwe';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;
                        
                            $mail->setFrom('support@indianrasoi.de', 'Indian Rasoi');
                            $mail->addAddress($email); 
                        
                            $mail->isHTML(true);
                           $mail->Subject = "Ihre Bestellung wurde geliefert";

                        $mail->Body = '
                        <html>
                        <head>
                            <title>Ihre Bestellung wurde geliefert – Indian Rasoi</title>
                            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
                            <style>
                                body {
                                    font-family: "Poppins", Arial, sans-serif;
                                    line-height: 1.6;
                                    color: #333;
                                    padding: 20px;
                                    background-color: #f7f7f7;
                                }
                                .content {
                                    background-color: rgba(255, 255, 255, 0.95);
                                    padding: 20px;
                                    border-radius: 8px;
                                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                                }
                                h1 {
                                    color: #2B2B29;
                                    font-size: 28px;
                                    margin-bottom: 10px;
                                }
                                h3 {
                                    color: #2B2B29;
                                    font-size: 20px;
                                    margin-top: 20px;
                                }
                                p, li {
                                    color: #555;
                                    font-size: 16px;
                                    margin: 8px 0;
                                }
                                a {
                                    color: #F2AF34;
                                    text-decoration: none;
                                }
                            </style>
                        </head>
                        <body>
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'https://indianrasoi.sassolution.org/API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
                                <tr>
                                    <td align="center">
                                        <table width="100%" class="content" style="max-width: 600px;">
                                            <tr>
                                                <td align="center">
                                                    <img src="https://indianrasoi.sassolution.org/admin_panel/images/logo.png" alt="Indian Rasoi" style="width: 100px; margin-bottom: 20px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h1>Ihre Bestellung wurde geliefert!</h1>
                                                    <p>Hallo <strong>' . htmlspecialchars($user_name) . '</strong>,</p>
                                                    <p>Wir freuen uns, Ihnen mitteilen zu können, dass Ihre Bestellung erfolgreich geliefert wurde.</p>
                                                    <p><strong>Bestellnummer:</strong> #' . htmlspecialchars($order_id) . '</p>
                                                    <h3>Guten Appetit!</h3>
                                                    <p>Wir hoffen, dass Sie Ihr Essen genießen. Vielen Dank, dass Sie bei <strong>Indian Rasoi</strong> bestellt haben.</p>
                                                    <p>Wenn Sie Fragen haben oder Feedback geben möchten, stehen wir Ihnen jederzeit zur Verfügung.</p>
                                                    <p>Mit freundlichen Grüßen,<br>Ihr Indian Rasoi Team</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </body>
                        </html>';

                    $mail->send();
    
                        } catch (Exception $e) {
                            $data = [
                                "status" => false,
                                "Response_code" => 500,
                                "Message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
                            ];
                            echo json_encode($data);
                        }

                }
            }
            
    }

    $sql_get_user_id = "SELECT `user_id` FROM `orders_zee` WHERE `id` = '$order_id'";
    $execute_get_user_id = mysqli_query($con, $sql_get_user_id);
    $user_data = mysqli_fetch_assoc($execute_get_user_id);
    $get_user_id = $user_data['user_id'];

    if ($get_user_id) {
        $sqltaskMembersx = "SELECT `notification_token` FROM `users` WHERE `id` = '$get_user_id'";
        $taskMembersx = mysqli_query($con, $sqltaskMembersx);
        $playerIdx = [];
        while ($row = mysqli_fetch_assoc($taskMembersx)) {
            array_push($playerIdx, $row['notification_token']);
        }

     $order_content = match ($status) {
    'pending' => [
        'de' => "Ihre Bestellung Nr: $order_id wurde angenommen. Die voraussichtliche Lieferzeit ist $datetime.",
        'en' => "Your order no: $order_id has been accepted. The estimated delivery time is $datetime."
    ],
    'shipped' => [
        'de' => "Ihre Bestellung Nr: $order_id wurde versandt.",
        'en' => "Your order no: $order_id has been shipped."
    ],
    default => [
        'de' => "Ihre Bestellung Nr: $order_id ist jetzt $status.",
        'en' => "Your order no: $order_id is now $status."
    ]
};

// Escape values for safe SQL insertion
$de_content = mysqli_real_escape_string($con, $order_content['de']);
$en_content = mysqli_real_escape_string($con, $order_content['en']);

        $insert_noti_details = "INSERT INTO `notification` (`user_id`, `content`, `german_content`,`purpose`) VALUES ('$get_user_id', '$en_content', '$de_content', 'order')";
        mysqli_query($con, $insert_noti_details);

        $fields = json_encode([
            'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
            'include_player_ids' => $playerIdx,
            'data' => ["foo" => "NewMassage", "Id" => $order_id],
            'large_icon' => "ic_launcher_round.png",
            'contents' => ["en" => $order_content]
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic os_v2_app_asdjgef7prhj3hwj7l2yvlebnd7ohwrgq5huhen2yfaytan73n45db4ovkcrwwdr2g4xsmwa3flzui3ih3pk65hgjfsjxo2vwnnagwy'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
    }

    if ($update){ 
        header("Location: ../order_details.php?order_id=$order_id&Massage=Sucessfully updated order.");
        
    }
}























if(isset($_POST['updateCategory'])){
    include('../assets/connection.php');
    
    $ProName = mysqli_real_escape_string($con,$_POST['ProName']);
    $product_id = $_POST['product_id'];
    $sql = "UPDATE `categories` SET `name` = '$ProName' WHERE `id` = $product_id";
    $update = mysqli_query($con,$sql);
    if($update){
         header("Location:../viewcategories.php?Massage=Sucessfully updated category.");
    }
}

// if(isset($_POST['updateSubCategory'])){
//      include('../assets/connection.php');
//     $ProName = mysqli_real_escape_string($con, $_POST['ProName']);
//     $product_id = $_POST['product_id'];
//     $sql = "UPDATE `sub_categories` SET `name` = '$ProName' WHERE `id` = $product_id";
//     $update = mysqli_query($con,$sql);
//     if($update){
//          header("Location:../SubCat.php?Massage=Sucessfully updated sub category.");
//     }
// }

if (isset($_POST['updateSubCategory'])) {
//         error_reporting(E_ALL);
// ini_set('display_errors', 1);
  include('../assets/connection.php');
  $ProName = mysqli_real_escape_string($con, $_POST['ProName']);
  $product_id = $_POST['product_id'];
  $banner_image = $_POST['banner_image'];


    $target_dir = "../Uploads/";
    $target_file = $target_dir . basename($_FILES["banner_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $filewithnewname = date("Ymdis") . "_banner." . $imageFileType;
    move_uploaded_file($_FILES["banner_image"]["tmp_name"], $target_dir . $filewithnewname);
      "The file " . htmlspecialchars(basename($_FILES["banner_image"]["name"])) . " has been uploaded.";

      $sql = "UPDATE `sub_categories` SET `name` = '$ProName', `banner_image` = '$filewithnewname' WHERE `id` = $product_id";
      $update = mysqli_query($con, $sql);
      if ($update) {
        header("Location:../SubCat.php?Massage=Sucessfully updated sub category.");
      }
  
}


if (isset($_POST['btnSubmit_insertAreas'])) {

    $PostalCode = $_POST['PostalCode'];
    $minorderprice = $_POST['minorderprice'];
    $branch_id = $_POST['branch_id']; 

    include('../assets/connection.php');


    $sql = "INSERT INTO `tbl_areas` (`area_name`, `min_order_amount`, `branch_id`) 
            VALUES ('$PostalCode', '$minorderprice', '$branch_id')";
            
    $insert = mysqli_query($con, $sql);

    if ($insert) {
        header("Location:../addareas.php?Massage=Sucessfully added new area.");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

if(isset($_POST['updateProduct'])){
//     error_reporting(E_ALL);
// ini_set('display_errors', 1);
    include('../assets/connection.php');
    include('../assets/config.php'); 
    $product_id = $_POST['product_id'];
    $ProName = mysqli_real_escape_string($con,$_POST['ProName']);
    $ProDes = mysqli_real_escape_string($con,$_POST['ProDes']);
    $ProCost = $_POST['ProCost'];
    $ProPrice = $_POST['ProPrice'];
    $ProDis = $_POST['ProDis'];
    $features = $_POST['features'];
    $status = mysqli_real_escape_string($con,$_POST['status']);
    $tax = mysqli_real_escape_string($con,$_POST['tax']);
    $sku_id = mysqli_real_escape_string($con,$_POST['sku_id']);
    
    
    // $addon = $_POST['addon'];
    // $types = $_POST['types'];
    // $dressing = $_POST['dressing'];
    
    
    $sql = "UPDATE `products` SET `name`='$ProName',`description`='$ProDes',`cost`=$ProCost,`price`=$ProPrice,`discount`=$ProDis , `features` = '$features',  `status` = '$status', `sku_id`= '$sku_id',     `tax` = '$tax'  WHERE `id`=$product_id";
    $update = mysqli_query($con,$sql);
    
    
    if($update){
         $monitor_sql = "INSERT INTO `website_requests` (`website_name`, `status`, `created_at`, `updated_at`) 
                        VALUES ('haveliresturant', '1' ,NOW(),NOW())";
        $monitor_update = mysqli_query($con, $monitor_sql);

        if ($monitor_update) {
            header("Location:../manageproducts.php?&Massage=Sucessfully updated product.");
        } else {
            die("Error updating monitoring database: " . mysqli_error($monitor_con));
        }
        
        
    }
}


if(isset($_POST['updatefeaturedProduct'])){
    $addon_id = $_POST['product_id'];
    $addon_name = $_POST['Addon_name'];
    $addon_price = $_POST['Addon_price'];
    include('../assets/connection.php');
    $sql = "UPDATE `add_on` SET `addon_name`='$addon_name',`addon_price`='$addon_price' WHERE `id`=$addon_id";
    $update = mysqli_query($con,$sql);
    if($update){
         header("Location:../manage_addons.php?&Massage=Sucessfully updated product.");
    }
}


// ZEE
if(isset($_POST['updateSubAddon'])){
    
    include('../assets/connection.php');
    $addon_id = $_POST['as_id'];
    
    $addon_title = $_POST['ao_title'];
    
    $addon_name = mysqli_real_escape_string($con, $_POST['as_name']);
    
    $addon_price = $_POST['as_price'];
    $sql = "UPDATE `addon_sublist` SET `ao_title`='$addon_title',`as_name`='$addon_name',`as_price`='$addon_price' WHERE `as_id`=$addon_id";
    $update = mysqli_query($con,$sql);
    if($update){
         header("Location:../view_addons.php?&Massage=Sucessfully updated Addons.");
    }
}


/*update adon title*/




/*end*/


/*update variation title*/


if(isset($_POST['updateVariationTitle'])){
    include('../assets/connection.php');
    
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($con,$_POST['title']);
    
    $sql = "UPDATE `variation` SET `title`= '$title' WHERE id = $id";
    $update = mysqli_query($con,$sql);
    if($update){
         header("Location:../managevariations.php?&Massage=Sucessfully updated variation title.");
    }
}


/*end*/


//updateSubTypes
if(isset($_POST['updateSubTypes'])){
    include('../assets/connection.php');
    
    $ts_id = $_POST['ts_id'];
     $t_id = $_POST['t_id'];
    // $type_title = $_POST['type_title'];
    
    $type_title_user = $_POST['type_title_user'];
    
    $ts_name = mysqli_real_escape_string($con, $_POST['ts_name']);
    $type_title = mysqli_real_escape_string($con, $_POST['type_title']);
    
    $sql = "UPDATE `types_sublist` SET `type_title`='$type_title',`type_title_user`='$type_title_user',`ts_name`='$ts_name' WHERE `ts_id`=$ts_id";
    $update = mysqli_query($con,$sql);
    if($update){
         header("Location:../update_types.php?id=".$t_id."&Massage=Sucessfully updated Types.");
    }
}



//updateSubTypes
if(isset($_POST['updateSubVariation']))
{
    include('../assets/connection.php');
    
    $id = $_POST['id'];
    $pro_id = $_POST['name'];
    $sub_title = mysqli_real_escape_string($con, $_POST['sub_title']);
    
    // echo $pro_id;
    // die();
    
    $sql = "UPDATE `variation_with_product` SET `product_id`= $pro_id,`sub_title`= '$sub_title' WHERE `id`= $id";
    $update = mysqli_query($con,$sql);
    if($update){
         header("Location:../managevariations.php?&Massage=Sucessfully updated Types.");
    }
}
//end

//updateSubDressings

if(isset($_POST['updateSubDressings'])){
    
    include('../assets/connection.php');
    
    $ds_id = $_POST['ds_id'];
     $d_id = $_POST['d_id'];
    //  $dressing_title = $POST['dressing_title'];
    
     $dressing_title_user = '';
    
    $dressing_name = mysqli_real_escape_string($con,$_POST['dressing_name']);
        $dressing_title = mysqli_real_escape_string($con,$_POST['dressing_title']);
    
    $sql = "UPDATE `dressing_sublist` SET `dressing_title`='$dressing_title',`dressing_title_user`='$dressing_title_user',`dressing_name`='$dressing_name' WHERE `ds_id`=$ds_id";
    $update = mysqli_query($con,$sql);
    if($update){
         header("Location:../update_dressing.php?id=".$d_id."&Massage=Sucessfully updated Dressing.");
    }
}


// ZEE


if(isset($_POST['updateInventory'])){
    
    include('../assets/connection.php');
    
    $Type = $_POST['Type'];
 
    if($Type == "add"){
       $availabale_qty = $_POST['old_qty'];
       $product_id= $_POST['product_id'];
       $newqty = $_POST['newqty'] + $availabale_qty;
         $sql = "UPDATE `products` SET `qty` = $newqty Where `id` = $product_id";
        $update = mysqli_query($con,$sql);
        if($update){
             $sqladd = "INSERT INTO `stock_log`(`product_id`, `qty`, `type`) VALUES ($product_id,$newqty,'$Type')";
             $add = mysqli_query($con,$sqladd);
             if($add){
                 header("Location:../manageinventory.php?Massage=Sucessfully updated inventory."); 
             }
            
        }
        
        
    }else if($Type == "sub"){
        $availabale_qty = $_POST['old_qty'];
       $product_id= $_POST['product_id'];
       $newqty = $availabale_qty - $_POST['newqty'];
       include('../assets/connection.php');
         $sql = "UPDATE `products` SET `qty` = $newqty Where `id` = $product_id";
        $update = mysqli_query($con,$sql);
        if($update){
             $sqladd = "INSERT INTO `stock_log`(`product_id`, `qty`, `type`) VALUES ($product_id,$newqty,'$Type')";
             $add = mysqli_query($con,$sqladd);
             if($add){
                 header("Location:../manageinventory.php?Massage=Sucessfully updated inventory."); 
             }
            
        }
        
    }
    
}
  
if(isset($_POST['btnSubmit_privacypolicy'])){
    $privacy = $_POST['privacy'];

       include('../assets/connection.php');

             $sqladd = "INSERT INTO `privacy_policy`(`privacy`) VALUES ('$privacy')";
             $add = mysqli_query($con,$sqladd);
             if($add){
                 header("Location:../managePoints.php?Massage=Sucessfully updated points."); 
           
            
        }
        

    
}

// if(isset($_POST['btnSubmit_insertTimings'])){
//     // $timings = $_POST;
//     $Mon_start_time=$_POST['Mon_start_time'];
//     $Mon_end_time=$_POST['Mon_end_time'];
//     $Tue_start_time=$_POST['Tue_start_time'];
//     $Tue_end_time=$_POST['Tue_end_time'];
//     $Wed_start_time=$_POST['Wed_start_time'];
//     $Wed_end_time=$_POST['Wed_end_time'];
//     $Thur_start_time=$_POST['Thr_start_time'];
//     $Thur_end_time=$_POST['Thr_end_time'];
//     $Fri_start_time=$_POST['Fri_start_time'];
//     $Fri_end_time=$_POST['Fri_end_time'];
//     $Sat_start_time=$_POST['Sat_start_time'];
//     $Sat_end_time=$_POST['Sat_end_time'];
//     $Sun_start_time=$_POST['Sun_start_time'];
//     $Sun_end_time=$_POST['Sun_end_time'];
//     // var_dump($_POST);
//     // die();

//         include('../assets/connection.php');
//         $sqlupdate1 = "UPDATE `tbl_working_hours` SET `start_time` = '$Mon_start_time' , `end_time` = '$Mon_end_time' WHERE `day` = 'Mon'";
//         $update = mysqli_query($con,$sqlupdate1);
        
//         $sqlupdate2 = "UPDATE `tbl_working_hours` SET `start_time`= '$Tue_start_time', `end_time`='$Tue_end_time' WHERE day='Tue'";
//         $update = mysqli_query($con,$sqlupdate2);
        
//         echo $sqlupdate3 = "UPDATE `tbl_working_hours` SET `start_time`='$Wed_start_time', `end_time`='$Wed_end_time' WHERE day='Wed'";
//         $update = mysqli_query($con,$sqlupdate3);
        
//          $sqlupdate4 = "UPDATE `tbl_working_hours` SET `start_time`='$Thur_start_time', `end_time`='$Thur_end_time' WHERE day='Thu'";
//         $update = mysqli_query($con,$sqlupdate4);
        
//         echo $sqlupdate5 = "UPDATE `tbl_working_hours` SET `start_time`='$Fri_start_time', `end_time`='$Fri_end_time' WHERE day='Fri'";
//         $update = mysqli_query($con,$sqlupdate5);
        
//         echo $sqlupdate6 = "UPDATE `tbl_working_hours` SET `start_time`='$Sat_start_time', `end_time`='$Sat_end_time' WHERE day='Sat'";
//         $update = mysqli_query($con,$sqlupdate6);
        
//         echo $sqlupdate7 = "UPDATE `tbl_working_hours` SET `start_time`='$Sun_start_time', `end_time`='$Sun_end_time' WHERE day='Sun'";
//         $update = mysqli_query($con,$sqlupdate7);
         
//         if($update){
//             header("Location:../managetimings.php?Massage=Sucessfully updated timings."); 
//         }
    
// }


if (isset($_POST['btnSubmit_insertTimings'])) {
    include('../assets/connection.php');

    // Get is_open status
    $is_open = isset($_POST['is_open']) ? 1 : 0;

    // Update or insert into your settings table
    $check = mysqli_query($con, "SELECT * FROM `system_setting` LIMIT 1");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($con, "UPDATE `system_setting` SET `is_open` = $is_open");
    } else {
        mysqli_query($con, "INSERT INTO `system_setting` (`is_open`) VALUES ($is_open)");
    }

    // Days list
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    foreach ($days as $day) {
        $dayKey = strtolower(substr($day, 0, 3)); // mon, tue, etc.

        $from1 = $_POST[$dayKey . '_from1'] ?? '00:00:00';
        $to1   = $_POST[$dayKey . '_to1'] ?? '00:00:00';
        $from2 = $_POST[$dayKey . '_from2'] ?? '00:00:00';
        $to2   = $_POST[$dayKey . '_to2'] ?? '00:00:00';

        $is_holiday = isset($_POST[$dayKey . '_holiday']) ? 1 : 0;

        // Check if record exists
        $check = mysqli_query($con, "SELECT id FROM tbl_working_hours WHERE day = '$day'");
        if (mysqli_num_rows($check) > 0) {
            // Update
            $update = mysqli_query($con, "
                UPDATE tbl_working_hours 
                SET start_time_1 = '$from1', end_time_1 = '$to1',
                    start_time_2 = '$from2', end_time_2 = '$to2',
                    is_holiday = '$is_holiday'
                WHERE day = '$day'
            ");
        }
    }

  header("Location:../managetimings.php?Massage=Sucessfully updated timings."); 
}


if(isset($_POST['btnSubmit_termscondition'])){
    $privacy = $_POST['terms'];

       include('../assets/connection.php');

             $sqladd = "INSERT INTO `terms_condition`(`terms_condition`) VALUES ('$privacy')";
             $add = mysqli_query($con,$sqladd);
             if($add){
                 header("Location:../managePoints.php?Massage=Sucessfully updated points."); 
           
            
        }
        

    
}
// function sendMessage($userid){
//     require 'connection.php';
//     $sqltaskMembers = "SELECT `id`, `role_id`, `name`, `phone`, `email`, `email_verified_at`, `password`, `notification_token`, `remember_token`, `rewards_token`, `created_at`, `updated_at` FROM `users` WHERE `id` = $userid";
//         $taskMembers = mysqli_query($con,$sqltaskMembers);
//         $playerId = [];
//         $subject = '';
//         while($row = mysqli_fetch_array($taskMembers)){
//         	     $subject =  $row['firstname'];
//                  array_push($playerId, '1913aa90-d6ce-40b5-8480-f17595f18ab6');           
//             }
            
//                 $content = array(
//                     "en" => ' you got new message '.$subject.'.'
//                     );

//                 $fields = array(
//                     'app_id' => "04869310-bf7c-4e9d-9ec9-faf58aac8168",
//                      'include_player_ids' => $playerId,
//                     'data' => array("foo" => "NewMassage","Id" => $taskid),
//                     'large_icon' =>"ic_launcher_round.png",
//                     'contents' => $content
//                 );

//                 $fields = json_encode($fields);
               

//                 $ch = curl_init();
//                 curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
//                 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
//                                                           'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'));
//                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//                 curl_setopt($ch, CURLOPT_HEADER, FALSE);
//                 curl_setopt($ch, CURLOPT_POST, TRUE);
//                 curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
//                 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

//                  $response = curl_exec($ch);
//                 curl_close($ch);

               


        
           
               
// }


// if (isset($_POST['updateDeals'])) {
//     include('../assets/connection.php');

//     // Retrieve form data
//     $deal_id = $_POST['deal_id'];
//     $deal_name = $_POST['deal_name'];
//     $deal_description = $_POST['deal_description'];
//     $deal_cost = $_POST['deal_cost'];
//     $deal_price = $_POST['deal_price'];
//     $deal_items_number = $_POST['deal_items_number'];
//     $status = $_POST['status'];

//     // Check for image upload
//     $image_path = '';
//     if (isset($_FILES['deal_image']) && $_FILES['deal_image']['error'] == 0) {
//         $target_dir = "../Uploads/";
//         $image_path = $target_dir . basename($_FILES['deal_image']['name']);
//         move_uploaded_file($_FILES['deal_image']['tmp_name'], $image_path);
//     }

//     // Prepare SQL update statement
//     $sql = "UPDATE `deals` SET `deal_name`='$deal_name', `deal_description`='$deal_description', `deal_cost`='$deal_cost', `deal_price`='$deal_price', `deal_items_number`='$deal_items_number', `status`='$status'";
    
//     if ($image_path) {
//         $sql .= ", `deal_image`='$image_path'";
//     }
    
//     $sql .= " WHERE `deal_id`='$deal_id'";

//     // Execute the SQL update statement
//     if (mysqli_query($con, $sql)) {
//         // If the update is successful, show an alert and redirect
//         echo "<script>
//                 alert('Update successfully');
//                 window.location.href='../view_deals.php';
//               </script>";
//     } else {
//         // If the update fails, show an error
//         echo "<script>
//                 alert('Error updating record: " . mysqli_error($con) . "');
//               </script>";
//     }
// }

if (isset($_POST['updateDeals'])) {
    include('../assets/connection.php');

    // Deal data
    $deal_id = $_POST['deal_id'];
    $deal_name = $_POST['deal_name'];
    $deal_description = $_POST['deal_description'];
    $deal_cost = $_POST['deal_cost'];
    $deal_price = $_POST['deal_price'];
    $deal_items_number = $_POST['deal_items_number'];
    $status = $_POST['status'];

    // Image handling
    $image_path = '';
    if (isset($_FILES['deal_image']) && $_FILES['deal_image']['error'] == 0) {
        $filename = basename($_FILES['deal_image']['name']);
        $target_dir = "../Uploads/";
        $filepath = $target_dir . $filename;

        if (move_uploaded_file($_FILES['deal_image']['tmp_name'], $filepath)) {
            // Save relative path only
            $image_path =  $filename;
        }
    }

    // Update main deal record
    $sql = "UPDATE `deals` SET  
                `deal_name`='$deal_name',  
                `deal_description`='$deal_description',  
                `deal_cost`='$deal_cost', 
                `deal_price`='$deal_price', 
                `deal_items_number`='$deal_items_number', 
                `status`='$status'";
    if ($image_path) {
        $sql .= ", `deal_image`='$image_path'";
    }
    $sql .= " WHERE `deal_id`='$deal_id'";

    $success = mysqli_query($con, $sql);

    // Update each deal item

        foreach ($_POST['deal_title'] as $i => $title) {
            $freeItems = $_POST['num_free_items'][$i];
            $selectedProducts = isset($_POST['checkboxid'][$i]) ? $_POST['checkboxid'][$i] : [];
            $deal_subdata = json_encode(['product_id' => $selectedProducts]);
            $itemId = isset($_POST['deal_item_ids'][$i]) ? $_POST['deal_item_ids'][$i] : '';

            if (!empty($itemId)) {
                $update = "UPDATE `deal_items` SET 
                                `di_title`='$title', 
                                `di_num_free_items`='$freeItems', 
                                `deal_subdata`='$deal_subdata' 
                           WHERE `di_id` = '$itemId'";
                mysqli_query($con, $update);
            }
        }

        echo "<script>
                alert('Deal and items updated successfully');
                window.location.href='../view_deals.php';
              </script>";
   
}


?>