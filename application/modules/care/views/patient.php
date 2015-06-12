
<div class="container">
<div class="row">
	<div class="col-md-12">
	<section class="slice bg-2 p-15">
         <h3>Data Pasien Rawat Inap</h3>
    </section> &nbsp;
	<div>		
		<div style="" id="results"></div>
	</div>
	</div>
</div>
</div>

<br>
<br>

<script type="text/javascript">
	$(function () {
		renderTable();
	});

    var fields = [
		{
            name: 'NAMA PASIEN',
            type: 'string',
            filterable: true
        }, {
            name: 'TGL MASUK RAWAT INAP',
            type: 'string',
            filterable: true
        }, {
            name: 'KATEGORI',
            type: 'string',
            filterable: true
        }, {
            name: 'RUANGAN',
            type: 'string',
            filterable: true
        }, {
            name: 'NOMOR TEMPAT TIDUR',
            type: 'string',
            filterable: true
        }, {
            name: 'DETAIL',
            type: 'string',
            filterable: true
        }
    ]

    function renderTable()
    {
		$('#results').html('');
		$('#results').append('<div class="alert alert-info">Memuat Data Pasien Rawat Inap...</div>');

		var jso;
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showPatient',
            success: function (dataCheck) {
				if (dataCheck.length > 0 ) {
					jso = dataCheck;
					setupPivot({
						json: jso,
						fields: fields,
						rowLabels: ["NAMA PASIEN", "TGL MASUK RAWAT INAP", "KATEGORI", "RUANGAN", "NOMOR TEMPAT TIDUR", "DETAIL"]                            
					})
					$('.stop-propagation').click(function (event) {
						event.stopPropagation();
					});
				}
				else {
					$('#results').html('');
					$('#results').append('<div class="alert alert-success">Data Pasien Rawat Inap Kosong!</div>');
				}
            },
            error: function (xhr, status, error) {
            }
        });
    }

</script>    



