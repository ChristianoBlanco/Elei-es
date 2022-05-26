<?php
require("../../_resources/php/conexao.php");
ini_set('display_errors','on');

    $arquivo = $anobase_adm . date('H').date('mm').date('i'). '.xls';

    //Configurações header para forçar o download
    header ("Expires:0");
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ("Content-Disposition: attachment; filename=".$arquivo);
    header ("Content-Description: PHP Generated Data" );
	
	$html = '<table width="1000" border="1">';
	$html .= '<tr><td>Matrícula</td><td>Userid</td></tr>';
	
	$rs = mysqli_query($con1, 'SELECT * FROM usuario where matricula <> 0');
	while($rw = mysqli_fetch_array($rs)){
		$html .= "<tr><td>".$rw['matricula']."</td><td>".$rw['id']."</td></tr>";
	}	
	$html .= "</table>";
	
	echo utf8_decode($html);