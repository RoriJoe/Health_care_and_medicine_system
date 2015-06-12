<div class="container">
<div class="row">
	<div class="col-md-12">
	<section class="slice bg-2 p-15">
         <h3>Data Stok Poli Umum</h3>
    </section>	&nbsp;
	

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
<br>
<br>

<script>
$(function () {
	renderTable();
});

var fields = [
		 {
		 name : 'NAMA OBAT',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'SUMBER ANGGARAN',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'STOK SAAT INI',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'TANGGAL KADALUARSA',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'NOMOR BATCH',
		 type : 'string',
		 filterable : true
		 }
];

function renderTable()
{
	var jso;

	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showStocks',
		success: function (dataCheck) {
			// alert(dataCheck);

			jso = dataCheck;
			setupPivot({
				json: jso,
				fields: fields,
				rowLabels: ["NAMA OBAT","SUMBER ANGGARAN", "STOK SAAT INI", "TANGGAL KADALUARSA", "NOMOR BATCH"]
			})
			$('.stop-propagation').click(function (event) {
				event.stopPropagation();
			});
		},
		error: function (xhr, status, error) {
			alert("error bung "+ xhr.responseText);
		}
	});
}

</script> 