<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$errormsg = "";
if(isset($_POST['add'])){
	$data = array();
	$data['name'] = (!empty($_POST['name'])) ? $_POST['name'] : "";
	$response = $fun->insert_tags($data);
	if($response == "insert"){
		$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Insert successfully.</div>';
		header("location:tags.php");
	}
	if($response == "exists"){
		$errormsg = '<div class="alert alert-danger">Tags Is Allready Exists.</div>';
	}
}
$categoryArray = $fun->getTableData("category");
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Add New Tags</h2>
		<div><?php echo $errormsg; ?></div>
		<form method="post">
			<div class="form-group">
				<input type="text" class="form-control" name="name" placeholder="Tags" required>
			</div>
			<button type="submit" class="btn btn-default" name="add">Add</button>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>