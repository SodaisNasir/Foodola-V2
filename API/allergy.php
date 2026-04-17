<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 
     include('connection.php');

     $sql = "SELECT  * FROM `allergy`";

     $execute = mysqli_query($conn,$sql);
     if(mysqli_num_rows($execute) > 0){
         $announcement = array();
         while($row = mysqli_fetch_array($execute)){
             $temp =[
                        "id"=>$row['id'],
                        "allergy"=>$row['allergy'],

                    ];
            array_push($announcement,$temp);
         
        }
        $data = ["status"=>true,
            "message"=>"allergy Found",
            "data"=>$announcement,
            ];
        echo json_encode($data);   
     }else{
          $data = ["status"=>false,
            "message"=>"Not found!"];
             echo json_encode($data);   
     }
     






  
  
  
  
  
 ?>