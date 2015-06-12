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
	<td colspan="2">
	LAPORAN KEGIATAN LABORATORIUM
	</td>
</tr>
<tr align="center">
	<td colspan="2">
	Bulan : '.$bulan.' Tahun : '.$tahun.'
	</td>
</tr>
<tr align="center">
	<td colspan="2">
	'.$detailPuskesmas[0]['NAMA_GEDUNG'].'
	</td>
</tr>
<tr align="center">
	<td colspan="2">
	</td>
</tr>
<tr align="center">
	<td colspan="2">
	</td>
</tr>
<tr>
	<td width="10%">
		
	</td>
	<td width="40%">
		1. Jumlah kunjungan Laboratorium
	</td>
	<td width="10%">
		
	</td>
	<td width="40%">
		: L = '.$head[0]['LAKI'].' P = '.$head[0]['PEREMPUAN'].'
	</td>
</tr>
<tr>
	<td width="10%">
		
	</td>
	<td width="40%">
		2. Jumlah spesimen yang diperiksa
	</td>
	<td width="10%">
		
	</td>
	<td width="40%">
		: '.($head[0]['DARAH']+$head[0]['URINE']+$head[0]['FESES']+$head[0]['DAHAK']+$head[0]['SEKRET']+$head[0]['LAIN']).' = (a+b+c+d+e+f)
	</td>
</tr>
<tr>
	<td width="10%">
		
	</td>
	<td width="40%">
		a. Spesimen Darah
	</td>
	<td width="10%">
		
	</td>
	<td width="40%">
		: '.$head[0]['DARAH'].' 
	</td>
</tr>
<tr>
	<td width="10%">
		
	</td>
	<td width="40%">
		b. Spesimen Urine
	</td>
	<td width="10%">
		
	</td>
	<td width="40%">
		: '.$head[0]['URINE'].'
	</td>
</tr>
<tr>
	<td width="10%">
		
	</td>
	<td width="40%">
		c. Spesimen Feses
	</td>
	<td width="10%">
		
	</td>
	<td width="40%">
		: '.$head[0]['FESES'].'
	</td>
</tr>
<tr>
	<td width="10%">
		
	</td>
	<td width="40%">
		d. Spesimen Dahak/sputum
	</td>
	<td width="10%">
		
	</td>
	<td width="40%">
		: '.$head[0]['DAHAK'].'
	</td>
</tr>
<tr>
	<td width="10%">
		
	</td>
	<td width="40%">
		e. Spesimen Sekret/duh
	</td>
	<td width="10%">
		
	</td>
	<td width="40%">
		: '.$head[0]['SEKRET'].'
	</td>
</tr>
<tr>
	<td width="10%">
		
	</td>
	<td width="40%">
		f. Spesimen Lain (rambut,kuku,dll)
	</td>
	<td width="10%">
		
	</td>
	<td width="40%">
		: '.$head[0]['LAIN'].'
	</td>
</tr>
<tr>
	<td width="10%">
		
	</td>
	<td width="40%">
		3. Jumlah Pemeriksaan
	</td>
	<td width="10%">
		
	</td>
	<td width="40%">
		: '.($head[0]['PUSKESMAS']+$head[0]['RUJUK']).' = (a+b)
	</td>
</tr>
<tr>
	<td width="10%">
		
	</td>
	<td width="40%">
		a. Diperiksa di Puskesmas
	</td>
	<td width="10%">
		
	</td>
	<td width="40%">
		: '.$head[0]['PUSKESMAS'].'
	</td>
</tr>
<tr>
	<td width="10%">
		
	</td>
	<td width="40%">
		b. Di Rujuk
	</td>
	<td width="10%">
		
	</td>
	<td width="40%">
		: '.$head[0]['RUJUK'].'
	</td>
</tr>
</table>
</b>
';

$pdf->writeHTML($tbl, true, false, false, false, '');


$tbl = '
<table cellspacing="0" cellpadding="1" border="1">
	<tr>
        <td align="center" width="6%" >NO.</td>
        <td align="center" width="50%">Pemeriksaan</td>
        <td align="center" width="20%">Di Puskesmas(a)</td>
		<td align="center" width="20%">Di Rujuk(b)</td>
    </tr>
';
$i=0;
$row = '';
if(isset($hematologi))
{
	foreach($hematologi as $isi)
	{
	$i++;
	$row .='
	<tr>
        <td  >'.$i.'</td>
        <td >'.$isi['NAMA_PEM_LABORAT'].'</td>
        <td align="center" width="20%">'.$isi['PSKM'].'</td>
		<td align="center" width="20%">'.$isi['RSKM'].'</td>
    </tr>';
	}
}


if(isset($urine))
{
	foreach($urine as $isi)
	{
	$i++;
	$row .='
	<tr>
        <td  >'.$i.'</td>
        <td >'.$isi['NAMA_PEM_LABORAT'].'</td>
        <td align="center" width="20%">'.$isi['PSKM'].'</td>
		<td align="center" width="20%">'.$isi['RSKM'].'</td>
    </tr>';
	}
}


