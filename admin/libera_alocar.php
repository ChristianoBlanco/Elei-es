<?php
ini_set('display_errors','on');

include("../resources/php/conexao.php");

$con = conexao('ELEICAOCARGOS');

$cabine = (int)$_POST['cabine'];
$ip = (int)$_POST['ip'];

mysqli_query($con, "update cabines set status = 1, ip = ".$ip." where cabine = ".$cabine);
print mysqli_error($con);
print json_encode("Cabine ".$cabine." alocada para máquina com IP final ".$ip);
