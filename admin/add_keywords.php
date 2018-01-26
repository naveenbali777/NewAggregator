<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$errormsg = "";
if(isset($_POST['upload'])){
	$file = $_FILES["file"]["tmp_name"];
	$fileType = pathinfo($_FILES["file"]["type"]);
	if($fileType['basename'] == 'csv'){
		$data = file_get_contents($file);
		$dataArray = explode("\n", $data);
		if(!empty($dataArray)){
			foreach ($dataArray as $key => $value) {
				$sData = array();
				$sData['name'] = trim($value," ");
				$sData['slug'] = strtolower(str_replace(" ", "-", $sData['name']));
				$fun->insertdata("Keywords",$sData);
			}
			$errormsg = '<div class="alert alert-success"><strong>Success!</strong> File upload successfully.</div>';
		}else{
			$errormsg = '<div class="alert alert-danger">Somthing wrong</div>';
		}
	}else{
		$errormsg = '<div class="alert alert-danger">Not a csv format</div>';
	}
}
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Import New Keywords</h2>
		<div><?php echo $errormsg; ?></div>
		<form method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="Pwd">Upload Csv:</label>
				<input type="file" class="form-control" name="file" required>
			</div>
			<button type="submit" class="btn btn-default" name="upload">Upload</button>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>