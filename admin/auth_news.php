<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$page_name = "auth_news.php";
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$index = 20;
$start = ($page == 1) ? 0 : ($page-1)*$index;
$extraprm = "";
$condition = " group by ".article_table.".`article_author`";
$totalCount = $fun->recordCountGb(article_table, $condition);
$condition = $condition." order by news_count desc limit $start,$index";
$from = ($start == 0) ? 1 : $start+1;
$to = $start+$index;
$to = ($to <= $totalCount) ? $to : $totalCount;
$dataArray = $fun->getnewsBycount($condition);
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">News By Author</h2>
		<div class="col-sm-12">
			<h4><?php echo ($totalCount > 0) ? "Showing $from to $to of $totalCount" : " No record found."; ?></h4>
		</div>
		<div class="col-sm-12">
			<div class="BoxContent">
		      	<table class="table table-fixed">
					<thead>
						<tr>
							<th class="col-sm-8">Aothor</th>
							<th class="col-sm-3">News Count</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) { ?>
						<tr>
							<td class="col-sm-8"><?php echo $value['article_author']; ?></td>
							<td class="col-sm-3"><?php echo $value['news_count']; ?></td>
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