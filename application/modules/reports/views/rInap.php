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
	LAPORAN BULANAN PELAYANAN RAWAT INAP
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

$jumhariperawatan = ($riRIH[0]['hUmum']+$riRIH[0]['hSKM']+$riRIH[0]['hBPJS']);
$jumpenderitakeluar = ($rikeluar[0]['RIKELUARSEMBUH']+$rikeluar[0]['RIKELUARMENINGGAL']+$rikeluar[0]['RIKELUARPAKSA']+$rikeluar[0]['RIKELUARRUJUKAN']);
$jumlahBed = $riBedDetail[0]['BIASA']+$riBedDetail[0]['KHUSUS']+$riBedDetail[0]['PONED'];
$jumlahri = $riC[0]['BIASA']+$riC[0]['KHUSUS']+$riC[0]['PONED'];

if($jumlahri == 0)
$alos = 0;
else
$alos = number_format(($jumhariperawatan/$jumlahri), 2, '.', '');;

if($jumlahBed == 0)
$bto = 0;
else
$bto = number_format(($jumpenderitakeluar/$jumlahBed), 2, '.', '');;

if($jumpenderitakeluar == 0)
$toi = 0;
else
$toi = number_format(((($jumlahBed*cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun))-$jumhariperawatan)/$jumpenderitakeluar), 2, '.', '');

if($riBedDetail[0]['BIASA']+$riBedDetail[0]['KHUSUS']+$riBedDetail[0]['PONED'] == 0)
$val = 0;
else
$val= number_format(((($riRIH[0]['hUmum']+$riRIH[0]['hSKM']+$riRIH[0]['hBPJS'])/(($riBedDetail[0]['BIASA']+$riBedDetail[0]['KHUSUS']+$riBedDetail[0]['PONED'])*cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun)))*100), 2, '.', '');

