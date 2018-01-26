<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$page_name = "enhanced_company.php";
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
		$con = $fun->conOpen();
		foreach ($_POST['companies'] as $key => $cvalue) {
			$company_id = $cvalue;
			// echo $company_id."<br/>";
			mysqli_query($con, "UPDATE company SET `premium` = '1' WHERE `id` = $company_id");
    		$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Active successfully.</div>';
		}
		mysqli_close($con);
	}
}
if(isset($_POST['inactive'])){
	if(!empty($_POST['companies'])){
		$con = $fun->conOpen();
		foreach ($_POST['companies'] as $key => $cvalue) {
			$company_id = $cvalue;
			// echo $company_id."<br/>";
			mysqli_query($con, "UPDATE company SET `premium` = '0' WHERE `id` = $company_id");
    		$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Inactive successfully.</div>';
		}
		mysqli_close($con);
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
		<h2 class="heading">Premium Companies</h2>
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
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<?php if(count($dataArray) > 0){ ?>
				<input type="submit" name="active" value="Active"> <input type="submit" name="inactive" value="Inactive">
			<?php } ?>
		</div>
		<div class="col-sm-12">
			<div class="BoxContent">
		      	<table class="table table-fixed">
					<thead>
						<tr>
							<th class="col-xs-1"><input type="checkbox" id="all_articles"></th>
							<th class="col-sm-4">Company Name</th>
							<th class="col-sm-2">Code</th>
							<th class="col-sm-4">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) { 
							$symbol = $value['symbol'];
							$symbolArray = explode(".", $symbol);
							$scode = strtolower(current($symbolArray));
							$companyName = $value['name'];
							if(!empty($value['company_logo'])){
								$companyName = '<a href="'.$value['company_logo'].'" target="_blank">'.$companyName.'</a>';
							}
							
						?>
						<tr>
							<td class="col-sm-1">
									<input type="checkbox" name="companies[]" class="articlesCheck" value="<?php echo $value['id']; ?>" <?php echo ($value['premium'] == "1") ? "checked" : ""; ?> >
								</td>
							<td class="col-sm-4"><?php echo $companyName; ?></td>
							<td class="col-sm-1"><?php echo $scode; ?></td>
							<td class="col-sm-5"><a href="banner_images.php?tkr=<?php echo $scode; ?>">Banner</a><!--  | <a href="">About</a> --> | <a href="executives.php?tkr=<?php echo $scode; ?>">Executives</a> | <a href="properties.php?tkr=<?php echo $scode; ?>">Properties</a> | <a href="questions.php?tkr=<?php echo $scode; ?>">Question</a> | <a target="_blank" href="http://52.60.98.68:3000/company/profile/preview/<?php echo $scode; ?>">Preview</a></td>
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