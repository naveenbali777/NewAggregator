<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$id = (!empty($_GET['id'])) ? $_GET['id'] : "";
$errormsg = "";
if(isset($_POST["update"])) {
	$con = $fun->conOpen();
    $page_name = (empty($_POST['page_name'])) ? "" : mysqli_real_escape_string($con,$_POST['page_name']);
    $title = (empty($_POST['title'])) ? "" : mysqli_real_escape_string($con,$_POST['title']);
    $meta_description = (empty($_POST['meta_description'])) ? "" : mysqli_real_escape_string($con,$_POST['meta_description']);
    $about_content = (empty($_POST['about_content'])) ? "" : mysqli_real_escape_string($con,$_POST['about_content']);
    
    $sqls = "SELECT * FROM meta_tags WHERE id = '".$id."'";
    $querys = mysqli_query($con, $sqls);
    $sdata = mysqli_fetch_assoc($querys);
    if(!empty($sdata)){
    	mysqli_query($con, "UPDATE meta_tags SET `title` = '$title', `meta_description` = '$meta_description', `about_content` = '$about_content' WHERE `id` = $id");
    	$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Update successfully.</div>';
    }
    mysqli_close($con);	
}
$dataArray = $fun->getTableData("meta_tags"," where id = $id");
$page_name = (!empty($dataArray[0]['page_name'])) ? $dataArray[0]['page_name'] : "";
$title = (!empty($dataArray[0]['title'])) ? $dataArray[0]['title'] : "";
// $meta_title = (!empty($dataArray[0]['meta_title'])) ? $dataArray[0]['meta_title'] : "";
$meta_description = (!empty($dataArray[0]['meta_description'])) ? $dataArray[0]['meta_description'] : "";
$about_content = (!empty($dataArray[0]['about_content'])) ? $dataArray[0]['about_content'] : "";
?>
<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
<script>
  tinymce.init({
    selector: '#mytextarea',
    height: '260'
  });
