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
			
		</style>
		<script src="js/jquery-3.1.1.min.js"></script>
	</head>

	<body onload="bb();" class="w3-black" style="background-image:url(images/black.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
	<?php include('./sidebar.php'); ?>

			<!-- Page Content -->
			
			<div style="text-align:center;">
			<br><br><br><br><br><br><br><br>
				
				<input style="height:60px;width:40%;" class="blue" type="button" name="assimilation"  value="統計 (<?php echo $_SESSION["sps_dep"];?>) 總人數總時數" onclick="location.href='t_statistics_s0.php'">
				
				<br><br><br><br>
				<?php
				if($_SESSION['level']=='A' || $_SESSION['level']=='C'){ 
				?>
					<input style="height:60px;width:40%;" class="blue" type="button" name="assimilation"  value="本科事由統計人數人次時數(僅限學術單位主任)" onclick="location.href='t_statistics_s.php'">
				<?php
				}
				?>
				
			</div>
	</body>
</html>