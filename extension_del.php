<?php
	session_start();
	include "db.php";
	$res_sel=mysqli_query($link,"SELECT * FROM `reservation` where `res_id`='$_POST[id]'");
	$res=mysqli_fetch_assoc($res_sel);
	
	$mas_sel=mysqli_query($link,"SELECT * FROM `master_list` where `mas_id`='$res[mas_id]'");
	$mas=mysqli_fetch_assoc($mas_sel);
	
	$del_total=$mas["total_hr"]-$res["res_hr"];
	
	if($_POST["id"]!=""){
		mysqli_query($link,"UPDATE `master_list` SET `total_hr`='$del_total' where `mas_id`='$mas[mas_id]'");
		$mas2_sel=mysqli_query($link,"SELECT * FROM `master_list` where `mas_id`='$res[mas_id]'");
		$mas2=mysqli_fetch_assoc($mas2_sel);
		if($mas2["total_hr"]==0){
			mysqli_query($link,"DELETE FROM `master_list` WHERE `mas_id`='$mas[mas_id]'");
		}
		
		mysqli_query($link,"DELETE FROM `reservation` WHERE `res_id`='$res[res_id]'");
		
		echo "<script>alert('刪除成功');location.href='extension.php';</script>";
	}else{
		echo "<script>alert('刪除失敗');location.href='extension.php';</script>";
	}
?>