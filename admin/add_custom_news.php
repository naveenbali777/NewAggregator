<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$errormsg = "";
$imgerrormsg = "";
// Check if image file is a actual image or fake image
if(isset($_POST["add"])) {
	$articleData = array();
	$imgUrl = "";
	if(!empty($_FILES["article_img"]["name"])){		
		$target_dir = "../uploads/";
		$filename=$_FILES["article_img"]["tmp_name"];
		$newfilename=time()."-".$_FILES["article_img"]["name"];
		$imgUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"."/news_aggregator/uploads/".$newfilename;
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
		// Check file size
		if ($_FILES["article_img"]["size"] > 500000) {
		    $imgerrormsg = "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
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
		    } else {
		        $imgerrormsg = "Sorry, there was an error uploading your file.";
		    }
		}
	}
	$articleData['article_title'] = (!empty($_POST['article_title'])) ? $_POST['article_title'] : "";
	$articleData['category_id'] = (!empty($_POST['category_id'])) ? $_POST['category_id'] : "";
	$articleData['article_author'] = (!empty($_POST['article_author'])) ? $_POST['article_author'] : "";
	$articleData['article_txt'] = (!empty($_POST['article_txt'])) ? str_replace("<p></p>", "", $_POST['article_txt']) : "";
	$articleData['article_img'] = $imgUrl;
	$articleData['article_actual_date'] = date('F d, Y');
	$articleData['website_id'] = 9999;
	$articleData['custom_news'] = '1';
	$result = $fun->insertArticle(article_table,$articleData);
	if($result == "insert"){
		$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Insert successfully.</div>';
	}
	if($result == "exists"){
		$errormsg = '<div class="alert alert-warning"><strong>Warning!</strong> News title already exists.</div>';
	}
}
$categoryArray = $fun->getTableData("category");
$category_id = (!empty($_POST['category_id']) ? $_POST['category_id'] : 0);
?>
<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
<script>
  tinymce.init({
    selector: '#mytextarea'
  });
  </script>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Add Custom News</h2>
		<div><?php echo $errormsg; ?></div>
		<form method="post" enctype="multipart/form-data"> 
			<div class="form-group">
				<input type="text" class="form-control" name="article_title" placeholder="Article Title" value="<?php echo (!empty($_POST['article_title']) ? $_POST['article_title'] : ""); ?>" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="article_author" placeholder="Article Author" value="<?php echo (!empty($_POST['article_author']) ? $_POST['article_author'] : ""); ?>">
			</div>
			<div class="form-group">
				<?php echo $imgerrormsg; ?>
				<input type="file" name="article_img" id="article_img" class="form-control">
			</div>
			<div class="form-group">
				<select name="category_id" class="form-control" required>
					<option value="">Select Category</option>
					<?php foreach ($categoryArray as $key => $value) { ?>
						<option value="<?php echo $value['id']; ?>" <?php echo ($category_id == $value['id']) ? "selected" : ""; ?> ><?php echo $value['name']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<textarea placeholder="Site Note" class="form-control" name="article_txt" id="mytextarea"><?php echo (!empty($_POST['article_txt']) ? $_POST['article_txt'] : ""); ?></textarea>
			</div>
			<button type="submit" class="btn btn-default" name="add">Add</button>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>