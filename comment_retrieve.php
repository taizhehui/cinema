<?php
	session_start();
	if(authenticate()){
		display_main();
	}
	else{
		echo "<h1> You have not logged in</h1>";
		echo '<script type="text/javascript">
           		setTimeout(function(){ window.location="index.html"; }, 3000);
      		</script>';
	}
	
	function authenticate(){
		if(isset($_SESSION['username'])){
			return true;
		}else{
			return false;
		}
	}
	function display_main(){
	?>
		<!DOCTYPE html>
		<html>
		<head>
    			<meta charset="UTF-8">
    			<title>Comment</title> 
    			<link rel="stylesheet" href="style_comment_retrieve.css" type="text/css">
		</head>
	<?php

		$host = "sophia";
		$username="zhtai";
		$password="zh950915";
		$database="zhtai";

		$db_conn=mysqli_connect($host,$username,$password,$database) or die ("Connection Error! ".mysqli_connect_error());

		$filmId = $_GET['filmID']; 

		$query= "SELECT * FROM Comment where FilmId = '".$filmId."'";
		$comment = mysqli_query($db_conn, $query) or die ("Query Error!".mysqli_error($db_conn));
	
		while($row=mysqli_fetch_array($comment)){
			echo "<h5 class=viewer> Viewer: ".$row['UserId']."</h5>";
			echo "<h5 class=comment>Comment: ".$row['Comment']."</h5>";
			echo "<hr>";
		}
		echo "</html>";
	}

?>
