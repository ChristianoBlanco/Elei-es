<?php
  ini_set('display_errors','on');
  include("resources/php/conexao.php");
  include("logon.php");
  
 $con = conexao('eleicaocargos');
 $check = $_POST;
 $rs = mysqli_query($con, "SELECT * FROM cargos");
 while($rw = mysqli_fetch_assoc($rs)){
	$t2 = mysqli_query($con, "select id from candidatos where cargo = ".$rw['id']);
	$t = mysqli_num_rows($t2);
	$c = array_keys($_POST,$rw['id']);
	if((int)$t > (int)$rw['vagas']){
		//Disputa
		switch(true){
			case count($c) === (int)0:
				$rs1 = mysqli_query($con, "select * from candidatos where cargo = ".$rw['id']);
				while($rw1 = mysqli_fetch_assoc($rs1)){
					$c2[] = $rw1['cod_campo'];
					$o[] = 3;
				}
				break;
			case count($c) > $rw['vagas']:
				$rs1 = mysqli_query($con, "select * from candidatos where cargo = ".$rw['id']);
				while($rw1 = mysqli_fetch_assoc($rs1)){
					$c2[] = $rw1['cod_campo'];
					$o[] = 2;
				}
				break;
			default:
				$rs1 = mysqli_query($con, "select * from candidatos where cargo = ".$rw['id']);
				while($rw1 = mysqli_fetch_assoc($rs1)){
					if(in_array($rw1['cod_campo'],$c)){
						$c2[] = $rw1['cod_campo'];
						$o[] = 1;
					}else{
						$c2[] = $rw1['cod_campo'];
						$o[] = 0;
					}
				}
				break;
		}
	}else{
		//Não tenho disputa
		//print $rw['descricao'] . '  -> ' . count($c). '/'.$rw['vagas'] . '<br>';
		switch(true){
			case count($c) > $rw['vagas']:
				$rs1 = mysqli_query($con, "select * from candidatos where cargo = ".$rw['id']);
				while($rw1 = mysqli_fetch_assoc($rs1)){
						$c2[] = $rw1['cod_campo'];
						$o[] = 2;
				}
				break;
			case count($c) <= $rw['vagas']:
			  
			  if($rw['vagas'] > 1 && count($c) == 0){ $b = 3; }else{ $b = 0; }

			  $rs1 = mysqli_query($con, "select * from candidatos where cargo = ".$rw['id']);
			  while($rw1 = mysqli_fetch_assoc($rs1)){
				if(in_array($rw1['cod_campo'],$c)){
					$c2[] = $rw1['cod_campo'];
					$o[] = 1;
				}else{
					$c2[] = $rw1['cod_campo'];
					$o[] = $b;
				}
			  }
			  break;
 			default:
				$rs1 = mysqli_query($con, "select * from candidatos where cargo = ".$rw['id']);
				while($rw1 = mysqli_fetch_assoc($rs1)){
						$c2[] = $rw1['cod_campo'];
						$o[] = 0;
				}
				break;
			
		}
	}
 }
 

mysqli_query($con, "insert into votos (".implode(",", $c2).") VALUES (".implode(",", $o).")");
print mysqli_error($con);
//mysqli_query($con, "update cabines set status = 1 where cabine = ".$_COOKIE['cabine']);
mysqli_query($con, "update votantes set status_votante = 1 where id = ".$id);

print "<script> alert('Voto computado com sucesso!'); location.href='index.php'; </script>";