if(isset($kehamilan))
{
	foreach($kehamilan as $isi)
	{
	$i++;
	$row .='
	<tr>
        <td  >'.$i.'</td>
        <td >'.$isi['NAMA_PEM_LABORAT'].'</td>
        <td align="center" width="20%">'.$isi['PSKM'].'</td>
		<td align="center" width="20%">'.$isi['RSKM'].'</td>
    </tr>';
	}
}


if(isset($feces))
{
	foreach($feces as $isi)
	{
	$i++;
	$row .='
	<tr>
        <td  >'.$i.'</td>
        <td >'.$isi['NAMA_PEM_LABORAT'].'</td>
        <td align="center" width="20%">'.$isi['PSKM'].'</td>
		<td align="center" width="20%">'.$isi['RSKM'].'</td>
    </tr>';
	}
}


if(isset($gula))
{
	foreach($gula as $isi)
	{
	$i++;
	$row .='
	<tr>
        <td  >'.$i.'</td>
        <td >'.$isi['NAMA_PEM_LABORAT'].'</td>
        <td align="center" width="20%">'.$isi['PSKM'].'</td>
		<td align="center" width="20%">'.$isi['RSKM'].'</td>
    </tr>';
	}
}


if(isset($serologi))
{
	foreach($serologi as $isi)
	{
	$i++;
	$row .='
	<tr>
        <td  >'.$i.'</td>
        <td >'.$isi['NAMA_PEM_LABORAT'].'</td>
        <td align="center" width="20%">'.$isi['PSKM'].'</td>
		<td align="center" width="20%">'.$isi['RSKM'].'</td>
    </tr>';
	}
}


if(isset($hati))
{
	foreach($hati as $isi)
	{
	$i++;
	$row .='
	<tr>
        <td  >'.$i.'</td>
        <td >'.$isi['NAMA_PEM_LABORAT'].'</td>
        <td align="center" width="20%">'.$isi['PSKM'].'</td>
		<td align="center" width="20%">'.$isi['RSKM'].'</td>
    </tr>';
	}
}


if(isset($lemak))
{
	foreach($lemak as $isi)
	{
	$i++;
	$row .='
	<tr>
        <td  >'.$i.'</td>
        <td >'.$isi['NAMA_PEM_LABORAT'].'</td>
        <td align="center" width="20%">'.$isi['PSKM'].'</td>
		<td align="center" width="20%">'.$isi['RSKM'].'</td>
    </tr>';
	}
}


if(isset($ginjal))
{
	foreach($ginjal as $isi)
	{
	$i++;
	$row .='
	<tr>
        <td  >'.$i.'</td>
        <td >'.$isi['NAMA_PEM_LABORAT'].'</td>
        <td align="center" width="20%">'.$isi['PSKM'].'</td>
		<td align="center" width="20%">'.$isi['RSKM'].'</td>
    </tr>';
	}
}


if(isset($direct))
{
	foreach($direct as $isi)
	{
	$i++;
	$row .='
	<tr>
        <td  >'.$i.'</td>
        <td >'.$isi['NAMA_PEM_LABORAT'].'</td>
        <td align="center" width="20%">'.$isi['PSKM'].'</td>
		<td align="center" width="20%">'.$isi['RSKM'].'</td>
    </tr>';
	}
}

if(!isset($direct) && !isset($ginjal) && !isset($lemak) && !isset($hati) && !isset($serologi) && !isset($gula) && !isset($feces) && !isset($kehamilan) && !isset($urine) && !isset($hematologi))
{
	$i++;
	$row .='
	<tr>
        <td  >'.$i.'</td>
        <td >-</td>
        <td align="center" width="20%">-</td>
		<td align="center" width="20%">-</td>
    </tr>';
}


$close = "</table>";
$tbl = $tbl.$row.$close;
$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

$tbl = '
<table style="width:100%" cellspacing="0" cellpadding="1">
	<tr align="center">
		<td align=center style="width:50%">
			<table cellspacing="0" cellpadding="0" >
				<tr >
					<td>
					Mengetahui,
					</td>
				</tr>
				<tr >
					<td>
					Kepala '.$detailPuskesmas[0]['NAMA_GEDUNG'].'
					</td>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr >
					<td>
					<u>('.$nKP.')</u>
					</td>
				</tr>
				<tr >
					<td>
					NIP. '.$nipKP.'
					</td>
				</tr>
			</table>
		</td>
		<td align=center style="width:50%">
			<table cellspacing="0" cellpadding="0" >
				<tr >
					<td>
Jember, ...............
					</td>
				</tr>
				<tr >
					<td>
					Petugas Laboratorium,

					</td>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr >
					<td>
					<u>('.$nPL.')</u>
					</td>
				</tr>
				<tr >
					<td>
					NIP. '.$nipPL.'
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
';

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+