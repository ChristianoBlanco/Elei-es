<?php 
  ini_set('display_errors','on');
  include ("../resources/php/conexao.php");
  $con = conexao('ELEICAOCARGOS');
  
  $tipo = mysqli_real_escape_string($con, $_POST['tipo']);

  $cabine = (int)$_POST['cabine'];
  
  $rs = mysqli_query($con, "update cabines set status = 0 where id = ".$cabine);
  
  print json_encode('Cabine '.$cabine.' liberada!');
		