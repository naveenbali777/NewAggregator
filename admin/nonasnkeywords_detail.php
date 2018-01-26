<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$index = 50;
$start = ($page == 1) ? 0 : ($page-1)*$index;
$page_name = "keywords_detail.php";

$keyword_id = (!empty($_GET['id'])) ? $_GET['id'] : 1;
$name = $fun->getnamebyid("keywords", $keyword_id);
$condition = " WHERE article_txt LIKE '%$name%' OR article_title LIKE '%$name%' order by ".article_table.".article_date desc";
// $totalCount = $fun->recordCount(article_table, $condition);
$dataArray = $fun->keywordnews($condition);
if(isset($_POST['active'])){
	if(isset($_POST['articles'])){
		foreach ($_POST['articles'] as $key => $value) {
			$fun->createRelation($keyword_id, $value);
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
			<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back to previous list</a>
			<h2 class="heading"><?php echo ucfirst($name); ?></h2>
		</div>
		<form method="post">
		<div class="col-sm-12">
			<div class="BoxContent">
		      	<table class="table table-fixed">
					<thead>
						<tr>
							<th class="col-sm-1"><input type="checkbox" id="all_articles"></th>
							<th class="col-sm-2">Serial No.</th>
							<th class="col-sm-2">Title</th>
							<th class="col-sm-2">Author</th>
							<th class="col-sm-2">Date</th>
							<th class="col-sm-2">Image</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) {
							if(empty($value['relationship_id'])){
							?>
							<tr>
								<td class="col-sm-1">
									<input type="checkbox" name="articles[]" class="articlesCheck" value="<?php echo $value['id']; ?>">
								</td>
								<td class="col-sm-2"><?php echo $count; ?></td>
								<td class="col-sm-2"><a href="news_detail.php?id=<?php echo $value['id']; ?>"><?php echo $value['article_title']; ?></a></td>
								<td class="col-sm-2"><?php echo $value['article_author']; ?></td>
								<td class="col-sm-2"><?php echo $value['article_actual_date']; ?></td>
								<td class="col-sm-2"><?php if(!empty($value['article_img'])){ echo "<img class='thumbImg' src='".$value['article_img']."'>"; } ?></td>
							</tr>
							<?php $count++;
							}
						} ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-12">
		<?php if($count > 1){ ?>
			<input type="submit" name="active" value="Approved">			
		<?php } ?>
		</div>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>