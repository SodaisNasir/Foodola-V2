<?php


if($_POST['request_name']== 'socialLogin'){
    include("../connection.php");
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $useremail = $_POST['email'];
    $userphone = $_POST['userphone'];
    $socialid = $_POST['socialid'];
    $Social_site = $_POST['Social_site'];
    $userpassword = null;
    $usertype = 'user';
    
    $sql_get = "SELECT `user_id`, `user_name`, `profilepic`, `user_email`, `user_phone`, `user_password`, `user_status`, `user_type`, `user_created_date` FROM `tbl_users` WHERE `social_id`='$socialid'";
    
    $execute_check = mysqli_query($con,$sql_get);
    if(mysqli_num_rows($execute_check)==0){
        
        $sql_get_email = "SELECT `user_id`, `user_name`, `profilepic`, `user_email`, `user_phone`, `user_password`, `user_status`, `user_type`, `user_created_date` FROM `tbl_users` WHERE `user_email`='$useremail'";
    
        $execute_check_email = mysqli_query($con,$sql_get_email);
        if(mysqli_num_rows($execute_check_email) == 0){
             $sql = "INSERT INTO `tbl_users`(`user_name`, `user_email`, `user_phone`, `user_password`, `user_type` , `social_id` , `registered_with`) VALUES ('$username','$useremail','$userphone','$userpassword','$usertype' , $socialid , '$Social_site')";
    
                $execute = mysqli_query($con,$sql);
                if($execute){
                    $user_id  = $last_id = $con->insert_id;
                    $data = array("User_type"=>$usertype,
                                      "User_id"=>$user_id,
                                      "user_name"=>$username,
                                      "profilepic"=>'assets/Images/ProfileImage.png',
                                      "user_email"=>$useremail,
                                      "user_phone"=>$userphone
                                      );
                                      
                    $response = array("Response"=>200,
                                      "Message"=>"Inserted Data.",
                                      "isAuthenticated"=>true,
                                      "User_Details"=>$data
                                      );    
                    echo json_encode($response); 
                }
        }else{
             $sql = "UPDATE `tbl_users` SET `social_id` = $socialid ,`registered_with` = '$Social_site' WHERE `user_email` = '$useremail'";
             $Data = mysqli_fetch_array($execute_check_email);
             $execute = mysqli_query($con,$sql);
                if($execute){
                    $data = array("User_type"=>$Data['user_type'],
                                      "User_id"=>$Data['user_id'],
                                      "user_name"=>$username,
                                      "profilepic"=>$Data['profilepic'],
                                      "user_email"=>$Data['user_email'],
                                      "user_phone"=>$Data['user_phone']
                                      );
                                      
                    $response = array("Response"=>200,
                                      "Message"=>"Inserted Data.",
                                      "isAuthenticated"=>true,
                                      "User_Details"=>$data
                                      );    
                    echo json_encode($response); 
                }
            
        }
       
        
        
    }else{
        $Data = mysqli_fetch_array($execute_check);
                    $data = array("User_type"=>$Data['user_type'],
                                      "User_id"=>$Data['user_id'],
                                      "user_name"=>$username,
                                      "profilepic"=>$Data['profilepic'],
                                      "user_email"=>$Data['user_email'],
                                      "user_phone"=>$Data['user_phone']
                                      );
                                      
                    $response = array("Response"=>200,
                                      "Message"=>"Inserted Data.",
                                      "isAuthenticated"=>true,
                                      "User_Details"=>$data
                                      );    
         echo json_encode($response); 
    }
    
    
    
}




