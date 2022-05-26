<?php
  include ("resources/php/valida.php");
  include ("resources/php/conexao.php");
  include ("resources/fpdf/fpdf.php");
  
  $con = conexao('eleicaosba');
  $id_voto = $_SESSION['id_voto'];
  
  $rs = mysqli_query($con, "select * from VOTOS where id = ".$id_voto);
  print mysqli_error($con);
  if(mysqli_num_rows($rs) > 0){
	  $rw = mysqli_fetch_assoc($rs);

	  $rs2 = mysqli_query($con, "select * from VOTANTES where matricula = ".$matricula);
	  $rw2 = mysqli_fetch_assoc($rs2);
	  
	  $pdf = new FPDF('P','mm','A4');
  	  $pdf->AddPage();
	  $pdf->SetTopMargin(20);
	  $pdf->Rect(5,5,200,285,'D');
	  $pdf->Image('resources/images/logomarca.jpg',70,35,66,32,'JPG',0);
	  $pdf->Ln(85);
	  $pdf->SetFont('Helvetica','B',16);
	  $pdf->Cell(0,8,utf8_decode('COMPROVANTE DE VOTAÇÃO'),0,1,'C',0,0);
	  $pdf->SetFont('Helvetica','',12);
	  $pdf->Ln(20);
	  
	  $txt1 = '     Este documento garante que você concluiu com sucesso o processo de votação online da Sociedade Brasileira de Anestesiologia com a matrícula '.$matricula.' no dia '. date('d/m/Y', strtotime($rw2['ENVIO'])).' às '.date('H:s:i', strtotime($rw2['ENVIO'])).'.';
	  $txt2 = '     Não existe nenhum vículo entre o registro de votação e o registro de idenficação do seu voto, que é anônimo.';
	  $txt3 = '     Garantimos a confidencialidade do seu voto. Somente o votante poderá identificar este código como seu, assim sendo, sugerimos que guarde este PDF, caso necessite no futuro';
	  
	  $pdf->MultiCell(0,8,utf8_decode($txt1),0,"J");
	  $pdf->MultiCell(0,8,utf8_decode($txt2),0,"J");
	  $pdf->MultiCell(0,8,utf8_decode($txt3),0,"J");
	  
	  $pdf->SetFont('Helvetica','',16);
	  $pdf->Ln(25);
	  $pdf->SetFillColor(169,251,196);
	  $pdf->SetTextColor(131,18,20);
	  $pdf->Cell(0,30,utf8_decode($rw['comprovante']),0,1,'C',1,0);
	  
	  $pdf->Output('file.pdf',"I");
	  
  }else{
	 print 'Voto não encontrado'; 
  }