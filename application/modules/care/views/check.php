<div class="container">
    <div class="row">
        <div class="col-md-12">
            <section class="slice bg-2 p-15">
                <h3>Pemeriksaan Baru</h3>
            </section>	
			<br>
            <div>                            
                <div class="form-header">
                    <h4>FORM RIWAYAT REKAM MEDIK</h4>
                </div>
                <div class="form-body">
                    <div id="detail_riwayat" class="">
                        <form id="FormPemeriksaanBaru" method="post" action="<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/insertNewCheckup'; ?>">
                            <input id="id_rawat_inap" name="id_rawat_inap" hidden="hidden" value="<?php echo $this->uri->segment(5); ?>">	<input id="id_rm" name="id_rm" hidden="hidden" value="<?php echo $this->uri->segment(4); ?>">		
                            <div class="row">
                                <div class="col-md-3">
                                    <div >
                                        <label for="tinggi">Tinggi Badan</label>
                                        <input autofocus class="form-control" id="tinggi" name="tinggi" placeholder="dalam centimeter" min="0" type="number">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="berat">Berat Badan</label>
                                        <input class="form-control" id="berat" name="berat" placeholder="dalam kilogram" type="number" min="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sistol">Tekanan Darah Atas</label>
                                        <input class="form-control" id="sistol" name="sistol" placeholder="sistol" type="number" min="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="diastol">Tekanan Darah Bawah</label>
                                        <input class="form-control" id="diastol" name="diastol" placeholder="diastol" type="number" min="0">
                                    </div>
                                </div>
                            </div>	
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="keluhan">Anamnesa/Keluhan</label><br>
                                        <textarea rows="1" style="height: 110px; resize: none" class="form-control" id="keluhan" name="keluhan" placeholder="Keluhan Pasien dipisahkan dengan koma. Contoh: mual,muntah,masuk angin"></textarea>
                                    </div>
                                </div>		
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="suhu">Suhu</label>
                                        <input class="form-control" id="suhu" name="suhu" placeholder="derajat Celcius" type="number">
										<!--<input class="form-control" id="umur" name="umur" placeholder="suhu badan dalam Celcius" type="hidden">-->
                                    </div>									
                                </div>		
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jantung">Detak Jantung</label><br>
                                        <input class="form-control" id="jantung" name="jantung" placeholder="Detak Jantung" type="number" min="0">									
                                    </div>
                                </div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="napas">Napas per Menit</label>
										<input class="form-control" id="napas" name="napas" placeholder="Napas/menit" type="number" min="0">										
									</div>
								</div>									
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Diagnosa Utama (ICD X)</label><br>
                                        <div class="input-group">
                                            <input id="queryicd" name="queryicd" class="form-control" placeholder="Masukkan kata pencarian utama" type="text">
                                            <span class="input-group-btn">									
                                                <button style="" class="btn btn-primary" type="button" onclick="renderTable()">Cari Kode ICD X</button>
                                                <!-- <a class="btn btn-two" type="button" onclick="getICD()">Go!</a> -->
                                            </span>
                                        </div>
                                    </div>			
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                   
                                    <div style="" id="results"></div>
                                </div>                              
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Daftar ICD X yang dipilih</label><br>
                                        <table style="width: 100%; " class="table-responsive">
                                            <tbody id="bodyChoosedICD">

                                            </tbody>
                                        </table>
                                    </div>			
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="keluhan">Diagnosa Keterangan</label><br>
                                        <textarea required rows="1" style="height: 100px; resize:none;" class="form-control" id="diagnosa" name="diagnosa" placeholder="Keterangan Diagnosa Pasien"></textarea>
                                    </div>
                                </div>							
                            </div>
							
							
							
							<div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="layananKesehatan">Layanan Kesehatan</label><br>
										<div class="input-group">
											<select id="layananKesehatan" name="layananKesehatan" class="form-control">
											<option value="">Pilih Layanan Kesehatan</option>
											  <?php foreach ($layanan as $row) :?>
											  <option value="<?php echo $row['ID_LAYANAN_KES'] ?>"><?php echo $row['NAMA_LAYANAN_KES'] ?></option>
											  <?php endforeach; ?>
											</select> 
											<span class="input-group-btn">									
                                                
											 <button class="btn btn-primary" type="button" onclick="LayananChoosed()" id="buttonLayanan" ><i class="fa fa-check" ></i></button>
											 </span>
										 </div>
                                    </div>
                                </div>
								
                            </div>
							<div class="row">
								<div class="col-md-12">
										<div class="form-group">
											<label for="">Daftar Layanan Kesehatan yang dipilih</label><br>
											<table style="width: 100%; " class="table-responsive">
												<tbody id="bodyChoosedLayanan">

												</tbody>
											</table>
										</div>
									</div>
							</div>
							
							
							
							
                            <!--<input type="hidden" id="hidden_noantrian" name="hidden_noantrian" >-->
                            <div class="row">
                                <div class="col-md-3">
									<div class="form-group">
                                        <label for="kunjungan">Kunjungan Pasien</label><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input id="kunjungan" name="kunjungan" type="radio" value="BARU"> Baru
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input checked id="kunjungan" name="kunjungan" type="radio" value="LAMA"> Lama
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-12">
                                                <input id="kunjungan" name="kunjungan" type="radio" value="LAMA"> KKL
                                            </div>
                                        </div>										
                                    </div>   
									<div class="form-group">
                                        <label for="pembayaranPasien">Sumber Pembayaran Pasien</label><br>
                                        <div class="row">
                                            <div class="col-md-12">                                                
												<select id="pembayaranPasien" class="form-control" name="pembayaranPasien">
													<?php foreach ($payment as $row) : ?>
														<option value="<?php echo $row['ID_SUMBER'] ?>"><?php echo $row['NAMA_SUMBER_PEMBAYARAN'] ?></option>
													<?php endforeach; ?>
												</select>
												
                                            </div>
                                        </div>
                                     								
                                    </div> 									
                                </div>	
								<div class="col-md-3">									
									<div class="form-group">
                                        <label for="status">Status Pasien Keluar Rawat Inap</label><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input id="status" name="status" type="radio" value="1"> Sembuh 
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-12">
                                                <input id="status" name="status" type="radio" value="2"> Meninggal Dunia
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-12">
                                                <input id="status" name="status" type="radio" value="3"> Pulang Paksa
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-12">
                                                <input id="status" name="status" type="radio" value="4"> Rujukan
												<input class="form-control" placeholder="Contoh: Rumah Sakit Dharma" id="rujuk" name="rujuk" type="text" value="">
                                            </div>
                                        </div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
                                        <label for="rawat">Penyakit</label><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input id="flagpneumonia" name="flagpneumonia" type="checkbox" value="1"> Pneumonia 
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-12">
                                                <input id="flagdiare" name="flagdiare" type="checkbox" value="1"> Diare 
                                            </div>
                                        </div>
									</div>
								</div>
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rawat">Status Perawatan</label><br>
                                        <!--<div class="row">
                                            <div class="col-md-12">
                                                <input required id="rawat" name="rawat" type="radio" value="0"> Rawat Jalan
                                            </div>
                                        </div>-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input checked required id="rawat" name="rawat" type="radio" value="1"> Rawat Inap
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-md-12">
												<br>
                                                <label for="tanggalriwayat">Tanggal Pemeriksaan : <br>
												<input id="tanggalriwayat" name="tanggalriwayat" readonly value="<?php date_default_timezone_set("Asia/Jakarta");  echo date('d-m-Y H:i:s'); ?>" class="form-control">
                                            </div>
                                        </div>
										<!--<div class="row">
                                            <div class="col-md-12">
                                                <input required id="rawat" name="rawat" type="radio" value="2"> Dirujuk
												<input class="form-control" placeholder="Tempat Rujukan, Contoh: Rumah Sakit Dharma" id="rujuk" name="rujuk" type="text" value="">									
                                            </div>
                                        </div>-->
                                    </div>
                                </div>									
                            </div>           
							<br>
                            <div class="row">    
                                <div class="col-md-3">                                   
									<input name="flagbutton" id="flagbutton" value="" type="hidden">	
									<input name="id_unit_tujuan" id="id_unit_tujuan" value="" type="hidden">	
									<input name="laborat" id="laborat" value="" type="hidden">
									<button onclick="CheckLaborat(1)" type="button" class="btn btn-primary col-md-12">Simpan & Kembali ke Daftar Pasien</button>
								</div>					
								<div class="col-md-3">                                   
									<button onclick="CheckLaborat(2)" type="button" class="btn btn-primary col-md-12">Simpan & Pasien Keluar Rawat Inap</button>
								</div>								
								
								<div class="col-md-3">
									<button onclick="CheckLaborat(3)" type="button" class="btn btn-primary col-md-12">Simpan & Buat Resep</button>
								</div>
								<div class="col-md-3">
									<button class="btn btn-primary col-md-12" data-toggle="modal" data-target="#myModal2" type="button">Simpan & Arahkan ke Poli Lain</button>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header alert alert-info">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Simpan & Arahkan Pasien ke Poli Lain</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-md-12">
						<select name="unit4" id="unit4" class="form-control" onchange="checkSubUnit4()">
							<?php 
							foreach ($unit as $r) { 							
								if (strpos(strtoupper($r['NAMA_UNIT']), strtoupper('laborat')) !== false) { 								
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
					<br>					
					</div>
                </div>            

            </div>
			
			
			
        </div>
    </div>
</div>

</div>


<script type="text/javascript">
	function mySetupPivot(input){
		input.callbacks = {afterUpdateResults: function(){
		  $('#results > table').dataTable({
			"sDom": "<'row'<'col-md-6'l><'col-md-6'f>>t<'row'<'col-md-6'i><'col-md-6'p>>",
			"iDisplayLength": 5,
			"aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "All"]],
			"oLanguage": {
			  "sLengthMenu": "_MENU_ records per page"
			}
		  });
		}};
		$('#pivot-demo').pivot_display('setup', input);
	}

    var fields = [
		{
            name: 'KODE ICD X',
            type: 'string',
            filterable: true
        }, {
            name: 'ENGLISH NAME',
            type: 'string',
            filterable: true
        }, {
            name: 'INDONESIAN NAME',
            type: 'string',
            filterable: true
        }, {
            name: 'KELOLA',
            type: 'string',
            filterable: true
        }
    ]

    function renderTable()
    {
		if ($("#queryicd").val() == "") return;
		
		var data_pos = $("#queryicd").val()
        var jso;
        var data_pos = $("#queryicd").val();
        var kapsul = {};
        kapsul.teksnya = {};
        kapsul.teksnya.tanda = $("#queryicd").val();
		
		$('#results').html('');
		$('#results').append('<div class="alert alert-info">Memuat Daftar ICD X...</div>');

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/getSearch'; ?>',
            data: kapsul,
            success: function (dataCheck) {
				if (dataCheck.length > 0) {
					jso = dataCheck;
					mySetupPivot({
						json: jso,
						fields: fields,
						rowLabels: ["KODE ICD X", "ENGLISH NAME", "INDONESIAN NAME", "KELOLA"]								
					})
					$('.stop-propagation').click(function (event) {
						event.stopPropagation();
					});
				}
				else {
					$('#results').html('');
					$('#results').append('<div class="alert alert-success">Tidak dapat ditemukan!</div>');
				}
            },
            error: function (xhr, status, error) {               
            }
        });
    }
