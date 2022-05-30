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
  background-color: #C4C4C4;
  width: 50%;
  text-align: left;
  border-collapse: collapse;
}
table.blueTable td, table.blueTable th {
  border: 4px solid #AAAAAA;
  padding: 3px 2px;
}
table.blueTable tbody td {
  font-size: 18px;
  font-weight: bold;
  color: #333333;
}
table.blueTable td:nth-child(even) {
  background: #DFECF4;
}
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
	<script>
			function upd1(){
				var id=document.getElementById('res_id').value;
				var ed=document.getElementById('date1').value;
				if(ed==""){
					alert("請輸入結束期限");
					return false;
				}else{
					$.ajax({
						type:'POST',
						url: 'extension_upd_2.php',
						data:{
							id:id,
							end_day:ed,
						},
						success: function(result){
							hide();
							finish();
						}
					})
				}
			}		
			function hide(){
				document.getElementById("bg").style.display = 'none';
				document.getElementById("ext_upd").style.display = 'none';
			}
			
			function finish(){
				/*$.ajax({url: "extension.php", 
					success: function(result){
						$("#main").html(result);
					}
				});*/
				location.href = "extension.php";
			}
		</script>
	<body>
	<?php
		include 'db.php';
		$ret=mysqli_query($link,"SELECT * FROM `reservation` as a inner join `master_list` as b on a.`mas_id`=b.`mas_id` inner join `units` as c on a.`unit_id`=c.`unit_id` inner join `student_information` as d on b.`account_id`=d.`account_id` where `res_id` = '$_POST[id]';");
		$row=mysqli_fetch_assoc($ret);
			//詳細時數表格
				$today=date('Y-m-d');
				$max_day=date('Y-m-d', strtotime($today .'+6 months'));
		echo"
			<center>
				<table class='blueTable'>
					<tbody>
						<input type='hidden' id='res_id' name='res_id' value='$row[mas_id]'>
						<tr>
							<td Width='35%' >學期</td>
							<td>$row[semester]</td>
						</tr>
						<tr>
							<td>填報日期</td>
							<td>$row[write_day]</font></td>
						</tr>
						<tr>
							<td>結束期限</td>
							<td>$row[end_day]</font></td>
						</tr>
						<tr>
						<td>結束期限</td>
						<td>
						
						<input id='date1' name='date1' type='date' value='' min='".date("Y-m-d")."' max='$max_day'>
						</td>
						</tr>
					</tbody>
				</table>
						<td>
							<input type='button' id='bg' class='green' value='確定' onclick='upd1()'>
							&nbsp&nbsp
							<input type='button' id='bg' class='red' value='關閉' onclick='hide();'>
						</td>
			</center>";		
		?>
		<div id="bg" class='bg' onclick='hide();'></div>
		<div id="ext_upd" style="display: none;" class='show'></div>
	</body>
</html>