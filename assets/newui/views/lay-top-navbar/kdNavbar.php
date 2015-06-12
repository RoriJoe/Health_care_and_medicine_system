<?php
	$fungsi = 'monitoringObat';
?>
<div class="container" >
	<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars icon-custom"></i>
                </button>
            </div>
    <div class="navbar-collapse collapse" st>
        <ul class="nav navbar-nav navbar-left">
            <?php $fungsi= $this->uri->segment(3, 0); ?>
            <li class="<?php echo ($fungsi=='monitoringObat')?'active':''; ?>">
                <a href="<?= base_url().'drugHC/'.$this->uri->segment(2, 0).'/monitoringObat' ?>" class="dropdown-toggle">Monitoring Obat</a>
            </li>
			<li class="<?php echo ($fungsi=='queue')?'active':''; ?>">
                <a href="<?= base_url().'regBooth/'.$this->uri->segment(2, 0).'/queue' ?>" class="dropdown-toggle">Monitoring Pelayanan</a>
            </li>
			<li class="<?php echo ($fungsi=='queueRI')?'active':''; ?>">
                <a href="<?= base_url().'regBooth/'.$this->uri->segment(2, 0).'/patientRI' ?>" class="dropdown-toggle">Monitoring Rawat Inap</a>
            </li>
			<li class="<?php echo ($fungsi=='monitoringSDM')?'active':''; ?>">
                <a href="<?= base_url().'account/'.$this->uri->segment(2, 0).'/monitoringSDM' ?>" class="dropdown-toggle">Monitoring SDM</a>
            </li>
            <li class="dropdown <?php echo ($fungsi=='report')?'active':''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Laporan</a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/drugStockCardPdf'; ?>">Laporan Kartu Stok Gudang Obat</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/drugAchievedUnitdf'; ?>">Laporan Penerimaan Obat Unit</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/drugUsedUnitdf'; ?>">Laporan Pemakaian Obat Unit</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/opname'; ?>">Laporan Stok Opname Obat Unit</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/LPLPO'; ?>">Laporan LPLPO Unit</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/LPLPOHc'; ?>">Laporan LPLPO Puskesmas</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/diseasePdf'; ?>">Laporan LB 1</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/diseaseByAgePdf'; ?>">Laporan Kesakitan Berdasarkan Umur</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/diseaseHighestPdf'; ?>">Laporan 15 Penyakit Terbanyak</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/diseaseByAgeHCarePdf'; ?>">Laporan Per Penyakit</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/hCare'; ?>">Laporan Pelayanan</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/inventarisPdf'; ?>">Laporan Inventaris Barang</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/sdmHc'; ?>">Laporan SDM</a></li>
							<li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/rInap'; ?>">Laporan Rawat Inap</a></li>
							<li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/labPdf'; ?>">Laporan Laboratorium</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>