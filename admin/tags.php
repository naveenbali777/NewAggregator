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
		<h2 class="heading">Tags<a class="btn btn-default pull-right" href="add_tags.php">Add Tags</a></h2>
		<div><?php echo $errormsg; ?></div>
		<div class="BoxContent">
	      	<table class="table table-fixed">
				<thead>
					<tr>
						<th class="col-sm-8">Tags</th>
						<th class="col-sm-3">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dataArray as $key => $value) { ?>
					<tr>
						<td class="col-sm-8"><?php echo $value['name']; ?></td>
						<td class="col-sm-3"><a href="tags.php?del=<?php echo $value['id']; ?>" onclick="return confirm('Are you Sure.');">Delete</a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>