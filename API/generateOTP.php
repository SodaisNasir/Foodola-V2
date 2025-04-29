<?php

if($_POST['token'] == "ASDEGFAERGBEBDFV66_2654641321sdvzdfv!@"){

    $Phone= str_replace("+92","92",$_POST['phone']);
    $digits = 4;
    $OTP = rand(pow(10, $digits-1), pow(10, $digits)-1);
    $temp = [
    	"loginId"=>"923152973613",
    	"loginPassword"=>"Zong@123",
    	"Destination"=>$Phone,
    	"Mask"=>"TodaysFresh",
    	"Message"=>"Your OTP code for TodaysFresh app is ".$OTP.". For any issues, contact us at 03453998674 or todaysfresh.com.pk.",
    	"UniCode"=>"0",
    	"ShortCodePrefered"=>"n"
    	];
    $obj = json_encode($temp);
    
    $curl = curl_init();
    $certificate_location = '/usr/local/openssl-0.9.8/certs/cacert.pem';
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $certificate_location);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $certificate_location);
    
    
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://cbs.zong.com.pk/reachrestapi/home/SendQuickSMS",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $obj,
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: bd9d4403-695a-8e13-7fc3-71e87fb29171"
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
       $response;
       $res = ["OTP"=>$OTP,
                "Message"=>"Message sent to user",
                "code"=>200];
        echo json_encode($res);        
    }
}