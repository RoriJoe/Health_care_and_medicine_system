<div class="container">
<div class="row">

<div class="col-md-12">
	<section class="slice bg-2 p-15">
            <h4>Pasien Rawat Inap</h4>
    </section> &nbsp;
	
	<div class="row">
		<div class="col-md-12">
			<b>Tanggal</b>
		</div>
	</div>
	
	<div class="row">
	<form id="find">
		<div class="col-md-3">
			<div class="form-group">
			<select id="puskesmas" name="puskesmas" class="form-control">
				  <option selected value="-1">Pilih Puskesmas</option>
				  <?php foreach ($puskesmas as $row) :?>
				  <option value="<?php echo $row['ID_GEDUNG'] ?>"><?php echo $row['NAMA_GEDUNG'] ?></option>
				  <?php endforeach; ?>
			</select> 
			</div>
		</div>	
		<div class="col-md-3">
			<div class="form-group">
				<input type="text" id="inputTanggal" name="inputTanggal" class="form-control datepicker"  size="16" value="<?= date('Y-m-d') ?>" >
			</div>
		</div>	
		<input class="btn btn-primary" type="button" value="Cari" id="submit" name="submit" onclick=showAntrian()>
		<div class="col-md-6">
		</div>
	</form>
	</div>
	
	<div class="col-md-12">
		<ul class="nav nav-pills">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"> Filter Fields <b class="caret"></b> </a>
				<ul class="dropdown-menu stop-propagation" style="overflow:auto;max-height:450px;padding:10px;">
					<div id="filter-list"></div>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"> Row Label Fields <b class="caret"></b> </a>
				<ul class="dropdown-menu stop-propagation" style="overflow:auto;max-height:450px;padding:10px;">
					<div id="row-label-fields"></div>
				</ul>
			</li>
		</ul>
		<span class="hide-on-print" id="pivot-detail"></span>
		<div id="results"></div>
</div>

	
</div>


</div>

	


</div>
&nbsp;
<br><br/>

<script>

$(function () {
	$( ".datepicker" ).datepicker({
		format: 'yyyy-mm-dd',
	});
});

$('#find').submit(function(e){
    showAntrian();
    e.preventDefault();
})

var fields = [
		 {
		 name : 'NIK',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'NAMA PASIEN',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'UMUR',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'JENIS KELAMIN',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'TANGGAL MASUK',
		 type : 'string',
		 filterable : true
		 }
];

function showAntrian (){
	if ($( "#puskesmas" ).val() == -1 || $( "#unit" ).val() == -1 || $( "#inputTanggal" ).val() == '') return;
	$( "#myBody" ).html('');

	var jso;
	$.ajax({
		type: "POST",
		url: "<?php echo base_url() .$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/showRI'; ?>",
		data: {puskesmas :$( "#puskesmas" ).val(), tanggal : $( "#inputTanggal" ).val()},
		success: function (dataCheck) {
			if (dataCheck) {
				jso = dataCheck;
				setupPivot({
					json: jso,
					fields: fields,
					rowLabels: ["NIK", "NAMA PASIEN", "UMUR", "JENIS KELAMIN", "TANGGAL MASUK"]
				})
				$('.stop-propagation').click(function (event) {
					event.stopPropagation();
				});
			}
		}
		,error: function (xhr, ajaxOptions, thrownError) {
           }
	});
}

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
			if(dataCheck.units != null)
			for (i=0;i<dataCheck.units.length;i++)
			{
				input += '<option value="'+dataCheck.units[i]['ID_UNIT']+'">'+dataCheck.units[i]['NAMA_UNIT']+'</option>';
			}
			$( "#unit" ).html(input);
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
	
	