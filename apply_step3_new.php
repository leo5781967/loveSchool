<!DOCTYPE html>
<?php
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
			#user_div {
				display: block;
				position: absolute;
				top: 10%;
				left: 87%;
				width: 190px;
				height: 150px;
				padding: 8px;
				box-shadow: 5px 5px 5px #888888;
				position: fixed;
				background-color: yellow;
				/* background-image: url(../images/note.png); */
				z-index: 1002;
				overflow: auto;
			}
			#user_div2 {
				display: block;
				position: absolute;
				top: 10%;
				left: 50%;
				width: 290px;
				height: 150px;
				padding: 8px;
				box-shadow: 5px 5px 5px #888888;
				position: fixed;
				background-color: yellow;
				/* background-image: url(../images/note.png); */
				z-index: 1002;
				overflow: auto;
			}
			.select {
				position: relative;
				background: #FFFFFF;
				overflow: hidden;
				border-radius: .25em;
			}
			select {
				font-family: Microsoft YaHei;
				font-size: 20px;
				width: 100%;
				height: 30px;
				margin: 0;
				padding: 0 0 0 .5em;
				color: #000;
				cursor: pointer;
				-webkit-appearance: none;
				outline: 0;
				border: 0 !important;
				background: #FFFFFF;
			}
			.word{
				font: 22px "微软雅黑", Arial, Helvetica, sans-serif;
				color: #FFFFFF;
			}
			.button1 {
				width: 300px;
				height: 52px;
				/*background-color: transparent;*/
				background-color: rgba(124, 123, 150, 0.8);
				border-radius: 4px;
				border: 0;
				box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.3);
				color: #ffffff !important;
				cursor: pointer;
				display: inline-block;
				font-weight: 300;
				height: 3em;
				line-height: 3em;
				padding: 0 2.25em;
				text-align: center;
				text-decoration: none;
				white-space: nowrap;
				/*font-size:18px;*/
				position: fixed;
				font: 19px "微软雅黑", Arial, Helvetica, sans-serif;
			}
			.button1:hover {
				width: 300px;
				height: 52px;
				/*background-color: transparent;*/
				background-color: rgba(124, 123, 150, 0.8);
				border-radius: 4px;
				border: 0;
				box-shadow: inset 0 0 0 1px rgb(136, 144, 208);
				color: #b1bbf7 !important;
				cursor: pointer;
				display: inline-block;
				font-weight: 300;
				height: 3em;
				line-height: 3em;
				padding: 0 2.25em;
				text-align: center;
				text-decoration: none;
				white-space: nowrap;
				font-size:18px;
			}
		</style>
		<script>
			
			
			function go_step4(){
				
				var tit_id = document.getElementsByName("tit[]");
				var tit_id1 = document.getElementsByName("tit1[]");
				var num_id = document.getElementsByName("content[]");
				var num_id1 = document.getElementsByName("content1[]");
				var arr1 = [];
				var arr2 = [];
				var test = 0;
				for(var i=0;i<num_id.length;i++){
					for(var j=0;j<i;j++){
						if(tit_id[j].value==tit_id[i].value){
							test++;
						}
					}
					if(num_id[i].value!=0){
						
						arr1.push(tit_id[i].value);
						arr2.push(num_id[i].value);
						
					}
				}
				for(var i=0;i<num_id1.length;i++){
					if(num_id1[i].value!=0){
						arr1.push(tit_id1[i].value);
						arr2.push(num_id1[i].value);
						
					}
				}
				if(test==0){
					var end_day=document.getElementById("end_day").value;
					
					var form = document.getElementById("form_name");
					for(var i=0; i<form.check_radio.length;i++){
						if(form.check_radio[i].checked){
							var check_radio = form.check_radio[i].value;
						}
					}
					
					if(tt.innerHTML!="已達上限"){
						alert("時數分配不正確");
						
					}else{
						var check_step3 = confirm("您確認要新增嗎？"); 
						if(!check_step3){
							return false; 
						}
						$.ajax({
							url: 'apply_step4.php',
							type: 'post',
							data: {
								dep:arr1,
								num:arr2,
								end_day:end_day,
								check_radio:check_radio
							},
							success: function(result){
								$("#main").html(result);
							}
						});
						
						
					}
				}else{
					alert("單位不能重複");
				}

			}
			function back_step2(num){
				var end_day=document.getElementById("end_day").value;
				$.ajax({
					url: 'apply_step2.php',
					type: 'post',
					data:{
						number:num
					},
					success: function(result){
						$("#main").html(result);
					}
				});
			}
			var s=0;
			function des(){
				var bt1=document.getElementById("bt1");//--按鈕
				var add=document.getElementById("add");//--加減號圖案
				var tab1=document.getElementById("tab1");//--預設
				var tab2=document.getElementById("tab2");//--選擇單位
				var user_div=document.getElementById("user_div");//--下拉式選單
				if(s==0){
					add.style.display="inline-block";
					tab1.style.display="none";
					tab2.style.display="table";
					user_div.style.display="block";
					bt1.value="單位分配";
					s=1;
				}else{
					add.style.display="none";
					tab2.style.display="none";
					tab1.style.display="table";
					user_div.style.display="none";
					bt1.value="指定單位";
					s=0;
				}
			}
			var s2=0;
			function des2(){
				var tab1=document.getElementById("tab1");//--預設
				var tab2=document.getElementById("tab2");//--選擇單位
				var user_div2=document.getElementById("user_div2");//--下拉式選單
				if(s2==0){
					tab1.style.display="none";
					tab2.style.display="table";
					user_div2.style.display="block";
					document.getElementById("bg_step3").style.display = 'block';
					document.getElementById("show_step4").style.display = 'block';
					s2=1;
				}else{
					tab2.style.display="none";
					tab1.style.display="table";
					user_div2.style.display="none";
					document.getElementById("bg_step3").style.display = 'none';
					document.getElementById("show_step4").style.display = 'none';
					add_tab();
					s2=0;
				}
			}
			function add_tab(){
				/*先取得目前的row數
				var num = document.getElementById("mytable").rows.length;*/
				var tr = document.getElementById("tab2").insertRow(-1);
				td = tr.insertCell(tr.cells.length);
					td.innerHTML="<font color='yellow' size='4'>選擇單位後->點我</font>";
					td.setAttribute('onclick', 'add_dep(this)');
				td = tr.insertCell(tr.cells.length);
					td.innerHTML="<input type='number' name='content[]' onkeyup='one_load();' style='width:50%;' placeholder='0'/>";
			}
			function less_tab(){
				var num = document.getElementById("tab2").rows.length;
				if(num >2)
				document.getElementById("tab2").deleteRow(-1);
				one_load();
			}
			//==選擇單位=====
			function add_dep(obj){
				var depp=document.getElementById("depp").value;
				obj.innerHTML="<input type='hidden' name='tit[]' value='"+depp+"'/><font color='lightgreen' size='4'>"+depp+"</font>";
			}
			function add_dep2(obj){
				var depp2=document.getElementById("depp2").value;
				obj.innerHTML="<input type='hidden' name='tit[]' value='"+depp2+"'/><font color='lightgreen' size='4'>"+depp2+"</font>";
			}
			var hh=0;
			function load(x){
				hh=x;
			}
			var tt=document.getElementById("font_hour");
			function one_load(){
				var num_hour=0;
				var num_id=document.getElementsByName("content[]");
				var num_id1=document.getElementsByName("content1[]");
					for(var i=0;i<num_id.length;i++){
						
						if(num_id[i].value!=""){
							num_hour+=parseFloat(num_id[i].value);
						}else{
							num_hour+=0;
						}
					}
					for(var i=0;i<num_id1.length;i++){
						
						if(num_id1[i].value!=""){
							num_hour+=parseFloat(num_id1[i].value);
						}else{
							num_hour+=0;
						}
					}
				num_hour=hh-num_hour;
				if(num_hour==0){
					tt.innerHTML="已達上限";
					tt.style.color="yellow";
				}else if(num_hour<0){
					num_hour*=-1;
					tt.innerHTML="超過上限"+num_hour+"小時";
					tt.style.color="red";
				}else{
					tt.innerHTML="共"+num_hour+"小時";
					tt.style.color="white";
				}
			}
			function step3_dep_check(){
				$.ajax({
					url: 'step3_dep_check.php',
					success: function(result){
						$("#show_step3").html(result);
						document.getElementById("bg_step3").style.display = 'block';
						document.getElementById("show_step3").style.display = 'block';
					}
				});
			}
			function hide_step3(){
				document.getElementById("bg_step3").style.display = 'none';
				document.getElementById("show_step3").style.display = 'none';
			}
		</script>
	</head>
	<body class="w3-black" align="center">
		<div id="bg_step3" class='bg' onclick='hide_step3();'></div>
		<div id="show_step3" style="display: none;" class='show'></div>
		<div id="show_step4" style="display: none;" class='show'>
			<?php
				/*--下拉選單(單位)--*/
				$api='http://ec.ukn.edu.tw/knjcapi/ukndep?IsAll=false';
				$data = simplexml_load_file($api);
				echo "<div id='user_div2' style='display:none;'>";
					echo "<div class='select' style='width:250px;margin-top:30px;'>";
						echo "<select id='depp2'>";
							$num=0;
							foreach ($data->UknDepEmp as $key){
								$depName=(string)$data->UknDepEmp[$num]->DepName;
								if($num!=0 && $depName!=""){
									echo "<option value='$depName'>$depName</option>";
								}
								$num++;
							}
						echo "</select>";
					echo "</div>";
					echo "</br>";
					
					echo "<font color='red' size='4' >下拉選單並選擇單位</font><br>
					
					<input type='button' id='bgc' class='blue' value='確定' onclick='des2();'>";
					
				echo "</div>";
			?>
		</div>
		<!-- Page Content -->
		<div class="w3-padding-large" id="main">
			<div style="border:0px black solid;width:20%;text-align:right;">
				<input type="button" id='bt2' class='button1' onclick='step3_dep_check();' value="查看 單位未完成 時數" />
			</div>
			<div style="border:0px black solid;width:65%;;text-align:right">
				<input type="button" id='bt1' class='button' onclick='des();' value="指定單位" />
			</div>
			<!--單位分配-->
			<div class="w3-padding-64 w3-content w3-text-grey" id="contact1"  style="max-width: 500px;">
				<?php
					$array=$_SESSION["master_list"];
					$array["content"]=$_POST["content"];
					$array["total_hr"]=$_POST["total_hr"];
					$_SESSION["master_list"]=$array;
					echo "<script>load('$array[total_hr]');</script>";
					/*--下拉選單(單位)--*/
					$api='http://ec.ukn.edu.tw/knjcapi/ukndep?IsAll=false';
					$data = simplexml_load_file($api);
					echo "<div id='user_div' style='display:none;'>";
						echo "<div class='select' style='width:150px;margin-top:30px;'>";
							echo "<select id='depp'>";
								$num=0;
								foreach ($data->UknDepEmp as $key){
									$depName=(string)$data->UknDepEmp[$num]->DepName;
									if($num!=0 && $depName!=""){
										echo "<option value='$depName'>$depName</option>";
									}
									$num++;
								}
							echo "</select>";
						echo "</div>";
						echo "</br>";
						
						echo "<font color='red' size='4' >下拉選單並選擇單位</font>";
						
					echo "</div>";
					//-------------------------
					echo "<h2 class='w3-text-light-grey'>單位分配 <p style='font-size:20px;' id='font_hour'>共$array[total_hr]小時</p></h2>";
					echo "<hr style='width:200px' class='w3-opacity'>";
					$today=date("Y-m-d");
					$end_day=date("Y-m-d");
					$end_day=date('Y-m-d', strtotime($end_day .'+2 weeks'));
					
					
					echo "<form name='form_name' id='form_name'>";
					echo "<input type='radio' name='check_radio' id='check_radio1' value='0'><label  style='color: #fff;cursor: pointer;' for='check_radio1'> 期限過後仍可做審核</label>&nbsp;&nbsp;&emsp;"	;
					echo "<input type='radio' name='check_radio' id='check_radio2' value='1' checked><label  style='color: #fff;cursor: pointer;' for='check_radio2'> 期限過後不可做審核</label>";
					echo "</form>";
					/*--單位分配--*/
					echo "<table border='1px' id='tab1'>";
						echo "<tr>";
							echo "<th width='50%'>單位</th>";
							echo "<th>時數</th>";
						echo "</tr>";	
						echo "<tr>";
							echo "<td><input type='hidden' name='tit1[]' value='軍訓室'/>軍訓室</td>";
							echo "<td><input type='text' name='content1[]' onkeyup='one_load();' style='width:50%;' placeholder='0' /></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td><input type='hidden' name='tit1[]' value='衛生保健組'/>衛生保健組</td>";
							echo "<td><input type='text' name='content1[]' onkeyup='one_load();' style='width:50%;' placeholder='0'/></td>";
						echo "</tr>";
					echo "</table>";
					/*--指定單位--*/
					echo "<table border='1px' id='tab2' style='display:none;'>";
						echo "<tr>";
							echo "<th width='50%'>單位</th>";
							echo "<th>時數</th>";
						echo "</tr>";	
						echo "<tr>";
							echo "<td onclick='add_dep2(this);'>";
								echo "<font style='cursor:pointer;' color='yellow' size='4'>選擇單位後->點我</font>";
							echo "</td>";
							/*echo "<td>";
								//----------------------------------------
									echo "<select id='depp'>";
										$num=0;
										foreach ($data->UknDepEmp as $key){
											$depName=(string)$data->UknDepEmp[$num]->DepName;
											if($num!=0 && $depName!=""){
												echo "<option value='$depName'>$depName</option>";
											}
											$num++;
										}
									echo "</select>";
								//----------------------------------------
							echo "</td>";*/
							echo "<td><input type='number' name='content[]' onkeyup='one_load();' style='width:50%;' placeholder='0'/></td>";
						echo "</tr>";
					echo "</table>";
					//------------------
					echo "<div id='add' style='width:50%;text-align:right;display:none;'>";
						echo "<br><img style='cursor:pointer;' src='images/less.png' width='30px' height='30px' onclick='less_tab();' />";
						echo "&nbsp&nbsp&nbsp";
						echo "<img style='cursor:pointer;' src='images/plus.png' width='30px' height='30px' onclick='des2();' />";
					echo "</div>";
					echo "<p style='display:inline-block;'>";
						echo "<font class='word'>執行期限：</font>";
						echo "<input type='date' id='end_day' min='$today' value='$end_day'/>";
					echo "</p>";
					
					echo "<br/><br/>";
					echo "<div style='border:0px black solid;width:100%;text-align:center'>";
						echo "<input type='button' class='button' onclick='back_step2(\"$array[stu_number]\");' value='上一步'>&nbsp&nbsp&nbsp";
						echo "<input type='button' class='button' onclick='go_step4();' value='下一步'>";
					echo "</div>";
				?>
			</div>
		</div>
	</body>
</html>