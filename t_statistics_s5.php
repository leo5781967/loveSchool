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
		<link href="css/font-awesome_index.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/button.css" rel="stylesheet" type="text/css" media="all" />
		<style>
			.w3-sidebar {width: 140px;background: #222;height: 100%;}
			table{
				font-size:28px;font-family:serif;
			}
			.show{
				display: none;  
				position: absolute;  
				top: 20%;  
				left: 25%;  
				width: 50%;  
				height: 55%;  
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
			.w3-padding-64 {
				padding-top: 6px!important;
				padding-bottom: 64px!important;
			}
		</style>
		<!--詳細資料要有這行-->
		<script src="js/jquery-3.1.1.min.js"></script>
		<script>
			function stu_1(id){
				$.ajax({
						url: 'stu_1.php',
						type: 'post',
						data:{a:id},
						success: function(result){
							$("#table").html(result);
							document.getElementById("table").style.display = 'block';
							document.getElementById("bg").style.display = 'block';
						}
					});
			}
			function hide(){
				document.getElementById("bg").style.display = 'none';
				document.getElementById("table").style.display = 'none';
			}
		</script>
	</head>
	<body onload="cc();" class="w3-black" style="background-image:url(images/black.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
	<?php include('./sidebar.php'); ?>
	<body onload="fou();" class="w3-black">
		<div id="bg" class='bg' onclick='hide();'></div>
		<div id="table" style="display: none;" class='show'></div>
			<!-- Page Content -->
			<div class="w3-padding-large" id="main">
				<!-- Contact Section -->
				<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
					<div id="page-wrapper">
						<!-- Banner -->
							<section id="banner">
								<header>
										<h2 style='color:#ffffff;'>統計各處室(科)-學生</h2>
										<h2 style='color:#ffffff;'><?php echo $_GET["seme"].$_GET["unitname"].$_GET["stu"].$_GET["grade"]."年  ".$_GET["class"]."班　".$_GET["name"]; ?></h2>
								</header>
						
									<?php																		
											$select1="SELECT * FROM `master_list` AS a,`reservation` AS b, `service_hours` AS c,`units` AS d,`student_information` as e ,`teacher_information` as f where b.`res_status`='1' and a.`mas_id` = b.`mas_id` AND b.`res_id` = c.`res_id` AND b.`unit_id` = d.`unit_id` and a.`account_id`=e.`account_id` and a.`teacher_id`=f.`teacher_id`and a.`semester`='$_GET[seme]' and d.`unit_name`='$_GET[unitname]' and e.`stu_dep`='$_GET[stu]' and e.`stu_grade`='$_GET[grade]' and e.`class_name`='$_GET[class]' and e.`stu_name`='$_GET[name]' GROUP BY b.`res_id`";
											$ret1=mysqli_query($link,$select1);
											
												echo"</br>
													</br>
												<table align='center' border='2'>";	
												echo
												"<tr>
													<td align='center'><b>完成日期</b></td>
													<td align='center'><b>愛校內容</b></td>
													<td align='center'><b>愛校單位</b></td>
													<td align='center'><b>審核人</b></td>
													<td align='center'><b>總時數</b></td>
													<td align='center'><b>操作</b></td>
												</tr>";											
												//分其他
												while($row1=mysqli_fetch_assoc($ret1)){
													echo
													"<tr>
														<td align='center'>$row1[ser_day]</td>
														<td align='center'>$row1[service_work]</td>
														<td align='center'>$row1[unit_name]</td>
														<td align='center'>$row1[teacher_name]</td>
														<td align='center'>$row1[res_hr]</td>
														<td><input type='button' value='詳細資料' class='blue' onclick='stu_1($row1[res_id]);'></td>
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