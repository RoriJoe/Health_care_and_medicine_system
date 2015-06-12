
<div class="container" >
	<?php $fungsi= $this->uri->uri_string();?>
	<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars icon-custom"></i>
                </button>
            </div>
	<div class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
			  <li class="<?php echo ($fungsi=='uHc/'.$this->uri->segment(2, 0).'/createUnit')?'active':''; ?>">
				<a href="<?php echo base_url().'uHc/'.$this->uri->segment(2, 0)?>">Data Unit</a></li>
			  <li class="<?php echo ($fungsi=='account/'.$this->uri->segment(2, 0))?'active':''; ?>">
                <a href="<?= base_url().'account/'.$this->uri->segment(2, 0) ?>" class="dropdown-toggle">Data Akun</a>
				</li>
				  <li class="<?php echo ($fungsi=='Hclinic/'.$this->uri->segment(2, 0).'/updatePuskesmas')?'active':''; ?>">
				<a href="<?php echo base_url(); ?>Hclinic/ap">Data Puskesmas</a></li>
		</ul>
	</div>
	<!--/.nav-collapse -->
	
</div>