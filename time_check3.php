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
					url: 'time_check.php',
					type: 'post',
					success: function(result){
						$("#main").html(result);
					}
				});*/
				location.href = "time_check.php";
			}
		</script>
	</head>
	<body class="w3-black" align="center">
		<div class="w3-padding-large" id="main">
			<div class="w3-padding-64 w3-content w3-text-grey" id="contact1"  style="max-width: 500px;">
				<?php
					$tt=$_SESSION['user_acc'];
					$api='http://ec.knjc.edu.tw/knjcapi/TrtoStdList?trad='.$tt;
					//新增主要清單
					$ins_service=mysqli_query($link,"insert into `service_hours`(`res_id`,`ser_day`,`start_time`,`end_time`,`hr`,`service_work`,`teacher_id`)values('$_POST[res_id]','$_POST[ser_day]','$_POST[start_time]','$_POST[end_time]','$_POST[hr]','$_POST[service_work]','$tt')");
					$upOKorNO = mysqli_query($link,"update reservation set res_status='$_POST[uptime]' where res_id='$_POST[res_id]'");
					
					
					if($ins_service){
						?><script>back_step3();</script><?php
					}else{
						echo "<h2 class='w3-text-light-grey'>核銷時數失敗</h2>";
					}
					echo "<br/><br/>";
					echo "<div style='width:0%;text-align:center;'>";
						//echo "<input type='button' class='button' onclick='back_step3();' value='回主頁'>";
						?><input type="button" class="button" onclick="location.href='time_check.php';" value="回主頁">&emsp;&emsp;<?php
					echo "</div>";
					
				?>
			</div>
		</div>
	</body>
</html>


