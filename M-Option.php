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
	<script>
		/*function go_url(uu){
			$.ajax({
				url: uu+'.php',
				type: 'post',
				success: function(result){
					$("#main").html(result);
				}
			});
		}*/

			
	</script>
</head>

<body style="background-image:url(images/blue.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
<center>
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
	

	
	<div id="main">
		<section id="banner">

			<header>
				<?php
					$ret=mysqli_query($link,"SELECT count(*) as a FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` inner join `service_hours` as c on b.`res_id`=c.`res_id` where b.`res_status`='1'");
					
					$num=mysqli_fetch_assoc($ret);
					if($num["a"]=="0"){
				?>	
						<div>
							<font style="color:#4B0091;">
								<h1>目前沒有紀錄喔~~~</h1>
							</font>
						</div>
				<?php 
					}else{
				?>
						</br><h2>愛校紀錄統計人數與時數<br>學期：<?php echo "$_POST[year]";?></h2>
			</header>
		
			<?php
					$select="SELECT a.`semester`,count(DISTINCT a.`account_id`) as `totalpeople`,sum(b.`res_hr`) as `totalhr` FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` where b.`res_status`='1' and a.`semester`";
					
					if(@$_POST['year']!=""){
						$year=$_POST['year'];
						$select.=" LIKE '$year'";
					}
					$select.="group by a.`semester`";
					$ret=mysqli_query($link,$select);
					$num=mysqli_num_rows($ret);
					if($num=='0'){
					echo "<font style='color:red; Font-size:48px;font-family:微軟正黑體 Light;text-shadow: rgb(136, 136, 136) 2px 2px 2px;'>本學期查無此紀錄!</font>";
					}else{
				
					echo "</br></br>
						<table align='center' border='2' class='table'>";	
			
					echo "<tr>
							<td align='center'><b>人數</b></td>
							<td align='center'><b>時數</b></td>
						</tr>";
					While($row=mysqli_fetch_assoc($ret)){
			
					echo "<tr>
							<td align='center'>
							<a href='M-Option_1.php?seme=$year'>
							$row[totalpeople]
							</a>
							</td>
							<td align='center'>$row[totalhr]</td>
						</tr>";
					}
					echo"</table>";		
					}
					}
			?>
		</section>
		<br/>
		<br/>
		
	</div>
		
</center>
</body>
</html>