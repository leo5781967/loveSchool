<!DOCTYPE html>
<?php 
	session_start(); 
	include "db.php";
	if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
	
	$c_manager_sql=mysqli_query($link,"SELECT * FROM `teacher_information` as a inner join `status` as b on a.`teacher_id`=b.`teacher_id` inner join `units` as c on b.`unit_id`=c.`unit_id` where `unit_name`='$_SESSION[sps_dep]' and b.`Authority`='1'");
	$c_manager=mysqli_fetch_array($c_manager_sql);
	if($c_manager["teacher_id"]==$_SESSION["user_acc"]){
		
	}else{
		echo "<script>alert('非主任權限，無法進入管理頁面!!');location.href='apply.php'</script>";
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
		<link href="css/button.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/select.css" rel="stylesheet" type="text/css" media="all" />
		
	<style>
		.w3-sidebar {width: 140px;background: #222;height: 100%;}
		table{
			font-size:28px;font-family:serif;
		}
		.w3-padding-64 {
			padding-top: 34px!important;
			padding-bottom: 64px!important;
		}
	</style>
	<script src="js/jquery-3.1.1.min.js"></script>
	<script>
		function look_manager(){
			location.href = "teachselect.php";
		}
		function go_upd(a){
			var manager_ch = confirm("確認修改?"); 
			if(!manager_ch){
				return false; 
			} 
			var upd_id=document.getElementById("teacher_id"+a).value;
			var unit_id=document.getElementById("unit_id"+a).value;
			$.ajax({
				type:'POST',
				url: 'upd_manager.php',
				data: {
					id:upd_id,
					ut:unit_id
				},
				success: function(result){
					look_manager();
				}
			});
		}
		function page(){
			var p=document.getElementById("page").value;
			aa(p);
		}
	</script>
	
</head>

<body class="w3-black" style="background-image:url(images/black.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">

<?php //include('./sidebar.php'); ?>
	<div class="w3-padding-large" id="main">
		<!-- Contact Section -->
		<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
			<div id="page-wrapper">
		<!-- Banner -->
				<section id="banner">
					
					<input class="blue" type="button" name="assimilation" id="assimilation" value="<?php echo $_SESSION["sps_dep"]; ?>資料同步" onclick="location.href='assimilation.php'">
					<?php
					?>
					<header>
						<font style='color:#fff;font-size:36px'>
							<?php echo $_SESSION["sps_dep"]; ?> 人員
						</font>
						
						</br>
						</br>
					</header>
						
					<?php
						$currect=0;
						
						if(isset($_GET["account"])){
							$manager_sql1="SELECT * FROM `teacher_information` as a inner join `status` as b on a.`teacher_id`=b.`teacher_id` inner join `units` as c on b.`unit_id`=c.`unit_id` where `unit_name`='$_SESSION[sps_dep]' and a.`teacher_name` like '%$_GET[account]%' order by `Authority` desc";
						}else{
							$manager_sql1="SELECT * FROM `teacher_information` as a inner join `status` as b on a.`teacher_id`=b.`teacher_id` inner join `units` as c on b.`unit_id`=c.`unit_id` where `unit_name`='$_SESSION[sps_dep]' order by `Authority` desc";
						
						}
						
						$manager_sql2=mysqli_query($link,$manager_sql1);
						
						$data_nums = mysqli_num_rows($manager_sql2); //統計總比數
						$per = 10; //每頁顯示項目數量
						$pages = ceil($data_nums/$per); //取得不小於值的下一個整數
						if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
							$page=1; //則在此設定起始頁數
						} else {
							$page = intval($_GET["page"]); //確認頁數只能夠是數值資料
						}
	
						$start = ($page-1)*$per; //每一頁開始的資料序號
						
						$manager_sql2 = mysqli_query($link,$manager_sql1.' LIMIT '.$start.', '.$per) or die("Error");
						
						echo "<table align='center' border='2'>";
						echo "
							<tr>
								<td align='center'>編號</td>
								<td align='center'>教職員姓名</td>
								<td align='center'>權限</td>
								<td align='center'>操作</td>
							</tr>
						";
						$n=0;
						While($manager=mysqli_fetch_array($manager_sql2)){
							$n++;
							echo "
								<tr>
									<td>
										$n
										<input type='hidden' name='teacher_id' id='teacher_id$n' value='$manager[teacher_id]'>
										<input type='hidden' name='unit_id' id='unit_id$n' value='$manager[unit_id]'>
									</td>
									<td>$manager[teacher_name]</td>
									<td>
							";
									
							if($manager["Authority"]==0){
								echo "非審核人員";
							}elseif($manager["Authority"]==1){
								echo "主任";
							}elseif($manager["Authority"]==2){
								echo "審核人員";
							}
								
							echo "
								</td>
								<td>
							";
							
							if($manager["Authority"]==0){
								echo "
									<input type='button' name='upd_mana' id='upd_mana' class='orange' value='修改為審核人' onclick='go_upd($n);'>
								";
							}else if($manager["Authority"]==2){
								echo "
									<input type='button' name='upd_mana' id='upd_mana' class='orange' value='修改為一般教職員' onclick='go_upd($n);'>
								";
							}else{
								echo "權限為主任無法修改";
							}
								echo "
								</td>
								";
						}
						echo "</tr>";
						echo "</table>";
						
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
					?>
							
				</section>

</body>
</html>