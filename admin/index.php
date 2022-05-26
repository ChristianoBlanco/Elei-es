<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Controle de eleições</title>
<link rel="stylesheet" type="text/css" href="../resources/css/CSSreset.min.css">
<link rel="stylesheet" type="text/css" href="../resources/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="../resources/css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="../resources/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../resources/css/bootstrap.css">
<style>
.navbar {
	background: #244224 !important;
}
.btn-block {
	padding: 15px 0px;
}
span.chapa {
	display: block;
	font-size: 11pt;
	padding-left: 25px;
	margin-bottom: 30px;
	margin-top: 15px;
}
html, body {
	height: 100%;
}
.rodape {
	position: absolute;
	bottom: 0px;
	background: #244224;
	min-height: 55px;
	width: 100%;
	color: #fff;
	display: table;
}
.rodape h5 {
	display: table-cell;
	vertical-align: middle;
}
.vertical-center{
  display: flex;
  align-items: center;	
}
</style>
</head>
<body>
<div class="topo text-center"><img src="/resources/images/logomarca.png" /></div>
<hr color="#244224">
<div class="container">
 
  <div class="row"><br><br><br><br><br>
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="glyphicon glyphicon-user"></i>&nbsp;login</h3>
        </div>
        <div class="panel-body">
          <form class="form-horizontal" action="logar.php" method="post">
            <div class="form-group">
              <div class="col-md-12">
                <label class="control-label">Usuário</label>
                <input type="text" name="login" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <label class="control-label">Senha</label>
                <input type="password" name="senha" class="form-control">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary">Entrar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12">&nbsp;</div>
  </div>
<?php include("../resources/php/rodape.php") ?>