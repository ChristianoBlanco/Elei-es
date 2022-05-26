<?php
ini_set('display_errors','on');

include("../resources/php/conexao.php");

$con = conexao('ELEICAOCARGOS');

if($_POST['tipo'] == 'novo' || $_POST['tipo'] == 'edit'){
	switch(true){
		case empty($_POST['descricao']):
		case empty($_POST['vagas']):
		case empty($_POST['sequencia']):
			print "<script>alert('Nenhum campo pode ficar vazio!'); history.back();</script>";
			break;
		default:
			$descricao = mysqli_real_escape_string($con, $_POST['descricao']);
			$vaga = (int)$_POST['vagas'];
			$sequencia = (int) $_POST['sequencia'];  
	}
}

$tipo = mysqli_real_escape_string($con, $_POST['tipo']);

if($tipo == 'novo'){
	$rs = mysqli_query($con, "select * from cargos where sequencia = ".$sequencia);
	if(mysqli_num_rows($rs) == 0){
		mysqli_query($con, "insert into cargos (id,descricao,vagas,sequencia) VALUES (0,'".$descricao."',".$vaga.",".$sequencia.")");
	}else{
		$rs = mysqli_query($con, "select * from cargos where sequencia >= ".$sequencia);
		$x = $sequencia;
		while($rw = mysqli_fetch_assoc($rs)){
			$x += 1;
			mysqli_query($con, "update cargos set sequencia = ".$x." where id = ".$rw['id']);
		}
		mysqli_query($con, "insert into cargos (id,descricao,vagas,sequencia) VALUES (0,'".$descricao."',".$vaga.",".$sequencia.")");
	}
	print "<script>alert('Cargo gravado com sucesso!'); location.href='painel.php?controle=cargos&tipo=listar';</script>";
}else
	if($tipo == 'edit'){
		$id = (int) $_POST['id'];
		mysqli_query($con, "update cargos set descricao = '".$descricao."', vagas = '".$vaga."', sequencia = ".$sequencia." where id = ".$id);
		print "<script>alert('Candidato gravado com sucesso!'); location.href='painel.php?controle=cargos&tipo=listar';</script>";
	}else
		if($tipo == 'sequencia'){
			$lista = explode(",", $_POST['lista']);
			foreach($lista as $i => $item){
				$sequencia = $i+1;
				mysqli_query($con, "update cargos set sequencia = {$sequencia} where id = {$item}");
			}
			print json_encode("ok");
		}else{
			print '<h1>Erro!</h1>';
		}