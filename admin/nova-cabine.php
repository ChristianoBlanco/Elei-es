<?php
ini_set("display_errors", "on");

include __DIR__ . "/../resources/php/conexao.php";

$con = conexao("ELEICAOCARGOS");

$rs = mysqli_query($con, "select id from cabines");
$nCabines = mysqli_num_rows($rs);

if ($nCabines < 10){ 
    mysqli_query($con, "insert into cabines (cabine, status, votante) values (" . ($nCabines+1) . ",0,0)");
    print mysqli_error($con);
    if (mysqli_affected_rows($con) > 0) {
        $retorno = true;
    } else {
        $retorno = false;
    }
} else {
    $retorno = false;
}

print json_encode($retorno);