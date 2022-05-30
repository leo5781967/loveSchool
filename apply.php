<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();
	include('db.php');
	
	if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>康寧大學-愛校管理系統</title>
		<meta charset="UTF-8">

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link href="css/font-awesome_index.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/button.css" rel="stylesheet" type="text/css" media="all" />
		<link href="css/apply.css" rel="stylesheet" type="text/css" media="all" />

		
		<style>
			.w3-sidebar {width: 120px;background: #222;height: 105%;}
			.topnav-right { float: right;}
			.w3-padding-64 {
				padding-top: 14px!important;
				padding-bottom: 64px!important;
			}

		</style>
		<script src="js/jquery-3.1.1.min.js"></script>
		<script>
			function go_url(uu){
				$.ajax({
					url: uu+'.php',
					type: 'post',
					success: function(result){
						$("#main").html(result);
					}
				});
			}
			function go_sel(id){
				$.ajax({
					type:'POST',
					url: 'anno_sel.php',
					data: {
						id:id
					},
					success: function(result){
						$("#show_sel").html(result);
						document.getElementById("bgc").style.display = 'block';
						document.getElementById("show_sel").style.display = 'block';
					}
				});
			}
			function hide(){
				document.getElementById("bgc").style.display = 'none';
				document.getElementById("show_sel").style.display = 'none';
				document.getElementById("log2").style.display = 'none';
			}
			
			function show(){//==================================切換單位
				//location.href="main.html";
				var acc2=document.getElementById("acc2").value;
				if(acc2!=""){
					$.ajax({
						url: 'change.php',
						type: 'post',
						data:{user_acc:acc2},
						success: function(result){
							$("#log2").html(result);
						}
					});
				}
			}
			
		</script>
	</head>
	<body class="w3-black" style="background-image:url(images/black.jpg);background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;">
		
		<div id="bgc" class='bg' onclick='hide();'></div>
		<div id="show_sel" style="display: none;" class='show'></div>
		<div id="log2" style="display: none;" class='show'></div>
		
		<?php include('sidebar.php'); ?>
		<style>
			.qq td {
				border: 0px solid #a7b4ff;
				color: #ffffb3;
				text-align:left;
			}
		</style>
		<div class="w3-padding-large" id="main">
			<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
				<input type="hidden" id="acc2" value="<?php echo $_SESSION['user_acc'];?>">
				
					
				
				<h1 class="w3-text-light-grey" style="font-size:30px;">
					<?php echo $_SESSION["sps_dep"];?>
					<?php if($_SESSION["dep_count"]=="0"){ ?>
						<button class="change1" style="vertical-align:middle" onclick="show();">
							<span>切換單位</span>
						</button>
					<?php } ?>
					
					<?php echo " ｜ ".$_SESSION["sps_name"]." 老師"; ?>
				</h1>
				
				<h1 class="w3-text-light-grey" style="font-size:50px;">愛校管理系統</h1>
			
				
				<h4 class="w3-text-light-grey" style="font-size:30px;" align="left">登記愛校說明</h4>
				
				<table align='left' style="color:#fff">
					
					<tr class="qq" height="40px" style="font-size:20px;">
						<td align='left'>※選擇完愛校事由及填完愛校時數後,</td>
						<td>&emsp;&emsp;&emsp;&emsp;</td>
						<td align='left'>※若有登記錯學生愛校,</td>
					</tr>
					<tr class="qq" height="40px" style="font-size:20px;">
						<td align='left'>請選擇執行期限過期後是否可以做時數上傳,</td>
						<td>&emsp;&emsp;&emsp;&emsp;</td>
						<td align='left'>可到學生愛校紀錄頁面,</td>
					</tr>
					<tr class="qq" height="40px" style="font-size:20px;">
						<td align='left'>並做確認分配單位和時數是否有誤※</td>
						<td>&emsp;&emsp;&emsp;&emsp;</td>
						<td align='left'>做查詢刪除的動作※</td>
					</tr>
					
				</table>
				<!--<table align='left' border='2'  class="fancytable" style="color:#fff">
					<tr class="headerrow" height="40px" style="font-size:20px;">
						<th>編號</th>
						<th>起始日期</th>
						<th>終止日期</th>
						<th>公告標題</th>
						<th>操作</th>
					</tr>
					<?php
						/*$sel=mysqli_query($link,"select * from `announment`");
						$n=1;
						$s=0;
						while($sel2=mysqli_fetch_assoc($sel)){			
							$s++;
							if($s%2==0){
								echo "
									<tr class='datarowodd'>	
										<td>$n</td>
										<td>$sel2[date_start]</td>
										<td>$sel2[date_end]</td>
										<td>$sel2[ano_title]</td>
										<td>
											<input type='button' id='del' name='del' class='blue' value='查看' onclick='go_sel(\"$sel2[ano_id]\")'>&nbsp&nbsp
											
										</td>
									</tr>
								";
							}else{
								echo "
									<tr class='dataroweven'>	
										<td>$n</td>
										<td>$sel2[date_start]</td>
										<td>$sel2[date_end]</td>
										<td>$sel2[ano_title]</td>
										<td>
											<input type='button' id='del' name='del' class='blue' value='查看' onclick='go_sel(\"$sel2[ano_id]\")'>&nbsp&nbsp
											
										</td>
									</tr>
								";
							}
							$n++;
						}
						echo $_SESSION["level"];*/
					?>
				</table>-->
			
			</div>
		</div>
		
	</body>
</html>