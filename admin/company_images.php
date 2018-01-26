<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$page_name = "company_images.php";

$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$ticker = (!empty($_GET['tkr'])) ? $_GET['tkr'] : "";
$index = 20;
$start = ($page == 1) ? 0 : ($page-1)*$index;
$extraprm = "";
$condition = "";
if($ticker != ""){
	$extraprm = $extraprm."&tkr=".$ticker;
}
$condition = ($ticker != "") ? " where channel LIKE '$ticker' GROUP BY channel" : " GROUP BY channel";
if(!empty($ticker)){
	$condition = (!empty($condition)) ? $condition." and channel LIKE '".$ticker."'" : " where channel LIKE '".$ticker."'";
}
$totalCount = $fun->countbycompany($condition);
$condition = $condition." order by cnt desc limit $start,$index";
$from = ($start == 0) ? 1 : $start+1;
$to = $start+$index;
$to = ($to <= $totalCount) ? $to : $totalCount;
$dataArray = $fun->getimagesbycompany($condition);
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<div class="col-sm-12">
			<h2 class="heading">Company Images</h2>
		</div>
		<div class="col-sm-12">
			<form method="get">
				<div class="row">
					<div class="col-sm-2">
						<input type="text" name="tkr" value="<?php echo $ticker; ?>" class="form-control" placeholder="Ticker">
					</div>
					<div class="col-sm-2">
						<button class="btn btn-default" type="submit">
					        <span class="glyphicon glyphicon-search"></span>
					    </button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-sm-12">
			<h4><?php echo ($totalCount > 0) ? "Showing $from to $to of $totalCount" : " No record found."; ?></h4>
		</div>
		<div class="col-sm-12">
			<div class="BoxContent">
		      	<table class="table table-fixed">
					<thead>
						<tr>
							<!-- <th class="col-xs-1"><input type="checkbox" id="all_articles"></th> -->
							<th class="col-sm-4">Ticker</th>
							<th class="col-sm-6">Count</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) { ?>
						<tr>
							<td class="col-sm-4"><?php echo strtoupper($value['channel']); ?></td>
							<td class="col-sm-6"><a href="single_company_image.php?tkr=<?php echo $value['channel']; ?>"><?php echo $value['cnt']; ?></a></td>
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