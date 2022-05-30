<!DOCTYPE HTML>
<?php session_start();
		if (empty($_SESSION['user_acc'])){
		die("<a href='index.html'>請先登入!!!!</a>");
	}
?>
<html>
	<head>
		<title>康寧大學-愛校管理系統</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<script type="text/javascript">
		function url(t){
			$.ajax({
				url: t+'.php',
				type: 'post', 
				success: function(result){
					$("#chage").html(result);
				}
			});
		}
	</script>
	<body class="is-preload landing">
		<?php 
			$tt=$_SESSION['user_acc'];
			$api='http://ec.ukn.edu.tw/knjcapi/stdsimple?idno='.$tt;
			$xmlurl=$api;
			$data = simplexml_load_file($xmlurl);
			$stu_chiname=(string)$data->stdSimple->chiname; //姓名
		?>
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1 id="logo">愛校管理系統&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $stu_chiname.'&nbsp;同學'; ?></h1>	
					<label></label>
					<nav id="nav">
						<ul>
							<!--<li><a onclick="url('stu_work')">我要填報</a></li>-->
							<!--<li><a onclick="url('stu_res')">預約時段</a></li>-->
							<li><a onclick="url('stu_search')">我的愛校紀錄</a></li>
							<li><a onclick="url('login_out')" class="button primary">登出</a></li>
						</ul>
					</nav>
				</header>
		</div>		

			<!-- Banner -->
		<div id="chage">
				<section id="banner">
					<div class="content">
						<header>
							<h2>歡迎使用愛校管理系統</h2>
							<p>你可以在此網頁查詢你的愛校紀錄或是你所積欠的時數</p>
						</header>
						<span class="image"><img src="images/ukn.jpg" /></span>
					</div>
					
				</section>

			<!-- Footer -->
				<footer id="footer">
					<ul class="icons">
						<li><a href="#" class="icon brands alt fa-facebook-f"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon brands alt fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon solid alt fa-envelope"><span class="label">Email</span></a></li>
					</ul>
					<ul class="copyright">
						<li>&copy;本系統由資管科學生：王致鈞、王譯璟、洪浩軒、王景瀚協助開發&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;技術指導：資圖中心 陳宗騰 主任</li>
					</ul>
				</footer>
		</div>
		

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>	
		
	</body>
</html>