<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$page_name = "company_images.php";
$errormsg = "";
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$ticker = (!empty($_GET['tkr'])) ? $_GET['tkr'] : "";
if(isset($_GET['del'])){
	$del = $_GET['del'];
	$con = $fun->conOpen();
	$fun->remove_file("banner_images",$del);
	mysqli_query($con, "DELETE FROM banner_images WHERE id = $del");
	mysqli_close($con);
	$errormsg = '<div class="alert alert-danger"><strong>Deleted!</strong> Delete successfully.</div>';
}
$index = 20;
$start = ($page == 1) ? 0 : ($page-1)*$index;
$extraprm = "";
$condition = "";
if($ticker != ""){
	$extraprm = $extraprm."&tkr=".$ticker;
}
$condition = ($ticker != "") ? " where channel LIKE '$ticker'" : "";
$totalCount = $fun->recordCount("banner_images", $condition);
$condition = $condition." order by channel asc limit $start,$index";
$from = ($start == 0) ? 1 : $start+1;
$to = $start+$index;
$to = ($to <= $totalCount) ? $to : $totalCount;
$dataArray = $fun->getTableData("banner_images",$condition);
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<div class="col-sm-12">
			<h2 class="heading"><?php echo strtoupper($ticker); ?> Banner Images <a class="btn btn-default pull-right" href="add_banner_images.php?tkr=<?php echo $ticker; ?>">Add Banner Images</a></h2>
		</div>
		<div class="col-sm-12">
			<div><?php echo $errormsg; ?></div>
		</div>
		<div class="col-sm-12">
			<h4><?php echo ($totalCount > 0) ? "Showing $from to $to of $totalCount" : " No record found."; ?></h4>
		</div>
		<div class="col-sm-12">
			<div class="BoxContent">
		      	<table class="table table-fixed">
					<thead>
						<tr>
							<th class="col-sm-2">Ticker</th>
							<th class="col-sm-7">Image</th>
							<th class="col-sm-2">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) { ?>
						<tr>
							<td class="col-sm-2"><?php echo strtoupper($value['channel']); ?></td>
							<td class="col-sm-7"><img src="<?php echo $value['image_link']; ?>" class="bannerThumb" ></td>
							<td class="col-sm-2"><a href="banner_images.php?tkr=<?php echo $ticker.'&del='.$value['id'];?>" onclick="return confirm('Are you Sure.');">Delete</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-12">
			<?php echo $fun->pagination_get($page_name,$totalCount,$index,$page,$extraprm); ?>
		</div>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>