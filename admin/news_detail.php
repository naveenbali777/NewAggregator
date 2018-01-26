<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$id = (!empty($_GET['id'])) ? $_GET['id'] : 1;
$errormsg = "";
if(isset($_POST['assign'])){
	$data = array();
	$exclusive = (!empty($_POST['exclusive'])) ? "yes" : "no";
	$con = $fun->conOpen();
	mysqli_query($con, "UPDATE ".article_table." SET `exclusive` = '$exclusive' WHERE id = $id");
	mysqli_close($con);
	$excTxt = ($exclusive == "yes") ? 'exclusive' : 'unexclusive';
	$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Set '.$excTxt.' successfully.</div>';
	
}
if(isset($_POST['delete'])){
	$con = $fun->conOpen();
	mysqli_query($con, "UPDATE ".article_table." SET `remove` = '1' WHERE id = $id");
	mysqli_close($con);
	$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Delete successfully.</div>';
}
$dataArray = $fun->getsinglenews($id);
$categoryArray = $fun->getTableData("category");
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
				<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back to news list</a>
				<h2 class="heading"><?php echo $value['article_title']; ?></h2>
				<div class="successMsg"><?php echo $errormsg; ?></div>
			</div>			
		</div>
		<form method="post">
	  		<div class="row actionButton" style="border: 1px solid #bbb;padding: 4px;margin:2px;background-color: #eee">
	  			<div class="col-sm-1"><input type="checkbox" name="exclusive" class="form-control" value="<?php echo $value['id']; ?>" <?php echo ($value['exclusive'] == "yes") ? "checked" : ""; ?> ></div>
	  			<div class="col-sm-2">Set Exclusive News</div>
	  			<div class="col-sm-1"><input type="checkbox" name="recent" class="form-control" value="<?php echo $value['id']; ?>" <?php echo ($value['recent'] == "yes") ? "checked" : ""; ?> ></div>
	  			<div class="col-sm-2">Set Recent News</div>
	  			<div class="col-sm-1"><input type="checkbox" name="popular" class="form-control" value="<?php echo $value['id']; ?>" <?php echo ($value['popular'] == "yes") ? "checked" : ""; ?> ></div>
	  			<div class="col-sm-2">Set Popular News</div>
	  			<div class="col-sm-1"><input type="checkbox" name="latest" class="form-control" value="<?php echo $value['id']; ?>" <?php echo ($value['latest'] == "yes") ? "checked" : ""; ?> ></div>
	  			<div class="col-sm-2">Set Latest News</div>
	  		</div>
	  		<div class="row actionButton" style="border: 1px solid #bbb;padding: 4px;margin:2px;background-color: #eee">
	  			<div class="col-sm-4">
	  				<select name="category" class="form-control categoryDrop">
	  					<option value="">Change category</option>
	  					<?php foreach ($categoryArray as $key => $catvalue) { ?>
							<option <?php if($catvalue['id'] == $value['category_id']){ echo "selected"; } ?> value="<?php echo $catvalue['id']."~".$value['id']."~".$catvalue['name']; ?>"><?php echo $catvalue['name']; ?></option>
						<?php } ?>
	  				</select>
	  			</div>
	  			<?php if($value['remove'] == "0"){ ?>
	  			<div class="col-sm-4">
	  				<button type="submit" name="delete" class="btn btn-default" onclick="return confirm('Are you Sure.');">Remove</button>
	  			</div>
	  			<?php } ?>
	  		</div>
  		</form>
		<div class="row">
	      	<div class="col-sm-12">
	      	<h4>
	      	<?php 
	      		$author = (!empty($value['article_author'])) ? "By ".$value['article_author']. " | " : "";
	      		echo $author.$value['article_actual_date'];
	      	?>	      		
	      	</h4>
	      	</div>
	      	<?php if(!empty($value['article_img'])){ 
	      		$mainImg = str_replace("-170x96", "", $value['article_img']);
	      	?>
	      	<div class="col-sm-12">
	      		<?php echo "<img class='fullImg' src='".$mainImg."'>"; ?>	
	      	</div>
	      	<?php } ?>
	      	<div class="col-sm-12">
	      		<p><?php echo $value['article_txt']; ?></p>      		
	      	</div>
		</div>
		<?php } ?>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>