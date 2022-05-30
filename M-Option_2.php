<!DOCTYPE html>
<?php session_start(); 
		if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
	include 'db.php';
	include('./menu.php');
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
			
		</style>
	</head>
	<body onload="aa();" style="background-image:url(images/blue.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
	<body onload="fou();" class="w3-black">
			<div class="w3-padding-large" id="main">
				<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
					<div id="page-wrapper">
							<section id="banner">
								<header>
										<h2 style='color:#4B0091;'>愛校紀錄統計-年級</h2>
										<h2 style='color:#4B0091;'><?php echo $_GET["seme"].$_GET["stu"]; ?></h2>
								</header>
									<?php
											$select="SELECT e.`stu_grade`,count(DISTINCT a.`account_id`) as `totalpeople`,sum(b.`res_hr`) as `totalhr` FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` inner join `student_information` AS e ON a.`account_id` = e.`account_id` where b.`res_status`='1' and a.`semester`='$_GET[seme]' and e.`stu_dep`='$_GET[stu]' group by e.`stu_grade`";
											
											//合計
											$select1="SELECT count(DISTINCT a.`account_id`) as `totalpeople1`,sum(b.`res_hr`) as `totalhr1` FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` inner join `student_information` AS e ON a.`account_id` = e.`account_id` where b.`res_status`='1' and a.`semester`='$_GET[seme]' and e.`stu_dep`='$_GET[stu]'";
											
											$ret=mysqli_query($link,$select);
											$ret1=mysqli_query($link,$select1);
											
												echo"</br>
													</br>
												<table align='center' border='2'>";	
												echo
												"<tr>
													<td align='center'><b>年級</b></td>
													<td align='center'><b>人數</b></td>
													<td align='center'><b>時數</b></td>
												</tr>";
												while($row=mysqli_fetch_assoc($ret)){
													echo
													"<tr>
														<td align='center'>
														<a href='M-Option_3.php?seme=$_GET[seme] & stu=$_GET[stu] & grade=$row[stu_grade]'>
														$row[stu_grade] 年級
														</a>
														</td>
														<td align='center'>$row[totalpeople]</td>
														<td align='center'>$row[totalhr]</td>
													</tr>";
												}
												while($row1=mysqli_fetch_assoc($ret1)){
													echo
													"<tr>
														<td align='center'>合計</td>
														<td align='center'>$row1[totalpeople1]</td>
														<td align='center'>$row1[totalhr1]</td>
													</tr>";
												}
												echo"</table>";
									?>
						<div name="back" align="center">
							<br/>
							<input type="button" id="back" name="back" class="red" onclick="history.go(-1)" value="返回"/>&nbsp;
							<input type="button" id="back" name="back" class="red" onclick="location.href='M-Option-s.php'" value="返回首頁" />
						</div>
						</section>
					</div>
				</div>
			</div>
	</body>
</html>