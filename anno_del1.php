<?php
	header('Content-type:text/html;charset=utf-8');
	include('db.php');
	session_start();
	
	$today=date("Y-m-d");
	$del=mysqli_query($link,"delete from `announment` where `ano_id`='$_POST[id]';");
	echo "<script>alert('刪除成功');location.href='anno_right.php';</script>";

?>