<?php

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

      include('connection.php');
           $sql = "SELECT `deal_id`, `deal_name`, `deal_description`, `deal_cost`, `deal_price`, `deal_image` FROM `deals`";
            $execute_sql = mysqli_query($conn,$sql);
            
            if(mysqli_num_rows($execute_sql) > 0){
                $deals_array = array();
                while($row = mysqli_fetch_array($execute_sql)){
                    $temp = [
                        "deal_id"=>$row['deal_id'],
                        "name"=>$row['deal_name'],
                        "description"=>$row['deal_description'],
                        "cost"=>$row['deal_cost'],
                        "price"=>$row['deal_price'],
                        "image"=>$row['deal_image'],
                        ];
                     array_push($deals_array,$temp);  
                        
                }
                $data = ["status"=>true,
                        "Response_code"=>200,
                        "Message"=>"Deals found successfully.",
                        "Data"=>$deals_array,
                        ];
                echo json_encode($data);  
            }else{
                  $data = ["status"=>false,
                    "Response_code"=>202,
                    "Message"=>"Not found!"];
                     echo json_encode($data);   
                }
    
    
}else{
                  $data = ["status"=>false,
                    "Response_code"=>404,
                    "Message"=>"Not found!"];
                     echo json_encode($data);   
                }


?>