<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$id = (!empty($_GET['id'])) ? $_GET['id'] : 0;
$errormsg = "";
$condition = " where websites.`id` = $id";
$dataArray = $fun->getwebsites($condition);
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
		<?php foreach ($dataArray as $key => $value) { ?>
		<div class="row">
			<div class="col-sm-12">
				<div><?php echo $errormsg; ?></div>
				<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back to suggested sources</a>
				<h2 class="heading"><?php echo $value['name']; ?></h2>
			</div>			
		</div>
		<div class="row">
	      	<div class="col-sm-12">
	      		<p><b>Website Name : </b><?php echo $value['category_name']; ?></p>
	      		<p><b>Website Url : </b><?php echo $value['url']; ?></p>
	      		<p><b>Alexa Rank : </b><?php echo $value['alexa_rank']; ?></p>
	      		<?php if(!empty($value['note'])){ ?>
	      		<p><b>Note : </b><?php echo $value['note']; ?></p>
	      		<?php }
	      		if(!empty($value['tags'])){ ?>
	      		<p><b>Tags : </b><?php echo $value['tags']; ?></p>
	      		<?php } ?>
	      		<?php if(!empty($value['ip_address'])){ ?>
	      		<p><b>Ip Address : </b><?php echo $value['ip_address']; ?></p>
	      		<?php } ?>
	      		<p><b>Date : </b><?php echo date('d F Y', strtotime($value['created_at'])); ?></p>
	      		<?php if(!empty($value['tags'])){ ?>
	      		<p><b>Tags : </b><?php echo $value['ip_address']; ?></p>
	      		<?php } ?>
	      	</div>
		</div>
		<?php } ?>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>