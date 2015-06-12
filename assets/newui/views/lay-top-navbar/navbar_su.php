
<div class="container" >
            <div class="navbar-collapse collapse" st>
                <ul class="nav navbar-nav navbar-left">
                	<li class="active"><a href="<?php echo base_url(); ?>index.php/drugWH">Dashboard</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" href="<?php echo base_url(); ?>index.php/account">Data Pengguna</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url();?>index.php/account/control/createAccount">Pendaftaran Pegawai</a></li>
                            <li><a href="<?php echo base_url();?>index.php/account/control">Manajemen Pegawai</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" href="<?php echo base_url(); ?>index.php/department">Jabatan</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url();?>index.php/department/dControl/createDepartment">Penambahan Jabatan</a></li>
                            <li><a href="<?php echo base_url();?>index.php/department/dControl">Manajemen Jabatan</a></li>
                        </ul>
                    </li>
					<li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" href="<?php echo base_url(); ?>index.php/uHc">Unit</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url();?>index.php/uHc/uHcControl/createUnit">Penambahan Unit</a></li>
                            <li><a href="<?php echo base_url();?>index.php/uHc">Manajemen Unit</a></li>
                        </ul>
                    </li>
					<li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" href="<?php echo base_url(); ?>index.php/department">Pangkat</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url();?>index.php/admHc/rAdmHc/createRank">Penambahan Pangkat</a></li>
                            <li><a href="<?php echo base_url();?>index.php/admHc/rAdmHc">Manajemen Pangkat</a></li>
                        </ul>
                    </li>
					<li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" href="<?php echo base_url(); ?>index.php/department">Sumber Pembayaran</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url();?>index.php/admHc/spAdmHc/createSPayment">Penambahan Sumber Pembayaran</a></li>
                            <li><a href="<?php echo base_url();?>index.php/admHc/spAdmHc">Manajemen Sumber Pembayaran</a></li>
                        </ul>
                    </li>
					<li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" href="<?php echo base_url(); ?>index.php/department">Pelayanan Kesehatan</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url();?>index.php/admHc/hsAdmHc/createHServices">Penambahan Pelayanan Kesehatan</a></li>
							<li><a href="<?php echo base_url();?>index.php/admHc/scAdmHc/createSCategory">Penambahan Kategori Pelayanan</a></li>
                            <li><a href="<?php echo base_url();?>index.php/admHc/hsAdmHc">Manajemen Pelayanan Kesehatan</a></li>
                            <li><a href="<?php echo base_url();?>index.php/admHc/scAdmHc">Manajemen Kategori Pelayanan</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
            
        </div>