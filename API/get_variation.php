<?php
include('connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
    
  $myarr = array();
    
  $select = "SELECT `id`, `title`, `created_at` FROM `variation`";
  $execute = mysqli_query($conn,$select);
  $rows = mysqli_num_rows($execute);

  if($rows > 0)
  {
        
         while($var_arr = mysqli_fetch_array($execute))
         {
             $id = $var_arr['id'];
             
             $select_var_with_pro = "SELECT vp.id AS variation_id,vp.product_id,vp.sub_title,p.addon_id,p.type_id,
             p.dressing_id,p.sub_category_id,p.name AS product_name,p.description,p.cost,p.price,p.discount,p.qty,p.img,p.features,
             p.created_at FROM variation_with_product vp INNER JOIN products p on p.id = vp.product_id WHERE vp.var_id = $id";
             $exec_var_with_pro = mysqli_query($conn,$select_var_with_pro);
             $num_var_with_pro = mysqli_num_rows($exec_var_with_pro);
             if($num_var_with_pro > 0)
             {
                 
                 while($ar_var_with_pro = mysqli_fetch_array($exec_var_with_pro))
                 {
                     $addon_id = $ar_var_with_pro['addon_id'];
                     $type_id = $ar_var_with_pro['type_id'];
                     $dressing_id = $ar_var_with_pro['dressing_id'];
                     $sub_category_id = $ar_var_with_pro['sub_category_id'];
                     
                     $select_adon = "SELECT `ao_id`, `ao_title` FROM `addon_list` WHERE ao_id = $addon_id"; 
                     $exec_select_adon = mysqli_query($conn,$select_adon);
                     if($exec_select_adon)
                     {
                          while($ar_select_adon = mysqli_fetch_array($exec_select_adon))
                          {
                              
                              $select_type = "SELECT `type_id`, `type_title`, `type_title_user` FROM `types_list` WHERE type_id = $type_id";
                              $exec_select_type = mysqli_query($conn,$select_type);
                              if($exec_select_type)
                              {
                                  while($ar_exec_select_type = mysqli_fetch_array($exec_select_type))
                                  {
                                      
                                      $select_dressing = "SELECT `dressing_id`, `dressing_title`, `dressing_title_user` FROM `dressing_list` WHERE dressing_id = $dressing_id";
                                      $exec_select_dressing = mysqli_query($conn,$select_dressing);
                                      if($exec_select_dressing)
                                      {
                                          while($ar_exec_select_dressing = mysqli_fetch_array($exec_select_dressing))
                                          {
                                              
                                               $select_sub_cat = "SELECT `id`, `category_id`, `name`, `img`, `created_at`, `updated_at` FROM `sub_categories` WHERE id = $sub_category_id";
                                               $exec_select_sub_cat = mysqli_query($conn,$select_sub_cat);
                                               if($exec_select_sub_cat)
                                               {
                                                    while($ar_exec_select_sub_cat = mysqli_fetch_array($exec_select_sub_cat))
                                                    {
                                                       $temp4 = 
                                                       [
                                                           "sub_category_id"=> $ar_exec_select_sub_cat['id'],
                                                           "category_id"=> $ar_exec_select_sub_cat['category_id'],
                                                           "name"=> $ar_exec_select_sub_cat['name'],
                                                           "img"=> $ar_exec_select_sub_cat['img'],
                                                           "created_at"=> $ar_exec_select_sub_cat['created_at'],
                                                       ];
                                                    }
                                               }
                                              
                                              
                                               $temp3 = 
                                               [
                                                   "dressing_id" => $ar_exec_select_dressing['dressing_id'],
                                                   "dressing_title" => $ar_exec_select_dressing['dressing_title'],
                                                   "dressing_title_user" => $ar_exec_select_dressing['dressing_title_user'],
                                               ];
                                          }
                                      }
                                      
                                      
                                       $temp2 = 
                                       [
                                           "type_id" => $ar_exec_select_type['type_id'],
                                           "type_title " => $ar_exec_select_type['type_title'],
                                           "type_title_user" => $ar_exec_select_type['type_title_user'],
                                       ];
                                  }
                              }
                              
                              
                              
                              $temp1 = 
                              [
                                  "ao_id"=>$ar_select_adon['ao_id'],
                                  "ao_title"=>$ar_select_adon['ao_title'],
                              ];
                          }
                          
                     }
                    
                    
                     $temp = 
                     [
                            "variation_id"=>$ar_var_with_pro['variation_id'],
                             "sub_title"=>$ar_var_with_pro['sub_title'],
                             "product_id"=>$ar_var_with_pro['product_id'],
                             "product_name"=>$ar_var_with_pro['product_name'],
                             "description"=>$ar_var_with_pro['description'],
                             "cost"=>$ar_var_with_pro['cost'],
                             "price"=>$ar_var_with_pro['price'],
                             "discount"=>$ar_var_with_pro['discount'],
                             "qty"=>$ar_var_with_pro['qty'],
                             "img"=>$ar_var_with_pro['img'],
                             "features"=>$ar_var_with_pro['features'],
                             "created_at"=>$ar_var_with_pro['created_at'],
                             "addons_title" => $temp1,
                             "var_type" => $temp2,
                             "var_dressing" => $temp3,
                             "var_sub_cat" => $temp4,
                     ];
                     array_push($myarr,$temp);
                    
                    
                 }
                 
                 
                 
             }
             
       
        }
        
        
        
        $response = 
               [
                   "status"=>true,
                    "Response_code"=>200,
                    "Message"=>"variation details found successfully",
                    "Data"=>$myarr,
            
                ];
                echo json_encode($response);  
        
        
     
  }
  else
  {
      $response = [
                      "status"=>false,
                      "Response_code"=>203,
                      "Message"=>"No Variation found",
                  ];
      echo json_encode($response); 
  }



}
else
{
    
  $data = [
                "status"=>false,
                "Response_code"=>403,
                "Message"=>"Access denied"
          ];
  echo json_encode($data);          
    
}


?>