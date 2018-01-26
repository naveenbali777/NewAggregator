<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$page_name = "company_list.php";
$sec = (!empty($_GET['sec'])) ? $_GET['sec'] : "";
$serchTxt = (!empty($_GET['serchTxt'])) ? $_GET['serchTxt'] : "";
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$index = 50;
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
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Companies List</h2>
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
							<th class="col-sm-2">Company Name</th>
							<th class="col-sm-1">Symbol</th>
							<th class="col-sm-3">Domain Name</th>
							<th class="col-sm-3">Logo</th>
							<th class="col-sm-2">Note</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) { 
							$symbol = $value['symbol'];
							$symbolArray = explode(".", $symbol);
							$scode = strtolower(current($symbolArray));
							$company_url = $value['company_url'];
							$parse = parse_url($company_url);
							$domain = (!empty($parse['host'])) ? $parse['host'] : "";	
						?>
						<tr class="cmpContainer">
							<td class="col-sm-2"><?php echo $value['name']; ?></td>
							<td class="col-sm-1"><?php echo $scode; ?></td>
							<td class="col-sm-3"><?php echo $domain; ?></td>
							<td class="col-sm-3"><img src="<?php echo $value['company_logo']; ?>"></td>
							<td class="col-sm-2">
							<input type="hidden" name="company_id" class="company_id" value="<?php echo $value['id']; ?>">
								<textarea cols="25" rows="4" class="company_note" name="note"><?php echo $value['note']; ?></textarea>
							</td>
						</tr>
						<?php 
						} ?>
					</tbody>
				</table>
			</div>
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