<?php

header("Content-Type:application/json");


$data = json_decode(file_get_contents("php://input"), true);

$psearch = $data["TransID"];

require_once "conn.php";

 $query = "SELECT * FROM MpesaC2BPayments WHERE TransID = '".$psearch."' ";

$result = mysqli_query($conn, $query) or die("Search Query Failed.");

$count = mysqli_num_rows($result);

if($count > 0)
{	
	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($row);
	
}
else
{	
	echo json_encode(array("Message" => "No Search Found.", "Error" => false));
}

?>