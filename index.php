<?php

include ("resources/php/conexao.php");

$con = conexao('eleicaocargos');
//$ip = explode(".",$_SERVER['REMOTE_ADDR']);
/*if(!isset($_COOKIE['cabine'])){
	//$rs = mysqli_query($con, "select * from cabines where status = 0 and ip = ".$ip[3]);
	$rs = mysqli_query($con, "select * from cabines where status = 0 ");
	if(mysqli_num_rows($rs) > 0){
		$rw = mysqli_fetch_assoc($rs);
		//setcookie('cabine',(string)$rw['cabine'], time()+(3600*24));
		header("location:index.php");
	}else{
		$cabine = "";
	}
}else{
	$cabine = $_COOKIE['cabine'];
	//exit;
}*/

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Controle de eleições</title>
<link rel="stylesheet" type="text/css" href="./resources/css/CSSreset.min.css">
<link rel="stylesheet" type="text/css" href="./resources/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="./resources/css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="./resources/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./resources/css/bootstrap.css">
<script src="resources/js/jquery-2.1.1.min.js"></script>
<style>
.navbar {
	background: #244224 !important;
}
.btn-block {
	padding: 15px 0px;
}
span.chapa {
	display: block;
	font-size: 11pt;
	padding-left: 25px;
	margin-bottom: 30px;
	margin-top: 15px;
}

html, body {
	height: 100%;
}

.rodape {
	position: absolute;
	bottom: 0px;
	background:  #008b92;
	min-height: 55px;
	width: 100%;
	color: #fff;
	display: table;
}

.rodape h5 {
	display: table-cell;
	vertical-align: middle;
}

.vertical-center{
  display: flex;
  align-items: center;	
}

#centralizado {
	margin-top: 3em;
}
</style>
</head>
<body>
<?php 
  header("location:login.php");
?>
<?php
include("resources/php/rodape.php");

?>