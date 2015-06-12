<div class="container" >
	<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars icon-custom"></i>
                </button>
            </div>
    <div class="navbar-collapse collapse" st>
        <ul class="nav navbar-nav navbar-left">
            <?php $fungsi= $this->uri->segment(3, 0); ?>
            <li class="<?php echo ($fungsi=='queue')?'active':''; ?>">
                <a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/queue' ?>" class="dropdown-toggle">Dashboard</a>
            </li>
            <?php
            if(strpos($this->uri->segment(4, 0), 'kia') !== FALSE || strpos($this->uri->segment(4, 0), 'balita') !== FALSE || strpos($this->uri->segment(4, 0), 'vkkia') !== FALSE || strpos($this->uri->segment(4, 0), 'kb') !== FALSE){ ?>
            <li class="<?php echo ($fungsi == 'dataRiwayat') ? 'active' : ''; ?>">
                <a href="<?= base_url() . $this->uri->segment(1, 0) . '/kia/dataRiwayat/'.$this->uri->segment(4, 0) ?>" class="dropdown-toggle">Antrian Pasien</a>
            </li>
            <?php } ?>
            <li class="dropdown <?php echo ($fungsi=='patient')?'active':''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Pasien</a>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/patient/kia' ?>">Ibu Hamil</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/patient/vkkia' ?>">VK KIA</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/patient/balita' ?>">Anak-Balita</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/patient/kb' ?>">KB</a></li>
                </ul>
            </li>
            <li class="<?php echo ($fungsi=='receipt')?'active':''; ?>">
                <a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/receipt/listPasien' ?>" class="dropdown-toggle">Resep Pasien</a>
            </li>
            <li class="dropdown <?php echo ($fungsi=='request' || $fungsi=='obatMasuk')?'active':''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Obat</a>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/monitoringObat' ?>">Stok Obat</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/request' ?>">Permintaan Obat</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/obatMasuk/daftar_pengiriman' ?>">Penerimaan Obat</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/obatKeluar/pemakaian' ?>">Pemakaian Obat</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/obatKeluar/retur' ?>">Retur Obat</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) .'/'.$this->uri->segment(2, 0). '/riwayatObat/minta' ?>" >Riwayat Obat Minta</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) .'/'.$this->uri->segment(2, 0). '/riwayatObat/masuk' ?>" >Riwayat Obat Masuk</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/riwayatObat/pemakaian' ?>">Riwayat Pemakaian Obat</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/riwayatObat/retur' ?>">Riwayat Retur Obat</a></li>
                </ul>
            </li>
        </ul>
    </div>

</div>