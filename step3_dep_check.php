<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start();
	include('db.php');
	if(!isset($_SESSION['user_acc'])){
		echo "<center>請登入系統</center>";
		echo "<center><a href='index.php'>登入系統</a></center>";
		die();
	}
?>
<html>
	<head>
		<title>公告(右)</title>
		<script>
			
			function hide_step3(){
				document.getElementById("bg_step3").style.display = 'none';
				document.getElementById("show_step3").style.display = 'none';
			}
		</script>
		<style>
			th{ background-color:#6c85b5;font-size: large;border: 1px solid #504d9a;}
			.headerrow td{ color:#000000; text-align:center;font-family: "微軟正黑體";}
			
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
					
		</style>
	</head>
	<body>
		<center>
			<h2  style="color:#3a3f7b;">所有單位 未完成時數</h2>
		</center>
		<table align='center' border='2'  class="fancytable">
			<tr class="headerrow" height="40px">
				<th>學校單位</th>
				<th>未完成時數</th>
				<th>人數</th>
			</tr>
			<?php
				$unit_sql=mysqli_query($link,"SELECT distinct `unit_id` FROM `reservation`");
				
				$u2=0;
				$c1=0;
				$c2=0;
				
				while($unit=mysqli_fetch_assoc($unit_sql)){
					$total_hr_sql=mysqli_query($link,"SELECT `unit_name` , SUM( `res_hr` ) as 'sum' FROM `reservation` as a, `units` as b where a.`unit_id` = '$unit[unit_id]' and a.`unit_id` = b.`unit_id`");
					$total_hr=mysqli_fetch_assoc($total_hr_sql);
					$total_sum=$total_hr["sum"];
					
					//時數
					$check_hr_sql=mysqli_query($link,"SELECT * FROM `reservation`");
					while($check_hr=mysqli_fetch_assoc($check_hr_sql)){
						$check_hr_2_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `service_hours` as b on a.`res_id`=b.`res_id` where b.`res_id`='$check_hr[res_id]' and a.`unit_id`='$unit[unit_id]'");
						while($check_hr_2=mysqli_fetch_assoc($check_hr_2_sql)){
							$total_sum-=$check_hr_2["hr"];
							$c2++;
						}
						$c1++;
					}
					
					//人數
					$check_name_sql1=mysqli_query($link,"select * from `master_list` as a,`reservation` as b where a.`mas_id`=b.`mas_id` and b.`unit_id`='$unit[unit_id]' and `res_status` = '2' group by `account_id`");//找人數(查帳號)
					
					$check_name_count=mysqli_num_rows($check_name_sql1);
					while($check_name1=mysqli_fetch_assoc($check_name_sql1)){
						$check_name_sql=mysqli_query($link,"select * from `master_list` as a,`reservation` as b where a.`mas_id`=b.`mas_id` and b.`unit_id`='$unit[unit_id]' and a.`account_id`='$check_name1[account_id]'");//查帳號&單位
						//echo "'$check_name1[account_id]'";echo "<br>";
						$hr_name_count=0;
						while($check_name=mysqli_fetch_assoc($check_name_sql)){
							$hr_name=$check_name["res_hr"];
							$check_hr_3_sql=mysqli_query($link,"select * from `service_hours` as a,`reservation` as b where a.`res_id`=b.`res_id` and b.`res_id`='$check_name[res_id]'");//檢查帳號有沒有還愛校時數
							$check_hr_3=mysqli_fetch_assoc($check_hr_3_sql);
							$hr_name-=$check_hr_3["hr"];
							//echo $hr_name;echo "<br>";
							if($hr_name>0){
								$hr_name_count++;
							}
						}
						if($hr_name_count==0){
							$check_name_count--;
						}
					}
					
					echo "
						<tr>
							<td style='color:#000'>$total_hr[unit_name]</td>
							<td style='color:#000'>$total_sum</td>
							<td style='color:#000'>$check_name_count</td>
						</tr>
					";
					$u2++;
				}
				
				
				//===============================
				echo "
					
					<tr>
						<td colspan='3'>
							<input type='button' id='bgc' class='blue' value='關閉' onclick='hide_step3();'>
						</td>
					</tr>
				";
			?>
		</table>
		<div id="bgc" class='bg' onclick='hide_step3();'></div>
		<div id="show_sel" style="display: none;" class='show'></div>	
	</body>
</html>