</script>    

<script>
function getPatHistory (rrm) {
	$.ajax({
		type: "POST",
		url: "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/getPatientHistory'; ?>",
		data: {id : rrm},
		success: function(data){   	
			alert (data);
			if (data) {
				dataObj = jQuery.parseJSON(data);				
				$("#detail_riwayat").show();
				$("#tinggi").val(dataObj.TINGGIBADAN_PASIEN);
				$("#berat").val(dataObj.BERATBADAN_PASIEN);
				$("#sistol").val(dataObj.SISTOL_PASIEN);
				$("#diastol").val(dataObj.DIASTOL_PASIEN);
				$("#tinggi").val(dataObj.TINGGIBADAN_PASIEN);
			}
		},
		error: function(e){          
        }
	});
}

function getPatient (rrm, id_antrian) {
	
	$("#data_pas").hide();
	$("#detail_riwayat").hide();
	// alert(rrm+" "+id_antrian);
	
	$('#tabelAntrian tbody tr').css("background-color","transparent");
	$('#row'+id_antrian).css("background-color","#e1f8ff");
	
	$("#id_rrm").val(rrm);
	$.ajax({
		type: "POST",
		url: "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/getPatientData'; ?>",
		data: {id : rrm},
		success: function(data){   			
			// alert (data);
			if (data) {
				dataObj = jQuery.parseJSON(data);				
				$("#detail_riwayat").show();
					$("#norekammedik").val(dataObj.noid_pasien);
					$("#namapasien").val(dataObj.nama_pasien);
					$("#umurpasien").val(Math.floor(dataObj.umur/12)+" Th");
					// $("#umur").val(dataObj.umur);
					$("#jkpasien").val(dataObj.gender_pasien);
					$("#alamatpasien").val(dataObj.alamat_pasien);
					$("#kunjunganpasien").val(dataObj.WAKTU_ANTRIAN_UNIT);
					$('#linknya').attr("href","<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/patientMRH/'; ?>"+dataObj.id_rekammedik);
				$("#hidden_noantrian").val(id_antrian);
				$("#data_pas").show();
					$("#pembayaranPasien").val(dataObj.ID_SUMBER);
					$("#sumberbayar").text(dataObj.NAMA_SUMBER_PEMBAYARAN);
				// getPatHistory (rrm);
			}			
		},
		error: function(e){          
        }
	});
}

