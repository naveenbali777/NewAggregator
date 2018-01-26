<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$id = (!empty($_GET['id'])) ? $_GET['id'] : 1;
$errormsg = "";
if(isset($_POST['assign'])){
	$data = array();
	$data['tags'] = (!empty($_POST['assign_tags'])) ? implode("~", $_POST['assign_tags']) : "";
	$data['id'] = $id;
	$response = $fun->assign_ctags($data);
	if($response == "updated"){
		$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Assign successfully.</div>';
	}
}
$where = " where id = $id";
$dataArray = $fun->getTableData("websites",$where);
$tagsArray = $fun->getTableData("tags");
$tags = (!empty($dataArray[0]['tags'])) ? $dataArray[0]['tags'] : "";
$assignArray = explode("~", $tags);
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Assign Tags</h2>
		<div><?php echo $errormsg; ?></div>
	    <form method="post">
		<div class="BoxContent">
	      	<table class="table table-fixed">
					<tbody>
						<?php foreach ($tagsArray as $key => $value) { ?>
						<tr>
							<td>
								<div class="checkbox">
		  							<label><input type="checkbox" value="<?php echo $value['name']; ?>" name="assign_tags[]" <?php echo (in_array($value['name'], $assignArray)) ? "checked" : ""; ?> ><?php echo $value['name']; ?></label>
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
			</table>
			<button type="submit" class="btn btn-default" name="assign">Assign</button>
		</div>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>