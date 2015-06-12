<div class="horizontal-menu navbar-collapse collapse ">
      <ul class="nav navbar-nav">
          <li class="active"><a href="#">Dashboard Gudang Obat Puskesmas</a></li>
          <!--<li ><a href="#">Stok Obat</a>-->
          <li class="dropdown">
              <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Stok Obat <b class=" fa fa-angle-down"></b></a>
              <ul class="dropdown-menu">
                  <li><a href="#">Penambahan Stok</a></li>
                  <li><a href="#">Pengurangan Stok</a></li>
              </ul>
          </li>
          <li ><a href="<?= base_url().'drugHC/'.$this->uri->segment(2, 0).'/request' ?>">Permintaan Obat</a></li>
      </ul>
</div>
  