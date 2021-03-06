<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$errormsg = "";
$imgerrormsg = "";
$channel = (!empty($_GET['tkr'])) ? $_GET['tkr'] : "";
// $tagsArray = $fun->getTableData("",);
// Check if image file is a actual image or fake image
if(isset($_POST["add"])) {
	$bannerImage = array();
	$imgUrl = "";
	if(!empty($_FILES["article_img"]["name"])){		
		$target_dir = "../uploads/executives/";
		$filename=$_FILES["article_img"]["tmp_name"];
		// $newfilename=time()."-".$_FILES["article_img"]["name"];
		$newfilename=$channel."-executive-".$_FILES["article_img"]["name"];
		$imgUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"."/news_aggregator/uploads/executives/".$newfilename;
		$uploadOk = 1;
		$imageFileType = pathinfo($target_dir . basename($_FILES["article_img"]["name"]),PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["article_img"]["tmp_name"]);
	    if($check !== false) {
	        $imgerrormsg = "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        $imgerrormsg = "File is not an image.";
	        $uploadOk = 0;
	    }
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			// echo "eeeeeee";
		    $imgerrormsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    $imgerrormsg = "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($filename, $target_dir.$newfilename)) {
		        $imgerrormsg = "The file ". basename( $_FILES["article_img"]["name"]). " has been uploaded.";
		        $con = $fun->conOpen();
				$channel = (empty($channel)) ? "" : mysqli_real_escape_string($con,$channel);
				$name = (empty($_POST['name'])) ? "" : mysqli_real_escape_string($con,$_POST['name']);
				$image_link = (empty($imgUrl)) ? "" : mysqli_real_escape_string($con,$imgUrl);
				$sqls = "SELECT * FROM executives WHERE image_link = '".$image_link."'";
			    $querys = mysqli_query($con, $sqls);
			    $sdata = mysqli_fetch_assoc($querys);
			    if(empty($sdata)){
			    	mysqli_query($con, "INSERT INTO executives(`channel`, `name`, `image_link`) VALUES('".$channel."', '".$name."', '".$image_link."') ");
			        $errormsg = '<div class="alert alert-success"><strong>Success!</strong> Add successfully.</div>';
			    }
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
		<h2 class="heading">Add <?php echo strtoupper($channel); ?> Key Executives <a class="btn btn-default pull-right" href="executives.php?tkr=<?php echo $channel; ?>">Back To Executives Page</a></h2>
		<div><?php echo $errormsg; ?></div>
		<form method="post" enctype="multipart/form-data"> 
			<div class="form-group">
				<input type="text" name="name" value="<?php echo (!empty($_POST['name']) ? $_POST['name'] : ""); ?>" class="form-control" placeholder="Name">
			</div>
			<div class="form-group">
				<?php echo $imgerrormsg; ?>
				<input type="file" name="article_img" id="article_img" class="form-control">
			</div>
			<button type="submit" class="btn btn-default" name="add">Add</button>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>