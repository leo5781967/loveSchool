<!DOCTYPE html>
<?php
 error_reporting(0); //PHP提示Notice: Undefined variable的解決辦法
 header('Content-type: text/html; charset=utf-8');
 session_start();
 if (empty($_SESSION['user_acc'])){
  die("<a href='index.html'>請先登入!!!!</a>");
 }
 include ("db.php");


 
 
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
		<link href="css/button.css" rel="stylesheet" type="text/css" media="all" />
		
		<style>
			.fancytable{border:2px;width:100%;border-collapse:collapse;color:#fff;}
			.fancytable td{border:1px solid #504d9a; color:#555555;text-align:center;line-height:28px;font-weight:bold;font-size:20px;}
			.headerrow{ background-color:#6c85b5;font-size: large;border: 1px solid #504d9a;}
			.headerrow td{ color:#000000; text-align:center;font-family: "微軟正黑體";}
			.datarowodd td{background-color:#FFFFFF;}
			.dataroweven td{ background-color:#efefef;}
			.datarowodd td{background-color:#ffffff;font-family: "微軟正黑體";}
			.dataroweven td{ background-color:#efefef;font-family: "微軟正黑體";}
				
			.bg{
				display: none; 
				position: absolute;
				top: 0%;
				left: 0%;
				width: 200%;
				height: 100%;
				background-color: black;
				z-index:1001;
				-moz-opacity: 0.7;
				opacity:.70;
				filter: alpha(opacity=70);
			}
			.show{
				display: none;  
				position: absolute;  
				top: 20%;  
				left: 25%;  
				width: 50%;  
				height: 50%;  
				padding: 8px;  
				border: 8px solid #a1a4c5; 
				position:fixed;  
				background-color: #DDDDDD;   
				z-index:1002;  
				overflow: auto;
				//cursor: pointer; 
				//background-image:url(image/cc.jpg);
				background-size:100% 100%
			}
			.btn{
				cursor: pointer;
			}
			
			.w3-sidebar {width: 140px;background: #222;height: 100%;}
			
		</style>
		<script>
			function go_check1_back(){
				/*$.ajax({
					url: 'time_check.php',
					type: 'post',
					success: function(result){
						alert('查無此學生！');
						$("#main").html(result);
					}
				});*/
				alert('查無此學生！');
				location.href = "time_check.php";
			}
			function go_check2(a,b,c,d){
				
				var account_id=document.getElementById("account_id"+b).value;
				var check_work=document.getElementById("check_work").value;
				var del2=document.getElementById("del2").value;
				$.ajax({
					url: 'time_check4.php',
					type: 'post',
					data:{
					
						account_id:account_id,
						res_id:c,
						total_hr:d,
						check_work:check_work,
						del2:del2
						},
					success: function(result){
						$("#main").html(result);
					}
				});
			}
			function key() { 
				if(event.keyCode == 13) 
				go_check2(); 
			}
			
		</script>
	</head>
	<body onload="fou();" class="w3-black">
			<!-- Page Content -->
			<div class="w3-padding-large" id="main">
			  <!-- Contact Section -->
			  <div class="w3-padding-64 w3-content w3-text-grey" id="contact">
			  <?php
				
				//===================================
				$api='http://ec.ukn.edu.tw/knjcapi/stdsimple?idno='.$_POST["number"];
				@$data = simplexml_load_file($api) or die("<script>go_check1_back();</script>");
				$stu_name=(string)$data->stdSimple->chiname; //姓名
				$stu_dep=(string)$data->stdSimple->depname; //科系
				$stu_grade=(string)$data->stdSimple->Degree;   //年級
				$stu_class=(string)$data->stdSimple->tclass;   //班級
				
				$api2='http://ec.knjc.edu.tw/knjcapi/stdtotr?stdno='.$_POST["number"];
				@$data2 = simplexml_load_file($api2) or die("<script>go_check1_back();</script>");
				$tch_id=(string)$data2->StdToTr->TeacherId; //姓名
				$tch_name=(string)$data2->StdToTr->TeacherName; //姓名
				//===================================
				
				$Result =mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `student_information` as d on b.`account_id`=d.`account_id` inner join `teacher_information` as f on b.`teacher_id`=f.`teacher_id` where c.`unit_name`='$_SESSION[sps_dep]' and b.`account_id`='$_POST[number]'");
				$num_rows = mysqli_num_rows($Result);
				if($num_rows == 0){
					echo "<h3 class='w3-text-light-grey' style='font-size:45px;'>本單位尚無此學生愛校紀錄1</h3>";
				}else{
					$Result = mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `student_information` as d on b.`account_id`=d.`account_id` inner join `teacher_information` as f on b.`teacher_id`=f.`teacher_id` where c.`unit_name`='$_SESSION[sps_dep]' ");
				$num_rows = mysqli_num_rows($Result);
				//==============================================
				$time_check_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `student_information` as d on b.`account_id`=d.`account_id` inner join `teacher_information` as f on b.`teacher_id`=f.`teacher_id` where c.`unit_name`='$_SESSION[sps_dep]' and b.`account_id`='$_POST[number]'");
				$n2=1;
				$s2=0;
				/*while($n_people=mysqli_fetch_assoc($time_check_sql)){
					$n_people2=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `service_hours` as b on a.`res_id`=b.`res_id` inner join `master_list` as c on a.`mas_id`=c.`mas_id` where c.`account_id`='$n_people[account_id]' and b.`res_id`='$n_people[res_id]'");
					$total_hr1=$n_people["res_hr"];
					while($n_people3=mysqli_fetch_assoc($n_people2)){
						$total_hr1=round($total_hr1-$n_people3["hr"],1);
					}
					$s2++;
					if($total_hr1 != 0){
						$n2++;
					}
				}
				$n2 = $n2 - 1;
				//echo "$n2";
				if($n2 == 0){
					echo "<h3 class='w3-text-light-grey' style='font-size:45px;'>本單位尚無此學生愛校紀錄2</h3>";
				}else{*/
				
				?>
				<h1 class="w3-text-light-grey" style="font-size:45px;">愛校時數上傳</h1>
				<table class="fancytable">
					<tr class="headerrow" height="50px" style="font-size:25px;">
						<th>科系</th>
						<th>班級</th>
						<th>學號</th>
						<th>姓名</th>
						<th>結束時間</th>
						<th>須完成時數</th>
						<th>登記老師</th>
						<th>狀態</th>
						<th>操作</th>
					</tr>
					<tr>
						<?php 
						$time_check_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `student_information` as d on b.`account_id`=d.`account_id` inner join `teacher_information` as f on b.`teacher_id`=f.`teacher_id` where c.`unit_name`='$_SESSION[sps_dep]' and b.`account_id`='$_POST[number]' order by end_day DESC");
							
							$n=1;
							$s=0;
							while($sel2=mysqli_fetch_assoc($time_check_sql)){
								
								$time_hr_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `service_hours` as b on a.`res_id`=b.`res_id` inner join `master_list` as c on a.`mas_id`=c.`mas_id` where c.`account_id`='$sel2[account_id]' and b.`res_id`='$sel2[res_id]'");
								$total_hr=$sel2["res_hr"];
								$newdate=date('Y-m-d');
								while($sel3=mysqli_fetch_assoc($time_hr_sql)){
									$total_hr=round($total_hr-$sel3["hr"]);
								}						
								$s++;
								if($total_hr != 0){
								if($s%2==0){
									echo "
									
										<tr class='datarowodd'>	
										<input type='hidden' id='check_work' name='check_work' value=''>
										<input type='hidden' id='del2' name='del2' value=''>
											<input type='hidden' id='res' name='res' value='$sel2[res_id]'>
													<td>$sel2[stu_dep]</td>
													<td>$sel2[stu_grade]$sel2[class_name]</td>
													<td>$sel2[account_id]
														<input type='hidden' name='account_id$n' id='account_id$n' value='$sel2[account_id]'>
													</td>
													<td>$sel2[stu_name]</td>
													<td>$sel2[end_day]</td>
													<td>$total_hr	小時</td>
													<td>$sel2[teacher_name]</td>";
													
													if ($sel2['mas_status']==0 and $sel2['end_day'] < $newdate){
														echo "<td style='color:red'>超過期限</td>";
														echo "<td>
														<input type='button' id='check' name='check' class='green' value=' 上傳時數 ' onclick='go_check2($sel2[account_id],$n,$sel2[res_id],$total_hr)'>&nbsp&nbsp
													</td>";
													}else if($sel2['mas_status']==1 and $sel2['end_day'] < $newdate){
														echo "<td style='color:red' colspan='2'>超過期限不可上傳</td>";
													}else{
														echo "<td>可操作</td>";
														echo "<td>
														<input type='button' id='check' name='check' class='green' value=' 上傳時數 ' onclick='go_check2($sel2[account_id],$n,$sel2[res_id],$total_hr)'>&nbsp&nbsp
													</td>";
													}
													
													
										"</tr>
									";
								}else{
									echo "
									
										<tr class='datarowodd'>	
										<input type='hidden' id='check_work' name='check_work' value=''>
										<input type='hidden' id='del2' name='del2' value=''>
											<input type='hidden' id='res' name='res' value='$sel2[res_id]'>
													<td>$sel2[stu_dep]</td>
													<td>$sel2[stu_grade]$sel2[class_name]</td>
													<td>$sel2[account_id]
														<input type='hidden' name='account_id$n' id='account_id$n' value='$sel2[account_id]'>
													</td>
													<td>$sel2[stu_name]</td>
													<td>$sel2[end_day]</td>
													<td>$total_hr	小時</td>
													<td>$sel2[teacher_name]</td>";
													if ($sel2['mas_status']==0 and $sel2['end_day'] < $newdate){
														echo "<td style='color:red'>超過期限</td>";
														echo "<td>
														<input type='button' id='check' name='check' class='green' value=' 上傳時數 ' onclick='go_check2($sel2[account_id],$n,$sel2[res_id],$total_hr)'>&nbsp&nbsp
													</td>";
													}else if($sel2['mas_status']==1 and $sel2['end_day'] < $newdate){
														echo "<td style='color:red' colspan='2'>超過期限不可上傳</td>";
													}else{
														echo "<td>可操作</td>";
														echo "<td>
														<input type='button' id='check' name='check' class='green' value=' 上傳時數 ' onclick='go_check2($sel2[account_id],$n,$sel2[res_id],$total_hr)'>&nbsp&nbsp
													</td>";
													}
													
										"</tr>
									";
								}
								$n++;
								}else{
								
								if($s%2==0){
									echo "
									
										<tr class='datarowodd'>	
										<input type='hidden' id='check_work' name='check_work' value=''>
										<input type='hidden' id='del2' name='del2' value=''>
											<input type='hidden' id='res' name='res' value='$sel2[res_id]'>
													<td>$sel2[stu_dep]</td>
													<td>$sel2[stu_grade]$sel2[class_name]</td>
													<td>$sel2[account_id]
														<input type='hidden' name='account_id$n' id='account_id$n' value='$sel2[account_id]'>
													</td>
													<td>$sel2[stu_name]</td>
													<td>$sel2[end_day]</td>
													<td>0	小時</td>
													<td>$sel2[teacher_name]</td>";
													echo "<td style='color:green' colspan='2'>已完成</td>";
								}else{
									echo "
									
										<tr class='datarowodd'>	
										<input type='hidden' id='check_work' name='check_work' value=''>
										<input type='hidden' id='del2' name='del2' value=''>
											<input type='hidden' id='res' name='res' value='$sel2[res_id]'>
													<td>$sel2[stu_dep]</td>
													<td>$sel2[stu_grade]$sel2[class_name]</td>
													<td>$sel2[account_id]
														<input type='hidden' name='account_id$n' id='account_id$n' value='$sel2[account_id]'>
													</td>
													<td>$sel2[stu_name]</td>
													<td>$sel2[end_day]</td>
													<td>0	小時</td>
													<td>$sel2[teacher_name]</td>";
													echo "<td style='color:green' colspan='2'>已完成</td>";
								}
								$n++;	
									}
								}
						//}
					}
					if($n == 1){
						echo "<h3 class='w3-text-light-grey' style='font-size:45px;'>本單位尚無此學生愛校紀錄</h3>";
					}
						?>
					
					</tr>
					
				</table>
				<br>
				<center>
					<input type="button" class="button" onclick="location.href='time_check.php';" value="回主頁">&emsp;&emsp;
				</center>
			  </div>
			</div>
	</body>
</html>
