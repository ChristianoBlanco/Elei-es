<?php include ("resources/php/conexao.php"); ?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Controle de eleições</title>
<link rel="stylesheet" type="text/css" href="/resources/css/CSSreset.min.css">
<link rel="stylesheet" type="text/css" href="/resources/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="/resources/css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="/resources/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/resources/css/bootstrap.css">
<script src="/resources/js/jquery-2.1.1.min.js"></script>
<script src="resources/js/bootstrap.min.js"></script>
<script src="resources/js/bootbox.min.js"></script>
<style>
.topo {	background: #244224 !important;	margin: 0px 0px 10px 0px !important;}
.rodape { background: #244224; width: 100%;	color: #fff; }
.rodape h5 { display: block; text-align:center;	padding: 10px 0px; }
table{ border: 1px solid #A9A9A9 !important; margin: 2px !important; }
table th{ background:#DCDCDC; border-top: 1px solid #A9A9A9 !important;	border-bottom: 1px solid #A9A9A9 !important; padding: 3px 5px !important;}
table th.vagas{ text-align: right !important; width: 75px; }
table td { padding: 0px !important; }
label input { position: relative; top: -3px;}
label {
	font-size: 16pt;
	padding: 5px 15px;
	display: block;
	margin: 0px;
}
label:hover {
	background: #EFEFEF;
}
label input {
	width: 25px;
	height: 25px;
	margin-bottom: 11px;
}
</style>
<body>
<div class="row topo">
 <div class="container">
   <div class="col-md-3"><img src="resources/images/logo-rodape.png"/></div><div class="col-md-9"><h2 style="color: white;">Cédula Eleitoral Assembléia de Representantes / <?php print date("Y") - 'Distrito Federal' ?> </h2></div>
 </div>
</div>
<?php
 $con = conexao('ELEICAOCARGOS');
?>

<div class="container">
  <div class="row">
  <div class="col-md-12">&nbsp;</div>
  <div class="col-md-12">&nbsp;</div>
  <div class="col-md-12">&nbsp;</div>
    <form class="form-horizontal" action="computa_voto.php" method="post" id="voto">
       <input type="hidden" name="voto" value="2">
        <?php 
	    $cargo = !empty($_GET['cargo']) ? (int)$_GET['cargo'] : 1 ;
	 	$rs = mysqli_query($con, "select * from CARGOS where id = ".$cargo);
		$rw = mysqli_fetch_assoc($rs)
		?>
        <div class="row">
        <div class="col-md-12">
           <h2><?php print $rw['descricao'] ?></h2>
           <hr>	
        </div>
        </div>
		<?php
          $rs1 = mysqli_query($con, "select * from CANDIDATOS where cargo = ".$rw['id']);
          while($rw1 = mysqli_fetch_assoc($rs1)){
        ?>
        <label class="chapa">
          <input type="checkbox" name="campo" value="<?php print $rw1['cod_campo'] ?>"> <strong> <?php print $rw1['nome'] ?> </strong>
          <input type="hidden" name="cargo" value="<?php print $cargo ?>">
        </label>
        <?php
              
          }
        ?>
        <div class="col-md-12">&nbsp;</div>
        <div class="col-md-12">&nbsp;</div>
        <div class="col-md-12">&nbsp;</div>
        <div class="col-md-12"><button class="btn btn-primary">Confirmar</button></div>
    </form>
  </div>
</div>
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