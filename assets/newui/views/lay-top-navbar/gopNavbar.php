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
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Monitoring Obat</a>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/monitoringObat/gop' ?>">Monitoring Obat GOP</a></li>
                    <li><a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/monitoringObat/allUnit' ?>">Monitoring Obat Layanan/Unit</a></li>
                </ul>
            </li>
            <li class="<?php echo ($fungsi=='obatKeluar')?'active':''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Obat Keluar</a>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/obatKeluar/newApotik' ?>">Pengiriman ke Apotik</a></li>
                    <li><a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/obatKeluar/newPoli' ?>">Pengiriman ke Layanan/Unit</a></li>
                    <li><a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/obatKeluar/newPustu' ?>">Pengiriman ke Puskesmas Pembantu</a></li>
                    <li><a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/obatKeluar/permintaan_apotik' ?>">Permintaan dari Apotik</a></li>
                    <li><a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/obatKeluar/permintaan_poli' ?>">Permintaan dari Layanan/Unit</a></li>
                    <li><a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/obatKeluar/permintaan_pustu' ?>">Permintaan dari Puskesmas Pembantu</a></li>
                    <li><a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/obatKeluar/retur' ?>">Retur Obat ke GFK</a></li>
                    <li><a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/obatKeluar/buang' ?>">Pembuangan Obat</a></li>
                </ul>
            </li>
            <li class="<?php echo ($fungsi=='obatMasuk')?'active':''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Obat Masuk</a>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/obatMasuk/dariGfk' ?>">Pengiriman dari GFK</a></li>
                    <li><a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/obatMasuk/penambahan' ?>">Pengiriman selain dari GFK</a></li>
                    <li><a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/obatMasuk/returUnit' ?>">Penerimaan Retur dari Unit</a></li>
                </ul>
            </li>
            <li class="<?php echo ($fungsi=='request')?'active':''; ?>">
                <a href="<?= base_url().'drughc' . '/' . $this->uri->segment(2, 0).'/request' ?>" class="dropdown-toggle">Permintaan Obat ke GFK</a>
            </li>
            <li class="dropdown <?php echo ($fungsi=='riwayatObat')?'active':''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Riwayat</a>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url().'drughc'.'/'.$this->uri->segment(2, 0).'/riwayatObat/minta' ?>">Obat Minta</a></li>
                    <li><a href="<?= base_url().'drughc'.'/'.$this->uri->segment(2, 0).'/riwayatObat/masuk' ?>">Obat Masuk</a></li>
                    <li><a href="<?= base_url().'drughc'.'/'.$this->uri->segment(2, 0).'/riwayatObat/keluar' ?>">Obat Keluar</a></li>
                    <li><a href="<?= base_url().'drughc'.'/'.$this->uri->segment(2, 0).'/riwayatObat/retur' ?>">Retur Obat ke GFK</a></li>
                    <li><a href="<?= base_url().'drughc'.'/'.$this->uri->segment(2, 0).'/riwayatObat/returMasuk' ?>">Penerimaan Retur Obat dari Unit</a></li>
                </ul>
            </li>
            <li class="dropdown <?php echo ($fungsi=='report')?'active':''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Laporan</a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url();?>index.php/reports/<?= $this->uri->segment(2, 0) ?>/drugAchievedUnitdf" target="_blank">Laporan Penerimaan Obat</a></li>
                    <li><a href="<?php echo base_url();?>index.php/reports/<?= $this->uri->segment(2, 0) ?>/drugUsedUnitdf" target="_blank">Laporan Pemakaian Obat</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/opname'; ?>">Laporan Stok Opname Obat Unit</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/LPLPO'; ?>">Laporan LPLPO Unit</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/LPLPOHc'; ?>">Laporan LPLPO Puskesmas</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>