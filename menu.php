<style>
	a.hide {
		text-decoration:none;
	}
	a:hover {
		color: red;
		background-color: #cccccc;
	}
	li:hover {
		height: 100%;
		background-color: #cccccc;
	}
	
			
	.tab {
		overflow: hidden;
		background-color: #e1e1ea;
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
</style>
<div style="text-align:center;">
	<br>
	<font class="title">愛校管理系統</font></br>
			<table width="100%" align="center" rules='none'>
				<tr bgcolor="#e1e1ea">
					<td width="80%" >
						<div class="tab">
							<li style="display:inline-block;"><a href="statistics_1.php" class="hide">查看愛校歷史紀錄</a style="display:inline;"></li>
							<li style="display:inline-block;;"><a href="M-Option-1-s.php" class="hide">統計學期未完成時數</a></li>
							<li style="display:inline-block;;"><a href="M-Option-s.php" class="hide">愛校紀錄統計</a></li>
							<li style="display:inline-block;;"><a href="statistics_3_s.php" class="hide">分配時數統計</a></li>
							<li style="display:inline-block;;"><a href="statistics_4_s.php" class="hide">事由統計</a></li>
						</div>
					</td>
					<td width="15%" align="right" >
						<div class="tab">
							<li style="display:inline-block;;" ><a href="index.html" class="hide">登出</a></li>
						</div>
					</td>
				</tr>
			</table>
</div>