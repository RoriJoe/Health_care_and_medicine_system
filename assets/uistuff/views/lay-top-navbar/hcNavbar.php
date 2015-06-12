<div class="horizontal-menu navbar-collapse collapse ">
      <ul class="nav navbar-nav">
          <li class="active"><a href="<?php echo base_url(); ?>index.php/drugWH">Dashboard</a></li>
          <li ><a href="<?php echo base_url(); ?>index.php/hClinic">Puskesmas</a></li>
          <li class="dropdown">
            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toogle" href="#">Stok Obat
            <b class=" fa fa-angle-down"></b></a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo base_url(); ?>index.php/drugWH/agfk">Gudang Farmasi Kabupaten</a> 
                </li>    
                <li><a href="#">Puskesmas</a>
                </li>
            </ul>
          </li>
          <li class="dropdown">
              <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Distribusi Obat<b class=" fa fa-angle-down"></b></a>
              <ul class="dropdown-menu">
                  <li><a href="#">Penerimaan Obat</a></li>
                  <li><a href="#">Pengeluaran Obat</a></li>
                  <li><a href="#">Permintaan Obat</a></li>
                  <li><a href="#">Riwayat</a></li>
              </ul>
          </li>
          <li><a href="#">Manajemen Akun</a></li>
      </ul>
</div>
