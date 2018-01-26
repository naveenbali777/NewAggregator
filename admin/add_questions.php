<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$errormsg = "";
$imgerrormsg = "";
$channel = (!empty($_GET['tkr'])) ? $_GET['tkr'] : "";
if(isset($_POST["add"])) {
	$con = $fun->conOpen();
	$channel = (empty($channel)) ? "" : mysqli_real_escape_string($con,$channel);
	$question = (empty($_POST['question'])) ? "" : mysqli_real_escape_string($con,$_POST['question']);
	$answer = (empty($_POST['answer'])) ? "" : mysqli_real_escape_string($con,$_POST['answer']);
	$sqls = "SELECT * FROM questions WHERE question = '".$question."'";
    $querys = mysqli_query($con, $sqls);
    $sdata = mysqli_fetch_assoc($querys);
    if(empty($sdata)){
    	mysqli_query($con, "INSERT INTO questions(`channel`, `question`, `answer`) VALUES('".$channel."', '".$question."', '".$answer."') ");
        $errormsg = '<div class="alert alert-success"><strong>Success!</strong> Add successfully.</div>';
    }
    mysqli_close($con);
	
}
// $categoryArray = $fun->getTableData("category");
// $category_id = (!empty($_POST['category_id']) ? $_POST['category_id'] : 0);
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Add <?php echo strtoupper($channel); ?> Questions <a class="btn btn-default pull-right" href="questions.php?tkr=<?php echo $channel; ?>">Back To Questions Page</a></h2>
		<div><?php echo $errormsg; ?></div>
		<form method="post" enctype="multipart/form-data"> 
			<div class="form-group">
				<input type="text" class="form-control" name="question" placeholder="Question" value="<?php echo (!empty($_POST['question']) ? $_POST['question'] : ""); ?>" required>
			</div>
			<div class="form-group">
				<textarea class="form-control" name="answer" placeholder="Answer" required><?php echo (!empty($_POST['answer']) ? $_POST['answer'] : ""); ?></textarea>
			</div>
			<button type="submit" class="btn btn-default" name="add">Add</button>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>