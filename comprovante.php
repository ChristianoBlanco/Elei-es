<?php
  include ("resources/php/valida.php");
  include ("resources/php/header.php");
  include ("resources/php/conexao.php");
  
//  $con = conexao('eleicaosba');
$con = conexao('ELEICAOSBA');
  $id_voto = $_SESSION['id_voto'];
  
  $rs2 = mysqli_query($con, "select * from VOTOS where id = ".$id_voto);
  $rw2 = mysqli_fetch_assoc($rs2);
  
  if($rw2['comprovante'] == ''){
	  $rs = mysqli_query($con, "select NOME from VOTANTES where matricula = ".$matricula);
	  $rw = mysqli_fetch_assoc($rs);
	  
	  $comprovante = md5($rw['NOME'].time().'sba'.date("Y").$matricula);
	  $_SESSION['controle'] = 'Comprovante';
	  $id_voto = $_SESSION['id_voto'];
	  
	  mysqli_query($con, "update VOTANTES set ENVIO = NOW() where matricula = ".$matricula);
	  mysqli_query($con, "update VOTOS set comprovante = '".$comprovante."' where id = ".$id_voto);
  }else{
	$comprovante = $rw2['comprovante']; 
  }
?>
<div style="min-height: 500px;">
    <div class="col-md-12">
      <h1 class="text-center">Código do comprovante de votação</h1>
    </div>
    <div class="alert alert-success">
      <h1 class="text-center text-danger"><?php print $comprovante ?></h1><br>
    </div>
    <div class="col-md-4">
       <h1 class="text-center"><a href="finaliza.php" class="btn btn-success btn-lg btn-block">Finalizar</a></h1>
    </div>
    <div class="col-md-4">
       <h1 class="text-center"><a href="pdf.php" class="btn btn-info btn-lg btn-block" target="_blank">Gerar PDF</a></h1>
    </div>
    <div class="col-md-4">
       <h1 class="text-center"><a href="javascript:void(0);" class="btn btn-primary btn-lg btn-block email">Enviar por E-mail</a></h1>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="mymodal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Comprovante</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="form-comprovante" action="email.php" method="post">
          <h4>Digite o e-mail que o comprovante deve ser enviado:</h4>
          <div class="input-group" style="padding-bottom: 30px;">
              <input type="text" name="email" class="form-control">
            <span class="input-group-btn">
              <button type="submit" class="btn-success btn">Enviar</button>
            </span>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(e) {
    $(document).on("click",".email", function(){
		$("#mymodal").modal();
	});
	
	$("#form-comprovante").submit(function(){
		var form = $(this);
		$.ajax({
			url: form.attr("action"),
			type: form.attr("method"),
			dataType:"json",
			data: form.serialize(),
			success: function(e){
				if(e == true){ msg = 'Comprovante enviado com sucesso!'}else{ msg = 'Erro ao enviar o comprovante!' }
				alert(msg);
				$("#mymodal").modal('hide');
			}
		});
		return false;
	});
});
</script>
<?php include ("resources/php/rodape.php");?>