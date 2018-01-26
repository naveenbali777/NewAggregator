<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$errormsg = "";
if(!empty($_GET['del'])){
	$fun->deleteData("tags", $_GET['del']);
	$errormsg = '<div class="alert alert-success"><strong>Deleted!</strong> Delete successfully.</div>';
}
$dataArray = $fun->getTableData("tags");

?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Websites associated with tags</h2>
		<div><?php echo $errormsg; ?></div>
		<div class="BoxContent">
	      	<?php foreach ($dataArray as $key => $value) { 
	      		$where = " where `tags` like'%".$value['name']."%'";
				$websiteArray = $fun->getTableData("websites",$where);
				if(count($websiteArray) > 0){ ?>
				<div class="col-sm-12 tagsBox">
					<button type="button" class="tagsButton" data-toggle="collapse" data-target="#<?php echo $value['name']; ?>"><?php echo $value['name']; ?></button>
					<div id="<?php echo $value['name']; ?>" class="collapse">
						<?php					
						foreach ($websiteArray as $key => $webvalue) { ?>
							<div class="tagsRow">
								<div class="tagsLeft"><?php echo $webvalue['name']; ?></div>
								<div class="tagsRight"><?php echo $webvalue['url']; ?></div>
								<div class="clear"></div>
							</div>
						<?php } ?>
					</div>
				</div>
				<?php } } ?>
		</div>
      </div>  
    </div>
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>