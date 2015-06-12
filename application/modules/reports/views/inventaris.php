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
	KARTU INVENTARIS BARANG (KIB)
	</td>
</tr>
<tr align="center">
	<td colspan="4">
	B. PERALATAN DAN MESIN
	</td>
</tr>
<tr>
	<td style="width:15%">
	PROVINSI
	</td>
	<td style="width:15%" colspan="3">
	: '.$detailPuskesmas[0]['PROVINSI_GEDUNG'].'
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
	</td>
	<td style="width:15%">
	</td>
</tr>
<tr>
	<td style="width:15%">
	SUB UNIT
	</td>
	<td style="width:15%">
	: '.$this->session->userdata['telah_masuk']['namaunit'].'
	</td>
	<td style="width:45%">
	</td>
	<td style="width:10%">
	</td>
	<td style="width:15%">
	</td>
</tr>
<tr>
	<td style="width:15%">
	SATUAN KERJA
	</td>
	<td style="width:15%">
	: '.$detailPuskesmas[0]['NAMA_GEDUNG'].'
	</td>
	<td style="width:45%">
	</td>
	<td style="width:10%">
	</td>
	<td style="width:15%">
	</td>
</tr>
<tr>
	<td style="width:15%">
	</td>
	<td style="width:15%" colspan="3">
	</td>
</tr>
</table>
</b>
';

$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = <<<EOD
<table align="center" cellspacing="0" cellpadding="1" border="1">
	<tr>
        <td width="3%" rowspan="2">No. Urut</td>
        <td rowspan="2">Kode Barang</td>
        <td width="10%" rowspan="2">Nama Brg / Jenis Brg</td>
		<td rowspan="2">Nomer Registrasi</td>
        <td rowspan="2">Merk / Type</td>
        <td rowspan="2">Ukuran / CC</td>
		<td rowspan="2">Bahan</td>
        <td rowspan="2">Tahun Pembelian</td>
		<td align="center" colspan="5">PEMBERIAN</td>
		<td rowspan="2">Asal Usul / Cara Perolehan</td>
        <td rowspan="2">Harga</td>
		<td rowspan="2">Keterangan</td>
    </tr>
EOD;

$h = <<<EOD
<tr>
		 <td >Pabrik</td>
		 <td >Rangka</td>
		 <td >Mesin</td>
		 <td >Polisi</td>
		 <td >BPKB</td>
    </tr>
EOD;
$content = "";
$i = 0;
if(isset($inventaris))
foreach($inventaris as $data)
{
$i += 1;
$row ="
<tr>
		 <td >".$i."</td>
		 <td >".$data['KODE_BARANG']."</td>
		 <td >".$data['NAMA_BARANG']."</td>
		 <td >".$data['NO_REG_BARANG']."</td>
		 <td >".$data['MERK_TYPE']."</td>
		 <td >".$data['UKURAN_CC']."</td>
		 <td >".$data['BAHAN_BARANG']."</td>
		 <td >".$data['TAHUN_PEMBELIAN_BARANG']."</td>
		 <td >".$data['NOMOR_PABRIK']."</td>
		 <td >".$data['NOMOR_RANGKA']."</td>
		 <td >".$data['NOMOR_MESIN']."</td>
		 <td >".$data['NOMOR_POLISI']."</td>
		 <td >".$data['NOMOR_BPKB']."</td>
		 <td >".$data['CARA_PEROLEHAN_BARANG']."</td>
		 <td >".$data['HARGA_BARANG']."</td>
		 <td >".$data['KETERANGAN_BARANG']."</td>
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