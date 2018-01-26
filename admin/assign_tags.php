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
	$response = $fun->assign_tags($data);
	if($response == "updated"){
		$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Assign successfully.</div>';
	}
}
if(isset($_POST['assignExc'])){
	$exclusive = (!empty($_POST['exclusive'])) ? "yes" : "no";
	$con = $fun->conOpen();
	mysqli_query($con, "UPDATE company SET `exclusive` = '$exclusive' WHERE id = $id");
	mysqli_close($con);
	$excTxt = ($exclusive == "yes") ? 'exclusive' : 'unexclusive';
	$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Set '.$excTxt.' successfully.</div>';
	
}
if(isset($_POST['setCompanyText'])){
	$company_text = (!empty($_POST['company_text'])) ? $_POST['company_text'] : "";
	$con = $fun->conOpen();
	mysqli_query($con, "UPDATE company SET `company_text` = '$company_text' WHERE id = $id");
	mysqli_close($con);
	$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Set company text successfully.</div>';
	
}
$where = " where id = $id";
$dataArray = $fun->getTableData("company",$where);
$tagsArray = $fun->getTableData("tags");
$tags = (!empty($dataArray[0]['tags'])) ? $dataArray[0]['tags'] : "";
$exclusive = (!empty($dataArray[0]['exclusive'])) ? $dataArray[0]['exclusive'] : "";
$company_text = (!empty($dataArray[0]['company_text'])) ? $dataArray[0]['company_text'] : "";
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
							<td class="col-sm-11">
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
		<form method="post">
  		<div class="row" style="border: 1px solid #bbb;padding: 4px;margin:2px;background-color: #eee">
  			<div class="col-sm-1"><input type="checkbox" name="exclusive" class="form-control" <?php echo ($exclusive == "yes") ? "checked" : ""; ?> ></div>
  			<div class="col-sm-3">Set as exclusive company</div>
  			<div class="col-sm-1">
  				<button type="submit" class="btn btn-default" name="assignExc">Set</button>
  			</div>
  			<div class="col-sm-5"><input type="text" class="form-control" name="company_text" value="<?php echo $company_text; ?>"></div>
  			<div class="col-sm-2"><button type="submit" class="btn btn-default" name="setCompanyText">Set Text</button></div>
  		</div>
  		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>