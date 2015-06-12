<div class="container">
<div class="row" >
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Cetak LPLPO Unit' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
				<div class="form-group">
					
					<form class="form-horizontal bucket-form" method="post" action="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/LPLPOpdf'; ?>" target="_blank">
						<div class="form-group">
							<label class="col-sm-3 control-label">Puskesmas</label>
							<div class="col-sm-9">
								<select class="form-control m-bot15" id="inputHC" name="inputHC" onchange = showUnit(this.value)>
									<?php
										if(count($allHC)!=1)
											echo '<option value="-1">Pilih Puskesmas</option>';
										foreach($allHC as $avacc)
										{
											echo '<option value="'.$avacc['ID_GEDUNG'].'">'.$avacc['NAMA_GEDUNG'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Unit</label>
							<div class="col-sm-9">
								<select class="form-control m-bot15" id="inputUnit" name="inputUnit">
									<?php
										if(count($allUnit)!=1)
											echo '<option value="-1">Pilih Unit Pelayanan</option>';
										foreach($allUnit as $avacc)
										{
											echo '<option value="'.$avacc['ID_UNIT'].'">'.$avacc['NAMA_UNIT'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Dari</label>
							<div class="col-sm-9">
								<input type="text" id="inputDari" name="inputDari" class="form-control datepicker"  size="16" value="<?= date('d-m-Y') ?>" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Hingga</label>
							<div class="col-sm-9">
								<input type="text" id="inputHingga" name="inputHingga" class="form-control datepicker"  size="16" value="<?= date('d-m-Y') ?>" >
							</div>
						</div>	
						<!-- ttd -->
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Nama Kepala Puskesmas</label>
							<div class="col-sm-9">
								<input type="text" id="nKP" name="nKP" class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">NIP Kepala Puskesmas</label>
							<div class="col-sm-9">
								<input type="text" id="nipKP" name="nipKP" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nama Petugas Pustu</label>
							<div class="col-sm-9">
								<input type="text" id="nPP" name="nPP" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">NIP Petugas Pustu</label>
							<div class="col-sm-9">
								<input type="text" id="nipPP" name="nipPP" class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nama Pengelola Obat Puskesmas</label>
							<div class="col-sm-9">
								<input type="text" id="nPOP" name="nPOP" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">NIP Pengelola Obat Puskesmas</label>
							<div class="col-sm-9">
								<input type="text" id="nipPOP" name="nipPOP" class="form-control" >
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
		format: 'dd-mm-yyyy',
	});
});
function showUnit (value){
	if (value == -1) return;
	$( "#myBody" ).html('');

	var jso;
	var id_numbers = new Array();
	$.ajax({
		type: "POST",
		url: "<?php echo base_url() .$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/AllunitInPuskesmas'; ?>",
		data: {id : value},
		success: function (dataCheck) {
			id_numbers = dataCheck;
			var i =0;
			var input = '<option selected value="-1">Pilih Unit Pelayanan</option>';
			if(dataCheck.units != null){
			for (i=0;i<dataCheck.units.length;i++)
			{
				input += '<option value="'+dataCheck.units[i]['ID_UNIT']+'">'+dataCheck.units[i]['NAMA_UNIT']+'</option>';
			}
			}
			$( "#inputUnit" ).html(input);
		}
		,error: function (xhr, ajaxOptions, thrownError) {
             alert(xhr.status);
             alert(thrownError);
             alert(xhr.responseText);
           },
		dataType:"json"
	});
}
</script>