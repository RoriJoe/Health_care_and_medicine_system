<div class="container">
<div class="row" >
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Cetak 15 Penyakit Terbanyak' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
				<div class="form-group">
					
					<form class="form-horizontal bucket-form" method="post" action="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/diseaseHighest'; ?>" target="_blank">
						<div class="form-group">
							<label class="col-sm-3 control-label">Puskesmas</label>
							<div class="col-sm-9">
								<select class="form-control m-bot15" id="inputHC" name="inputHC">
									<?php
										if(count($allHC)!=1){
											echo '<option value="-1">Pilih Puskesmas</option>';
											if($this->session->userdata['telah_masuk']['idha'] == 14 || $this->session->userdata['telah_masuk']['idha'] == 15)
											echo '<option value="-2">Semua</option>';
											}
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
								<input type="text" id="inputDari" name="inputDari" class="form-control datepicker"  size="16" value="<?= date('Y-m-d') ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Hingga</label>
							<div class="col-sm-9">
								<input type="text" id="inputHingga" name="inputHingga" class="form-control datepicker"  size="16" value="<?= date('Y-m-d') ?>">
							</div>
						</div>	
						<input class="btn btn-primary pull-right" type="submit" value="Cetak" name="submit">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script>
$(function () {
	$( ".datepicker" ).datepicker({
		format: 'yyyy-mm-dd',
	});
});
</script>