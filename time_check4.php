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
			function back_step4(a){
				$.ajax({
					url: 'time_check1.php',
					type: 'post',
					data:{
						number:a
					},
					success: function(result){
						$("#main").html(result);
					}
				});
			}
			function go_check3(a,b,c){
				var day=document.getElementById('str_date').value;
				var del=document.getElementById('del_hr').value;
				var del2=document.getElementById('del_hr').value;
				var check_work=document.getElementById('check_work').value;
				var str_date=document.getElementById('str_date').value;
				var end_time=document.getElementById('end_time').value;
				del = del*60*60;
				$.ajax({
					url: 'time_check2.php',
					type: 'post',
					data:{
						day:day,
						res_id:a,
						account_id:b,
						del:del,
						del2:del2,
						check_work:check_work,
						total_hr:c,
						str_date:str_date,
						end_time:end_time
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
		  <font size = '5px' class='w3-text-light-grey' align='right'>請完成愛校後再上傳時數</font>
			<h2 class="w3-text-light-grey">上傳時數
			<hr style="width:200px" class="w3-opacity">
			
			<?php
				session_start();
				include ("db.php");
				$check_ok_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `student_information` as d on b.`account_id`=d.`account_id` inner join `teacher_information` as f on b.`teacher_id`=f.`teacher_id` where c.`unit_name`='$_SESSION[sps_dep]' and b.`account_id`='$_POST[account_id]'");
				
				$check =mysqli_fetch_assoc($check_ok_sql);
				$date=date("Y-m-d");
				echo "<table border='1px'>";
					echo "<tr>";
						echo "<input type='hidden' id='total_hr' name='total_hr' value='$_POST[total_hr]'>";
						echo "<input type='hidden' id='res_id' name='res_id' value='$_POST[res_id]'>";
						
					echo "<tr>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>學號</th>";
						echo "<td>$check[account_id]</td>";
						
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>姓名</th>";
						echo "<td>$check[stu_name]</td>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>年級</th>";
						echo "<td>$check[stu_grade]$check[class_name]</td>";
					echo "<tr>";
						echo "<th align='center' colspan='2' style='background-color: rgba(124, 123, 150, 0.8);'>工作內容</th>";
						if($_POST['check_work']!=""){
							echo "<td colspan='5' align='left'>";
							echo "<input type='text' name='check_work' id='check_work' style='width:50%;' value='$_POST[check_work]'>";
						echo "</td>";
						
						}else{
							echo "<td colspan='5' align='left'>";
							echo "<input type='text' name='check_work' id='check_work' style='width:50%;' placeholder='請輸入學生愛校的內容' >";
						echo "</td>";
						}
					echo "</tr>";
					$date = date( "Y-m-d" ) ;
					$time = date( "H:00" ) ;
					echo "<tr>";
						echo "<th align='center' colspan='2' style='background-color: rgba(124, 123, 150, 0.8);'>愛校日期</th>";
							echo "<td colspan='2' align='left'>";
							echo "<input type='date' name='str_date' id='str_date' value='$date' />";
							echo "</td>";
						echo "<th align='center' colspan='1' style='background-color: rgba(124, 123, 150, 0.8);'>結束時間</th>";
							echo "<td colspan='1' align='left'>";
							echo "<input type='time' name='end_time' id='end_time' value='$time' />";
							echo "</td>";
					echo "</tr>";
					//echo "$time('H')";
					//echo "$time('i')";
					echo "<tr>";
						echo "<th align='center' colspan='2' style='background-color: rgba(124, 123, 150, 0.8);'>上傳愛校時數</th>";
						if($_POST['del2']!=""){
							echo "<td colspan='2' align='left'>";
							echo "<input type='text' name='del_hr' id='del_hr' value='$_POST[del2]' />";
							echo "</td>";
						}else{
						echo "<td colspan='2' align='left'>";
						
							echo "<input type='text' name='del_hr' id='del_hr' placeholder='0' />";
						echo "</td>";
						}
						echo "請輸入時數";
						
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>總時數</th>";
						echo "<td>$_POST[total_hr] 小時</td>";
					echo "</tr>";
				echo "</table>";
				//-----------------
				echo "<br/><br/>";
				echo "<div style='width:90%;text-align:center'>";?>
					&emsp;&emsp;&emsp;&emsp;<input type="button" class="button" onclick="location.href='time_check.php';" value="回主頁">&emsp;&emsp;
					<?php
					
					echo "<input class='button' type='button' onclick='go_check3($_POST[res_id],$check[account_id],$_POST[total_hr]);' value='下一步'>";
				echo "</div>";
				
			?>
		  </div>
		</div>
	</body>
</html>
