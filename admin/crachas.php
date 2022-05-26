<?php

	ini_set("memory_limit", "25M");
	ini_set("display_errors", "on");
	
	include ("../../_resources/php/conexao.php");
	include ("../../_resources/fpdf/fpdf.php");
	
	
$regionais = "SAERJ,SAESP,SAEB,SAEAL,ASSAEAM,SAEC,SADIF,SAES,SAEGO,SAEM,SAMG,SOMA,SAEMS,SAEPA,SAEPB,SPA,SAEPE,SAEPI,SAERN,SARGS,SAESC,SAESE,SAETO,DIRETORIA,DIR,SAEAC,SAEAP,RONDONIA";
$regionais = split(",",$regionais);

	
	$arquivo = 'arquivo.pdf';
	$pdf = new FPDF('L','mm',array(80,30));

	for($i=0;$i<=count($regionais)-1;$i++){
		$reg = $regionais[$i];
		if($reg == 'DIR'){
			$rs = mysqli_query($con1, "select SECRET2.matricula,PESSOA.nome,SECRET2.nome_prof,SECRET2.reg from cba.representantes inner join sbahq.SECRET2 on cba.representantes.matricula = sbahq.SECRET2.matricula inner join sbahq.PESSOA on SECRET2.id_pessoa = PESSOA.id_pessoa where SECRET2.matricula in (8500,7522,9339,6458,8067,14169,8856,5925) order by nome");
		}else{
			$rs = mysqli_query($con1, "select SECRET2.matricula,PESSOA.nome,SECRET2.nome_prof,SECRET2.reg from cba.representantes inner join sbahq.SECRET2 on cba.representantes.matricula = sbahq.SECRET2.matricula inner join sbahq.PESSOA on SECRET2.id_pessoa = PESSOA.id_pessoa where SECRET2.reg = '".$reg."' order by reg,nome");	
		}
	
	$pdf->AddPage();
	$pdf->SetMargins(1,1);
	$pdf->SetAutoPageBreak(0,0);
	$pdf->SetFont('Arial','',20);
	
	print mysqli_error($con1);
	while($rw = mysqli_fetch_array($rs)){
		$pdf->AddPage();
		$pdf->SetMargins(1,1);
		$pdf->SetAutoPageBreak(0,0);
		if(empty($rw['nome_prof'])){
			$nome = explode(" ", mb_strtoupper($rw['nome'],'utf-8'));
			$cracha = $nome[0].' '.$nome[count($nome)-1];
		}else{
			$cracha = mb_strtoupper($rw['nome_prof'],'utf-8');	
		}
		
		
		$pdf->SetFont('Arial','',20);
		$pdf->Cell(0,10,utf8_decode($cracha),0,1,'C');
		$pdf->SetFont('Arial','',12);
		if($rw['matricula']== 5925){
			$pdf->Cell(0,4,'SUP',0,1,'C');
		}else{
			$pdf->Cell(0,4, utf8_decode($reg),0,1,'C');	
		}
		
		$pdf->SetFont('Arial','B',12);			
		$pdf->Cell(0,4,'',0,1,'C');				
		$pdf->Cell(0,1,'',0,1,'C');
		$pdf->Image("http://".$_SERVER['HTTP_HOST']."/_resources/php/php-barcode.php?text=codetype=Code39&text=".str_pad($rw['matricula'], 5, "0", STR_PAD_LEFT),25,null,0,0,"png");
		}
	}
$pdf->Output($arquivo, "I");