function ICDChoosed (value) {
	$.ajax({
		type: "POST",
		url: "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/showICDById'; ?>",
		data: {id : value},
		success: function(data){   	
			var parsedData = JSON.parse(data);
			
			$('#bodyChoosedICD').append('<tr id="'+value+'"><td><input id="icd-'+value+'" name="icd-'+value+'" readonly class="form-control" type="text" value="'+parsedData.INDONESIAN_NAME+'"></td><td><button onclick="removeSelectedICD('+value+')" class="btn btn-warning" type="button">Hapus</button></td><td><strong>Status Kasus :</strong></td><td><input id="kasus-'+value+'" name="kasus-'+value+'" type="radio" value="BARU">Baru</td><td><input checked id="kasus-'+value+'" name="kasus-'+value+'" type="radio" value="LAMA">Lama</td></tr>');
		},
		error: function(e){
        }
	});
}

function removeSelectedICD (value) {
	$('#bodyChoosedICD').find('#'+value+'').remove();
}

function LayananChoosed () {
	value = $('#layananKesehatan').val();
	if (value != "") {
		name = $('#layananKesehatan :selected').text();
		
		$('#bodyChoosedLayanan').append('<tr id="layanan-'+value+'"><td><input id="layanan-'+value+'" name="layanan-'+value+'" readonly class="form-control" type="text" value="'+name+'"></td><td><button onclick="removeSelectedLayanan(\'layanan-'+value+'\')" class="btn btn-warning" type="button">Hapus</button></td></tr>');
	}
}

