<?php
ini_set('display_errors','on');

include("../resources/php/conexao.php");

$con = conexao('ELEICAOCARGOS');

switch(true){
	case empty($_POST['nome']):
	case empty($_POST['cargo']):
	case empty($_POST['campo']):
	  print "<script>alert('Nenhum campo pode ficar vazio!'); history.back();</script>";
	  break;
	default:
	  $nome = mysqli_real_escape_string($con, $_POST['nome']);
	  $cargo = (int)$_POST['cargo'];
	  $campo = mysqli_real_escape_string($con, $_POST['campo']);	
	  $tipo = mysqli_real_escape_string($con, $_POST['tipo']);
	  
	  if($tipo == 'novo'){
			mysqli_query($con, "insert into candidatos (id,cod_campo,nome,cargo) VALUES (0,'".$campo."','".$nome."',".$cargo.")");
	  }else
	  	if($tipo == 'edit'){
			$id = (int) $_POST['id'];
			mysqli_query($con, "update candidatos set cod_campo = '".$campo."', nome = '".$nome."', cargo = ".$cargo." where id = ".$id);
		}else{
			print '<h1>Erro!</h1>';
		}
		
		if(mysqli_error($con) != ''){
			print '<h1>Erro, '.mysqli_error($con).'</h1>';
		}else{
			print "<script>alert('Candidato gravado com sucesso!'); location.href='painel.php?controle=candidato&tipo=".$tipo."&id_cand=".$id."';</script>";
		}
}

