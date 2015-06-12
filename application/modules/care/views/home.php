
<div class="container">
    <div class="row">
        <div class="col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Informasi Kamar Tidur</h3>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-responsive">						
					<tbody>
					<tr>
						<td><strong>Tidak Terpakai</strong></td>
						<td><?php echo $remainBeds; ?> kasur</td>
					</tr>
					<tr>
						<td><strong>Jumlah Terpakai</strong></td>
						<td><?php echo ($allBeds-$remainBeds); ?> kasur</td>
					</tr>
					<tr>
						<td><strong>Total Kasur</strong></td>
						<td><?php echo $allBeds; ?> kasur</td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
				
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Data Antrian Rawat Inap</h3>
                </div>
                <div class="panel-body">
					<table style="width: 100%;" class="table table-striped table-responsive">
						 <tr> 
						 <td style="background-color: #C3FFB5">Hijau</td>
						 <td colspan=2>Antrian dari Loket</td>
						 </tr>
						 
						 <tr> 
						 <td style="background-color: yellow">Kuning</td>
						 <td colspan=2>Antrian dari Poli Lain</td>
						 </tr>
					</table>
                    <div style="height: 700px; overflow-y: scroll;">
                        <table id="tabelAntrian" style="width: 100%;" class="table table-responsive">
                                <!--<thead>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Pilih</th>
                                </thead> -->
                            <tbody>								 
								 
                                 <?php if (isset($queues)) : ?>
                                    <?php $counter = 1; foreach ($queues as $row) : ?>
                                        <tr style="background-color: <?php if ($row['flag_intern'] == '0') echo '#C3FFB5'; else echo 'yellow'; ?>" id="row<?php echo $row['id_antrian_unit']; ?>">
                                            <td><?php echo $counter++; ?></td>					
                                            <td><?php echo $row['nama_pasien']; ?></td>
                                            <td><button type="button" class="btn btn-xs btn-success" onclick="getPatient(<?php echo $row['id_riwayat_rm']; ?>,<?php echo $row['id_antrian_unit']; ?>)"><i class="fa fa-check"></i></button></td>
											<td><button type="button" class="btn btn-xs btn-danger" onclick="removeAntrian(<?php echo $row['id_riwayat_rm']; ?>,<?php echo $row['id_antrian_unit']; ?>)"><i class="fa fa-cut"></i></button></td>
                                        </tr>
                                    <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
		
		
		
        <div class="col-md-8">
            <section class="slice bg-2 p-15">
                <h3>Kunjungan Pasien Rawat Inap</h3>
            </section>	
			<br>
			
            <div class="col-md-12">                            
                <div class="form-body" >
                    <div class="row alert alert-info" id="data_pas" hidden="hidden">
						<h4>PROFIL PASIEN</h4>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                    <label ><u>NOMOR IDENTITAS</u></label>
                                    <input class="form-control" id="norekammedik" readonly>									
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><u>NAMA</u></label>
                                    <input class="form-control" id="namapasien" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3  form-group">
								<label ><u>UMUR</u></label>
								<input class="form-control" id="umurpasien" readonly>
                            </div>
                            <div class="col-md-3 form-group">
								<label ><u>JENIS KELAMIN</u></label>
								<input class="form-control" id="jkpasien" readonly>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
								<label ><u>ALAMAT</u></label>
								<input class="form-control" id="alamatpasien" readonly>
                            </div>							
                        </div>
						<div class="row">
                            <div class="col-md-6 form-group">
								<label ><u>KUNJUNGAN TERAKHIR</u></label>
								<input class="form-control" id="kunjunganpasien" readonly>
                            </div>							
                        </div>
						<div class="row">
							<div class="col-md-4">
								<strong><a id="linknya" type='button' class='btn btn-xs btn-warning' style='color: white' href="" target='_blank'>Lihat Data Riwayat Kunjungan Pasien</a></strong>
							</div>
						</div>
                    </div>  
				</div>  
				
                <div class="row form-body">
                    <!-- Error Message -->  
                    <?php if (isset($error_msg)) : ?>

                            <?php if ($error_msg == "success") : ?>

                            <div class="alert alert-success fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                <strong>Well done!</strong> You successfully read this important alert message.
                            </div>

                            <?php elseif ($error_msg == "failed") : ?>

                            <div class="alert alert-block alert-danger fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                <strong>Oh snap!</strong> Change a few things up and try submitting again.
                            </div>

                        <?php endif;
                        $error_msg = null; ?>
                        <?php endif; ?>
                    <!-- end of error Message; -->

                    <div id="detail_riwayat" class ="col-md-12" hidden="hidden">
						<h4>FORM RAWAT INAP</h4>
                        <form id="FormHomePoliumum" method="post" action="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/updateRMHistory">
                            <input id="id_rrm" name="id_rrm" hidden="hidden">
							<input type="hidden" id="hidden_noantrian" name="hidden_noantrian" >
							<input type="hidden" name="pembayaranPasien" id="pembayaranPasien" value="" />
							
                            <div class="row">  
								<div class="col-md-4 form-group">
									<label>Waktu Rawat Inap</label>
									<input id="startop" name="startop" readonly value="<?php date_default_timezone_set("Asia/Jakarta");  echo date('d-m-Y H:i:s'); ?>" class="form-control">
								</div>									
                            </div>
							
							<div class="row">
								<div class="col-lg-12">		
									<div  id="results"></div>
								</div>
								
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Kamar yang terpilih</label><br>
                                        <table style="width: 100%; " class="table-responsive">
                                            <tbody id="bodyChoosedBed">

                                            </tbody>
                                        </table>
                                    </div>			
                                </div>
                            </div>
							
							<div class="row">
								<div class="col-md-4">
									<button id="setujuiBtn" class="btn btn-primary col-md-12" type="submit">Setujui Rawat Inap</button>
								</div>
								<div class="col-md-4">
									
									<input name="flagbutton" id="flagbutton" value="" type="hidden">	
									<input name="id_unit_tujuan" id="id_unit_tujuan" value="" type="hidden">	
									<input name="laborat" id="laborat" value="" type="hidden">
									
									<button class="btn btn-primary col-md-12" data-toggle="modal" data-target="#myModal2" type="button">Arahkan ke Poli Lain</button>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header alert alert-info">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Arahkan Pasien ke Poli Lain</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-md-12">
						<select name="unit4" id="unit4" class="form-control" onchange="checkSubUnit4()">
							<?php 
							foreach ($unit as $r) { 							
								if (strpos(strtoupper($r['NAMA_UNIT']), strtoupper('rawat inap')) === false) { 
								
								 echo '<option value="'. $r['ID_UNIT'].'">'.$r['NAMA_UNIT'].'</option>';
								 
								}

							} ?>
						</select>
					</div>
				</div>
				<div id="subunit4">
								
				</div>
								<div class="row form-group">
                                    <div class="col-lg-6">
                                        <label>Tanggal Kunjungan</label>
                                        <input class="form-control datepicker" id="tanggalAntrian" name="tanggalAntrian" placeholder="Contoh: 31-08-2014" value="<?php echo date('d-m-Y'); ?>">
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Waktu Antrian</label>
                                        <input class="form-control" name="waktuAntrian" type="text" value="<?php
                                        $time = date('H:i:s');
                                        echo $time
                                        ?>" placeholder="Format 24 Jam: Jam:Menit:detik , contoh: 21:15:55">
                                    </div>
                                    
                                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
			   
			<button onclick="CheckLaborat(4)" type="button" class="btn btn-primary">Simpan</button>
			</div>
		</div>
	</div>
