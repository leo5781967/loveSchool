<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();
	include('db.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>愛校管理系統</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link href="css/font-awesome_index.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/button.css" rel="stylesheet" type="text/css" media="all" />
		
		<style>
			.w3-sidebar {width: 140px;background: #222;height: 100%;}
		</style>
		<script src="js/jquery-3.1.1.min.js"></script>
		<script>
			function go_step2(){
				var num=document.getElementById("number").value;
				$.ajax({
					url: 'apply_step2.php',
					type: 'post',
					data:{number:num},
					success: function(result){
						$("#main").html(result);
					}
				});
				/*url="apply_step2.php?number="+num;
				alert(url);
				location.href='apply_step2.php?number=+num';*/
			}
			function key() { 
				if(event.keyCode == 13) 
				go_step2(); 
			}
			function fou() { 
				document.getElementById("number").focus();
			}
			fou();
		</script>
	</head>
	<body onload="fou();" class="w3-black" style="background-image:url(images/black.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
		<?php include('./sidebar.php'); ?>
			<!-- Page Content -->
			<div class="w3-padding-large" id="main">
			  <!-- Contact Section -->
			  <div class="w3-padding-64 w3-content w3-text-grey" id="contact">
				<h1 class="w3-text-light-grey" style="font-size:45px;">登記學生愛校</h1>
				<h2 class="w3-text-light-grey">輸入學號：</h2>
				<hr style="width:200px" class="w3-opacity">
				<p><input id="number" class="w3-input w3-padding-16" type="text" onkeyup="key();" placeholder="學號" ></p>
				<p>
					<button class="w3-button w3-light-grey w3-padding-large" onclick="go_step2();">
						<i class="fa fa-paper-plane"></i> 送出
					</button>
				</p>
				<br/>
				
			  </div>
			</div>
	</body>
</html>
