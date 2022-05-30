<!DOCTYPE html>
<?php 
	session_start(); 
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
		<link href="css/M-Option.css" rel="stylesheet" type="text/css" media="all" />

		<style>
			.w3-sidebar {width: 140px;background: #222;height: 100%;}
			table{
				font-size:28px;font-family:serif;
			}
			fieldset {
				border:0;
				padding:10px;
				margin-bottom:10px;
				background:#EEE;
			}
			legend {
				padding:3px 10px;
				background-color:#4F709F;
				color:#FFF;
			}
			
			.btn-primary{color:#fff;background-color:#337ab7;border-color:#2e6da4}
			.btn-primary.focus,.btn-primary:focus{color:#fff;background-color:#286090;border-color:#122b40}
			.btn-primary:hover{color:#fff;background-color:#286090;border-color:#204d74}

		</style>
		<script src="js/jquery-3.1.1.min.js"></script>
		<script>
			function aa(pag){
				if(typeof(pag)=='undefined')pag=1;
				var year=document.getElementById("year1").value;
				var dep=document.getElementById("dep").value;
				var grade=document.getElementById("grade").value;
				var name=document.getElementById("name").value;
				var account=document.getElementById("account").value;
				var status=document.getElementById("status").value;
				var t="statistics_2.php?year="+year+"&dep="+dep+"&grade="+grade+"&name="+name+"&account="+account+"&status="+status+"&page="+pag;
				$.ajax({
					type:'GET',
					url:t,
					success: function(result){
						$("#div1").html(result);
					},
				});
			}
			aa();
	</script>
	</head>
	
	<body onload="aa();" style="background-image:url(images/blue.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
	<?php include('./menu.php'); ?>
	<div class="div2">
		
		<div class="main">
			<center>
				</br>
				<!--<h2 style='color:#4B0091;'>查看各科系年級愛校紀錄</h2>-->
				<table style="align:center;border:0;width:80%;">
					<form>
						<tr style='font-size:16px;'>
							
							<td>
							學期：
								<select name="year1" id="year1"  align="center">
									<?php
									$select=mysqli_query($link,"SELECT DISTINCT `semester` FROM `master_list` order by `semester` DESC");
									while($row=mysqli_fetch_assoc($select)){ 
									?>
									<option>
									<?php echo $row['semester'];}?>
									</option>
								</select>
							</td>
							<td>
							科系:
								<select name="dep" id="dep"  align="center">
									<option value="">請選擇</option>
									<?php
									$select=mysqli_query($link,"SELECT DISTINCT `stu_dep` FROM `student_information`");
									while($row=mysqli_fetch_assoc($select)){ 
									?>
									<option>
									<?php echo $row['stu_dep'];}?>
									</option>
								</select>
							</td>
							<td>
								年級：
								<select name="grade" id="grade"  align="center">
									<option value="">請選擇</option>
									<?php
									$select=mysqli_query($link,"SELECT DISTINCT `stu_grade` FROM `student_information` order by `stu_grade` ASC");
									while($row=mysqli_fetch_assoc($select)){ 
									?>
									<option>
									<?php echo $row['stu_grade'];}?>
									</option>
								</select>
							</td>
							<td>
								班級名稱：
								<select name="name" id="name"  align="center">
									<option value="">請選擇</option>
									<?php
									$select=mysqli_query($link,"SELECT DISTINCT `class_name` FROM `student_information`");
									while($row=mysqli_fetch_assoc($select)){ 
									?>
									
									<option>
									<?php echo $row['class_name'];}?>
									</option>
								</select>
							</td>
							<td>
								學號：<input type="text" id="account" name="account" style="height:30px;width:150px">
							</td>
							<td>
								狀態：
								<select name="status" id="status"  align="center">
									<option value="">請選擇</option>
									<option value="3">超過期限</option>
									<option value="2">未完成</option>
									<option value="1">已完成</option>
								</select>
							</td>
							<td>
								<a href="javascript: aa();" onclick="aa()">
									<input type="button" class="blue" value="查詢">
								</a>
							</td>
						</tr>
					</form>
					
				</table>
				</br>
				<div id="div1"></div>
			</center>
		</div>
	</div>
	</body>
</html>
