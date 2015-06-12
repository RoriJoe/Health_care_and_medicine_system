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
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
	<td colspan="4">
	LAPORAN PEMAKAIAN DAN LEMBAR PERMINTAAN OBAT
	</td>
</tr>
<tr align="center">
	<td colspan="4">
	(LPLPO)
	</td>
</tr>
<tr>
	<td style="width:15%">
	KODE PUSKESMAS
	</td>
	<td style="width:15%" colspan="3">
	: '.$detailPuskesmas[0]['NOID_GEDUNG'].'
	</td>
</tr>
<tr>
	<td style="width:15%">
	PUSKESMAS
	</td>
	<td style="width:15%">
	: '.$detailPuskesmas[0]['NAMA_GEDUNG'].'
	</td>
	<td style="width:45%">
	</td>
	<td style="width:10%">
	BULAN
	</td>
	<td style="width:15%">
	: SEPTEMBER
	</td>
</tr>
<tr>
	<td style="width:15%">
	KECAMATAN
	</td>
	<td style="width:15%">
	: '.$detailPuskesmas[0]['KECAMATAN_GEDUNG'].'
	</td>
	<td style="width:45%">
	</td>
	<td style="width:10%">
	TAHUN
	</td>
	<td style="width:15%">
	: 2014
	</td>
</tr>
<tr>
	<td style="width:15%">
	KABUPATEN
	</td>
	<td style="width:15%">
	: '.$detailPuskesmas[0]['KABUPATEN_GEDUNG'].'
	</td>
	<td style="width:45%">
	</td>
	<td style="width:10%">
	MASUK TGL.
	</td>
	<td style="width:15%">
	: 
	</td>
</tr>
<tr>
	<td style="width:15%">
	PROPINSI
	</td>
	<td style="width:15%" colspan="3">
	: JAWA TIMUR
	</td>
</tr>
</table>
</b>
';

$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = <<<EOD
<table align="center" cellspacing="0" cellpadding="1" border="1">
	<tr>
        <td width="3%" rowspan="2">NO. URUT</td>
        <td rowspan="2">NO. LPLPO</td>
        <td width="10%" rowspan="2">NAMA OBAT</td>
		<td rowspan="2">SATUAN</td>
        <td rowspan="2">STOK AWAL</td>
        <td rowspan="2">PENERIMAAN</td>
		<td rowspan="2">PERSEDIAAN</td>
        <td rowspan="2">PEMAKAIAN</td>
		<td rowspan="2">SISA STOK</td>
        <td rowspan="2">STOK OPT.</td>
		<td rowspan="2">PERMINTAAN</td>
		<td align="center" colspan="5">PEMBERIAN</td>
		<td rowspan="2">KET</td>
    </tr>
EOD;

$h = <<<EOD
<tr>
		 <td >DAU</td>
		 <td >ASKES</td>
		 <td >PROG</td>
		 <td >LAIN-2</td>
		 <td >TOTAL</td>
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
		 <td >".$data['STOK_OPT']."</td>
		 <td >".$data['PERMINTAAN']."</td>
		 <td >".$data['DAU']."</td>
		 <td >".$data['ASKES']."</td>
		 <td >".$data['PROG']."</td>
		 <td >".$data['LAIN']."</td>
		 <td >".$data['TOTAL']."</td>
		 <td >-</td>
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
$tbl = $tbl.$h.$content.$close;
$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+