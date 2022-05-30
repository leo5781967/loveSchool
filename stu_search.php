<!DOCTYPE html>
<?php
	session_start(); 
	if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
	include 'db.php';
	$tt=$_SESSION['user_acc'];
	$api='http://ec.ukn.edu.tw/knjcapi/stdsimple?idno='.$tt;
?>
<html>
	<head>

		<style>
			.bg{
				display: none; 
				position: absolute;
				top: 0%;
				left: 0%;
				width: 100%;
				height: 200%;
				background-color: black;
				z-index:1001;
				-moz-opacity: 0.7;
				opacity:.70;
				filter: alpha(opacity=70);
			}
			.show{
				display: none;  
				position: absolute;  
				top: 10%;  
				left: 30%;  
				width: 40%;  
				height: 80%;  
				padding: 8px;  
				border: 8px solid #E8E9F7; 
				position:fixed;  
				background-color: #DDDDDD;   
				z-index:1002;  
				overflow: auto;
				cursor: pointer; 
				//background-image:url(image/cc.jpg);
				background-size:100% 100%
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
	</style>
		<script>
		function aa(pag){
				if(typeof(pag)=='undefined')pag=1;
				var year=document.getElementById("year").value;
				$.ajax({
					type:'POST',
					url: "stu_owehr.php?p="+pag,
					data:{year:year},
					success: function(result){
						$("#div2").html(result);
					},
				});
			}
			aa();
		/* 清空查詢
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
	<section id="banner">
		<body onload="aa();">
			<div id="big" class="content">
				<center>
					</br>
					<?php
						$thr=mysqli_query($link,"SELECT sum(c.`hr`) as `totalhr` FROM `master_list` as a inner join `reservation` as b on a.`mas_id`=b.`mas_id` inner join `service_hours` as c on b.`res_id`=c.`res_id` where `account_id`='$tt'");
						$num=mysqli_fetch_assoc($thr);
					?>
					<h2>愛校紀錄總覽</h2></br>
					<h2>已完成時數：<?php  echo round($num['totalhr'],1);?>小時</h2>
					
					<table>
						<form>
							<tr style='font-size:16px;'>
							<td align="center" style="width:1.5%;text-align:right;">
								<font style="font-size:24px;">學期：</font>
							</td>
							<td style="width:0.5%;text-align:center;">
								<select name="year" id="year" style="width:80%;text-align:center;">
									<?php
										$select=mysqli_query($link,"SELECT DISTINCT `semester` FROM `master_list` order by `semester` DESC");
										while($row=mysqli_fetch_assoc($select)){ 
									?>
								<option>
									<?php echo $row['semester'];}?>
								</option>
								</select>
							</td>
						
							<td align="center" style="width:1.1%;text-align:left;">
								<a href="javascript: aa();" onclick="aa()">
									<input type="button" value="查詢">
								</a>
							</td>
							<!--<td>
								<a href="javascript: bb();" onclick="bb()">
									<input type="button" value="清空查詢">
								</a>
							</td>-->
							</tr>
						</form>
						
					</table>
					
					<div id="div2"></div>
				</center>
			</div>
			<div id="bg" class='bg' onclick='hide();'></div>
			<div id="table" style="display: none;" class='show'></div>
		</body>
	</section>
</html>
