<?php
include("./common/header.php");
include("./controller/function.php");
$fun = new FetchData();
$fun->authentication();
$serchType = (!empty($_GET['stype'])) ? $_GET['stype'] : "";
// $condition = ($serchType == "week") ? " where article_actual_date != ''" : " where article_actual_date LIKE '%:%'";
$condition = "";
if($serchType == "week" || $serchType == "month"){
	$condition = " where article_actual_date != ''";
}
if($serchType == "hours" || $serchType == ""){
	$condition = " where article_actual_date LIKE '%:%'";
}
$dataArray = $fun->getTableData(article_table,$condition);
$timeArray = array(array('start'=>'00:00','end'=>'01:00','count'=>'0'),array('start'=>'01:00','end'=>'02:00','count'=>'0'),array('start'=>'02:00','end'=>'03:00','count'=>'0'),array('start'=>'03:00','end'=>'04:00','count'=>'0'),array('start'=>'04:00','end'=>'05:00','count'=>'0'),array('start'=>'05:00','end'=>'06:00','count'=>'0'),array('start'=>'06:00','end'=>'07:00','count'=>'0'),array('start'=>'07:00','end'=>'08:00','count'=>'0'),array('start'=>'08:00','end'=>'09:00','count'=>'0'),array('start'=>'09:00','end'=>'10:00','count'=>'0'),array('start'=>'10:00','end'=>'11:00','count'=>'0'),array('start'=>'11:00','end'=>'12:00','count'=>'0'),array('start'=>'12:00','end'=>'13:00','count'=>'0'),array('start'=>'13:00','end'=>'14:00','count'=>'0'),array('start'=>'14:00','end'=>'15:00','count'=>'0'),array('start'=>'15:00','end'=>'16:00','count'=>'0'),array('start'=>'16:00','end'=>'17:00','count'=>'0'),array('start'=>'17:00','end'=>'18:00','count'=>'0'),array('start'=>'18:00','end'=>'19:00','count'=>'0'),array('start'=>'19:00','end'=>'20:00','count'=>'0'),array('start'=>'20:00','end'=>'21:00','count'=>'0'),array('start'=>'21:00','end'=>'22:00','count'=>'0'),array('start'=>'22:00','end'=>'23:00','count'=>'0'),array('start'=>'23:00','end'=>'24:00','count'=>'0'));
$weekArray = array(array('day'=>'Sunday','count'=>'0'),array('day'=>'Monday','count'=>'0'),array('day'=>'Tuesday','count'=>'0'),array('day'=>'Wednesday','count'=>'0'),array('day'=>'Thursday','count'=>'0'),array('day'=>'Friday','count'=>'0'),array('day'=>'Saturday','count'=>'0'));
$MonthArray = array(array('day'=>'January','count'=>'0'),array('day'=>'February','count'=>'0'),array('day'=>'March','count'=>'0'),array('day'=>'April','count'=>'0'),array('day'=>'May','count'=>'0'),array('day'=>'June','count'=>'0'),array('day'=>'July','count'=>'0'),array('day'=>'August','count'=>'0'),array('day'=>'September','count'=>'0'),array('day'=>'October','count'=>'0'),array('day'=>'November','count'=>'0'),array('day'=>'December','count'=>'0'));

// echo "<pre>";
// print_r($MonthArray);
// exit;

$newArray = array();
if($serchType == "week"){
	foreach ($weekArray as $key => $weekvalue) { 
		$nArray = array();
		$nArray['day'] = $weekvalue['day'];
		$nArray['count'] = $weekvalue['count'];	
		foreach ($dataArray as $key => $value) {
			$adate = $value['article_date'];
			$week = date('l',strtotime($adate));;
			if($weekvalue['day'] == $week){
				$nArray['count']++;
			} 
		}
		array_push($newArray, $nArray);
	}
}
if($serchType == "hours" || $serchType == ""){
	foreach ($timeArray as $key => $timevalue) { 
		$nArray = array();
		$nArray['start'] = $timevalue['start'];
		$nArray['end'] = $timevalue['end'];
		$nArray['count'] = $timevalue['count'];	
		foreach ($dataArray as $key => $value) {
			$adate = $value['article_date'];
			$time = date('H:i',strtotime($adate));
			if($timevalue['start'] <= $time && $timevalue['end'] >= $time){
				$nArray['count']++;
			} 
		}
		array_push($newArray, $nArray);
	}	
}
if($serchType == "month"){
	foreach ($MonthArray as $key => $monthvalue) { 
		$nArray = array();
		$nArray['day'] = $monthvalue['day'];
		$nArray['count'] = $monthvalue['count'];	
		foreach ($dataArray as $key => $value) {
			$adate = $value['article_date'];
			$month = date('F',strtotime($adate));;
			if($monthvalue['day'] == $month){
				$nArray['count']++;
			} 
		}
		array_push($newArray, $nArray);
	}	
}
// echo "<pre>";
// print_r($newArray);
// exit;
?>
<div class="container-fluid">
	<?php require_once("./common/loginBar.php"); ?>
  <div class="row content">
  	<?php require_once("./common/menu.php"); ?>
    <div class="col-sm-9">
      <div class="row BoxOuter">
		<div class="col-sm-12">
			<h2 class="heading">News Stat</h2>
		</div>
		<div class="col-sm-12">
			<form method="get">
				<div class="row">
					<div class="col-sm-3">
						<select name="stype" class="form-control" required>
							<option value="">Select type</option>
							<option <?php if($serchType == 'week'){ echo "selected"; } ?> value="week">Days of a week</option>
							<option <?php if($serchType == 'hours'){ echo "selected"; } ?> value="hours">Hourly</option>
							<option <?php if($serchType == 'month'){ echo "selected"; } ?> value="month">Month</option>
						</select>
					</div>
					<div class="col-sm-1">
						<button class="btn btn-default" type="submit">
					        <span class="glyphicon glyphicon-search"></span>
					    </button>
					</div>
					<div class="col-sm-2">
						<a href="./web_news.php">News by website</a>
					</div>
					<div class="col-sm-2">
						<a href="./auth_news.php">News by author</a>
					</div>
					<div class="col-sm-2">
						<a href="./inf_news.php">News by influencer</a>
					</div>
				</div>
			</form>
		</div>
		<div class="col-sm-12">
			<h4></h4>
		</div>
		<div class="col-sm-12">
			<div class="BoxContent">
		      	<table class="table table-fixed">
					<thead>
						<tr>
							<th class="col-sm-8">Time</th>
							<th class="col-sm-3">Count</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($newArray as $key => $newvalue) {
							$startTime = (!empty($newvalue['start'])) ? $newvalue['start'] : "";
							$endTime = (!empty($newvalue['end'])) ? $newvalue['end'] : "";
							$wday = (!empty($newvalue['day'])) ? $newvalue['day'] : "";
							// $Svalve = ($serchType == "week") ? $wday : date('g:i A',strtotime($startTime))." To ".date('g:i A',strtotime($endTime));
							$Svalve = "";
							if($serchType == "hours" || $serchType == ""){
								$Svalve = date('g:i A',strtotime($startTime))." To ".date('g:i A',strtotime($endTime));
							}
							if($serchType == "week"){
								$Svalve = $wday;
							}
							if($serchType == "month"){
								$Svalve = $wday;
							}
							$Scount = $newvalue['count'];
						?>
						<tr>
							<td class="col-sm-8"><?php echo $Svalve; ?></td>
							<td class="col-sm-3"><?php echo $Scount; ?></td>
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