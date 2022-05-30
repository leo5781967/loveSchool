<!DOCTYPE HTML>
<?php session_start(); 
		if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
?>
<html>
<style>
	table.blueTable {
	border: 1px solid #1C6EA4;
	
	width: 100%;
	text-align: left;
	border-collapse: collapse;
	}
	table.blueTable th{
		background-color: #1C6EA4;
	}
	table.blueTable td, table.blueTable th {
	text-align:center;
	border: 4px solid #AAAAAA;
	padding: 3px 2px;
	}
	table.blueTable tbody td {
	font-size: 18px;
	font-weight: bold;
	color: #333333;
	}
	/*table.blueTable td:nth-child(even) {
	background: #DFECF4;
	}*/
	table.blueTable tfoot td {
	font-size: 14px;
	}
	table.blueTable tfoot .links {
	text-align: right;
	}
	table.blueTable tfoot .links a{
	display: inline-block;
	background: #1C6EA4;
	color: #FFFFFF;
	padding: 2px 8px;
	border-radius: 5px;
	}
</style>
	<body>
		<center>
		<h1 style="color:#000000;">詳細資料</h1>
	<?php 
		$tt=$_SESSION['user_acc'];
		$api='http://ec.ukn.edu.tw/knjcapi/stdsimple?idno='.$tt;
		$xmlurl=$api;
		$data = simplexml_load_file($xmlurl);
		$stu_chiname=(string)$data->stdSimple->chiname; //姓名
		
		include 'db.php';
		
		/*$ret=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `student_information` as d on b.`account_id`=d.`account_id` inner join `teacher_information` as e on b.`teacher_id`=e.`teacher_id` where `res_id`=$_POST[a]");*/
		$ret=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `service_hours` as c on a.`res_id`=c.`res_id` inner join `units` as d on a.`unit_id`=d.`unit_id` inner join `teacher_information` as e on c.`teacher_id`=e.`teacher_id` where a.`res_id`='$_POST[a]'");
		
		$ret_num=mysqli_num_rows($ret);
	
		echo "<table class='blueTable'>
					<tbody>
						<tr>
							<th>完成日期</th>
							<th>愛校時間</th>
							<th>愛校內容</th>
							<th>愛校單位</th>
							<th>審核人</th>
							<th>時數</th>
							
						</tr>";
		if($ret_num==0){
			echo "
					
						
						<tr>
							<td colspan='7'>無資料</td>
						</tr>
						
					
				";
		}else{
			while($row=mysqli_fetch_assoc($ret)){
		
				
			
				echo "
						<tr>
							<td>$row[ser_day]</td>
							<td>$row[start_time]~
							$row[end_time]</td>
							<td>$row[service_work]</td>
							<td>$row[unit_name]</td>
							<td>$row[teacher_name]</td>
							<td>$row[hr]</td>
							
						</tr>
						
					
				";
			}
		}
		echo "
			</tbody>
			</table>		
			<input type='button' value='返回' onclick='hide();'>
			</center>";		
		?>
		</center>
	</body>
</html>