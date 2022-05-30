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
										<h2 style='color:#4B0091;'>事由統計人數人次與時數<br>學期：<?php echo "$_POST[year]";?></h2>
								</header>
						
									<?php
											$year=$_POST['year'];
											
											//其他人數----------------------------------
												$totalnum=0;
												$count="SELECT a.`content`,count(a.`account_id`) as `totalpeople` FROM `reservation` as a1 inner join `master_list` as a on a1.`mas_id`=a.`mas_id` INNER JOIN `student_information` AS e ON a.`account_id` = e.`account_id`  where a1.`res_status`='1' and a.`content_number`='1' and a.`semester`='$year' GROUP BY a.`content`";
												
												$count1=mysqli_query($link,$count);
												
												while($row=mysqli_fetch_assoc($count1)){
													$select1="SELECT a.`content`,count(DISTINCT a.`account_id`) as `people`,sum(b.`res_hr`) AS `totalhr` FROM `master_list` AS a INNER JOIN `reservation` AS b ON a.`mas_id` = b.`mas_id` INNER JOIN `units` AS d ON b.`unit_id` = d.`unit_id` where b.`res_status`='1' and a.`content_number`='1' and a.`semester`='$year' and a.`content`='$row[content]'";
													$ret1=mysqli_query($link,$select1);
													while($row1=mysqli_fetch_assoc($ret1)){
														if($row1["totalhr"] != 0){
															$totalnum+=$row1["people"];
														}
													}
												}		
												echo"</table>";	
											//------------------------------------------
											
											$count="SELECT a.`semester`,a.`content`,count(a.`account_id`) as `totalpeople` FROM `reservation` as a1 inner join `master_list` as a on a1.`mas_id`=a.`mas_id` INNER JOIN `student_information` AS e ON a.`account_id` = e.`account_id`  where a1.`res_status`='1' and a.`content_number`='0'";
											
											$count1="SELECT a.`semester`,a.`content`,count(a.`account_id`) as `totalpeople` FROM `reservation` as a1 inner join `master_list` as a on a1.`mas_id`=a.`mas_id` INNER JOIN `student_information` AS e ON a.`account_id` = e.`account_id`  where a1.`res_status`='1' and a.`content_number`='1'";
											
											//合計
											$select2="SELECT a.`semester`,count(a.`account_id`) as `totalpeople1`,sum(b.`res_hr`) as `totalhr1` FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` inner join units as d on b.`unit_id` = d.`unit_id` where b.`res_status`='1'";
											
											if($year!=""){
												//content_number=0,group by分事由
												$count.=" and a.`semester`='$year' GROUP BY a.`content`";
												//content_number=1其他,group by不能分事由只能分學期
												$count1.=" and a.`semester`='$year' GROUP BY a.`semester`";
												//合計分學期
												$select2.=" and a.`semester` LIKE '$year'";
											}										
											
											$count11=mysqli_query($link,$count);
											$count2=mysqli_query($link,$count1);
											$ret2=mysqli_query($link,$select2);
											
												echo"</br>
													</br>
												<table align='center' border='2'>";	
												echo
												"<tr>
													<td align='center'><b>事由</b></td>
													<td align='center'><b>人數</b></td>
													<td align='center'><b>人次</b></td>
													<td align='center'><b>時數</b></td>
												</tr>";	
											$totalnum1=0;											
											while($roww=mysqli_fetch_assoc($count11)){
												$select="SELECT a.`semester`,a.`content`,count(DISTINCT a.`account_id`) as `people`,sum(b.`res_hr`) as `totalhr` FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` inner join `units` as d on b.`unit_id`=d.`unit_id` where b.`res_status`='1' and a.`content_number`='0' and a.`content`='$roww[content]'";
												if($year!=""){									
												$select.=" and a.`semester`='$year' GROUP BY a.`content`";
												}			
												$ret=mysqli_query($link,$select);
																								
												while($row=mysqli_fetch_assoc($ret)){
													echo
													"<tr>
														<td align='center'>
														<a href='statistics_4_1.php?seme=$year & con=$row[content]'>
														$row[content]
														</a>
														</td>
														<td align='center'>$row[people]</td>
														<td align='center'>$roww[totalpeople]</td>
														<td align='center'>$row[totalhr]</td>
													</tr>";
												$totalnum1+=$row["people"];
												}
											}
											$totalnum2=0;
											while($rowww=mysqli_fetch_assoc($count2)){
												$select1="SELECT a.`semester`,a.`content`,count(DISTINCT a.`account_id`) as `people`,sum(b.`res_hr`) as `totalhr` FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` inner join `units` as d on b.`unit_id`=d.`unit_id` where b.`res_status`='1' and a.`content_number`='1' and a.`semester`='$rowww[semester]'";
												if($year!=""){
													$select1.=" and a.`semester`='$year' GROUP BY a.`semester`";
												}
												$ret1=mysqli_query($link,$select1);
												//分其他
												while($row1=mysqli_fetch_assoc($ret1)){
												//等於0消失
													if($totalnum != 0){
														echo
														"<tr>
															<td align='center'>
															<a href='statistics_4_1_1.php?seme=$year'>
															其他
															</a>
															</td>
															<td align='center'>$totalnum</td>
															<td align='center'>$rowww[totalpeople]</td>
															<td align='center'>$row1[totalhr]</td>
														</tr>";
													}
												}
											}
											$totalnum2+=$totalnum1 + $totalnum;
											while($row2=mysqli_fetch_assoc($ret2)){	
													
													echo
													"<tr>
														<td align='center'>合計</td>
														<td align='center'>$totalnum2</td>
														<td align='center'>$row2[totalpeople1]</td>
														<td align='center'>$row2[totalhr1]</td>
													</tr>";
											}			
											echo"</table>";
										}
									?>
						</section>
					</div>
				</div>
			</div>
	</body>
</html>