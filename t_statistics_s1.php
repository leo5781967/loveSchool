<!DOCTYPE html>
<?php 
	session_start(); 
		if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
	include 'db.php';
	$tt=$_SESSION['sps_dep'];
	$api='http://ec.ukn.edu.tw/knjcapi/stdsimple?idno='.$tt;
?>
<html>
	<head>
		<title>愛校管理系統</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="css/table.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link href="css/font-awesome_index.css" rel="stylesheet" type="text/css" media="all" />
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
		<script src="js/jquery-3.1.1.min.js"></script>
	</head>

	<body onload="cc();" class="w3-black" style="background-image:url(images/black.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
	<body onload="fou();" class="w3-black">

			<!-- Page Content -->
			<div class="w3-padding-large" id="main">
				<!-- Contact Section -->
				<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
					<div id="page-wrapper">
						<!-- Banner -->
								<header>
										<?php
										$ret=mysqli_query($link,"SELECT COUNT( * ) AS a FROM `master_list` AS a INNER JOIN `reservation` AS b ON a.`mas_id` = b.`mas_id` INNER JOIN `service_hours` AS c ON b.`res_id` = c.`res_id` INNER JOIN `units` AS d ON b.`unit_id` = d.`unit_id` WHERE d.`unit_name` = '$tt'");
										$num=mysqli_fetch_assoc($ret);
										
										if($num["a"]=="0"){
										?>	
											<div>
												<font style="color:#ffffff;">
												<h1>目前沒有紀錄喔~~~</h1>
												</font>
											</div>
										<?php 
										}
										else
										{
										?>
											<h2 style='color:#ffffff;'>
												分配至<?php echo $_SESSION["sps_dep"]."　愛校統計";?>
												<br>學期：<?php echo "$_POST[year]";?>
											</h2>
								</header>
						
									<?php
											$ret1="SELECT a.semester,d.unit_name,count(DISTINCT a.`account_id`) as `totalpeople`,sum(b.`res_hr`) as `totalhr` FROM `master_list` AS a,`reservation` AS b,`units` AS d where b.`res_status`='1' and a.`mas_id` = b.`mas_id` AND b.`unit_id` = d.`unit_id` AND d.`unit_name` = '$tt'";
											$year=$_POST['year'];
											if($year!=""){
												$ret1.=" and a.`semester`='$year' group by a.`semester`";
											}
											
											$ret1=mysqli_query($link,$ret1);
											$num=mysqli_num_rows($ret1);
											if($num=='0'){
												echo "<font style='color:red; Font-size:48px;font-family:微軟正黑體 Light;text-shadow: rgb(136, 136, 136) 2px 2px 2px;'>本學期尚無紀錄!</font>";
											}else{
												echo"</br>
													</br>
												<table align='center' border='2'>";	
												echo
												"<tr>
													<td align='center'><b>分配人數</b></td>
													<td align='center'><b>分配時數</b></td>
												</tr>";
												while($row=mysqli_fetch_assoc($ret1)){
													
													echo
													"<tr>
														<!--<td align='center'><a href='t_statistics_s1_1.php?seme=$year & unitname=$tt'>
														$row[totalpeople]
														</a></td>-->
														<td align='center'>$row[totalpeople]</td>
														<td align='center'>$row[totalhr]</td>
													</tr>";
												}
												echo"</table>";	
											}											
										}
									?>
									<div name="back" align="center">
									<br/>
									<input type="button" id="back" name="back" class="red" onclick="location.href='t_statistics.php'" value="返回首頁" />
									</div>
						</section>
					</div>
				</div>
			</div>
	</body>
</html>