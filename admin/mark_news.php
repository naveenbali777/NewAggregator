<?php 
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
if(isset($_GET['mark'])){
	$imgId = $_GET['mark'];
	$bname = $_GET['bname'];
	if(!empty($imgId)){
		$con = $fun->conOpen();
		mysqli_query($con, "UPDATE ".article_table." SET `$bname` = 'yes' WHERE id = $imgId");
		mysqli_close($con);
		echo "mark";
	}
}
if(isset($_GET['unmark'])){
	$imgId = $_GET['unmark'];
	$bname = $_GET['bname'];
	if(!empty($imgId)){
		$con = $fun->conOpen();
		mysqli_query($con, "UPDATE ".article_table." SET `$bname` = 'no' WHERE id = $imgId");
		mysqli_close($con);
		echo "unmark";
	}
}