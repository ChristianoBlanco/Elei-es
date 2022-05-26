<?php

if(isset($_GET['id'])){
	$comissao = (int)$_GET['id'];
}else{
	$comissao = 1;
}
$serie = array();
$rsTotal = mysqli_query($con, "select * from cargos");
$rs1 = mysqli_query($con,"Select * from cargos where sequencia = ".$comissao);
$row1 = mysqli_fetch_array($rs1);
$rs = mysqli_query($con,"Select * from resultado where orgao = ".$row1['id']." order by votos desc");
while ($row = mysqli_fetch_array($rs)){	
	$serie[] =  array($row["NOME"],(int)$row["VOTOS"]);
}
?>
<div id="container"></div>
<div class="col-md-12">
<hr>
<?php

if (mysqli_num_rows($rs) > 0) {
	if($comissao > 1){
		$ant = $comissao - 1;
		if($comissao == 20)
			$ant--;

		echo '<a class="btn btn-default" href="?controle=projecao&id='.$ant.'">Voltar</a>';
	}

	if($comissao < mysqli_num_rows($rsTotal)){
		$prox = $comissao + 1;
		if($comissao == 18)
			$prox++;

		echo '<a class="btn btn-default pull-right" href="?controle=projecao&id='.$prox.'">Avançar</a>';
	}
} else {
	echo "<h3>Banco de dados vazio!</h3>";
}
?>
</div>
<script>
$('#container').highcharts({
			chart: {
				type: 'column'
			},
			title: {
				text: '<?php echo $row1['descricao'];?>'
			},
			subtitle: {
				text: 'Assembleia de Representantes <?= $ano ?>'
			},
			xAxis: {
				type: 'category',
				labels: {
					
					style: {
						fontSize: '12px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
			},
			yAxis: {
				min: 0,
				title: {
					text: 'votos'
				}
			},
			legend: {
				enabled: false
			},
			tooltip: {
				pointFormat: 'votos: <b>{point.y:.1f}</b>'
			},
			series: [{
				name: 'Candidatos',
				data: <?php echo json_encode($serie);?>,
				dataLabels: {
					enabled: true,
					rotation: -90,
					color: '#000000',
					align: 'right',
					x: 4,
					y: -20,
					style: {
						fontSize: '12px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
			}]
		});
    </script>