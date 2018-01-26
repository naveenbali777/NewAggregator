<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
// $fun->authentication();
$dataArray = $fun->getTableData("keywords");
foreach ($dataArray as $key => $value){
	$keywordId = $value['id'];
	$nonasn = $fun->getcoutbykeyword($value['name']);
	$asn = $fun->getassignkeywordcount($value['id']);
	$count = $nonasn - $asn;
	// echo "keyword Id : ".$keywordId." ---- keyword Name : ".$value['name']." ---- Count : ".$count;
	// echo "<br/>";
	$con = $fun->conOpen();
	if($count < 1){
		// mysqli_query($con, "DELETE FROM relationship WHERE keyword_id = $keywordId");
	}else{
		mysqli_query($con, "UPDATE keywords SET `count` = $count WHERE id = $keywordId");
	}
	mysqli_close($con);
}