$header = '
<table border="1" cellspacing="0" cellpadding="1">
<tr>
					<td align="center" width="6%">
						NO.
					</td>
					<td align="center" width="60%">
						URAIAN
					</td>
					<td align="center" width="6%">
						L
					</td>
					<td align="center" width="6%">
						P
					</td>
					<td align="center" width="10%">
						JUMLAH
					</td>
				</tr>
				<tr>
					<td>
						1.
					</td>
					<td>
						Jumlah Tempat Tidur (TT) untuk fasilitas Rawat Inap(=a+b+c)
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center" >
						'.($riBedDetail[0]['BIASA']+$riBedDetail[0]['KHUSUS']+$riBedDetail[0]['PONED']).'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Tempat tidur (TT) Perawatan Biasa
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center">
						'.$riBedDetail[0]['BIASA'].'
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Dewasa
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center">
						'.$riBedDetail[0]['BDEWASA'].'
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Anak
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center">
						'.$riBedDetail[0]['BANAK'].'
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Bayi
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center">
						'.$riBedDetail[0]['BBAYI'].'
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Tempat Tidur (TT) Perawat Khusus
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center">
						'.$riBedDetail[0]['KHUSUS'].'
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Dewasa
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center">
						'.$riBedDetail[0]['KDEWASA'].'
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Anak
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center">
						'.$riBedDetail[0]['KANAK'].'
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Bayi
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center" >
						'.$riBedDetail[0]['KBAYI'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Tempat Tidur PONED
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center" >
						'.$riBedDetail[0]['PONED'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Dewasa
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center" >
						'.$riBedDetail[0]['PDEWASA'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Neonatal
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center" >
						'.$riBedDetail[0]['PNEONATAL'].'
						
					</td>
				</tr>
				<tr>
					<td>
						4.
					</td>
					<td>
					Jumlah kunjungan Rawat Inap Baru
					</td>
					<td align="center" >
						'.$riVSDetail[0]['LBaru'].'
						
					</td>
					<td align="center" >
						'.$riVSDetail[0]['PBaru'].'
						
					</td>
					<td align="center" >
						'.$riVSDetail[0]['Baru'].'
						
					</td>
				</tr>
				<tr>
					<td>
						5.
					</td>
					<td>
					Jumlah kunjungan Rawat Inap Lama
					</td>
					<td align="center" >
						'.$riVSDetail[0]['LLama'].'
						
					</td>
					<td align="center" >
						'.$riVSDetail[0]['PLama'].'
						
					</td>
					<td align="center" >
						'.$riVSDetail[0]['Lama'].'
						
					</td>
				</tr>
				<tr>
					<td>
						6.
					</td>
					<td>
						Jumlah kunjungan Rawat Inap (= a+b+c)
					</td>
					<td align="center" >
						'.($riC[0]['LBIASA']+$riC[0]['LKHUSUS']+$riC[0]['LPONED']).'
						
					</td>
					<td align="center" >
						'.($riC[0]['PBIASA']+$riC[0]['PKHUSUS']+$riC[0]['PPONED']).'
						
					</td>
					<td align="center" >
						'.($riC[0]['BIASA']+$riC[0]['KHUSUS']+$riC[0]['PONED']).'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Perawatan Biasa
					</td>
					<td align="center" >
						'.$riC[0]['LBIASA'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['PBIASA'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['BIASA'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Dewasa
					</td>
					<td align="center" >
						'.$riC[0]['LBDEWASA'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['PBDEWASA'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['BDEWASA'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Anak
					</td>
					<td align="center" >
						'.$riC[0]['LBANAK'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['PBANAK'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['BANAK'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Bayi
					</td>
					<td align="center" >
						'.$riC[0]['LBBAYI'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['PBBAYI'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['BBAYI'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Perawatan Khusus
					</td>
					<td align="center" >
						'.$riC[0]['LKHUSUS'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['PKHUSUS'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['KHUSUS'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Dewasa
					</td>
					<td align="center" >
						'.$riC[0]['LKDEWASA'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['PKDEWASA'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['KDEWASA'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Anak
					</td>
					<td align="center" >
						'.$riC[0]['LKANAK'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['PKANAK'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['KANAK'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Bayi
					</td>
					<td align="center" >
						'.$riC[0]['LKBAYI'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['PKBAYI'].'
						
					</td>
					<td align="center" >
						'.$riC[0]['KBAYI'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Perawatan PONED
					</td>
					<td  align="center" >
						'.$riC[0]['LPONED'].'
						
					</td>
					<td  align="center" >
						'.$riC[0]['PPONED'].'
						
					</td>
					<td  align="center" >
						'.$riC[0]['PONED'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Dewasa
					</td>
					<td  align="center" >
						'.$riC[0]['LPDEWASA'].'
						
					</td>
					<td  align="center" >
						'.$riC[0]['PPDEWASA'].'
						
					</td>
					<td  align="center" >
						'.$riC[0]['PDEWASA'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Neonatal
					</td>
					<td  align="center" >
						'.$riC[0]['LPNEONATAL'].'
						
					</td>
					<td  align="center" >
						'.$riC[0]['PPNEONATAL'].'
						
					</td>
					<td  align="center" >
						'.$riC[0]['PNEONATAL'].'
						
					</td>
				</tr>
				<tr>
					<td>
						7.
					</td>
					<td>
					Jumlah penderita berdasarkan jenis kunjungan (a+b+c)
					</td>
					<td align="center" >
						'.($riVC[0]['LBPJS']+$riVC[0]['LSKM']+$riVC[0]['LUmum']).'
						
					</td>
					<td align="center" >
						'.($riVC[0]['PBPJS']+$riVC[0]['PSKM']+$riVC[0]['PUmum']).'
						
					</td>
					<td align="center" >
						'.($riVC[0]['BPJS']+$riVC[0]['SKM']+$riVC[0]['Umum']).'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. BPJS (Askes, Jamsostek, Jamkesmas, Jampersal)
					</td>
					<td align="center" >
						'.$riVC[0]['LBPJS'].'
						
					</td>
					<td align="center" >
						'.$riVC[0]['PBPJS'].'
						
					</td>
					<td align="center" >
						'.$riVC[0]['BPJS'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. SKM
					</td>
					<td align="center" >
						'.$riVC[0]['LSKM'].'
						
					</td>
					<td align="center" >
						'.$riVC[0]['PSKM'].'
						
					</td>
					<td align="center" >
						'.$riVC[0]['SKM'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Umum
					</td>
					<td align="center" >
						'.$riVC[0]['LUmum'].'
						
					</td>
					<td align="center" >
						'.$riVC[0]['PUmum'].'
						
					</td>
					<td align="center" >
						'.$riVC[0]['Umum'].'
						
					</td>
				</tr>
				<tr>
					<td>
						8.
					</td>
					<td>
					Jumlah Hari Perawatan (HP) (a+b+c)
					</td>
					<td align="center" >
						'.($riRIH[0]['LhUmum']+$riRIH[0]['LhSKM']+$riRIH[0]['LhBPJS']).'
						
					</td>
					<td align="center" >
						'.($riRIH[0]['PhUmum']+$riRIH[0]['PhSKM']+$riRIH[0]['PhBPJS']).'
						
					</td>
					<td align="center" >
						'.($riRIH[0]['hUmum']+$riRIH[0]['hSKM']+$riRIH[0]['hBPJS']).'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. BPJS (Askes, Jamsostek, Jamkesmas, Jampersal)
					</td>
					<td align="center" >
						'.$riRIH[0]['LhBPJS'].'
						
					</td>
					<td align="center" >
						'.$riRIH[0]['PhBPJS'].'
						
					</td>
					<td align="center" >
						'.$riRIH[0]['hBPJS'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. SKM
					</td>
					<td align="center" >
						'.$riRIH[0]['LhSKM'].'
						
					</td>
					<td align="center" >
						'.$riRIH[0]['PhSKM'].'
						
					</td>
					<td align="center" >
						'.$riRIH[0]['hSKM'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Umum
					</td>
					<td align="center" >
						'.$riRIH[0]['LhUmum'].'
						
					</td>
					<td align="center" >
						'.$riRIH[0]['PhUmum'].'
						
					</td>
					<td align="center" >
						'.$riRIH[0]['hUmum'].'
						
					</td>
				</tr>
				<tr>
					<td>
						9.
					</td>
					<td>
					Jumlah penderita yang keluar (a+b+c)
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center">
						'.($rikeluar[0]['RIKELUARSEMBUH']+$rikeluar[0]['RIKELUARMENINGGAL']+$rikeluar[0]['RIKELUARPAKSA']+$rikeluar[0]['RIKELUARRUJUKAN']).'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Sembuh
					</td>
					<td align="center" >
						'.$rikeluar[0]['LRIKELUARSEMBUH'].'
						
					</td>
					<td align="center" >
						'.$rikeluar[0]['PRIKELUARSEMBUH'].'
						
					</td>
					<td align="center" >
						'.$rikeluar[0]['RIKELUARSEMBUH'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Meninggal Dunia
					</td>
					<td align="center" >
						'.$rikeluar[0]['LRIKELUARMENINGGAL'].'
						
					</td>
					<td align="center" >
						'.$rikeluar[0]['PRIKELUARMENINGGAL'].'
						
					</td>
					<td align="center" >
						'.$rikeluar[0]['RIKELUARMENINGGAL'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td >
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Pulang paksa / APS
					</td>
					<td align="center" >
						'.$rikeluar[0]['LRIKELUARPAKSA'].'
						
					</td>
					<td align="center" >
						'.$rikeluar[0]['PRIKELUARPAKSA'].'
						
					</td>
					<td align="center" >
						'.$rikeluar[0]['RIKELUARPAKSA'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d. Rujukan
					</td>
					<td align="center" >
						'.$rikeluar[0]['LRIKELUARRUJUKAN'].'
						
					</td>
					<td align="center" >
						'.$rikeluar[0]['PRIKELUARRUJUKAN'].'
						
					</td>
					<td align="center" >
						'.$rikeluar[0]['RIKELUARRUJUKAN'].'
						
					</td>
				</tr>
									
				<tr>
					<td>
						10.
					</td>
					<td>
						Bed Occupancy Rate (BOR)
					</td>
					<td align="center" >
						0%
					</td>
					<td align="center" >
						0%
					</td>
					<td align="center" >
						'.$val.'%
						
					</td>
				</tr>
				<tr>
					<td>
						11. 
					</td>
					<td>
						Average Length of Stay (ALOS)
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center">
						'.$alos.'
					</td>
				</tr>
				<tr>
					<td>
						12. 
					</td>
					<td>
						Bed Turn Over (BTO)
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center">
						'.$bto.'
						
					</td>
				</tr>
				<tr>
					<td>
						13. 
					</td>
					<td>
						Turn Over Interval (TOI)
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center">
						'.$toi.'
						
					</td>
				</tr>
				<tr>
					<td>
						14. 
					</td>
					<td>
						Jumlah Penderita yang meninggal dunia sebelum 48 jam perawatan
					</td>
					<td align="center" >
						'.$riDT[0]['LUNDER'].'
						
					</td>
					<td align="center" >
						'.$riDT[0]['PUNDER'].'
						
					</td>
					<td align="center" >
						'.$riDT[0]['UNDER'].'
						
					</td>
				</tr>
				<tr>
					<td>
						15. 
					</td>
					<td>
						Jumlah Penderita yang meninggal dunia sesudah 48 jam perawatan
					</td>
					<td align="center" >
						'.$riDT[0]['LMORE'].'
						
					</td>
					<td align="center" >
						'.$riDT[0]['PMORE'].'
						
					</td>
					<td align="center" >
						'.$riDT[0]['MORE'].'
						
					</td>
				</tr>
				<tr>
					<td>
						16. 
					</td>
					<td>
						Jumlah kasus diare yang dirawat

					</td>
					<td align="center" >
						'.$riDBA[0]['LDewasa'].'
						
					</td>
					<td align="center" >
						'.$riDBA[0]['PDewasa'].'
						
					</td>
					<td align="center" >
						'.$riDBA[0]['Dewasa'].'
						
					</td>
				</tr>
				<tr>
					<td>
						17. 
					</td>
					<td>
						Jumlah kasus diare balita yang dirawat
					</td>
					<td align="center" >
						'.$riDBA[0]['LBalita'].'
						
					</td>
					<td align="center" >
						'.$riDBA[0]['PBalita'].'
						
					</td>
					<td align="center" >
						'.$riDBA[0]['Balita'].'
						
					</td>
				</tr>
				<tr>
					<td>
						18. 
					</td>
					<td>
						Jumlah kematian kasus diare setelah dirawat sesudah 48 jam
					</td>
					<td align="center" >
						'.$riDT[0]['LDMORE'].'
						
					</td>
					<td align="center" >
						'.$riDT[0]['PDMORE'].'
						
					</td>
					<td align="center" >
						'.$riDT[0]['DMORE'].'
						
					</td>
				</tr>
				
				<tr>
					<td>
						19.
					</td>
					<td>
					Jumlah kasus pneumonia balita yang dirawat inap
					</td>
					<td align="center" >
						'.$riBP[0]['LPneumonia'].'
						
					</td>
					<td align="center" >
						'.$riBP[0]['PPneumonia'].'
						
					</td>
					<td align="center" >
						'.$riBP[0]['Pneumonia'].'
						
					</td>
				</tr>
				<tr>
					<td>
						20.
					</td>
					<td>
					Jumlah ibu hamil (dengan kelainan) yang dirawat
					</td>
					<td align="center" >
						0
					</td>
					<td align="center" >
						0
					</td>
					<td align="center" >
						'.$rivkkia[0]['HAMILK'].'
						
					</td>
				</tr>
				<tr>
					<td>
						21.
					</td>
					<td>
					Jumlah ibu melahirkan (dengan kelainan) yang dirawat
					</td>
					<td align="center" >
						0
					</td>
					<td align="center" >
						0
					</td>
					<td align="center" >
						'.$rivkkia[0]['LAHIRK'].'
						
					</td>
				</tr>
				<tr>
					<td>
						22.
					</td>
					<td>
					Jumlah ibu nifas (dengan kelainan) yang dirawat
					</td>
					<td align="center" >
						0
					</td>
					<td align="center" >
						0
					</td>
					<td align="center" >
						'.$rivkkia[0]['NIFASK'].'
						
					</td>
				</tr>
				<tr>
					<td>
						23.
					</td>
					<td>
					 Jumlah balita (dengan kelainan) yang dirawat
					</td>
					<td>
						0
					</td>
					<td>
						0
					</td>
					<td>
						0
					</td>
				</tr>
				<tr>
					<td>
						24.
					</td>
					<td>
					Jumlah penderita cedera/kecelakaan lalu lintas yang dirawat
					</td>
					<td align="center" >
						'.$rivll[0]['LLAKALANTAS'].'
						
					</td>
					<td align="center" >
						'.$rivll[0]['PLAKALANTAS'].'
						
					</td>
					<td align="center" >
						'.$rivll[0]['LAKALANTAS'].'
						
					</td>
				</tr>
				<tr>
					<td>
						25
					</td>
					<td>
					Pelayanan PONED (khusus Puskesmas PONED)
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
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Jumlah penderita kasus Maternal Risti/komplikasi
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center" >
						'.$riPoned[0]['Materna'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Jumlah penderita kasus Neonatal Risti/komplikasi
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center" >
						'.$riPoned[0]['Neonata'].'
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Jumlah persalinan normal
					</td>
					<td>
						
					</td>
					<td>
						
					</td>
					<td align="center" >
						'.$riPoned[0]['Normal'].'
						
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Jumlah bayi baru lahir
					</td>
					<td>
						0
					</td>
					<td>
						0
					</td>
					<td align="center" >
						'.$riPoned[0]['Baru'].'
						
					</td>
				</tr>
