<?php
session_start();
if(authenticate()){
	display_movie();
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
function display_movie(){
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"> 
		<link rel="stylesheet" href="style_buy_welcome2.css" type="text/css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">


</head>
<body>



	 <ul>

	<li><a href="buywelcome.php">Buy a ticket</a></li> 
<li><a href="comment.php">Movie review</a></li>
<li><a href="history.php">Purchase History</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>

<?php

$host = "sophia";
$username="zhtai";
$password="zh950915";
$database="zhtai";

$db_conn=mysqli_connect($host,$username,$password,$database) or die ("Connection Error! ".mysqli_connect_error());
$query= "SELECT * FROM Film";
$Film=mysqli_query($db_conn, $query) or die ("Query Error!".mysqli_error($db_conn));

if(mysqli_num_rows($Film) > 0){
	while($row=mysqli_fetch_array($Film)){
	$q = "SELECT * FROM BroadCast WHERE FilmId = '".$row[FilmId]."'";
	$bc = mysqli_query($db_conn, $q) or die ("Query Error!".mysqli_error($db_conn));

	echo "<div class=container>";
	echo "<h1 class=title>".$row['FilmName']."</h1>";
	echo "<img src=\"".$row['Filename']."\">";
	echo "<h3 class=info>"."Synopsis: ".$row['Description']."</h3>";
	echo "<h4 class=info>"."Director: ".$row['Director']."</h4>";
	echo "<h4 class=info>"."Duration: ".$row['Duration']."</h4>";
	echo "<h4 class=info>"."Category: ".$row['Category']."</h4>";
	echo "<h4 class=info>"."Language: ".$row['Language']."</h4>";
	
	echo "<form action=seatplantry.php method=post>";
	echo "<select name=\"id\">";
		while ($row2=mysqli_fetch_array($bc)) {
		$id = $row2['BroadCastId'];
     			$date = $row2['Dates'];
      			$time = $row2['Time']; 
		$day = $row2['Day'];
		$house = $row2['HouseId'];
	$space = " ";
      		echo '<option value="'.$id.'">'.$date.$space.$time.$space.$day.$space.$house.'</option>';
	}
		echo "</select>";
	echo "<input class=button type=\"submit\" name=\"Submit\">";	
	echo "</form>";	
	echo "<hr>";
	echo "</div>";
	mysqli_free_result($bc);		
}
}
mysqli_free_result($Film);
mysqli_close($db_conn);
?>
</body>
</html>		
<?php
}

?>


