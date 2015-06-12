<div class="container">	
<div class="row">

<div class="col-md-3">
	<div class="panel panel-primary" >
		<div class="panel-heading">
			<h3 class="panel-title">Notifikasi</h3>
		</div>
		<div class="panel-body" style="height: 700px; overflow-y: scroll">
			<?php 
			
			if (isset($allStocks)) {
				$arr_sudah_dicek = array();
				foreach ($allStocks as $sisaStok) {
					$mydate2 = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
					$mydate1 = DateTime::createFromFormat('Y-m-d', $sisaStok['EXPIRED_DATE']);
					if (diffInMonths ($mydate1, $mydate2) <= 1){
						echo '<div class="alert alert-danger"><strong>Peringatan!</strong><i> '.$sisaStok['NAMA_OBAT'].'</i> Batch '.
						$sisaStok['NOMOR_BATCH'].' kadaluarsa pada '.$mydate1->format('d-M-Y').' </div>';
					}
					
					if (in_array( $sisaStok['ID_OBAT'], $arr_sudah_dicek, true) == false) {
						if ($sisaStok['TOTAL'] <= $sisaStok['JML_OBAT_MIN']) {
							echo '<div class="alert alert-warning"><strong>Perhatian!</strong> Stok obat <i>'.$sisaStok['NAMA_OBAT'].'</i> mulai menipis.</div>';
							$arr_sudah_dicek[] = $sisaStok['ID_OBAT'];
						}
					}
				}
			}
			?>
		</div>
	</div>
</div>

<div class="col-md-9">

	<section class="slice bg-2 p-15">
            <h3>Riwayat Obat Rusak dan Kadaluarsa</h3>
    </section>&nbsp;	

	<div class="row form-group">
	<div class="col-md-12">
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
	&nbsp;
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
	 name : 'SUMBER ANGGARAN',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'TGL KADALUARSA',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'NOMOR BATCH',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'KETERANGAN',
	 type : 'string',
	 filterable : true
	 }
];

function renderTable() {
	$('#results').append ('<div class="alert alert-info">Memuat Riwayat Obat...</div>');
	var jso;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showAllDrugsGFKUnused',
		success: function (dataCheck) {		  
			// alert (dataCheck);
			if (dataCheck.length > 0) {
				jso = dataCheck;
				setupPivot({
					json: jso,
					fields: fields,
					rowLabels: ["NOMOR", "NAMA OBAT","SUMBER ANGGARAN", "TGL KADALUARSA", "NOMOR BATCH", "KETERANGAN"]
				})
				$('.stop-propagation').click(function (event) {
					event.stopPropagation();
				});
			}
			else {
				$('#results').html('');
				$('#results').append ('<div class="alert alert-success">Daftar Riwayat Kosong!</div>');
			}
		},
		error: function (xhr, status, error) {
			// alert(status.status+ error + xhr.responseText);
		}
	});
}

$(function () {
	renderTable();
	$( ".datepicker" ).datepicker({
		format: 'dd-mm-yyyy',
	});
});

</script> 

<style>
.datepicker {
	z-index: 100000;
}
</style>