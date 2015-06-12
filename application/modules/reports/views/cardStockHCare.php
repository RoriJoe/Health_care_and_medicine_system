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
<b>
<table >
<tr align="center">
	<td colspan="4">
	<b>KARTU STOK OBAT PUSKESMAS</b>
	</td>
</tr>
<tr>
	<td style="width:15%">
	Nama Obat
	</td>
	<td style="width:15%">
	: 
	</td>
	<td style="width:35%">
	</td>
	<td style="width:20%">
	Kemasan
	</td>
	<td style="width:15%">
	: 
	</td>
</tr>
<tr>
	<td style="width:15%">
	
	</td>
	<td style="width:15%">
	
	</td>
	<td style="width:35%">
	</td>
	<td style="width:20%">
	Satuan
	</td>
	<td style="width:15%">
	: 
	</td>
</tr>
</table>
</b>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$h = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
<tr>
		 <td >TGL</td>
		 <td >MUTASI DARI/KE</td>
		 <td >STOK AWAL</td>
		 <td >PENERIMAAN</td>
		 <td >PENGELUARAN</td>
		 <td >SISA STOK</td>
		 <td >EXP DATE</td>
    </tr>
EOD;
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
		 <td >ASKES</td>
		 <td >PROG</td>
    </tr>";
$content= $content.$row;
}
$close = "</table>";
$tbl = $h.$content.$close;
$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+