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
    			<title>Main</title> 
    			<link rel="stylesheet" href="style_main4.css" type="text/css">
       
		</head>
		<body>
		<ul>

    		<li><a href="buywelcome.php">Buy a ticket</a></li> 
		<li><a href="comment.php">Movie review</a></li>
		<li><a href="history.php">Purchase History</a></li>
		<li><a href="logout.php">Logout</a></li>
		</ul>
		</body>
		</html>
		<?php
	}

?>
