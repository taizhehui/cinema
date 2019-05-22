

<?php

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
	echo "<h1> Account already existed </h1>";
	echo '<script type="text/javascript">
           setTimeout(function(){ window.location="createaccount.html"; }, 3000);
      	</script>'; 

}else{
	$query="Insert INTO Login (UserId,PW) VALUES ('$username','$password')";
	if(!mysqli_query($db_conn, $query)){
		echo "<p>Error insert!!<br>".mysqli_error($db_conn)."</p>";
	}
	echo "<h1> Account created! Welcome </h1>";
	echo '<script type="text/javascript">
           setTimeout(function(){ window.location="index.html"; }, 3000);
      	</script>';


}

mysqli_free_result($Login);
mysqli_close($db_conn);
?>
