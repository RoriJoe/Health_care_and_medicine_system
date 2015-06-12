<div class="container">
<div class="row" >
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Cetak LPLPO Puskesmas' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
				<div class="form-group">
					
					<form class="form-horizontal bucket-form" method="post" action="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/mutasipdf'; ?>" target="_blank">
						<div class="form-group">
							<label class="col-sm-3 control-label">Bulan</label>
							<div class="col-sm-9">
								<select class="form-control m-bot15" id="inputDari" name="inputDari">
									<option value="1">Januari</option>';
									<option value="2">Februari</option>';
									<option value="3">Maret</option>';
									<option value="4">April</option>';
									<option value="5">Mei</option>';
									<option value="6">Juni</option>';
									<option value="7">Juli</option>';
									<option value="8">Agustus</option>';
									<option value="9">September</option>';
									<option value="10">Oktober</option>';
									<option value="11">November</option>';
									<option value="12">Desember</option>';
								</select>	
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Hingga</label>
							<div class="col-sm-9">
								<input type="text" id="inputHingga" name="inputHingga" class="form-control datepicker"  size="16" value="<?= date('Y-m-d') ?>" >
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