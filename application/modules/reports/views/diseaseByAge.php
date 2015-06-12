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
	LAPORAN KESAKITAN BERDASARKAN UMUR
	</td>
</tr>
<tr align="center">
	<td colspan="4">
	</td>
</tr>
<tr>
	<td style="width:15%">
	KODE GEDUNG
	</td>
	<td style="width:15%" colspan="3">
	: '.$detailPuskesmas[0]['NOID_GEDUNG'].'
	</td>
</tr>
<tr>
	<td style="width:15%">
	PUSKESMAS
	</td>
	<td style="width:40%">
	: '.$detailPuskesmas[0]['NAMA_GEDUNG'].'
	</td>
	<td style="width:10%">
	</td>
	<td style="width:10%">
		DARI TGL
	</td>
	<td style="width:15%">
		:'.$from.'
	</td>
</tr>
<tr>
	<td style="width:15%">
	KECAMATAN
	</td>
	<td style="width:40%">
	: '.$detailPuskesmas[0]['KECAMATAN_GEDUNG'].'
	</td>
	<td style="width:10%">
	</td>
	<td style="width:10%">
		S/D TGL
	</td>
	<td style="width:15%">
		: '.$till.'
	</td>
</tr>
</table>
</b>
';

$pdf->writeHTML($tbl, true, false, false, false, '');


$header = '
<table align="center" border="1" cellspacing="0" cellpadding="1">
<tr>
					<td align="center" width="6%" >
						KODE
					</td>
					<td align="center" width="6%" >
						0-7 HARI
					</td>
					<td align="center" width="6%" >
						8-28 HARI
					</td>
					<td align="center" width="6%" >
						1-12 BULAN
					</td>
					<td align="center" width="6%" >
						1-4 TH
					</td>
					<td align="center" width="6%" >
						5-9 TH
					</td>
					<td align="center" width="6%" >
						10-14 TH
					</td>
					<td align="center" width="6%" >
						15-19 TH
					</td>
					<td align="center" width="6%" >
						20-44 TH
					</td>
					<td align="center" width="6%" >
						45-54 TH
					</td>
					<td align="center" width="6%" >
						55-59 TH
					</td>
					<td align="center" width="6%" >
						60-64 TH
					</td>
					<td align="center" width="6%" >
						65-69 TH
					</td>
					<td align="center" width="6%" >
						>70 TH
					</td>
					<td align="center" width="6%" >
						TOTAL
					</td>
				</tr>				';

				$content = "";
$i=0;
if(isset($disease)){
foreach($disease as $drow)
	{
	$IDICD = $drow['CATEGORY'];
	if($drow['SUBCATEGORY'] != '')
		$IDICD .= '.'.$drow['SUBCATEGORY'];
	$i +=1;
	$row ="
	<tr>
			 <td >".$IDICD."</td>
			 <td align='center'>".$drow['07hari']."</td>
			 <td align='center'>".$drow['828hari']."</td>
			 <td align='center'>".$drow['112bulan']."</td>
			 <td align='center'>".$drow['14tahun']."</td>
			 <td align='center'>".$drow['59tahun']."</td>
			 <td align='center'>".$drow['1014tahun']."</td>
			 <td align='center'>".$drow['1519tahun']."</td>
			 <td align='center'>".$drow['2044tahun']."</td>
			 <td align='center'>".$drow['4554tahun']."</td>
			 <td align='center'>".$drow['5559tahun']."</td>
			 <td align='center'>".$drow['6064tahun']."</td>
			 <td align='center'>".$drow['6569tahun']."</td>
			 <td align='center'>".$drow['70tahun']."</td>
			 <td align='center'>".$drow['total']."</td>
		</tr>";
	$content= $content.$row;
	}
}
else
{
	$i +=1;
$row ="
	<tr>
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

$tbl = $header.$content.$close;
$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+