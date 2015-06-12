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
                <a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/queue' ?>" class="dropdown-toggle">Antrian Pasien</a>
            </li>
            <li class="<?php echo ($fungsi=='patient')?'active':''; ?>">
                <a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/patient' ?>" class="dropdown-toggle">Pasien</a>
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
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/riwayatObat/minta' ?>" >Riwayat Obat Minta</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/riwayatObat/masuk' ?>" >Riwayat Obat Masuk</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/riwayatObat/pemakaian' ?>">Riwayat Pemakaian Obat</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/riwayatObat/retur' ?>">Riwayat Retur Obat</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!--/.nav-collapse -->

</div>