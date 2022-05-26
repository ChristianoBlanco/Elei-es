<?php
ini_set('display_errors','on');
include ("resources/php/conexao.php");
//$con = conexao('eleicaosba');
$con = conexao('eleicaocargos');

$login = mysqli_real_escape_string($con, $_POST['login']);
$senha = mysqli_real_escape_string($con, $_POST['senha']);

if(!empty($login) || !empty($senha)){
	$rs = mysqli_query($con, "select MATRICULA,HASH,VOTO from VOTANTES where USUARIO = '".$login."' and SENHA = '".$senha."'");
	if(mysqli_num_rows($rs) > 0){
		$rw = mysqli_fetch_assoc($rs);
		if($rw['VOTO'] == 0){
		  session_start();
		  $_SESSION['matricula'] = $rw['MATRICULA'];
		  $_SESSION['hash'] = $rw['HASH'];
		  $_SESSION['controle'] = 'Diretoria';
		  $_SESSION['id_voto'] = (int)0;
		  $_SESSION['comprovante'] = (int)0;
		  
		  header('location: index.php');
		}else{
			print '<div class="topo"><img src="/resources/images/logomarca.jpg" /></div>';
			print '<hr color="#244224">';
			print '<div class="h1"><h1>Desculpe, mas de acordo com nossos registros seu voto já foi computado!</h1>';
			print '<a href="login.php">Voltar</a></div>';
		}
	}else{
		print '<div class="topo"><img src="/resources/images/logomarca.jpg" /></div>';
		print '<hr color="#244224">';
		print '<div class="h1"><h1>Erro, o usuário e/ou a senha digitada não foi encontrada. Por favor, digite novamente.</h1>';
		print '<a href="login.php">Voltar</a></div>';
	}
}else{
	print '<div class="topo"><img src="/resources/images/logomarca.jpg" /></div>';
	print '<hr color="#244224">';
	print '<div class="h1"><h1>Os campos usuário e senha não podem ficar vazios!</h1>';
	print '<a href="login.php">Voltar</a></div>';
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
}
.topo{
	width: 100%;
	display: block;
	text-align:center;
}
</style>