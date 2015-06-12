<div class="horizontal-menu navbar-collapse collapse ">
      <ul class="nav navbar-nav">
          <li selected><a href="<?php echo base_url(); ?>index.php/drugWH">Dashboard</a></li>
          <li class="dropdown">
            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toogle" href="#">Stok Obat
            <b class=" fa fa-angle-down"></b></a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo base_url(); ?>index.php/drugWH/stocks">Gudang Farmasi Kabupaten</a> 
                </li>    
                <li><a href="#">Puskesmas</a>
                </li>
            </ul>
          </li>
          <li class="dropdown">
              <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toogle" href="#" >Distribusi Obat<b class=" fa fa-angle-down"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo base_url(); ?>index.php/drugWH/distribution/in">Penerimaan Obat</a></li>
                  <li><a href="<?php echo base_url(); ?>index.php/drugWH/distribution/out">Pengeluaran Obat</a></li>
                  <li><a href="<?php echo base_url(); ?>index.php/drugWH/distribution/log">Riwayat</a></li>
              </ul>
          </li>
          <li><a href="#">Manajemen Akun</a></li>
      </ul>

  </div>