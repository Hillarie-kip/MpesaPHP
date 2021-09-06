<?php
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] =='POST'){
    $Payload = file_get_contents('php://input');
    $data = json_decode($Payload,true);
    
    $Phone = $data['Phone'];
    $Amount = $data['Amount'];
    $TillNumber = $data['TillNumber'];
    if(strlen($Phone) != '12'){
       $response = [
           'errorMessage'=>'Phone Number Must be 12 digits',
           ];
           echo json_encode($response);
    }else{
        $pre = substr($Phone,0,3);
        if($pre !== '254'){
            $response = [
                    'errorMessage'=>'Phone Number Must Start with 254',
                    ];
             echo json_encode($response);
        }else{
            
            require 'paymentrequest.php';
            
            
        }
    }
}

