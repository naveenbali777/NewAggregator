<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$errormsg = "";
$imgerrormsg = "";
$channel = (!empty($_GET['tkr'])) ? $_GET['tkr'] : "";
if(isset($_POST["add"])) {
	$properties = array();
	$con = $fun->conOpen();
	$channel = $channel;
	$about = (!empty($_POST['about'])) ? mysqli_real_escape_string($con,str_replace("<p></p>", "", $_POST['about'])) : "";
	$map = (!empty($_POST['map'])) ? $_POST['map'] : "";
	$financing = (!empty($_POST['financing'])) ? mysqli_real_escape_string($con,str_replace("<p></p>", "", $_POST['financing'])) : "";
	$catalyst = (!empty($_POST['catalyst'])) ? mysqli_real_escape_string($con,str_replace("<p></p>", "", $_POST['catalyst'])) : "";
	$politics = (!empty($_POST['politics'])) ? mysqli_real_escape_string($con,str_replace("<p></p>", "", $_POST['politics'])) : "";
	$media_coverage = (!empty($_POST['media_coverage'])) ? mysqli_real_escape_string($con,str_replace("<p></p>", "", $_POST['media_coverage'])) : "";
	$challenges = (!empty($_POST['challenges'])) ? mysqli_real_escape_string($con,str_replace("<p></p>", "", $_POST['challenges'])) : "";
	$question_heading = (!empty($_POST['question_heading'])) ? mysqli_real_escape_string($con,str_replace("<p></p>", "", $_POST['question_heading'])) : "";
	$sqls = "SELECT * FROM properties WHERE channel = '".$channel."'";
    $querys = mysqli_query($con, $sqls);
    $sdata = mysqli_fetch_assoc($querys);
    if(empty($sdata)){
    	mysqli_query($con, "INSERT INTO properties(`channel`, `about`, `map`, `financing`, `catalyst`, `politics`, `media_coverage`, `challenges`, `question_heading`) VALUES('".$channel."', '".$about."', '".$map."', '".$financing."', '".$catalyst."', '".$politics."', '".$media_coverage."', '".$challenges."', '".$question_heading."') ");
        $errormsg = '<div class="alert alert-success"><strong>Success!</strong> Add successfully.</div>';
    }else{
    	mysqli_query($con, "UPDATE properties SET `about` = '$about', `map` = '$map', `financing` = '$financing', `catalyst` = '$catalyst', `politics` = '$politics', `media_coverage` = '$media_coverage', `challenges` = '$challenges', `question_heading` = '$question_heading' WHERE `channel` = '$channel'");
    	$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Update successfully.</div>';
    }
    mysqli_close($con);
}else{
	$propertyArray = $fun->getTableData("properties","where `channel` = '$channel' limit 1");
	$about = (!empty($propertyArray[0]['about'])) ? $propertyArray[0]['about'] : "";
	$map = (!empty($propertyArray[0]['map'])) ? $propertyArray[0]['map'] : "";
	$financing = (!empty($propertyArray[0]['financing'])) ? $propertyArray[0]['financing'] : "";
	$catalyst = (!empty($propertyArray[0]['catalyst'])) ? $propertyArray[0]['catalyst'] : "";
	$politics = (!empty($propertyArray[0]['politics'])) ? $propertyArray[0]['politics'] : "";
	$media_coverage = (!empty($propertyArray[0]['media_coverage'])) ? $propertyArray[0]['media_coverage'] : "";
	$challenges = (!empty($propertyArray[0]['challenges'])) ? $propertyArray[0]['challenges'] : "";
	$question_heading = (!empty($propertyArray[0]['question_heading'])) ? $propertyArray[0]['question_heading'] : "";
}
?>
<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
<script>
tinymce.init({
	selector: '#mytextarea,#mytextarea1,#mytextarea2,#mytextarea3,#mytextarea4,#mytextarea5,#mytextarea6'
});
</script>
<style type="text/css">
	.sidenav{
		min-height: 2000px;
	}
</style>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Add <?php echo strtoupper($channel); ?> Properties</h2>
		<div><?php echo $errormsg; ?></div>
		<form method="post" enctype="multipart/form-data"> 
			<div class="form-group">
				<label>About:</label>
				<textarea placeholder="Site Note" class="form-control" name="about" id="mytextarea"><?php echo $about; ?></textarea>
			</div>
			<div class="form-group">
				<label>Map:</label>
				<textarea placeholder="Site Note" class="form-control" name="map"><?php echo $map; ?></textarea>
			</div>
			<div class="form-group">
				<label>Financing & paper:</label>
				<textarea placeholder="Site Note" class="form-control" name="financing" id="mytextarea1"><?php echo $financing; ?></textarea>
			</div>
			<div class="form-group">
				<label>Catalyst:</label>
				<textarea placeholder="Site Note" class="form-control" name="catalyst" id="mytextarea2"><?php echo $catalyst; ?></textarea>
			</div>
			<div class="form-group">
				<label>Politics:</label>
				<textarea placeholder="Site Note" class="form-control" name="politics" id="mytextarea3"><?php echo $politics; ?></textarea>
			</div>
			<div class="form-group">
				<label>Media coverage:</label>
				<textarea placeholder="Site Note" class="form-control" name="media_coverage" id="mytextarea4"><?php echo $media_coverage; ?></textarea>
			</div>
			<div class="form-group">
				<label>Challenges:</label>
				<textarea placeholder="Site Note" class="form-control" name="challenges" id="mytextarea5"><?php echo $challenges; ?></textarea>
			</div>
			<div class="form-group">
				<label>Question Heading</label>
				<textarea placeholder="Site Note" class="form-control" name="question_heading" id="mytextarea6"><?php echo $question_heading; ?></textarea>
			</div>
			<button type="submit" class="btn btn-default" name="add">Add</button>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>