else if($_POST['request_name']== 'registration'){
    include("../connection.php");
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $useremail = $_POST['email'];
    $userphone = $_POST['userphone'];
    $userpassword = $_POST['userpassword'];
    $usertype = 'user';
    
    $username = $firstName." ".$lastName;
    
    
    $sql_get = "SELECT `user_id`, `user_name`, `profilepic`, `user_email`, `user_phone`, `user_password`, `user_status`, `user_type`, `user_created_date` FROM `tbl_users` WHERE `user_email`='$useremail'";
    
    $execute_check = mysqli_query($con,$sql_get);
    if(mysqli_fetch_array($execute_check)==0){
    $sql = "INSERT INTO `tbl_users`(`user_name`, `user_email`, `user_phone`, `user_password`, `user_type`) VALUES ('$username','$useremail','$userphone','$userpassword','$usertype')";
    
    $execute = mysqli_query($con,$sql);
        if($execute){
            $user_id  = $last_id = $con->insert_id;
            $data = array("User_type"=>$usertype,
                              "User_id"=>$user_id,
                              "user_name"=>$username,
                              "profilepic"=>'assets/Images/ProfileImage.png',
                              "user_email"=>$useremail,
                              "user_phone"=>$userphone
                              );
                              
            $response = array("Response"=>200,
                              "Message"=>"Inserted Data.",
                              "isRegistered"=>true,
                              "User_Details"=>$data
                              );    
            echo json_encode($response); 
        }else{
          $data = array("User_type"=>null,
                              "User_id"=>null,
                              "user_name"=>null,
                              "profilepic"=>null,
                              "user_email"=>null,
                              "user_phone"=>null,
                              );
            http_response_code(202);        
            $response = array("Response"=>202,
                              "Message"=>"There was some eorror.",
                              "isRegistered"=>false,
                              "User_Details"=>$data
                              );    
            echo json_encode($response);  
        }
    }else{
        $data = array("User_type"=>null,
                              "User_id"=>null,
                              "user_name"=>null,
                              "profilepic"=>null,
                              "user_email"=>null,
                              "user_phone"=>null,
                              );
            http_response_code(202);                  
            $response = array("Response"=>202,
                              "Message"=>"This email has been used already.",
                              "isRegistered"=>false,
                              "User_Details"=>$data
                     );    
            echo json_encode($response);  
    }
   
    
    
}else if($_POST['request_name']== 'likeMcqs'){ 
    
    include("../connection.php");
    $mcqs_id = $_POST['mcqs_id'];
    $user_id = $_POST['user_id'];
    $sql_check = "SELECT `like_id` FROM `tbl_mcqs_like` WHERE `mcqs_id` = $mcqs_id AND  `user_id` = $user_id ";
    $execute_check = mysqli_query($con,$sql_check);
    if(mysqli_num_rows($execute_check) == 0 ){
        $sql = "INSERT INTO `tbl_mcqs_like`(`mcqs_id`, `user_id`) VALUES ($mcqs_id,$user_id)";
        $execute = mysqli_query($con,$sql);
        if($execute){
            $response = array("Response"=>200,
                              "Message"=>"Sucessfully liked this mcq.",
                              "isliked"=>true,
                              );    
            echo json_encode($response);  
        }else{
            $response = array("Response"=>400,
                              "Message"=>"There was some error.",
                              "isliked"=>null,
                              );    
            echo json_encode($response);
        }
    }else{
        $sql = "DELETE FROM `tbl_mcqs_like` WHERE `mcqs_id` = $mcqs_id AND `user_id` = $user_id";
        $execute = mysqli_query($con,$sql);
        if($execute){
            $response = array("Response"=>200,
                              "Message"=>"Sucessfully unliked this mcq.",
                              "isliked"=>false,
                              );    
            echo json_encode($response);  
        }else{
            $response = array("Response"=>400,
                              "Message"=>"There was some error.",
                              "isliked"=>null,
                              );    
            echo json_encode($response);
        }
    }
     
    
}else if($_POST['request_name']== 'postcomment'){ 
    include("../connection.php");
    $mcqs_id = $_POST['mcqs_id'];
    $user_id = $_POST['user_id'];
    $comment = $_POST['comment'];
    
    $sql = "INSERT INTO `mcsq_comments`(`user_id`, `mcqs_id`, `comment`) VALUES ($user_id,$mcqs_id,'$comment')";
    $execute = mysqli_query($con,$sql);
    if($execute){
            $response = array("Response"=>200,
                              "Message"=>"Sucessfully inserted comment on this mcq.",
                              "isCommented"=>true,
                              "YourComment"=>$comment
                              );    
            echo json_encode($response);  
    }else{
            $response = array("Response"=>400,
                              "Message"=>"There was some error.",
                              "isCommented"=>false,
                              "YourComment"=>$comment
                              );    
            echo json_encode($response);
    }
    
}else if($_POST['request_name']== 'followUser'){ 
    
    include("../connection.php");
    $follower_id = $_POST['follower_id'];
    $user_id = $_POST['user_id'];
    $sql_check = "SELECT `follow_id`, `user_id`, `follower_id`, `created_date` FROM `tbl_follower` WHERE `user_id` = $user_id AND `follower_id` = $follower_id ";
    $execute_check = mysqli_query($con,$sql_check);
    if(mysqli_num_rows($execute_check) == 0 ){
        $sql = "INSERT INTO `tbl_follower`(`user_id`, `follower_id`) VALUES ($user_id,$follower_id)";
        $execute = mysqli_query($con,$sql);
        if($execute){
            $response = array("Response"=>200,
                              "Message"=>"Sucessfully followed this user.",
                              "isFollowed"=>true,
                              );    
            echo json_encode($response);  
        }else{
            $response = array("Response"=>400,
                              "Message"=>"There was some error.",
                              "isFollowed"=>null,
                              );    
            echo json_encode($response);
        }
    }else{
        $sql = "DELETE FROM `tbl_follower` WHERE `user_id` = $user_id AND `follower_id` = $follower_id";
        $execute = mysqli_query($con,$sql);
        if($execute){
            $response = array("Response"=>200,
                              "Message"=>"Sucessfully unfollowed this user.",
                              "isFollowed"=>false,
                              );    
            echo json_encode($response);  
        }else{
            $response = array("Response"=>400,
                              "Message"=>"There was some error.",
                              "isFollowed"=>null,
                              );    
          echo json_encode($response);
        }
    }
     
    
}else if($_POST['request_name']== 'reporteuser'){ 
    
    include("../connection.php");
     $report_id = $_POST['report_id'];
     $reported_by = $_POST['reported_by'];
     $reason = $_POST['reason'];
    $sql ="INSERT INTO `tbl_report`(`reported_by`, `reported_id`, `reason`) VALUES ($reported_by,$report_id,'$reason')";
    $execute = mysqli_query($con,$sql);
     if($execute){
           $response = array("Response"=>200,
                              "Message"=>"Sucessfully reported this user.",
                              "isReported"=>true,
                              );    
            echo json_encode($response);  
        }else{
            $response = array("Response"=>400,
                              "Message"=>"There was some error.",
                              "isReported"=>false,
                              );    
          echo json_encode($response);
       }
     
    
}else if($_POST['request_name']== 'reportemcqs'){ 
    
    include("../connection.php");
     $reported_by= $_POST['reported_by'];
     $mcqs_id = $_POST['mcqs_id'];
     $reason = $_POST['reason'];
    $sql ="INSERT INTO `tbl_report_mcqs`( `mcqs_id`, `reported_by`, `reason`) VALUES ($mcqs_id,$reported_by,'$reason')";
    $execute = mysqli_query($con,$sql);
     if($execute){
           $response = array("Response"=>200,
                              "Message"=>"Sucessfully reported this mcqs.",
                              "isReported"=>true,
                              );    
            echo json_encode($response);  
        }else{
            $response = array("Response"=>400,
                              "Message"=>"There was some error.",
                              "isReported"=>false,
                              );    
          echo json_encode($response);
       }
     
    
}

