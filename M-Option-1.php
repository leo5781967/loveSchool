<!DOCTYPE html>
<?php 
	session_start(); 
	if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
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
	<link href="css/button.css" rel="stylesheet" type="text/css" media="all" />

	<style>
		.w3-sidebar {width: 140px;background: #222;height: 100%;}
		table{
			font-size:28px;font-family:serif;
		}

		.change3 {
			box-shadow: 0px 0px 0px 2px #FF2D2D;
			background:linear-gradient(to bottom, #FF2D2D 5%, #FF7575 100%);
			/*background-color:#ff3333;*/
			border-radius:10px;
			border:1px solid #FF2D2D;
			display:inline-block;
			cursor:pointer;
			color:#ffffff;
			font-family:Arial;
			font-size:19px;
			padding:12px 37px;
			text-decoration:none;
			text-shadow:0px 1px 0px #283966;
		}

		.change3 span {
			cursor: pointer;
			display: inline-block;
			position: relative;
			transition: 0.5s;
		}

		.change3 span:after {
			content: '»';
			position: absolute;
			opacity: 0;
			top: 0;
			right: -20px;
			transition: 0.5s;
		}

		.change3:hover span {
			padding-right: 25px;
		}

		.change3:hover span:after {
			opacity: 1;
			right: 0;
		}
	</style>
	<script src="js/jquery-3.1.1.min.js"></script>
</head>
<body style="background-image:url(images/blue.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">

<center>

	<?php 
		include 'db.php';
		$select="SELECT semester FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` where a.`semester`";
		
		$year=$_POST['year'];
		if(@$_POST['year']!=""){
			$select.=" LIKE '$year'";
			//echo "$_POST[year]";
		}
	?>

	<div id="main">
		<section id="banner">
			<header>
				<?php
				$n=1;
				$s=0;
				$check_name_sql1=mysqli_query($link,"select * from `master_list` as a,`reservation` as b where a.`mas_id`=b.`mas_id` and a.`semester`='$year' group by `account_id`");
					$check_name_count=mysqli_num_rows($check_name_sql1);
					while($check_name1=mysqli_fetch_assoc($check_name_sql1)){
						$check_name_sql=mysqli_query($link,"select * from `master_list` as a,`reservation` as b where a.`mas_id`=b.`mas_id` and a.`account_id`='$check_name1[account_id]'");
						$hr_name_count=0;
						while($check_name=mysqli_fetch_assoc($check_name_sql)){
							$hr_name=$check_name["res_status"];
							if($hr_name!=1){
								$hr_name_count++;
							}
					}	

						if($hr_name_count==0){
							$check_name_count--;
						}
					}
				$dephour=0;
				$dep_hr=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `student_information` as d on b.`account_id`=d.`account_id` inner join `teacher_information` as f on b.`teacher_id`=f.`teacher_id` where b.`semester`='$year'");
				while($dehr1=mysqli_fetch_assoc($dep_hr)){
					$dep_hr2=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `service_hours` as b on a.`res_id`=b.`res_id` inner join `master_list` as c on a.`mas_id`=c.`mas_id` where c.`account_id`='$dehr1[account_id]' and b.`res_id`='$dehr1[res_id]'");
								$dephour1=$dehr1["res_hr"];
								//echo "$dephour1<br/>";
								while($dehr2=mysqli_fetch_assoc($dep_hr2)){
									$dephour1=round($dephour1-$dehr2["hr"],1);
									//echo "$dephour1<br/>";
								}
									$dephour = $dephour + $dephour1;
								}
					//echo "$dephour";
					if($dephour == 0){
				?>	
						<div>
							<font style="color:#4B0091;">
								<h1>本學期尚無紀錄!</h1>
							</font>
						</div>
				<?php 
					}else{
				?>
						</br><h2>統計學期人數與未完成時數<br>學期：<?php echo "$_POST[year]";?></h2>
			</header>

			<?php
					$select.="group by a.`semester`";
					$ret=mysqli_query($link,$select);
					echo "</br></br>
						<table align='center' border='2' class='table'>";
					echo "<tr>
							<td align='center'><b>人數</b></td>
							<td align='center'><b>未完成時數</b></td>
						</tr>";
					While($row=mysqli_fetch_assoc($ret)){
					echo "<tr>
							<td align='center'>$check_name_count</td>
							<td align='center'>$dephour</td>
						</tr>";
					}
					echo"</table>";		
					}
			?>
		</section>
		<br/>
		<br/>
	</div>
</center>
</body>
</html>