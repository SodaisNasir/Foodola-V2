<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_POST['token'] === 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    

    $name =  $_POST['name'];
    $phone =  $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role =  $_POST['role_id'];
    $user_referal =  $_POST['user_referal'];
    $notification_token = $_POST['notification_token'];
    $country_code =  $_POST['country_code'];

    include('connection.php');
    
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'faracecut@gmail.com';
        $mail->Password = 'ohvjrjlpxkjfvujd'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('support@burgerpoint.de', 'Pizza Burger Point');
        $mail->addAddress($email); 

        $mail->isHTML(true);
        $mail->Subject = "Welcome to Pizza Burger Point";

        $digits = 8;
        $referal_code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);

        $sql = "SELECT `id` FROM `users` WHERE `phone` = '$phone' OR `email` = '$email'";
        $execute = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($execute) == 0) {
            if (empty($user_referal)) {
                $sql = "INSERT INTO `users`(`role_id`, `name`, `phone`, `notification_token`, `email`, `referal_code`, `password`, `country_code`, `status`) VALUES ('$role','$name','$phone','$notification_token','$email','$referal_code','$password', '$country_code', 'active')";
            } else {
                $sql = "INSERT INTO `users`(`role_id`, `name`, `phone`, `notification_token`, `email`, `referal_code`, `user_referal`, `password`, `country_code` ,`status`) VALUES ('$role','$name','$phone','$notification_token','$email','$referal_code','$user_referal','$password', '$country_code', 'active')";
            }

            $result = mysqli_query($conn, $sql);

            if ($result) {
                $last_id = $conn->insert_id;

                $sql_getdata = "SELECT `id`, `role_id`, `name`, `phone`, `email`, `referal_code`, `profilepic`, `email_verified_at`, `notification_token`, `rewards_token`, `card_number`, `cvc_code`, `amount`, `created_at`, `updated_at`, `country_code`, `status` FROM `users` WHERE `id` = $last_id"; 
                $ex_getdata = mysqli_query($conn, $sql_getdata);
                
                if ($ex_getdata) {
                    $Data = mysqli_fetch_array($ex_getdata);
                    
                            $template = '
                            <html>
                            <head>
                                <title>Welcome to Pizza Burger Point !</title>

                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                                    .social-icons img {
                                        margin: 0 5px;
                                        width: 35px;
                                        height: 35px;
                                        transition: all 0.3s;
                                    }
                                    .social-icons img:hover {
                                        opacity: 0.7;
                                    }
                                    /* Mobile adjustments */
                                    @media (max-width: 768px) {
                                        h1 {
                                            font-size: 24px;
                                        }
                                        h3, p {
                                            font-size: 14px;
                                        }
                                        .content {
                                            padding: 15px;
                                        }
                                        .social-icons {
                                            text-align: center;
                                            margin-top: 10px;
                                        }
                                        .social-icons img {
                                            width: 30px;
                                            height: 30px;
                                        }
                                        table {
                                            background-image: none;
                                            background-color: #f7f7f7;
                                        }
                                    }
                                </style>
                            </head>
                            <body>
                                <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'https://burgerpoint.shop/BurgerPoint/API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
                                    <tr>
                                        <td align="center">
                                            <table width="100%" class="content" style="max-width: 600px;">
                                                <tr>
                                                    <td align="center">
                                                        <!-- Logo Section -->
                                                        <img src="https://burgerpoint.shop/BurgerPoint/admin_panel/images/logo.png" alt="Pizza Burger Point Logo" style="width: 100px; margin-bottom: 20px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <h1>Welcome, ' . htmlspecialchars($name) . '!</h1>
                                                        <p>Thank you for joining Pizza Burger Point! We’re thrilled to welcome you to our community of pizza and burger lovers.</p>
                                                        <h3>Why You’ll Love Pizza Burger Point :</h3>
                                                        <ul>
                                                            <li>🍕 <strong>Authentic Flavors:</strong> Indulge in our chef-crafted pizzas and burgers made with the finest ingredients.</li>
                                                            <li>🚀 <strong>Fast Delivery:</strong> Enjoy hot and fresh meals at your doorstep in no time.</li>
                                                        </ul>
                                                        <h3>Get Started Now!</h3>
                                                        <p>Here’s what you can do next:</p>
                                                        <ul>
                                                            <li>👀 <a href="https://burgerpoint.shop/menu">Browse our Menu</a> and find your favorites.</li>
                                                            <li>🛒 Place your first order and experience the convenience and quality we’re known for!</li>
                                                        </ul>
                                                        <p>If you have any questions, feel free to reach out to our support team. We’re here to make sure you have the best experience possible.</p>
                                                        <h4>Stay Connected:</h4>
                                                        <p>Follow us on social media for the latest updates, promotions, and delicious inspiration!</p>
                                                        <div class="social-icons">
                                                            <a href="https://facebook.com/burgerpoint" target="_blank">
                                                                <img src="https://burgerpoint.shop/BurgerPoint/API/uploads/facebook_logo.png" alt="Facebook">
                                                            </a>
                                                            <a href="https://instagram.com/burgerpoint" target="_blank">
                                                                <img src="https://burgerpoint.shop/BurgerPoint/API/uploads/instagram_logo.png" alt="Instagram">
                                                            </a>
                                                            <a href="https://twitter.com/burgerpoint" target="_blank">
                                                                <img src="https://burgerpoint.shop/BurgerPoint/API/uploads/twitter_logo.png" alt="Twitter">
                                                            </a>
                                                        </div>
                                                        <p>Enjoy every bite!</p>
                                                        <p>Warm regards,<br><strong>The Pizza Burger Point Team</strong></p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </body>
                            </html>
                            ';



                    $mail->Body = $template;
                    $mail->send();

                    $userdata = [
                        "user_id" => $Data['id'],
                        "role_id" => $Data['role_id'],
                        "name" => $Data['name'],
                        "phone" => $Data['phone'],
                        "email" => $Data['email'],
                        "referal_code" => $Data['referal_code'],
                        "profilepic" => $Data['profilepic'],
                        "rewards_token" => $Data['rewards_token'],
                        "card_number" => $Data['card_number'],
                        "cvc_code" => $Data['cvc_code'],
                        "amount" => $Data['amount'],
                        "created_at" => $Data['created_at'],
                        "country_code" => $Data['country_code'],
                        "status" => $Data['status']
                    ];

                    $data = [
                        "status" => true,
                        "Response_code" => 200,
                        "Message" => "User has been registered successfully.",
                        "Data" => $userdata
                    ];
                    echo json_encode($data);
                }
            } else {
                $data = [
                    "status" => false,
                    "Response_code" => 202,
                    "Message" => "There was some error while registering."
                ];
                echo json_encode($data);
            }
        } else {
            $data = [
                "status" => false,
                "Response_code" => 203,
                "Message" => "User with this phone number or email already exists."
            ];
            echo json_encode($data);
        }
    
    } catch (Exception $e) {
        $data = [
            "status" => false,
            "Response_code" => 500,
            "Message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
        ];
        echo json_encode($data);
    }

}
