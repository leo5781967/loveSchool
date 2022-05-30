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
			.show{
				display: none;  
				position: absolute;  
				top: 20%;  
				left: 25%;  
				width: 50%;  
				height: 40%;  
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
				height: 200%;
				background-color: black;
				z-index:1001;
				-moz-opacity: 0.7;
				opacity:.70;
				filter: alpha(opacity=70);
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
	<body onload="aa();" style="background-image:url(images/blue.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
	<body onload="fou();" class="w3-black">
			<div class="w3-padding-large" id="main">
				<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
					<div id="page-wrapper">
							<section id="banner">
								<header>
										<h2 style='color:#4B0091;'>事由統計-學生</h2>
										<h2 style='color:#4B0091;'><?php echo $_GET["seme"].$_GET["con"].$_GET["stu"].$_GET["grade"]."年  ".$_GET["class"]."班"; ?></h2>
								</header>
									<?php
											$count="SELECT e.`account_id`,e.`stu_name`,count(a.`account_id`) as `totalpeople` FROM `reservation` as a1 inner join `master_list` as a on a1.`mas_id`=a.`mas_id` INNER JOIN `student_information` AS e ON a.`account_id` = e.`account_id`  where a1.`res_status`='1' and a.`content_number`='0' and a.`semester`='$_GET[seme]' and a.`content`='$_GET[con]' and e.`stu_dep`='$_GET[stu]' and e.`stu_grade`='$_GET[grade]' and e.`class_name`='$_GET[class]' GROUP BY e.`account_id`";
											
											//合計
											$select1="SELECT count(a.`account_id`) as `totalpeople1`,sum(b.`res_hr`) as `totalhr1` FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` INNER JOIN `student_information` AS e ON a.`account_id` = e.`account_id` where b.`res_status`='1' and `content_number`='0' and a.`semester`='$_GET[seme]' and a.`content`='$_GET[con]' and e.`stu_dep`='$_GET[stu]' and e.`stu_grade`='$_GET[grade]' and e.`class_name`='$_GET[class]'";
											
											$count1=mysqli_query($link,$count);
											$ret2=mysqli_query($link,$select1);
											
											
												echo"</br>
													</br>
												<table align='center' border='2'>";	
												echo
												"<tr>
													<td align='center'><b>學號</b></td>
													<td align='center'><b>姓名</b></td>
													<td align='center'><b>登記次數</b></td>
													<td align='center'><b>時數</b></td>
												</tr>";	
											while($row=mysqli_fetch_assoc($count1)){
												$select1="SELECT e.`account_id`,e.`stu_name`,sum(b.`res_hr`) as `totalhr` FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` inner join `units` as d on b.`unit_id`=d.`unit_id` inner join `student_information` as e on a.`account_id`=e.`account_id` where b.`res_status`='1' and a.`content_number`='0' and a.`semester`='$_GET[seme]' and a.`content`='$_GET[con]' and e.`stu_dep`='$_GET[stu]' and e.`stu_grade`='$_GET[grade]' and e.`class_name`='$_GET[class]' and e.`account_id`='$row[account_id]'";
												$ret1=mysqli_query($link,$select1);
												//分其他
												while($row1=mysqli_fetch_assoc($ret1)){
													echo
													"<tr>
														<td align='center'>$row1[account_id]</td>
														<td align='center'>$row1[stu_name]</td>
														<td align='center'>$row[totalpeople]</td>
														<td align='center'>
														<a href='statistics_4_5.php?seme=$_GET[seme] & con=$_GET[con] & stu=$_GET[stu] & grade=$_GET[grade] & class=$_GET[class] & name=$row1[stu_name]'>
														$row1[totalhr]
														</a>
														</td>
													</tr>";
												}
											}
											while($row2=mysqli_fetch_assoc($ret2)){	
													echo
													"<tr>
														<td colspan='2'>合計</td>
														<td align='center'>$row2[totalpeople1]</td>
														<td align='center'>$row2[totalhr1]</td>
													</tr>";
											}											
											echo"</table>";		

									?>
									<div name="back" align="center">
									<br/>
									<input type="button" id="back" name="back" class="red" onclick="history.go(-1)" value="返回"/>&nbsp;
									<input type="button" id="back" name="back" class="red" onclick="location.href='statistics_4_s.php'" value="返回首頁" />
									</div>
						</section>
					</div>
				</div>
			</div>
	</body>
</html>