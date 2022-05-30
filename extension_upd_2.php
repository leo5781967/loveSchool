<?php
	header('Content-type:text/html;charset=utf-8');
	include('db.php');
	session_start();
	$upd=mysqli_query($link,"update `master_list` set `end_day`='$_POST[end_day]' WHERE `mas_id` = '$_POST[id]';");	
	
	
	//echo "<script>alert('修改成功');location.href='extension.php';</script>";
	
?>