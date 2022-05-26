<?php 

  ini_set("display_errors","on");

  include("../resources/php/header_adm.php");
  include("../resources/php/conexao.php");
  include("logon.php");

  $con = conexao('ELEICAOCARGOS');
  
  $controle = isset($_GET['controle']) ? mysqli_real_escape_string($con, $_GET['controle']) : header("location:?controle=cabine");
  $tipo = isset($_GET['tipo']) ? mysqli_real_escape_string($con, $_GET['tipo']) : 'listar';
  $cargo = isset($_GET['cargo']) ? (int)$_GET['tipo'] : 0;
  $ano = date("Y");

?>
<style>
#cedula label{
	padding: 15px 10px;
	font-size: 12pt;
}

#cedula label:hover{
	background:#E0E0E0;
}

.nome{
	color: #fff;
	display: block;
	padding: 5px 0px;
}

</style>
  <div class="row">
    <div class="btn-group menu">
      <a href="?controle=cabine" class="btn cabine"><i class="glyphicon glyphicon-cog"></i> <br> cabines</a>
      <a href="?controle=candidato" class="btn candidato"><i class="glyphicon glyphicon-th-list"></i> <br> Candidatos</a>
      <a href="?controle=cargos" class="btn cargo"><i class="glyphicon glyphicon-briefcase"></i> <br> Cargos</a>
      <a href="?controle=projecao" class="btn projecao"><i class="glyphicon glyphicon-calendar"></i> <br> Projeção</a>
	  <a href="?controle=apuracao" class="btn apuracao"><i class="glyphicon glyphicon-stats"></i> <br> Apuração</a>
	</div>
	<a href="logoff.php" class="btn" style="margin-left:700px;"><i class="glyphicon glyphicon-arrow-right"></i> <br> Sair</a>
  </div>
 
  <div class="row">
    <div class="col-md-12">  <hr> </div>
	<?php
	switch($controle){
		case "cabine":?>

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<button class="btn btn-success nova-cabine">Nova cabine</button>
				</div>
				<div class="col-md-12">  <hr> </div>
			</div>
			<div class="row"><?php include("cabines.php"); ?> </div>
<?php		break;
	    case "apuracao":
			include("apuracao.php");
			break;
		case "projecao":
			include("projecao.php");
			break;
		case "candidato":
			include("form_candidatos.php");
			break;
		case "cargos":
			include("form_cargos.php");
			break;
		default: "";
	}
	?>
  </div>

<script type="text/javascript">
$(document).ready(function(e) {
	var ano = <?php print date("Y") ?>;
	$(".menu .apuracao, .menu .cabine, .menu .projecao, .menu .candidato, .menu .cargo, .menu .edit, .menu .listar, .menu .novo, .menu .cargoss").addClass("btn-default");	
	$(".menu .<?php print $controle ?>").removeClass("btn-default").addClass("btn-primary");
	
	$(document).on("click",".cab", function(){
		$.ajax({
			url:"verifica_votante.php",
			data: "tipo=cabine&cabine="+$(this).attr("cabine"),
			dataType:"JSON",
			type: "POST",
			success: function(e){
				alert(e);
				$("#busca_voto_online .reset").trigger("click");
			}
		});
	});
	
	$(document).on("click",".lalocar", function(){
		cabines = $(this).parents(".cabines");
		var i = cabines.find('.form-control').val();
		var c = cabines.find('.lalocar').attr('valor');
		$.ajax({
			url:"libera_alocar.php",
			data: "cabine="+c+"&ip="+i,
			dataType:"JSON",
			type: "POST",
			success: function(e){
				alert(e);
			}
		});
	});

	$(document).on("click", ".nova-cabine", function() {
		$.ajax({
			url:"nova-cabine.php",
			dataType:"JSON",
			type: "POST",
			success: function(e){
				if (e === true) {
					
					location.reload()
				} else {

					alert("Erro ao criar nova cabine!");
				}
			},
			error: function(e){
				alert("Erro ao criar nova cabine!");
			}
		});
	});
});
</script>