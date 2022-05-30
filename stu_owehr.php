<!DOCTYPE HTML>
<?php 
	error_reporting(0);
	session_start(); 
		if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
?>
<html>
	<style>
			table{
				width:100%;
			}
			<!--.bg{
				display: none; 
				position: absolute;
				top: 0%;
				left: 0%;
				width: 100%;
				height: 150%;
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
				left: 30%;  
				width: 40%;  
				height: 70%;  
				padding: 8px;  
				border: 8px solid #E8E9F7; 
				position:fixed;  
				background-color: #DDDDDD;   
				z-index:1002;  
				overflow: auto;
				cursor: pointer; 
				//background-image:url(image/cc.jpg);
				background-size:100% 100%
			}-->
	</style>
	<script>
			function stu_table(id){
				$.ajax({
						url: 'stu_table.php',
						type: 'post',
						data:{a:id},
						success: function(result){
							$("#table").html(result);
							document.getElementById("table").style.display = 'block';
							document.getElementById("bg").style.display = 'block';
							
						}
					});
			}

			function cc(pge){
				if(pge==null){
					pge=1;
				}
				$.ajax({
					url: 'stu_owehr.php?pge='+pge,// url位置
					type: 'post', 
					success: function(result){
						$("#main").html(result);
					}
				});
			}
		</script>
	<body class="is-preload landing">
	

	<div id="main">
		<div id="page-wrapper">
			<!-- Banner -->
			<?php 
				include 'db.php';
				$tt=$_SESSION['user_acc'];
				$api='http://ec.ukn.edu.tw/knjcapi/stdsimple?idno='.$tt;
				$ret=mysqli_query($link,"SELECT count(*) as C FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `teacher_information` as d on b.`teacher_id`=d.`teacher_id` where b.`account_id`='$tt'");
				if (isset($_GET['pge'])){
				$p=$_GET['pge'];//接收頁數
				}else{
				$p=1;//預設第1頁
				}
				$pnum=10; //每頁有10筆
				$pstart=($p-1)* $pnum; //計算第p頁應該由第幾筆開始抓起
				$row=mysqli_fetch_assoc($ret);
				$pcount=$row['C'];//總資料比數
				$pmax=ceil($pcount/$pnum);
				echo"<br>";	
				//計算總積欠時數
				$hr1=mysqli_query($link,"SELECT sum(`total_hr`) as 'total_hr2' FROM `master_list` where `account_id`='$tt'");//結束日期到今天的所有時數
				$hr2=mysqli_query($link,"SELECT sum(a.`hr`) as 'total_hr3' FROM `service_hours` as a inner join `reservation` as b on a.`res_id`=b.`res_id` inner join `master_list` as c on b.`mas_id`=c.`mas_id` where `account_id`='$tt'");//結束日期到今天所核銷的時數加總
				$total=mysqli_fetch_assoc($hr1);
				$total2=mysqli_fetch_assoc($hr2);
				$time=$total['total_hr2'];
				$time2=$total2['total_hr3'];
				$all_hr=$time - $time2;
			?>
					<div >
						<header>
						<?php 
							if($total['total_hr2']=='')
								{
							?>	
							<h1>目前沒有積欠時數喔~~~</h1>
						<?php 	}
							else
							{
						?>
						
						<h1>學期：<?php echo "$_POST[year]";?>&nbsp;&nbsp;&nbsp;&nbsp;目前積欠時數：<?php  echo round($all_hr,1);?>小時</h1>
						</header>
						<?php
									$date_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `teacher_information` as d on b.`teacher_id`=d.`teacher_id` where b.`account_id`='$tt' and a.`res_status`='2' and b.`semester` and b.`end_day`<=now()");
									while($date=mysqli_fetch_array($date_sql)){
										mysqli_query($link,"UPDATE `reservation` SET `res_status`='3' where `res_id`='$date[res_id]'");
									}
									
									$date2_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `teacher_information` as d on b.`teacher_id`=d.`teacher_id` where b.`account_id`='$tt' and a.`res_status`='3' and b.`semester` and b.`end_day`>=now()");
									while($date2=mysqli_fetch_array($date2_sql)){
										mysqli_query($link,"UPDATE `reservation` SET `res_status`='2' where `res_id`='$date2[res_id]'");
									}
							
									$select="SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `teacher_information` as d on b.`teacher_id`=d.`teacher_id` where b.`account_id`='$tt'";
									$year=$_POST['year'];
									if($year!=""){
									$select.=" and b.`semester` LIKE '$year'";
									}
									$select.=" order by a.`res_status` desc limit $pstart,$pnum";
									
									$ret=mysqli_query($link,$select);
									$num=mysqli_num_rows($ret);
									//echo"<br>";
									if($num=='0'){
									echo "<br/><font style='color:red; Font-size:48px;font-family:微軟正黑體 Light;text-shadow: rgb(136, 136, 136) 2px 2px 2px;'>本學期查無此紀錄!</font>";
									}else{
									echo"
									<table align='center' border='2'>";
									echo
									"<tr>
										<td align='center' style='width:15%;'><b>填報日期</b></td>
										<td align='center' style='width:15%;'><b>截止日期</b></td>
										<td align='center' style='width:15%;'><b>事由</b></td>
										<td align='center' style='width:20%;'><b>報到單位</b></td>
										<td align='center' style='width:10%;'><b>總時數</b></td>
										<td align='center' style='width:15%;'><b>未完成時數</b></td>
										<td align='center' style='width:10%;'><b>狀態</b></td>
										<td align='center' style='width:15%;'></td>
									</tr>";
									$s=0;
									
									While($row=mysqli_fetch_assoc($ret)){
										
										$time_hr_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `service_hours` as b on a.`res_id`=b.`res_id` inner join `master_list` as c on a.`mas_id`=c.`mas_id` where c.`account_id`='$row[account_id]' and b.`res_id`='$row[res_id]' limit $pstart,$pnum");
										
										$total_hr=$row["res_hr"];
										
									
										while($sel3=mysqli_fetch_assoc($time_hr_sql)){
											
											$total_hr=round($total_hr-$sel3["hr"],1);
										}
										$s++;										
											echo
											"<tr>
											<td align='center'>$row[write_day]</td>
											<td align='center'>$row[end_day]</td>
											<td align='center'>$row[content]</td>
											<td align='center'>$row[unit_name]</td>
											<td align='center'>$row[res_hr]</td>
											<td align='center'>$total_hr</td>
											<td align='center'>";	
											
											if($row["res_status"]==1){ 
												echo "已完成"; 
											}elseif($row["res_status"]==2){ 
												echo "<font style='color:yellow;'>未完成</font>";
											}elseif($row["res_status"]==3){
												echo "<font style='color:#ff8080;'>超過期限</font>";
											}
											echo "</td>
											<td align='center'><input type='button' value='詳細資料' onclick='stu_table($row[res_id]);'></td>
										</tr>";
										
										}				
										echo"</table>";		
									}
									}
									echo"<br>";
									if($p>1){
									$ps=$p-1;
									echo "<ul class='pagination'><li><a href=# onclick='cc($ps);'><font face='微軟正黑體'><<上一頁</a></li></ul>";
										}
									for ($x=1;$x<=$pmax;$x=$x+1){	
									if ($x==$p){
									echo "<ul class='pagination'>
										  <li><a class='active'>$p</a></li>
									</ul>";
									}else{
									echo "<ul class='pagination'>";
									echo "<li><a href='#' onclick='cc($x);'>$x</a></li>
									</ul>";					
									}
									}
									if($p < $pmax){
									$next=$p+1;
									echo "<ul class='pagination'><li><a href=# onclick='cc($next);'><font face='微軟正黑體'>下一頁>></a></li></ul>";
									} 
									echo"<br>";
									//echo "<font size='4px' color='#fff'>共計$pcount 筆</font>";			
						?>
				</div>
			</div>
	</body>
</html>