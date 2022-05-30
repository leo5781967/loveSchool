<!DOCTYPE>
<meta charset="utf-8">
<html>
	<head>
		<TITLE>歷史紀錄</TITLE> 
		<meta charset="utf-8">
		<?php 
			session_start(); 
			if (empty($_SESSION['user_acc'])){
				die("<a href='../index.html'>請先登入!!!!</a>");
			}
		?>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		
		<link href="../css/button.css" rel="stylesheet" type="text/css" media="all" />
		
		
		<style>
			.show {
				display: none;
			}
		</style>
		<script>
			function statistics_recondtable(id){
				$.ajax({
						url: '../statistics_recondtable.php',
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
	<body>
		<center>
			<div class="w3-padding-large" id="main">
				<!-- Contact Section -->
				<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
					<div id="page-wrapper">
						<!-- Banner -->
						<section id="banner">
							<?php 
								include "../db.php";
								$year=$_POST['year'];
								$dep=$_POST['dep'];
								$grade=$_POST['grade'];
								$name=$_POST['name'];
								$account=$_POST['account'];
								$select="SELECT * FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` inner join `service_hours` as c on b.`res_id`=c.`res_id` inner join `student_information` as d on a.`account_id`=d.`account_id` where a.`mas_id` <> ''";
								if($year!=""){
									$select.=" and `semester` LIKE '$year'";
								}
								
								if($dep!=""){
									$select.=" and `stu_dep` LIKE '%".$dep."%'";
								}
								if($grade!=""){
									$select.=" and `stu_grade` LIKE '%".$grade."%'";
								}
								if($name!=""){
									$select.=" and `class_name` LIKE '%".$name."%'";
								}
								if($account!=""){
									$select.=" and a.`account_id` LIKE '%".$account."%'";
								}     
								$select.="order by `semester` asc,`stu_grade` asc"; 
								$ret=mysqli_query($link,$select);
								$num=mysqli_num_rows($ret);
								if($num=='0'){
									echo "<font style='color:red; Font-size:48px;font-family:微軟正黑體 Light;text-shadow: rgb(136, 136, 136) 2px 2px 2px;'>目前查無此紀錄!</font>";
								}else{
									echo"
									
									<table align='center' border='2'>";
								
									echo "
									<tr>
											<th>學期</th>	
											<th>科系</th>
											<th>年級</th>
											<th>班級名稱</th>
											<th>學號</th>
											<th>姓名</th>
											<th>事由</th>
											<th>操作</th>
									</tr>";
								
									While($row=mysqli_fetch_assoc($ret)){
										echo"<tr>
											<td>$row[semester]</td>
											<td>$row[stu_dep]</td>
											<td>$row[stu_grade]</td>
											<td>$row[class_name]</td>
											<td>$row[account_id]</td>
											<td>$row[stu_name]</td>
											<td>$row[content]</td>
											<td><input type='button' value='詳細資料' class='blue' onclick='statistics_recondtable($row[sh_id]);'></td>";
										echo"</tr>";
									};
								
									echo"</table></br>";
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