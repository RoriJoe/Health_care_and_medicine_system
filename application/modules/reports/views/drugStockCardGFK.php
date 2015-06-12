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

$tbl = '
<b>
<table >
<tr align="center">
	<td>
		<u>LAPORAN DATA STOK GUDANG OBAT</u>
	</td>
</tr>
<tr align="center">
	<td>
		UNIT
	</td>
</tr>
<tr>
	<td>
	Dari : '.$dari.'
	</td>
</tr>
<tr>
	<td>
	Hingga : '.$hingga.' 
	</td>
</tr>
';

if(isset($edari) && isset($ehingga))
$tbl .='
<tr>
	<td>
	Kedaluarsa Dari : '.$edari.'
	</td>
</tr>
<tr>
	<td>
	Kedaluarsa Hingga : '.$ehingga.' 
	</td>
</tr>';

if(isset($nama))
$tbl .='
<tr>
	<td>
	Nama Obat : '.$nama.'
	</td>
</tr>';

if(isset($sumber))
$tbl .='
<tr>
	<td>
	Sumber : '.$sumber.'
	</td>
</tr>';

$close = '
</table>
</b>';

$tbl .= $close;

$pdf->writeHTML($tbl, true, false, false, false, '');

$header = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
	<tr align = "center">
        <td width="5%">NO. URUT</td>
        <td width="5%">NO. LPLPO</td>
        <td width="20%">NAMA OBAT</td>
		<td>SATUAN</td>
        <td>STOK AWAL</td>
        <td>PENERIMAAN</td>
		<td>PERSEDIAAN</td>
		<td>PENGELUARAN</td>
        <td>SISA STOK</td>
    </tr>
	<tr align="center" style="background-color:'grey'">
        <td>1</td>
        <td>2</td>
        <td>3</td>
		<td>4</td>
        <td>5</td>
        <td>6</td>
		<td>7</td>
		<td>8</td>
        <td>9</td>
    </tr>
EOD;

$content = "";
$i = 0;
if(isset($lplpo))
foreach($lplpo as $data)
{
$i += 1;
$row ="
<tr>
		 <td >".$i."</td>
		 <td >".$data['KODE_OBAT']."</td>
		 <td >".$data['NAMA_OBAT']."</td>
		 <td >".$data['SATUAN']."</td>
		 <td >".$data['STOK_AWAL']."</td>
		 <td >".$data['PENERIMAAN']."</td>
		 <td >".$data['PERSEDIAAN']."</td>
		 <td >".$data['PEMAKAIAN']."</td>
		 <td >".$data['SISA_STOK']."</td>
    </tr>";
$content= $content.$row;
}
else
{
$i += 1;
$row ="
<tr>
		 <td >".$i."</td>
		 <td >-</td>
		 <td >-</td>
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