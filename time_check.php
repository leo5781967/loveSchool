<!DOCTYPE html>
<?php 
	error_reporting(0);//隱藏mysql版本問題
	header('Content-type: text/html; charset=utf-8');
	session_start();
	include('db.php');
	if(!isset($_SESSION['user_acc'])){
		echo "<center>請登入系統</center>";
		echo "<center><a href='index.php'>登入系統</a></center>";
		die();
	}
//-------------------------------------------------------------------------------------------
	//

?>

<html>
	<head>
		<title>愛校管理系統</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
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
		<script src="js/jquery-3.1.1.min.js"></script>
		<script>
			
			function go_check1(){
				var num=document.getElementById("number").value;
				$.ajax({
					url: 'time_check1.php',
					type: 'post',
					data:{number:num},
					success: function(result){
						$("#main").html(result);
					}
				});
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
				go_check1(); 
			}
			function fou() { 
				document.getElementById("number").focus();
			}
			fou();
		</script>
	</head>
	
	<body onload="fou();" class="w3-black" style="background-image:url(images/black.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
		<?php include('./sidebar.php'); ?>
		<!-- Page Content -->
		<div class="w3-padding-large" id="main">
			<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
				<?php
				
				$unit_sql=mysqli_query($link,"SELECT distinct `unit_id` FROM `units` where `unit_name`='$_SESSION[sps_dep]'");
				while($unit=mysqli_fetch_assoc($unit_sql)){
				$check_name_sql1=mysqli_query($link,"select * from `master_list` as a,`reservation` as b where a.`mas_id`=b.`mas_id` and b.`unit_id`='$unit[unit_id]' group by `account_id`");//找人數(查帳號)
					$check_name_count=mysqli_num_rows($check_name_sql1);
					$total_check_name_count=$check_name_count;
					while($check_name1=mysqli_fetch_assoc($check_name_sql1)){
						$check_name_sql=mysqli_query($link,"select * from `master_list` as a,`reservation` as b where a.`mas_id`=b.`mas_id` and b.`unit_id`='$unit[unit_id]' and a.`account_id`='$check_name1[account_id]'");//查帳號&單位
						$hr_name_count=0;
						while($check_name=mysqli_fetch_assoc($check_name_sql)){
							$hr_name=$check_name["res_status"];
							if($hr_name!=1){
								$hr_name_count++;
							}
						}
						
						
						if($hr_name_count==0){
							$check_name_count--;
						}
					}
				}
				//==============================================
				if($total_check_name_count==""){
					$total_check_name_count=0;
				}
				//==========================================================================
				$dephour=0;
				$dep_hr=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `student_information` as d on b.`account_id`=d.`account_id` inner join `teacher_information` as f on b.`teacher_id`=f.`teacher_id` where c.`unit_name`='$_SESSION[sps_dep]' order by end_day asc");
				while($dehr1=mysqli_fetch_assoc($dep_hr)){
					$dep_hr2=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `service_hours` as b on a.`res_id`=b.`res_id` inner join `master_list` as c on a.`mas_id`=c.`mas_id` where c.`account_id`='$dehr1[account_id]' and b.`res_id`='$dehr1[res_id]'");
								$dephour1=$dehr1["res_hr"];
								$newdate=date('Y-m-d');
								while($dehr2=mysqli_fetch_assoc($dep_hr2)){
									$dephour1=round($dephour1-$dehr2["hr"],1);
								}
								$s++;
								if($dephour1 == 0){
									
								}else{
									
									if($dehr1['end_day'] < $newdate and $dehr1['mas_status'] == 1){
										
									}else{
										if($s%2==0){
										}else{
										}
										$dephour = $dephour + $dephour1;
									}
								}
				}
				//==========================================================================
				echo "<font class='w3-text-light-grey' align='right'>分派至$_SESSION[sps_dep] 愛校共 $total_check_name_count 人</font>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<font class='w3-text-light-grey' align='right'>未完成愛校共 $check_name_count 人</font>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<font class='w3-text-light-grey' align='right'>未完成愛校共 $dephour 小時</font>";
				
				

					
					
				?>
				<!-- Contact Section -->
				
				
				<h1 class="w3-text-light-grey" style="font-size:45px;">愛校時數上傳</h1>
				<h2 class="w3-text-light-grey">輸入學號：</h2>
				<hr style="width:200px" class="w3-opacity">
				
				<p>
					<input id="number" class="w3-input w3-padding-16" type="text" onkeyup="key();" placeholder="學號(可搜尋本單位學生紀錄)" >
				</p>
				<p>
					<button class="w3-button w3-light-grey w3-padding-large" onclick="go_check1();">
						<i class="fa fa-paper-plane"></i> 送出
					</button>
				</p>
				<?php
				//==============================================
				if($check_name_count == 0){
					echo "<h3 class='w3-text-light-grey' style='font-size:45px;'>$_SESSION[sps_dep] 暫無愛校同學</h3>";
				}else{
				?>
				<table class="fancytable" >
				
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
							$n=1;
							$s=0;
							$time_check_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `student_information` as d on b.`account_id`=d.`account_id` inner join `teacher_information` as f on b.`teacher_id`=f.`teacher_id` where c.`unit_name`='$_SESSION[sps_dep]' order by `end_day` DESC");
							while($sel2=mysqli_fetch_assoc($time_check_sql)){
								
								$time_hr_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `service_hours` as b on a.`res_id`=b.`res_id` inner join `master_list` as c on a.`mas_id`=c.`mas_id` where c.`account_id`='$sel2[account_id]' and b.`res_id`='$sel2[res_id]'");
								$total_hr=$sel2["res_hr"];
								$newdate=date('Y-m-d');
								while($sel3=mysqli_fetch_assoc($time_hr_sql)){
									$total_hr=round($total_hr-$sel3["hr"],1);
								}
								
								$s++;
								if($total_hr == 0){
									
								}else{
									
									if($sel2['end_day'] < $newdate and $sel2['mas_status'] == 1){
										
									}else{
										if($s%2==0){
											echo "
											
												<tr class='datarowodd' style='height:53px'>	
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
													}else{
														echo "<td>可操作</td>";
													}
													
													echo "<td>
														<input type='button' id='check' name='check' class='green' value=' 上傳時數 ' onclick='go_check2($sel2[account_id],$n,$sel2[res_id],$total_hr)'>&nbsp&nbsp
													</td>
												</tr>
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
													}else{
														echo "<td>可操作</td>";
													}
													echo "<td>
														<input type='button' id='check' name='check' class='green' value=' 上傳時數 ' onclick='go_check2($sel2[account_id],$n,$sel2[res_id],$total_hr)'>&nbsp&nbsp
													</td>
												</tr>
											";
										}
										$n++;
									}
									
								}
							
							}?>	
					</tr>
				</table>
				<?php
				}
				
				?>
			</div>
		</div>
	</body>
</html>
