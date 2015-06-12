<div class="container">
<div class="row" >
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Cetak Laporan Data Stok Gudang Obat Berdasar Tanggal' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
				<div class="form-group">
					
					<form class="form-horizontal bucket-form" method="post" action="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/drugStockCard'; ?>" target="_blank">
						<div class="form-group">
							<label class="col-sm-3 control-label">Unit</label>
							<div class="col-sm-9">
								<select class="form-control m-bot15" id="inputHC" name="inputHC">
									<?php
										foreach($allHC as $avacc)
										{
											echo '<option value="'.$avacc['ID_GEDUNG'].'">'.$avacc['NAMA_GEDUNG'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Dari</label>
							<div class="col-sm-9">
								<input type="text" id="inputDari" name="inputDari" class="form-control datepicker"  size="16" value="<?= date('d-m-Y') ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Hingga</label>
							<div class="col-sm-9">
								<input type="text" id="inputHingga" name="inputHingga" class="form-control datepicker"  size="16" value="<?= date('d-m-Y') ?>" >
							</div>
						</div>	
						<input class="btn btn-primary pull-right" type="submit" value="Cetak" name="submit">

					</form>
				</div>
			</div>
			<br>
			<br>
		</div>
	</div>
	
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Cetak Laporan Data Stok Gudang Obat Berdasar Item' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
				<div class="form-group">
					
					<form class="form-horizontal bucket-form" method="post" action="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/drugStockCardName'; ?>" target="_blank">
						<div class="form-group">
							<label class="col-sm-3 control-label">Unit</label>
							<div class="col-sm-9">
								<select class="form-control m-bot15" id="inputHC" name="inputHC">
									<?php
										foreach($allHC as $avacc)
										{
											echo '<option value="'.$avacc['ID_GEDUNG'].'">'.$avacc['NAMA_GEDUNG'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nama Obat</label>
							<div class="col-sm-9">
								<input type="text" id="inputObatN" name="inputObatN" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Dari</label>
							<div class="col-sm-9">
								<input type="text" id="inputDari" name="inputDari" class="form-control datepicker"  size="16" value="<?= date('d-m-Y') ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Hingga</label>
							<div class="col-sm-9">
								<input type="text" id="inputHingga" name="inputHingga" class="form-control datepicker"  size="16" value="<?= date('d-m-Y') ?>" >
							</div>
						</div>	
						<input class="btn btn-primary pull-right" type="submit" value="Cetak" name="submit">

					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Cetak Laporan Data Stok Gudang Obat Berdasar Kadaluarsa' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
				<div class="form-group">
					
					<form class="form-horizontal bucket-form" method="post" action="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/drugStockCardByEXP'; ?>" target="_blank">
						<div class="form-group">
							<label class="col-sm-3 control-label">Unit</label>
							<div class="col-sm-9">
								<select class="form-control m-bot15" id="inputHC" name="inputHC">
									<?php
										foreach($allHC as $avacc)
										{
											echo '<option value="'.$avacc['ID_GEDUNG'].'">'.$avacc['NAMA_GEDUNG'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Dari</label>
							<div class="col-sm-9">
								<input type="text" id="inputDari" name="inputDari" class="form-control datepicker"  size="16" value="<?= date('d-m-Y') ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Hingga</label>
							<div class="col-sm-9">
								<input type="text" id="inputHingga" name="inputHingga" class="form-control datepicker"  size="16" value="<?= date('d-m-Y') ?>" >
							</div>
						</div>	
						<div class="form-group">
							<label class="col-sm-3 control-label">Kadaluarsa Dari</label>
							<div class="col-sm-9">
								<input type="text" id="inputDariK" name="inputDariK" class="form-control datepicker"  size="16" value="<?= date('d-m-Y') ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Kadaluarsa Hingga</label>
							<div class="col-sm-9">
								<input type="text" id="inputHinggaK" name="inputHinggaK" class="form-control datepicker"  size="16" value="<?= date('d-m-Y') ?>" >
							</div>
						</div>	
						<input class="btn btn-primary pull-right" type="submit" value="Cetak" name="submit">

					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Cetak Laporan Data Stok Gudang Obat Berdasar Sumber Anggaran' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
				<div class="form-group">
					
					<form class="form-horizontal bucket-form" method="post" action="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/drugStockCardBySource'; ?>" target="_blank">
						<div class="form-group">
							<label class="col-sm-3 control-label">Unit</label>
							<div class="col-sm-9">
								<select class="form-control m-bot15" id="inputHC" name="inputHC">
									<?php
										foreach($allHC as $avacc)
										{
											echo '<option value="'.$avacc['ID_GEDUNG'].'">'.$avacc['NAMA_GEDUNG'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Sumber Anggaran</label>
							<div class="col-sm-9">
								<select class="form-control m-bot15" id="inputSource" name="inputSource">
									<?php
										foreach($allSource as $source)
										{
											echo '<option value="'.$source['ID_SUMBER_ANGGARAN_OBAT'].'_'.$source['NAMA_SUMBER_ANGGARAN_OBAT'].'">'.$source['NAMA_SUMBER_ANGGARAN_OBAT'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Dari</label>
							<div class="col-sm-9">
								<input type="text" id="inputDari" name="inputDari" class="form-control datepicker"  size="16" value="<?= date('d-m-Y') ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Hingga</label>
							<div class="col-sm-9">
								<input type="text" id="inputHingga" name="inputHingga" class="form-control datepicker"  size="16" value="<?= date('d-m-Y') ?>" >
							</div>
						</div>	
						<input class="btn btn-primary pull-right" type="submit" value="Cetak" name="submit">

					</form>
				</div>
			</div>
			<br>
			<br>
		</div>
	</div>
</div>
</div>

<script>
$(function () {
	$( ".datepicker" ).datepicker({
		format: 'dd-mm-yyyy',
	});
});
</script>