';

$close = "</table>";

$tbl = $header.$close;
$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = '
<table style="width:100%" cellspacing="0" cellpadding="1">
	<tr >
		<td  style="width:50%">
			<table cellspacing="0" cellpadding="0" >
				<tr >
					<td align="center" colspan="2">
					Jember, ...............
					</td>
				</tr>
				<tr >
					<td align="center" colspan="2">
					Kepala Puskesmas ...........
					</td>
				</tr>
				<tr><td></td><td></td></tr>
				<tr><td></td><td></td></tr>
				<tr><td></td><td></td></tr>
				<tr >
					<td align="center" colspan="2">
					<u>('.$nKP.')</u>
					</td>
				</tr>
				<tr >
					<td width="30%">
					</td>
					<td>
					NIP. '.$nipKP.'
					</td>
				</tr>
			</table>
		</td>
		<td  style="width:50%">
			<table cellspacing="0" cellpadding="0" >
				<tr >
					<td colspan="2">

					</td>
				</tr>
				<tr >
					<td align="center" colspan="2">
					Koordinator Rawat Inap

					</td>
				</tr>
				<tr><td></td><td></td></tr>
				<tr><td></td><td></td></tr>
				<tr><td></td><td></td></tr>
				<tr >
					<td align="center" colspan="2">
					<u>('.$nKRI.')</u>
					</td>
				</tr>
				<tr >
					<td width="30%">
					</td>
					<td>
					NIP. '.$nipKRI.'
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