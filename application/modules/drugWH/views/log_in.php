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
            <h3>Riwayat Obat Masuk Gudang Farmasi Kabupaten</h3>
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
&nbsp;
</div>  
</div>

<!-- Pop up detail-->      
<div style="display: none;" class="modal fade in col-md-12" id="detailObatModal" tabindex="-1" role="dialog" aria-labelledby="detailObatModal" aria-hidden="false">
<div class="modal-dialog">
	<div class="modal-content" style="width: 800px; position: center">
	<div class="modal-header alert alert-success">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h4 class="modal-title">Detail Obat per Batch</h4>
	</div>
	<div class="modal-body" style="height: 300px; overflow-y: scroll;">
		<table class="table table-striped table-comparision table-responsive" >				
			<thead>
				<tr>				
					<th>NAMA OBAT</th>
					<th>SUMBER ANGGARAN</th>
					<th>NO. BATCH</th>
					<th>JUMLAH</th>
					<th>SATUAN</th>					
					<th>TGL. KADALUARSA</th>					
					<th>HARGA SATUAN</th>
					<th>PENYEDIA</th>
				</tr>
			</thead>
			<tbody id="bodyDetailObat">

			</tbody>			
		</table> 
		<div id="alertPembuangan">
			
		</div>
	</div>
	</div>
</div>
</div>                            
<!-- Eof Detail -->  


<script>		
var fields = [
	 {
	 name : 'NOMOR',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'NOID TRANSAKSI',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'TANGGAL TRANSAKSI',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'DETAIL',
	 type : 'string',
	 filterable : true
	 }
];

function renderTable() {
	$('#results').append ('<div class="alert alert-info">Memuat Daftar Riwayat...</div>');
	var jso;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/getLogIn',
		success: function (dataCheck) {	
			// alert (dataCheck);
			if (dataCheck.length > 0) {
				jso = dataCheck;
				setupPivot({
					json: jso,
					fields: fields,
					rowLabels: ["NOMOR", "NOID TRANSAKSI", "TANGGAL TRANSAKSI","DETAIL"]
				})
				$('.stop-propagation').click(function (event) {
					event.stopPropagation();
				});
			}
			else {
				$('#results').html ('');
				$('#results').append ('<div class="alert alert-success">Daftar Riwayat Kosong!</div>');
			}
		},
		error: function (xhr, status, error) {
			// alert(status.status+ error + xhr.responseText);
		}
	});
}


function detail(id) {
	$("#bodyDetailObat").html ('');
	// alert (id);
	var jso;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showDetailLogIn',
		data: {id : id},
		success: function (dataCheck) {	
			// alert (dataCheck);
			if (dataCheck.length > 0 ){
				var objData = eval (dataCheck);
				var content;
				$.each(objData, function(index, value) { 
					// alert (value.NAMA_OBAT);
					content += '<tr><td>'+value.NAMA_OBAT+'</td>';	
					content += '<td>'+value.NAMA_SUMBER_ANGGARAN_OBAT+'</td>';	
					content += '<td>'+value.NOMOR_BATCH+'</td>';	
					content += '<td>'+value.JUMLAH_OBAT+'</td>';
					content += '<td>'+value.SATUAN+'</td>';
					content += '<td>'+value.TANGGAL_KADALUARSA+'</td>';
					if (value.HARGA_SATUAN) content += '<td>'+value.HARGA_SATUAN+'</td>'; 
					else content += '<td>-</td>';
					if (value.PENYEDIA_OBAT) content += '<td>'+value.PENYEDIA_OBAT+'</td>';
					else 
					content += '<td>-</td>';
					content += '</tr>';

				});			
				$("#bodyDetailObat").append (content);	
			}
		},
		error: function (xhr, status, error) {
			// alert(status.status+ error + xhr.responseText);
		}
	});
}

$(function () {
	renderTable();
});

</script> 

                