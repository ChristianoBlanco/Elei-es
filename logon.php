<?php
// Inicia sessões
session_start();

$id = $_SESSION["id"];
// Verifica se existe os dados da sessão de login
if(!isset($_SESSION["usuario"]) || !isset($_SESSION["senha"]))
{
// Usuário não logado! Redireciona para a página de login
header("Location: login.php");
exit;
}
?>