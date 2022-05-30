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
		<meta charset="UTF-8">
		<link href="css/button.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/apply.css" rel="stylesheet" type="text/css" media="all" />
	</head>
	<style>
		/*==============================test===================*/
			/*第一欄第一列：左上*/
			tr:first-child td:first-child{
				border-top-left-radius: 0px;
			}
			/*第一欄最後列：左下*/
			tr:last-child td:first-child{
				border-bottom-left-radius: 0px;
			}
			/*最後欄第一列：右上*/
			tr:first-child td:last-child{
				border-top-right-radius: 0px;
			}
			/*最後欄第一列：右下*/
			tr:last-child td:last-child{
				border-bottom-right-radius: 0px;
			}
		/*==============================test===================*/		
	</style>
	<script>
		/*function go_upd(id){
			if(id!=""){
				$.ajax({url: "setting_upd.php?id="+id, 
					success: function(result){$("#set_upd").html(result);
					document.getElementById("bg").style.display = 'block';
					document.getElementById("set_upd").style.display = 'block';},
				});
			}
		}*/
		function go_sel(id){
			$.ajax({
				type:'POST',
				url: 'anno_sel.php',
				data: {
					id:id
				},
				success: function(result){
					$("#show_sel").html(result);
					document.getElementById("bgc").style.display = 'block';
					document.getElementById("show_sel").style.display = 'block';
				}
			});
		}
		function go_upd(id){
			
			$.ajax({
				type:'POST',
				url: 'setting_upd.php',
				data: {
					id:id
				},
				success: function(result){
					$("#set_upd").html(result);
					document.getElementById("bgcc").style.display = 'block';
					document.getElementById("set_upd").style.display = 'block';
				}
			});
		}
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
					look_right();
				}
			})
		}
		
		function hide(){
			document.getElementById("bgc").style.display = 'none';
			document.getElementById("show_sel").style.display = 'none';
			document.getElementById("bgcc").style.display = 'none';
			document.getElementById("set_upd").style.display = 'none';
			document.getElementById("bgccc").style.display = 'none';
			document.getElementById("show_del").style.display = 'none';
		}
		function look_right(){
			$.ajax({url: "anno_right.php", 
				success: function(result){$("#right").html(result);},
			});
		}
	</script>

	<body>
		<h2><?php echo $_SESSION["sps_dep"];?>公告</h2>
		<table align='center' border='2'  class="fancytable">

			<?php
				$sel=mysqli_query($link,"select * from `announment` as a ,`units` as b where a.`unit_id`=b.`unit_id` and b.`unit_name`='$_SESSION[sps_dep]'");
				$n=1;
				$s=0;
				$number=mysqli_num_rows($sel);
				if($number!=0){
					echo "<tr class='headerrow' height='40px'>
						<th>編號</th>
						<th>起始日期</th>
						<th>終止日期</th>
						<th>公告標題</th>
						<th>操作</th>
					</tr>";
					while($sel2=mysqli_fetch_assoc($sel)){			
						$s++;
						if($s%2==0){
							echo "
								<tr class='datarowodd'>	
									<td>$n</td>
									<td>$sel2[date_start]</td>
									<td>$sel2[date_end]</td>
									<td>$sel2[ano_title]</td>
									<td>
										<input type='button' id='del' name='del' class='blue' value='查看' onclick='go_sel(\"$sel2[ano_id]\")'>&nbsp&nbsp
										<input type='button' id='del' name='del' class='orange' value='修改' onclick='go_upd(\"$sel2[ano_id]\")'>&nbsp&nbsp
										<input type='button' id='del' name='del' class='red' value='刪除' onclick='go_del(\"$sel2[ano_id]\")'>
									</td>
								</tr>
							";
						}else{
							echo "
								<tr class='dataroweven'>	
									<td>$n</td>
									<td>$sel2[date_start]</td>
									<td>$sel2[date_end]</td>
									<td>$sel2[ano_title]</td>
									<td>
										<input type='button' id='del' name='del' class='blue' value='查看' onclick='go_sel(\"$sel2[ano_id]\")'>&nbsp&nbsp
										<input type='button' id='del' name='del' class='orange' value='修改' onclick='go_upd(\"$sel2[ano_id]\")'>&nbsp&nbsp
										<input type='button' id='del' name='del' class='red' value='刪除' onclick='go_del(\"$sel2[ano_id]\")'>
									</td>
								</tr>
							";
						}
						$n++;
					}
				}else{
					echo "<font style='color:#fff;'>
						<br><br><br>
						<h1>目前沒有公告紀錄~~~&nbsp;&nbsp;</h1>
					</font>";
				}

			?>
		</table>
		<div id="bgc" class='bg' onclick='hide();'></div>
		<div id="show_sel" style="display: none;" class='show'></div>	
		<div id="bgcc" class='bg' onclick='hide();'></div>
		<div id="set_upd" style="display: none;" class='show'></div>
		<div id="bgccc" class='bg' onclick='hide();'></div>
		<div id="show_del" style="display: none;" class='show'></div>	
	</body>
</html>