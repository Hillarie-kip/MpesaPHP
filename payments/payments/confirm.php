<?php

//Set the response content type to application/json
header("Content-Type:application/json");

//read incoming request
$postData=file_get_contents('php://input');
//log file


$filePath="C2BPayments.json";
//error log
$errorLog="C2Berrors.log";

$jdata=json_decode($postData,true);

$TransactionType= $jdata["TransactionType"];
$TransID=$jdata["TransID"];
$TransTime= $jdata["TransTime"];
$TransAmount = $jdata["TransAmount"];
$BusinessShortCode = $jdata["BusinessShortCode"];
$BillRefNumber = $jdata["BillRefNumber"];
$InvoiceNumber = $jdata["InvoiceNumber"];
$OrgAccountBalance = $jdata["OrgAccountBalance"];
$ThirdPartyTransID= $jdata["ThirdPartyTransID"];
$MSISDN= $jdata["MSISDN"];
$FirstName = $jdata["FirstName"];
$MiddleName = $jdata["MiddleName"];
$LastName = $jdata["LastName"];

require_once "conn.php";

    $query = "INSERT INTO MpesaC2BPayments(TransactionType, TransID, TransTime, TransAmount, BusinessShortCode,BillRefNumber,InvoiceNumber,MSISDN,FirstName,MiddleName,LastName,OrgAccountBalance,UsedBalance) 
VALUES ('$TransactionType','$TransID', '$TransTime','$TransAmount','$BusinessShortCode','$BillRefNumber','$InvoiceNumber','$MSISDN','$FirstName','$MiddleName','$LastName','$OrgAccountBalance','$TransAmount')";
    

if(mysqli_query($conn, $query) or die("Insert Query Failed"))
{
	echo json_encode(array("ResultDesc" => "Confirmation recieved successfully", "ResultCode" => "0"));	
}
else
{
	echo json_encode(array("ResultDesc" => "Failed  Not Inserted ", "ResultCode" => "2"));	
}

?>

