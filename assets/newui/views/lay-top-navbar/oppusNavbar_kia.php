<div class="container" >
	<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars icon-custom"></i>
                </button>
            </div>
    <div class="navbar-collapse collapse" st>
        <ul class="nav navbar-nav navbar-left">
            <?php $fungsi = $this->uri->segment(3, 0); ?>
            <?php if($this->uri->segment(4, 0)=="kia" || $this->uri->segment(4, 0)=="kb" || 
                     $this->uri->segment(4, 0)=="vkkia" || $this->uri->segment(4, 0)=="balita"): ?>
            <li class="<?php echo ($fungsi == 'dataRiwayat') ? 'active' : ''; ?>">
                <a href="<?= base_url() . $this->uri->segment(1, 0) . '/kia/dataRiwayat/'.$this->uri->segment(4, 0) ?>" class="dropdown-toggle">Antrian Pasien</a>
            </li>
            <?php endif; ?>
            <li class="dropdown <?php echo ($fungsi == 'patient') ? 'active' : ''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Pasien</a>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) . '/pu/patient' ?>">Poli Umum</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) . '/kia/patient/kia' ?>">Poli KIA Ibu Hamil</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) . '/kia/patient/vkkia' ?>">Poli KIA VK KIA</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) . '/kia/patient/balita' ?>">Poli KIA Anak-Balita</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) . '/kia/patient/kb' ?>">Poli KIA KB</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Poli Pustu</a>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) . '/lp' ?>">Loket Pendaftaran</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) . '/pu' ?>">Poli Umum</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) . '/oppus/queue' ?>">Poli KIA</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) . '/lo' ?>">Loket Obat</a></li>
                </ul>
            </li>
            <li class="<?php echo ($fungsi=='receipt')?'active':''; ?>">
                <a href="<?= base_url().$this->uri->segment(1, 0).'/kia/receipt/listPasien' ?>" class="dropdown-toggle">Resep Pasien</a>
            </li>
            <li class="dropdown <?php echo ($fungsi == 'report') ? 'active' : ''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Obat</a>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) .'/oppus/monitoringObat' ?>">Stok Obat</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) .'/oppus/request' ?>">Permintaan Obat</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) .'/oppus/obatMasuk/daftar_pengiriman' ?>">Penerimaan Obat</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/oppus/obatKeluar/pemakaian' ?>">Pemakaian Obat</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/oppus/obatKeluar/retur' ?>">Retur Obat</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/oppus/riwayatObat/pemakaian' ?>">Riwayat Pemakaian Obat</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/oppus/riwayatObat/minta' ?>">Riwayat Obat Minta</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/oppus/riwayatObat/masuk' ?>">Riwayat Obat Masuk</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/oppus/riwayatObat/retur' ?>">Riwayat Retur Obat</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!--/.nav-collapse -->
</div>