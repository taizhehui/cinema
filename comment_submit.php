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
		$host = "sophia";
		$username="zhtai";
		$password="zh950915";
		$database="zhtai";

		$db_conn=mysqli_connect($host,$username,$password,$database) or die ("Connection Error! ".mysqli_connect_error());

		$user = $_SESSION['username'];
		$filmId = $_POST['filmId'];
		$comment = $_POST['comment']; 

		$query_insert= "INSERT INTO Comment (FilmId, UserId, Comment) VALUES ('$filmId' , '$user', '$comment')";
		mysqli_query($db_conn, $query_insert) or die ("Query Error!".mysqli_error($db_conn));
	
		echo "<h1> Your comment has been submitted</h1>";
		echo '<script type="text/javascript">
           		setTimeout(function(){ window.location="comment.php"; }, 3000);
      		</script>';

		

	}

?>