</div>
								</div>
							</div>
							</form>
							<br>

                    </div>
                </div>            

            </div>
				
			</div>		
			
        </div>
    </div>


<script type="text/javascript">

	function getPatient (rrm, id_antrian) {
		cekKamar();
		
		$("#data_pas").hide();
		$("#detail_riwayat").hide();		
		
		$("#id_rrm").val(rrm);
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/getPatientData'; ?>",
			data: {id : rrm},
			success: function(data){   			
				if (data) {
					dataObj = jQuery.parseJSON(data);				
					$("#detail_riwayat").show();
						$("#norekammedik").val(dataObj.noid_pasien);
						$("#namapasien").val(dataObj.nama_pasien);
						$("#umurpasien").val(Math.floor(dataObj.umur/12)+" Th");
						$("#umur").val(dataObj.umur);
						$("#jkpasien").val(dataObj.gender_pasien);
						$("#alamatpasien").val(dataObj.alamat_pasien);
						$("#kunjunganpasien").val(dataObj.WAKTU_ANTRIAN_UNIT);
						$('#linknya').attr("href","<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/patientMRH/'; ?>"+dataObj.id_rekammedik);
					$("#hidden_noantrian").val(id_antrian);
					$("#data_pas").show();
					$('#data_pas').scrollTop( '100%' );	
						$("#pembayaranPasien").val(dataObj.ID_SUMBER);
						$("#sumberbayar").text(dataObj.NAMA_SUMBER_PEMBAYARAN);
					// getPatHistory (rrm);
					
					renderTable();
				}			
			},
			error: function(e){				
			}
		});
	}

	function tolakRawat (id_antrian) {
		if (confirm("Tolak Rawat Inap?") == true ){
			$.ajax({
					type: "POST",
					url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/declineRI",
					data: {id : id_antrian},
					success: function () {
						window.location.href = "<?php echo base_url(); ?>care";
					}
			});
		}
	}


    var fields = [
		{
            name: 'NOMOR TEMPAT TIDUR',
            type: 'string',
            filterable: true
        },{
            name: 'KATEGORI',
            type: 'string',
            filterable: true
        },{
            name: 'RUANGAN',
            type: 'string',
            filterable: true
        },{
            name: 'PILIH',
            type: 'string',
            filterable: true
        }
    ]

    function renderTable()
    {
		$('#results').html('');
		$('#results').append('<div class="alert alert-info">Memuat Daftar Kamar Tidur...</div>');
		var jso;
		
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showRemainBed',
            success: function (dataCheck) {                
				if (dataCheck.length > 0){
					jso = dataCheck;
					setupPivot({
						json: jso,
						fields: fields,
						rowLabels: ["NOMOR TEMPAT TIDUR", "KATEGORI", "RUANGAN", "PILIH"]                           
					})
					$('.stop-propagation').click(function (event) {
						event.stopPropagation();
					});
				}
				else {
					$('#results').html('');
					$('#results').append('<div class="alert alert-success">Daftar Kamar Tidur Kosong...</div>');
				}
            },
            error: function (xhr, status, error) {              
            }
        });
    }
	
	function BedChoosed (value, nomor, kategori, ruangan) {
			$('#bodyChoosedBed').html('');
			$('#bodyChoosedBed').append('<tr id="bed-'+value+'"><td><input id="bed-'+value+'" name="bed-'+value+'" readonly class="form-control" type="text" value="'+nomor+' - (Kat: '+kategori+') (Ruang: '+ruangan+')"></td><td><button onclick="removeSelectedBed('+value+')" class="btn btn-danger">Hapus</button>');
			cekKamar();
	}

	function removeSelectedBed (value) {
		$('#bodyChoosedBed').find('#bed-'+value+'').remove();
		cekKamar();
	}
	
	function removeAntrian (rrm, id_antrian) {
		if (confirm("Apakah Anda yakin menghapus antrian ini?") == true ){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/removeDataAntrian'; ?>",
				data: {id_rrm : rrm, id_antrian : id_antrian},
				success: function(data){
					if (data.length > 0) {
						window.location = "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2);?>";
					}
				},
				error: function(e){
				}
			});
		}	
	}
	
	function cekKamar () {
		var kamarTerpilih = $('#bodyChoosedBed');			
		if (kamarTerpilih.children().length == 0) {
			$("#setujuiBtn").attr("disabled", "disabled");
		}
		else $("#setujuiBtn").removeAttr("disabled");
	}

	function CheckLaborat (value) {
		$('#flagbutton').val(value);
		$('#id_unit_tujuan').val ($('#unit'+value).val());
		
		var str = $('#unit'+value+' :selected').text();
		if (str.toLowerCase().indexOf("laborat") >= 0 ) {
			$('#laborat').val ('1');		
		}
		else $('#laborat').val ('0');		
		
		$('#FormHomePoliumum').submit();
	}

</script>    