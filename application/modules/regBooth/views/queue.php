<div class="container">
<div class="row">

<div class="col-md-12">
	<section class="slice bg-2 p-15">
            <h4>Antrian Pasien Per Poli</h4>
    </section> &nbsp;

	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
			<select class="form-control" id="pelayananPasien" name="pelayananPasien" onchange="checkSubUnit()">
				  <option selected value="-1">Pilih Unit Pelayanan</option>
				  <?php foreach ($units as $row) :?>
				  <option value="<?php echo $row['ID_UNIT'] ?>"><?php echo $row['NAMA_UNIT'] ?></option>
				  <?php endforeach; ?>
			</select> 
			</div>
		</div>	
		<div class="col-md-3">
			<div class="form-group" id="subunit">
			</div>
		</div>
		<div class="col-md-6">

		</div>
	</div>
	
	<div id="myBody" hidden="hidden">
	<div>
		<!--<ul class="nav nav-pills">
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
		</ul>-->
		<span class="hide-on-print" id="pivot-detail"></span>
		<div id="results"></div>
	</div>
	</div>

	
</div>


</div>

	


</div>
&nbsp;
<br><br/>

<script>
var fields = [
		 {
		 name : 'NOMOR ANTRIAN',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'NOMOR IDENTITAS',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'NAMA PASIEN',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'WAKTU ANTRIAN',
		 type : 'string',
		 filterable : true
		 }
];

function showAntrian (value){

	if (value == -1) {
		$( "#myBody" ).hide();
		return;
	}
	$( "#myBody" ).show();

	var jso;
	var sub_unit;
	if ($('#subUnitPelayanan')) {
		sub_unit = $('#subUnitPelayanan').val();
	}

	
	$('#results').append('<div class="alert alert-info">Memuat Antrian Pasien...</div>');
	
	$.ajax({
		type: "POST",
		url: "<?php echo base_url() .'regBooth/lp/showQueueUnit'; ?>",
		data: {id : value, sub : sub_unit},
		success: function (dataCheck) {
		    // alert(dataCheck);
			if (dataCheck.length > 0) {
				jso = dataCheck;
				setupPivot({
					json: jso,
					fields: fields,
					rowLabels: ["NOMOR ANTRIAN","NOMOR IDENTITAS", "NAMA PASIEN", "WAKTU ANTRIAN"]
				})
				$('.stop-propagation').click(function (event) {
					event.stopPropagation();
				});
				
				$("#pivot-table").class("table-responsive");
			}
			else {
				$('#results').html('');
				$('#results').append('<div class="alert alert-success">Antrian Pasien Kosong!</div>');
			}
		},
		error: function (xhr, status, error) {
			
		}
	});
}

function checkSubUnit () {

	var chosenUnit = $('#pelayananPasien :selected').text();
	var id_unit = $('#pelayananPasien').val();	
	
	if (chosenUnit == 'KIA') {
		var content = '<select id="subUnitPelayanan" class="form-control" name="subUnitPelayanan" onchange="showAntrian('+id_unit+')">';
		
		content += '<option selected value="">Silahkan Pilih</option>';
		content += '<option value="kia">KIA-Bumil</option>';
		content += '<option value="balita">KIA-Balita</option>';
		content += '<option value="vkkia">KIA-VK KIA</option>';
		content += '<option value="kb">KIA-KB</option>';
		content += '</select>';
		$('#subunit').append(content);
		$( "#myBody" ).hide();
	}
	else {
		$('#subunit').html('');		
		showAntrian(id_unit);
	}
}


</script>
	
	