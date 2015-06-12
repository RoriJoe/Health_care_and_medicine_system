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
			<li class="<?php echo ($func == 'care/ri')?'active':''; ?>">
				<a href="<?php echo base_url().'care/'.$this->uri->segment(2); ?>" data-close-others="true">Antrian Pasien</a>
			</li>
			<li class="<?php echo ($this->uri->segment(3) == 'patient' || $this->uri->segment(3) == 'patientMRH' || $this->uri->segment(3) == 'profileMRH')?'active':''; ?>">
				<a href="<?php echo base_url().'care/'.$this->uri->segment(2); ?>/patient" data-close-others="true">Pasien Rawat Inap</a>
			</li>
			<li class="<?php echo ($this->uri->segment(3) == 'receipt')?'active':''; ?>">
				<a href="<?php echo base_url().'care/'.$this->uri->segment(2).'/receipt/listPasien'?>" data-close-others="true">Resep Pasien</a>
			</li>
			<li class="dropdown <?php echo ($this->uri->segment(3) == 'request' || $this->uri->segment(3) == 'stocks' || $this->uri->segment(3) == 'obatMasuk')?'active':''; ?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Obat</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo base_url().'care/'.$this->uri->segment(2).'/stocks'?>"> Stok Obat Poli</a></li>
					<li><a href="<?php echo base_url().'care/'.$this->uri->segment(2).'/request'?>">Permintaan Obat</a></li>
					<li><a href="<?php echo base_url().'care/'.$this->uri->segment(2).'/obatMasuk/daftar_pengiriman'?>">Penerimaan Obat</a></li>
				</ul>
			</li>
			<li class="<?php echo ($this->uri->segment(3) == 'listKeluar')?'active':''; ?>">
				<a href="<?php echo base_url().'care/'.$this->uri->segment(2).'/listKeluar'?>" data-close-others="true">Riwayat Pasien Keluar</a>
			</li>
		</ul>	
		</div>
</div>
</div>