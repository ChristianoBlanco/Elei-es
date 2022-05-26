<?php
ini_set('display_errors','on');
include ("../resources/php/conexao.php");

$con = conexao('ELEICAOCARGOS');

$login = mysqli_real_escape_string($con, $_POST['login']);
$senha = mysqli_real_escape_string($con, $_POST['senha']);

if(!empty($login) || !empty($senha)){
	$rs = mysqli_query($con, "select * from adm where usuario = '".$login."' and senha = '".$senha."'");
	if(mysqli_num_rows($rs) > 0){
	  $rw = mysqli_fetch_assoc($rs);
	  session_start();
	  $_SESSION['id'] = $rw['id'];
	  $_SESSION['usuario'] = $rw['usuario'];
	  $_SESSION['senha']   = $rw['senha'];
	  header('location: painel.php');
	}else{
		print '<div class="topo"><img src="/resources/images/logomarca.jpg" /></div>';
		print '<hr color="#244224">';
		print '<div class="h1"><h1>Usuário e/ou senha não encontrado!</h1>';
		print '<a href="index.php">Voltar</a></div>';
	}
}else{
	print '<div class="topo"><img src="/resources/images/logomarca.jpg" /></div>';
	print '<hr color="#244224">';
	print '<div class="h1"><h1>Os campos usuário e senha não podem ficar vazios!</h1>';
	print '<a href="index.php">Voltar</a></div>';

}
?>
<style>
*{
	font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
}
a{
	padding: 10px 20px;
	border-radius: 4px;
	color:#fff;
	text-decoration:none;
	background:#427942;
	width: 8em;
	display: block;
	text-align:center;
	margin: 90px auto;
}
.h1{
	display: block;
	margin: 10% auto;
	width: 50%;
	text-align:center;
}
.topo{
	width: 100%;
	display: block;
	text-align:center;
}
</style>