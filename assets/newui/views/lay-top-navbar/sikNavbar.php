
<div class="container" >
	<?php $fungsi= $this->uri->uri_string();?>
	<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars icon-custom"></i>
                </button>
            </div>
	<div class="navbar-collapse collapse">
		<ul class="nav navbar-nav navbar-left">
			<li class="dropdown <?php echo ($fungsi=='hClinic/'.$this->uri->segment(2, 0).'/createPuskesmas')?'active':''; ?>">
				<a href="<?php echo base_url().'hClinic/'.$this->uri->segment(2, 0)."/"; ?>">Puskesmas</a></li>
			<li class="dropdown <?php echo ($fungsi=='account/sik')?'active':''; ?>">
				<a href="<?php echo base_url(); ?>account/sik">Manajemen Pegawai</a>
			</li>
			<li class="dropdown <?php echo ($fungsi=='drugHC/'.$this->uri->segment(2, 0).'/monitoringObat' || $fungsi=='regBooth/'.$this->uri->segment(2, 0).'/queue' || $fungsi=='account/'.$this->uri->segment(2, 0).'/monitoringSDM')?'active':''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Monitoring</a>
                <ul class="dropdown-menu">
					<li >
						<a href="<?= base_url().'drugHC/'.$this->uri->segment(2, 0).'/monitoringObat' ?>" class="dropdown-toggle">Monitoring Obat</a>
					</li>
					<li >
						<a href="<?= base_url().'regBooth/'.$this->uri->segment(2, 0).'/queue' ?>" class="dropdown-toggle">Monitoring Pelayanan</a>
					</li>
					<li >
						<a href="<?= base_url().'account/'.$this->uri->segment(2, 0).'/monitoringSDM' ?>" class="dropdown-toggle">Monitoring SDM</a>
					</li>
				</ul>
            </li>            
			<li class="dropdown <?php echo ($fungsi=='department/'.$this->uri->segment(2, 0).'/manageDepartment' || $fungsi=='admHc/'.$this->uri->segment(2, 0).'/manageHServices' || $fungsi=='admHc/'.$this->uri->segment(2, 0).'/manageSPayment' || $fungsi=='admHc/'.$this->uri->segment(2, 0).'/manageRank')?'active':''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Data Master</a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url().'department/'.$this->uri->segment(2, 0)."/manageDepartment"; ?>">Jabatan</a></li>
                    <li><a href="<?php echo base_url().'admHc/'.$this->uri->segment(2, 0)."/manageHServices"; ?>">Pelayanan Kesehatan</a></li>
                    <li><a href="<?php echo base_url().'admHc/'.$this->uri->segment(2, 0)."/manageSPayment"; ?>">Sumber Pembayaran</a></li>
                    <li><a href="<?php echo base_url().'admHc/'.$this->uri->segment(2, 0)."/manageRank"; ?>">Pangkat</a></li>
                </ul>
            </li>
            <li class="dropdown <?php echo ($fungsi=='report')?'active':''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Laporan</a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/drugStockCardPdf'; ?>">Laporan Kartu Stok Gudang Obat</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/drugAchievedUnitdf'; ?>">Laporan Penerimaan Obat Unit</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/drugUsedUnitdf'; ?>">Laporan Pemakaian Obat Unit</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/opname'; ?>">Laporan Stok Opname Obat Unit</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/LPLPO'; ?>">Laporan LPLPO Unit</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/LPLPOHc'; ?>">Laporan LPLPO Puskesmas</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/diseasePdf'; ?>">Laporan LB 1</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/inventarisPdf'; ?>">Laporan Inventaris Barang</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/sdmHc'; ?>">Laporan SDM</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/hCare'; ?>">Laporan Pelayanan</a></li>
                </ul>
            </li>
		</ul>
	</div>
</div>