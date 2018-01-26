<?php 
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
if(isset($_GET['company_id'])){
	$company_id = $_GET['company_id'];
	$con = $fun->conOpen();
	$note = (empty($_GET['notevalue'])) ? "" : mysqli_real_escape_string($con,$_GET['notevalue']);
	mysqli_query($con, "UPDATE company SET `note` = '$note' WHERE id = $company_id");
	mysqli_close($con);
	echo "done";
}