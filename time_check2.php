<!DOCTYPE html>
<?php
 /*error_reporting(0); //PHP提示Notice: Undefined variable的解決辦法
 header('Content-type: text/html; charset=utf-8');
 session_start();
 if (empty($_SESSION['user_acc'])){
  die("<a href='index.html'>請先登入!!!!</a>");
 }

 $api='http://ec.ukn.edu.tw/knjcapi/stdsimple?idno='.$_POST["number"];
 @$data = simplexml_load_file($api) or die("<script>go_check1_back();</script>");
 $stu_name=(string)$data->stdSimple->chiname; //姓名
 $stu_dep=(string)$data->stdSimple->depname; //科系
 $stu_grade=(string)$data->stdSimple->Degree;   //年級
 $stu_class=(string)$data->stdSimple->tclass;   //班級
 
 $api2='http://ec.knjc.edu.tw/knjcapi/stdtotr?stdno='.$_POST["number"];
 @$data2 = simplexml_load_file($api2);
 $tch_id=(string)$data2->StdToTr->TeacherId; //姓名
 $tch_name=(string)$data2->StdToTr->TeacherName; //姓名*/
	echo "<input type='hidden' id='total_hr' name='total_hr' value='$_POST[total_hr]'>";
	echo "<input type='hidden' id='res_id' name='res_id' value='$_POST[res_id]'>";
	echo "<input type='hidden' id='account_id' name='account_id' value='$_POST[account_id]'>";
	echo "<input type='hidden' id='check_work' name='check_work' value='$_POST[check_work]'>";
	echo "<input type='hidden' id='del2' name='del2' value='$_POST[del2]'>";
	if($_POST['check_work'] == ''){
	  echo "
	  <script>
	  alert('請確認是否有輸入服務內容');
	  var account_id = document.getElementById('account_id').value;
	  var res_id = document.getElementById('res_id').value;
	  var total_hr = document.getElementById('total_hr').value;
	  var check_work = document.getElementById('check_work').value;
	  var del2 = document.getElementById('del2').value;
	  $.ajax({
					url: 'time_check4.php',
					type: 'post',
					data:{
						account_id:account_id,
						res_id:res_id,
						total_hr:total_hr,
						check_work:check_work,
						del2:del2
					},
					success: function(result){
						$('#main').html(result);
					}
				});
	  </script>
	  ";
	  die();
  }
  if($_POST['del2'] > $_POST['total_hr']){
	  echo "
	  <script>
	  alert('超出時數');
	  var account_id = document.getElementById('account_id').value;
	  var res_id = document.getElementById('res_id').value;
	  var total_hr = document.getElementById('total_hr').value;
	  var check_work = document.getElementById('check_work').value;
	  var del2 = document.getElementById('del2').value;
	  $.ajax({
					url: 'time_check4.php',
					type: 'post',
					data:{
						account_id:account_id,
						res_id:res_id,
						total_hr:total_hr,
						check_work:check_work,
						del2:del2
					},
					success: function(result){
						$('#main').html(result);
					}
				});
	  </script>
	  ";
	  die();
  }
    if($_POST['del2'] == 0){
	  echo "
	  <script>
	  alert('請輸入時數');
	  var account_id = document.getElementById('account_id').value;
	  var res_id = document.getElementById('res_id').value;
	  var total_hr = document.getElementById('total_hr').value;
	  var check_work = document.getElementById('check_work').value;
	  var del2 = document.getElementById('del2').value;
	  $.ajax({
					url: 'time_check4.php',
					type: 'post',
					data:{
						account_id:account_id,
						res_id:res_id,
						total_hr:total_hr,
						check_work:check_work,
						del2:del2
					},
					success: function(result){
						$('#main').html(result);
					}
				});
	  </script>
	  ";
	  die();
  }
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
			.w3-sidebar {width: 140px;background: #222;height: 105%;}
			table{
				font-size:28px;font-family:serif;
			}
		</style>
		<script>
			
			function back_step3(){
				$.ajax({
					url: 'time_check.php',
					type: 'post',
					success: function(result){
						$("#main").html(result);
					}
				});
				
			}
			function back_step4(a,b,c){
				var check_work=document.getElementById('check_work').value;
				var del2=document.getElementById('del_hr').value;
				$.ajax({
					url: 'time_check4.php',
					type: 'post',
					data:{
						account_id:a,
						res_id:b,
						total_hr:c,
						check_work:check_work,
						del2:del2
					},
					success: function(result){
						$("#main").html(result);
					}
				});
			}
			function go_check3(a){
				var sd=document.getElementById('check_date').value;
				var st=document.getElementById('start_time').value;
				var et=document.getElementById('end_time').value;
				var sw=document.getElementById('check_work').value;
				var hr=document.getElementById('del_hr').value;
				var uptime=document.getElementById('uptime').value;
				
				var time_check_step2 = confirm("您確認要通過嗎？"); 
				if(!time_check_step2){
					return false; 
				}
				$.ajax({
					url: 'time_check3.php',
					type: 'post',
					data:{
						res_id:a,
						ser_day:sd,
						start_time:st,
						end_time:et,
						service_work:sw,
						hr:hr,
						uptime:uptime
					},
					
					success: function(result){
						$("#main").html(result);
					}
				});
			}
			function sel_chg(){
				var xx=document.getElementById("xx");
				var content=document.getElementById("content").value;
				if(content=='其他'){
					xx.style.display="block";
					xx.innerHTML="<input type='text' id='other' placeholder='請輸入事由'/>";
				}else{
					xx.style.display="none";
				}
			}
			
			var hh=0;
			function load(x){
				hh=x;		//全部共hh個小時
			}
			
			
			
			
		</script>
	</head>
	<body class="w3-black">
		<!-- Page Content -->
		<div class="w3-padding-large" id="main">
		  <!-- Contact Section -->
		  <div class="w3-padding-64 w3-content w3-text-grey" id="contact">
			<h2 class="w3-text-light-grey">上傳時數
		
			<hr style="width:200px" class="w3-opacity">
			
			<?php
				session_start();
				include ("db.php");
				$check_ok_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `student_information` as d on b.`account_id`=d.`account_id` inner join `teacher_information` as f on b.`teacher_id`=f.`teacher_id` where c.`unit_name`='$_SESSION[sps_dep]' and b.`account_id`='$_POST[account_id]'");
				
				$check =mysqli_fetch_assoc($check_ok_sql);
				echo "<table border='1px'>";
					echo "<tr>";
						
						echo "<th colspan='2' style='background-color: rgba(124, 123, 150, 0.8);'>報到單位</th>";
						echo "<td colspan='2'>$_SESSION[sps_dep]</td>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>填報人</th>";
						echo "<td>$_SESSION[sps_name]</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>學號</th>";
						echo "<td>$check[account_id]</td>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>科系</th>";
						echo "<td>$check[stu_dep]</td>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>愛校日期</th>";
						echo "<input type='hidden' name='check_date' id='check_date' value='$_POST[day]' readonly>";
						echo "<td>$_POST[day]</td>";
					echo "</tr>";	
					echo "<tr>";
						echo "<th colspan='2' style='background-color: rgba(124, 123, 150, 0.8);'>姓名</th>";
						echo "<td colspan='2' >$check[stu_name]</td>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>年級</th>";
						echo "<td>$check[stu_grade]$check[class_name]</td>";
					echo "</tr>";
					$str_time = strtotime("$_POST[end_time]")-"$_POST[del]";
					$str_time_hr = date('H:i', $str_time);
					echo "<tr>";	
					echo "<th style='background-color: rgba(124, 123, 150, 0.8);' colspan='2' >執行開始時間</th>";
					echo "<input type='hidden' name='start_time' id='start_time' value='$str_time_hr' readonly></td>";
					echo "<td colspan='2'>$str_time_hr</td>";
					echo "<th style='background-color: rgba(124, 123, 150, 0.8);' colspan='1'>執行結束時間</th>";
					echo "<input type='hidden' name='end_time' id='end_time' value='$_POST[end_time]' readonly>";
					echo "<td>$_POST[end_time]</td>";
				 echo "";
					echo "</tr>";
					
					echo "<tr>";
						echo "<th align='center' colspan='2' style='background-color: rgba(124, 123, 150, 0.8);'>工作內容</th>";
							echo "<input type='hidden' name='check_work' id='check_work' style='width:50%;' value = '$_POST[check_work]' readonly>";
							echo "<td colspan='4'>$_POST[check_work]</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<th align='center' colspan='2' style='background-color: rgba(124, 123, 150, 0.8);'>上傳愛校時數</th>";
							
							$del = $_POST['del']/60/60 ;
							echo "<input type='hidden' name='del_hr' id='del_hr' value='$del' readonly/>";
							echo "<td colspan='4'>$del</td>";
						
					echo "</tr>";
				echo "</table>";
				//-----------------
				echo "<br/><br/>";
				echo "<div style='width:90%;text-align:center'>";
				
					?><input type="button" class="button" onclick="location.href='time_check.php';" value="回主頁">&emsp;&emsp;<?php
					echo "<input type='button' class='button' onclick='back_step4($check[account_id],$_POST[res_id],$_POST[total_hr]);' value='上一步'>&emsp;&emsp;";
					
					echo "<input class='button' type='button' onclick='go_check3($_POST[res_id]);' value='下一步'>";
					
				echo "</div>";
				$uptime = 2;
				if ($_POST['total_hr']-$_POST['del2'] == 0){
					$uptime = 1;
				}
				echo "<input type='hidden' name='uptime' id='uptime' value='$uptime'/>";
			?>
		  </div>
		</div>
	</body>
</html>
