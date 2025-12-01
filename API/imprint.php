<?php

     include('connection.php');

     $sql = "SELECT  * FROM `imprint`";

     $execute = mysqli_query($conn,$sql);
     if(mysqli_num_rows($execute) > 0){
         $announcement = array();
         while($row = mysqli_fetch_array($execute)){
             $temp =[
                        "id"=>$row['id'],
                        "imprint"=>$row['imprint'],
                        "created_at"=>$row['created_at'],
                        "updated_at"=>$row['updated_at'],
                    ];
            array_push($announcement,$temp);
         
        }
        $data = ["status"=>true,
            "message"=>"imprint Found",
            "data"=>$announcement,
            ];
        echo json_encode($data);   
     }else{
          $data = ["status"=>false,
            "message"=>"Not found!"];
             echo json_encode($data);   
     }
     






  
  
  
  
  
 ?>