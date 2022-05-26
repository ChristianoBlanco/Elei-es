<?php include ("resources/php/header.php");?>
 
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
                <input type="text" name="login" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <label class="control-label">Senha</label>
                <input type="password" name="senha" class="form-control" required>
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
      <div class="col-md-12">
      <h3><center>Para acessar a área de votação, utilize os dados - USUÁRIO e SENHA, eviados via E-mail.</center></h3>
    </div>
  </div>
  <div class="col-md-12">&nbsp;</div>
  </div>
<?php include("resources/php/rodape.php") ?>