<?php

 include("resources/php/header.php");
 include("resources/php/conexao.php");
 include("logon.php");
 $con = conexao('eleicaocargos');
 //$rs = mysqli_query($con, "select * from cabines where cabine = ".$_COOKIE['cabine']." and status = 1");
 $rs = mysqli_query($con, "select * from votantes where id = ".$id." and status_votante = 1");
 if(mysqli_num_rows($rs) > 0){
	 header("location:logoffVoto.php");
 }
?>
<a href="logoff.php" class=" text-left btn btn-sm btn-primary conf" style="margin-left:25px;">Sair</a>
<br/><br/>
<div class="container-fluid">
<div class="row">
   <form class="form-horizontal" action="computa_voto.php" method="post" id="voto">
       <div class="col-md-4 col-sm-4 col-xs-4">
       <?php 
	 	$rs = mysqli_query($con, "select * from cargos where sequencia BETWEEN 1 and 6 order by sequencia");
		while($rw = mysqli_fetch_assoc($rs)){
		?>
              <table class="table">
              <tr><th><?php print $rw['descricao']?></th><th class="vagas <?= verificaDisputa($con, $rw['id']) ? 'disputa' : '' ?>"> <?php print $rw['vagas'] >  1 ?  $rw['vagas'].' Vagas' : $rw['vagas'].' Vaga'?></th></tr>
              <tr>
            <td colspan="2">
        <?php
			$rs1 = mysqli_query($con, "select * from candidatos where cargo = ".$rw['id']." order by cargo,nome");
			while($rw1 = mysqli_fetch_assoc($rs1)){
		?>
        	  <label>
                 <input type="checkbox" name="<?php print $rw1['cod_campo'] ?>" value="<?php print $rw1['cargo'] ?>"> <?php print $rw1['nome']?>
              </label>
        <?php
			}
		?>
        </td>
          </tr>
            </table>
        <?php
		}
	   ?>
       </div>
       <div class="col-md-4 col-sm-4 col-xs-4">
       <?php 
	 	$rs = mysqli_query($con, "select * from cargos where sequencia BETWEEN 7 and 15 order by sequencia");
		while($rw = mysqli_fetch_assoc($rs)){
		?>
              <table class="table">
              <tr><th><?php print $rw['descricao']?></th><th  class="vagas <?= verificaDisputa($con, $rw['id']) ? 'disputa' : '' ?>"> <?php print $rw['vagas'] >  1 ?  $rw['vagas'].' Vagas' : $rw['vagas'].' Vaga'?></th></tr>
              <tr>
            <td colspan="2">
        <?php
			$rs1 = mysqli_query($con, "select * from candidatos where cargo = ".$rw['id']." order by cargo,nome");
			while($rw1 = mysqli_fetch_assoc($rs1)){
		?>
        	 <label>
                 <input type="checkbox" name="<?php print $rw1['cod_campo'] ?>" value="<?php print $rw1['cargo'] ?>"> <?php print $rw1['nome']?>
              </label>
        <?php
			}
		?>
        </td>
          </tr>
            </table>
        <?php
		}
	   ?>
       <div><button class="btn btn-primary btn-block conf" type="submit">Confirmar</button></div>
       </div>
       
      <div class="col-md-4 col-sm-4 col-xs-4">
       <?php 
	 	$rs = mysqli_query($con, "select * from cargos where sequencia BETWEEN 16 and 30 order by sequencia");
		while($rw = mysqli_fetch_assoc($rs)){
		?>
              <table class="table">
              <tr><th><?php print $rw['descricao']?></th><th class="vagas <?= verificaDisputa($con, $rw['id']) ? 'disputa' : '' ?>"> <?php print $rw['vagas'] >  1 ?  $rw['vagas'].' Vagas' : $rw['vagas'].' Vaga'?></th></tr>
              <tr>
            <td colspan="2">
        <?php
			$rs1 = mysqli_query($con, "select * from candidatos where cargo = ".$rw['id']." order by cargo,nome");
			while($rw1 = mysqli_fetch_assoc($rs1)){
		?>
        	  <label>
                 <input type="checkbox" name="<?php print $rw1['cod_campo'] ?>" value="<?php print $rw1['cargo'] ?>"> <?php print $rw1['nome']?>
              </label>
        <?php
			}
		?>
        </td>
          </tr>
            </table>
        <?php
		}
	   ?>
       </div>
   </form>
</div>
</div>
<?php

	function verificaDisputa($con, $cargo){
		$rsCargos = mysqli_query($con, "select * from cargos where id = {$cargo}");
		$rw = mysqli_fetch_assoc($rsCargos);
		$rs = mysqli_query($con, "select * from candidatos where cargo = {$cargo}");
		if( mysqli_num_rows($rs) > $rw['vagas']){
			return true;
		}
		return false;
	}
?>


<script type="text/javascript">
$(document).ready(function(e) {
	var button = 0;
	$(document).on('click', 'button[name=botao]', function(){
		button = $(this);
		var tipo = 0;
		var cont = 0;
		var msg = "Você está votando em CHAPA ÚNICA deseja confirmar seu voto?";
		if(button.attr("value") > 0){
			$("input[type=checkbox]").each(function(index, element) { 
				if($(this).is(":checked") == false){
					cont++;
					msg = 'Por favor escolha uma chapa para votar.';
					tipo = 1;
				}
			});
			
		}else
			if(button.attr("value") == 0){
				msg = 'Você está votando NULO! \n Deseja confirmar seu voto?';
			}else{
				msg = 'Você está votando em BRANCO! \n Deseja confirmar seu voto?';
			}
		if(tipo != 1){
			bootbox.confirm({
				message: '<h3 class="text-center">'+msg+'</h3>',
				buttons: {
					confirm: {
						label: 'Sim',
						className: 'btn-success'
					},
					cancel: {
						label: 'Não',
						className: 'btn-danger'
					}
				},
				callback: function (result) {
					if(result == true){
						$("form").submit();
					}
				}
		    });
		}else{
			bootbox.alert('<h3 class="text-center">'+msg+'</h3>');
		}
});
$(document).on("submit","form", function(){
	var form = $(this);
		$.ajax({
			url:form.attr("action"),
			type: "POST",
			dataType:"json",
			data: 'botao='+button.val()+'&opcao='+$("input[type=checkbox]").val(),
			success: function(data){
				if(data == 1){
					bootbox.alert({
						size: "small",
						title: "Alert",
						message: '<h3 class="text-center">Voto computado com sucesso!</h3>',
						callback: function(result){
							if(result == true){
								location.reload();
							}else{
								location.reload();
							}
						}
						});
				}else{
					bootbox.alert({
						size: "small",
						title: "Alert",
						message: '<h3 class="text-center">Voto computado com sucesso!</h3>',
						callback: function(result){
							if(result == true){
								location.reload();
							}else{
								location.reload();
							}
						}
					});
				}
			}
		});
		return false;
	});
});
</script>