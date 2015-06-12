
<div class="container" >
	<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars icon-custom"></i>
                </button>
            </div>
			<?php $fungsi= $this->uri->segment(3, 0); ?>
            <div class="navbar-collapse collapse" >
                <ul class="nav navbar-nav navbar-left">
					<li class="<?php echo ($fungsi=='manageSPayment')?'active':''; ?>">
                        <a href="<?php echo base_url().'index.php/admHc/'.$this->uri->segment(2, 0); ?>">Sumber Pembayaran</a>
                    </li>
			<li class="<?php echo ($fungsi=='queueRI')?'active':''; ?>">
                <a href="<?= base_url().'regBooth/'.$this->uri->segment(2, 0).'/patientRI' ?>" class="dropdown-toggle">Monitoring Rawat Inap</a>
            </li>
					<li class="dropdown <?php echo ($fungsi=='hCare')?'active':''; ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Laporan</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/hCare'; ?>">Laporan Pelayanan</a></li>
							<li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/rInap'; ?>">Laporan Rawat Inap</a></li>
							<li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/labPdf'; ?>">Laporan Laboratorium</a></li>
							<li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/diseasePdf'; ?>">Laporan LB 1</a></li>
							<li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/diseaseByAgePdf'; ?>">Laporan Kesakitan Berdasarkan Umur</a></li>
							<li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/diseaseHighestPdf'; ?>">Laporan 15 Penyakit Terbanyak</a></li>
							<li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/diseaseByAgeHCarePdf'; ?>">Laporan Per Penyakit</a></li>
						</ul>
					</li>
                </ul>
            </div>
            <!--/.nav-collapse -->
            
        </div>