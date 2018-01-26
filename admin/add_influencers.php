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
		$data = str_replace("\n", ",", $data);
		$data = str_replace('"', "", $data);
		$dataArray = explode(",", $data);
		if(!empty($dataArray)){
			$d = 1;
			foreach ($dataArray as $key => $value) {
				$sData = array();
				$sData['name'] = trim($value," ");
				$sData['slug'] = strtolower(str_replace(" ", "-", $sData['name']));
				if(!empty($sData['name']) && strlen($sData['name']) > 4){
					$fun->insertdata("influencers",$sData);
					
				}
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
		<h2 class="heading">Import New Influencers</h2>
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