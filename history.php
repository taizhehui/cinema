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
    			<title>History</title> 
    			<link rel="stylesheet" href="style_history2.css" type="text/css">
       
		</head>
		<body>

    		<ul>

    		<li><a href="buywelcome.php">Buy a ticket</a></li> 
		<li><a href="comment.php">Movie review</a></li>
		<li><a href="history.php">Purchase History</a></li>
		<li><a href="logout.php">Logout</a></li>
		</ul>
		<h1 class="title">Purchase History</h1>

		<?php
		$userId = $_SESSION['username'];
		echo "<div class=container>";
		echo "Username: ".$userId;
		echo "</div>";
		
		$host = "sophia";
		$username="zhtai";
		$password="zh950915";
		$database="zhtai";
		$db_conn=mysqli_connect($host,$username,$password,$database) or die ("Connection Error! ".mysqli_connect_error());

		$query = "SELECT * FROM Ticket WHERE UserId = '".$userId."'";
		$ticket = mysqli_query($db_conn, $query) or die ("Query Error!".mysqli_error($db_conn));
		echo "<hr>";
		while ($row=mysqli_fetch_array($ticket)) {
			$bc_id = $row['BroadCastId'];
			$query = "SELECT * FROM BroadCast WHERE BroadCastId = '".$bc_id."'";
			$bc = mysqli_query($db_conn, $query) or die ("Query Error!".mysqli_error($db_conn));
			$row_bc=mysqli_fetch_array($bc);
			
			$filmId = $row_bc['FilmId'];
			$query = "SELECT * FROM Film WHERE FilmId = '".$filmId."'";
			$film = mysqli_query($db_conn, $query) or die ("Query Error!".mysqli_error($db_conn));
			$row_film=mysqli_fetch_array($film);
			$space=" ";	
			$money="$";	
	
			echo "<table>";
			echo "<tr><td>"."TicketId: "."</td>"."<td>".$row['TicketId'].$space.$money.$row['TicketFee'].$space.$row['TicketType']."</td></tr>";
			echo "<tr><td>"."House: "."</td>"."<td>".$row_bc['HouseId']."</td></tr>";
			echo "<tr><td>"."Seat: "."</td>"."<td>".$row['SeatNo']."</td></tr>";
			echo "<tr><td>"."FilmName: "."</td>"."<td>".$row_film['FilmName'].$space.$row_film['Category'].$space.$row_film['Duration']."</td></tr>";
			echo "<tr><td>"."Language: "."</td>"."<td>".$row_film['Language']."</td></tr>";
			echo "<tr><td>"."Date: "."</td>"."<td>".$row_bc['Dates'].$space.$row_bc['Day'].$space.$row_bc['Time']."</td></tr>";
			echo "</table>";
			echo "<hr>";



		}	
		
		echo "</body>";
		echo "</html>";


	}

?>
