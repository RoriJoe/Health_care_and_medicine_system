
<div class="container">	
<div class="row">
<section class="slice bg-2 p-15">
   <h3>Rekomendasi Pengiriman Rutin</h3>
</section>
<br>
<div class="col-md-12">
	<div class="row form-group">
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
</div>

<script>
var fields = [
	 {
	 name : 'NOMOR',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'NAMA OBAT',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'NOMOR BATCH',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'REKOMENDASI',
	 type : 'string',
	 filterable : true
	 }
];


$(function () {
	ShowRecommendation ();
	$( ".datepicker" ).datepicker({
		format: 'dd-mm-yyyy',
	});
});

function ShowRecommendation () {
	var id_unit = "<?php echo $this->uri->segment(4); ?>";
	var link = "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showDataRecom/"+id_unit;
	$.ajax ({
		type: "POST",
		url: link,
		data: {id: id_unit},
		success: function (data_return) {
			// alert (data_return);			
			if (data_return) {
			setupPivot({
				json: data_return,
				fields: fields,
				rowLabels: ["NOMOR","NAMA OBAT", "NOMOR BATCH", "REKOMENDASI"]
			})
			$('.stop-propagation').click(function (event) {
				event.stopPropagation();
			});
			}
		},
		error: function () { 
			// alert ("Error!"); 
		}
	});
}

</script> 

<style>
.datepicker {
	z-index: 100000;
}
</style>
