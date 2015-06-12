<div class="container" >
    <div class="row">
        <?php 
        $func = $this->uri->uri_string();
        $fungsi= $this->uri->segment(3, 0); ?>
        <ul class="nav navbar-nav navbar-left">
            <li class="<?php echo ($func == 'laboratorium/lab') ? 'active' : ''; ?>">
                <a href="<?php echo base_url(); ?>laboratorium/lab" data-close-others="true">Antrian Pasien</a>
            </li>
            <li class="<?php echo ($func == 'laboratorium/lab/masterTestList') ? 'active' : ''; ?>">
                <a href="<?php echo base_url(); ?>laboratorium/lab/masterTestList" data-close-others="true">Master Pengujian</a>
            </li>
            <li class="<?php echo ($func == 'poliumum/pg/receipt') ? 'active' : ''; ?>">
                <a href="<?php echo base_url(); ?>laboratorium/lab/patient" data-close-others="true">Riwayat Pasien</a>
            </li>
            <li class="dropdown <?php echo ($func=='laboratorium/lab/monitoringObat' ||
                    $func=='laboratorium/lab/obatMasuk/daftar_pengiriman' || 
                    $func=='laboratorium/lab/request' ||
                    $func=='laboratorium/lab/obatKeluar/pemakaian' ||
                    $func=='laboratorium/lab/obatKeluar/retur')?'active':''; ?>">
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
</div>