
		<style>
			.tab {
				overflow: hidden;
				background-color: #222;
			}
			.tab a {
				text-decoration:none;
				background-color: inherit;
				float: right;
				border: none;
				outline: none;
				cursor: pointer;
				padding: 14px 16px;
				transition: 0.3s;
				font-size: 19px;
				color: #000;
			}
			.tab a:hover {
				color: #000;
				background-color: #999;
			}
			.tab a.active {
				background-color: red;
			}
			/*---------------------table--------------------*/			
			body {
			background: #000;
			}
			#Main {
				width: 600px;
				text-align: center;
				margin: 0 auto;
			}
			.table_top {
				width: 100%;
				font-size:18px;
				border-collapse: collapse;
				text-align: left;
				/*margin: 10px 5px 5px 10px;*/
				cursor: default;
				border: 1px solid #ccc;
				/*margin-top:20px;*/
				box-shadow: 0px 0px 10px rgba(0,255,255,0.75);
				border: 1px solid rgba(127,255,255,0.75);
				-webkit-box-shadow: 0px 0px 8px rgba(0,255,255,0.75);
				-moz-box-shadow: 0px 0px 8px rgba(0,255,255,0.75);
				box-shadow: 0px 0px 8px #8ca5f7;
			}
			
			.tbTitle>th {
				font-weight: 300;
				text-align: center;
				padding: 10px 0 10px 0;
				font: 18px "微软雅黑", Arial, Helvetica, sans-serif;
				background-color: rgba(0,93,93,0.8);
				color: #efefef;
				text-shadow: 0px 0px 20px rgba(127,255,255,1);
			}
			th, td {
				border: 1px solid #a7b4ff;
				text-align:center;
				color: #FFFFFF;
			}
			.tbContext:hover {
				background-color: rgba(0,99,99,0.9) !important;
			}
			td,td>a {
				font: 20px "微软雅黑", Arial, Helvetica, sans-serif;
				text-align: center;
				padding: 6px 0 6px 0;
				//color: rgba(128,255,255,0.75);
				//text-shadow: 0px 0px 20px rgba(0,255,255,0.75);/*-webkit-filter: drop-shadow(0px 0px 20px rgba(0,255,255,0.95));
				-moz-filter: drop-shadow(0px 0px 20px rgba(0,255,255,0.95));
				-o-filter: drop-shadow(0px 0px 20px rgba(0,255,255,0.95));
				-ms-filter: drop-shadow(0px 0px 20px rgba(0,255,255,0.95));
				filter: drop-shadow(0px 0px 20px rgba(0,255,255,0.95));*/
			}
			.tbContext:nth-child(2n 1) {
				background-color: rgba(0,127,127,0.1);
			}

			/*---------------------table--------------------*/	
		</style>
		
		<div id="sidebar">
			<table width="100%" align="center" rules='none' class="table_top">
				<tr bgcolor="#222">
					<td width="100%" >
						<div  align="center"  class="tab">
							<img src="images/ukn.png" height="100">
							<button class="w3-bar-item w3-button w3-padding-large w3-hover-black" onclick="location.href='apply.php';">
								<i class="fa fa-home w3-xxlarge"></i> 
								<p style="font-size:15px;">首頁</p>
							</button>
							<button class="w3-bar-item w3-button w3-padding-large w3-hover-black" onclick="location.href='apply_step1.php';">
								<i class="fa fa-pencil-square-o w3-xxlarge"></i> 
								<p style="font-size:15px;">登記學生愛校</p>
							</button>
							
							<button class="w3-bar-item w3-button w3-padding-large w3-hover-black" onclick="location.href='extension.php';">
								<i class="fa fa-pencil-square-o w3-xxlarge"></i> 
								<p style="font-size:15px;">學生愛校紀錄</p>
							</button>
							
							<?php 
							if($_SESSION['level']=='A' || $_SESSION['level']=='B' || $_SESSION['level']=='C' || $_SESSION['level']=='R'){ 
							?>
								<button class="w3-bar-item w3-button w3-padding-large w3-hover-black" onclick="location.href='time_check.php';">
									<i class="fa fa-gavel w3-xxlarge"></i> 
									<p style="font-size:15px;">愛校時數上傳</p>
								</button>
							<?php
							}
							?>
							
							<?php 
							if($_SESSION['level']=='A' || $_SESSION['level']=='B' || $_SESSION['level']=='T'){ 
							?>
								<button class="w3-bar-item w3-button w3-padding-large w3-hover-black" onclick="location.href='myclass_search.php';">
									<i class="fa fa-sticky-note w3-xxlarge"></i>
									<p style="font-size:15px;">本班愛校資訊</p>
								</button>
							<?php
							}
							?>
							
							<?php 
							if($_SESSION['level']=='A' || $_SESSION['level']=='C' || $_SESSION['level']=='R' || $_SESSION['level']=='B'){
							?>
								<button class="w3-bar-item w3-button w3-padding-large w3-hover-black"  onclick="location.href='t_statistics.php';">
									<i class="fa fa-bar-chart w3-xxlarge"></i>
									<p style="font-size:15px;">統計</p>
								</button>
							<?php
							}
							?>
							
							<?php 
							//if($_SESSION['level']=='A' || $_SESSION['level']=='B' || $_SESSION['level']=='C' || $_SESSION['level']=='R'){ 
							?>
								<!--<button class="w3-bar-item w3-button w3-padding-large w3-hover-black" onclick="location.href='anno.php';">
									<i class="fa fa-calendar-o w3-xxlarge"></i>
									<p style="font-size:15px;">公告</p>
								</button>-->
							<?php
							//}
							?>
							
							<?php
							if($_SESSION['level']=='A' || $_SESSION['level']=='C'){ 
							?>
								<button class="w3-bar-item w3-button w3-padding-large w3-hover-black" onclick="location.href='teachselect.php';">
									<i class="fa fa-cogs w3-xxlarge"></i>
									<p style="font-size:15px;">管理審核人員</p>
								</button>
							<?php
							}
							?>

							<button class="w3-bar-item w3-button w3-padding-large w3-hover-black" onclick="location.href='index.html';">
								<i class="fa fa-user w3-xxlarge"></i>
								<p style="font-size:15px;">登出</p>
							</button>
						</div>
					</td>
				</tr>
			</table>
		</div>