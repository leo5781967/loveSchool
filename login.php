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
		document.getElementById("bg").setAttribute("style", "display:block");
		document.getElementById('log').setAttribute("style", "display:block");
	} 
	function closeit_close(){ 
		document.getElementById("bg").setAttribute("style", "display:none");
		document.getElementById('log').setAttribute("style", "display:none");
	} 
	function closeit_close1(){ 
		setTimeout("closeit_close();", 1200);
	}
</script>
<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start();
	include('db.php');
	//----------------------------------------判斷權限(暫不啟用)-----------------------------------------	
	/*$arr=explode("/",$_POST['user_acc']);
	$url = "http://ec.ukn.edu.tw/knjcapi/auth.aspx?id=".$arr[0]."&pwd=".$_POST['user_pwd'];
	$output = file_get_contents($url);
	if($output!="n00" && $output!="s00" && $output!="t00"){
		$_SESSION['user_acc'] = $arr[0];
		$row=mysqli_query($link,"select * from `manager` where `account`='$arr[0]';");
		if($row1=mysqli_fetch_array($row)){
			if(isset($arr[1])){
				if($arr[1]=="admin"){
					echo '<script>location.href="M-Option-search.php";</script>';
					die();
				}
				//=====================================student=============================
				@$api_stu = simplexml_load_file("http://ec.ukn.edu.tw/knjcapi/stdsimple?idno=".$arr[1]."");
				if($api_stu){
					$_SESSION['user_acc'] = $arr[1];
					echo "<script>location.href='student.php'</script>";
					die();
				}
				//=========================================================================
				$api='http://ec.ukn.edu.tw/knjcapi/truser?trid='.$arr[1];
				$data = simplexml_load_file($api);
				$tname=(string)$data->Truser->trname;
				//echo $tname;
				$_SESSION['user_acc'] = $arr[1];
				$_SESSION['username'] = $tname;
				$api2='http://ec.knjc.edu.tw/knjcapi/EmpDep?empid='.$arr[1];
				$data2 = simplexml_load_file($api2);
				$num=0;
				foreach ($data2->UknDepEmp as $key){
					$dName=(string)$data2->UknDepEmp[$num]->DepName;
					$num++;
				}
				if($num==1){
					//----判斷是不是只有一個單位
					gg($arr[1],1);
				}else{
					//----擁有多個單位
					echo "<script>closeit_show();</script>";
					qq($arr[1],1);
				}
			}else{
				echo "<script>location.href='student.php'</script>";
			}
		}elseif($output=="s01"){
			echo "<script>location.href='student.php'</script>";
		}elseif($output=="t01"){
			$api='http://ec.ukn.edu.tw/knjcapi/truser?trid='.$arr[0];
			$data = simplexml_load_file($api);
			$tname=(string)$data->Truser->trname;
			//echo $tname;
			$_SESSION['user_acc'] = $arr[0];
			$_SESSION['username'] = $tname;
			$api2='http://ec.knjc.edu.tw/knjcapi/EmpDep?empid='.$arr[0];
			$data2 = simplexml_load_file($api2);
			$num=0;
			foreach ($data2->UknDepEmp as $key){
				$dName=(string)$data2->UknDepEmp[$num]->DepName;
				$num++;
			}
			if($num==1){
				//----判斷是不是只有一個單位
				gg($arr[0],1);
			}else{
				//----擁有多個單位
				echo "<script>closeit_show();</script>";
				qq($arr[0],1);
			}
		}
	}else{
		echo "<script>closeit_show();</script>";
		echo "<br/><br/><br/><br/><center><font size='64px' color='red'>帳號密碼錯誤!!</font></center>";
		echo "<script>closeit_close1();</script>";
	}*/
	//-----------------------------------------(無權限判斷)------------------------------------------
	$arr=$_POST['user_acc'];
	$_SESSION['user_acc'] = $arr;
	if(isset($arr)){
		if($arr=="admin"){
			echo '<script>location.href="M-Option-search.php";</script>';
			die();
		}
		//=====================================student=============================
		@$api_stu = simplexml_load_file("http://ec.ukn.edu.tw/knjcapi/stdsimple?idno=".$arr."");
		if($api_stu){
			$_SESSION['user_acc'] = $arr;
			echo "<script>location.href='student.php'</script>";
			die();
		}
		//=========================================================================
		$api='http://ec.ukn.edu.tw/knjcapi/truser?trid='.$arr;
		$data = simplexml_load_file($api);
		$tname=(string)$data->Truser->trname;
		//echo $tname;
		$_SESSION['user_acc'] = $arr;
		$_SESSION['username'] = $tname;
		$api2='http://ec.knjc.edu.tw/knjcapi/EmpDep?empid='.$arr;
		$data2 = simplexml_load_file($api2);
		$num=0;
		foreach ($data2->UknDepEmp as $key){
			$dName=(string)$data2->UknDepEmp[$num]->DepName;
			$num++;
		}
		if($num==1){
			//----判斷是不是只有一個單位
			$_SESSION['dep_count'] = "1";
			gg($arr,1);
		}else if($num==0){
			echo "<script>closeit_show();</script>";
			echo "<br/><br/><br/><br/><center><font size='64px' color='red'>帳號密碼錯誤!!</font></center>";
			echo "<script>closeit_close1();</script>";
		}else{
			//----擁有多個單位
			$_SESSION['dep_count'] = "0";
			echo "<script>closeit_show();</script>";
			qq($arr,1);
		}
		
	}else{
		echo "<script>location.href='student.php'</script>";
	}
	//------------------------------------------------------------------------------------------
	function qq($tt,$ss){
		
		//=====================================teacher=============================
		$api='http://ec.ukn.edu.tw/knjcapi/truser?trid='.$tt;
		$data = simplexml_load_file($api);
		$tname=(string)$data->Truser->trname;
		//echo $tname;
		$_SESSION['user_acc'] = $tt;
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
	function gg($tt,$ss){
		
		$api='http://ec.ukn.edu.tw/knjcapi/truser?trid='.$tt;
		$data = simplexml_load_file($api);
		$tname=(string)$data->Truser->trname;
		//echo $tname;
		$_SESSION['user_acc'] = $tt;
		$_SESSION['username'] = $tname;
		$api2='http://ec.knjc.edu.tw/knjcapi/EmpDep?empid='.$tt;
		$data2 = simplexml_load_file($api2);
		$num=0;
		
		foreach ($data2->UknDepEmp as $key){
			$dName=(string)$data2->UknDepEmp[$num]->DepName;
			$_SESSION['depname'] = $dName;
			echo "<script>location.href='login_2.php?sps_dep=".urlencode($dName)."&sps_name=".urlencode($tname)."'</script>";
			$num++;
		}
		die();
	}
	

?>