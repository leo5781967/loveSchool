<!DOCTYPE html>
<?php session_start(); 
		if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
	
	include 'db.php';
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
			ul.pagination {
			display: inline-block;
			padding: 0;
			margin: 0;
			font-size:15px
			}

			ul.pagination li {display: inline;}
			ul.pagination li a {
				color: black;
				float: left;
				padding: 8px 16px;
				text-decoration: none;
				transition: background-color .3s;
				font-size:15px
			}

			ul.pagination li a.active {
				background-color:#FFB630;
				color: white;
				font-size:15px
			}

			ul.pagination li a:hover:not(.active){
				background-color: #dddddd;
				font-size:15px
			}
			 .bb {
			transition: all 0.5s ease 0s;
			width:50px
		   }
		   .bb:hover {
			-moz-transform: scale(1.05);
			-ms-transform: scale(1.05);
			-o-transform: scale(1.05);
			-webkit-transform: scale(1.05);
			transform: scale(1.05);
			opacity: .5;
		   }
			.show{
				display: none;  
				position: absolute;  
				top: 20%;  
				left: 25%;  
				width: 50%;  
				height: 55%;  
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
		
			
			.bg{
				display: none; 
				position: absolute;
				top: 0%;
				left: 0%;
				width: 200%;
				height: 200%;
				background-color: black;
				z-index:1001;
				-moz-opacity: 0.7;
				opacity:.70;
				filter: alpha(opacity=70);
			}
	</style>
		<script src="js/jquery-3.1.1.min.js"></script>
		<script>
			function aa(pag){
				if(typeof(pag)=='undefined')pag=1;
				var year=document.getElementById("year").value;
				var account=document.getElementById("account").value;
				var t="myclass.php?year="+year+"&page="+pag+"&account="+account;
				$.ajax({
					type:'GET',
					url: t,
					
					success: function(result){
						$("#div2").html(result);
					},
				});
			}
			aa();
		/*清空查詢
		function bb(){
			document.getElementById("year").value="";
			aa();
		} */
		function hide(){
			document.getElementById("bg").style.display = 'none';
			document.getElementById("table").style.display = 'none';
		}
	</script>
	</head>
	<body onload="aa();" class="w3-black" style="background-image:url(images/black.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
		<?php include('./sidebar.php'); ?>
		<div class="outer-container">
		<div class="inner-container">
        <div class="content">
		<div id="big" class="content">
			<center>
				</br>
				<h2>本班愛校資訊總覽</h2>
				<input class="blue" type="button" name="assimilation" id="m_statistics" value="本班事由統計" onclick="location.href='m_statistics.php'"></br></br>
				<table style="align:center;width:67%;">
					<form>
						<tr style='font-size:16px;'>
						<td>
							學期：
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
							學號：<input type="text" id="account" name="account" style="height:30px;width:150px">
						</td>
						<td>
							<a href="javascript: aa();" onclick="aa()">
								<input class="blue" type="button" value="查詢">
							</a>
						</td>
						<!--<td>
							<a href="javascript: bb();" onclick="bb()">
								<input class="red" type="button" value="清空查詢">
							</a>
						</td>-->
						</tr>
					</form>
					
				</table>
				
				<div id="div2"></div>
			</center>
		<div>
		
		<div id="bg" class='bg' onclick='hide();'></div>
		<div id="table" style="display: none;" class='show'></div>
		 </div>
     </div>
 </div>
	</body>
</html>
