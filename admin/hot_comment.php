<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$page_name = "hot_comment.php";

$author = (!empty($_GET['auth'])) ? urldecode($_GET['auth']) : "";
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$index = 20;
$start = ($page == 1) ? 0 : ($page-1)*$index;
$extraprm = "";
if($author != ""){
	$extraprm = $extraprm."&auth=".$author;
}
$condition = " where influencer = 1";
if($author != ""){
	$condition = (!empty($condition)) ? $condition." and `company_comment`.name LIKE '$author'" : " where `company_comment`.name LIKE '$author'";
}
$totalCount = $fun->recordCount('company_comment', $condition);
$condition = $condition." order by company_comment.c_timestamp desc limit $start,$index";
$from = ($start == 0) ? 1 : $start+1;
$to = $start+$index;
$to = ($to <= $totalCount) ? $to : $totalCount;

$dataArray = $fun->getHotCmt($condition);
$authorArray = $fun->getauthorgroupby(" where influencer = 1");
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Companies Comment</h2>
		<div class="col-sm-12">
			<form method="get">
				<div class="row">
					<div class="col-sm-4">
						<select name="auth" class="form-control">
							<option value="">Select Author</option>
							<?php foreach ($authorArray as $key => $value) { ?>
								<option <?php if($author == $value['name']){ echo "selected"; } ?> value="<?php echo urlencode($value['name']); ?>"><?php echo $value['name']; ?></option>
							<?php } ?>
						</select>
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
							<th class="col-sm-2">Company Name</th>
							<th class="col-sm-2">Author</th>
							<th class="col-sm-1">Symbol</th>
							<th class="col-sm-2">Date</th>
							<th class="col-sm-3">Comment</th>
							<th class="col-sm-1">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) { ?>
						<tr>
							<td class="col-sm-2"><?php echo $value['companyName']; ?></td>
							<td class="col-sm-2"><?php echo $value['name']; ?></td>
							<td class="col-sm-1"><?php echo strtoupper($value['channel']); ?></td>
							<td class="col-sm-2"><?php echo date('d-m-Y H:i:s',$value['c_timestamp']); ?></td>
							<td class="col-sm-3"><?php echo substr($value['spiel'], 0,80).".."; ?></td>
							<td class="col-sm-1"><a href="company_comment_detail.php?id=<?php echo $value['id']; ?>">View</a></td>
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