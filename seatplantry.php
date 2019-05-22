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
    			<title>Seat Plantry</title> 
    			<link rel="stylesheet" href="style_seat_plantry7.css" type="text/css">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript">
		function checked() {
			var checkbox = document.getElementsByTagName("input");
			var count = 0;
      			for (var i=0; i<checkbox.length; i++) {
        			if (checkbox[i].type === "checkbox" && checkbox[i].checked === true) {
         				count++;
        			}
      			}
      			if(count ==0){
				alert("You must select one seat");
				return false;
      			}
		}

		</script>
       
		</head>
		<body>
			<h1 class=title> Ticketing</h1>
		<?php
			$bc_id=$_POST['id'];

			$host = "sophia";
			$username="zhtai";
			$password="zh950915";
			$database="zhtai";
			$db_conn=mysqli_connect($host,$username,$password,$database) or die ("Connection Error! ".mysqli_connect_error());

			$query_bc = "SELECT * FROM BroadCast WHERE BroadCastId = '".$bc_id."'";
			$bc = mysqli_query($db_conn, $query_bc) or die ("Query Error!".mysqli_error($db_conn));
			$row_bc=mysqli_fetch_array($bc);
			$filmId = $row_bc['FilmId'];
			$query_film = "SELECT * FROM Film WHERE FilmId = '".$filmId."'";
			$Film=mysqli_query($db_conn, $query_film) or die ("Query Error!".mysqli_error($db_conn));
			$row_film=mysqli_fetch_array($Film);
			$space = " ";

			echo "<table>";
			echo "<tr><td>"."Cinema: "."</td>"."<td>"."Star Cinema"."</td></tr>";
			echo "<tr><td>"."House: "."</td>"."<td>".$row_bc['HouseId']."</td></tr>";
			echo "<tr><td>"."Film: "."</td>"."<td>".$row_film['FilmName']."</td></tr>";
			echo "<tr><td>"."Category: "."</td>"."<td>".$row_film['Category']."</td></tr>";
			echo "<tr><td>"."Show Time: "."</td>"."<td>".$row_bc['Dates'].$space.$row_bc['Day'].$space.$row_bc['Time']."</td></tr>";
			echo "</table>";
		
			$query_hs = "SELECT * FROM House WHERE HouseId = '".$row_bc['HouseId']."'";
			$house = mysqli_query($db_conn, $query_hs) or die ("Query Error!".mysqli_error($db_conn));
			$row_hs=mysqli_fetch_array($house);
			$row = $row_hs['HouseRow'];
			$col = $row_hs['HouseCol'];

			$query_ticket = "SELECT * FROM Ticket WHERE BroadCastId = '".$bc_id."'";
			$ticket = mysqli_query($db_conn, $query_ticket) or die ("Query Error!".mysqli_error($db_conn));
			
			$array_sold = array();
			while($row_ticket=mysqli_fetch_array($ticket)){
				array_push($array_sold ,$row_ticket['SeatNo']);
			}
			$width = strval(intval($col)*60);
			$width = $width."px";
			echo "<div class=container style=width:$width;>";
		

			echo "<form id=\"form\" method=\"post\" action=\"buyticket.php?id=$bc_id\" onsubmit=\"return checked()\">";
	
			$chars = array("A", "B" , "C" ,"D", "E", "F");
			for ($x = $row-1; $x >= 0; $x--) {
				for ($y = 1; $y <= $col; $y++) {
					$seatName = $chars[$x].$y;
					if (in_array($seatName, $array_sold)) {
    						echo "<label class=\"seat_sold\">Sold $seatName</label>";
					}
					else{
						echo "<label class=\"seat\"><input id=\"chk[]\" name=\"checked[]\" value=$seatName type=\"checkbox\">$seatName</label>";
					}
				}
				echo "<br><br><br><br>";
			} 
			echo "</form>";
			echo "<label class=\"screen\">SCREEN</label>";	

		?>
		<button class=button type="submit" form="form" value="Submit" >Submit</button>		
		<a href="buywelcome.php" ><input class=button type=button value="Cancel"></a>
		</div>
    		</body>
		</html>
		<?php
	}
?>
