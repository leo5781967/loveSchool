<?php
	function seme(){
		$qq=date("Y-m-d");
		$q1=date("Y");
		$q2=date("m-d");
		$d=$q1-1911;
		if($q2>'08-01'){
			if($qq>=date("Y-m-d",mktime(0,0,0,8,1,$q1)) && $qq<date("Y-m-d",mktime(0,0,0,2,1,$q1+1))){
				$d.="1";
			}else{
				$d=($d)."2";
			}
		}else{
			if($qq>=date("Y-m-d",mktime(0,0,0,8,1,$q1-1)) && $qq<date("Y-m-d",mktime(0,0,0,2,1,$q1))){
				$d=($d-1)."1";
			}else{
				$d=($d-1)."2";
			}
		}
		return $d;
	}
?>