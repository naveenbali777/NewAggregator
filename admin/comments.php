<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$id = (!empty($_GET['id'])) ? $_GET['id'] : 1;
$dataArray = $fun->getCompanyCmt($id," order by c_timestamp desc");
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
      <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a>
		<h2 class="heading">Comments</h2>
		<div class="BoxContent">
	      	<table class="table table-fixed">
				<thead>
					<tr>
						<th class="col-sm-8">Title</th>
						<th class="col-sm-2">Date</th>
						<th class="col-sm-1">Like</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dataArray as $key => $value) { 
						$cmtDate = (!empty($value['c_timestamp'])) ? date('d M Y H:i',$value['c_timestamp']) : "";
						$percent_change = (!empty($value['percent_change'])) ? $value['percent_change'] : "";
					?>
					<tr>
						<td class="col-sm-8"><?php echo $value['spiel']; ?></td>
						<td class="col-sm-2"><?php echo $cmtDate; ?></td>
						<td class="col-sm-1"><?php echo $value['votes']; ?></td>
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