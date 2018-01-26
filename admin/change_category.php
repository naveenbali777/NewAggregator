<?php 
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
if(isset($_GET['nId'])){
	$catId = $_GET['catId'];
	$newsId = $_GET['nId'];
	if(!empty($newsId)){
		$con = $fun->conOpen();
		mysqli_query($con, "UPDATE ".article_table." SET `category_id` = $catId WHERE id = $newsId");
		mysqli_close($con);
		echo "done";
	}
}