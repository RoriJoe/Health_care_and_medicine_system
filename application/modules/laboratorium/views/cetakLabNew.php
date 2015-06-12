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
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
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
	<h2>Hasil Tes Laborat</h2>
	</td>
</tr>
<tr align="center">
	<td colspan="4">
	<h2>'.$gedung[0]['NAMA_GEDUNG'].'</h2>
	</td>
</tr>
<tr align="center">
	<td colspan="4">
	</td>
</tr>
<tr>
	<td style="width:15%">
	</td>
	<td style="width:15%" colspan="3">
	</td>
</tr>
<tr>
	<td style="width:15%">
	Nomor Index
	</td>
	<td style="width:40%">
	: ' . $profil[0]['NOID_REKAMMEDIK'] . '
	</td>
	<td style="width:10%">
	</td>
</tr>
<tr>
	<td style="width:15%">
	Nama Pasien
	</td>
	<td style="width:40%">
	: ' . $profil[0]['NAMA_PASIEN'] . '
	</td>
	<td style="width:10%">
	</td>
</tr>
<tr>
	<td style="width:15%">
	Tanggal Lahir
	</td>
	<td style="width:40%">
	: ' . $profil[0]['TGL_LAHIR_PASIEN'] . '
	</td>
	<td style="width:10%">
	</td>
</tr>
<tr>
	<td style="width:15%">
	Jenis Kelamin
	</td>
	<td style="width:40%">
	: ' . $profil[0]['GENDER_PASIEN'] . '
	</td>
	<td style="width:10%">
	</td>
</tr>
<tr>
	<td style="width:15%">
	Alamat
	</td>
	<td style="width:40%">
	: ' . $profil[0]['ALAMAT_PASIEN'].', '.$profil[0]['KECAMATAN_PASIEN'].', '.$profil[0]['KOTA_PASIEN'] . '
	</td>
	<td style="width:10%">
	</td>
</tr>
</table>
</b>
';

$pdf->writeHTML($tbl, true, false, false, false, '');


$header = '
<table align="center" border="1" cellspacing="0" cellpadding="1">
<tr>
                                        <td align="center" width="5%" >
						No
					</td>
					<td align="center" width="25%" >
						Pengujian
					</td>
					<td align="center" width="15%" >
						Spesimen
					</td>
					<td align="center" width="15%" >
						Kategori Pengujian
					</td>
					<td align="center" width="10%" >
						Hasil Tes
					</td>
					<td align="center" width="10%" >
						Satuan
					</td>
					<td align="center" width="10%" >
						Nilai Normal
					</td>
					<td align="center" width="10%" >
						Tanggal Tes
					</td>
				</tr>				';

$content = "";
$i = 0;
if (isset($laborat)) {
    foreach ($laborat as $row) {
        $i +=1;
        $row = "
	<tr>
			 <td align='center'>" . $i . "</td>
			 <td align='center'>" . $row['NAMA_PEM_LABORAT'] . "</td>
			 <td align='center'>" . $row['NAMA_SPESIMEN'] . "</td>
			 <td align='center'>" . $row['NAMA_KP_LABORAT'] . "</td>
			 <td align='center'>" . $row['HASIL_TES_LAB'] . "</td>
			 <td align='center'>" . $row['SATUAN_HASIL_UJI'] . "</td>
			 <td align='center'>" . $row['NILAI_NORMAL_UJI'] . "</td>
			 <td align='center'>" . $row['TANGGAL_TES_LAB'] . "</td>
			 
		</tr>";
        $content = $content . $row;
    }
} else {
    $i +=1;
    $row = "
	<tr>
			 <td >-</td>
			 <td >-</td>
			 <td >-</td>
			 <td >-</td>
			 <td >-</td>
			 <td >-</td>
			 <td >-</td>
			 <td >-</td>
			 
		</tr>";
    $content = $content . $row;
}

$close = "</table>";

$tbl = $header . $content . $close;
$pdf->writeHTML($tbl, true, false, false, false, '');

$date = date('m/d/Y h:i:s a', time());
$tbl = "Waktu Cetak : ".$date;
$pdf->writeHTML($tbl, true, false, false, false, '');


$tbl = "Petugas Lab : ".$this->session->userdata['telah_masuk']['namauser'];
$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+