</script>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Edit Meta Tags</h2>
		<div><?php echo $errormsg; ?></div>
		<form method="post" enctype="multipart/form-data"> 
			<div class="form-group">
				<select name="page_name" class="form-control" required>
					<option value="">Select Page</option>
					<option <?php echo ($page_name == 'home-page') ? "selected" : ""; ?> value="home-page">Home Page</option>
					<option <?php echo ($page_name == 'gold') ? "selected" : ""; ?> value="gold">Gold</option>
					<option <?php echo ($page_name == 'gold-stocks') ? "selected" : ""; ?> value="gold-stocks">Gold Stocks</option>
					<option <?php echo ($page_name == 'silver') ? "selected" : ""; ?> value="silver">Silver</option>
					<option <?php echo ($page_name == 'silver-stocks') ? "selected" : ""; ?> value="silver-stocks">Silver Stocks</option>
					<option <?php echo ($page_name == 'zinc') ? "selected" : ""; ?> value="zinc">Zinc</option>
					<option <?php echo ($page_name == 'zinc-stocks') ? "selected" : ""; ?> value="zinc-stocks">Zinc Stocks</option>
					<option <?php echo ($page_name == 'platinum') ? "selected" : ""; ?> value="platinum">Platinum</option>
					<option <?php echo ($page_name == 'platinum-stocks') ? "selected" : ""; ?> value="platinum-stocks">Platinum Stocks</option>
					<option <?php echo ($page_name == 'aluminum') ? "selected" : ""; ?> value="aluminum">Aluminum</option>
					<option <?php echo ($page_name == 'aluminum-stocks') ? "selected" : ""; ?> value="aluminum-stocks">Aluminum Stocks</option>
					<option <?php echo ($page_name == 'nickel') ? "selected" : ""; ?> value="nickel">Nickel</option>
					<option <?php echo ($page_name == 'nickel-stocks') ? "selected" : ""; ?> value="nickel-stocks">Nickel Stocks</option>
					<option <?php echo ($page_name == 'copper') ? "selected" : ""; ?> value="copper">Copper</option>
					<option <?php echo ($page_name == 'copper-stocks') ? "selected" : ""; ?> value="copper-stocks">Copper Stocks</option>
					<option <?php echo ($page_name == 'tin') ? "selected" : ""; ?> value="tin">Tin</option>
					<option <?php echo ($page_name == 'tin-stocks') ? "selected" : ""; ?> value="tin-stocks">Tin Stocks</option>
					<option <?php echo ($page_name == 'iron-ore-fines') ? "selected" : ""; ?> value="iron-ore-fines">Iron Ore Fines</option>
					<option <?php echo ($page_name == 'iron-ore-fines-stocks') ? "selected" : ""; ?> value="iron-ore-fines-stocks">Iron Ore Fines Stocks</option>
					<option <?php echo ($page_name == 'palladium') ? "selected" : ""; ?> value="palladium">Palladium</option>
					<option <?php echo ($page_name == 'palladium-stocks') ? "selected" : ""; ?> value="palladium-stocks">Palladium Stocks</option>
					<option <?php echo ($page_name == 'lead') ? "selected" : ""; ?> value="lead">Lead</option>
					<option <?php echo ($page_name == 'lead-stocks') ? "selected" : ""; ?> value="lead-stocks">Lead Stocks</option>
					<option <?php echo ($page_name == 'cobalt') ? "selected" : ""; ?> value="cobalt">Cobalt</option>
					<option <?php echo ($page_name == 'cobalt-stocks') ? "selected" : ""; ?> value="cobalt-stocks">Cobalt Stocks</option>
					<option <?php echo ($page_name == 'uranium') ? "selected" : ""; ?> value="uranium">Uranium</option>
					<option <?php echo ($page_name == 'uranium-stocks') ? "selected" : ""; ?> value="uranium-stocks">Uranium Stocks</option>
					<option <?php echo ($page_name == 'diamonds') ? "selected" : ""; ?> value="diamonds">Diamonds</option>
					<option <?php echo ($page_name == 'diamonds-stocks') ? "selected" : ""; ?> value="diamonds-stocks">Diamonds Stocks</option>
					<option <?php echo ($page_name == 'coal') ? "selected" : ""; ?> value="coal">Coal</option>
					<option <?php echo ($page_name == 'coal-stocks') ? "selected" : ""; ?> value="coal-stocks">Coal Stocks</option>
					<option <?php echo ($page_name == 'potash') ? "selected" : ""; ?> value="potash">Potash</option>
					<option <?php echo ($page_name == 'potash-stocks') ? "selected" : ""; ?> value="potash-stocks">Potash Stocks</option>
					<option <?php echo ($page_name == 'base-metal') ? "selected" : ""; ?> value="base-metal">Base Metal</option>
					<option <?php echo ($page_name == 'base-metal-stocks') ? "selected" : ""; ?> value="base-metal-stocks">Base Metal Stocks</option>
					<option <?php echo ($page_name == 'recent-news') ? "selected" : ""; ?> value="recent-news">Recent News</option>
					<option <?php echo ($page_name == 'popular-post') ? "selected" : ""; ?> value="popular-post">Popular Posts</option>
				</select>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo $title ?>" required>
			</div>
			<!-- <div class="form-group">
				<input type="text" class="form-control" name="meta_title" placeholder="Meta Title" value="<?php echo $meta_title ?>">
			</div> -->
			<div class="form-group">
				<textarea placeholder="Meta Description" class="form-control" name="meta_description"  required><?php echo $meta_description; ?></textarea>
			</div>
			<div class="form-group">
				<label>Static Content</label>
				<textarea placeholder="About Canadian Content" class="form-control" name="about_content" id="mytextarea"><?php echo $about_content; ?></textarea>
			</div>
			<button type="submit" class="btn btn-default" name="update">Update</button>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>