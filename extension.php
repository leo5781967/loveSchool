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
		<link href="css/font-awesome_index.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/button.css" rel="stylesheet" type="text/css" media="all" />
		
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
		<script src="js/jquery-3.1.1.min.js"></script>
		<script>
		function go_back(){
			/*$.ajax({
			 url: 'apply_step1.php',
			 success: function(result){
			  $("#main").html(result);
			 }
			});*/
			location.href = "apply_step1.php";
		}
		function upd(id){
		$.ajax({
			type:'POST',
			url: 'extension_upd.php',
			data: {
				id:id
			},
			success: function(result){
				$("#ext_upd").html(result);
				document.getElementById("bg").style.display = 'block';
				document.getElementById("ext_upd").style.display = 'block';
			}
		});
		}
		function del(id){
			var statu = confirm("刪除是不可恢復的，你確認要刪除嗎？");
			if(!statu){
				return false; 
			} 
			$.ajax({
			type:'POST',
			url: 'extension_del.php',
			data: {
				id:id
			},
			success: function(result){
				$("#ext_upd").html(result);
				
			}
		});
		}
		function hide_extension(){
			document.getElementById("bg").style.display = 'none';
			document.getElementById("ext_upd").style.display = 'none';
		}
		function se(pag){
			if(typeof(pag)=='undefined')pag=1;
			var account=document.getElementById("account").value;
			var teaId1=document.getElementById("teaId1").value;
			var t="stu_Record.php?account="+account+"&page="+pag+"&teaId1"+teaId1;
			if(account==""){
				alert("請輸入學號");
			}else{
				$.ajax({
					type:'GET',
					url: t,
				
					success: function(result){
						$("#div2").html(result);
					},
				});
			}
			
		}
		function se2(){
			history.go(0);
		}
		
		</script>
	</head>

	<body class="w3-black" style="background-image:url(images/black.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
		
		<div id="bg" class='bg' onclick='hide_extension();'></div>
		<div id="ext_upd" style="display: none;" class='show'></div>
		<?php include('./sidebar.php');
				
		?>
		<!-- Page Content -->
		<div class="w3-padding-large" id="main">
			<!-- Contact Section -->
			<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
				<table style="align:center;width:67%;">
					<form>
						<tr style='font-size:16px;'>
						<td>
							查詢學生紀錄
						</td>
						<td>
							學號：<input type="text" id="account" name="account" style="height:30px;width:150px" placeholder='請輸入學號'>
							<?php
							$tt=$_SESSION['user_acc'];
							echo "<input type='hidden' id='teaId1' name='teaId1' value=$tt>";
							?>
						</td>
						<td>
							<a href="javascript: se();" >
								<input class="blue" type="button" value="查詢">
							</a>
						</td>
						<td>
							<a href="javascript: se2();" >
								<input class="blue" type="button" value="查看未完成紀錄">
							</a>
						</td>
						</tr>
					</form>
					
				</table>
				
				<div id="page-wrapper">
					<!-- Banner -->
					<section id="banner">
					
						<div id="div2">
							<?php
							include 'db.php';

							$api='http://ec.knjc.edu.tw/knjcapi/TrtoStdList?trad='.$tt;
							$ret=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `student_information` as d on b.`account_id`=d.`account_id` where b.`teacher_id` = '$tt' ORDER BY a.`res_status` desc,`end_day` ASC,b.`account_id` ASC");
							$num=mysqli_num_rows($ret);
							if($num=='0'){ ?>	
								<div>
									<font style="color:#fff;">
										<h1>目前沒有您所登記的未完成愛校紀錄&nbsp;&nbsp;
										<a><input type="button" class="blue" value="返回" onclick="go_back();"></a>
										</h1>
										
									</font>
								</div>
							<?php 
							}
							else
							{ ?>
								
								<?php include('./stu_Record1.php'); ?>
								
							<?php 
							} ?>
						</div>
					</section>
				</div>
				
				
			</div>
		</div>
	</body>
</html>