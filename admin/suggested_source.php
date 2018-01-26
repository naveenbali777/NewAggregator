<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$errormsg = "";
if(!empty($_GET['del'])){
	$fun->deleteData("websites", $_GET['del']);
	$errormsg = '<div class="alert alert-success"><strong>Deleted!</strong> Delete successfully.</div>';
}
// $dataArray = $fun->getwebsites(" where suggested = 'yes' order by alexa_rank asc");
$dataArray = $fun->getwebsites(" where suggested = 'yes' order by created_at desc");
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Suggested Source<a class="btn btn-default pull-right" href="add_source.php">Add Source</a></h2>
		<div><?php echo $errormsg; ?></div>
		<div class="BoxContent">
	      	<table class="table table-fixed">
				<thead>
					<tr>
						<th class="col-sm-2">Website Name</th>
						<th class="col-sm-2">Category</th>
						<th class="col-sm-4">Website Url</th>
						<th class="col-sm-1">Approved</th>
						<!-- <th class="col-sm-2">Note</th> -->
						<th class="col-sm-2">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dataArray as $key => $value) { ?>
					<tr>
						<td class="col-sm-2"><?php echo $value['name']; ?></td>
						<td class="col-sm-2"><?php echo $value['category_name']; ?></td>
						<td class="col-sm-4"><?php echo $value['url']; ?></td>
						<td class="col-sm-1"><?php echo ($value['active'] == "yes") ? "Yes" : "No"; ?></td>
						<!-- <td class="col-sm-2"><?php echo $value['note']; ?></td> -->
						<td class="col-sm-2"><a href="suggested_source_detail.php?id=<?php echo $value['id']; ?>">View</a><?php if($value['active'] == "no"){ ?> | <a href="suggested_source.php?del=<?php echo $value['id']; ?>" onclick="return confirm('Are you Sure.');">Delete</a> <?php } ?></td>
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