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
	<?php include('./sidebar.php'); ?>
	<body onload="fou();" class="w3-black">

			<!-- Page Content -->
			<div class="w3-padding-large" id="main">
				<!-- Contact Section -->
				<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
					<div id="page-wrapper">
						<!-- Banner -->
								<section id="banner">
								<header>
										<h2 style='color:#ffffff;'>統計各處室(科)-科系</h2>
										<h2 style='color:#ffffff;'><?php echo $_GET["seme"].$_GET["unitname"]; ?></h2>
								</header>
						
									<?php
											$select="SELECT stu_dep,count(DISTINCT e.`account_id`) as `totalpeople`,sum(c.`hr`) as `totalhr` FROM `master_list` AS a,`reservation` AS b, `service_hours` AS c,`units` AS d,`student_information` as e where b.`res_status`='1' and a.`mas_id` = b.`mas_id` AND b.`res_id` = c.`res_id` AND b.`unit_id` = d.`unit_id` and a.`account_id`=e.`account_id` and a.`semester`='$_GET[seme]' and d.`unit_name`='$_GET[unitname]' group by e.`stu_dep`";
											$ret=mysqli_query($link,$select);
											
												echo"</br>
													</br>
												<table align='center' border='2'>";	
												echo
												"<tr>
													<td align='center'><b>科系</b></td>
													<td align='center'><b>分配總人數</b></td>
													<td align='center'><b>分配總時數</b></td>
												</tr>";
												while($row=mysqli_fetch_assoc($ret)){
													echo
													"<tr>
														<td align='center'>
														<a href='t_statistics_s2.php?seme=$_GET[seme] & unitname=$_GET[unitname] & stu=$row[stu_dep]'>
														$row[stu_dep]
														</a>
														</td>
														<td align='center'>$row[totalpeople]</td>
														<td align='center'>$row[totalhr]</td>
													</tr>";
												}
												echo"</table>";
									?>
						<div name="back" align="center">
							<br/>
							<input type="button" id="back" name="back" class="red" onclick="history.go(-1)" value="返回"/>&nbsp;
							<input type="button" id="back" name="back" class="red" onclick="location.href='t_statistics_s0.php'" value="返回首頁" />
						</div>
						</section><br>
					</div>
				</div>
			</div>
	</body>
</html>