<?php
/*echo "<script>alert('123');</script>";
die();*/
	header('Content-type:text/html;charset=utf-8');
	include('db.php');
	session_start();
	$today=date("Y-m-d");
	//判斷單位
	$unit_sql=mysqli_query($link,"select * from `units` where `unit_name`='$_SESSION[sps_dep]'");
	$unit_num=mysqli_num_rows($unit_sql);
	if($unit_num=='0'){//新增單位
		$ins_unit=mysqli_query($link,"insert into `units`(`unit_name`)values('$_SESSION[sps_dep]')");
	}
	//找老師ID(公告人)
	$teacher_sql=mysqli_query($link,"select * from `teacher_information` where `teacher_name`='$_SESSION[sps_name]'");
	$teacher=mysqli_fetch_assoc($teacher_sql);
	//找單位ID
	$unit_sql=mysqli_query($link,"select * from `units` where `unit_name`='$_SESSION[sps_dep]'");
	$unit=mysqli_fetch_assoc($unit_sql);
	//新增
	$ins=mysqli_query($link,"insert into `announment`(`ano_date`,`date_start`,`date_end`,`ano_title`,`ano_content`,`office_time_hr`,`need_people`,`remain_people`,`unit_id`,`teacher_id`) values ('$today','$_POST[start_date]','$_POST[end_date]','$_POST[title]','$_POST[context]','$_POST[time_hr]','$_POST[people]','$_POST[people]','$unit[unit_id]','$teacher[teacher_id]')");
	
	echo "<script>alert('發佈成功');location.href='apply.php';</script>";
?>