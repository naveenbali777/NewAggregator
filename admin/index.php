<?php
include("./common/header.php");
include("./controller/function.php");
// print_r($_SESSION);
$fun = new FetchData();
$errormsg = "";
if(isset($_POST['login'])){
	$uName = $_POST['uName'];
	$Pwd = $_POST['Pwd'];
	if($fun->login($uName,$Pwd) == "valid"){
		header("location:dashboard.php");
	}else{
		$errormsg = '<div class="alert alert-danger">Invalid login</div>';
	}
}
?>
<div class="container-fluid">
  <div class="row content">
  	<div class="col-sm-offset-4 col-sm-4">
      <div class="loginBox">
      	<div><?php echo $errormsg; ?></div>
		<form method="post">
			<div class="form-group">
				<label for="uName">Username:</label>
				<input type="uName" class="form-control" name="uName" required>
			</div>
			<div class="form-group">
				<label for="Pwd">Password:</label>
				<input type="password" class="form-control" name="Pwd" required>
			</div>
			<button type="submit" class="btn btn-default" name="login">Submit</button>
		</form>
      </div> 
    </div>
  </div>
</div>
<?php //require_once("./common/footer.php"); ?>