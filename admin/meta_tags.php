<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$errormsg = "";
$dataArray = $fun->getTableData("meta_tags");

?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Meta Tags<a class="btn btn-default pull-right" href="add_meta_tags.php">Add Meta Tags</a></h2>
		<div><?php echo $errormsg; ?></div>
		<div class="BoxContent">
	      	<table class="table table-fixed">
				<thead>
					<tr>
						<th class="col-sm-2">Page</th>
						<th class="col-sm-3">Title</th>
						<th class="col-sm-4">Meta Description</th>
						<!-- <th class="col-sm-3">About Canadian</th> -->
						<th class="col-sm-2">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dataArray as $key => $value) { ?>
					<tr>
						<td class="col-sm-2"><?php echo ucfirst(str_replace("-", " ", $value['page_name'])); ?></td>
						<td class="col-sm-3"><?php echo $value['title']; ?></td>
						<td class="col-sm-4"><?php echo $value['meta_description']; ?></td>
						<!-- <td class="col-sm-3"><?php echo $value['about_content']; ?></td> -->
						<td class="col-sm-2"><a href="edit_meta_tags.php?id=<?php echo $value['id']; ?>">Edit</a></td>
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