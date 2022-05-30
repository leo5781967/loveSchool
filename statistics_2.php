<!DOCTYPE>
<meta charset="utf-8">
<html>
	<head>
		<TITLE>歷史紀錄</TITLE> 
		<meta charset="utf-8">
		<?php 
			session_start(); 
			if (empty($_SESSION['user_acc'])){
				die("<a href='index.html'>請先登入!!!!</a>");
			}
		?>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="css/table.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link href="css/M-Option.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/button.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/apply.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/select.css" rel="stylesheet" type="text/css" media="all" />
		<style>
			.w3-sidebar {width: 140px;background: #222;height: 100%;}
			table{
				font-size:28px;font-family:serif;
			}
			.bg{
				display: none; 
				position: absolute;
				top: 0%;
				left: 0%;
				width: 100%;
				height: 170%;
				background-color: black;
				z-index:1001;
				-moz-opacity: 0.7;
				opacity:.70;
				filter: alpha(opacity=70);
			}
			.show{
				display: none;  
				position: absolute;  
				top: 20%;  
				left: 20%;  
				width: 55%;  
				height: 70%;  
				padding: 8px;  
				border: 8px solid #E8E9F7; 
				position:fixed;  
				background-color: #DDDDDD;   
				z-index:1002;  
				overflow: auto;
				cursor: pointer; 
				//background-image:url(image/cc.jpg);
				background-size:100% 100%
			}
			
			.w3-padding-64 {
				padding-top: 1px!important;
				padding-bottom: 64px!important;
			}
			.w3-content {
				max-width: 1100px;
			}

		</style>
		<script>
			function statistics_recondtable(id){
				$.ajax({
						url: 'statistics_recondtable.php',
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
			function page(){
				var p=document.getElementById("page").value;
				aa(p);
			}
		</script>
	<h2 style='color:#4B0091;'>學期：<?php echo "$_GET[year]";?></h2>
	</head>
	<body>
		<center>
			<div class="w3-padding-large" id="main">
				<div id="bg" class='bg' onclick='hide();'></div>
				<div id="table" style="display: none;" class='show'></div>
				<!-- Contact Section -->
				<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
					<div id="page-wrapper">
						<!-- Banner -->
						<section id="banner">
							<?php 
							
								include "db.php";
								$year=$_GET['year'];
								$dep=$_GET['dep'];
								$grade=$_GET['grade'];
								$name=$_GET['name'];
								$account=$_GET['account'];
								$status=$_GET['status'];
								$select="SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `student_information` as e on b.`account_id`=e.`account_id` where a.`mas_id` <> ''";
								if($year!=""){
									$select.=" and b.`semester` LIKE '$year'";
								}
								if($dep!=""){
									$select.=" and e.`stu_dep` LIKE '%".$dep."%'";
								}
								if($grade!=""){
									$select.=" and e.`stu_grade` LIKE '%".$grade."%'";
								}
								if($name!=""){
									$select.=" and e.`class_name` LIKE '%".$name."%'";
								}
								if($account!=""){
									$select.=" and b.`account_id` LIKE '%".$account."%'";
								}
								if($status!=""){
									$select.=" and a.`res_status` LIKE '%".$status."%'";
								}
								$select.=" GROUP BY a.`res_id` order by a.`res_status` desc,e.`stu_grade` asc";
								$ret=mysqli_query($link,$select);
								$num=mysqli_num_rows($ret);
								if($num=='0'){
									echo "<font style='color:red; Font-size:48px;font-family:微軟正黑體 Light;text-shadow: rgb(136, 136, 136) 2px 2px 2px;'>本學期尚無紀錄!</font>";
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
									<table align='center' border='2'>";
								
									echo "
									<tr>
											<th>科系</th>
											<th>年級</th>
											<th>班級名稱</th>
											<th>學號</th>
											<th>姓名</th>
											<th>事由</th>
											<th>狀態</th>
											<th>操作</th>
									</tr>";
								
									While($row=mysqli_fetch_assoc($ret)){
										echo"<tr>
											<td>$row[stu_dep]</td>
											<td>$row[stu_grade]</td>
											<td>$row[class_name]</td>
											<td>$row[account_id]</td>
											<td>$row[stu_name]</td>
											<td>$row[content]</td>
											<td align='center'>";
											if($row["res_status"]==1){ 
												echo "<font style='color:#000;'>已完成</font>"; 
											}elseif($row["res_status"]==2){ 
												echo "<font style='color:#ff9900;'>未完成</font>";
											}elseif($row["res_status"]==3){
												echo "<font style='color:#FF0000;'>超過期限</font>";
											}
											echo"</td>
											<td><input type='button' value='詳細資料' class='blue' onclick='statistics_recondtable($row[res_id]);'></td>";
										echo"</tr>";
									};
								
									echo"</table></br>";
									
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
									echo "<font size='4px' color='#000'>共計 $data_nums 筆</font>";
								}
							?>
							</br>
						</section>
					</div>
				</div>
			</div>
		</center>
		
	</body>
</html>