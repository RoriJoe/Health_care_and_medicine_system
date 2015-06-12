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
	<td colspan="4">
	DAFTAR PENGUJIAN LAB
	</td>
</tr>
<tr>
	<td style="width:15%">
	BULAN/TAHUN
	</td>
	<td style="width:15%" colspan="3">
	: '.$bulan.'/'.$tahun.'
	</td>
</tr>
<tr>
	<td style="width:15%">
	PUSKESMAS
	</td>
	<td style="width:40%">
	: '.$namaPuskesmas.'
	</td>
	<td style="width:10%">
	</td>
	<td style="width:10%">
	</td>
	<td style="width:15%">
	</td>
</tr>
<tr>
	<td style="width:15%">
	KECAMATAN
	</td>
	<td style="width:15%">
	: '.$kec.'
	</td>
	<td style="width:10%">
	</td>
	<td style="width:10%">
	</td>
	<td style="width:15%">
	</td>
</tr>
</table>
</b>
';

$pdf->writeHTML($tbl, true, false, false, false, '');


$header = '
<table border="1" cellspacing="0" cellpadding="1">
<tr>
					<td width="6%">
						NO.
					</td>
					<td width="60%">
						NAMA PENGUJIAN
					</td>
					<td width="6%">
						L
					</td>
					<td width="6%">
						P
					</td>
				</tr> ';

				$content = "";
$i=0;
if(isset($allLab)){
foreach($allLab as $lab)
	{
	$i +=1;
	$row ="
	<tr>
			 <td >".$i."</td>
			 <td >".$lab['NAMA_PEMERIKSAAN']."</td>
			 <td >".$lab['L']."</td>
			 <td >".$lab['P']."</td>
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