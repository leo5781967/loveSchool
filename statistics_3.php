<!DOCTYPE html>
<?php session_start(); 
		if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
	include 'db.php';
?>
<html>
	<head>
		<title>愛校管理系統</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/table.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link href="css/M-Option.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/button.css" rel="stylesheet" type="text/css" media="all" />
		<style>
			.w3-sidebar {width: 140px;background: #222;height: 100%;}
			table{
				font-size:28px;font-family:serif;
			}
			.w3-padding-64 {
				padding-top: 6px!important;
				padding-bottom: 64px!important;
			}
		</style>
	</head>
	<body onload="fou();" class="w3-black">
			<div class="w3-padding-large" id="main">
				<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
					<div id="page-wrapper">
							<section id="banner">
								<header>
									<?php
										$ret=mysqli_query($link,"SELECT count(*) as a FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` inner join `service_hours` as c on b.`res_id`=c.`res_id` inner join `units` as d on b.`unit_id`=d.`unit_id` where b.`res_status`='1'");
										$num=mysqli_fetch_assoc($ret);
										if($num["a"]=="0"){
									?>	
										<div>
											<font style="color:#4B0091;">
											<h1>目前沒有紀錄喔~~~</h1>
											</font>
										</div>
									<?php 
										} 
										else
										{
									?>
										<h2 style='color:#4B0091;'>各單位愛校統計分配人數與時數<br>學期：<?php echo "$_POST[year]";?></h2>
								</header>
						
									<?php
											$select="SELECT semester,unit_name,count(DISTINCT a.`account_id`) as `totalpeople`,sum(b.`res_hr`) as `totalhr`FROM `master_list` AS a,`reservation` AS b,`units` AS d WHERE a.`mas_id` = b.`mas_id` AND b.`unit_id` = d.`unit_id` and  b.`res_status`='1'";
											//合計
											$select1="SELECT a.`semester`,count(DISTINCT a.`account_id`) as `totalpeople1`,sum(b.`res_hr`) as `totalhr1` FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` inner join units as d on b.`unit_id` = d.`unit_id` where b.`res_status`='1'";
											
											$year=$_POST['year'];
											if($year!=""){
												$select.=" and a.`semester` LIKE '$year'";
												$select1.=" and a.`semester` LIKE '$year'";
											}
											//分各處室
											$select.="group by d.`unit_name`";
											$ret=mysqli_query($link,$select);
											$ret1=mysqli_query($link,$select1);
											$num=mysqli_num_rows($ret);
											if($num=='0'){
											echo "<font style='color:red; Font-size:48px;font-family:微軟正黑體 Light;text-shadow: rgb(136, 136, 136) 2px 2px 2px;'>本學期尚無紀錄!</font>";
											}else{
												
											
											echo"</br>
												 </br>
											<table align='center' border='2'>";	
											echo
											"<tr>
												<td align='center'><b>各處室(科)</b></td>
												<td align='center'><b>分配人數</b></td>
												<td align='center'><b>分配時數</b></td>
											</tr>";
											$totalnum=0;
											while($row=mysqli_fetch_assoc($ret)){
												echo
												"<tr>
													<td align='center'>
													<!--<a href='statistics_3_1.php?seme=$year & unitname=$row[unit_name]'>-->
													$row[unit_name]
													<!--</a>-->
													</td>
													<td align='center'>$row[totalpeople]</td>
													<td align='center'>$row[totalhr]</td>
												</tr>";
												$totalnum+=$row["totalpeople"];
											}
											while($row1=mysqli_fetch_assoc($ret1)){
													echo
													"<tr>
														<td align='center'>合計</td>
														<td align='center'>$totalnum</td>
														<td align='center'>$row1[totalhr1]</td>
													</tr>";
												}
											echo"</table>";		
											}
											}
									?>
						</section>
					</div>
				</div>
			</div>
	</body>
</html>