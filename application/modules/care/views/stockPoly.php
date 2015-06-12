<div class="container">
<div class="row">
	<div class="col-md-12">
	<section class="slice bg-2 p-15">
         <h3>Data Stok Rawat Inap</h3>
    </section>	&nbsp;
	
	<div class="row">
	<div class="col-md-12">
		<div id="results"></div>
	</div>
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
	$('#results').html('');
	$('#results').append('<div class="alert alert-info">Memuat Daftar Stok Obat Rawat Inap...</div>');
		
	var jso;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showStocks',
		success: function (dataCheck) {
			if (dataCheck.length > 0) {
				jso = dataCheck;
				setupPivot({
					json: jso,
					fields: fields,
					rowLabels: ["NAMA OBAT","SUMBER ANGGARAN", "STOK SAAT INI", "TANGGAL KADALUARSA", "NOMOR BATCH"]
				})
				$('.stop-propagation').click(function (event) {
					event.stopPropagation();
				});
			}
			else  {
				$('#results').html('');
				$('#results').append('<div class="alert alert-success">Daftar Stok Obat Rawat Inap Kosong!</div>');
			}
		},
		error: function (xhr, status, error) {			
		}
	});
}

</script> 