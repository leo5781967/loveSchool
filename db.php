<?php
	$link=mysqli_connect("localhost","loveSchool","love+1234"); //連線帳號密碼
	if(!$link) die('連線失敗'); //如果連線失敗則停止程式並顯示連線失敗
	mysqli_query($link,"SET CHARACTER SET UTF8"); //編碼
	mysqli_select_db($link,"loveSchool") or die("選擇資料庫失敗".mysqli_error($link)); //選擇資料庫如果失敗則停止程式並顯示選擇資料庫失敗
?>
