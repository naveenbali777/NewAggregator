<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$errormsg = "";
if(isset($_POST["add"])) {
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
    
    $sqls = "SELECT * FROM static_page WHERE page_name = '".$page_name."'";
    $querys = mysqli_query($con, $sqls);
    $sdata = mysqli_fetch_assoc($querys);
    if(empty($sdata)){
    	mysqli_query($con, "INSERT INTO static_page(`page`, `page_name`, `title`, `meta_description`, `about_content`, `content`) VALUES('".$page."', '".$page_name."', '".$title."', '".$meta_description."', '".$about_content."', '".$content."') ");
        $errormsg = '<div class="alert alert-success"><strong>Success!</strong> Add successfully.</div>';
    }else{
    	$errormsg = '<div class="alert alert-warning"><strong>Warning!</strong> Page already exists.</div>';
    }
    mysqli_close($con);	
}
$page_name = (!empty($_POST['page_name']) ? $_POST['page_name'] : "");
?>
<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
<script>
  tinymce.init({
    selector: '#mytextarea'
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
		<h2 class="heading">Add Static Page</h2>
		<div><?php echo $errormsg; ?></div>
		<form method="post">
			<div class="form-group">
				<input type="text" class="form-control" name="page" placeholder="Page" value="<?php echo (!empty($_POST['page']) ? $_POST['page'] : ""); ?>" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo (!empty($_POST['title']) ? $_POST['title'] : ""); ?>" required>
			</div>
			<div class="form-group">
				<textarea placeholder="Meta Description" class="form-control" name="meta_description" required><?php echo (!empty($_POST['meta_description']) ? $_POST['meta_description'] : ""); ?></textarea>
			</div>
			<div class="form-group">
				<label>Static Content</label>
				<textarea placeholder="About Canadian Content" class="form-control" name="about_content" id="mytextarea"><?php echo (!empty($_POST['about_content']) ? $_POST['about_content'] : ""); ?></textarea>
			</div>
			<div class="form-group">
				<label>Page Content</label>
				<textarea placeholder="About Canadian Content" class="form-control" name="content" id="mytextarea2"><?php echo (!empty($_POST['content']) ? $_POST['content'] : ""); ?></textarea>
			</div>
			<button type="submit" class="btn btn-default" name="add">Add</button>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>