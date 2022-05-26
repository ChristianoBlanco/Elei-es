<?php
ini_set('display_errors','on');

include("../resources/php/conexao.php");

$con = conexao('ELEICAOCARGOS');

if(isset($_POST['tipo']) && $_POST['tipo'] == 'candidato'){
	$id_cand = (int)$_POST['id'];
	mysqli_query($con, "delete from candidatos where id = ".$id_cand);
}else{
	$id = (int)$_POST['id'];
	mysqli_query($con, "delete from cargos where id = ".$id);
	$rs = mysqli_query($con, "select * from cargos order by sequencia");
	$x = 1;
	while($rw = mysqli_fetch_assoc($rs)){
		mysqli_query($con, "update cargos set sequencia = ".$x." where id = ".$rw['id']);
		$x += 1;
	}
}
if(mysqli_error($con) != ''){
	print json_encode("Erro,".mysqli_error($con));
}else{
	print json_encode("Candidato removido com sucesso");
}