function removeSelectedLayanan (value) {
	$('#bodyChoosedLayanan').find('#'+value+'').remove();
}

// function CheckLaborat (value) {
	// $('#flagbutton').val(value);
		
	// var str = $('#unit'+value+' :selected').text();
	// if (str.toLowerCase().indexOf("laborat") >= 0 ) {
		// alert ("Ke "+$('#unit'+value+' :selected').text());
		// id_rrm = $('#id_rrm').val();
		// id_antrian = $('#hidden_noantrian').val();
		// id_unit_tujuan = $('#unit'+value).val();
		// window.location = "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/toLaborat/'; ?>" + id_rrm+"/"+id_antrian+"/"+id_unit_tujuan;
	// }
	// else {
		// $('#FormHomePoliumum').submit();
	// }
// }

function CheckSubmit (value) {
	$('#flagbutton').val(value);
	$('#FormPemeriksaanBaru').submit();
}

function CheckLaborat (value) {
	$('#flagbutton').val(value);
	$('#id_unit_tujuan').val ($('#unit'+value).val());
	
	var str = $('#unit'+value+' :selected').text();
	if (str.toLowerCase().indexOf("laborat") >= 0 ) {
		$('#laborat').val ('1');		
	}
	else $('#laborat').val ('0');		
	
	$('#FormPemeriksaanBaru').submit();
}

function checkSubUnit4 () {
		var chosenUnit = $('#unit4 :selected').text();
		if (chosenUnit == 'KIA') {
			var content = '<select id="subUnitPelayanan4" class="form-control" name="subUnitPelayanan4">';
			content += '<option value="kia">KIA-Bumil</option>';
			content += '<option value="balita">KIA-Balita</option>';
			content += '<option value="vkkia">KIA-VK KIA</option>';
			content += '<option value="kb">KIA-KB</option>';
            content += '</select>';
			$('#subunit4').append(content);
		}
		else {
			$('#subunit4').html('');
		}
	}
	
	function checkSubUnit5 () {
		var chosenUnit = $('#unit5 :selected').text();
		if (chosenUnit == 'KIA') {
			var content = '<select id="subUnitPelayanan5" class="form-control" name="subUnitPelayanan5">';
			content += '<option value="kia">KIA-Bumil</option>';
			content += '<option value="balita">KIA-Balita</option>';
			content += '<option value="vkkia">KIA-VK KIA</option>';
			content += '<option value="kb">KIA-KB</option>';
            content += '</select>';
			$('#subunit5').append(content);
		}
		else {
			$('#subunit5').html('');
		}
	}

</script>  
<style>
    .datepicker {
        z-index: 100000;
    }
</style>