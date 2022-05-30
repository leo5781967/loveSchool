<?php

	header('Content-type:text/html;charset=utf-8');
	include('db.php');
	session_start();
	$today=date("Y-m-d");
	
	$upd=mysqli_query($link,"update `announment` set `date_start`='$_POST[start_date]',`date_end`='$_POST[end_date]',`ano_title`='$_POST[title]',`ano_content`='$_POST[content]',`office_time_hr` = '$_POST[time_hr]',`need_people`='$_POST[people]',`remain_people`='$_POST[people_last]' WHERE `ano_id` = '$_POST[id]';");
	
	
?>