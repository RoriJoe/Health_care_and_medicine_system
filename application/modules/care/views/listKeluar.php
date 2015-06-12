<div class="container">
<div class="row">
	<div class="col-md-12">
	<section class="slice bg-2 p-15">
         <h3>Riwayat Pasien Keluar Rawat Inap</h3>
    </section>	&nbsp;
	

	<div>		
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
	 name : 'NAMA PASIEN',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'ALAMAT',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'MASUK INAP',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'KELUAR INAP',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'JML HARI INAP',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'STATUS KELUAR',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'TEMPAT RUJUKAN',
	 type : 'string',
	 filterable : true
	 }
];

function renderTable()
{
		
	$('#results').html('');
	$('#results').append('<div class="alert alert-info">Memuat Riwayat Pasien Keluar Rawat Inap...</div>');

	var jso;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/listPasienKeluar',
		success: function (dataCheck) {
			if (dataCheck.length > 0) {
				jso = dataCheck;
				setupPivot({
					json: jso,
					fields: fields,
					rowLabels: ["NAMA PASIEN","ALAMAT", "MASUK INAP", "KELUAR INAP", "JML HARI INAP", "STATUS KELUAR", "TEMPAT RUJUKAN"]
				})
				$('.stop-propagation').click(function (event) {
					event.stopPropagation();
				});
			}
			else {
				$('#results').html('');
				$('#results').append('<div class="alert alert-success">Riwayat Pasien Keluar Rawat Inap Kosong!</div>');
			}
		},
		error: function (xhr, status, error) {			
		}
	});
}

</script> 