else if($_POST['request_name']== 'GenerateQuiz'){ 
    
    include("../connection.php");
    $sub_category_id = $_POST['sub_category_id'];
    $user_id = $_POST['user_id'];
    
    
     $getuser_name = "SELECT `user_id`, `user_name`, `profilepic`, `user_email`, `user_phone`, `user_password`, `user_status`, `user_type`, `user_created_date` FROM `tbl_users` WHERE `user_id` = $user_id";
     $getdata = mysqli_query($con,$getuser_name);
     $user_data = mysqli_fetch_array($getdata);
     $username = $user_data['user_name'];
     
     $quiz_tittle = $username." have created quiz ".date("Y/m/d");
     
    
     $create_quiz_sql = "INSERT INTO `tbl_quiz`(`quiz_tittle`,`quiz_creator`, `quiz_total_marks`) VALUES ('$quiz_tittle',$user_id,20)";
     $insert = mysqli_query($con,$create_quiz_sql);
     $last_id = $con->insert_id;
     
       $sql = "SELECT `mcqs_id`, `sub_category_id`, `mcqs_question_type`, `mcqs_question`, `mcqs_options_type`, `mcqs_option_1`, `mcqs_option_2`, `mcqs_option_3`, `mcqs_option_4`, `mcqs_answer`, `mcqs_creator`, `mcqs_created_date` FROM `tbl_mcqs` WHERE `sub_category_id` = $sub_category_id ORDER BY rand() LIMIT 20";
         $execute = mysqli_query($con,$sql);
         $data = array();
         while($row = mysqli_fetch_array($execute)){
             $mcqs_id = $row['mcqs_id'];
             $insert_questions = "INSERT INTO `tbl_quiz_questions`(`quiz_id`, `mcqs_id`) VALUES ($last_id,$mcqs_id)";
             $insert_questions;
             $inserted_questions = mysqli_query($con,$insert_questions);
             $last_question_id = $con->insert_id;
             
                    $temp = [
                    "question_id"=>$last_question_id,
                    "quiz_id"=>$last_id,
                    "mcqs_id"=>$row['mcqs_id'],
                    "quiz_question_type"=>$row['mcqs_question_type'],
                    "quiz_question"=>$row['mcqs_question'],
                    "quiz_options_type"=>$row['mcqs_options_type'],
                    "quiz_option_1"=>$row['mcqs_option_1'],
                    "quiz_option_2"=>$row['mcqs_option_2'],
                    "quiz_option_3"=>$row['mcqs_option_3'],
                    "quiz_option_4"=>$row['mcqs_option_4'],
                    "quiz_answer"=>$row['mcqs_answer'],
                    "selected_option"=>null,
                    ];
                    
            
           array_push($data,$temp);
             
         }
        if($insert){
            $response = array("Response"=>200,
                              "Message"=>"Sucessfully created new quiz.",
                              "isQuizCreated"=>true,
                              "Data"=>$data
                              );    
            echo json_encode($response);  
        }else{
            $response = array("Response"=>400,
                              "Message"=>"There was some error.",
                              "isQuizCreated"=>null,
                              "Data"=>null
                              );    
            echo json_encode($response);
        }
     
    
}else if($_POST['request_name'] == 'PostQuizAnswer'){ 
    
      include("../connection.php");
      $Data = json_decode($_POST['Data']);
      $user_id = $_POST['user_id'];
      $response_data = array();
      $error = false;
      $data_error = array();
      foreach($Data as $rowcheck){
        if($rowcheck->selected_option ==  null){
           $error = true; 
           $temp = ["Question_id"=>$rowcheck->question_id,
                   "isAnswered"=>false,
                   "Message"=>"Option not selected"
                   ];
             array_push($data_error,$temp);
        }  
      }
      if($error == false){
      foreach($Data as $row){
            $question_id = $row->question_id;
            $mcqs_id =$row->mcqs_id;
            $quiz_id =$row->quiz_id;
            $answer_option = $row->selected_option;
          
          $sql_add_answer = "INSERT INTO `tbl_quiz_answer`(`user_id`, `quiz_id`, `mcqs_id`, `question_id`, `answer_option`) VALUES ($user_id,$quiz_id,$mcqs_id,$question_id,$answer_option)";
          $execute = mysqli_query($con,$sql_add_answer);
          if($execute){
              $temp = ["Question_id"=>$question_id,
                   "isAnswered"=>true,
                   "mcqs_id"=>$mcqs_id,
                   "quiz_id"=>$quiz_id,
                   "answer_option"=>$answer_option,
                   ];
             array_push($response_data,$temp);
          }else{
              $temp = ["Question_id"=>$question_id,
                   "isAnswered"=>false,
                   "mcqs_id"=>$mcqs_id,
                   "quiz_id"=>$quiz_id,
                   "answer_option"=>$answer_option,
                    ];
              array_push($response_data,$temp);
          }
          
          
         }
         http_response_code(200);
         $response = array("Response"=>200,
                              "Message"=>"Sucessfully answered questions.",
                              "Data"=>$response_data
                              );    
         echo json_encode($response); 
     }else{
         http_response_code(202);
         $response = array("Response"=>202,
                              "Message"=>"There is some Mcq not answered.",
                              "Data"=>$data_error
                              );    
         echo json_encode($response); 
     }
      
     
      
     
    
}else if($_POST['request_name'] == 'ContactForm'){ 
    include("../connection.php");
    $email = $_POST['email'];
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $message = $_POST['message'];
     $sql = "INSERT INTO `tbl_contact_us`(`user_id`, `name`, `email`, `message`) VALUES (1,'$name','$email','$message')";
    $execute = mysqli_query($con,$sql);
    $last_id = $con->insert_id;
     if($execute){
            $response = array("Response"=>200,
                              "Message"=>"Sucessfully contact form submitted.",
                              "isFormsubmitted"=>true,
                              "ticket_id"=>$last_id,
                              
                              );    
            echo json_encode($response);  
        }else{
            $response = array("Response"=>400,
                              "Message"=>"There was some error.",
                              "isFormsubmitted"=>false,
                              "ticket_id"=>null,
                              );    
            echo json_encode($response);
        }
    
    
    
}else{
   $response = array("Response"=>"404","Message"=>"Invalid Prams");
   echo json_encode($response);
}





?>