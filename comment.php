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
    			<link rel="stylesheet" href="style_comment.css" type="text/css">
		<script>
			function isEmpty(){
				var c =document.getElementById("textarea").value;
				if(c.length<1)
   				{
        				window.alert ("Comment cant be left empty");
        				return false;
    				}
			}
			function ajax(){
				var xmlhttp;
				if (window.XMLHttpRequest) {
					xmlhttp = new XMLHttpRequest();
				} else {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
          
				xmlhttp.onreadystatechange = function () {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						var mesgs = document.getElementById("viewcomment");
						mesgs.innerHTML = xmlhttp.responseText;
					}
				}
				var filmId= document.getElementById("option").value;
				xmlhttp.open("GET", "comment_retrieve.php?filmID="+filmId,true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.send();
			}
		</script>
		</head>
		<body>

    		<ul>

    		<li><a href="buywelcome.php">Buy a ticket</a></li> 
		<li><a href="comment.php">Movie review</a></li>
		<li><a href="history.php">Purchase History</a></li>
		<li><a href="logout.php">Logout</a></li>
		</ul>
		<h1 class=title>Movie Review</h1>

		<?php
		
		$host = "sophia";
		$username="zhtai";
		$password="zh950915";
		$database="zhtai";
		$db_conn=mysqli_connect($host,$username,$password,$database) or die ("Connection Error! ".mysqli_connect_error());

		$query = "SELECT * FROM Film";
		$Film=mysqli_query($db_conn, $query) or die ("Query Error!".mysqli_error($db_conn));
		echo "<h3 class=title2> Film Name </h3>";

		echo "<form id=form action=comment_submit.php method=post onsubmit=\"return isEmpty()\">";
		echo "<select id=option name=filmId>";
    		while ($row_film=mysqli_fetch_array($Film)) {
			$filmId = $row_film['FilmId'];
                 	$filmName = $row_film['FilmName'];
                   	echo '<option value="'.$filmId.'">'.$filmName.'</option>';
		}
    		echo "</select>";
		echo "</form>";

		echo "<textarea id=\"textarea\" rows=20 cols=80 name=comment form=form placeholder=\"Please input comment here\"></textarea>";
		echo "<br>";
		echo "<div id=container>";
		echo "<button class=button type=submit onclick=ajax() >View comment</button>";
		echo "<button class=button type=submit form=form >Submit comment</button>";
		echo "</div>";
		echo "<div id=viewcomment></div>";


	
	
		echo "</body>";
		echo "</html>";


	}

?>
