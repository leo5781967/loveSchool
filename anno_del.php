<!--<?php 
	/*header('Content-type: text/html; charset=utf-8');
	session_start();
	include('db.php');
	if(!isset($_SESSION['user_acc'])){
		echo "<center>請登入系統</center>";
		echo "<center><a href='index.php'>登入系統</a></center>";
		die();
	}*/
?>
<html>
	<head>
		<title>公告(右)</title>
		<script>
			
			function go_del(id){
				var statu = confirm("刪除是不可恢復的，你確認要刪除嗎？"); 
				if(!statu){
					return false; 
				} 
				$.ajax({
					type:'POST',
					url: 'anno_del1.php',
					data: {
						id:id
					},
					success: function(result){
						hide();
						look_right();
					}
				})
			}
			function look_right(){
				$.ajax({url: "anno_right.php", 
					success: function(result){$("#right").html(result);},
				});
			}
			function hide(){
				document.getElementById("bgccc").style.display = 'none';
				document.getElementById("show_del").style.display = 'none';
			}
		</script>
		<style>
			th{ background-color:#6c85b5;font-size: large;border: 1px solid #504d9a;}
			//.headerrow td{ color:#000000; text-align:center;font-family: "微軟正黑體";}
			
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
		</style>
	</head>
	<body>
		<h2  style="color:#3a3f7b;">所有公告</h2>
		<table align='center' border='2'  class="fancytable">
			<?php
				//@$sel=mysqli_query($link,"select * from `announment` where `ano_id`=$_POST[id]");
				//$sel2=mysqli_fetch_assoc($sel);
				/*echo "
					<tr>
						<th>起始日期</th>
						<td>$sel2[date_start]</td>
						<th>終止日期</th>
						<td>$sel2[date_end]</td>
					</tr>
					<tr>
						<th>標題</th>
						<td colspan='3'>$sel2[ano_title]</td>
					</tr>
					<tr>
						<th>所需時間</th>
						<td colspan='3'>$sel2[office_time_hr]</td>
					</tr>
					<tr>
						<th>人數需求</th>
						<td>$sel2[need_people]</td>
						<th>剩餘名額</th>
						<td>$sel2[remain_people]</td>
					</tr>
					<tr>
						<th>內文</th>
						<td colspan='3'>$sel2[ano_content]</td>
					</tr>
					<tr>
						<td colspan='4'>
						<input type='button' id='del' name='del' class='red' value='刪除' onclick='go_del(\"$sel2[ano_id]\")'>
						&nbsp&nbsp
						<input type='button' id='bgccc' class='blue' value='關閉' onclick='hide();'>
						</td>
					</tr>
				";*/
			?>
		</table>
		<div id="bgccc" class='bg' onclick='hide();'></div>
		<div id="show_del" style="display: none;" class='show'></div>	
	</body>
</html>
--!>