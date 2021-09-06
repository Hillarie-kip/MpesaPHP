<?php

$data =file_get_contents("php://input");
$data = json_decode($data, true);
file_put_contents("callback.json", json_encode($data, JSON_PRETTY_PRINT), FILE_APPEND);

$ResultCode = $data['Body']['stkCallback']['ResultCode'];
$ResultDesc = $data['Body']['stkCallback']['ResultDesc'];
$CheckoutRequestID = $data['Body']['stkCallback']['CheckoutRequestID'];
$TransactionDate = $data['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
$MSISDN = $data['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
$TransAmount =  $data['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
$TransID = $data['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];

if ($ResultCode == '0') {
    require_once "conn.php";

    $query = "INSERT INTO LNMOCallBack(ResultCode, ResultDesc, CheckoutRequestID, TransAmount, TransID,MSISDN,TransactionDate) 
VALUES ('$ResultCode','$ResultDesc', '$CheckoutRequestID','$TransAmount','$TransID','$MSISDN','$TransactionDate')";
    

if(mysqli_query($conn, $query) or die("Insert Query Failed"))
{
	echo json_encode(array("ResultDesc" => "Confirmation recieved successfully", "ResultCode" => "0"));	
}
else
{
	echo json_encode(array("ResultDesc" => "Failed  Not Inserted ", "ResultCode" => "2"));	
}

}