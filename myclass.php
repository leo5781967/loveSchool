<!DOCTYPE html>
<?php session_start(); 
		if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
	
	include 'db.php';
	$tt=$_SESSION['user_acc'];
	$api='http://ec.knjc.edu.tw/knjcapi/TrtoStdList?trad='.$tt;
?>
<html>
	<head>
		<title>愛校系統</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="css/table.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link href="css/font-awesome_index.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/select.css" rel="stylesheet" type="text/css" media="all" />
		<style>
		
			.fancytable{border:2px;width:100%;border-collapse:collapse;color:#fff;}
			.fancytable td{border:1px solid #504d9a; color:#555555;text-align:center;line-height:28px;font-weight:bold;font-size:18px;}
			.headerrow{ background-color:#6c85b5;font-size: large;border: 1px solid #504d9a;}
			.headerrow td{ color:#000000; text-align:center;font-family: "微軟正黑體";}
			.datarowodd td{background-color:#FFFFFF;}
			.dataroweven td{ background-color:#efefef;}
			.datarowodd td{background-color:#ffffff;font-family: "微軟正黑體";}
			.dataroweven td{ background-color:#efefef;font-family: "微軟正黑體";}
			
			
			.w3-sidebar {width: 140px;background: #222;height: 100%;}
			table{
				font-size:18px;font-family:serif;
			}
			ul.pagination {
				display: inline-block;
				padding: 0;
				margin: 0;
				font-size:15px
			}

			ul.pagination li {display: inline;}
			ul.pagination li a {
				color: black;
				float: left;
				padding: 8px 16px;
				text-decoration: none;
				transition: background-color .3s;
				font-size:15px
			}

			ul.pagination li a.active {
				background-color:#FFB630;
				color: white;
				font-size:15px
			}

			ul.pagination li a:hover:not(.active){
				background-color: #dddddd;
				font-size:15px
			}
			 .bb {
				transition: all 0.5s ease 0s;
				width:50px
		   }
		   .bb:hover {
				-moz-transform: scale(1.05);
				-ms-transform: scale(1.05);
				-o-transform: scale(1.05);
				-webkit-transform: scale(1.05);
				transform: scale(1.05);
				opacity: .5;
		   }
			.w3-padding-64 {
				padding-top: 1px!important;
				padding-bottom: 64px!important;
			}
		</style>
		<script>
			function myclass_recondtable(id){
				$.ajax({
						url: 'myclass_recondtable.php',
						type: 'post',
						data:{a:id},
						success: function(result){
							$("#table").html(result);
							document.getElementById("table").style.display = 'block';
							document.getElementById("bg").style.display = 'block';
						}
					});
			}
			function page(){
				var p=document.getElementById("page").value;
				aa(p);
			}
		</script>
	</head>

	<body class="w3-black">
			<!-- Contact Section -->
			<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
		    
				<div id="main">
					<!-- Banner -->
					<section id="banner">
						
						<header>				
						<h2 style='color:#ffffff;'>學期：<?php echo "$_GET[year]";?></h2>
						</header>
						
						<?php		
									$date_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `teacher_information` as d on b.`teacher_id`=d.`teacher_id` inner join `student_information` as e on b.`account_id`=e.`account_id` where e.`teacher_id` = '$tt' and a.`res_status`='2' and b.`end_day`<=now()");
									while($date=mysqli_fetch_array($date_sql)){
										mysqli_query($link,"UPDATE `reservation` SET `res_status`='3' where `res_id`='$date[res_id]'");
									}
									$date_sql2=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `teacher_information` as d on b.`teacher_id`=d.`teacher_id` inner join `student_information` as e on b.`account_id`=e.`account_id` where e.`teacher_id` = '$tt' and a.`res_status`='3' and b.`end_day`>=now()");
									while($date2=mysqli_fetch_array($date_sql2)){
										mysqli_query($link,"UPDATE `reservation` SET `res_status`='2' where `res_id`='$date2[res_id]'");
									}
									//搜尋
									$select="SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `teacher_information` as d on b.`teacher_id`=d.`teacher_id` inner join `student_information` as e on b.`account_id`=e.`account_id` where e.`teacher_id` = '$tt'";
									$year=$_GET['year'];
									$account=$_GET['account'];
									if($year!=""){
									$select.=" and b.`semester` LIKE '$year'";
									}
									if($account!=""){
									$select.=" and b.`account_id` LIKE '%".$account."%'";
									}
									$select.=" order by a.`res_status` desc";

									$ret=mysqli_query($link,$select);
									$num=mysqli_num_rows($ret);
									if($num=='0'){
										echo "<font style='color:red; Font-size:48px;font-family:微軟正黑體 Light;text-shadow: rgb(136, 136, 136) 2px 2px 2px;'>本學期查無此紀錄!</font>";
									}else{
										
										$data_nums = mysqli_num_rows($ret); //統計總比數
										$per = 10; //每頁顯示項目數量
										$pages = ceil($data_nums/$per); //取得不小於值的下一個整數
										if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
											$page=1; //則在此設定起始頁數
										} else {
											$page = intval($_GET["page"]); //確認頁數只能夠是數值資料
										}
	
										$start = ($page-1)*$per; //每一頁開始的資料序號
										
										$ret = mysqli_query($link,$select.' LIMIT '.$start.', '.$per) or die("Error");
										
										echo"
										<table align='center' border='2' class='fancytable'>";
										echo
										"<tr class='headerrow'>
											<th align='center'><b>截止日期</b></th>
											<th align='center'><b>學號</b></th>
											<th align='center'><b>姓名</b></th>
											<th align='center'><b>事由</b></th>
											<th align='center'><b>報到單位</b></th>
											<th align='center'><b>總時數</b></th>
											<th align='center'><b>未完成時數</b></th>
											<th align='center'><b>狀態</b></th>
											<th align='center'><b>操作</b></th>
										</tr>";
										$s=0;
										While($row=mysqli_fetch_assoc($ret)){
										
											$time_hr_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `service_hours` as b on a.`res_id`=b.`res_id` inner join `master_list` as c on a.`mas_id`=c.`mas_id` where c.`account_id`='$row[account_id]' and b.`res_id`='$row[res_id]'");
											
											$total_hr=$row["res_hr"];
											
										
											while($sel3=mysqli_fetch_assoc($time_hr_sql)){
												
												$total_hr=round($total_hr-$sel3["hr"],1);
											}
												$s++;
											
												echo
												"<tr class='datarowodd'>
												<td align='center'>$row[end_day]</td>
												<td align='center'>$row[account_id]</td>
												<td align='center'>$row[stu_name]</td>
												<td align='center'>$row[content]</td>
												<td align='center'>$row[unit_name]</td>
												<td align='center'>$row[res_hr]</td>
												<td align='center'>$total_hr</td>
												<td align='center'>";
												if($row["res_status"]==1){ 
													echo "<font style='color:#000;'>已完成</font>"; 
												}elseif($row["res_status"]==2){ 
													echo "<font style='color:#ff9900;'>未完成</font>";
												}elseif($row["mas_status"]==1 and $row["res_status"]==3){
													echo "<font style='color:red;'>超過期限無法審核</font>";
												}elseif($row["res_status"]==3){
													echo "<font style='color:red;'>超過期限</font>";
												}
												echo"</td>
												<td align='center'><input type='button' class='blue' value='詳細資料' onclick='myclass_recondtable($row[res_id]);'></td>
											</tr>";
										
										}				
										echo"</table>";		
										
										//分頁頁碼
										echo "
											<div id='data_page'>
												<div class='select' style='width:120px;margin-top:15px;'>
													<select id='page' style='padding-left:30px;' class='select1' onchange='page();'>
										";
										$q=0;
										for($i=1;$i<=$pages;$i++){
											if($i==$page){
												echo "<option value='$i' selected>第".$i."頁</option>";
											}else{
												echo "<option value='$i'>第".$i."頁</option>";
												$q=$i;
											}
										}
										echo "
													</select>
												</div>
											</div>
										";
										echo "<font size='4px' color='#fff'>共計 $data_nums 筆</font>";
									}
									
									echo"<br>";		
						?>
					</section>
				</div>
			</div>
	</body>
</html>