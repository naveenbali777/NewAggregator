<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$errormsg = "";
$imgerrormsg = "";
if(isset($_POST["upload"])) {
	$bannerImage = array();
	$imgUrl = "";
	if(!empty($_FILES["excelFile"]["name"])){		
		$target_dir = "../uploads/excelFile/";
		$filename=$_FILES["excelFile"]["tmp_name"];
		// echo $newfilename;
		$newfilename="tag_excel_file.xlsx";
		$imgUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"."/news_aggregator/uploads/excelFile/".$newfilename;
		$uploadOk = 1;
		$imageFileType = pathinfo($target_dir . basename($_FILES["excelFile"]["name"]),PATHINFO_EXTENSION);
		// Allow certain file formats
		if($imageFileType != "xlsx") {			// echo "eeeeeee";
		    $imgerrormsg = "Sorry, only xlsx files are allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    $imgerrormsg = "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($filename, $target_dir.$newfilename)) {
		        $imgerrormsg = "The file ". basename( $_FILES["excelFile"]["name"]). " has been uploaded.";
		        $con = $fun->conOpen();
				mysqli_query($con, "UPDATE excel_status SET `status` = 'pending' WHERE `id` = 1");
			    mysqli_close($con);
		    } else {
		        $imgerrormsg = "Sorry, there was an error uploading your file.";
		    }
		}
	}
	
}
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Excel file for tags</h2>
		<div><?php echo $errormsg; ?></div>
		<form method="post" enctype="multipart/form-data" id="excelForm"> 
			<div class="form-group">
				<?php echo $imgerrormsg; ?>
				<input type="file" name="excelFile" id="excelFile" class="form-control">
			</div>
			<button type="submit" class="btn btn-default" name="upload">Upload</button>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>