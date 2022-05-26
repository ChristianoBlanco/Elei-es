<?php
include ("resources/php/valida.php");
include ("resources/php/conexao.php");

$con = conexao("eleicaosba");

$id_voto = $_SESSION["id_voto"];

$email = mysqli_real_escape_string($con, $_POST["email"]);
$rs = mysqli_query($con, "select * from VOTOS where id = ".$id_voto);
if(mysqli_num_rows($rs) > 0){
	$rw = mysqli_fetch_assoc($rs);
	
	$rs2 = mysqli_query($con, "select * from VOTANTES where matricula = ".$matricula);
	$rw2 = mysqli_fetch_assoc($rs2);
}
$html  = "<!DOCTYPE html>";
$html .= "<html>";
$html .= "<head>";
$html .= "<meta charset=\"utf-8\">";
$html .= "<title>Comprovante de votação</title>";
$html .= "</head>";
$html .= "<body bgcolor=\"#F4F4F4\">";
$html .= "<div style=\"border: 1px solid #F4F4F4; width: 600px; padding: 0px 10px 140px 10px; margin: 0 auto; background: #ffffff\">";
$html .= "<table width=\"600\" borde=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: helvetica; line-height: 18pt;\">";
$html .= "  <tbody>";
$html .= "    <tr>";
$html .= "      <td align=\"center\" style=\"padding: 30px;\"><img src=\"http://www.eleicoessba.com.br/resources/images/logomarca.jpg\" width=\"250\" height=\"120\" alt=\"logo\" style=\"border:none\"/></td>";
$html .= "    </tr>";
$html .= "    <tr>";
$html .= "    <th align=\"center\" style=\"padding: 30px 0px;\">COMPROVANTE DE VOTAÇÃO</th>";
$html .= "    </tr>";
$html .= "    <tr>";
$html .= "      <td style=\"padding: 30px 15px; text-align:justify;\">";
$html .= "		  <p style=\"text-indent: 1.2em\">Este documento garante que você concluiu com sucesso o processo de votação online da Sociedade Brasileira de Anestesiologia com a matrícula [MATRICULA] no dia [DIA] às [HORA].</p>";
$html .= "		  <p style=\"text-indent: 1.2em\">Não existe nenhum vínculo entre o registro de votação e o registro de idenficação do seu voto, que é anônimo.</p>";
$html .= "		  <p style=\"text-indent: 1.2em\">Garantimos a confidencialidade do seu voto. Somente o votante poderá identificar este código como seu, assim sendo, sugerimos que guarde este e-mail, caso necessite no futuro.</p>";
$html .= "      </td>";
$html .= "    </tr>";
$html .= "    <tr>";
$html .= "    <td bgcolor=\"#A9FBC4\" align=\"center\" style=\"padding: 40px; font-size: 17pt; color:#660A0B; font-weight: 100; border-radius: 4px\">[COMPROVANTE]</td>";
$html .= "    </tr>";
$html .= "  </tbody>";
$html .= "</table>";
$html .= "</div>";
$html .= "</body>";
$html .= "</html>";

$headers  = "Content-Type:text/html; charset=UTF-8\n";
$headers .= "From:" . utf8_decode(" Votação SBA"). "<comprovantevoto2016@eleicoessba.com.br>\n";
$headers .= "X-Sender: <comprovantevoto2016@eleicoessba.com.br>\n";
$headers .= "Date:".date("r",$_SERVER["REQUEST_TIME"])."\n";
$headers .= "X-Mailer: PHP v".phpversion()."\n";
$headers .= "X-IP: ".$_SERVER["REMOTE_ADDR"]."\n";
$headers .= "Return-Path: <comprovantevoto2016@eleicoessba.com.br>\n";
$headers .= "MIME-Version: 1.0\n";

$mailsender = "comprovantevoto2016@eleicoessba.com.br";
$assunto = "Comprovante de votação SBA 2016";

$html = str_replace("\r","",$html);
$html = str_replace("\n","",$html);

$html =str_replace("[DIA]", date("d/m/Y", strtotime($rw2["ENVIO"])), $html);
$html =str_replace("[MATRICULA]", $matricula, $html);
$html =str_replace("[HORA]", date("H:s:i", strtotime($rw2["ENVIO"])) , $html);
$html =str_replace("[COMPROVANTE]", $rw["comprovante"], $html);

if(mail($email,$assunto,$html,$headers,"-r".$mailsender) == true){
	$json = true;
}else{
	$json = false;
}

print json_encode($json);