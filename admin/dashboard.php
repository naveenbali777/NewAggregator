<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$dataArray = $fun->getTableData("category");
// echo "<pre>";
// print_r($categories);
// exit;

?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Categories</h2>
		<div class="BoxContent">
	      	<table class="table table-bordered">
				<thead>
					<tr>
						<th>Category</th>
						<!-- <th>Action</th> -->
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dataArray as $key => $value) { ?>
					<tr>
						<td><?php echo $value['name']; ?></td>
						<!-- <td>Edit | Delete</td> -->
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