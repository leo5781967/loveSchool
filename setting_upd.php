<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start();
	include('db.php');
	if(!isset($_SESSION['user_acc'])){
		echo "<center>請登入系統</center>";
		echo "<center><a href='index.php'>登入系統</a></center>";
		die();
	}
?>
<html>
	<head>
		<title>公告(右)</title>
		<script>
			//look_right();
			/*function go_upd(id){
				if(id!=""){
					$.ajax({url: "setting_upd.php?id="+id, 
						success: function(result){$("#set_upd").html(result);
						document.getElementById("bg").style.display = 'block';
						document.getElementById("set_upd").style.display = 'block';},
					});
				}
			}
			function go_sel(id){
				$.ajax({
					type:'POST',
					url: 'anno_sel.php',
					data: {
						id:id
					},
					success: function(result){
						$("#show_sel").html(result);
					}
				});
			}*/
			
			function go_upd_2(){
				var id=document.getElementById('anno_id').value;
				var sd=document.getElementById('date3').value;
				var ed=document.getElementById('date4').value;
				var t_title=document.getElementById('t_title_2').value;
				var time_hr=document.getElementById('time_hr_2').value;
				var people=document.getElementById('people_2').value;
				var pl=document.getElementById('people_last_2').value;
				var t_content=document.getElementById('t_content_2').value;
				if(sd==""){
					alert("請輸入起始日期");
					return false;
				}else if(ed==""){
					alert("請輸入終止日期");
					return false;
				}else if(t_title==""){
					alert("請輸入標題");
					return false;
				}else if(time_hr==""){
					alert("請輸入所需時間");
					return false;
				}else if(people==""){
					alert("請輸入所需人數");
					return false;
				}else if(pl==""){
					alert("請輸入剩餘人數");
					return false;
				}else if(t_content==""){
					alert("請輸入內文");
					return false;
				}else if(sd > ed){
					alert("起始日期不能大於終止日期");
					return false;
				}else{
					$.ajax({
						type:'POST',
						url: 'setting_upd_2.php',
						data:{
							id:id,
							start_date:sd,
							end_date:ed,
							title:t_title,
							content:t_content,
							time_hr:time_hr,
							people:people,
							people_last:pl
						},
						success: function(result){
							hide();
							look_right();
							//$("#hide_go").html(result);
						}
					})
				}
			}
			function look_right(){
				$.ajax({url: "anno_right.php", 
					success: function(result){$("#right").html(result);},
				});
			}
			function hide(){
				document.getElementById("bgcc").style.display = 'none';
				document.getElementById("set_upd").style.display = 'none';
			}
		</script>
		<style>
			th{ background-color:#6c85b5;font-size: large;border: 1px solid #504d9a;}
			.headerrow td{ color:#000000; text-align:center;font-family: "微軟正黑體";}
			.show{
				display: none;  
				position: absolute;  
				top: 5%;  
				left: 25%;  
				width: 50%;  
				height: 90%;  
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
		</style>
	</head>
	<body>
		
		<h2  style="color:#3a3f7b;">所有公告</h2>
		<table align='center' border='2'  class="fancytable">
			<?php
				@$sel=mysqli_query($link,"select * from `announment` where `ano_id`=$_POST[id]");
				$sel2=mysqli_fetch_assoc($sel);
				echo "
					<tr>
						<input type='hidden' id='anno_id' name='anno_id' value='$_POST[id]'>
						<th>起始日期</th>
						<td><input id='date3' style='width: 100%;' name='date3' type='date' value='$sel2[date_start]' max='ed();'></td>
						<th>終止日期</th>
						<td><input id='date4' style='width: 100%;' name='date4' type='date' value='$sel2[date_end]' ></td>
					</tr>
					<tr>
						<th>標題</th>
						<td colspan='3'><input type='text' id='t_title_2' name='t_title_2' style='margin: 0px; width: 100%;font-family: Microsoft JhengHei;' value='$sel2[ano_title]'></td>
					</tr>
					<tr>
						<th>所需時間</th>
						<td><input type='number' style='width:100%' name='time_hr_2' id='time_hr_2' min='1' value='$sel2[office_time_hr]'></td>
						<th>所需人數</th>
						<td><input type='number' style='width:100%' name='people_2' id='people_2' min='1' value='$sel2[need_people]'></td>
					</tr>
					<tr>
						<th>剩餘名額</th>
						<td colspan='3'><input type='number' style='width:100%' name='people_last_2' id='people_last_2' min='1' value='$sel2[remain_people]'></td>
					</tr>
					<tr>
						<th>內文</th>
						<td colspan='3'><textarea id='t_content_2' name='t_content_2' style='margin: 0px; width: 100%; height: 150px; font-family: Microsoft JhengHei;'>$sel2[ano_content]</textarea></td>
					</tr>
					<tr>
						<td colspan='4'>
							<input type='button' id='bgcc' class='green' value='確定' onclick='go_upd_2()'>
							&nbsp&nbsp
							<input type='button' id='bgcc' class='red' value='關閉' onclick='hide();'>
							<!--&nbsp&nbsp
							<input type='button' id='del' name='del' value='刪除' onclick='go_del(\"$sel2[ano_id]\")'>-->
						</td>
					</tr>
				";
			?>
		</table>
		<div id="bgcc" class='bg' onclick='hide();'></div>
		<div id="set_upd" style="display: none;" class='show'></div>
	</body>
</html>
