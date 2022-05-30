<html>
	<head>
		
		<script>
			
			function hide_step3(){
				document.getElementById("bg_step3").style.display = 'none';
				document.getElementById("show_step3").style.display = 'none';
			}
			function hide_step4(){
				var depp=document.getElementById("depp").value;
				$.ajax({
					type:'POST',
					url: 'apply_step3.php',
					data:{
						depp:depp
					},
					success: function(result){
						hide_step3();
					}
				})
			}
		</script>
		<style>
			th{ background-color:#6c85b5;font-size: large;border: 1px solid #504d9a;}
			.headerrow td{ color:#000000; text-align:center;font-family: "微軟正黑體";}
			
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
		<center>
			<h2  style="color:#3a3f7b;">選擇單位</h2>
		</center>
		<table align='center' border='2'  class="fancytable">

			<?php
				echo "<tr>";
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
				echo "</tr>";	
				//===============================
				echo "
					
					<tr>
						<td colspan='3'>
							<input type='button' id='bgc' class='blue' value='確定' onclick='hide_step4();'>
						</td>
						<td colspan='3'>
							<input type='button' id='bgc' class='blue' value='關閉' onclick='hide_step3();'>
						</td>
					</tr>
				";
			?>
		</table>
		<div id="bgc" class='bg' onclick='hide_step3();'></div>
		<div id="show_sel" style="display: none;" class='show'></div>	
	</body>
</html>
