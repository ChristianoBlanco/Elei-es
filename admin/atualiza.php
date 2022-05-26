<?php
	ini_set("memory_limit", "25M");
	ini_set("display_errors", "on");
	
	include ("../../_resources/php/conexao.php");
	
	$rs = mysqli_query($con1,"Select * from representantes where userid = 0");
	if(mysqli_num_rows($rs)){
		while($rw = mysqli_fetch_array($rs)){
			$rs1 = mysqli_query($con1,"select * from usuario where matricula = ".$rw['matricula']);
			if(mysqli_num_rows($rs1)){
				$rw1 = mysqli_fetch_array($rs1);
				mysqli_query($con1,"Update representantes set userid = ".$rw1['id']." where matricula = ".$rw['matricula']);	
			}
		}
	}
	
	echo "ok";