<?php
// Inicia sessões, para assim poder destruí-las
session_start();
session_destroy();

print '<div class="topo"><img src="./resources/images/logomarca_sba.png" /></div>';
print '<hr color="#244224">';
print '<div class="h1"><h1>Desculpe, mas de acordo com nossos registros seu voto já foi computado!</h1>';
print '<a href="login.php">Voltar</a></div>';
?>
<style>
*{
	font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
}
a{
	padding: 10px 20px;
	border-radius: 4px;
	color:#fff;
	text-decoration:none;
	background:#427942;
	width: 8em;
	display: block;
	text-align:center;
	margin: 90px auto;
}
.h1{
	display: block;
	margin: 10% auto;
	width: 50%;
}
.topo{
	width: 100%;
	display: block;
	text-align:center;
}
</style>