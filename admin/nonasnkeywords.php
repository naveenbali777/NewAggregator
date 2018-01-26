<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$dataArray = $fun->getTableData("keywords");
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
      	<div class="col-sm-12">
			<h2 class="heading">Non Approved Keywords News<a class="btn btn-default pull-right" href="add_keywords.php">Import New Keywords</a></h2>
		</div>
		<div class="col-sm-12">
			<div class="BoxContent">
		      	<table class="table table-fixed">
					<thead>
						<tr>
							<th class="col-sm-7">Keywords</th>
							<th class="col-sm-2">News Count</th>
							<th class="col-sm-2">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) { ?>
						<tr>
							<td class="col-sm-7"><?php echo $value['name']; ?></td>
							<td class="col-sm-2">
								<?php echo $value['count']; ?>									
							</td>
							<td class="col-sm-2"><a href="nonasnkeywords_detail.php?id=<?php echo $value['id']; ?>">View</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>