<?php

function conexao($banco){
	$hostname = "localhost";
	$username = "root";
	$password = "";
	if (mysqli_connect_errno()) {
	    echo "Erro de conexão com o banco de dados: " . mysqli_connect_error();
	}else{
		$con = mysqli_connect($hostname, $username, $password, $banco);	
		mysqli_set_charset($con, "utf8");		
		return $con;
	}
}