<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$page_name = "approve_news.php";

$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$category_id = (!empty($_GET['cat'])) ? $_GET['cat'] : 0;
$website_id = (!empty($_GET['web'])) ? $_GET['web'] : 0;
$article_date = (!empty($_GET['adate'])) ? $_GET['adate'] : "";
$article_enddate = (!empty($_GET['aenddate'])) ? $_GET['aenddate'] : "";
$index = 20;
$start = ($page == 1) ? 0 : ($page-1)*$index;
$extraprm = "";
if($category_id != 0){
	$extraprm = $extraprm."&cat=".$category_id;
}
if($website_id != 0){
	$extraprm = $extraprm."&web=".$website_id;
}
if($article_date != ""){
	$extraprm = $extraprm."&adate=".$article_date;
}
if($article_enddate != ""){
	$extraprm = $extraprm."&aenddate=".$article_enddate;
}
$condition = ($category_id != 0) ? " where ".article_table.".category_id = ".$category_id : "";
if($website_id != 0){
	$condition = (!empty($condition)) ? $condition." and ".article_table.".website_id = ".$website_id : " where ".article_table.".website_id = ".$website_id;
}
if(!empty($article_date)){
	// $condition = (!empty($condition)) ? $condition." and ".article_table.".article_date like '%".$article_date."%'" : " where ".article_table.".article_date like '%".$article_date."%'";
	$condition = (!empty($condition)) ? $condition." and ".article_table.".article_date >= '".$article_date."'" : " where ".article_table.".article_date >= '".$article_date."'";
}
if(!empty($article_enddate)){
	$condition = (!empty($condition)) ? $condition." and ".article_table.".article_date <= '".$article_enddate."'" : " where ".article_table.".article_date <= '".$article_enddate."'";
}
$condition = (!empty($condition)) ? $condition." and ".article_table.".status = '1'" : $condition." where ".article_table.".status = '1'";
$totalCount = $fun->recordCount(article_table, $condition);
$condition = $condition." order by ".article_table.".article_date desc limit $start,$index";

$from = ($start == 0) ? 1 : $start+1;
$to = $start+$index;
$to = ($to <= $totalCount) ? $to : $totalCount;
$dataArray = $fun->getnews($condition);
$categoryArray = $fun->getcategorygroupby(" where ".article_table.".status = '1'");
$websiteArray = $fun->getwebsitesgroupby(" where ".article_table.".status = '1'");

if(isset($_POST['inactive'])){
	if(isset($_POST['articles'])){
		foreach ($_POST['articles'] as $key => $value) {
			$fun->inactiveNewsStatus($value);
		}
		header("location:".$_SERVER['HTTP_REFERER']);
	}
}
$count = 1;
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<div class="col-sm-12">
			<h2 class="heading">Approved News</h2>
		</div>
		<div class="col-sm-12">
			<form method="get">
				<div class="row">
					<div class="col-sm-2">
						<select name="cat" class="form-control">
							<option value="">Select Category</option>
							<?php foreach ($categoryArray as $key => $value) { ?>
								<option <?php if($category_id == $value['id']){ echo "selected"; } ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-sm-3">
						<select name="web" class="form-control">
							<option value="">Select Website</option>
							<?php foreach ($websiteArray as $key => $value) { ?>
								<option <?php if($website_id == $value['id']){ echo "selected"; } ?> value="<?php echo $value['id']; ?>"><?php echo $value['url']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-sm-3">
						<input type="date" name="adate" value="<?php echo $article_date; ?>" class="form-control" placeholder="Start Date">
					</div>
					<div class="col-sm-3">
						<input type="date" name="aenddate" value="<?php echo $article_enddate; ?>" class="form-control" placeholder="End Date">
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
							<th class="col-xs-2">Title</th>
							<th class="col-xs-1">Category</th>
							<th class="col-xs-2">Website</th>
							<th class="col-xs-1">Author</th>
							<th class="col-xs-2">Date</th>
							<th class="col-xs-1">Image</th>
							<th class="col-xs-1">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) { ?>
						<tr>
							<td class="col-sm-1">
									<input type="checkbox" name="articles[]" class="articlesCheck" value="<?php echo $value['id']; ?>" >
								</td>
							<td class="col-xs-2"><?php echo $value['article_title']; ?></td>
							<td class="col-xs-1"><?php echo $value['category_name']; ?></td>
							<td class="col-xs-2"><?php echo $value['website_name']; ?></td>
							<td class="col-xs-1"><?php echo $value['article_author']; ?></td>
							<td class="col-xs-2"><?php echo $value['article_actual_date']; ?></td>
							<td class="col-xs-1"><?php if(!empty($value['article_img'])){ echo "<img class='thumbImg' src='".$value['article_img']."'>"; } ?></td>
							<td class="col-xs-1"><a href="news_detail.php?id=<?php echo $value['id']; ?>">View</a></td>
						</tr>
						<?php 
						$count++;
						} ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-12">
		<?php if($count > 1){ ?>
			<input type="submit" name="inactive" value="Unapprove">			
		<?php } ?>
		</div>
		</form>
		<div class="col-sm-12">
			<?php echo $fun->pagination_get($page_name,$totalCount,$index,$page,$extraprm); ?>
		</div>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>