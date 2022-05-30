<?php
	include "db.php";
	$teacher_sql=mysqli_query($link,"SELECT * FROM `teacher_information` as a inner join `status` as b on a.`teacher_id`=b.`teacher_id` where a.`teacher_id`='$_POST[id]' and b.`unit_id`='$_POST[ut]'");
	$teacher=mysqli_fetch_assoc($teacher_sql);
	
	if($_POST["id"]!="" and $_POST["ut"]!=""){
		if($teacher["Authority"]==0){
			mysqli_query($link,"UPDATE `status` SET `Authority`='2' where `unit_id`='$_POST[ut]' and `teacher_id`='$_POST[id]'");
		}elseif($teacher["Authority"]==2){
			mysqli_query($link,"UPDATE `status` SET `Authority`='0' where `unit_id`='$_POST[ut]' and `teacher_id`='$_POST[id]'");
		}
	}else{
	}
?>