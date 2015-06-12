<?php
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

$tbl = '<table><tbody>';
$pdf->writeHTML($tbl, true, false, false, false, '');

//for ($i = 0; $i < sizeof($profil); $i++){
$tbl = 
'<tr>
    <td>Nama</td>
    <td></td>
</tr>
<tr>
    <td>Tgl Lahir / Umur</td>
    <td></td>
</tr>
<tr>
    <td>Jenis Kelamin</td>
    <td></td>
</tr>
<tr>
    <td>Alamat</td>
    <td></td>
</tr>
<tr>
    <td>Telepon</td>
    <td></td>
</tr>';
$pdf->writeHTML($tbl, true, false, false, false, '');
//}
            
$tbl = '</tbody></table>';
$pdf->writeHTML($tbl, true, false, false, false, '');

//$header = '
//<table>
//    <thead>
//        <tr>	
//            <th>SPESIMEN</th>
//            <th>KATEGORI PENGUJIAN</th>
//            <th>HASIL TES</th>
//            <th>SATUAN</th>
//            <th>NILAI NORMAL</th>
//            <th>TANGGAL TES</th>
//        </tr>
//    </thead>
//    <tbody>';
//$pdf->writeHTML($header, true, false, false, false, '');
//
//foreach ($laborat as $row){
//    $tbl = 
//    '<tr>
//        <td>'.$row['NAMA_PEM_LABORAT'].'</td>
//        <td>'.$row['NAMA_SPESIMEN'].'</td>
//        <td>'.$row['HASIL_TES_LAB'].'</td>
//        <td>'.$row['SATUAN_HASIL_UJI'].'</td>
//        <td>'.$row['NILAI_NORMAL_UJI'].'</td>
//        <td>'.$row['TANGGAL_TES_LAB'].'</td>
//    </tr>';
//    $pdf->writeHTML($tbl, true, false, false, false, '');
//}
//
//$tbl = '</tbody></table>';
//$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
$pdf->Output('hasil_laborat.pdf', 'I');
?>