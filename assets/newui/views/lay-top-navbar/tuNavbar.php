<?php
?>
<div class="container" >
	<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars icon-custom"></i>
                </button>
            </div>
	<div class="navbar-collapse collapse" st>
		<?php $fungsi= $this->uri->uri_string();?>
		<ul class="nav navbar-nav navbar-left">
			<li class="<?php echo ($fungsi=='inventory/'.$this->uri->segment(2, 0))?'active':''; ?>"><a href="<?php echo base_url().'inventory/'.$this->uri->segment(2, 0); ?>">Inventaris</a></li>
			<li class="<?php echo ($fungsi=='hospitalization/'.$this->uri->segment(2, 0).'/manageRoom')?'active':''; ?>"><a href="<?php echo base_url().'hospitalization/'.$this->uri->segment(2, 0); ?>">Ruangan Unit</a></li>
			<li class="<?php echo ($fungsi=='hospitalization/'.$this->uri->segment(2, 0).'/manageBR')?'active':''; ?>"><a href="<?php echo base_url().'hospitalization/'.$this->uri->segment(2, 0)."/manageBR"; ?>">Tempat Tidur</a></li>
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
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/diseaseByAgePdf'; ?>">Laporan Kesakitan Berdasarkan Umur</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/diseaseHighestPdf'; ?>">Laporan 15 Penyakit Terbanyak</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/hCare'; ?>">Laporan Pelayanan</a></li>
                    <li><a href="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/inventarisPdf'; ?>">Laporan Inventaris Barang</a></li>
                </ul>
            </li>
		</ul>
	</div>
</div>