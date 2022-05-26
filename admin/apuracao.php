<?php

$rs = mysqli_query($con,"Select R1 from votos");
$total = mysqli_num_rows($rs);	
			

if($total > 0){
	$rs = mysqli_query($con,"delete from resultado ");
	
	echo '<table class="table">';
	$rs = mysqli_query($con,"Select * from cargos order by sequencia");
	
	while ($row = mysqli_fetch_array($rs)){		
		echo '<thead><tr><th colspan="2">'.$row['descricao'].'</th></tr></thead>';
		$rs1 = mysqli_query($con,"Select * from candidatos where cargo = ".$row['id']);
				
		if(mysqli_num_rows($rs1) > $row['vagas']){ //DISPUTA
			
			while($row1 = mysqli_fetch_array($rs1)){
			
				$rs2 = mysqli_query($con,"Select count(R1) as total from votos where ".$row1['cod_campo']." = 1");
				$row2 = mysqli_fetch_array($rs2);
				echo '<tr><td>'.$row1['nome'].' <span class="badge">'.$row2['total'].' votos</span></td><td width="50%">'.barra($row2['total'],$total,'primary').'</td></tr>';
				$rs3 = mysqli_query($con,"Insert into resultado (ORGAO,NOME,VOTOS) values (".$row['id'].",'".$row1['nome']."',".$row2['total'].")");
				$rs2 = mysqli_query($con,"Select count(R1) as total from votos where ".$row1['cod_campo']." = 2"); //NULO
				$row2 = mysqli_fetch_array($rs2);
				$nulo = $row2['total'];
				$rs2 = mysqli_query($con,"Select count(R1) as total from votos where ".$row1['cod_campo']." = 3"); //BRANCO
				$row2 = mysqli_fetch_array($rs2);
				$branco = $row2['total'];
	
			}
			echo '<tr><td>Brancos <span class="badge">'.$branco.' votos</span></td><td>'.barra($branco,$total,'danger').'</td></tr>';
			$rs3 = mysqli_query($con,"Insert into resultado (ORGAO,NOME,VOTOS) values (".$row['id'].",'Brancos',".$branco.")");
			echo '<tr><td>Nulos <span class="badge">'.$nulo.' votos</span></td><td>'.barra($nulo,$total,'danger').'</td></tr>';
			$rs3 = mysqli_query($con,"Insert into resultado (ORGAO,NOME,VOTOS) values (".$row['id'].",'Nulos',".$nulo.")");
						
		}else{
			if($row['vagas']>1){ //CALCULO DE votos EM BRANCO DIFERENTE
				while($row1 = mysqli_fetch_array($rs1)){
					
					$rs2 = mysqli_query($con,"Select count(R1) as total from votos where ".$row1['cod_campo']." = 1");
					$row2 = mysqli_fetch_array($rs2);
					echo '<tr><td>'.$row1['nome'].' <span class="badge">'.$row2['total'].' votos</span></td><td>'.barra($row2['total'],$total,'primary').'</td></tr>';
					$rs3 = mysqli_query($con,"Insert into resultado (ORGAO,NOME,VOTOS) values (".$row['id'].",'".$row1['nome']."',".$row2['total'].")");
					$rs2 = mysqli_query($con,"Select count(R1) as total from votos where ".$row1['cod_campo']." = 3"); //BRANCO
					$row2 = mysqli_fetch_array($rs2);
					$branco = $row2['total'];
				}
				echo '<tr><td>Brancos <span class="badge">'.$branco.' votos</span></td><td>'.barra($branco,$total,'danger').'</td></tr>';
				$rs3 = mysqli_query($con,"Insert into resultado (ORGAO,NOME,VOTOS) values (".$row['id'].",'Brancos',".$branco.")");
			}else{
				$row1 = mysqli_fetch_array($rs1);
				$rs2 = mysqli_query($con,"Select R1 from votos where ".$row1['cod_campo']." = 1");
				echo '<tr><td>'.$row1['nome'].' <span class="badge">'.mysqli_num_rows($rs2).' votos</span></td><td>'.barra(mysqli_num_rows($rs2),$total,'primary').'</td></tr>';
				$rs3 = mysqli_query($con,"Insert into resultado (ORGAO,NOME,VOTOS) values (".$row['id'].",'".$row1['nome']."',".mysqli_num_rows($rs2).")");
				$rs2 = mysqli_query($con,"Select R1 from votos where ".$row1['cod_campo']." = 0");
				echo '<tr><td>Brancos <span class="badge">'.mysqli_num_rows($rs2).' votos</span></td><td>'.barra(mysqli_num_rows($rs2),$total,'danger').'</td></tr>';
				$rs3 = mysqli_query($con,"Insert into resultado (ORGAO,NOME,VOTOS) values (".$row['id'].",'Brancos',".mysqli_num_rows($rs2).")");

			}
	
		}
	}
}else{
	echo "<p>Ocorreu um erro, banco de dados vazio!</p>";	
}
?>


</table>

<?php
function barra($valor,$total,$cor){
	global $con;
	$rs = mysqli_query($con, "select count(R1) as total from votos");
	$rw = mysqli_fetch_assoc($rs);
	$total = $rw['total'] == 0 ? 1 : $rw['total'];	

	$perc = number_format(($valor/$total)*100,2);
	$barra = '<div class="progress">';
	$barra .= '<div class="progress-bar progress-bar-'.$cor.' progress-bar-striped" role="progressbar" aria-valuenow="'.$perc.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$perc.'%">';
    	//$barra .= $perc.'% ('.$valor.' votos)';
	$barra .= '('.$valor.' votos)';
  	$barra .= '</div>';
	$barra .= '</div>';
	
	return $barra;	
}
