<?php

session_start();

$host = "sophia";
$username="zhtai";
$password="zh950915";
$database="zhtai";

$db_conn=mysqli_connect($host,$username,$password,$database) or die ("Connection Error! ".mysqli_connect_error());

$username = $_POST['username'];
$password = $_POST['password'];

$query= "SELECT * FROM Login WHERE UserId = '$username'" ;
$Login=mysqli_query($db_conn, $query) or die ("Query Error!".mysqli_error($db_conn));

if(mysqli_num_rows($Login) > 0){
	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;
	echo '<script type="text/javascript">
           window.location="main.php"; 
      	</script>';

}else{
	echo "<h1> Invalid login, please login again</h1>";
	echo '<script type="text/javascript">
           setTimeout(function(){ window.location="index.html"; }, 3000);
      	</script>';

	
}

mysqli_free_result($Std_record);
mysqli_close($db_conn);
?>
