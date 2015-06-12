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
	<td colspan="4" >
	<p style="text-transform:uppercase;">STOK OPNAME '.$detailPuskesmas[0]['NAMA_GEDUNG'].'</p>
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

$unitPuskesmas = '<p style="text-transform:uppercase;">'.$namaUnit.'</p>';
$pdf->writeHTML($unitPuskesmas, true, false, false, false, '');

$tbl = <<<EOD
<table align="center" cellspacing="0" cellpadding="1" border="1">
	<tr align = "center">
        <td rowspan="2">NO. URUT</td>
        <td rowspan="2">NAMA OBAT</td>
		<td rowspan="2">SATUAN</td>
        <td rowspan="2">GUDANG</td>
        <td rowspan="2">APOTIK</td>
		<td rowspan="2">UGD</td>
        <td rowspan="2">VK</td>
		<td rowspan="2">KIA</td>
        <td rowspan="2">ZAAL</td>
        <td rowspan="2">BP</td>
		<td rowspan="2">GIGI</td>
        <td rowspan="2">TEGAL BOTO</td>
		<td rowspan="2">TEGAL GEDE</td>
        <td rowspan="2">KR. REJO</td>
		<td rowspan="2">ANTI ROGO</td>
        <td rowspan="2">WIROLEGI</td>
		<td rowspan="2">JUMLAH</td>
        <td rowspan="2">SISA LPLPO</td>
		<td align="center" colspan="2">SELISIH</td>
    </tr>
EOD;

$h = <<<EOD
<tr>
		 <td >LEBIH</td>
		 <td >KURANG</td>
    </tr>
EOD;
$content = "";
for($i=1;$i<11;$i++)
{
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