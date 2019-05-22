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
    			<title>Confirm</title> 
    			<link rel="stylesheet" href="style_confirm.css" type="text/css">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
       
		</head>
		<body>

    		<ul>

    		<li><a href="buywelcome.php">Buy a ticket</a></li> 
		<li><a href="comment.php">Movie review</a></li>
		<li><a href="history.php">Purchase History</a></li>
		<li><a href="logout.php">Logout</a></li>
		</ul>
		<h1 class=title>Order Information</h1>

		<?php

		$bc_id = $_GET['id'];
		$option=$_POST['option'];
		
		$host = "sophia";
		$username="zhtai";
		$password="zh950915";
		$database="zhtai";
		$db_conn=mysqli_connect($host,$username,$password,$database) or die ("Connection Error! ".mysqli_connect_error());

		$query = "SELECT * FROM BroadCast WHERE BroadCastId = '".$bc_id."'";
		$bc = mysqli_query($db_conn, $query) or die ("Query Error!".mysqli_error($db_conn));
		$row_bc=mysqli_fetch_array($bc);
		$filmId = $row_bc['FilmId'];
		$query2 = "SELECT * FROM Film WHERE FilmId = '".$filmId."'";
		$Film=mysqli_query($db_conn, $query2) or die ("Query Error!".mysqli_error($db_conn));
		$row_film=mysqli_fetch_array($Film);
		$space =" ";
	
		for ($x = 0; $x < sizeof($option); $x++) {
			$seat = substr($option[$x],0,2);
			$fee_type = substr($option[$x],2,20);
			$fee = (int)substr($option[$x],4,2);
			$type = substr($option[$x],7,20);
			$total = $total + $fee;
			$username = $_SESSION['username'];

			echo "<table>";
			echo "<tr><td>"."Cinema: "."</td>"."<td>"."Star Cinema"."</td></tr>";
			echo "<tr><td>"."House: "."</td>"."<td>".$row_bc['HouseId']."</td></tr>";
			echo "<tr><td>"."SeatNo: "."</td>"."<td>".$seat."</td></tr>";
			echo "<tr><td>"."Film: "."</td>"."<td>".$row_film['FilmName']."</td></tr>";
			echo "<tr><td>"."Category: "."</td>"."<td>".$row_film['Category']."</td></tr>";
			echo "<tr><td>"."Show Time: "."</td>"."<td>".$row_bc['Dates'].$space.$row_bc['Day'].$space.$row_bc['Time']."</td></tr>";
			echo "<tr><td>"."Ticket Fee: "."</td>"."<td>".$fee_type."</td></tr>";
			echo "</table>";

			echo "<hr>";

			$query_insert = "INSERT INTO Ticket (SeatNo,BroadCastId,Valid,UserId,TicketType,TicketFee) VALUES ('$seat','$bc_id','0','$username','$type','$fee')";
			mysqli_query($db_conn, $query_insert) or die ("Query Error!".mysqli_error($db_conn));
		}
		echo "<div class=container>";
		echo "Total fee: $".$total;
		echo "<hr>";
		echo "<div class=please> Please present valid proof of age/status when purchasing Student or Senior tickets before entering the cinema house.</div>";
		echo "<a href=\"buywelcome.php\"><input class=button type=button value=\"OK\"></a>";
		echo "</div>";

		
		
		echo "</body>";
		echo "</html>";


	}

?>
