<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$id = (!empty($_GET['id'])) ? $_GET['id'] : "";
$errormsg = "";
if(isset($_POST["update"])) {
	$con = $fun->conOpen();
	$channel = (empty($channel)) ? "" : mysqli_real_escape_string($con,$channel);
	$question = (empty($_POST['question'])) ? "" : mysqli_real_escape_string($con,$_POST['question']);
	$answer = (empty($_POST['answer'])) ? "" : mysqli_real_escape_string($con,$_POST['answer']);
    $sqls = "SELECT * FROM questions WHERE id = '".$id."'";
    $querys = mysqli_query($con, $sqls);
    $sdata = mysqli_fetch_assoc($querys);
    if(!empty($sdata)){
    	mysqli_query($con, "UPDATE questions SET `question` = '$question', `answer` = '$answer' WHERE `id` = $id");
    	$errormsg = '<div class="alert alert-success"><strong>Success!</strong> Update successfully.</div>';;
    }
    mysqli_close($con);
	
}
$dataArray = $fun->getTableData("questions"," where id = $id");
$question = (!empty($dataArray[0]['question'])) ? $dataArray[0]['question'] : "";
$answer = (!empty($dataArray[0]['answer'])) ? $dataArray[0]['answer'] : "";
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<h2 class="heading">Edit Question</h2>
		<div><?php echo $errormsg; ?></div>
		<form method="post" enctype="multipart/form-data"> 
			<div class="form-group">
				<input type="text" class="form-control" name="question" placeholder="Question" value="<?php echo $question; ?>" required>
			</div>
			<div class="form-group">
				<textarea class="form-control" name="answer" placeholder="Answer" required><?php echo $answer; ?></textarea>
			</div>
			<button type="submit" class="btn btn-default" name="update">Update</button>
		</form>
      </div>  
    </div>
  </div>
</div>
<?php require_once("./common/footer.php"); ?>