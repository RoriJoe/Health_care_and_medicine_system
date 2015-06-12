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
	REKAP PENERIMAAN
	</td>
</tr>
<tr>
	<td style="width:15%">
	BULAN/TAHUN
	</td>
	<td style="width:15%" colspan="3">
	: 
	</td>
</tr>
<tr>
	<td style="width:15%">
	PUSKESMAS
	</td>
	<td style="width:15%">
	: 
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
	KECAMATAN
	</td>
	<td style="width:15%">
	: 
	</td>
	<td style="width:45%">
	</td>
	<td style="width:10%">
	</td>
	<td style="width:15%">
	</td>
</tr>
</table>
</b>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$header = <<<EOD
<table style="width:100%" cellspacing="0" cellpadding="1">
	<tr>
        <td style="width:80%">
			<table style="width:100%" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						A. KEGIATAN KUNJUNGAN PUSKESMAS
					</td>
				</tr>
				<tr>
					<td>
						1. Jumlah Keluarga (KK) baru yang tercatat di Puskesmas 
					</td>
				</tr>
				<tr>
					<td>
						2. Jumlah Kunjungan Puskesmas (baru)
					</td>
				</tr>
				<tr>
					<td>
						3. Jumlah Kunjungan Puskesmas (lama)
					</td>
				</tr>
				<tr>
					<td>
						4. Jumlah Kunjungan Rawat Jalan (baru)
					</td>
				</tr>
				<tr>
					<td>
						5. Jumlah Kunjungan Rawat Jalan (lama)
					</td>
				</tr>
				<tr>
					<td>
						6. Jumlah Kunjungan Rawat Jalan Gigi (baru)
					</td>
				</tr>
				<tr>
					<td>
						7. Jumlah Kunjungan Rawat Jalan Gigi (lama)
					</td>
				</tr>
				<tr>
					<td>
						8. Jumlah Kunjungan Rawat Jalan baru Gol. Umur > 60 tahun
					</td>
				</tr>
				<tr>
					<td>
						9. Jumlah Kunjungan Rawat Jalan lama Gol. Umur  > 60 tahun 
					</td>
				</tr>
				<tr>
					<td>
						10. Jumlah kunjungan  sesuai dengan jenis kepesertaan :(Jumlah point 2 & 3 di atas)
					</td>
				</tr>
				<tr>
					<td >
						<table style="width:100%" cellspacing="0" cellpadding="0">
							<tr>
								<td style="width:3%">
								</td>
								<td style="width:10%">
								</td>
								<td style="width:87%">
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td>
											a. Umum
											</td>
										</tr>
										<tr>
											<td>
											b. ASKES
											</td>
										</tr>
										<tr>
											<td>
											c. JAMKESMAS / JAMKESDA
											</td>
										</tr>
										<tr>
											<td>
											d. Lain- lain 
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						11. Jumlah Kasus baru
					</td>
				</tr>
				<tr>
					<td>
						12. Jumlah Kasus lama
					</td>
				</tr>
				<tr>
					<td>
						13. Jumlah kunjungan kasus lama
					</td>
				</tr>
				<tr>
					<td>
						14. Jumlah kunjungan kasus (jumlah No. 11 + No. 12 + No. 13)
					</td>
				</tr>
				<tr>
					<td>
						15. Jumlah penderita yang dilayani Dokter Umum (BP & KIA Puskesmas Induk)
					</td>
				</tr>
				<tr>
					<td>
						16. Jumlah pemeriksaan Gigi yang dilayani Dokter Gigi
					</td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td>
						B. KEGIATAN PELAYANAN KEGAWAT DARURATAN

					</td>
				</tr>
				<tr>
					<td>
						1. Jumlah penderita gawat darurat yang ditemukan
					</td>
				</tr>
				<tr>
					<td>
						2. Jumlah penderita gawat darurat yang ditangani (total) (Target : 100 % dari yang ditemukan)
					</td>
				</tr>
				<tr>
					<td>
						<table style="width:100%" cellspacing="0" cellpadding="0">
							<tr>
								<td style="width:3%">
								</td>
								<td style="width:10%">
								Rincian :
								</td>
								<td style="width:87%">
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td>
											a. Maternal 
											</td>
										</tr>
										<tr>
											<td>
											b. Neonatal 
											</td>
										</tr>
										<tr>
											<td>
											c. Bayi
											</td>
										</tr>
										<tr>
											<td>
											d. Anak Balita
											</td>
										</tr>
										<tr>
											<td>
											e. Penderita Kasus Kecelakaan Lalu lintas :
											</td>
										</tr>
										<tr>
											<td>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Luka Ringan 
											</td>
										</tr>
										<tr>
											<td>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Luka Berat 
											</td>
										</tr>
										<tr>
											<td>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Mati 
											</td>
										</tr>
										<tr>
											<td>
											f. Penderita dengan Penyakit potensial KLB
											</td>
										</tr>
										<tr>
											<td>
											g. Lain -lain
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						3. Jumlah penderita gawat darurat yang di rujuk ke Puskesmas perawatan / Rumah Sakit (total) (Target 25 % dari GD yang ditangani)
					</td>
				</tr>
				<tr>
					<td>
						<table style="width:100%" cellspacing="0" cellpadding="0">
							<tr>
								<td style="width:3%">
								</td>
								<td style="width:10%">
								Rincian :
								</td>
								<td style="width:87%">
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td>
											a. Maternal 
											</td>
										</tr>
										<tr>
											<td>
											b. Neonatal 
											</td>
										</tr>
										<tr>
											<td>
											c. Bayi
											</td>
										</tr>
										<tr>
											<td>
											d. Anak Balita
											</td>
										</tr>
										<tr>
											<td>
											e. Penderita Kasus Kecelakaan Lalu lintas :
											</td>
										</tr>
										<tr>
											<td>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Luka Ringan 
											</td>
										</tr>
										<tr>
											<td>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Luka Berat 
											</td>
										</tr>
										<tr>
											<td>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Mati 
											</td>
										</tr>
										<tr>
											<td>
											f. Penderita dengan Penyakit potensial KLB
											</td>
										</tr>
										<tr>
											<td>
											g. Lain -lain
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td>
						C. PEMERIKSAAN DIAGNOSTIK
					</td>
				</tr>
				<tr>
					<td>
						1. Jumlah pemeriksaan EKG
					</td>
				</tr>
				<tr>
					<td>
						2. Jumlah pemeriksaan USG
					</td>
				</tr>
				<tr>
					<td>
						3. Jumlah pemeriksaan Radiologi
					</td>
				</tr>
				<tr>
					<td>
						4. Jumlah pemeriksaan lainnya
					</td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td>
						D. PEMERIKSAAN KESEHATAN / KEURING
					</td>
				</tr>
				<tr>
					<td>
						1. Keuring Tenaga Kerja
					</td>
				</tr>
				<tr>
					<td>
						2. Keuring Pelajar
					</td>
				</tr>
				<tr>
					<td>
						3. Keuring Calon Transmigrasi
					</td>
				</tr>
				<tr>
					<td>
						4. Keuring Jamaah Haji
					</td>
				</tr>
				<tr>
					<td>
						5. Keuring Olah Raga 
					</td>
				</tr>
				<tr>
					<td>
						6. Keuring Calon Pengantin (sepasang)
					</td>
				</tr>
				<tr>
					<td>
						7. Keuring Kesehatan Umum

					</td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td>
						E. KEGIATAN PELAYANAN JKN

					</td>
				</tr>
				<tr>
					<td>
						1. Jumlah peserta JKN yang terdaftar di Puskesmas 

					</td>
				</tr>
				<tr>
					<td>
						2. Jumlah keluarga peserta JKN yang terdaftar di Puskesmas 

					</td>
				</tr>
				<tr>
					<td>
						3. Jumlah peserta  JKN dan keluarganya yang dilayani /diobati

					</td>
				</tr>
				<tr>
					<td>
						4. Jumlah kunjungan BP dan BPG / kuratif (peserta dan keluarga)

					</td>
				</tr>
				<tr>
					<td>
						5. Jumlah kunjungan KIA / preventif (peserta dan keluarga) 
					</td>
				</tr>
				<tr>
					<td>
						6. Jumlah kunjungan JKN seluruhnya (jumlah No. 4 & No. 5)
					</td>
				</tr>
				<tr>
					<td>
						7. Jumlah kunjungan Umum seluruhnya (termasuk JKN)
					</td>
				</tr>
				<tr>
					<td>
						8. Jumlah rujukan pasien ke Rumah Sakit
					</td>
				</tr>
				<tr>
					<td>
						9. Jumlah rujukan penunjang diagnostik
					</td>
				</tr>
			</table>
		</td>
        <td style="width:2%">
			<table style="width:100%" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
				<tr>
					<td>
						:
					</td>
				</tr>
			</table>
		</td>
        <td style="width:18%">
			<table style="width:100%" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
				<tr>
					<td>
						......
					</td>
				</tr>
			</table>
		</td>
    </tr>
EOD;

$close = "</table>";

$tbl = $header.$close;
$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = <<<EOD
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
					Kepala Puskesmas ...........
					</td>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr >
					<td>
					<u>dr. ...........</u>
					</td>
				</tr>
				<tr >
					<td>
					NIP. 19590428 198703 2 002
					</td>
				</tr>
			</table>
		</td>
		<td align=center style="width:50%">
			<table cellspacing="0" cellpadding="0" >
				<tr >
					<td>
					Malang, 01 Pebruari 2014

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
					<u>..............</u>
					</td>
				</tr>
				<tr >
					<td>
					NIP. 19680221 198901 2 001
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+