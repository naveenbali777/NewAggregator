<?php 
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
if(isset($_GET['mark'])){
	$imgId = $_GET['mark'];
	if(!empty($imgId)){
		$con = $fun->conOpen();
		mysqli_query($con, "UPDATE company_images SET `status` = 'yes' WHERE id = $imgId");
		mysqli_close($con);
		echo "mark";
	}
}
if(isset($_GET['unmark'])){
	$imgId = $_GET['unmark'];
	if(!empty($imgId)){
		$con = $fun->conOpen();
		mysqli_query($con, "UPDATE company_images SET `status` = 'no' WHERE id = $imgId");
		mysqli_close($con);
		echo "unmark";
	}
}