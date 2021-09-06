<?php
header("Content-Type:application/json");

//read incoming request
$postData=file_get_contents('php://input');


$jdata=json_decode($postData,true);
$ShortCode = $jdata["ShortCode"];

$consumerkey = "";
$consumersecret = "";
$validationurl="";
$confirmationurl="";

$authenticationurl='https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$registerurl = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
$credentials= base64_encode($consumerkey.':'.$consumersecret);

$username=$consumerkey ;
$password=$consumersecret;
  // Request headers
  $headers = array(  
    'Content-Type: application/json; charset=utf-8'
  );

  $ch = curl_init($authenticationurl);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  //curl_setopt($ch, CURLOPT_HEADER, TRUE); // Includes the header in the output
  curl_setopt($ch, CURLOPT_HEADER, FALSE); 
  curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password); 
  $result = curl_exec($ch);  
  $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
$result = json_decode($result);
$access_token=$result->access_token;
curl_close($ch);


$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $registerurl);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); 
$curl_post_data = array(
  
  'ShortCode' => $ShortCode,
  'ResponseType' => 'Completed',
  'ConfirmationURL' => $confirmationurl,
  'ValidationURL' => $validationurl
);
$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
$curl_response = curl_exec($curl);
echo $curl_response;
