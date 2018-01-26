<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$infArray = $fun->getTableData("influencers"," where news_count !=0 order by news_count desc");
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<div class="col-sm-12">
			<h2 class="heading">News By Influencer</h2>
		</div>
		<div class="col-sm-12">
			<h4></h4>
		</div>
		<div class="col-sm-12">
			<div class="BoxContent">
		      	<table class="table table-fixed">
					<thead>
						<tr>
							<th class="col-sm-8">Influencer</th>
							<th class="col-sm-3">News Count</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($infArray as $key => $newvalue) { ?>
						<tr>
							<td class="col-sm-8"><?php echo $newvalue['name']; ?></td>
							<td class="col-sm-3"><?php echo $newvalue['news_count']; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>