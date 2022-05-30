<?php
	session_start();
	session_destroy();
	//$url ="http://oes3.im.ukn.edu.tw/~loveschool/index.html" ;
	$url ="http://mysql.im.ukn.edu.tw/~loveSchool/index.html" ;
	echo "<script language='javascript' type='text/javascript'>";  
	echo "window.location.href='$url'";  
	echo "</script>"; 
?>