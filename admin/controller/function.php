<?php
session_start();
require_once("../config/config.php");

/**
* Class for common function
*/
class FetchData
{

	// connection open
	function conOpen(){
		$con=mysqli_connect(host,database_user,database_password);
		if(!$con){
			die('could not connect:'.mysqli_error());
		}
		mysqli_select_db($con,database_name);
		return $con;
	}

	// Insert data in database
	function insertdata($table_name,$data){
		$con = $this->conOpen();
		$date = date("Y-m-d H:i:s");
	    $name = (empty($data['name'])) ? "" : mysqli_real_escape_string($con,$data['name']);
	    $slug = (empty($data['slug'])) ? "" : mysqli_real_escape_string($con,$data['slug']);
	    

	    $sqls = "SELECT * FROM $table_name WHERE name = '".$name."'";
		$querys = mysqli_query($con, $sqls);
		$sdata = mysqli_fetch_assoc($querys);
		if(empty($sdata)){
	    	mysqli_query($con, "INSERT INTO $table_name(`name`, `slug`, `create_date`, `update_date`) VALUES('".$name."', '".$slug."', '".$date."', '".$date."') ");
		}
	    mysqli_close($con);
	}

	// Get table data
	function getTableData($tablename,$condition=""){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT * FROM $tablename ".$condition;
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// Get website data
	function getwebsites($condition=""){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT websites.`id`,websites.`name`,websites.`url`,websites.`alexa_rank`,websites.`active`,websites.`note`,websites.`tags`,websites.`ip_address`,websites.`created_at`,category.`name` as category_name FROM websites INNER JOIN category ON websites.`category_id` = category.`id`".$condition;
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// function get name by id
	function getnamebyid($tablename, $id = 1){
		// echo "WHERE articles_new1.`id` = $id";exit;
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT name FROM $tablename WHERE id = $id";
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		$name = (!empty($dataArray[0]['name'])) ? $dataArray[0]['name'] : "Null";
		return $name;
	}

	// Get all news data
	function getnews($condition=""){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT ".article_table.".`id`,".article_table.".`article_author`,".article_table.".`influencer_name`,".article_table.".`article_date`,".article_table.".`article_actual_date`,".article_table.".`article_title`,".article_table.".`article_img`,".article_table.".`status`,category.`name` as category_name,websites.`name` as website_name,websites.`alexa_rank` FROM ((".article_table." INNER JOIN category ON ".article_table.".`category_id` = category.`id`) INNER JOIN websites ON ".article_table.".`website_id` = websites.`id`)".$condition;
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// Get news by keywords
	function keywordnews($condition=""){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT ".article_table.".`id`,".article_table.".`article_author`,".article_table.".`article_date`,".article_table.".`article_actual_date`,".article_table.".`article_title`,".article_table.".`article_img`,relationship.`id` as relationship_id,relationship.`keyword_id` FROM ".article_table." LEFT JOIN relationship ON ".article_table.".`id` = relationship.`article_id`".$condition;
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// Get single news data
	function getsinglenews($id = 1){
		// echo "WHERE articles_new1.`id` = $id";exit;
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT ".article_table.".`id`,".article_table.".`category_id`,".article_table.".`article_author`,".article_table.".`article_date`,".article_table.".`article_actual_date`,".article_table.".`article_title`,".article_table.".`article_img`,".article_table.".`article_txt`,".article_table.".`exclusive`,".article_table.".`remove`,".article_table.".`recent`,".article_table.".`popular`,".article_table.".`latest`,category.`name` as category_name,websites.`name` as website_name FROM ((".article_table." INNER JOIN category ON ".article_table.".`category_id` = category.`id`) INNER JOIN websites ON ".article_table.".`website_id` = websites.`id`) WHERE ".article_table.".`id` = $id";
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// Get website data from article table
	function getwebsitesgroupby($condition=""){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT websites.`id`,websites.`category_id`,websites.`name`,websites.`url` FROM ".article_table." INNER JOIN websites ON websites.`id` = ".article_table.".`website_id`".$condition." group by ".article_table.".`website_id`";
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// Get category data from article table
	function getcategorygroupby($condition=""){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT category.`id`,category.`name` FROM ".article_table." INNER JOIN category ON category.`id` = ".article_table.".`category_id`".$condition." group by ".article_table.".`category_id`";
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// Login
	function login($username,$password){
		$password = md5(md5('s3@h!h6j8@mj').md5($password));
		$condition = "where username='".$username."' and password = '".$password."'";
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT * FROM admin ".$condition;
		$query = mysqli_query($con, $sql);
		mysqli_close($con);
		if(count(mysqli_fetch_assoc($query)) > 0){
			$_SESSION['username'] = $username;
			return "valid";
		}else{
			return "invalid";
		}
		
	}

	// Check user login or not
	function authentication(){
		if(!$_SESSION["username"]){
			return header("location:index.php");
		}
	}

	// Destory session
	function signout(){
		session_destroy();
		return header("location:index.php");
	}

	// function Get name from url
	function get_url_name($url){
		$name = "";
		$urlArray = explode("/", $url);
		$gname = $urlArray[count($urlArray)-1];
		$gcArray = explode(".php", $gname);
		$name = current($gcArray);
		return($name);
	}

	// Pagination function
	function pagination($pageName, $totalCount, $index, $page){
		$pagination = '<ul class="pagination">';
		$pagination = $pagination.'<li ';
		if(($page == 1)){
			$pagination = $pagination.'class="active" ';
		}
		$pagination = $pagination.'><a href="'.$pageName.'">First</a></li>';
		$forCount = ceil($totalCount/$index);
		$prevRecords = $page-5;
		$nextRecords = $page+5;
		if($prevRecords < 0){
			for ($i=$prevRecords; $i <= 0; $i++) { 
				$nextRecords++;
			}			
		}
		if($nextRecords > $forCount){
			for ($i=$forCount; $i < $nextRecords; $i++) { 
				$prevRecords--;
			}			
		}
		for ($i=2; $i <= $forCount; $i++) { 
			if($i==$forCount){
				$pagination = $pagination.'<li ';
				if(($page == $forCount)){
					$pagination = $pagination.'class="active" ';
				}
				$pagination = $pagination.'><a href="'.$pageName.'?page='.$i.'">Last</a></li>';
			}else{
				if($i < $nextRecords && $i > $prevRecords){
					$pagination = $pagination.'<li ';
					if(($page == $i)){
						$pagination = $pagination.'class="active" ';
					}
					$pagination = $pagination.'><a href="'.$pageName.'?page='.$i.'">'.$i.'</a></li>';
				}
			}
		}
		return ($totalCount > 0) ? $pagination : "";
	}

	// Pagination function
	function pagination_get($pageName, $totalCount, $index, $page,$extraprm=""){
		$extraprmData = (!empty($extraprm)) ? "?".substr($extraprm, 1) : "";
		$pagination = '<ul class="pagination">';
		$pagination = $pagination.'<li ';
		if(($page == 1)){
			$pagination = $pagination.'class="active" ';
		}
		$pagination = $pagination.'><a href="'.$pageName.$extraprmData.'">First</a></li>';
		$forCount = ceil($totalCount/$index);
		$prevRecords = $page-5;
		$nextRecords = $page+5;
		if($prevRecords < 0){
			for ($i=$prevRecords; $i <= 0; $i++) { 
				$nextRecords++;
			}			
		}
		if($nextRecords > $forCount){
			for ($i=$forCount; $i < $nextRecords; $i++) { 
				$prevRecords--;
			}			
		}
		for ($i=2; $i <= $forCount; $i++) { 
			if($i==$forCount){
				$pagination = $pagination.'<li ';
				if(($page == $forCount)){
					$pagination = $pagination.'class="active" ';
				}
				$pagination = $pagination.'><a href="'.$pageName.'?page='.$i.$extraprm.'">Last</a></li>';
			}else{
				if($i < $nextRecords && $i > $prevRecords){
					$pagination = $pagination.'<li ';
					if(($page == $i)){
						$pagination = $pagination.'class="active" ';
					}
					$pagination = $pagination.'><a href="'.$pageName.'?page='.$i.$extraprm.'">'.$i.'</a></li>';
				}
			}
		}
		return ($totalCount > 0) ? $pagination : "";
	}

	// Record count function
	function recordCount($tableName, $condition=""){
		$con = $this->conOpen();
		$sql = "SELECT count(*) as cnt FROM $tableName".$condition;
		$query = mysqli_query($con, $sql);
		$data = mysqli_fetch_array($query);
		$CNT = (!empty($data['cnt'])) ? $data['cnt'] : 0;
		return $CNT;
	}

	// Create keyword relation
	function createRelation($keyword_id,$article_id){
	    $con = $this->conOpen();
	    $sqls = "SELECT * FROM relationship WHERE article_id = $article_id and keyword_id = $keyword_id";
		$querys = mysqli_query($con, $sqls);
		$sdata = mysqli_fetch_assoc($querys);
		if(empty($sdata)){
	    	mysqli_query($con, "INSERT INTO relationship( `article_id`, `keyword_id`) VALUES($article_id, $keyword_id) ");
	    	mysqli_query($con, "UPDATE `keywords` SET `count` = `count`-1 WHERE id = $keyword_id");

		}
	    mysqli_close($con);
	}

	// Remove keyword relation
	function removeRelation($relationship_id,$keyword_id=0){
	    $con = $this->conOpen();
	    $sqls = "DELETE FROM relationship WHERE id = $relationship_id";
		$querys = mysqli_query($con, $sqls);
		mysqli_query($con, "UPDATE `keywords` SET `count` = `count`+1 WHERE id = $keyword_id");
	    mysqli_close($con);
	}


	// get articles count by keywords
	function getcoutbykeyword($keyword){
		$con = $this->conOpen();
		$sql = "SELECT count(*) as cnt FROM ".article_table." WHERE article_txt LIKE '%$keyword%' OR article_title LIKE '%$keyword%'";
		$query = mysqli_query($con, $sql);
		$data = mysqli_fetch_array($query);
		$CNT = (!empty($data['cnt'])) ? $data['cnt'] : 0;
		return $CNT;
	}

	// get assign keywords list
	function getassignkeylist(){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT COUNT(relationship.`id`) as cnt,relationship.`article_id`,relationship.`keyword_id` as id,keywords.`name` FROM relationship inner join keywords on relationship.`keyword_id` = keywords.`id` GROUP BY relationship.`keyword_id`";
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// get assign keywords count
	function getassignkeywordcount($keyword_id){
		$con = $this->conOpen();
		$sql = "SELECT COUNT(`id`) as cnt FROM relationship where keyword_id = $keyword_id";
		$query = mysqli_query($con, $sql);
		$data = mysqli_fetch_array($query);
		$CNT = (!empty($data['cnt'])) ? $data['cnt'] : 0;
		return $CNT;
	}

	
	// get assign keywords count
	function getassignkeyword($keyword_id){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT relationship.*,".article_table.".`article_title`,".article_table.".`article_author`,".article_table.".`article_actual_date`,".article_table.".`article_img` FROM relationship inner join ".article_table." on relationship.`article_id` = ".article_table.".`id` where relationship.`keyword_id` = $keyword_id";
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// get assign keywords count
	function getCompany($condition){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT `company`.* FROM `company`".$condition;
		// echo $sql;exit;
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// get company comment
	function getCompanyCmt($id,$orderby){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT * FROM `company_comment` WHERE `company_id` = $id".$orderby;
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// get hot comments
	function getHotCmt($condition){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT `company_comment`.*, `company`.name as companyName FROM `company_comment` LEFT JOIN `company` ON `company`.id = `company_comment`.company_id".$condition;
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// Get category data from article table
	function getauthorgroupby($condition=""){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT company_comment.`name` FROM company_comment ".$condition." group by company_comment.`name`";
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}
	// Insert data in database
	function insert_website($data){
		$con = $this->conOpen();
	    $name = (empty($data['name'])) ? "" : mysqli_real_escape_string($con,$data['name']);
	    $url = (empty($data['url'])) ? "" : mysqli_real_escape_string($con,$data['url']);
	    $note = (empty($data['note'])) ? "" : mysqli_real_escape_string($con,$data['note']);
	    $category_id = (empty($data['category_id'])) ? "" : mysqli_real_escape_string($con,$data['category_id']);
	    $suggested = (empty($data['suggested'])) ? "" : mysqli_real_escape_string($con,$data['suggested']);
	    $ip_address = (empty($data['ip_address'])) ? "" : mysqli_real_escape_string($con,$data['ip_address']);
	    $alexa_rank = 0;
	    $date = date('Y-m-d H:i:s');
	    $sqls = "SELECT * FROM websites WHERE url = '".$url."'";
		$querys = mysqli_query($con, $sqls);
		$sdata = mysqli_fetch_assoc($querys);
		if(empty($sdata)){
			mysqli_query($con, "INSERT INTO websites(`category_id`, `name`, `url`, `alexa_rank`, `suggested`, `note`, `ip_address`, `created_at`, `updated_at`) VALUES('".$category_id."', '".$name."', '".$url."', '".$alexa_rank."', '".$suggested."', '".$note."', '".$ip_address."', '".$date."', '".$date."') ");
			mysqli_close($con);
			return "insert";
		}else{
			mysqli_close($con);
			return "exists";
		}
	    mysqli_close($con);
	}
	// Remove website relation
	function deleteData($tableName, $id){
	    $con = $this->conOpen();
	    $sqls = "DELETE FROM $tableName WHERE id = $id";
		$querys = mysqli_query($con, $sqls);
	    mysqli_close($con);
	}

	// Insert data in database
	function insert_tags($data){
		$con = $this->conOpen();
		$name = (empty($data['name'])) ? "" : mysqli_real_escape_string($con,$data['name']);
	    $slug = strtolower(str_replace(" ", "-", $name));
	    $slug = (empty($slug)) ? "" : mysqli_real_escape_string($con,$slug);
	    // echo $slug;exit;
	    $date = date('Y-m-d H:i:s');
	    $sqls = "SELECT * FROM tags WHERE slug = '".$slug."'";
		$querys = mysqli_query($con, $sqls);
		$sdata = mysqli_fetch_assoc($querys);
		if(empty($sdata)){
			mysqli_query($con, "INSERT INTO tags(`name`, `slug`, `created_at`) VALUES('".$name."', '".$slug."', '".$date."') ");
			mysqli_close($con);
			return "insert";
		}else{
			mysqli_close($con);
			return "exists";
		}
	    mysqli_close($con);
	}

	// Assign tags 
	function assign_tags($data){
		$con = $this->conOpen();
		$tags = (empty($data['tags'])) ? "" : mysqli_real_escape_string($con,$data['tags']);
		$id = (empty($data['id'])) ? "" : mysqli_real_escape_string($con,$data['id']);
		if(!empty($id)){
			mysqli_query($con, "UPDATE company SET `tags` = '$tags' WHERE id LIKE '$id'");
			return "updated";
		}
		mysqli_close($con);
	}

	// Assign tags 
	function assign_ctags($data){
		$con = $this->conOpen();
		$tags = (empty($data['tags'])) ? "" : mysqli_real_escape_string($con,$data['tags']);
		$id = (empty($data['id'])) ? "" : mysqli_real_escape_string($con,$data['id']);
		if(!empty($id)){
			mysqli_query($con, "UPDATE websites SET `tags` = '$tags' WHERE id = $id");
			return "updated";
		}
		mysqli_close($con);
	}

	// Get news count
	function getnewsBycount($condition=""){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT websites.`category_id`,websites.`name`,websites.`url`, ".article_table.".`article_author`,".article_table.".`website_id`, count('id') as news_count FROM ".article_table." INNER JOIN websites ON websites.`id` = ".article_table.".`website_id`".$condition;
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// Group by Record count function
	function recordCountGb($tableName, $condition=""){
		$con = $this->conOpen();
		$sql = "SELECT id FROM $tableName".$condition;
		$query = mysqli_query($con, $sql);
		$data = mysqli_fetch_all($query);
		mysqli_close($con);
		return count($data);
	}

	// Get company news
	function getcompanynews($condition=""){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT company_news.`id`,company_news.`author`,company_news.`ticker`,company_news.`title`,company_news.`slug`,company_news.`news_date`,company_news.`news_time`,company_news.`news_txt`,company.`name` as company_name FROM company_news INNER JOIN company ON company_news.`company_id` = company.`id`".$condition;
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// Get single company news data
	function getsinglecompanynews($id = 1){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT company_news.`id`,company_news.`author`,company_news.`ticker`,company_news.`title`,company_news.`slug`,company_news.`news_date`,company_news.`news_time`,company_news.`news_txt`,company_news.`reviews`,company_news.`analysis`,company_news.`remove`,company.`name` as company_name FROM company_news INNER JOIN company ON company_news.`company_id` = company.`id` where company_news.`id` = $id";
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// Get single company news data
	function getsinglecompanycomment($id = 1){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT company_comment.`id`,company_comment.`channel`,company_comment.`spiel`,company_comment.`name`,company_comment.`reviews`,company_comment.`analysis`,company.`name` as company_name FROM company_comment INNER JOIN company ON company_comment.`company_id` = company.`id` where company_comment.`id` = $id";
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// Get company data from company news table
	function getcompanygroupby($condition=""){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT company.`id`,company.`name`,company.`symbol` FROM company_news INNER JOIN company ON company.`id` = company_news.`company_id` group by company_news.`company_id`";
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// Active news status
	function activeNewsStatus($article_id){
		$con = $this->conOpen();
	    mysqli_query($con, "UPDATE ".article_table." SET `status` = '1' WHERE `id` = $article_id");
	    mysqli_close($con);
	}	

	// Inactive news status
	function inactiveNewsStatus($article_id){
		$con = $this->conOpen();
	    mysqli_query($con, "UPDATE ".article_table." SET `status` = '0' WHERE `id` = $article_id");
	    mysqli_close($con);
	}

	// Insert and update articles table
	function insertArticle($table_name,$data){
		$con = $this->conOpen();
		
		$category_id = (empty($data['category_id'])) ? "" : mysqli_real_escape_string($con,$data['category_id']);
	    $website_id = (empty($data['website_id'])) ? "" : mysqli_real_escape_string($con,$data['website_id']);
	    $article_author = (empty($data['article_author'])) ? "" : mysqli_real_escape_string($con,$data['article_author']);
	    $article_actual_date = (empty($data['article_actual_date'])) ? "" : mysqli_real_escape_string($con,$data['article_actual_date']);
	    $article_title = (empty($data['article_title'])) ? "" : mysqli_real_escape_string($con,$data['article_title']);
	    $article_img = (empty($data['article_img'])) ? "" : mysqli_real_escape_string($con,$data['article_img']);
	    $article_txt = (empty($data['article_txt'])) ? "" : mysqli_real_escape_string($con,$data['article_txt']);
	    $article_link = (empty($data['article_link'])) ? "" : mysqli_real_escape_string($con,$data['article_link']);
	    $custom_news = (empty($data['custom_news'])) ? "" : mysqli_real_escape_string($con,$data['custom_news']);
	    $created_at = date('Y-m-d H:i:s');
	    $updated_at = date('Y-m-d H:i:s');
	    $article_date = $article_actual_date;
	    if(!empty($article_date)){
	    	$article_date = str_replace("/", "-", $article_date);
	    	$article_date = date('Y-m-d H:i:s',strtotime($article_date));
	    }else{
	    	$date = date('Y-m-d');
	    	$article_date = date('Y-m-d H:i:s',strtotime($date));
	    }
	    $sqls = "SELECT * FROM $table_name WHERE article_title = '".$article_title."'";
		$querys = mysqli_query($con, $sqls);
		$sdata = mysqli_fetch_assoc($querys);
		if(empty($sdata)){
	    	mysqli_query($con, "INSERT INTO $table_name( `category_id`, `website_id`, `article_author`, `article_date`, `article_actual_date`, `article_title`, `article_img`, `article_txt`, `article_link`, `custom_news`, `created_at`, `updated_at`) VALUES('".$category_id."', '".$website_id."', '".$article_author."', '".$article_date."', '".$article_actual_date."', '".$article_title."', '".$article_img."', '".$article_txt."', '".$article_link."', '".$custom_news."', '".$created_at."', '".$updated_at."') ");
	    	return "insert";

		}
		else{
			return "exists";
		}
	    mysqli_close($con);
	}
	// Insert and update articles table
	function updateArticle($table_name,$data,$id){
		$con = $this->conOpen();
		
		$category_id = (empty($data['category_id'])) ? "" : mysqli_real_escape_string($con,$data['category_id']);
	    $website_id = (empty($data['website_id'])) ? "" : mysqli_real_escape_string($con,$data['website_id']);
	    $article_author = (empty($data['article_author'])) ? "" : mysqli_real_escape_string($con,$data['article_author']);
	    $article_title = (empty($data['article_title'])) ? "" : mysqli_real_escape_string($con,$data['article_title']);
	    $article_img = (empty($data['article_img'])) ? "" : mysqli_real_escape_string($con,$data['article_img']);
	    $article_txt = (empty($data['article_txt'])) ? "" : mysqli_real_escape_string($con,$data['article_txt']);
	    $article_link = (empty($data['article_link'])) ? "" : mysqli_real_escape_string($con,$data['article_link']);
	    $custom_news = (empty($data['custom_news'])) ? "" : mysqli_real_escape_string($con,$data['custom_news']);
	    $updated_at = date('Y-m-d H:i:s');
	    $sqls = "SELECT * FROM $table_name WHERE article_title = '".$article_title."' and id != $id";
		$querys = mysqli_query($con, $sqls);
		$sdata = mysqli_fetch_assoc($querys);
		if(empty($sdata)){
	    	mysqli_query($con, "UPDATE $table_name SET `article_title` = '".$article_title."', `article_author` = '".$article_author."', `article_img` = '".$article_img."', `article_txt` = '".$article_txt."', `custom_news` = '".$custom_news."', `updated_at` = '".$updated_at."' WHERE id = '".$id."'");
	    	return "updated";

		}
		else{
			return "exists";
		}
	    mysqli_close($con);
	}


	// Get all news data
	function getcustomnews($condition=""){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT ".article_table.".`id`,".article_table.".`article_author`,".article_table.".`influencer_name`,".article_table.".`article_date`,".article_table.".`article_actual_date`,".article_table.".`article_title`,".article_table.".`article_img`,".article_table.".`status`,category.`name` as category_name FROM (".article_table." INNER JOIN category ON ".article_table.".`category_id` = category.`id`)".$condition;
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}
	// Get single news data
	function getcustomsinglenews($id = 1){
		// echo "WHERE articles_new1.`id` = $id";exit;
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT ".article_table.".`id`,".article_table.".`category_id`,".article_table.".`article_author`,".article_table.".`article_date`,".article_table.".`article_actual_date`,".article_table.".`article_title`,".article_table.".`article_img`,".article_table.".`article_txt`,".article_table.".`exclusive`,".article_table.".`remove`,".article_table.".`recent`,".article_table.".`popular`,".article_table.".`latest`,category.`name` as category_name FROM (".article_table." INNER JOIN category ON ".article_table.".`category_id` = category.`id`) WHERE ".article_table.".`id` = $id";
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}

	// Get company images and count by company
	function getimagesbycompany($condition){
		$dataArray = array();
		$con = $this->conOpen();
		$sql = "SELECT id, COUNT(id) as cnt, channel FROM company_images".$condition;
		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$dataArray[] = $row;
		}
		mysqli_close($con);
		return $dataArray;
	}
	
	// Get company images and count by company
	function countbycompany($condition){
		$con = $this->conOpen();
		$sql = "SELECT id, COUNT(id) as cnt, channel FROM company_images".$condition;
		$query = mysqli_query($con, $sql);
		$data = mysqli_fetch_all($query);
		mysqli_close($con);
		return count($data);
	}

	// Remove file
	function remove_file($tablename,$id){
		$con = $this->conOpen();
		$sql = "SELECT image_link FROM $tablename where id = $id limit 1";
		$query = mysqli_query($con, $sql);
		$data = mysqli_fetch_assoc($query);
		$imgLink = (!empty($data['image_link'])) ? $data['image_link'] : "";
		$imgArray = explode("news_aggregator/", $imgLink);
		$imagePath = (!empty($imgArray[1])) ? "../".$imgArray[1] : "";
		unlink($imagePath);
		mysqli_close($con);
	}
}