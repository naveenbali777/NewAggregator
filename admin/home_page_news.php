<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$errormsg = "";
$page_heading = "Popular Posts";
if(!empty($_GET['del'])){
	$id = $_GET['del'];
	$con = $fun->conOpen();
	mysqli_query($con, "UPDATE ".article_table." SET `remove` = '1' WHERE id = $id");
	mysqli_close($con);
	$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Delete successfully.</div>';
}
if(!empty($_GET['exc'])){
	$id = $_GET['exc'];
	$con = $fun->conOpen();
	mysqli_query($con, "UPDATE ".article_table." SET `exclusive` = 'yes' WHERE id = $id");
	mysqli_close($con);
	$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Set exclusive successfully.</div>';
}
if(!empty($_GET['unexc'])){
	$id = $_GET['unexc'];
	$con = $fun->conOpen();
	mysqli_query($con, "UPDATE ".article_table." SET `exclusive` = 'no' WHERE id = $id");
	mysqli_close($con);
	$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Set unexclusive successfully.</div>';
}

$type = (!empty($_GET['type'])) ? $_GET['type'] : "popular";
if($type == "popular"){
	$condition = " where `remove` = '0' order by popular desc, rank asc limit 0,5";
	$dataArray = $fun->getTableData(article_table, $condition);
	$page_heading = "Popular Posts";
}
if($type == "recent"){
	$condition = " where `remove` = '0' order by recent desc, article_date desc limit 0,5";
	$dataArray = $fun->getTableData(article_table, $condition);
	$page_heading = "Recent News";
}
if($type == "main"){
	$condition = " where `remove` = '0' and `article_img` != '' order by latest desc, article_date desc limit 0,1";
	$dataArray = $fun->getTableData(article_table, $condition);
	$page_heading = "LATEST NEWS & POSTS";
}
// echo "<pre>";
// print_r($dataArray);
// exit;
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<div class="col-sm-12">
			<h2 class="heading"><?php echo $page_heading; ?>
				<a href="./home_page_news.php?type=main" class="pageLinks">LATEST NEWS & POSTS</a>
				<a href="./home_page_news.php?type=recent" class="pageLinks">Recent News</a>
				<a href="./home_page_news.php?type=popular" class="pageLinks">Popular Posts</a>
			</h2>
		</div>
		<div class="col-sm-12">
			<div><?php echo $errormsg; ?></div>
		</div>
		<div class="col-sm-12">
			<h4></h4>
		</div>
		<div class="col-sm-12">
			<?php if(!empty($dataArray)){ ?>
			<div class="BoxContent">
		      	<table class="table table-fixed">
					<thead>
						<tr>
							<th class="col-sm-7">Title</th>
							<th class="col-sm-2">Date</th>
							<th class="col-sm-2">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) { ?>						
						<tr>
							<td class="col-sm-7"><?php echo $value['article_title'] ?></td>
							<td class="col-sm-2"><?php echo $value['article_actual_date'] ?></td>
							<td class="col-sm-2">
								<a href="home_page_news.php?del=<?php echo $value['id']."&type=".$type; ?>" onclick="return confirm('Are you Sure.');">Delete</a> | 
								<?php if($value['exclusive'] == "no"){ ?>
								<a href="home_page_news.php?exc=<?php echo $value['id']."&type=".$type; ?>" onclick="return confirm('Are you Sure.');">Exclusive</a>
								<?php }else{ ?>
								<a href="home_page_news.php?unexc=<?php echo $value['id']."&type=".$type; ?>" onclick="return confirm('Are you Sure.');">Unexclusive</a>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<?php } ?>
		</div>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>