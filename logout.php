<?php
	session_start();
	session_destroy();
	echo "<h2>Logging out</h2>";
	echo '<script type="text/javascript">
           setTimeout(function(){ window.location="index.html"; }, 3000);
      	</script>';


?>
