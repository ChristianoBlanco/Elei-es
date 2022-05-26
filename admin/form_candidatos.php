<div class="col-md-2">
    <div class="btn-group-vertical menu">
      <a href="?controle=candidato&tipo=novo" class="btn novo"><i class="glyphicon glyphicon-stats"></i> Novo candidato</a>
      <a href="?controle=candidato&tipo=listar" class="btn listar"><i class="glyphicon glyphicon-cog"></i> Listar candidatos</a>
    </div>
  </div>
  <div class="col-md-10">
<?php
if($tipo != 'listar'){
	if(isset($_GET['id_cand']) && $_GET['id_cand'] != 0){
		$id = (int)$_GET['id_cand'];
		$rs = mysqli_query($con, "select * from candidatos where id = ".$id);
		$rw = mysqli_fetch_assoc($rs);
		form($rw['nome'],$rw['cargo'],$rw['cod_campo'],$tipo,$id);
	}else{
		if($tipo == 'novo'){
			$id = (int)0;
			form('',0,0,$tipo,$id);
		}
	}
}else{
	$nome = isset($_GET['nome']) ? mysqli_real_escape_string($con, $_GET['nome']) : '';
	$rs = mysqli_query($con, "select * from candidatos where nome like '%".$nome."%' order by cargo,nome");
	if(mysqli_num_rows($rs) > 0){
		$html = '<table class="table table-striped">';
		$html .= '<tr><th></th><th></th><th>Nome</th><th>Cargo</th><th>Campo<th></tr>';
		while($rw = mysqli_fetch_assoc($rs)){
			$html .= '<tr>';
			$html .= '<td width="1"><a href="?controle=candidato&tipo=edit&id_cand='.$rw['id'].'"><i class="glyphicon glyphicon-edit"></i></a></td>';
			$html .= '<td width="1"><a href="javascript:void(0);" valor="'.$rw['id'].'" class="excluir"><i class="glyphicon glyphicon-trash"></i></a></td>';
			$html .= '<td>'.$rw['nome'].'</td>';
			$html .= '<td>'.cargo($rw['cargo'],$con).'</td>';
			$html .= '<td>'.$rw['cod_campo'].'</td>';
			$html .= '</tr>';
		}
		$html .= '</table>';
	}else{
		$html = "Nenhum candidato encontrado!";
	}
	
	print $html;
}
?>
</div>

<?php
function form($nome,$cargo,$campo,$tipo,$id){
	global $con;
?>
 <form method="post" class="form-horizontal" action="grava_candidato.php">
   <input type="hidden" name="tipo" value="<?php print $tipo ?>">
   <input type="hidden" name="id" value="<?php print $id ?>">
 	<div class="form-group">
    	<div class="col-md-5">
        	<label>Candidato</label>
        	<input class="form-control" name="nome" value="<?php print $nome ?>">
        </div>
        <div class="col-md-3">
        	<label>Cargo</label>
        	<select class="form-control" name="cargo">
            <?php
			$rs = mysqli_query($con, "select * from cargos order by sequencia");
			while($rw = mysqli_fetch_assoc($rs)){
				if($rw['id'] == $cargo){
			?>
            <option value="<?php print $rw['id'] ?>" selected><?php print $rw['descricao']?></option>
            <?php
				}else{
			?>
            <option value="<?php print $rw['id'] ?>"><?php print $rw['descricao']?></option>
            <?php	
				}
			}
			?>
            </select>
        </div>
        <div class="col-md-3">
           	<label>Cod Campo</label>
            <?php
			$rs = mysqli_query($con, "select * from candidatos order by nome");
			print mysqli_error($con);
			if( mysqli_num_rows($rs) > 0){
				while($rw = mysqli_fetch_assoc($rs)){
					$c3[] = $rw['cod_campo'];
				}
			}else{
				$c3[] = '';
			}
			
			if($tipo != 'edit'){
				$rs = mysqli_query($con, "select * from votos");
				$c = mysqli_fetch_fields($rs);		
				foreach($c as $item){
					$c2[] = $item->name;
				}
				
				$c4 = array_diff($c2,$c3);
			}else{
				$c4 = $c3;
			}
            ?>
        	<select class="form-control" name="campo">
            <?php
			foreach($c4 as $item){
			  if($item == $campo){
			?>
            <option value="<?php print $item ?>" selected><?php print $item ?></option>
            <?php
				}else{
			?>
            <option value="<?php print $item ?>"><?php print $item ?></option>
            <?php	
				}
			}
			?>
            </select>
        </div>
        <div class="col-md-1" style="margin-top: 23px;"><input class="btn btn-success" type="submit" value="Enviar"></div>
    </div>
 </form>
 <?php 
}

function cargo($i,$con){
	$rs = mysqli_query($con, "select * from cargos where id = ".$i);
	
	$rw = mysqli_fetch_assoc($rs);
	
	return $rw['descricao'];
}
 ?>
 <script>
 $(document).ready(function(e) {
	 $(".menu .<?php print $tipo?>").removeClass("btn-default").addClass("btn-primary");
    $(document).on("click",".excluir", function(){
		if(confirm("Deseja excluir este candidato?")){
			$.ajax({
				url:"excluir.php",
				data: 'tipo=candidato&id='+$(this).attr("valor"),
				dataType:"json",
				type: 'POST',
				success: function(e){
					alert(e);
					location.reload();
				}
			});
		}
	});
});
 </script>