<?php
session_start();
include "db.php";
	
	$currect=0;
			
	$api1='http://ec.ukn.edu.tw/knjcapi/ukndep?IsAll=false';
	$data = simplexml_load_file($api1) or die("錯誤");
	//print_r($data);
	
	$num=1;$num2=0;
	foreach ($data->UknDepEmp as $key){
		//print_r($key);echo "<br>";  進第一層
		
		$dName=(string)$key->DepName;//將單位丟入dName
		if($_SESSION["sps_dep"] == $dName){   //首先判斷單位
			
			foreach ($key->children() as $key2){//進入第二層，children()子類別
				
				//print_r($key2);echo "<br>";
				$num3=0;
				foreach ($key2->depemp as $key3){//進入第三層，抓到教職員ID、Level權限
					
					//print_r($key3);echo "<br>";
					
					$Name=(string)$key3->name;
					$Level=(string)$key3->level;
					
					//===============================================
					
					
					/*$teacher_sql=mysqli_query($link,"SELECT * FROM `teacher_information` where `teacher_id`='$Name'");
					$teacher_num=mysqli_num_rows($teacher_sql);*/
					
					$status_sql=mysqli_query($link,"SELECT * FROM `status` as a inner join `units` as b on a.`unit_id`=b.`unit_id` inner join `teacher_information` as c on a.`teacher_id`=c.`teacher_id` where a.`teacher_id`='$Name' and a.`unit_id`='$_SESSION[sps_dep]'");
					
					$status_num=mysqli_num_rows($status_sql);
				
					$unit_sql=mysqli_query($link,"SELECT * FROM `units` where `unit_name`='$_SESSION[sps_dep]'");
					$unit=mysqli_fetch_assoc($unit_sql);
					
					
					$api='http://ec.ukn.edu.tw/knjcapi/truser?trid='.$Name;
					$data = simplexml_load_file($api);
					$tea_name=(string)$data->Truser->trname;
	
					if($status_num==0){
						$ins_teacher=mysqli_query($link,"INSERT INTO `teacher_information`(`teacher_id`,`teacher_name`) VALUES ('$Name','$tea_name')");
					
						
					
					}
					$status2_sql=mysqli_query($link,"SELECT * FROM `status` where `teacher_id`='$Name' and `unit_id`='$unit[unit_id]'");
					$status2=mysqli_num_rows($status2_sql);
					if($status2==0){
						$ins_status=mysqli_query($link,"INSERT INTO `status`(`unit_id`,`teacher_id`,`Authority`) VALUES ('$unit[unit_id]','$Name','$currect')");
					}
					$num3++;
				}
				$num2++;	
			}	
		}
		$num++;
	}
	
	$manager_sql=mysqli_query($link,"SELECT * FROM `teacher_information` as a inner join `status` as b on a.`teacher_id`=b.`teacher_id` inner join `units` as c on b.`unit_id`=c.`unit_id` where `unit_name`='$_SESSION[sps_dep]' order by `Authority` desc");
	$manager_num=mysqli_num_rows($manager_sql);
	if($manager_num!=0){
		echo "<script>alert('同步成功');location.href='apply.php';</script>";
	}else{
		echo "<script>alert('同步失敗);location.href='apply.php';</script>";
	}
?>