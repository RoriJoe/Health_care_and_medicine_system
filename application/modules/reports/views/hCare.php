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
	LAPORAN BULANAN PELAYANAN KESEHATAN
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
						URAIAN
					</td>
					<td width="6%">
						L
					</td>
					<td width="6%">
						P
					</td>
					<td width="10%">
						JUMLAH
					</td>
				</tr>
				<tr>
					<td>
						A.
					</td>
					<td>
						KEGIATAN KUNJUNGAN PUSKESMAS
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						1.
					</td>
					<td>
						Jumlah Keluarga (KK) baru yang tercatat di Puskesmas 
					</td>
					<td>
						'.$hcarekk[0]['LKK'].'
					</td>
					<td>
						'.$hcarekk[0]['PKK'].'
						
					</td>
					<td>
						'.$hcarekk[0]['KK'].'
						
					</td>
				</tr>
				<tr>
					<td>
						2. 
					</td>
					<td>
						Jumlah Kunjungan Puskesmas (baru)
					</td>
					<td>
						'.$hcarepvisit[0]['LKPUSBARU'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['PKPUSBARU'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['KPUSBARU'].'
						
					</td>
				</tr>
				<tr>
					<td>
						3. 
					</td>
					<td>
						Jumlah Kunjungan Puskesmas (lama)
					</td>
					<td>
						'.$hcarepvisit[0]['LKPUSLAMA'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['PKPUSLAMA'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['KPUSLAMA'].'
						
					</td>
				</tr>
				<tr>
					<td>
						4. 
					</td>
					<td>
						Jumlah Kunjungan Rawat Jalan (baru)
					</td>
					<td>
						'.$hcarerjalan[0]['LKBPBARU'].'
						
					</td>
					<td>
						'.$hcarerjalan[0]['PKBPBARU'].'
						
					</td>
					<td>
						'.$hcarerjalan[0]['KBPBARU'].'
						
					</td>
				</tr>
				<tr>
					<td>
						5. 
					</td>
					<td>
						Jumlah Kunjungan Rawat Jalan (lama)
					</td>
					<td>
						'.$hcarerjalan[0]['LKBPLAMA'].'
						
					</td>
					<td>
						'.$hcarerjalan[0]['PKBPLAMA'].'
						
					</td>
					<td>
						'.$hcarerjalan[0]['KBPLAMA'].'
						
					</td>
				</tr>
				<tr>
					<td>
						6. 
					</td>
					<td>
						Jumlah Kunjungan Rawat Jalan Gigi (baru)
					</td>
					<td>
						'.$hcarerjalan[0]['LKGIGIBARU'].'
						
					</td>
					<td>
						'.$hcarerjalan[0]['PKGIGIBARU'].'
						
					</td>
					<td>
						'.$hcarerjalan[0]['KGIGIBARU'].'
						
					</td>
				</tr>
				<tr>
					<td>
						7. 
					</td>
					<td>
						Jumlah Kunjungan Rawat Jalan Gigi (lama)
					</td>
					<td>
						'.$hcarerjalan[0]['LKGIGILAMA'].'
						
					</td>
					<td>
						'.$hcarerjalan[0]['PKGIGILAMA'].'
						
					</td>
					<td>
						'.$hcarerjalan[0]['KGIGILAMA'].'
						
					</td>
				</tr>
				<tr>
					<td>
						8. 
					</td>
					<td>
						Jumlah Kunjungan Rawat Jalan baru Gol. Umur > 60 tahun
					</td>
					<td>
						'.$hcarerjalan[0]['LKBPBARUTUA'].'
						
					</td>
					<td>
						'.$hcarerjalan[0]['PKBPBARUTUA'].'
						
					</td>
					<td>
						'.$hcarerjalan[0]['KBPBARUTUA'].'
						
					</td>
				</tr>
				<tr>
					<td>
						9. 
					</td>
					<td>
						Jumlah Kunjungan Rawat Jalan lama Gol. Umur  > 60 tahun 
					</td>
					<td>
						'.$hcarerjalan[0]['LKBPLAMATUA'].'
						
					</td>
					<td>
						'.$hcarerjalan[0]['PKBPLAMATUA'].'
						
					</td>
					<td>
						'.$hcarerjalan[0]['KBPLAMATUA'].'
						
					</td>
				</tr>
				<tr>
					<td>
						10. 
					</td>
					<td>
						Jumlah kunjungan  sesuai dengan jenis kepesertaan :(Jumlah point 2 & 3 di atas)
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Umum
					</td>
					<td>
						'.$hcarepvisit[0]['LKSUMBERUMUM'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['PKSUMBERUMUM'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['KSUMBERUMUM'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. BPJS(Askes, Jamsostek, Jamkesmas, Jampersal)
					</td>
					<td>
						'.$hcarepvisit[0]['LKSUMBERBPJS'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['PKSUMBERBPJS'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['KSUMBERBPJS'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. Kunjungan
					</td>
					<td>
						'.$hcarepvisit[0]['LKSUMBERBPJSKUNJUNGAN'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['PKSUMBERBPJSKUNJUNGAN'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['KSUMBERBPJSKUNJUNGAN'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Di Rujuk
					</td>
					<td>
						'.$hcarepvisit[0]['LKSUMBERBPJSRUJUKAN'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['PKSUMBERBPJSRUJUKAN'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['KSUMBERBPJSRUJUKAN'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. SKM
					</td>
					<td>
						'.$hcarepvisit[0]['LKSUMBERSKM'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['PKSUMBERSKM'].'
						
					</td>
					<td>
						'.$hcarepvisit[0]['KSUMBERSKM'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d. Lain- lain 
					</td>
					<td>
						'.$hcarepvisit[0]['LKSUMBERLAIN'].'
					</td>
					<td>
						'.$hcarepvisit[0]['PKSUMBERLAIN'].'
					</td>
					<td>
						'.$hcarepvisit[0]['KSUMBERLAIN'].'
					</td>
				</tr>
									
				<tr>
					<td>
						11. 
					</td>
					<td>
						Jumlah Kasus baru
					</td>
					<td>
						'.$hcarekasus[0]['LKB'].'
						
					</td>
					<td>
						'.$hcarekasus[0]['PKB'].'
						
					</td>
					<td>
						'.$hcarekasus[0]['KB'].'
						
					</td>
				</tr>
				<tr>
					<td>
						12. 
					</td>
					<td>
						Jumlah Kasus lama
					</td>
					<td>
						'.$hcarekasus[0]['LKL'].'
						
					</td>
					<td>
						'.$hcarekasus[0]['PKL'].'
						
					</td>
					<td>
						'.$hcarekasus[0]['KL'].'
						
					</td>
				</tr>
				<tr>
					<td>
						13. 
					</td>
					<td>
						Jumlah kunjungan kasus lama
					</td>
					<td>
						'.$hcarekasus[0]['LKKL'].'
						
					</td>
					<td>
						'.$hcarekasus[0]['PKKL'].'
						
					</td>
					<td>
						'.$hcarekasus[0]['KKL'].'
						
					</td>
				</tr>
				<tr>
					<td>
						14. 
					</td>
					<td>
						Jumlah kunjungan kasus (jumlah No. 11 + No. 12 + No. 13)
					</td>
					<td>
						'.($hcarekasus[0]['LKB']+$hcarekasus[0]['LKL']+$hcarekasus[0]['LKKL']).'
					</td>
					<td>
						'.($hcarekasus[0]['PKB']+$hcarekasus[0]['PKL']+$hcarekasus[0]['PKKL']).'
					</td>
					<td>
						'.($hcarekasus[0]['KB']+$hcarekasus[0]['KL']+$hcarekasus[0]['KKL']).'
					</td>
				</tr>
				<tr>
					<td>
						15. 
					</td>
					<td>
						Jumlah penderita yang dilayani Dokter Umum (BP & KIA Puskesmas Induk)
					</td>
					<td>
						'.$hcaregigiumum[0]['LUMUM'].'
						
					</td>
					<td>
						'.$hcaregigiumum[0]['PUMUM'].'
						
					</td>
					<td>
						'.$hcaregigiumum[0]['UMUM'].'
						
					</td>
				</tr>
				<tr>
					<td>
						16. 
					</td>
					<td>
						Jumlah pemeriksaan Gigi yang dilayani Dokter Gigi
					</td>
					<td>
						'.$hcaregigiumum[0]['LGIGI'].'
						
					</td>
					<td>
						'.$hcaregigiumum[0]['PGIGI'].'
						
					</td>
					<td>
						'.$hcaregigiumum[0]['GIGI'].'
						
					</td>
				</tr>
				<tr>
					<td>
						B. 
					</td>
					<td>
						KEGIATAN PELAYANAN KEGAWAT DARURATAN

					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						1. 
					</td>
					<td>
						Jumlah penderita gawat darurat yang ditemukan
					</td>
					<td>
						'.$hcareugd[0]['UGDL'].'
						
					</td>
					<td>
						'.$hcareugd[0]['UGDP'].'
						
					</td>
					<td>
						'.($hcareugd[0]['UGDL']+$hcareugd[0]['UGDP']).'
						
					</td>
				</tr>
				<tr>
					<td>
						2. 
					</td>
					<td>
						Jumlah penderita gawat darurat yang ditangani (total) (Target : 100 % dari yang ditemukan)
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
				
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Maternal 
					</td>
					<td>
						'.$hcareugd[0]['LPMATERNAL'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PPMATERNAL'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PMATERNAL'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Neonatal 
					</td>
					<td>
						'.$hcareugd[0]['LPNEONATAL'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PPNEONATAL'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PNEONATAL'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Bayi
					</td>
					<td>
						'.$hcareugd[0]['LPBAYI'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PPBAYI'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PBAYI'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d. Anak Balita
					</td>
					<td>
						'.$hcareugd[0]['LPBALITA'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PPBALITA'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PBALITA'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;e. Penderita Kasus Kecelakaan Lalu lintas :
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Luka Ringan 
					</td>
					<td>
						'.$hcareugd[0]['LPLANTASRINGAN'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PPLANTASRINGAN'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PLANTASRINGAN'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Luka Berat 
					</td>
					<td>
						'.$hcareugd[0]['LPLANTASBERAT'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PPLANTASBERAT'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PLANTASBERAT'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Mati 
					</td>
					<td>
						'.$hcareugd[0]['LPLANTASMATI'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PPLANTASMATI'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PLANTASMATI'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;f. Penderita dengan Penyakit potensial KLB
					</td>
					<td>
						'.$hcareugd[0]['LPUGDKLB'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PPUGDKLB'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PUGDKLB'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;g. Lain -lain
					</td>
					<td>
						'.$hcareugd[0]['LPUGDLAIN'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PPUGDLAIN'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PUGDLAIN'].'
						
					</td>
				</tr>
				<tr>
					<td>
						3. 
					</td>
					<td>
						Jumlah penderita gawat darurat yang di rujuk ke Puskesmas perawatan / Rumah Sakit (total) (Target 25 % dari GD yang ditangani)
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Maternal 
					</td>
					<td>
						'.$hcareugd[0]['LRMATERNAL'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PRMATERNAL'].'
						
					</td>
					<td>
						'.$hcareugd[0]['RMATERNAL'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Neonatal 
					</td>
					<td>
						'.$hcareugd[0]['LRNEONATAL'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PRNEONATAL'].'
						
					</td>
					<td>
						'.$hcareugd[0]['RNEONATAL'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Bayi
					</td>
					<td>
						'.$hcareugd[0]['LRBAYI'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PRBAYI'].'
						
					</td>
					<td>
						'.$hcareugd[0]['RBAYI'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d. Anak Balita
					</td>
					<td>
						'.$hcareugd[0]['LRBALITA'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PRBALITA'].'
						
					</td>
					<td>
						'.$hcareugd[0]['RBALITA'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;e. Penderita Kasus Kecelakaan Lalu lintas :
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Luka Ringan 
					</td>
					<td>
						'.$hcareugd[0]['LRLANTASRINGAN'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PRLANTASRINGAN'].'
						
					</td>
					<td>
						'.$hcareugd[0]['RLANTASRINGAN'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Luka Berat 
					</td>
					<td>
						'.$hcareugd[0]['LRLANTASBERAT'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PRLANTASBERAT'].'
						
					</td>
					<td>
						'.$hcareugd[0]['RLANTASBERAT'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Mati 
					</td>
					<td>
						'.$hcareugd[0]['LRLANTASMATI'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PRLANTASMATI'].'
						
					</td>
					<td>
						'.$hcareugd[0]['RLANTASMATI'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;f. Penderita dengan Penyakit potensial KLB
					</td>
					<td>
						'.$hcareugd[0]['LRUGDKLB'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PRUGDKLB'].'
						
					</td>
					<td>
						'.$hcareugd[0]['RUGDKLB'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;g. Lain -lain
					</td>
					<td>
						'.$hcareugd[0]['LRUGDLAIN'].'
						
					</td>
					<td>
						'.$hcareugd[0]['PRUGDLAIN'].'
						
					</td>
					<td>
						'.$hcareugd[0]['RUGDLAIN'].'
						
					</td>
				</tr>
									
				<tr>
					<td>
						
					</td><td></td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td></tr>
				<tr>
					<td>
						C. 
					</td>
					<td>
						PEMERIKSAAN DIAGNOSTIK
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						1. 
					</td>
					<td>
						Jumlah pemeriksaan EKG/ECG
					</td>
					<td>
						'.$hcareservice[0]['LEKG'].'
						
					</td>
					<td>
						'.$hcareservice[0]['PEKG'].'
						
					</td>
					<td>
						'.$hcareservice[0]['EKG'].'
						
					</td>
				</tr>
				<tr>
					<td>
						2. 
					</td>
					<td>
						Jumlah pemeriksaan USG
					</td>
					<td>
						'.$hcareservice[0]['LUSG'].'
						
					</td>
					<td>
						'.$hcareservice[0]['PUSG'].'
						
					</td>
					<td>
						'.$hcareservice[0]['USG'].'
						
					</td>
				</tr>
				<tr>
					<td>
						3. 
					</td>
					<td>
						Jumlah pemeriksaan Radiologi
					</td>
					<td>
						'.$hcareservice[0]['LRadiologi'].'
						
					</td>
					<td>
						'.$hcareservice[0]['PRadiologi'].'
						
					</td>
					<td>
						'.$hcareservice[0]['Radiologi'].'
						
					</td>
				</tr>
				<tr>
					<td>
						4. 
					</td>
					<td>
						Jumlah pemeriksaan lainnya
					</td>
					<td>
						'.$hcareservice[0]['LLain'].'
						
					</td>
					<td>
						'.$hcareservice[0]['PLain'].'
						
					</td>
					<td>
						'.$hcareservice[0]['Lain'].'
						
					</td>
				</tr>
				<tr>
					<td>
						D. 
					</td>
					<td>
						PEMERIKSAAN KESEHATAN / KEURING
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						1. 
					</td>
					<td>
						Keuring Tenaga Kerja
					</td>
					<td>
						'.$hcareservice[0]['LTK'].'
						
					</td>
					<td>
						'.$hcareservice[0]['PTK'].'
						
					</td>
					<td>
						'.$hcareservice[0]['TK'].'
						
					</td>
				</tr>
				<tr>
					<td>
						2. 
					</td>
					<td>
						Keuring Pelajar
					</td>
					<td>
						'.$hcareservice[0]['LPelajar'].'
						
					</td>
					<td>
						'.$hcareservice[0]['PPelajar'].'
						
					</td>
					<td>
						'.$hcareservice[0]['Pelajar'].'
						
					</td>
				</tr>
				<tr>
					<td>
						3. 
					</td>
					<td>
						Keuring Calon Transmigrasi
					</td>
					<td>
						'.$hcareservice[0]['LTransmigrasi'].'
						
					</td>
					<td>
						'.$hcareservice[0]['PTransmigrasi'].'
						
					</td>
					<td>
						'.$hcareservice[0]['Transmigrasi'].'
						
					</td>
				</tr>
				<tr>
					<td>
						4. 
					</td>
					<td>
						Keuring Jamaah Haji
					</td>
					<td>
						'.$hcareservice[0]['LHaji'].'
						
					</td>
					<td>
						'.$hcareservice[0]['PHaji'].'
						
					</td>
					<td>
						'.$hcareservice[0]['Haji'].'
						
					</td>
				</tr>
				<tr>
					<td>
						5. 
					</td>
					<td>
						Keuring Olah Raga 
					</td>
					<td>
						'.$hcareservice[0]['LOlahr'].'
						
					</td>
					<td>
						'.$hcareservice[0]['POlahr'].'
						
					</td>
					<td>
						'.$hcareservice[0]['Olahr'].'
						
					</td>
				</tr>
				<tr>
					<td>
						6. 
					</td>
					<td>
						Keuring Calon Pengantin (sepasang)
					</td>
					<td>
						'.$hcareservice[0]['LPengantin'].'
						
					</td>
					<td>
						'.$hcareservice[0]['PPengantin'].'
						
					</td>
					<td>
						'.$hcareservice[0]['Pengantin'].'
						
					</td>
				</tr>
				<tr>
					<td>
						7. 
					</td>
					<td>
						Keuring Kesehatan Umum

					</td>
					<td>
						'.$hcareservice[0]['Lumum'].'
						
					</td>
					<td>
						'.$hcareservice[0]['Pumum'].'
						
					</td>
					<td>
						'.$hcareservice[0]['umum'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
						E. KEGIATAN PELAYANAN BPJS

					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						1. 
					</td>
					<td>
						Jumlah peserta BPJS yang terdaftar di Puskesmas 

					</td>
					<td>
						'.$hcaresourcepayment[0]['LBPJS'].'
						
					</td>
					<td>
						'.$hcaresourcepayment[0]['PBPJS'].'
						
					</td>
					<td>
						'.$hcaresourcepayment[0]['BPJS'].'
						
					</td>
				</tr>
				<tr>
					<td>
						2. 
					</td>
					<td>
						Jumlah peserta  JKN dan keluarganya yang dilayani /diobati

					</td>
					<td>
						'.$hcaresourcepayment[0]['LJKN'].'
						
					</td>
					<td>
						'.$hcaresourcepayment[0]['PJKN'].'
						
					</td>
					<td>
						'.$hcaresourcepayment[0]['JKN'].'
						
					</td>
				</tr>
				<tr>
					<td>
						3. 
					</td>
					<td>
						Jumlah kunjungan BP dan BPG / kuratif (BPJS)
					</td>
					<td>
						'.$hcaresourceservice[0]['LGUBPJS'].'
						
					</td>
					<td>
						'.$hcaresourceservice[0]['PGUBPJS'].'
						
					</td>
					<td>
						'.$hcaresourceservice[0]['GUBPJS'].'
						
					</td>
				</tr>
				<tr>
					<td>
							4. 
					</td>
					<td>
					Jumlah kunjungan KIA / preventif (BPJS) 
					</td>
					<td>
						'.$hcaresourceservice[0]['LKIABPJS'].'
						
					</td>
					<td>
						'.$hcaresourceservice[0]['PKIABPJS'].'
						
					</td>
					<td>
						'.$hcaresourceservice[0]['KIABPJS'].'
						
					</td>
				</tr>
				<tr>
					<td>
						5. 
					</td>
					<td>
						Jumlah kunjungan BPJS seluruhnya (jumlah No. 4 & No. 5)
					</td>
					<td>
						'.($hcaresourceservice[0]['LKIABPJS']+$hcaresourceservice[0]['LGUBPJS']).'
						
					</td>
					<td>
						'.($hcaresourceservice[0]['PKIABPJS']+$hcaresourceservice[0]['PGUBPJS']).'
						
					</td>
					<td>
						'.($hcaresourceservice[0]['KIABPJS']+$hcaresourceservice[0]['GUBPJS']).'
						
					</td>
				</tr>
				<tr>
					<td>
						6. 
					</td>
					<td>
						Jumlah kunjungan Umum seluruhnya (termasuk BPJS)
					</td>
					<td>
						'.$hcaresourceservice[0]['LSOURCEUMUM'].'
						
					</td>
					<td>
						'.$hcaresourceservice[0]['PSOURCEUMUM'].'
						
					</td>
					<td>
						'.$hcaresourceservice[0]['SOURCEUMUM'].'
						
					</td>
				</tr>
				<tr>
					<td>
						7. 
					</td>
					<td>
						Jumlah rujukan pasien(BPJS) ke Rumah Sakit
					</td>
					<td>
						'.$hcareugd[0]['LRUJUK'].'
					</td>
					<td>
						'.$hcareugd[0]['PRUJUK'].'
					</td>
					<td>
						'.$hcareugd[0]['RUJUK'].'
					</td>
				</tr>
				<tr>
					<td>
						8. 
					</td>
					<td>
						Jumlah rujukan penunjang diagnostik
					</td>
					<td>
						'.$hcareugd[0]['LRUJUK'].'
					</td>
					<td>
						'.$hcareugd[0]['PRUJUK'].'
					</td>
					<td>
						'.$hcareugd[0]['RUJUK'].'
					</td>
				</tr>
';

$close = "</table>";

$tbl = $header.$close;
$pdf->writeHTML($tbl, true, false, false, false, '');

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
					Kepala Puskesmas
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
					Jember, ........

					</td>
				</tr>
				<tr >
					<td>
					Koordinator SP2TP

					</td>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr >
					<td>
					<u>('.$nSP2TP.')</u>
					</td>
				</tr>
				<tr >
					<td>
					NIP. '.$nipSP2TP.'
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
';

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+