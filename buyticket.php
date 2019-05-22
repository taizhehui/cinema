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
    			<title>Buy Ticket</title> 
    			<link rel="stylesheet" href="style_buyticket.css" type="text/css">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
       
		</head>
		<body>
			<h1 class=title> Cart</h1>
		<?php
			$bc_id= $_GET['id'];
			$checked = $_POST['checked'];			

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
			$space = " ";

			echo "<table>";
			echo "<tr><td>"."Cinema: "."</td>"."<td>"."Star Cinema"."</td></tr>";
			echo "<tr><td>"."House: "."</td>"."<td>".$row_bc['HouseId']."</td></tr>";
			echo "<tr><td>"."Film: "."</td>"."<td>".$row_film['FilmName']."</td></tr>";
			echo "<tr><td>"."Category: "."</td>"."<td>".$row_film['Category']."</td></tr>";
			echo "<tr><td>"."Show Time: "."</td>"."<td>".$row_bc['Dates'].$space.$row_bc['Day'].$space.$row_bc['Time']."</td></tr>";
			echo "</table>";

			echo "<div class=container>";
			echo "<form id=\"form\" method=\"post\" action=\"confirm.php?id=$bc_id\" >";
			for ($x = 0; $x <sizeof($checked); $x++) {
				$seat = $checked[$x];
				$adult = $seat."($75)Adult";
				$student = $seat."($50)Student/Senior";
				echo "<ul>";
   	 			echo "<div id=seat>$seat</div>";
				echo "<select class=option name=\"option[]\"><option value=$adult>Adult($75)</option>";
				echo "<option value=$student>Student/Senior($50)</option></select></ul>";
			}
			echo "</form>";

		?>
			<button class=button type="submit" form="form" value="Submit" >Confirm</button>
			<a href="buywelcome.php" ><input class=button type=button value="Cancel"></a>
			</div>

    		</body>
		</html>
		<?php
	}

?>
