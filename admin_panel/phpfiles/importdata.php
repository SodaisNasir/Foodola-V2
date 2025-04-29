<?php


require('../Library/php-excel-reader/excel_reader2.php');
require('../Library/SpreadsheetReader.php');
include_once('../assets/connection.php');


if(isset($_POST['btn_importExcel'])){

  $mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  if(in_array($_FILES["file"]["type"],$mimes)){


    $uploadFilePath = '../excelFiles/'.basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);


    $Reader = new SpreadsheetReader($uploadFilePath);


    $totalSheet = count($Reader->sheets());


    

    
    /* For Loop for all sheets */
    for($i=0;$i<$totalSheet;$i++){


      $Reader->ChangeSheet($i);

      $rownumber=0;
      foreach ($Reader as $Row)
      {
       
          if($rownumber!=0){
        
        
          $query = "INSERT INTO `tbl_students`(`reg_number`, `name`, `cgpa`, `score`, `last_year_scholarship`, `Zakat_Certificate`, `Amount_Required`, `Amount_remaing`, `Zakat`, `Sadqa`) VALUES ($Row[1],'$Row[2]','$Row[3]','$Row[4]','$Row[5]','$Row[6]',$Row[7],$Row[7],0,0)";
        

           $result = mysqli_query($con,$query);
          }

      	 $rownumber++;
      
          


        //$mysqli->query($query);
       }


    }

    header("Location: ../importexcel.php?Massage=Sucessfull added new students.");
    



  }else { 
    die("<br/>Sorry, File type is not allowed. Only Excel file."); 
  }


}


?>