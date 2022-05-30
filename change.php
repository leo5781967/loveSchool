<style>

	.button {

		display: inline-block;

		text-align: center;

		vertical-align: middle;

		padding: 12px 24px;

		border: 1px solid #088ec8;

		border-radius: 15px;

		background: #0de7ff;

		background: -webkit-gradient(linear, left top, left bottom, from(#0de7ff), to(#088ec8));

		background: -moz-linear-gradient(top, #0de7ff, #088ec8);

		background: linear-gradient(to bottom, #0de7ff, #088ec8);

		text-shadow: #05597d 1px 1px 1px;

		font: normal normal bold 30px 微軟正黑體 Light;

		color: #ffffff;

		text-decoration: none;

	}

	.button:hover,

	.button:focus {

		border: 1px solid ##0ab2fa;

		background: #10ffff;

		background: -webkit-gradient(linear, left top, left bottom, from(#10ffff), to(#0aaaf0));

		background: -moz-linear-gradient(top, #10ffff, #0aaaf0);

		background: linear-gradient(to bottom, #10ffff, #0aaaf0);

		color: #ffffff;

		text-decoration: none;

	}

	.button:active {

		background: #088ec8;

		background: -webkit-gradient(linear, left top, left bottom, from(#088ec8), to(#088ec8));

		background: -moz-linear-gradient(top, #088ec8, #088ec8);

		background: linear-gradient(to bottom, #088ec8, #088ec8);

	}

</style>

<script> 

	function closeit_show(){ 

		document.getElementById("bgc").setAttribute("style", "display:block");

		document.getElementById('log2').setAttribute("style", "display:block");

	} 

	

</script>

<?php 

	header('Content-type: text/html; charset=utf-8');

	session_start();

	include('db.php');

	//-------------------------------------------------------------------------------------------	

	

	echo "<script>closeit_show();</script>";

	qq($_SESSION['user_acc']);

	

	function qq($tt){

		$api='http://ec.ukn.edu.tw/knjcapi/truser?trid='.$tt;

		$data = simplexml_load_file($api);

		$tname=(string)$data->Truser->trname;

		//echo $tname;

		

		$_SESSION['username'] = $tname;

		$api2='http://ec.knjc.edu.tw/knjcapi/EmpDep?empid='.$tt;

		$data2 = simplexml_load_file($api2);

		$num=0;

		echo "

			<center>

				<h1 style='color:black;'>請選擇登入之單位</h1>

				<br/>

		";

		foreach ($data2->UknDepEmp as $key){

			$dName=(string)$data2->UknDepEmp[$num]->DepName;

			$_SESSION['depname'] = $dName;

			echo "<a href='login_2.php?sps_dep=".urlencode($dName)."&sps_name=".urlencode($tname)."' class='button'>$dName</a><br/><br/><br/><br/>";

			$num++;

		}

		echo "</center>";

		

		die();

	}

	



?>