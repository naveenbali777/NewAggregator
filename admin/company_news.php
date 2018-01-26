<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$page_name = "company_news.php";

$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$company_id = (!empty($_GET['cmp'])) ? $_GET['cmp'] : 0;
$ticker = (!empty($_GET['tkr'])) ? $_GET['tkr'] : "";
$news_date = (!empty($_GET['ndate'])) ? $_GET['ndate'] : "";
$news_enddate = (!empty($_GET['nenddate'])) ? $_GET['nenddate'] : "";
$index = 20;
$start = ($page == 1) ? 0 : ($page-1)*$index;
$extraprm = "";
$condition = "";
if($company_id != 0){
	$extraprm = $extraprm."&cmp=".$company_id;
}
if($ticker != ""){
	$extraprm = $extraprm."&smbl=".$ticker;
}
if($news_date != ""){
	$extraprm = $extraprm."&ndate=".$news_date;
}
if($news_enddate != ""){
	$extraprm = $extraprm."&nenddate=".$news_enddate;
}
$condition = ($company_id != 0) ? " where company_news.company_id = ".$company_id : "";
if(!empty($ticker)){
	$condition = (!empty($condition)) ? $condition." and company_news.ticker LIKE '".$ticker."'" : " where company_news.ticker LIKE '".$ticker."'";
}
if(!empty($news_date)){
	$condition = (!empty($condition)) ? $condition." and company_news.news_date >= '".$news_date."'" : " where company_news.news_date >= '".$news_date."'";
}
if(!empty($news_enddate)){
	$condition = (!empty($condition)) ? $condition." and company_news.news_date <= '".$news_enddate."'" : " where company_news.news_date <= '".$news_enddate."'";
}
$totalCount = $fun->recordCount("company_news", $condition);
$condition = $condition." order by company_news.news_time desc limit $start,$index";

$from = ($start == 0) ? 1 : $start+1;
$to = $start+$index;
$to = ($to <= $totalCount) ? $to : $totalCount;
$dataArray = $fun->getcompanynews($condition);
$companyArray = $fun->getcompanygroupby($condition);
// echo "<pre>";
// print_r($companyArray);
// exit;
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<div class="col-sm-12">
			<h2 class="heading">Company News</h2>
		</div>
		<div class="col-sm-12">
			<form method="get">
				<div class="row">
					<div class="col-sm-3">
						<select name="cmp" class="form-control">
							<option value="">Select Website</option>
							<?php foreach ($companyArray as $key => $value) { ?>
								<option <?php if($company_id == $value['id']){ echo "selected"; } ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-sm-2">
						<input type="text" name="tkr" value="<?php echo $ticker; ?>" class="form-control" placeholder="Ticker">
					</div>
					<div class="col-sm-3">
						<input type="date" name="ndate" value="<?php echo $news_date; ?>" class="form-control" placeholder="Start Date">
					</div>
					<div class="col-sm-3">
						<input type="date" name="nenddate" value="<?php echo $news_enddate; ?>" class="form-control" placeholder="End Date">
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
		<div class="col-sm-12">
			<div class="BoxContent">
		      	<table class="table table-fixed">
					<thead>
						<tr>
							<th class="col-sm-3">Title</th>
							<th class="col-sm-2">Company Name</th>
							<th class="col-sm-1">Ticker</th>
							<th class="col-sm-2">Author</th>
							<th class="col-sm-2">Date</th>
							<th class="col-sm-1">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) { ?>
						<tr>
							<td class="col-sm-3"><?php echo $value['title']; ?></td>
							<td class="col-sm-2"><?php echo $value['company_name']; ?></td>
							<td class="col-sm-1"><?php echo $value['ticker']; ?></td>
							<td class="col-sm-2"><?php echo $value['author']; ?></td>
							<td class="col-sm-2"><?php echo date('F d, Y', $value['news_time']); ?></td>
							<td class="col-sm-1"><a href="company_news_detail.php?id=<?php echo $value['id']; ?>">View</a></td>
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