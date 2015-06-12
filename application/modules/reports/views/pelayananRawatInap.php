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

$tbl = <<<EOD
<table >
<tr align="center">
	<td colspan="2">
		<b>LAPORAN BULANAN PELAYANAN KESEHATAN</b>
	</td>
</tr>
<tr>
	<td width="15%">
	</td>
	<td>
	</td>
</tr>
<tr>
	<td width="15%">
	BULAN/TAHUN 
	</td>
	<td>
	: ...............
	</td>
</tr>
<tr>
	<td width="15%">
	PUSKESMAS
	</td>
	<td>
	: ...............
	</td>
</tr>
<tr>
	<td width="15%">
	KECAMATAN 
	</td>
	<td>
	: ...............
	</td>
</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->SetFillColor(255, 255, 255);
// -----------------------------------------------------------------------------
$txt = 'NO. LPLPO';


$header = '
<table cellspacing="0" cellpadding="1" border="1">
	<tr align="center">
        <td width="5%" height="30px" ><span padding=5px>NO.</span></td>
        <td width="75%" height="30px" >URAIAN</td>
        <td width="5%" height="30px" >L</td>
		<td width="5%" height="30px" >P</td>
        <td width="10%" height="30px" >JUMLAH</td>
    </tr>
';

$content = "";
for($i=1;$i<11;$i++)
{
	$row ="
		<tr>
			 <td >".$i."</td>
			 <td >ASKES</td>
			 <td >PROG</td>
			 <td >LAIN-2</td>
			 <td >TOTAL</td>
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