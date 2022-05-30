<!DOCTYPE html>
<?php 
	session_start(); 
		if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
	include 'db.php';
	$tt=$_SESSION['sps_dep'];
	$api='http://ec.ukn.edu.tw/knjcapi/stdsimple?idno='.$tt;
?>
<html>
	<head>
		<title>愛校管理系統</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="css/table.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link href="css/font-awesome_index.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/button.css" rel="stylesheet" type="text/css" media="all" />
		<style>
			.w3-sidebar {width: 140px;background: #222;height: 100%;}
			table{
				font-size:28px;font-family:serif;
			}
			
		</style>
		<script src="js/jquery-3.1.1.min.js"></script>
		<script>
		function bb(pag){
				if(typeof(pag)=='undefined')pag=1;
				var year=document.getElementById("year").value;
				$.ajax({
					type:'POST',
					url: "t_statistics_1.php?p="+pag,
					data:{year:year},
					success: function(result){
						$("#div1").html(result);
					},
				});
			}
			bb();
		</script>
	</head>

	<body onload="bb();" class="w3-black" style="background-image:url(images/black.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
	<?php include('./sidebar.php'); ?>			
			<div class="div2">
				<div class="main">	
					<center>
						</br>
						<!--<h2>查看本科事由總人次與總時數</h2>-->
						<table style="align:center;width:67%;">
							<form>
								<tr style='font-size:16px;'>
								<td>
								學期：
								</td>
								<td>
									<select name="year" id="year"  align="center">
									<?php
									$select=mysqli_query($link,"SELECT DISTINCT `semester` FROM `master_list` order by `semester` DESC");
									while($row=mysqli_fetch_assoc($select)){ 
									?>
									<option>
									<?php echo $row['semester'];}?>
									</option>
									</select>
								</td>
								<td>
									<a href="javascript: bb();" onclick="bb()">
										<input class="blue" type="button" value="查詢">
									</a>
								</td>
								
								</tr>
							</form>
							
						</table>
						</br>
						<div id="div1"></div>
					</center>
				</div>
			</div>
	</body>
</html>