<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$page_name = "company.php";
$sec = (!empty($_GET['sec'])) ? $_GET['sec'] : "";
$serchTxt = (!empty($_GET['serchTxt'])) ? $_GET['serchTxt'] : "";
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$index = 20;
$start = ($page == 1) ? 0 : ($page-1)*$index;
$extraprm = "";
$condition = "";
$errormsg = "";
if(isset($_POST['active'])){
	if(!empty($_POST['companies'])){
		foreach ($_POST['companies'] as $key => $cvalue) {
			$data = array();
			$data['tags'] = (!empty($_POST['assign_tags'])) ? implode("~", $_POST['assign_tags']) : "";
			$data['id'] = $cvalue;
			$response = $fun->assign_tags($data);
			if($response == "updated"){
				$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Assign successfully.</div>';
			}
		}
	}
}

if($sec != ""){
	$extraprm = $extraprm."&sec=".$sec;
}
if($serchTxt != ""){
	$extraprm = $extraprm."&serchTxt=".$serchTxt;
}
$fieldName = ($sec == "cname") ? "name" : "symbol";
$condition = ($serchTxt != "") ? " where company.".$fieldName." LIKE "."'%$serchTxt%'" : "";
$totalCount = $fun->recordCount('company', $condition);
$condition = $condition." order by company.name asc limit $start,$index";
$from = ($start == 0) ? 1 : $start+1;
$to = $start+$index;
$to = ($to <= $totalCount) ? $to : $totalCount;

$dataArray = $fun->getCompany($condition);
$tagsArray = $fun->getTableData("tags");
$count = 1;
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Companies</h2>
		<div><?php echo $errormsg; ?></div>
		<div class="col-sm-12">
			<form method="get">
				<div class="row">
					<div class="col-sm-3">
						<select name="sec" class="form-control" required>
							<option value="">Select Section</option>
							<option <?php if($sec == 'cname'){ echo "selected"; } ?> value="cname">Company Name</option>
							<option <?php if($sec == 'code'){ echo "selected"; } ?> value="code">Company Code</option>
						</select>
					</div>
					<div class="col-sm-3">
						<input type="text" name="serchTxt" value="<?php echo $serchTxt; ?>" class="form-control" required>
					</div>
					<div class="col-sm-1">
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
		<form method="post">
		<div class="col-sm-12">
			<div class="BoxContent">
		      	<table class="table table-fixed">
					<thead>
						<tr>
							<th class="col-xs-1"><input type="checkbox" id="all_articles"></th>
							<th class="col-sm-1">Company Name</th>
							<th class="col-sm-1">Code</th>
							<th class="col-sm-1">Updated Date</th>
							<th class="col-sm-1">Last Trade</th>
							<th class="col-sm-1">Price Change</th>
							<th class="col-sm-1">Percent Change</th>
							<!-- <th class="col-sm-1">Mkt Cap</th> -->
							<th class="col-sm-1">Shares</th>
							<th class="col-sm-1">Volume</th>
							<th class="col-sm-1">Comments</th>
							<th class="col-sm-1">Tags</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) { 
							$priceArrow = "";
							$price_change = (!empty($value['price_change'])) ? round($value['price_change'],'1') : "";
							$percent_change = (!empty($value['percent_change'])) ? round($value['percent_change'],'1') : 0;
							$symbol = $value['symbol'];
							$symbolArray = explode(".", $symbol);
							$scode = strtolower(current($symbolArray));
							$ldate = (!empty($value['c_date'])) ? date('m/d/Y',strtotime($value['c_date']))." ".$value['c_time'] : "";
							if($price_change < 0){
								$priceArrow = '<span class="glyphicon glyphicon-arrow-down" style="color:#a00">'.$price_change.'</span>';
							}
							if($price_change > 0){
								$priceArrow = '<span class="glyphicon glyphicon-arrow-up" style="color:#0a0">'.$price_change.'</span>';
							}

							$tagsData = (!empty($value['tags'])) ? str_replace("~", ", ", $value['tags']) : "Add Tags";
							$companyName = $value['name'];
							if(!empty($value['company_logo'])){
								$companyName = '<a href="'.$value['company_logo'].'" target="_blank">'.$companyName.'</a>';
							}
							
						?>
						<tr>
							<td class="col-sm-1">
									<input type="checkbox" name="companies[]" class="articlesCheck" value="<?php echo $value['id']; ?>" >
								</td>
							<td class="col-sm-1"><?php echo $companyName; ?></td>
							<td class="col-sm-1"><?php echo $scode; ?></td>
							<td class="col-sm-1"><?php echo $ldate; ?></td>
							<td class="col-sm-1"><?php echo round($value['last_trade_price'],'2'); ?></td>
							<td class="col-sm-1"><?php echo $priceArrow; ?></td>
							<td class="col-sm-1"><?php echo $percent_change."%"; ?></td>
							<td class="col-sm-1"><?php echo $value['volume']; ?></td>
							<!-- <td class="col-sm-1"><?php echo $value['mkt_cap']; ?></td> -->
							<td class="col-sm-1"><?php echo $value['shares']; ?></td>
							<td class="col-sm-1"><a href="comments.php?id=<?php echo $value['id']; ?>"><?php echo $value['comments']; ?></a></td>
							<td class="col-sm-1"><a href="assign_tags.php?id=<?php echo $value['id']; ?>"><?php echo $tagsData; ?></a></td>
						</tr>
						<?php 
						$count++;
						} ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-12">
			<?php foreach ($tagsArray as $key => $value) { ?>
			<div class="checkbox" style="float:left;margin-right:6px;padding:4px;margin-top:2px;">
					<label><input type="checkbox" value="<?php echo $value['name']; ?>" name="assign_tags[]"><?php echo $value['name']; ?></label>
			</div>
			<?php } ?>
			<?php if($count > 1){ ?>
				<input type="submit" name="active" value="Assign Tags">			
			<?php } ?>
		</div>
		</form>
      </div>
      <div class="col-sm-12">
			<?php echo $fun->pagination_get($page_name,$totalCount,$index,$page,$extraprm); ?>
		</div> 
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>