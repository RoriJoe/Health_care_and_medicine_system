<div class="container" >
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse" st>
                <ul class="nav navbar-nav">
                    <?php $fungsi= $this->uri->segment(3, 0); ?>
                    <li class="<?php echo ($fungsi=='stok')?'active':''; ?>">
                        <a href="<?= base_url().'drugHC/'.$this->uri->segment(2, 0).'/stok' ?>" class="dropdown-toggle">Stok</a>
                    </li>
                    <li class="<?php echo ($fungsi=='send')?'active':''; ?>">
                        <a href="<?= base_url().'drugHC/'.$this->uri->segment(2, 0).'/send' ?>" class="dropdown-toggle">Pengiriman</a>
                    </li>
                    <li class="<?php echo ($fungsi=='request')?'active':''; ?>">
                    	<a href="<?= base_url().'drugHC/'.$this->uri->segment(2, 0).'/request' ?>" class="dropdown-toggle">Permintaan</a>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
            
        </div>