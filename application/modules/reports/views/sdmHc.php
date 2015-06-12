<?php
//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */

// Include the main TCPDF library (search for installation path).
$this->load->library('Pdf');

// create new PDF document
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set margins
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// ---------------------------------------------------------

// add a page
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 8);

$puskesmas = '<p style="text-transform:uppercase;">'.$namaPuskesmas.'</p>';
$pdf->writeHTML($puskesmas, true, false, false, false, '');

$header = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
	<tr align="center">
        <td width="6%">No. URUT</td>
        <td width="15%">NIK</td>
        <td width="25%">NAMA</td>
        <td width="15%">JABATAN</td>
        <td width="15%">PANGKAT</td>
        <td width="10%">GOLONGAN</td>
        <td width="10%">STATUS PEGAWAI</td>
    </tr>
	<tr align="center" style="background-color:'grey'">
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
    </tr>
EOD;

$content = "";
$i=0;
if(isset($allSDM)){
foreach($allSDM as $sdm)
	{
	$i +=1;
	$row ="
	<tr>
			 <td >".$i."</td>
			 <td >".$sdm['NIK']."</td>
			 <td >".$sdm['NAMA']."</td>
			 <td >".$sdm['JABATAN']."</td>
			 <td >".$sdm['PANGKAT']."</td>
			 <td >".$sdm['GOLONGAN']."</td>
			 <td >".$sdm['STATUS_PEGAWAI']."</td>
		</tr>";
	$content= $content.$row;
	}
}
else
{
	$i +=1;
$row ="
	<tr>
			 <td >".$i."</td>
			 <td >-</td>
			 <td >-</td>
			 <td >-</td>
			 <td >-</td>
			 <td >-</td>
			 <td >-</td>
		</tr>";
	$content= $content.$row;
}

$close = "</table>";

$tbl = $header.$content.$close;
$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
