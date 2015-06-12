
<div class="container">
    <div class="row">
            <section class="slice bg-2 p-15">
                <h3>Riwayat Kunjungan Pasien <?php if (isset($data_rrm)) : echo '- ' . $data_rrm[0]['NAMA_PASIEN'] ; endif;  ?></h3>
            </section>
			<br>
			<div class="row">
			<div class="col-md-6">
				<input type="hidden" value="<?php echo $id_rm ?>" id="id_rm"/>
				<label >Jumlah Data</label>
				<select class="form-control" onchange="renderTable()" id="rangedata" name="rangedata">
					<option value="100" selected>100 Riwayat Terakhir</option>
					<option value="250">250 Riwayat Terakhir</option>
					<option value="350">350 Riwayat Terakhir</option>
					<option value="">Semua Data</option>
				</select>
				<br>
			</div>
			<div class="col-md-6">					
				<a class="btn btn-success pull-right" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/newCheckUp/<?php echo $this->uri->segment(4).'/'.$this->uri->segment(5); ?>" style="color: white">
				Pemeriksaan Baru
				<i class="fa fa-plus"></i>
				</a>
			</div>
			</div>
			<div>
				<div  id="results"></div>
			</div>
    </div>
</div>
<br>
<br>

<script>
	$(function () {
		renderTable();
	})

    var fields = [
		{
            name: 'TANGGAL PERIKSA',
            type: 'string',
            filterable: true
        },{
            name: 'WAKTU PERIKSA',
            type: 'string',
            filterable: true
        },{
            name: 'DETIL',
            type: 'string',
            filterable: true
        }
    ]

    function renderTable()
    {
        var kapsul = {};
        kapsul.teksnya = {};
        kapsul.teksnya.id_rm = $("#id_rm").val();
        kapsul.teksnya.range = document.getElementById("rangedata").value;
			
		$('#results').html('');
		$('#results').append('<div class="alert alert-info">Memuat Riwayat Kunjungan Pasien...</div>');
		
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/getSearch2',
            data: kapsul,
            success: function (dataCheck) {
				if (dataCheck.length > 0) {				
					jso = dataCheck;
					setupPivot({
						json: jso,
						fields: fields,
						rowLabels: ["TANGGAL PERIKSA", "WAKTU PERIKSA", "DETIL"]                           
					})
					$('.stop-propagation').click(function (event) {
						event.stopPropagation();
					});
				}
				else {
					$('#results').html('');
					$('#results').append('<div class="alert alert-info">Riwayat Kunjungan Pasien Kosong!</div>');
				}
            },
            error: function (xhr, status, error) {
            }
        });
    }
</script>