<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$id = (!empty($_GET['id'])) ? $_GET['id'] : "";
$errormsg = "";
if(isset($_POST["update"])) {
	$metaData = array();
	$imgUrl = "";	
	$metaData['page'] = (!empty($_POST['page'])) ? $_POST['page'] : "";
	$metaData['page_name'] = (!empty($metaData['page'])) ? strtolower(str_replace(" ", "-", $metaData['page'])) : "";
	$metaData['title'] = (!empty($_POST['title'])) ? $_POST['title'] : "";
	$metaData['meta_description'] = (!empty($_POST['meta_description'])) ? $_POST['meta_description'] : "";
	$metaData['about_content'] = (!empty($_POST['about_content'])) ? $_POST['about_content'] : "";
	$metaData['content'] = (!empty($_POST['content'])) ? $_POST['content'] : "";

	$con = $fun->conOpen();
    $page = (empty($metaData['page'])) ? "" : mysqli_real_escape_string($con,$metaData['page']);
    $page_name = (empty($metaData['page_name'])) ? "" : mysqli_real_escape_string($con,$metaData['page_name']);
    $title = (empty($metaData['title'])) ? "" : mysqli_real_escape_string($con,$metaData['title']);
    $meta_description = (empty($metaData['meta_description'])) ? "" : mysqli_real_escape_string($con,$metaData['meta_description']);
    $about_content = (empty($metaData['about_content'])) ? "" : mysqli_real_escape_string($con,$metaData['about_content']);
    $content = (empty($metaData['content'])) ? "" : mysqli_real_escape_string($con,$metaData['content']);
    
    $sqls = "SELECT * FROM static_page WHERE id = '".$id."'";
    $querys = mysqli_query($con, $sqls);
    $sdata = mysqli_fetch_assoc($querys);
    if(!empty($sdata)){
    	mysqli_query($con, "UPDATE static_page SET `page` = '$page', `title` = '$title', `meta_description` = '$meta_description', `about_content` = '$about_content', `content` = '$content' WHERE `id` = $id");
    	$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Update successfully.</div>';;
    }
    mysqli_close($con);
}
$dataArray = $fun->getTableData("static_page"," where id = $id");
$page = (!empty($dataArray[0]['page'])) ? $dataArray[0]['page'] : "";
$title = (!empty($dataArray[0]['title'])) ? $dataArray[0]['title'] : "";
$meta_description = (!empty($dataArray[0]['meta_description'])) ? $dataArray[0]['meta_description'] : "";
$about_content = (!empty($dataArray[0]['about_content'])) ? $dataArray[0]['about_content'] : "";
$content = (!empty($dataArray[0]['content'])) ? $dataArray[0]['content'] : "";
?>
<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
<script>
  tinymce.init({
    selector: '#mytextarea',
    height: '220'
  });
  tinymce.init({
    selector: '#mytextarea2',
    height: '220'
  });
</script>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Edit Static Page</h2>
		<div><?php echo $errormsg; ?></div>
		<form method="post">
			<div class="form-group">
				<input type="text" class="form-control" name="page" placeholder="Page" value="<?php echo $page; ?>" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo $title; ?>" required>
			</div>
			<div class="form-group">
				<textarea placeholder="Meta Description" class="form-control" name="meta_description" required><?php echo $meta_description; ?></textarea>
			</div>
			<div class="form-group">
				<label>Static Content</label>
				<textarea placeholder="About Canadian Content" class="form-control" name="about_content" id="mytextarea"><?php echo $about_content; ?></textarea>
			</div>
			<div class="form-group">
				<label>Content</label>
				<textarea placeholder="Content" class="form-control" name="content" id="mytextarea2"><?php echo $content; ?></textarea>
			</div>
			<button type="submit" class="btn btn-default" name="update">Update</button>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>