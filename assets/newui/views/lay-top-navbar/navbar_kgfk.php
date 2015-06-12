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
			
				<li class="dropdown <?php echo ($func == $this->uri->segment(1).'/'.$this->uri->segment(2).'/stocksGFK' || $func == $this->uri->segment(1).'/'.$this->uri->segment(2).'/stocksHC')?'active':''; ?>">
					<a href="" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Monitoring Stok Obat</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url().'drugWH/'.$this->uri->segment(2).'/stocksGFK' ?>">Daftar Stok Obat GFK</a>
						</li>
						<li>
							<a href="<?php echo base_url().'drugWH/'.$this->uri->segment(2).'/stocksHC' ?>"> Daftar Stok Puskesmas</a>
						</li>
					</ul>
				</li>
				
				<!--<li class="dropdown <?php echo ($func == $this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsOut' || $func == $this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsOutHC')?'active':''; ?>">
					<a href="" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Obat Keluar</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url().'drugWH/'.$this->uri->segment(2).'/drugsOut' ?>">Distribusi Rutin</a>
						</li>
						<li>
							<a href="<?php echo base_url().'drugWH/'.$this->uri->segment(2).'/drugsOutHC' ?>">Distribusi CITO</a>
						</li>
					</ul>
				</li>
				
				<li class="dropdown <?php echo ($func == $this->uri->segment(1).'/'.$this->uri->segment(2).'/drugsIn')?'active':''; ?>">
					<a href="<?php echo base_url().'drugWH/'.$this->uri->segment(2).'/drugsIn' ?>" data-close-others="true">Obat Masuk</a>			
				</li>
				
				<li class="dropdown <?php echo ($func == $this->uri->segment(1).'/'.$this->uri->segment(2).'/recapDrugsOut')?'active':''; ?>">
					<a href="<?php echo base_url().'drugWH/'.$this->uri->segment(2).'/recapDrugsOut' ?>" data-close-others="true">Rekap Distribusi Rutin</a>				
				</li>-->
				
				<li class="dropdown <?php echo ($func == $this->uri->segment(1).'/'.$this->uri->segment(2).'/logIn' || $func == $this->uri->segment(1).'/'.$this->uri->segment(2).'/logOut' || $func == $this->uri->segment(1).'/'.$this->uri->segment(2).'/logUnused')?'active':''; ?>">
					<a href="" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Riwayat</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url().'drugWH/'.$this->uri->segment(2).'/logIn' ?>">Riwayat Obat Masuk</a>
						</li>
						<li>
							<a href="<?php echo base_url().'drugWH/'.$this->uri->segment(2).'/logOut' ?>">Riwayat
						Obat Keluar</a>
						</li>						
						<li><a href="<?php echo base_url().'drugWH/'.$this->uri->segment(2).'/logUnused' ?>">Riwayat Obat Rusak dan Kadaluarsa</a></li>
					</ul>
				</li>
				<li class="dropdown <?php echo ($this->uri->segment(1) == 'reports')?'active':''; ?>">
					<a href="" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Laporan</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/opname'; ?>">Laporan Stok Opname Obat Unit</a></li>
						<li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2).'/drugStockCardPdf'; ?>">Laporan Data Stok Gudang Obat</a></li>
						<li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2).'/LPLPO'; ?>">Laporan LPLPO Unit</a></li>
						<li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2).'/LPLPOHc'; ?>">Laporan LPLPO Puskesmas</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/sdmHc'; ?>">Laporan SDM</a></li>
					</ul>
				</li>
				<li class="dropdown <?php echo ($this->uri->segment(1) == 'account')?'active':''; ?>">
					<a href="<?php echo base_url().'account/'.$this->uri->segment(2);?>" data-close-others="true">Manajemen Akun</a>				
				</li>
			</ul>
		</div>
</div>
</div>