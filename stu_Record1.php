
<?php
$n=0;
$n1=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `teacher_information` as d on b.`teacher_id`=d.`teacher_id` inner join `student_information` as e on b.`account_id`=e.`account_id` where b.`teacher_id` = '$tt' ORDER BY a.`res_status` desc,`end_day` ASC,b.`account_id` ASC");
while($row1=mysqli_fetch_assoc($n1)){
	$time_hr_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `service_hours` as b on a.`res_id`=b.`res_id` inner join `master_list` as c on a.`mas_id`=c.`mas_id` where c.`account_id`='$row1[account_id]' and b.`res_id`='$row1[res_id]' ");
	$total_hr=$row1["res_hr"];
	while($sel3=mysqli_fetch_assoc($time_hr_sql)){
		$total_hr=round($total_hr-$sel3["hr"]);
	}
	if($total_hr != 0){
		$n++;
	}
}
if($n==0){
	echo "<font style='color:#fff;'>
	<h1>目前沒有您所登記的未完成愛校紀錄&nbsp;&nbsp;
	<a><input type='button' class='red' value='返回' onclick='go_back();'></a>
	</h1>

	</font>";
}else{ ?>
	<h2 style='color:#fff;'>學生未完成紀錄&nbsp;&nbsp;</h2>
	</header>

	<?php
	echo"
	<table align='center' border='2' class='fancytable'>";
	echo
	"<tr class='headerrow'>
		<th align='center'><b>截止日期</b></th>
		<th align='center'><b>學號</b></th>
		<th align='center'><b>姓名</b></th>
		<th align='center'><b>事由</b></th>
		<th align='center'><b>報到單位</b></th>
		<th align='center'><b>所有時數</b></th>
		<th align='center'><b>積欠時數</b></th>
		<th align='center'><b>延長截止日期</b></th>
		<th align='center'><b>刪除</b></th>
	</tr>";
	$date_sql=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `teacher_information` as d on b.`teacher_id`=d.`teacher_id` inner join `student_information` as e on b.`account_id`=e.`account_id` where b.`teacher_id` = '$tt' and a.`res_status`='2' and b.`end_day`<=now()");
	while($date=mysqli_fetch_array($date_sql)){
			mysqli_query($link,"UPDATE `reservation` SET `res_status`='3' where `res_id`='$date[res_id]'");
	}
	$date_sql2=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `teacher_information` as d on b.`teacher_id`=d.`teacher_id` inner join `student_information` as e on b.`account_id`=e.`account_id` where b.`teacher_id` = '$tt' and a.`res_status`='3' and b.`end_day`>=now()");
	while($date2=mysqli_fetch_array($date_sql2)){
			mysqli_query($link,"UPDATE `reservation` SET `res_status`='2' where `res_id`='$date2[res_id]'");
	}
	
	
	/* if(isset($_GET["account"])){
		$ret_sql1="SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `teacher_information` as d on b.`teacher_id`=d.`teacher_id` inner join `student_information` as e on b.`account_id`=e.`account_id` where b.`teacher_id` = '$tt' and e.`account_id`='$_GET[account]' ORDER BY a.`res_status` desc,`end_day` ASC,b.`account_id` ASC";
	}else{ */
		$ret_sql1="SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `teacher_information` as d on b.`teacher_id`=d.`teacher_id` inner join `student_information` as e on b.`account_id`=e.`account_id` where b.`teacher_id` = '$tt' ORDER BY a.`res_status` desc,`end_day` ASC,b.`account_id` ASC";
	//}
	
	$ret1=mysqli_query($link,$ret_sql1);
	
	
	$s=0;
	while($row=mysqli_fetch_assoc($ret1)){
		
		/* if(isset($_GET["account"])){
			$time1_hr_sql="SELECT * FROM `reservation` as a inner join `service_hours` as b on a.`res_id`=b.`res_id` inner join `master_list` as c on a.`mas_id`=c.`mas_id` where c.`account_id`='$_GET[account]'";
		}else{ */
			$time1_hr_sql="SELECT * FROM `reservation` as a inner join `service_hours` as b on a.`res_id`=b.`res_id` inner join `master_list` as c on a.`mas_id`=c.`mas_id` where c.`account_id`='$row[account_id]' and b.`res_id`='$row[res_id]'";
		//}
		
		$time_hr_sql=mysqli_query($link,$time1_hr_sql);
		$total_hr=$row["res_hr"];
		while($sel3=mysqli_fetch_assoc($time_hr_sql)){
			
			$total_hr=round($total_hr-$sel3["hr"]);
			/* echo "$sel3[mas_id] &nbsp";
			echo "$sel3[res_id] &nbsp";
			echo "$total_hr &nbsp";
			echo "$sel3[hr]";
			echo "</br>";
			echo "</br>"; */
		}							
		$s++;
		if($total_hr == 0){
			
		}else{
			if($s%2==0){
				echo
				"<tr class='datarowodd'>
					<td align='center'>$row[end_day]</td>
					<td align='center'>$row[account_id]</td>
					<td align='center'>$row[stu_name]</td>
					<td align='center'>$row[content]</td>
					<td align='center'>$row[unit_name]</td>
					<td align='center'>$row[res_hr]</td>
					<td align='center'>$total_hr</td>
				";
				if($row["res_status"]==1){
					echo"	<td align='center' colspan='3'>";
							if($row["res_status"]==2){ 
								echo "<font style='color:#ff9900;'>未過期</font>";	
							}elseif($row["mas_status"]==1 and $row["res_status"]==3){
								echo "<font style='color:red;'>超過期限無法上傳</font>";
							}elseif($row["res_status"]==3){
								echo "<font style='color:red;'>超過期限</font>";
							}
							echo"</td>
					
					";
				}else{
					echo"	<td align='center'>";
							if($row["res_status"]==2){ 
								echo "<font style='color:#ff9900;'>未過期</font>";	
							}elseif($row["mas_status"]==1 and $row["res_status"]==3){
								echo "<font style='color:red;'>超過期限無法上傳</font>";
							}elseif($row["res_status"]==3){
								echo "<input type='button' class='orange' value='延長截止日期' onclick='upd($row[res_id]);'>";
							}
							echo"</td>
					
					";
				}
					echo "<td align='center'><input type='button' class='red' value='刪除' onclick='del($row[res_id]);'></td>";
			}
			else{
				echo "
				
				<tr class='dataroweven'>
					<td align='center'>$row[end_day]</td>
					<td align='center'>$row[account_id]</td>
					<td align='center'>$row[stu_name]</td>
					<td align='center'>$row[content]</td>
					<td align='center'>$row[unit_name]</td>
					<td align='center'>$row[res_hr]</td>
					<td align='center'>$total_hr</td>
				";
				if($row["res_status"]==1){
					
					echo "<td align='center' colspan='3'>";
					if($row["res_status"]==2){ 
						echo "<font style='color:#ff9900;'>未過期</font>";
					}elseif($row["mas_status"]==1 and $row["res_status"]==3){
						echo "<font style='color:red;'>超過期限無法審核</font>";
					}elseif($row["res_status"]==3){
						echo "<font style='color:red;'>超過期限</font>";
					}
					echo"</td>";
				}else{
				
					echo "<td align='center'>";
					if($row["res_status"]==2){ 
						echo "<font style='color:#ff9900;'>未過期</font>";
					}elseif($row["mas_status"]==1 and $row["res_status"]==3){
						echo "<font style='color:red;'>超過期限無法審核</font>";
					}elseif($row["res_status"]==3){
						echo "<input type='button' class='orange' value='延長截止日期' onclick='upd($row[res_id]);'>";
					}
					echo"</td>";
				}
					echo "<td align='center'><input type='button' class='red' value='刪除' onclick='del($row[res_id]);'></td>";
				echo "
				</tr>";
			}
		}
	
	}

	echo"</table>";
}
?>