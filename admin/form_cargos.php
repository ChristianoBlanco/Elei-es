<div class="col-md-2">
    <div class="btn-group-vertical menu">
      <a href="?controle=cargos&tipo=novo" class="btn novo"><i class="glyphicon glyphicon-stats"></i> Novo cargo</a>
      <a href="?controle=cargos&tipo=listar" class="btn listar"><i class="glyphicon glyphicon-cog"></i> Listar cargos</a>
    </div>
  </div>
  <div class="col-md-10">
<?php
if($tipo != 'listar'){
	if(isset($cargo) && $cargo != 0){
		$id = (int)$_GET['cargo'];
		$rs = mysqli_query($con, "select * from cargos where id = ".$id);
		$rw = mysqli_fetch_assoc($rs);
		form($rw['descricao'],$rw['vagas'],$rw['sequencia'],$tipo,$id);
	}else{
		if($tipo == 'novo'){
			$id = (int)0;
			form('',0,0,$tipo,$id);
		}else{
			$id = (int)$_GET['cargo'];
			$rs = mysqli_query($con, "select * from cargos where id = ".$id);
			$rw = mysqli_fetch_assoc($rs);
			form($rw['descricao'],$rw['vagas'],$rw['sequencia'],$tipo,$id);
		}
	}
	
}else{
	$nome = isset($_GET['nome']) ? mysqli_real_escape_string($con, $_GET['nome']) : '';
	$rs = mysqli_query($con, "select * from cargos where descricao like '%".$nome."%' order by sequencia");
	if(mysqli_num_rows($rs) > 0){
		$html = '<table class="table table-striped" id="table">';
		$html .= '<thead>';
		$html .= '<tr><th></th><th></th><th>Descricao</th><th>Vagas</th><th>Sequencia<th></tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		while($rw = mysqli_fetch_assoc($rs)){
			$html .= '<tr valor="'.$rw['id'].'">';
			$html .= '<td width="1"><a href="?controle=cargos&tipo=edit&cargo='.$rw['id'].'"><i class="glyphicon glyphicon-edit"></i></a></td>';
			$html .= '<td width="1"><a href="javascript:void(0);" valor="'.$rw['id'].'" class="excluir"><i class="glyphicon glyphicon-trash"></i></a></td>';
			$html .= '<td>'.$rw['descricao'].'</td>';
			$html .= '<td>'.$rw['vagas'].'</td>';
			$html .= '<td>'.$rw['sequencia'].'</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '<tfoot></tfoot>';
		$html .= '</table>';
	}else{
		$html = "Nenhum candidato encontrado!";
	}
	
	print $html;
}
?>
</div>

<?php
function form($descricao,$vaga,$sequencia,$tipo,$id){
	global $con, $controle;
?>
 <form method="post" class="form-horizontal" action="grava_cargos.php">
   <input type="hidden" name="tipo" value="<?php print $tipo ?>">
   <input type="hidden" name="id" value="<?php print $id ?>">
 	<div class="form-group">
    	<div class="col-md-5">
        	<label>Descricao</label>
        	<input class="form-control" name="descricao" value="<?php print $descricao ?>">
        </div>
        <div class="col-md-3">
        	<label>Vagas</label>
        	<input class="form-control" name="vagas" value="<?php print $vaga ?>">
        </div>
        <div class="col-md-3">
        	<label>Sequencia</label>
           	<input class="form-control" name="sequencia" value="<?php print $sequencia ?>">
        </div>
        <div class="col-md-1" style="margin-top: 23px;"><input class="btn btn-success" type="submit" value="Enviar"></div>
    </div>
 </form>
 <?php 
}
 ?>
 <script>
 $(document).ready(function(e) {
	 $(".menu .<?php print $tipo?>").removeClass("btn-default").addClass("btn-primary");
    $(document).on("click",".excluir", function(){
		if(confirm("Deseja excluir este cargo?")){
			$.ajax({
				url:"excluir.php",
				data: 'tipo=cargos&id='+$(this).attr("valor"),
				dataType:"json",
				type: 'POST',
				success: function(e){
					alert(e);
					location.reload();
				}
			});
		}
	});
	
	$('tbody').sortable({
		update: function(){
			var valores = new Array();
			$(this).find('tr').each(function(index, element) {
                valores.push($(this).attr("valor"));
            });
			$.ajax({
				url:"grava_cargos.php",
				type:"POST",
				dataType:"json",
				data:'tipo=sequencia&lista='+valores.toString(),
				success: function(data){
					location.reload();
				}
			});
		}
	});
});
 </script>