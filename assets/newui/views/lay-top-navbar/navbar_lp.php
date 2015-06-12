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

			<?php $func= $this->uri->segment(3, 0); ?>
			<ul class="nav navbar-nav navbar-left">
				<li class="<?php echo ($func == 'oldPatient')?'active':''; ?>">
					<a href="<?php echo base_url(); ?>regBooth/lp/oldPatient" data-close-others="true">Pasien Lama</a>
				</li>
				<li class="<?php echo ($func == 'newPatient')?'active':''; ?>">
					<a data-close-others="true" href="<?php echo base_url(); ?>regBooth/lp/newPatient">Pendaftaran Pasien Baru</a>
				</li>
				<li class="<?php echo ($func == 'queue')?'active':''; ?>">
					<a data-close-others="true" href="<?php echo base_url(); ?>regBooth/lp/queue">Antrian Pasien</a>
				</li>
			</ul>	
		</div>
</div>
</div>