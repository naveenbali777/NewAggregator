<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$errormsg = "";
$IP = $_SERVER['REMOTE_ADDR'];
$computerName = gethostbyaddr($IP);
if(isset($_POST['add'])){
	$data = array();
	$data['name'] = (!empty($_POST['name'])) ? $_POST['name'] : "";
	$data['url'] = (!empty($_POST['url'])) ? $_POST['url'] : "";
	$data['note'] = (!empty($_POST['note'])) ? $_POST['note'] : "";
	$data['note'] = (!empty($_POST['note'])) ? $_POST['note'] : "";
	$data['category_id'] = (!empty($_POST['category_id'])) ? $_POST['category_id'] : "";
	$data['suggested'] = "yes";
	$data['ip_address'] = $computerName;
	$response = $fun->insert_website($data);
	if($response == "insert"){
		$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Insert successfully.</div>';
	}
	if($response == "exists"){
		$errormsg = '<div class="alert alert-danger">Source Url Is Allready Exists.</div>';
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
		<h2 class="heading">Add New Source</h2>
		<div><?php echo $errormsg; ?></div>
		<form method="post">
			<div class="form-group">
				<input type="text" class="form-control" name="name" placeholder="Site Name" required>
			</div>
			<div class="form-group">
				<input type="url" class="form-control" name="url" placeholder="Site Url" required>
			</div>
			<div class="form-group">
				<select name="category_id" class="form-control" required>
					<option value="">Select Category</option>
					<?php foreach ($categoryArray as $key => $value) { ?>
						<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<textarea placeholder="Site Note" class="form-control" name="note"></textarea>
			</div>
			<button type="submit" class="btn btn-default" name="add">Add</button>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>