<div class="container" >
	<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars icon-custom"></i>
                </button>
            </div>
    <div class="navbar-collapse collapse" st>
        <ul class="nav navbar-nav navbar-left">
            <?php $fungsi = $this->uri->segment(3, 0); ?>
            <li class="dropdown <?php echo ($fungsi == 'resepPasien') ? 'active' : ''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Resep Pasien</a>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/resepPasien/list' ?>">Daftar Permintaan Resep</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/resepPasien/riwayatTebusan' ?>">Riwayat Resep</a></li>
                </ul>
            </li>
            <li class="<?php echo ($fungsi == 'monitoringObat') ? 'active' : ''; ?>">
                <a href="<?= base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/monitoringObat' ?>" class="dropdown-toggle">Stok Obat</a>
            </li>
            <li class="<?php echo ($fungsi == 'obatMasuk') ? 'active' : ''; ?>">
                <a href="<?= base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/obatMasuk/daftar_pengiriman' ?>" class="dropdown-toggle">Obat Masuk</a>
            </li>
            <li class="<?php echo ($fungsi == 'obatKeluar') ? 'active' : ''; ?>">
                <a href="<?= base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/obatKeluar/retur' ?>" class="dropdown-toggle">Retur Obat</a>
            </li>
            <li class="<?php echo ($fungsi == 'request') ? 'active' : ''; ?>">
                <a href="<?= base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/request' ?>" class="dropdown-toggle">Permintaan Obat</a>
            </li>
            <li class="dropdown <?php echo ($fungsi == 'riwayatObat') ? 'active' : ''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Riwayat Obat</a>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/riwayatObat/minta' ?>">Obat Minta</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/riwayatObat/masuk' ?>">Obat Masuk</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/riwayatObat/retur' ?>">Riwayat Retur Obat</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!--/.nav-collapse -->
</div>