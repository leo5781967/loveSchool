<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start();
	include('db.php');
	

	
	$_SESSION['sps_dep'] = urldecode($_GET['sps_dep']);
	$_SESSION['sps_name'] = urldecode($_GET['sps_name']);

//====================================
		if(isset($_SESSION['user_acc'])){
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
							
							if($Name == $_SESSION["user_acc"] && $Level=="1"){
								$currect++;
								//判斷完成
							}
							$num3++;
						}
						$num2++;
					}
					
				}
				
				$num++;
			}
			
			//=============審核權限判斷&&判斷(新增教職員、各單位)==========================
			$status_sql=mysqli_query($link,"select count(*) as a from `status` AS a INNER JOIN `units` AS b ON a.`unit_id` = b.`unit_id` where `teacher_id`='".$_SESSION['user_acc']."' and `unit_name`='".$_SESSION['sps_dep']."'");
			$teacher_sql=mysqli_query($link,"select count(*) as a from `teacher_information` where `teacher_id`='".$_SESSION['user_acc']."'");
			$unit_sql=mysqli_query($link,"select count(*) as a from `units` where `unit_name`='".$_SESSION['sps_dep']."'");
			
			$status1=mysqli_fetch_assoc($status_sql);
			$teacher=mysqli_fetch_assoc($teacher_sql);
			$unit=mysqli_fetch_assoc($unit_sql);
			
			if($teacher["a"]==0){
				$teacher_ins_sql=mysqli_query($link,"insert into `teacher_information`(`teacher_id`,`teacher_name`)values('".$_SESSION['user_acc']."','".$_SESSION['username']."')");
			}
			if($unit["a"]==0){
				$unit_ins_sql=mysqli_query($link,"insert into `units`(`unit_name`)values('".$_SESSION['sps_dep']."')");
			}
			if($status1["a"]==0){
				$status_ins_sql=mysqli_query($link,"insert into `status`(`teacher_id`,`unit_id`,`Authority`)values('".$_SESSION['user_acc']."',(select `unit_id` from `units` where `unit_name`='".$_SESSION['sps_dep']."'),'$currect')");
			}
			//=============test==========================*/
			
			
			$principal_sql2="select * from `status` as a , `teacher_information` as b , `units` as c where a.`teacher_id`=b.`teacher_id` and a.`unit_id`=c.`unit_id` and b.`teacher_id`='".$_SESSION['user_acc']."' and a.`Authority`='2' and c.`unit_name`='".$_SESSION['sps_dep']."'";
			
			//echo $principal_sql2;die();
			$principal_no2=mysqli_query($link,$principal_sql2) or die("錯誤");
			$principal=mysqli_fetch_assoc($principal_no2);
			
			$tea=0;
			$api='http://ec.knjc.edu.tw/knjcapi/TrtoStdList?trad='.$_SESSION['user_acc'];//stddata
			$data1 = simplexml_load_file($api) or $tea=1;
			
			//echo $row['level'];
			if($currect>0 && $tea==0){
				//主任、班級導師-A
				$_SESSION['level']='A';
			}else if(mysqli_num_rows($principal_no2)>0 &&  $tea==0){
				//審核人、班級導師-B
				$_SESSION['level']='B';
			}else if($currect>0){
				//主任(包含審核人)C
				$_SESSION['level']='C';
			}else if(mysqli_num_rows($principal_no2)>0){
				//審核人R
				$_SESSION['level']='R';
			}else if($tea==0){
				//班級導師T
				$_SESSION['level']='T';
			}else{
				//一班教職員M
				$_SESSION['level']='M';
			}
			
		}
//====================================
	
	echo "<script>location.href='apply.php'</script>";
?>