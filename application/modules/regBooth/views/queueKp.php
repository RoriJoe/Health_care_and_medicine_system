<div class="container">
<div class="row">

<div class="col-md-12">
	<section class="slice bg-2 p-15">
            <h4>Antrian Pasien Per Poli</h4>
    </section> &nbsp;

	<div class="col-md-12">
	<div class="row">
		<form id="find">
		<div class="col-md-3">
			<div class="form-group">
			<select id="unit" name="unit" class="form-control in"> <!--onchange="showAntrian(this.value)">-->
				  <option selected value="-1">Pilih Unit Pelayanan</option>
				  <?php foreach ($units as $row) :?>
				  <option value="<?php echo $row['ID_UNIT'] ?>"><?php echo $row['NAMA_UNIT'] ?></option>
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
		 name : 'NOMOR ANTRIAN',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'NIK',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'NAMA PASIEN',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'WAKTU ANTRIAN UNIT',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'STATUS ANTRI',
		 type : 'string',
		 filterable : true
		 }
];

function showAntrian (){
	if ($( "#unit" ).val() == -1 || $( "#inputTanggal" ).val() == '') return;
	$( "#myBody" ).html('');

	var jso;
	$.ajax({
		type: "POST",
		url: "<?php echo base_url() .$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/showQueueUnit'; ?>",
		data: {unit : $( "#unit" ).val(), tanggal : $( "#inputTanggal" ).val()},
		success: function (dataCheck) {
			if (dataCheck) {
				jso = dataCheck;
				setupPivot({
					json: jso,
					fields: fields,
					rowLabels: ["NOMOR ANTRIAN","NIK", "NAMA PASIEN", "WAKTU ANTRIAN UNIT", "STATUS ANTRI"]
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

</script>
	
	