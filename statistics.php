<!DOCTYPE html>
<?php 
	session_start(); 
		if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
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
		
		<style>
			.w3-sidebar {width: 140px;background: #222;height: 100%;}
			table{
				font-size:28px;font-family:serif;
			}
			
		</style>
		
	</head>

	<body onload="fou();" class="w3-black">
		<?php 
		include 'db.php';
		$date_s=date("Y-m");
		$date_s=explode('-',$date_s);//將檔案名稱以-分割
		$date_s[0]."</br>";//--年
		$date_s[1]."</br>";//--月
		/*echo $date_s[0]."</br>";
		echo $date_s[1]."</br>";*/
		
		
		$new_year=$date_s[0]-1911; //民國年
		if ($date_s[1]=='8'||$date_s[1]=='9'||$date_s[1]=='10'||$date_s[1]=='11'||$date_s[1]=='12'||$date_s[1]=='1'){
		$new_month=1; //上下學期
		$new_year=$new_year;
		if ($date_s[1]=='01'){
			$new_year=$new_year-1;
		}
		}else {
		$new_month=2;
		$new_year=$new_year-1;
		}
		$school_year=$new_year.$new_month;//學期 如 1071
		//echo $school_year;
		?>
		
			<!-- Page Content -->
			<div class="w3-padding-large" id="main">
				<!-- Contact Section -->
				<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
						<div id="page-wrapper">
							<!-- Banner -->
							<section id="banner">
								<div style="text-align:right;">
									<button class="statistics1" onclick="go_url('statistics_1');">
										<span>查看各科系年級愛校歷史紀錄</span>
									</button>
									<br/><br/>
									<button class="statistics2" onclick="go_url('statistics_3');">
										<span>統計各處室(科)整學期的愛校人數時數</span>
									</button>
								</div>
								<header>
									<?php
										$ret=mysqli_query($link,"SELECT count(*) as a FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` inner join `service_hours` as c on b.`res_id`=c.`res_id` where a.`semester` = '$school_year'");
										
										$num=mysqli_fetch_assoc($ret);
										if($num["a"]=="0"){
									?>	
									<div>
										<font style="color:#fff;">
											<h1>本學期目前沒有紀錄喔~~~</h1>
										</font>
									</div>
									<?php 
										} 	
										else
										{
									?>
									<h2 style='color:#fff;'>整學期總人數與總時數</h2>
								</header>
						
									<?php
											$ret1=mysqli_query($link,"SELECT count(a.`account_id`) as `totalpeople`,sum(c.`hr`) as `totalhr` FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` inner join `service_hours` as c on b.`res_id`=c.`res_id` where a.`semester` = '$school_year'");
											
											echo"</br>
											<table align='center' border='2'>";	
											echo
											"<tr>
												<td align='center'><b>學期</b></td>
												<td align='center'><b>總人數</b></td>
												<td align='center'><b>總時數</b></td>
											</tr>";
											While($row=mysqli_fetch_assoc($ret1)){
											echo
											"<tr>
												<td align='center'>$school_year</td>
												<td align='center'>$row[totalpeople]</td>
												<td align='center'>$row[totalhr]</td>
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