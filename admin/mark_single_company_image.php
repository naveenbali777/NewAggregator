<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$page_name = "single_company_image.php";

$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$ticker = (!empty($_GET['tkr'])) ? $_GET['tkr'] : "";
$index = 20;
$start = ($page == 1) ? 0 : ($page-1)*$index;
$extraprm = "";
$condition = "";
if($ticker != ""){
	$extraprm = $extraprm."&tkr=".$ticker;
}
$condition = ($ticker != "") ? " where channel LIKE '$ticker' and `status` = 'yes'" : " where `status` = 'yes'";
if(!empty($ticker)){
	$condition = (!empty($condition)) ? $condition." and channel LIKE '".$ticker."' and `status` = 'yes'" : " where channel LIKE '".$ticker."' and `status` = 'yes'";
}
$totalCount = $fun->recordCount('company_images', $condition);
$condition = $condition." order by channel desc limit $start,$index";
$from = ($start == 0) ? 1 : $start+1;
$to = $start+$index;
$to = ($to <= $totalCount) ? $to : $totalCount;
$dataArray = $fun->getTableData("company_images",$condition);
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<div class="col-sm-12">
			<h2 class="heading">Selected <?php echo strtoupper($ticker); ?> Company Images</h2>
		</div>
		<div class="col-sm-12">
			<h4><?php echo ($totalCount > 0) ? "Showing $from to $to of $totalCount" : " No record found."; ?></h4>
		</div>
		<div class="col-sm-12">
			<div class="row">
				<?php foreach ($dataArray as $key => $value) { ?>
				<div class="col-sm-2 fixHeight">
					<a target="_blank" href="<?php echo $value['image_link']; ?>"><img src="<?php echo $value['image_link']; ?>"></a>
					<div class="actionBox">
						<input type="checkbox" class="cmp_images" name="cmp_images" value="<?php echo $value['id']; ?>" <?php if($value['status'] == "yes"){ echo "checked"; } ?> > Select
					</div>
				</div>
				<?php } ?>
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