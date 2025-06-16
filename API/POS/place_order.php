<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require __DIR__ . '/../vendor/autoload.php';
use Pusher\Pusher;


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $user_id = $_POST['user_id'];
  $name = $_POST['name'];
  $username = $_POST['user_name'];
  $phone = $_POST['phone'];
  $Shipping_address = $_POST['Shipping_address'];
  $Shipping_address_2 = $_POST['Shipping_address_2'];
  $Shipping_city = $_POST['city'];
  $Shipping_area = str_replace("undefined", "", $_POST['Shipping_area']);
  $Shipping_state = str_replace("undefined", "", $_POST['Shipping_state']);
  $Shipping_postal_code = $_POST['postal_code'];
  $House_number = $_POST['house_no'];
  $street = $_POST['street'];
  $password = 'demo123';
  $payment_type = $_POST['payment_type'];
  $amount_received = $_POST['amount_received'];
  $amount_return = $_POST['amount_return'];
  $total_amount = $_POST['total_amount'];
  $order_details = json_decode($_POST['order_details'], true);
  $paymentstatus = $_POST['payment_status'];
  $shipping_cost = $_POST['shipping_cost'];
  $branch_id = $_POST['branch_id'];
  $additional_notes = $_POST['addtional_notes'];
  $tbl_id = $_POST['table_id'];
  $total_netto_tax = $_POST['total_netto_tax'];
  $total_metto_tax = $_POST['total_metto_tax'];
  $order_status = $_POST['order_status'] ?? 'neworder';
  $order_type = $_POST['order_type'];
  $total_discount = $_POST['total_discount'];
  $wallet_balance = $_POST['wallet_balance'];
  $payment_method = $_POST['payment_method'];
  $transaction_id = $_POST['transaction_id'];
  $platform = $_POST['platform'];
