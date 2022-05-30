<!DOCTYPE html>
<?php
	error_reporting(0); //PHP提示Notice: Undefined variable的解決辦法
	header('Content-type: text/html; charset=utf-8');
	session_start();
	if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
	include 'db.php';
	include('semester.php');
	

?>
<html>
	<head>
		<title>愛校服務系統</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/table.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link href="css/font-awesome_index.css" rel="stylesheet" type="text/css" media="all" />
		<style>
			.w3-sidebar {width: 140px;background: #222;height: 100%;}
			table{
				font-size:28px;font-family:serif;
			}
		</style>
		<script>
			function back_step3(){
				/*$.ajax({
					url: 'apply_step1.php',
					success: function(result){
						$("#main").html(result);
					}
				});*/
				location.href = "apply_step1.php";
			}
		</script>
	</head>
	<body class="w3-black" align="center">
		<div class="w3-padding-large" id="main">
			<div class="w3-padding-64 w3-content w3-text-grey" id="contact1"  style="max-width: 500px;">
				<?php
					$d=seme();
					$array=$_SESSION["master_list"];
					$array["end_day"]=$_POST["end_day"];
					$array["semester"]=$d;
					//-----------------------------------------------------------------------------
					//判斷學生&老師是否有資料
					$stu_data_sql=mysqli_query($link,"select count(*) as a from `student_information` where `account_id`='$array[stu_number]'");
					$tch_data_sql=mysqli_query($link,"select count(*) as a from `teacher_information` where `teacher_id`='$array[tch_id]'");
					$tch_data_num=mysqli_num_rows($tch_data_sql);
					$stu_data_num=mysqli_num_rows($stu_data_sql);
					
					if($tch_data_num["a"]==0){
						$ins_tch=mysqli_query($link,"insert into `teacher_information`(`teacher_id`,`teacher_name`)values('$array[tch_id]','$array[tch_name]')");
						
					}
					if($stu_data_num["a"]==0){
						$ins_stu=mysqli_query($link,"insert into `student_information`(`account_id`,`stu_dep`,`stu_grade`,`class_name`,`stu_name`,`teacher_id`) values ('$array[stu_number]','$array[stu_dep]','$array[stu_grade]','$array[stu_class]','$array[stu_name]','$array[tch_id]')");
						
					}
					//-----------------------------------------------------------------------------
					//新增主要清單
					$content1=mysqli_real_escape_string($link,$array["content"]);//SQL Injection 
					//-----------------------------------------------------------------------------
					$content_number=2;
					switch ($content1){
						case "曠課輔導":
							$content_number = 0;
							echo "曠課輔導";
							break;
						case "留校察看":
							$content_number = 0;
							echo "留校察看";
							break;
						case "改過銷過":
							$content_number = 0;
							echo "改過銷過";
							break;
						case "服儀違規":
							$content_number = 0;
							echo "服儀違規";
							break;
						case "愛宿":
							$content_number = 0;
							echo "愛宿";
							break;
						default:
							$content_number = 1;
							echo "其他";
					}
					//-----------------------------------------------------------------------------
					$ins_master=mysqli_query($link,"insert into `master_list`(`account_id`,`teacher_id`,`content`,`content_number`,`total_hr`,`write_day`,`end_day`,`semester`,`mas_status`)values('$array[stu_number]','$_SESSION[user_acc]','$content1','$content_number','$array[total_hr]','$array[write_day]','$array[end_day]','$array[semester]','$_POST[check_radio]')");
				
					
					
					if($ins_master){
						$sel=mysqli_query($link,"SELECT LAST_INSERT_ID() as `mas_id`;");
						
						$sel2=mysqli_fetch_assoc($sel);
						for($i=0;$i<count($_POST["dep"]);$i++){
							$dep=$_POST["dep"][$i];
							
							$unit_sql=mysqli_query($link,"SELECT * FROM `units` where `unit_name`='$dep'");
							$unit=mysqli_num_rows($unit_sql);
							if($unit==0){
								mysqli_query($link,"INSERT INTO `units`(`unit_name`) VALUES ('$dep')");
							}
							$unit_sql2=mysqli_query($link,"SELECT * FROM `units` where `unit_name`='$dep'");
							
							$unit2=mysqli_fetch_assoc($unit_sql2);
							
							$num=$_POST["num"][$i];
							
							$reservation=mysqli_query($link,"INSERT INTO `reservation`(`mas_id`,`unit_id`,`res_hr`,`res_status`) VALUES ('$sel2[mas_id]','$unit2[unit_id]','$num','2');");
							
							
						}
						
						?><script>back_step3();</script><?php
					}else{
						echo "NO";
					}
					echo "<br/><br/>";
					echo "<div style='width:0%;text-align:center;'>";
						echo "<input type='button' class='button' onclick='back_step3();' value='回主頁面'>";
					echo "</div>";
					
				?>
			</div>
		</div>
	</body>
</html>


