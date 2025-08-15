<?php

header("Access-Control-Allow-Origin: *");  // Allow the specific origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers
header("Content-Type: application/json"); 
include('connection.php'); 


if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {

    $email = $_POST['email'];
    $phone = $_POST['phone'];

    include('connection.php');

    $sql = "SELECT `id` FROM `users` WHERE `email` = '$email' OR `phone` = '$phone'";
    $execute = mysqli_query($conn, $sql);

    if (mysqli_num_rows($execute) > 0) {

        $OTP = rand(1000, 9999);  

        // Email Content with Template
        $subject = 'Your OTP for Chick Pom';
      $message = '
<html>
<head>
    <title>Your OTP for Chick Pom</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Poppins", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .content {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 600px;
        }
        h1 {
            color: #2B2B29;
            font-size: 28px;
            margin-bottom: 10px;
        }
        p {
            color: #555;
            font-size: 16px;
            margin: 8px 0;
        }
        h2 {
            color: #F2AF34;
            font-size: 24px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'https://chickpom.de/API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
        <tr>
            <td align="center">
                <table class="content">
                    <tr>
                        <td align="center">
                            <img src="https://chickpom.de/admin_panel/images/logo.png" alt="Chick Pom" style="width: 100px; margin-bottom: 20px;">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h1>Your OTP for Chick Pom</h1>
                            <p>Your One-Time Password (OTP) for accessing your account is:</p>
                            <h2>' . htmlspecialchars($OTP) . '</h2>
                            <p>Please use this OTP to complete your login.</p>
                            <p>If you did not request this, please ignore this email.</p>
                            <p class="footer">Best regards,<br>The Chick Pom  Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';


        $headers = "From: support@chickpom.de\r\n";
        $headers .= "Reply-To: support@chickpom.de\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

        if (mail($email, $subject, $message, $headers)) {
            $data = [
                "OTP" => $OTP,
            ];
            $response = [
                "status" => true,
                "data" => $data,
                "message" => "Your OTP has been sent to you",
            ];
            echo json_encode($response);
        } else {
            $response = [
                "status" => false,
                "message" => "OTP not sent. There was an issue with the email sending process.",
            ];
            echo json_encode($response);
        }

    } else {
        $response = [
            "status" => false,
            "message" => "Email or phone does not exist",
        ];
        echo json_encode($response);
    }

} else {
    $response = [
        "status" => false,
        "Response_code" => 403,
        "Message" => "Access denied",
    ];
    echo json_encode($response);
}
?>
