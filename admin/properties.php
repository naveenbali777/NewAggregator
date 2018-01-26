<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$ticker = (!empty($_GET['tkr'])) ? $_GET['tkr'] : "";
$condition = ($ticker != "") ? " where channel LIKE '$ticker' limit 1" : "";
$dataArray = $fun->getTableData("properties",$condition);
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<div class="col-sm-12">
			<h2 class="heading"><?php echo strtoupper($ticker); ?> Properties<a class="btn btn-default pull-right" href="add_properties.php?tkr=<?php echo $ticker; ?>">Add Properties</a></h2>
		</div>
		<div class="col-sm-12">
			<div class="BoxContent">
		      	<table class="table table-fixed">
					<tbody>
						<?php foreach ($dataArray as $key => $value) { ?>
						<tr>
							<td class="col-sm-3"><b>About</b></td>
							<td class="col-sm-8"><?php echo $value['about'] ?></td>
						</tr>
						<tr>
							<td class="col-sm-3"><b>Map</b></td>
							<td class="col-sm-8"><?php echo $value['map'] ?></td>
						</tr>
						<tr>
							<td class="col-sm-3"><b>Financing & paper</b></td>
							<td class="col-sm-8"><?php echo $value['financing'] ?></td>
						</tr>
						<tr>
							<td class="col-sm-3"><b>Catalyst</b></td>
							<td class="col-sm-8"><?php echo $value['catalyst'] ?></td>
						</tr>
						<tr>
							<td class="col-sm-3"><b>Politics</b></td>
							<td class="col-sm-8"><?php echo $value['politics'] ?></td>
						</tr>
						<tr>
							<td class="col-sm-3"><b>Media coverage</b></td>
							<td class="col-sm-8"><?php echo $value['media_coverage'] ?></td>
						</tr>
						<tr>
							<td class="col-sm-3"><b>Challenges</b></td>
							<td class="col-sm-8"><?php echo $value['challenges'] ?></td>
						</tr>
						<tr>
							<td class="col-sm-3"><b>Question Heading</b></td>
							<td class="col-sm-8"><?php echo $value['question_heading'] ?></td>
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