$ordersheduletype = $_POST['ordersheduletype'];
$sheduletime = $_POST['sheduletime'] . ":00";
  
  
    date_default_timezone_set('Europe/Berlin');
    $datetime = date('Y-m-d H:i:s', time());

  if ($tbl_id) {
    $sql_order = "INSERT INTO `orders_zee`(`table_id`, `status`, `payment_type`, `order_total_price`, `payment_status`, `branch_id`, `total_netto_tax`,`total_metto_tax`, `order_type`, `platform` ) 
                  VALUES ('$tbl_id', '$order_status', '$payment_type', '$total_amount', '$paymentstatus', '$branch_id', '$total_netto_tax', '$total_metto_tax', '$order_type', '$platform')";
    $result_order = mysqli_query($conn, $sql_order);

    if ($result_order) {
      $last_order_id = $conn->insert_id;
      $no_of_deal = 1;

      foreach ($order_details as $details) {
        if ($details['is_deal'] == "yes") {
          $deal_id = $details['deal_id'];
          $deal_qty = $details['deal_qty'];
          $no_of_deal++;

          foreach ($details['deal_items'] as $deal_item) {
            $item_id = $deal_item['item_id'];

            foreach ($deal_item['items_products'] as $product) {
              $product_id = $product['prod_id'];

              $addons = mysqli_real_escape_string($conn, json_encode($product['addons'], JSON_UNESCAPED_UNICODE));
              $types = mysqli_real_escape_string($conn, json_encode($product['types'], JSON_UNESCAPED_UNICODE));
              $dressing = mysqli_real_escape_string($conn, json_encode($product['dressing'], JSON_UNESCAPED_UNICODE));

              $sql_getitems = "SELECT `deal_cost`, `deal_price` FROM `deals` WHERE `deal_id` = $deal_id";
              $execute_get_products = mysqli_query($conn, $sql_getitems);

              if ($execute_get_products) {
                $deal_details = mysqli_fetch_array($execute_get_products);
                $cost = $deal_details['deal_cost'];
                $price = $deal_details['deal_price'];
                
                $sql_getpro = "SELECT * FROM `products` WHERE `id` = '$product_id'";
                $ex_get_pro = mysqli_query($conn,$sql_getpro);
                $product = mysqli_fetch_array($ex_get_pro);
                $pro_name = $product['name'];
                  $pro_decs = $product['description'];

                $order_details_insert = "INSERT INTO `order_details_zee`(`order_id`, `deal_id`, `deal_item_id`, `product_id`, `product_name`,`product_description`,  `qty`, `cost`, `price`, `addons`, `types`, `dressing`, `no_of_deal`) 
                                                     VALUES ('$last_order_id', '$deal_id', '$item_id', '$product_id', '$pro_name','$pro_decs', '$deal_qty', '$cost', '$price', '$addons', '$types', '$dressing', '$no_of_deal')";
                $execute_details_insert = mysqli_query($conn, $order_details_insert);



                if (!$execute_details_insert) {
                  echo json_encode(["statusCode" => 201, "message" => "Failed to insert deal order details", "error" => mysqli_error($conn)]);
                  exit;
                }
              } else {
                echo json_encode(["statusCode" => 201, "message" => "Failed to fetch product details", "error" => mysqli_error($conn)]);
                exit;
              }
            }
          }
        } else {
          $product_id = $details['id'];
          $product_qty = $details['qty'];

          $product_addons = mysqli_real_escape_string($conn, json_encode($details['addons'], JSON_UNESCAPED_UNICODE));
          $product_types = mysqli_real_escape_string($conn, json_encode($details['types'], JSON_UNESCAPED_UNICODE));
          $product_dressing = mysqli_real_escape_string($conn, json_encode($details['dressing'], JSON_UNESCAPED_UNICODE));

          $get_product_details = "SELECT `id`, `cost`, `price` FROM `products` WHERE `id`= $product_id";
          $execute_get_products = mysqli_query($conn, $get_product_details);

          if ($execute_get_products) {
            $product_details = mysqli_fetch_array($execute_get_products);
            $cost = $product_details['cost'];
            $price = $product_details['price'];
            
            $sql_getpro = "SELECT * FROM `products` WHERE `id` = '$product_id'";
            $ex_get_pro = mysqli_query($conn,$sql_getpro);
            $product = mysqli_fetch_array($ex_get_pro);
            $pro_name = $product['name'];
              $pro_decs = $product['description'];

            $order_details_insert = "INSERT INTO `order_details_zee`(`order_id`, `product_id`,`product_name`, `product_description` ,`qty`, `cost`, `price`, `addons`, `types`, `dressing`) 
                                             VALUES ('$last_order_id', '$product_id', '$pro_name','$pro_decs','$product_qty', '$cost', '$price', '$product_addons', '$product_types', '$product_dressing')";
            $execute_details_insert = mysqli_query($conn, $order_details_insert);


            if (!$execute_details_insert) {
              echo json_encode(["statusCode" => 201, "message" => "Failed to insert order details", "error" => mysqli_error($conn)]);
              exit;
            }
          } else {
            echo json_encode(["statusCode" => 201, "message" => "Failed to fetch product details", "error" => mysqli_error($conn)]);
            exit;
          }
        }
      }

      // Update table status
      $sql = "UPDATE `tables` SET `status`='available' , `occupied_at` = NULL WHERE `id` = '$tbl_id'";
      $execute = mysqli_query($conn, $sql);

      if ($execute) {
        $started_at = date('Y-m-d H:i:s');
        $uptsql = "UPDATE `tables_details` SET `ended_at`='$started_at' WHERE `tbl_id` = '$tbl_id'";
        $execute = mysqli_query($conn, $uptsql);

        $execute_tbl_order = "UPDATE `tables_order_details` SET `status`= 'complete' WHERE tbl_id='$tbl_id'";
        $ex = mysqli_query($conn, $execute_tbl_order);
        if (!$execute) {
          echo json_encode(["statusCode" => 201, "message" => "Failed to update table details", "error" => mysqli_error($conn)]);
          exit;
        }
      } else {
        echo json_encode(["statusCode" => 201, "message" => "Failed to update table status", "error" => mysqli_error($conn)]);
        exit;
      }

      echo json_encode(["statusCode" => 200, "message" => "Order created successfully", "order_id" => $last_order_id]);
    } else {
      echo json_encode(["statusCode" => 201, "message" => "Failed to create order", "error" => mysqli_error($conn)]);
    }
  } elseif (!empty($name)) {
    // Check if the user already exists
    $check_user = "SELECT `id`, `phone` FROM `users` WHERE `phone` = '$phone'";
    $result_check_user = mysqli_query($conn, $check_user);
    
    
    if (mysqli_num_rows($result_check_user) > 0) {
      echo json_encode(array("statusCode" => 201, "message" => "User already exists"));
    } else {
      // Insert new user
      $sql_insert_user = "INSERT INTO `users`(`role_id`, `name`, `phone`, `email`, `password`, `street`, `postal_code`, `city`, `house_no`) 
                            VALUES (3, '$name', '$phone', null, '$password', '$street', '$Shipping_postal_code', '$Shipping_city', '$House_number')";
      $result_user = mysqli_query($conn, $sql_insert_user);

      if ($result_user) {
        $last_user_id = $conn->insert_id;

        if ($wallet_balance) {
          $sql_check_wallet = "SELECT `amount` FROM `users` WHERE `id` = '$user_id'";
          $result_check_wallet = mysqli_query($conn, $sql_check_wallet);
          $row_wallet = mysqli_fetch_assoc($result_check_wallet);

          if ($row_wallet && isset($row_wallet['amount'])) {
            $current_balance = $row_wallet['amount'];

            if ($wallet_balance > $current_balance) {
              // If wallet balance is greater than available amount, show error
              $response = [
                "status" => false,
                "Response_code" => 400,
                "Message" => "Insufficient wallet balance"
              ];
              echo json_encode($response);
              exit;
            }

            // Deduct the balance
            $sql_update_wallet = "UPDATE `users` SET `amount` = `amount` - $wallet_balance WHERE `id` = '$user_id'";
            mysqli_query($conn, $sql_update_wallet);
            
            $transaction_message = "Abzug von €$wallet_balance vom Guthaben";

            $rand_id  = rand(000000, 10000000);

            $sql = "INSERT INTO `tbl_transaction` (`user_id`, `transaction_id`, `amount`, `type`, `message`) 
                VALUES ('$user_id', '$rand_id', '$wallet_balance', 'debit', '$transaction_message')";

            $ex_sql = mysqli_query($conn, $sql);

          } else {
            // If amount column is not found
            $response = ["status" => false,"Response_code" => 400,"Message" => "Wallet balance not found"];
            echo json_encode($response);
            exit;
          }
        }

        // Insert order details
        $sql_order = "INSERT INTO `orders_zee`(`user_id`, `status`, `payment_type`, `order_total_price`, `payment_status`, `Shipping_address`, `Shipping_address_2`, 
                            `Shipping_city`, `Shipping_postal_code`, `Shipping_Cost`, `branch_id`, `addtional_notes`, `total_netto_tax`, `total_metto_tax`, `total_discount`,`payment_method`, `transaction_id`, `platform`, `ordersheduletype`, `sheduletime`) 
                          VALUES ($last_user_id, '$order_status', '$payment_type', '$total_amount', '$paymentstatus', '$Shipping_address', '$Shipping_address_2', 
                            '$Shipping_city', '$Shipping_postal_code', '$shipping_cost', '$branch_id', '$additional_notes', '$total_netto_tax', '$total_metto_tax', '$total_discount', '$payment_method', '$transaction_id', '$platform','$ordersheduletype', '$sheduletime')";

        $result_order = mysqli_query($conn, $sql_order);

        if ($result_order) {

            $last_order_id = $conn->insert_id;
          
          $no_of_deal = 1;

          foreach ($order_details as $details) {
            if ($details['is_deal'] == "yes") {
              $deal_id = $details['deal_id'];
              $deal_qty = $details['deal_qty'];
              $no_of_deal++;

              foreach ($details['deal_items'] as $deal_item) {
                $item_id = $deal_item['item_id'];

                foreach ($deal_item['items_products'] as $product) {
                  $product_id = $product['prod_id'];
                  $addons = mysqli_real_escape_string($conn, json_encode($product['addons'], JSON_UNESCAPED_UNICODE));
                  $types = mysqli_real_escape_string($conn, json_encode($product['types'], JSON_UNESCAPED_UNICODE));
                  $dressing = mysqli_real_escape_string($conn, json_encode($product['dressing'], JSON_UNESCAPED_UNICODE));

                  $sql_getitems = "SELECT `deal_cost`, `deal_price` FROM `deals` WHERE `deal_id` = $deal_id";
                  $execute_get_products = mysqli_query($conn, $sql_getitems);

                  if ($execute_get_products) {
                    $deal_details = mysqli_fetch_array($execute_get_products);
                    $cost = $deal_details['deal_cost'];
                    $price = $deal_details['deal_price'];
                    
                     $sql_getpro = "SELECT * FROM `products` WHERE `id` = '$product_id'";
                                $ex_get_pro = mysqli_query($conn,$sql_getpro);
                                $product = mysqli_fetch_array($ex_get_pro);
                                $pro_name = $product['name'];
                                $pro_decs = $product['description'];

                    $order_details_insert = "INSERT INTO `order_details_zee`(`order_id`, `deal_id`, `deal_item_id`, `product_id`,`product_name`, `product_description`, `qty`, `cost`, `price`, `addons`, `types`, `dressing`, `no_of_deal`) 
                                                             VALUES ('$last_order_id', '$deal_id', '$item_id', '$product_id', '$pro_name', '$pro_decs', '$deal_qty', '$cost', '$price', '$addons', '$types', '$dressing', '$no_of_deal')";
                    $execute_details_insert = mysqli_query($conn, $order_details_insert);

                    if (!$execute_details_insert) {
                      echo json_encode(array("statusCode" => 201, "message" => "Failed to insert deal order details", "error" => mysqli_error($conn)));
                      exit;
                    }
                  } else {
                    echo json_encode(array("statusCode" => 201, "message" => "Failed to fetch product details", "error" => mysqli_error($conn)));
                    exit;
                  }
                }
              }
            } else {
              $product_id = $details['id'];
              $product_qty = $details['qty'];

              $product_addons = mysqli_real_escape_string($conn, json_encode($details['addons'], JSON_UNESCAPED_UNICODE));
              $product_types = mysqli_real_escape_string($conn, json_encode($details['types'], JSON_UNESCAPED_UNICODE));
              $product_dressing = mysqli_real_escape_string($conn, json_encode($details['dressing'], JSON_UNESCAPED_UNICODE));

              $get_product_details = "SELECT `id`, `cost`, `price` FROM `products` WHERE `id`= $product_id";
              $execute_get_products = mysqli_query($conn, $get_product_details);

              if ($execute_get_products) {
                $product_details = mysqli_fetch_array($execute_get_products);
                $cost = $product_details['cost'];
                $price = $product_details['price'];
                
                $sql_getpro = "SELECT * FROM `products` WHERE `id` = '$product_id'";
                $ex_get_pro = mysqli_query($conn,$sql_getpro);
                $product = mysqli_fetch_array($ex_get_pro);
                $pro_name = $product['name'];
                $pro_decs = $product['description'];

                $order_details_insert = "INSERT INTO `order_details_zee`(`order_id`, `product_id`,`product_name`,`product_description`, `qty`, `cost`, `price`, `addons`, `types`, `dressing`) 
                                                     VALUES ('$last_order_id', '$product_id', '$pro_name','$pro_decs', '$product_qty', '$cost', '$price', '$product_addons', '$product_types', '$product_dressing')";
                $execute_details_insert = mysqli_query($conn, $order_details_insert);

                if (!$execute_details_insert) {
                  echo json_encode(array("statusCode" => 201, "message" => "Failed to insert order details", "error" => mysqli_error($conn)));
                  exit;
                }
              } else {
                echo json_encode(array("statusCode" => 201, "message" => "Failed to fetch product details", "error" => mysqli_error($conn)));
                exit;
              }
            }
          }
          
         
          
          echo json_encode(array("statusCode" => 200, "message" => "Order created successfully", "order_id" => $last_order_id));
          
             $sql_user = "SELECT * FROM `users` WHERE `id` = '$user_id'";
            $exec_sql_user = mysqli_query($conn, $sql_user);
            
            if ($exec_sql_user && mysqli_num_rows($exec_sql_user) > 0) {
                $user = mysqli_fetch_array($exec_sql_user, MYSQLI_ASSOC);
            }

        
          
            $address = $Shipping_address . " " . $Shipping_address_2 . " " . $Shipping_city . " " . $Shipping_area . " " . $Shipping_state . " " . $Shipping_postal_code;

            $order_info = [
                'id' => $last_order_id,
                'order_total_price' => $total_amount,
                'Shipping_Cost' => $shipping_cost,
                'address' => $address,
                'additional_notes' => $additionalNotes,
                'payment_type' => $payment_type,
                'status' => "neworder",
                'created_at' => $datetime,
                'name' => $user['name'],
                "order_type" => $order_type
            ];

  
             try {
                    // configure Pusher
                    $options = [
                        'cluster' => 'mt1',  // e.g. 'mt1'
                        'useTLS'  => true
                    ];
                
                    $pusher = new Pusher(
                        'a1964c3ac950c1a0cdf5',    // App key from Pusher dashboard
                        'a711ec3a4b827eb6bcc5', // App secret from Pusher dashboard
                        '1982652',     // App ID from Pusher dashboard
                        $options
                    );
                
                    // prepare notification
                    $channel = 'pizzapazza_orders'; // Channel name dynamically based on user ID
                    $event   = 'new_order';
                    $data    = [
                        'order_id' => $last_order_id,
                        'order_data'  => $order_info,
                    ];
                
                    // trigger the event
                    $response = $pusher->trigger($channel, $event, $data);
                
                    // if ($response) {
                    //     echo "Notification triggered successfully!";
                    // } else {
                    //     echo "Failed to trigger notification.";
                    // }
                    
                } catch (Exception $e) {
                    // Handle Pusher error
                    error_log("Pusher error: " . $e->getMessage());
                    echo "Error triggering notification: " . $e->getMessage();
                }
                    
          
          
        } else {
          echo json_encode(array("statusCode" => 201, "message" => "Failed to create order", "error" => mysqli_error($conn)));
        }
      } else {
        echo json_encode(array("statusCode" => 201, "message" => "Failed to create user", "error" => mysqli_error($conn)));
      }
    }
  } else {

    if ($wallet_balance) {
              $sql_check_wallet = "SELECT `amount` FROM `users` WHERE `id` = '$user_id'";
              $result_check_wallet = mysqli_query($conn, $sql_check_wallet);
              $row_wallet = mysqli_fetch_assoc($result_check_wallet);
        
              if ($row_wallet && isset($row_wallet['amount'])) {
                $current_balance = $row_wallet['amount'];
        
                if ($wallet_balance > $current_balance) {
                  // If wallet balance is greater than available amount, show error
                  $response = [
                    "status" => false,
                    "Response_code" => 400,
                    "Message" => "Insufficient wallet balance"
                  ];
                  echo json_encode($response);
                  exit;
                }

        // Deduct the balance
        $sql_update_wallet = "UPDATE `users` SET `amount` = `amount` - $wallet_balance WHERE `id` = '$user_id'";
        mysqli_query($conn, $sql_update_wallet);

        $transaction_message = "Abzug von €$wallet_balance vom Guthaben";

        $rand_id  = rand(000000, 10000000);
        
        $sql = "INSERT INTO `tbl_transaction` (`user_id`, `transaction_id`, `amount`, `type`, `message`) 
                VALUES ('$user_id', '$rand_id', '$wallet_balance', 'debit', '$transaction_message')";
        
        $ex_sql = mysqli_query($conn, $sql);



        // curl_close($ch);
      } else {
        // If amount column is not found
        $response = [
          "status" => false,
          "Response_code" => 400,
          "Message" => "Wallet balance not found"
        ];
        echo json_encode($response);
        exit;
      }
    }

    $sql_update_user = "UPDATE `users` SET `street` = '$street', `postal_code` = '$Shipping_postal_code', `city` = '$Shipping_city', `house_no` = '$House_number'WHERE `id` = $user_id";
    $result_user = mysqli_query($conn, $sql_update_user);
    
    if (!$result_user) {
         echo json_encode(array("statusCode" => 201, "message" => "Failed to update user", "error" => mysqli_error($conn)));
    }


    $sql = "INSERT INTO `orders_zee`(`user_id`, `status`, `payment_type`, `order_total_price`, 
                    `payment_status`, `Shipping_address`, `Shipping_address_2`, 
                    `Shipping_city`, `Shipping_postal_code`, `Shipping_Cost`,`branch_id`, `addtional_notes`, `total_netto_tax`, `total_metto_tax`, `order_type`, `total_discount`, `payment_method`, `transaction_id`, `platform`, `ordersheduletype`, `sheduletime`) 
            VALUES ($user_id, '$order_status', '$payment_type', '$total_amount', 
                    '$paymentstatus', '$Shipping_address', '$Shipping_address_2', 
                    '$Shipping_city', '$Shipping_postal_code', '$shipping_cost', '$branch_id', '$additional_notes', '$total_netto_tax', '$total_metto_tax', '$order_type', '$total_discount', '$payment_method', '$transaction_id', '$platform','$ordersheduletype', '$sheduletime')";
                    
    $result = mysqli_query($conn, $sql);

    if ($result) {
      $last_order_id = $conn->insert_id;

      $no_of_deal = 1;
      foreach ($order_details as $details) {
        if ($details['is_deal'] == "yes") {
          $deal_id = $details['deal_id'];
          $deal_qty = $details['deal_qty'];
          $no_of_deal++;
          foreach ($details['deal_items'] as $deal_item) {
            $item_id = $deal_item['item_id'];
            foreach ($deal_item['items_products'] as $product) {
              $product_id = $product['prod_id'];
              $addons = mysqli_real_escape_string($conn, json_encode($product['addons'], JSON_UNESCAPED_UNICODE));
              $types = mysqli_real_escape_string($conn, json_encode($product['types'], JSON_UNESCAPED_UNICODE));
              $dressing = mysqli_real_escape_string($conn, json_encode($product['dressing'], JSON_UNESCAPED_UNICODE));


              $sql_getitems = "SELECT `deal_cost`, `deal_price` FROM `deals` WHERE `deal_id` = $deal_id";
              $execute_get_products = mysqli_query($conn, $sql_getitems);


              if ($execute_get_products) {
                $product_details = mysqli_fetch_array($execute_get_products);
                $cost = $product_details['deal_cost'];
                $price = $product_details['deal_price'];
                
                
                $sql_getpro = "SELECT * FROM `products` WHERE `id` = '$product_id'";
                $ex_get_pro = mysqli_query($conn,$sql_getpro);
                $product = mysqli_fetch_array($ex_get_pro);
                $pro_name = $product['name'];
                $pro_decs = $product['description'];

                $order_details_insert = "INSERT INTO `order_details_zee`(`order_id`, `deal_id`, `deal_item_id`, `product_id`, `product_name`,`product_description`, `qty`, `cost`, `price`, `addons`, `types`, `dressing`, `no_of_deal`) 
                                                             VALUES ('$last_order_id', '$deal_id', '$item_id', '$product_id','$pro_name','$pro_decs', '$deal_qty', '$cost', '$price', '$addons', '$types', '$dressing', '$no_of_deal')";
                $execute_details_insert = mysqli_query($conn, $order_details_insert);

                if (!$execute_details_insert) {
                  echo json_encode(array("statusCode" => 201, "message" => "Failed to insert deal order details", "error" => mysqli_error($conn)));
                  exit;
                }
              } else {
                echo json_encode(array("statusCode" => 201, "message" => "Failed to fetch product details", "error" => mysqli_error($conn)));
                exit;
              }
            }
          }
        } else {
          $product_id = $details['id'];
          $product_qty = $details['qty'];


          $product_addons = mysqli_real_escape_string($conn, json_encode($details['addons'], JSON_UNESCAPED_UNICODE));
          $product_types = mysqli_real_escape_string($conn, json_encode($details['types'], JSON_UNESCAPED_UNICODE));
          $product_dressing = mysqli_real_escape_string($conn, json_encode($details['dressing'], JSON_UNESCAPED_UNICODE));

          $get_product_details = "SELECT `id`, `cost`, `price` FROM `products` WHERE `id` = '$product_id'";
          $execute_get_products = mysqli_query($conn, $get_product_details);

          if ($execute_get_products) {
            $product_details = mysqli_fetch_array($execute_get_products);
            $cost = $product_details['cost'];
            $price = $product_details['price'];
            
            $sql_getpro = "SELECT * FROM `products` WHERE `id` = '$product_id'";
            $ex_get_pro = mysqli_query($conn,$sql_getpro);
            $product = mysqli_fetch_array($ex_get_pro);
            $pro_name = $product['name'];
            $pro_decs = $product['description'];


            $order_details_insert = "INSERT INTO `order_details_zee`(`order_id`, `product_id`,`product_name`,`product_description`, `qty`, `cost`, `price`, `addons`, `types`, `dressing`) 
                                                     VALUES ('$last_order_id', '$product_id', '$pro_name','$pro_decs', '$product_qty', '$cost', '$price', '$product_addons', '$product_types', '$product_dressing')";

            $execute_details_insert = mysqli_query($conn, $order_details_insert);

            if (!$execute_details_insert) {
              echo json_encode(array("statusCode" => 201, "message" => "Failed to insert order details", "error" => mysqli_error($conn)));
              exit;
            }
          } else {
            echo json_encode(array("statusCode" => 201, "message" => "Failed to fetch product details", "error" => mysqli_error($conn)));
            exit;
          }
        }
      }
      
     echo json_encode(array("statusCode" => 200, "message" => "Order created successfully", "order_id" => $last_order_id));
      

    $address = $Shipping_address . " " . $Shipping_address_2 . " " . $Shipping_city . " " . $Shipping_area . " " . $Shipping_state . " " . $Shipping_postal_code;
    
    
              $sql_user = "SELECT * FROM `users` WHERE `id` = '$user_id'";
            $exec_sql_user = mysqli_query($conn, $sql_user);
            
            if ($exec_sql_user && mysqli_num_rows($exec_sql_user) > 0) {
                $user = mysqli_fetch_array($exec_sql_user, MYSQLI_ASSOC);
            }

        

            $order_info = [
                'id' => $last_order_id,
                'order_total_price' => $total_amount,
                'Shipping_Cost' => $shipping_cost,
                'address' => $address,
                'additional_notes' => $additionalNotes,
                'payment_type' => $payment_type,
                'status' => "neworder",
                'created_at' => $datetime,
                'name' => $user['name'],
                "order_type" => $order_type
            ];
            
            
            
         try {
                    // configure Pusher
                    $options = [
                        'cluster' => 'mt1',  // e.g. 'mt1'
                        'useTLS'  => true
                    ];
                
                    $pusher = new Pusher(
                        'a1964c3ac950c1a0cdf5',    // App key 
                        'a711ec3a4b827eb6bcc5', // App secret 
                        '1982652',     // App ID from Pusher 
                        $options
                    );
                
                    // prepare notification
                    $channel = 'pizzapazza_orders'; // Channel name 
                    $event   = 'new_order';
                    $data    = [
                        'order_id' => $last_order_id,
                        'order_data'  => $order_info,
                    ];
                
                    // trigger the event
                    $response = $pusher->trigger($channel, $event, $data);
                
                    // if ($response) {
                    //     echo "Notification triggered successfully!";
                    // } else {
                    //     echo "Failed to trigger notification.";
                    // }
                    
        } catch (Exception $e) {
                    // Handle Pusher error
                    // error_log("Pusher error: " . $e->getMessage());
                    echo "Error triggering notification: " . $e->getMessage();
        }
                    
    } else {
      echo json_encode(array("statusCode" => 201, "message" => "Failed to create order", "error" => mysqli_error($conn)));
    }
  }
} else {

  http_response_code(401);
  echo json_encode(array("statusCode" => 401, "message" => "Method Not Allowed"));
}
mysqli_close($conn);
