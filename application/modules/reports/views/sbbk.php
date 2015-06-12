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

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        //$image_file = K_PATH_IMAGES.'logo_example.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

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
$pdf->SetFont('times', '', 9);
$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
 //$pdf->Line(5, 10, 80, 30, $style);
$tbl = '

<table >
<tr align="center">
	<td width="20%" rowspan="5">
		<img width="77px" height="91px" src="'.base_url().'/assets/logo.png" />
	</td>
	<td width="80%">
		<h1>PEMERINTAH KABUPATEN JEMBER</h1>
	</td>
</tr>
<tr align="center">
	<td >
		<h1><b>DINAS KESEHATAN</b></h1>
	</td>
</tr>
<tr align="center">
	<td >
		<h1><b>GUDANG FARMASI KABUPATEN</b></h1>
	</td>
</tr>
<tr align="center">
	<td >
		Jl. Ciliwung No. 41 Telp. 0331-487173
	</td>
</tr>
<tr align="center">
	<td >
		Jember
	</td>
</tr>
</table>
<hr  style="border: 3px double #487;"/>
<table >
<tr align="center">
	<td colspan="2">
	</td>
</tr>
<tr align="center">
	<td colspan="2">
	SURAT BUKTI BARANG KELUAR
	</td>
</tr>
<tr align="center">
	<td colspan="2">
	( SBBK )
	</td>
</tr>
<tr align="center">
	<td colspan="2">
	
	</td>
</tr>
<tr >
	<td >
	Bukti Barang dari
	</td>
	<td >
	: UPT Gudang Farmasi Kab. Jember
	</td>
</tr>';

if(isset($sbbk))
$tbl .= '
<tr >
	<td >
	Kepada
	</td>
	<td >
	: '.$sbbk[0]['PUSKESMAS'].'
	</td>
</tr>
</table>
';
else
$tbl .= '
<tr >
	<td >
	Kepada
	</td>
	<td >
	: -
	</td>
</tr>
</table>
</b>
';


$pdf->writeHTML($tbl, true, false, false, false, '');


$tbl = '
<table cellspacing="0" cellpadding="1" border="1">
	<tr>
        <td align="center" width="10%" >NO.</td>
        <td align="center" width="20%">Tgl. Penyerahan barang menurut</td>
        <td align="center" width="50%">Nama dan Kode Barang</td>
		<td align="center" width="10%">Satuan</td>
		<td align="center" width="10%">Banyaknya / Satuan</td>
    </tr>
	<tr>
        <td align="center" >1</td>
        <td align="center" >2</td>
        <td align="center" >3</td>
		<td align="center" >4</td>
		<td align="center" >5</td>
    </tr>
';

$content = "";
$i = 0;
if(isset($sbbk))
foreach($sbbk as $data)
{
$i += 1;
$row ='
	<tr>
        <td align="center" >'.$i.'</td>
        <td align="center" >'.$data['TANGGAL'].'</td>
        <td >'.$data['OBAT'].'</td>
		<td align="center" >'.$data['SATUAN'].'</td>
		<td align="center" >'.$data['TOTAL'].'</td>
    </tr>';
$content= $content.$row;
}
else
{
$i += 1;
$row ='
<tr>
		 <td align="center">'.$i.'</td>
		 <td align="center">-</td>
		 <td align="center">-</td>
		 <td align="center">-</td>
		 <td align="center">-</td>

    </tr>';
$content= $content.$row;
}

$close = "</table>";
$tbl = $tbl.$content.$close;
$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table style="width:100%" cellspacing="0" cellpadding="1">
	<tr>
		<td width="30%">
		Puskesmas :
		</td>
		<td align="center" colspan="2">
		Dibuat di Jember :
		</td>
	</tr>
	<tr >
		<td >
			<table cellspacing="0" cellpadding="0" >
				<tr >
					<td>
					Yang Menerima
					</td>
				</tr>
				<tr >
					<td>
					Tanda Tangan :
					</td>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr >
					<td>
					Nama	:
					</td>
				</tr>
				<tr >
					<td>
					NIP		:
					</td>
				</tr>
				<tr >
					<td>
					Pangkat / Gol:
					</td>
				</tr>
			</table>
		</td>
		<td  >
			<table cellspacing="0" cellpadding="0" >
				<tr >
					<td>
					Sie Penyimpanan & Penyaluran
					</td>
				</tr>
				<tr >
					<td>
					Tanda Tangan	:
					</td>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr >
					<td>
					Nama	:
					</td>
				</tr>
				<tr >
					<td>
					NIP		:
					</td>
				</tr>
				<tr >
					<td>
					Pangkat / Gol:
					</td>
				</tr>
			</table>
		</td>
		<td  >
			<table cellspacing="0" cellpadding="0" >
				<tr >
					<td>
Sie Pelaksanaan Distribusi
					</td>
				</tr>
				<tr >
					<td>
					Tanda Tangan

					</td>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr >
					<td>
					Nama	:
					</td>
				</tr>
				<tr >
					<td>
					NIP		:
					</td>
				</tr>
				<tr >
					<td>
					Pangkat / Gol:
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr >
		<td width="20%" >
		</td>
		<td   colspan="2">
		</td>
	</tr>
	<tr >
		<td width="20%" >
		</td>
		<td   colspan="2">
			<table cellspacing="0" cellpadding="0" >
				<tr >
					<td align="center">
Mengetahui/menyetujui
					</td>
				</tr>
				<tr >
					<td align="center">
Kepala Gudang Farmasi
					</td>
				</tr>
				<tr >
					<td align="center">
Kabupaten Jember
					</td>
				</tr>
				<tr >
					<td>
					Tanda Tangan

					</td>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr >
					<td>
					Nama	:
					</td>
				</tr>
				<tr >
					<td>
					NIP		:
					</td>
				</tr>
				<tr >
					<td>
					Pangkat / Gol:
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+