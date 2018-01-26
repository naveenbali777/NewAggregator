<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$index = 20;
$start = ($page == 1) ? 0 : ($page-1)*$index;
$page_name = "news.php";
if(isset($_POST['search'])){
	$_SESSION['category_id'] = $_POST['category_id'];
	$_SESSION['website_id'] = $_POST['website_id'];
	$_SESSION['article_date'] = $_POST['article_date'];
}
$condition = (!empty($_SESSION['category_id'])) ? " where articles_new1.category_id = ".$_SESSION['category_id'] : "";
if(!empty($_SESSION['website_id'])){
	$condition = (!empty($condition)) ? $condition." and articles_new1.website_id = ".$_SESSION['website_id'] : " where articles_new1.website_id = ".$_SESSION['website_id'];
}
if(!empty($_SESSION['article_date'])){
	$condition = (!empty($condition)) ? $condition." and articles_new1.article_date like '%".$_SESSION['article_date']."%'" : " where articles_new1.article_date like '%".$_SESSION['article_date']."%'";
}
$totalCount = $fun->recordCount('articles_new1', $condition);
$condition = $condition." order by articles_new1.article_date desc limit $start,$index";

$from = ($start == 0) ? 1 : $start+1;
$to = $start+$index;
$to = ($to <= $totalCount) ? $to : $totalCount;


$dataArray = $fun->getnews($condition);
// $categoryArray = $fun->getTableData("category");
$categoryArray = $fun->getcategorygroupby();
// $websiteArray = $fun->getTableData("websites");
$websiteArray = $fun->getwebsitesgroupby();
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<div class="col-sm-12">
			<h2 class="heading">News</h2>
		</div>
		<div class="col-sm-12">
			<form method="post">
				<div class="row">
					<div class="col-sm-3">
						<select name="category_id" class="form-control">
							<option value="">Select Category</option>
							<?php foreach ($categoryArray as $key => $value) { ?>
								<option <?php if(isset($_SESSION['category_id'])){ if($_SESSION['category_id'] == $value['id']){ echo "selected"; } } ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-sm-3">
						<select name="website_id" class="form-control">
							<option value="">Select Website</option>
							<?php foreach ($websiteArray as $key => $value) { ?>
								<option <?php if(isset($_SESSION['website_id'])){ if($_SESSION['website_id'] == $value['id']){ echo "selected"; } } ?> value="<?php echo $value['id']; ?>"><?php echo $value['url']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-sm-3">
						<input type="date" name="article_date" value="<?php if(isset($_SESSION['article_date'])){ echo $_SESSION['article_date']; } ?>" class="form-control">
					</div>
					<div class="col-sm-2">
						<button class="btn btn-default" type="submit" name="search">
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
		      	<table class="table table-bordered">
					<thead>
						<tr>
							<th>Title</th>
							<th>Category</th>
							<th>Website</th>
							<th>Author</th>
							<th>Date</th>
							<th>Image</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) { ?>
						<tr>
							<td class="max-width"><?php echo $value['article_title']; ?></td>
							<td><?php echo $value['category_name']; ?></td>
							<td><?php echo $value['website_name']; ?></td>
							<td><?php echo $value['article_author']; ?></td>
							<td><?php echo $value['article_actual_date']; ?></td>
							<td><?php if(!empty($value['article_img'])){ echo "<img class='thumbImg' src='".$value['article_img']."'>"; } ?></td>
							<td><a href="news_detail.php?id=<?php echo $value['id']; ?>">View</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-12">
			<?php echo $fun->pagination($page_name,$totalCount,$index,$page); ?>
		</div>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>