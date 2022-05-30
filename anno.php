<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start();
	include('db.php');
	if(!isset($_SESSION['user_acc'])){
		echo "<center>請登入系統</center>";
		echo "<center><a href='index.php'>登入系統</a></center>";
		die();
	}
	$today=date("Y-m-d");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>愛校管理系統</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link href="css/font-awesome_index.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/button.css" rel="stylesheet" type="text/css" media="all" />
		
		<script src="js/jquery-3.1.1.min.js"></script>
		<script>
			look_right();
			function look_right(){
				$.ajax({url: "anno_right.php", 
					success: function(result){$("#right").html(result);},
				});
			}
			function ins_up(){
				var sd=document.getElementById('date1').value;
				var ed=document.getElementById('date2').value;
				var t_title=document.getElementById('t_title').value;
				var t_content=document.getElementById('t_content').value;
				var time_hr=document.getElementById('time_hr').value;
				var people=document.getElementById('people').value;
				
				//判斷日期用
				var ssd= new Date(sd);
				var eed= new Date(ed);
				
				if(sd==""){
					alert("請輸入起始日期");
					return false;
				}else if(ed==""){
					alert("請輸入終止日期");
					return false;
				}else if(eed<ssd){
					alert("終止日期不能小於起始日期");
					return false;
				}else if(t_content==""){
					alert("請輸入公告內容");
					return false;
				}else{
					$.ajax({
						type:'POST',
						url: 'anno_ins.php',
						data: {
							start_date:sd,
							end_date:ed,
							title:t_title,
							context:t_content,
							time_hr:time_hr,
							people:people
						},
						success: function(result){
							look_right();
							//$("#hide_go").html(result);
						}
					});
				}
			}
		</script>
		<style>
			.annotable{border:2px;border-collapse: collapse;color:#fff;}
			
			.annotable td{
				border:2px solid #504d9a;
				color:#fff;
				text-align:center;
				line-height:28px;
				/*font-weight:bold;*/
				font-size:20px;
			}
			.headerrow{ font-size: large;border: 1px solid #504d9a;}
			.headerrow td{ color:#000000; text-align:center;font-family: "微軟正黑體";}
			.datarowodd td{background-color:#FFFFFF;}
			.dataroweven td{ background-color:#efefef;}
			.datarowodd td{background-color:#ffffff;font-family: "微軟正黑體";}
			.dataroweven td{ background-color:#efefef;font-family: "微軟正黑體";}
				
			.bg{
				display: none; 
				position: absolute;
				top: 0%;
				left: 0%;
				width: 200%;
				height: 100%;
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
				left: 25%;  
				width: 50%;  
				height: 50%;  
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
			.btn{
				cursor: pointer;
			}
			
			.w3-sidebar {width: 140px;background: #222;height: 100%;}
			
			.qq{
				border:0;
			}
		</style>
	</head>
	<body class="w3-black" style="background-image:url(images/black.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
	<?php include('./sidebar.php'); ?>
		<center>
			
			<div id='main' style="margin-left:120px"> 
				<br><h1>公告管理</h1>
				<table align='center' border='0' width="100%" >
					
					<tr>
						<td width="50%" align="center"  class="qq">
							<div id='left'>
								<h2>新增公告</h2>
								<form>
									<table align='center' border='2'  class="annotable">
										<tr>
											<td>單位</td>
											<td><?php echo $_SESSION["sps_dep"]; ?></td>
											<td>公告人</td>
											<td><?php echo $_SESSION["sps_name"]; ?></td>
										</tr>
										<tr> 
											<td>起始日期</td>
											<td><input id="date1" style="width: 100%;" name="date1" type="date" /></td>
											<td>終止日期</td>
											<td><input id="date2" style="width: 100%;" name="date2" type="date" /></td>
										</tr>
										<tr>
											<td>標題</td>
											<td colspan="3"><input type="text" id="t_title" name="t_title" style="margin: 0px; width: 100%;font-family: Microsoft JhengHei;"></td>
										</tr>
										<tr>
											<td>單位所需時間</td>
											<td>
												<input type="number" style="width:200px" name="time_hr" id="time_hr" min="1">
											</td>
											<td>單位所需人數</td>
											<td>
												<input type="number" style="width:200px" name="people" id="people" min="1" value="1">
											</td>
										</tr>
										<tr>
											<td>內文</td>
											<td colspan="3"><textarea id="t_content" name="t_content" style="margin: 0px; width: 100%; height: 150px; font-family: Microsoft JhengHei;"></textarea></td>
										</tr>
									</table><br>
									<input type="button" value="送出" onclick='ins_up();' class="green"/>
									&nbsp&nbsp;
									<input type="reset" value="重設" class="orange"/>
								</form>
							</div>
						</td>
						<td width="50%" align="center" valign="top"  class="qq">
							<div id="right"></div>
						</td>
					</tr>
				</table>
				<div id="hide_go" style="display:block;"></div>
			</div>
		</center>
	</body>
</html>
