<div class="container" >
<div class="row">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="navbar-collapse collapse">

		<?php $func= $this->uri->uri_string();?>
		<ul class="nav navbar-nav navbar-left">
			<li class="<?php echo ($func == 'poliumum/'.$this->uri->segment(2).'/queue')?'active':''; ?>">
				<a href="<?php echo base_url().'poliumum/'.$this->uri->segment(2).'/queue'?>" data-close-others="true">Antrian Pasien</a>
			</li>
			<li class="<?php echo ($func == 'poliumum/'.$this->uri->segment(2).'/patient')?'active':''; ?>">
				<a href="<?php echo base_url().'poliumum/'.$this->uri->segment(2).'/patient'?>" data-close-others="true">Daftar Pasien</a>
			</li>
			<li class="<?php echo ($this->uri->segment(3) == 'receipt')?'active':''; ?>">
				<a href="<?php echo base_url().'poliumum/'.$this->uri->segment(2).'/receipt/listPasien'?>" data-close-others="true">Resep Pasien</a>
			</li>
			<li class="dropdown <?php echo ($this->uri->segment(3) == 'request' || $this->uri->segment(3) == 'stocks' || $this->uri->segment(3) == 'obatMasuk' || $this->uri->segment(3) == 'obatKeluar' || $this->uri->segment(3) == 'riwayatObat')?'active':''; ?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Obat</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo base_url().'poliumum/'.$this->uri->segment(2).'/stocks'?>"> Stok Obat Poli</a></li>
					<li><a href="<?php echo base_url().'poliumum/'.$this->uri->segment(2).'/request'?>">Permintaan Obat</a></li>
					<li><a href="<?php echo base_url().'poliumum/'.$this->uri->segment(2).'/obatMasuk/daftar_pengiriman'?>">Penerimaan Obat</a></li>
					<li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/obatKeluar/pemakaian' ?>">Pemakaian Obat</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) .'/'.$this->uri->segment(2, 0). '/riwayatObat/minta' ?>" >Riwayat Obat Minta</a></li>
                    <li><a href="<?= base_url() . $this->uri->segment(1, 0) .'/'.$this->uri->segment(2, 0). '/riwayatObat/masuk' ?>" >Riwayat Obat Masuk</a></li>
                    <li><a href="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/riwayatObat/pemakaian' ?>">Riwayat Pemakaian Obat</a></li>
				</ul>
			</li>
			<!--<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Laporan</a>
				<ul class="dropdown-menu">
							<li><a href="#">Laporan Rekap Kunjungan Resep</a></li>
							<li><a href="<?php //echo base_url();?>index.php/reports/rdrug/drugAchievedUnitdf" target="_blank">Laporan Penerimaan Obat</a></li>
							<li><a href="<?php //echo base_url();?>index.php/reports/rdrug/drugUsedUnitdf" target="_blank">Laporan Pemakaian Obat</a></li>
							<li><a href="<?php //echo base_url();?>index.php/reports/rdrug/opnameStockPdf" target="_blank">Laporan Stok Opname Obat</a></li>
							<li><a href="<?php //echo base_url();?>index.php/reports/rdrug/lplpo" target="_blank">Laporan LPLPO</a></li>
				</ul>
			</li>-->
		</ul>	
		</div>
</div>
</div>