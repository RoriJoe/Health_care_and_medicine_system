
<div class="container" >
	<?php $fungsi= $this->uri->uri_string();?>
	<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars icon-custom"></i>
                </button>
            </div>
	<div class="navbar-collapse collapse">
		<ul class="nav navbar-nav navbar-left">
			  <li>
                <a href="<?= base_url().'account/redirectByTipeUser' ?>" class="dropdown-toggle">Kembali</a>
				</li>
		</ul>
	</div>
	<!--/.nav-collapse -->
	
</div>