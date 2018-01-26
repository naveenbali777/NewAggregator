<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$id = (!empty($_GET['id'])) ? $_GET['id'] : 0;
$errormsg = "";
if(isset($_POST['assign'])){
	$data = array();
	$analysis = (!empty($_POST['analysis'])) ? "yes" : "no";
	$reviews = (!empty($_POST['reviews'])) ? "yes" : "no";
	$con = $fun->conOpen();
	mysqli_query($con, "UPDATE company_comment SET `reviews` = '$reviews', `analysis` = '$analysis' WHERE id = $id");
	mysqli_close($con);
	$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Assign successfully.</div>';
	
}
$dataArray = $fun->getsinglecompanycomment($id);
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<?php foreach ($dataArray as $key => $value) { ?>
		<div class="row">
			<div class="col-sm-12">
			<div><?php echo $errormsg; ?></div>
				<!-- <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back to company comment list</a> -->
			</div>			
		</div>
		<div class="row">
	      	<div class="col-sm-12">
	      	<h4>
	      	<?php 
	      		echo $value['company_name'];
	      	?>	      		
	      	</h4>
	      	</div>
	      	<div class="col-sm-12">
	      		<p><?php echo (!empty($value['name'])) ? "[".$value['name']."] ".$value['spiel'] : "".$value['spiel']; ?></p>      		
	      	</div>
	      	<div class="col-sm-12">
	      		<form method="post">
	      		<div class="row" style="border: 1px solid #bbb;padding: 4px;margin:2px;background-color: #eee">
	      			<div class="col-sm-1"><input type="checkbox" name="reviews" class="form-control" <?php echo ($value['reviews'] == "yes") ? "checked" : ""; ?> ></div>
	      			<div class="col-sm-2">Set Company Reviews</div>
	      			<div class="col-sm-1"><input type="checkbox" name="analysis" class="form-control" <?php echo ($value['analysis'] == "yes") ? "checked" : ""; ?> ></div>
	      			<div class="col-sm-2">Set Industry Analysis</div>
	      			<div class="col-sm-1">
	      				<button type="submit" class="btn btn-default" name="assign">Assign</button>
	      			</div>
	      		</div>
	      		</form>
	      	</div>
		</div>
		<?php } ?>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>