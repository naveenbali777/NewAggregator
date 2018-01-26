<?php 
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$dataArray = $fun->getwebsites("order by alexa_rank asc");
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
      	<div class="col-sm-12">
			<h2 class="heading">Websites</h2>
		</div>
		<div class="col-sm-12">
			<div class="BoxContent">
		      	<table class="table table-fixed">
					<thead>
						<tr>
							<th class="col-sm-3">Website Name</th>
							<th class="col-sm-2">Category</th>
							<th class="col-sm-1">Alexa Rank</th>
							<th class="col-sm-1">Tags</th>
							<th class="col-sm-4">Website Url</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($dataArray as $key => $value) { 
							$tagsData = (!empty($value['tags'])) ? str_replace("~", ", ", $value['tags']) : "Add Tags";
						?>
						<tr>
							<td class="col-sm-3"><?php echo $value['name']; ?></td>
							<td class="col-sm-2"><?php echo $value['category_name']; ?></td>
							<td class="col-sm-1"><?php echo $value['alexa_rank']; ?></td>
							<td class="col-sm-1"><a href="assign_ctags.php?id=<?php echo $value['id']; ?>"><?php echo $tagsData; ?></a></td>
							<td class="col-sm-4"><?php echo $value['url']; ?></td>
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