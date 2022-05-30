<!DOCTYPE html>
<?php
	error_reporting(0);//隱藏mysql版本問題
	header('Content-type: text/html; charset=utf-8');
	session_start();
	if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}

?>
<html>
	<head>
		<title>愛校服務系統</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="css/table.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link href="css/font-awesome_index.css" rel="stylesheet" type="text/css" media="all" />
		<style>
			.w3-sidebar {width: 140px;background: #222;height: 100%;}
			table{
				font-size:28px;font-family:serif;
			}
		</style>
		<script>
			function sel_chg(){
				var xx=document.getElementById("xx");
				var content=document.getElementById("content").value;
				if(content=='其他'){
					xx.style.display="block";
					xx.innerHTML="<input type='text' id='other' placeholder='請輸入事由'/>";
				}else{
					xx.style.display="none";
				}
			}
			function go_step1(){
				/*$.ajax({
					url: 'apply_step1.php',
					type: 'post',
					success: function(result){
						alert('查無此學生！');
						$("#main").html(result);
					}
				});*/
				alert('查無此學生！');
				location.href = "apply_step1.php";
			}
			function go_step3(){
				var content=document.getElementById("content").value;
				
				var total_hr=document.getElementById("total_hr").value;
				if(total_hr=="" || total_hr=="0"){
					alert("請填入時數");
				}else{
					if(content == "其他"){
						
						var other=document.getElementById("other").value;
						content = other;
					}
					$.ajax({
						url: 'apply_step3.php',
						type: 'post',
						data:{
							content:content,
							total_hr:total_hr
						},
						success: function(result){
							$("#main").html(result);
						}
					});
				}
				
			}
			function go_back(){
				$.ajax({
					url: 'apply_step1.php',
					success: function(result){
						$("#main").html(result);
					}
				});
			}
			
		</script>
	</head>
	<?php
	//==============================判斷學生ID==============================================
	$api='http://ec.ukn.edu.tw/knjcapi/stdsimple?idno='.$_POST["number"];
	@$data = simplexml_load_file($api) or die("<script>go_step1();</script>");
	$stu_name=(string)$data->stdSimple->chiname; //姓名
	$stu_dep=(string)$data->stdSimple->depname; //科系
	$stu_grade=(string)$data->stdSimple->Degree;   //年級
	$stu_class=(string)$data->stdSimple->tclass;   //班級
	
	
	$api2='http://ec.knjc.edu.tw/knjcapi/stdtotr?stdno='.$_POST["number"];
	@$data2 = simplexml_load_file($api2) or die("<script>go_step1();</script>");
	$tch_id=(string)$data2->StdToTr->TeacherId; //姓名
	$tch_name=(string)$data2->StdToTr->TeacherName; //姓名
	//======================================================================================
	?>
	<body class="w3-black">
		<!-- Page Content -->
		<div class="w3-padding-large" id="main">
		  <!-- Contact Section -->
		  <div class="w3-padding-64 w3-content w3-text-grey" id="contact">
			<h2 class="w3-text-light-grey">愛校登記</h2>
			<hr style="width:200px" class="w3-opacity">
			
			<?php

				$date=date("Y-m-d");
				echo "<table border='1px' width='100%' style=''>";
					echo "<tr>";
						echo "<th colspan='2' style='background-color: rgba(124, 123, 150, 0.8);'>填報單位</th>";
						echo "<td colspan='2'>$_SESSION[sps_dep]</td>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>填報人</th>";
						echo "<td>$_SESSION[sps_name]</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>學號</th>";
						echo "<td>$_POST[number]</td>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>科系</th>";
						echo "<td>$stu_dep</td>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>填表日期</th>";
						echo "<td>$date</td>";
					echo "</tr>";	
					echo "<tr>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>姓名</th>";
						echo "<td>$stu_name</td>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>班級</th>";
						echo "<td>$stu_grade$stu_class</td>";
						echo "<th style='background-color: rgba(124, 123, 150, 0.8);'>導師</th>";
						echo "<td>$tch_name</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<th align='center' colspan='2' style='background-color: rgba(124, 123, 150, 0.8);'>愛校事由</th>";
						echo "<td colspan='5' align='left'>";
							echo "<select id='content' onchange='sel_chg();' style='width:50%;'>";
								echo "<option value='曠課輔導'>曠課輔導</option>";
								echo "<option value='留校察看'>留校察看</option>";
								echo "<option value='改過銷過'>改過銷過</option>";
								echo "<option value='服儀違規'>服儀違規</option>";
								echo "<option value='愛宿'>愛宿(宿舍)</option>";
								echo "<option value='其他'>其他</option>";
							echo "</select>";
							echo "<span id='xx' style='display:none;'></span>";
						echo "</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<th align='center' colspan='2' style='background-color: rgba(124, 123, 150, 0.8);'>愛校時數</th>";
						echo "<td colspan='5' align='left'>";
							echo "<input type='number' id='total_hr' style='width:50%;' min='1' value='1'/>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
				//-----------------
				echo "<br/><br/>";
				echo "<div style='border:0px black solid;width:100%;text-align:center'>";
					?><input type="button" class="button" onclick="location.href='apply_step1.php';" value="返回">&emsp;&emsp;<?php
					echo "&nbsp&nbsp&nbsp";
					echo "<input class='button' type='button' onclick=\"go_step3();\" value='下一步'>";
				echo "</div>";
				
				$array = [
					"stu_number" => $_POST["number"],
					"stu_dep" => $stu_dep,
					"stu_grade" => $stu_grade,
					"stu_class" => $stu_class,
					"stu_name" => $stu_name,
					"tch_id" => $tch_id,
					"tch_name" => $tch_name,
					"sps_dep" => $_SESSION["sps_dep"],
					"sps_name" => $_SESSION["sps_name"],
					"write_day" => $date,
					"end_day" => "",
					"content" => $_SESSION["sps_content"],
					"total_hr" => 0,
					"semester" => ""
				];
				$_SESSION["master_list"]=$array;
			?>
		  </div>
		</div>
	</body>
</html>
