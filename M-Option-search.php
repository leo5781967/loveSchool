<!DOCTYPE html>
<?php session_start(); 
		if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
	
	include 'db.php';
	$select=mysqli_query($link,"SELECT * FROM `master_list`");	
	$row=mysqli_num_rows($select);
?>
<html>
	<head>
	<title>康寧大學-愛校管理系統</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="css/table.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
	<link href="css/M-Option.css" rel="stylesheet" type="text/css" media="all" />
	</head>
	<style>
		.w3-sidebar {width: 140px;background: #222;height: 100%;}
		table{
			font-size:28px;font-family:serif;
		}
		
	</style>
	<script src="js/jquery-3.1.1.min.js"></script>
		<script>
		</script>
	
	<body style="background-image:url(images/blue.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">	

		<div id="big" class="content">
			<center>
				
				<?php include('menu.php'); ?>
				<div id="div2"></div>	
			</center>
		</div>
		

	</body>
</html>