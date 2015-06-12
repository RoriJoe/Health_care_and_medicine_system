
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <section class="slice bg-2 p-15">
                <h4>Form Pendaftaran Pasien</h4>
            </section>

            <div class="form-body"> &nbsp;

                <!-- Error Message -->  
                <?php if (isset($error_msg)) : ?>

                    <?php if ($error_msg == "success") : ?>

                        <div class="alert alert-success fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong>Berhasil!</strong>
                        </div>

                    <?php elseif ($error_msg == "failed") : ?>

                        <div class="alert alert-block alert-danger fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong>Gagal!</strong>
                        </div>

                    <?php endif;
                    $error_msg = null; ?>

<?php endif; ?>
                <!-- end of error Message; -->

                <div class="col-md-12">
                    <form method="post" id="FormDaftarPasien" action="<?php echo base_url(); ?>regBooth/lp/newRegistration">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="idPasien">Nomor Identitas Pasien</label>
                                    <input class="form-control" id="idPasien" name="idPasien" placeholder="Masukkan Nomor Identitas Pasien" type="number" min=0>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="namaPasien">Nama Lengkap</label>
                                    <input required class="form-control" id="namaPasien" name="namaPasien" placeholder="Masukkan Nama Lengkap Pasien" type="text">
                                </div>
                            </div>		
                            <div class="col-md-2"></div>
                        </div>			

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="genderPasien">Jenis Kelamin Pasien</label><br/>
                                    <select required id="genderPasien" class="form-control" name="genderPasien">
										<option selected value="">Silahkan Pilih</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select> 
                                </div>
                            </div>		
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="tanggalLahirPasien">Tanggal Lahir</label>
                                    <input required class="form-control datepicker" id="tanggalLahirPasien" name="tanggalLahirPasien" placeholder="Contoh: 31-08-1990">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tempatLahirPasien">Tempat Lahir</label>
                                    <input class="form-control" id="tempatLahirPasien" name="tempatLahirPasien" placeholder="Masukkan Tempat Lahir Pasien" type="text">
                                </div>
                            </div>		
                            <div class="col-md-2"></div>		
                        </div>

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="darahPasien">Golongan Darah</label><br/>
                                    <select id="darahPasien" class="form-control" name="darahPasien">
										<option selected value="">Tidak Tahu</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                    </select> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="agamaPasien">Agama</label>
                                    <select required id="agamaPasien" class="form-control" name="agamaPasien">
                                        <option selected value="">Silahkan Pilih</option>
										<option value="Islam">Islam</option>
										<option value="Kristen">Katolik</option>
										<option value="Kristen">Protestan</option>
										<option value="Hindu">Hindu</option>
										<option value="Budha">Budha</option>
										<option value="Budha">Khonghucu</option>
                                    </select> 
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pendidikanPasien">Pendidikan</label>
                                    <input class="form-control" id="pendidikanPasien" placeholder="Masukkan Pendidikan Pasien" name="pendidikanPasien" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pekerjaanPasien">Pekerjaan</label>
                                    <input class="form-control" id="pekerjaanPasien" placeholder="Masukkan Pekerjaan Pasien" name="pekerjaanPasien" type="text">
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>


                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="namaKKPasien">Nama Kepala Keluarga</label>
                                    <input required class="form-control" id="namaKKPasien" name="namaKKPasien" placeholder="Masukkan Nama Kepala Keluarga Pasien" type="text">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
									<input hidden="hidden" id="hubunganPasien" name="hubunganPasien" />
                                    <label for="">Posisi dalam Keluarga</label><br/>
									<select required class="form-control" id="pilihhubungan" name="pilihhubungan" onchange="setHubungan(this.value)">
										<option selected value="">Pilih Posisi dalam Keluarga</option>
										<option value="00">Kakek</option>
										<option value="00">Nenek</option>
										<option value="00">Ayah</option>
										<option value="00">Ibu</option>
										<option value="00">Saudara</option>
										<option value="01">Suami</option>
										<option value="02">Istri</option>
										<option value="03">Anak ke-</option>
									</select>
                                </div>								
                            </div>
							<div class="col-md-2" id="divanak">
								<div class="form-group">
									<label for="">Posisi Anak</label><br/>
									<select disabled class="form-control" id="pilihanak" name="pilihanak" onchange="setAnak(this.value)">
										<option selected value="">Pilih Posisi Anak</option>
										<?php $index = 1; for ($i=3; $i<23; $i++) :?>
										<?php if ($i<10) :?>
										<option value="0<?php echo $i; ?>">Anak ke-<?php echo $index; ?></option>
										<?php else : ?>
										<option value="<?php echo $i; ?>">Anak ke-<?php echo $index; ?></option>
										<?php endif; ?>
										<?php $index++; endfor; ?>
									</select>
								</div>
							</div>
                            <div class="col-md-2"></div>
                        </div>


                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="noKesehatanPasien">Nomor Index</label>
                                    <input readonly class="form-control" id="noKesehatanPasien" placeholder="Masukkan Nomor Index Pasien" name="noKesehatanPasien" type="text"
									value="<?php if (isset($nomor_index)) echo $nomor_index;?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="alamatPasien">Alamat</label><br/>
                                    <input class="form-control" id="alamatPasien" placeholder="Masukkan Alamat Pasien" name="alamatPasien" type="text">
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>


                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="rtPasien">RT</label>
                                    <input class="form-control" id="rtPasien" placeholder="Nomor RT" name="rtPasien" type="number" min=0>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="rwPasien">RW</label>
                                    <input class="form-control" id="rwPasien" placeholder="Nomor RW" name="rwPasien" type="number" min=0>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
									<input hidden="hidden" id="kelurahanPasien" name="kelurahanPasien" >
                                    <label for="">Kelurahan</label><br/>
                                    <select required class="form-control" onchange="setKelurahan(this.value)" id="pilihdesa">
										<option selected value="">Pilih Kelurahan</option>
										<?php if (isset($desa)) :?>
										<?php foreach ($desa as $row) :?>
										<option value="<?php echo $row['id_nodesa']; ?>"> <?php echo $row['nama_desa'] ?></option>
										<?php endforeach; endif; ?>
									</select>									                                    
                                </div>
                            </div>		
                        </div>

                        <div class="row">
                            <div class="col-md-2"></div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kecamatanPasien">Kecamatan</label>
                                    <input readonly class="form-control" id="kecamatanPasien" placeholder="Masukkan Kecamatan Pasien" name="kecamatanPasien" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kotaPasien">Kota</label>
                                    <input readonly class="form-control" id="kotaPasien" placeholder="Masukkan Kota Pasien" name="kotaPasien" type="text" value="JEMBER">
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telepon1Pasien">Telepon 1</label>
                                    <input class="form-control" id="telepon1Pasien" name="telepon1Pasien" placeholder="Masukkan Nomor Telepon Utama Pasien" type="number" min=0>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telepon2Pasien">Telepon 2</label>
                                    <input class="form-control" id="telepon2Pasien" name="telepon2Pasien" placeholder="Masukkan Nomor Telepon Lainnya" type="number" min=0>
                                </div>
                            </div>
                            <div class="col-md-2"></div>		
                        </div>


                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">	
                                <div class="form-group">
                                    <label for="pembayaranPasien">Sumber Pembayaran</label>
                                    <select required id="pembayaranPasien" class="form-control" name="pembayaranPasien">
                                        <option value="">Pilih Sumber Pembayaran Pasien</option>
                                        <?php foreach ($payment as $row) : ?>
                                            <option value="<?php echo $row['ID_SUMBER'] ?>"><?php echo $row['NAMA_SUMBER_PEMBAYARAN'] ?></option>
<?php endforeach; ?>
                                    </select> 
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="pelayananPasien">Unit Pelayanan Yang Dituju</label>
                                    <select required onchange="checkSubUnit()" id="pelayananPasien" class="form-control" name="pelayananPasien">
                                        <option value="">Pilih Unit</option>
                                        <?php foreach ($units as $row) : ?>
                                            <option value="<?php echo $row['ID_UNIT'] ?>"><?php echo $row['NAMA_UNIT'] ?></option>
<?php endforeach; ?>
                                    </select> 
                                </div>
                            </div>
							<div class="col-md-2" id="subunit">
								
							</div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >Tanggal Antrian</label>
                                    <input required class="form-control datepicker2" id="tanggalAntrian" name="tanggalAntrian" placeholder="Contoh: 31-08-2014" value="<?php echo date('d-m-Y'); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label >Waktu Antrian</label>
                                <input required class="form-control" name="waktuAntrian" type="text" value="<?php $time = date('H:i:s'); echo $time ?>" placeholder="Format 24 Jam: Jam:Menit:detik , contoh: 21:15:55">
                                <!--<time datetime=""></time>-->
                            </div>
                            <div class="col-md-2"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <button id="daftarBtn" class="btn btn-two pull-right" type="submit">Daftar</button>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <br><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
	function setKelurahan (value) {
		text = $("#pilihdesa :selected").text();
		$('#kelurahanPasien').val(text);
		
		$.ajax({
			type: "POST",
			data: {id: $('#pilihdesa').val() },
			url: '<?php echo base_url(); ?>regBooth/lp/setKecamatan',
			success: function (dataCheck) {
				var dataObj = eval(dataCheck);
				var kec = dataObj[0]['nama_kecamatan'];
				$('#kecamatanPasien').val(kec);
				
				var kel = dataObj[0]['nomor_desa'];
				noIndexKelurahan = '';
				if (kel < 10 ) noIndexKelurahan = '0';
				
				noIndexPuskesmas = $('#noKesehatanPasien').val().substr(0, 2);
				noIndexKelurahan += kel;
				noIndexHubungan = $('#noKesehatanPasien').val().substr(4, 2);		
				noIndexNoUrut = $('#noKesehatanPasien').val().substr(7, 5);
				currentNoIndex = noIndexPuskesmas+noIndexKelurahan+noIndexHubungan+'-'+noIndexNoUrut;
				$('#noKesehatanPasien').val(currentNoIndex);
			},
			error: function (xhr, status, error) {
				
			}
		});
	}

	function setHubungan (value) {
		text = $("#pilihhubungan :selected").text();
		$('#hubunganPasien').val(text);	
		if (value == '03') {
			$('#pilihanak').prop('disabled', false);
		}
		else {
			$('#pilihanak').prop('disabled', true);
			noIndexPuskesmas = $('#noKesehatanPasien').val().substr(0, 2);
			noIndexKelurahan = $('#noKesehatanPasien').val().substr(2, 2);
			noIndexHubungan = value;		
			noIndexNoUrut = $('#noKesehatanPasien').val().substr(7, 5);
			currentNoIndex = noIndexPuskesmas+noIndexKelurahan+noIndexHubungan+'-'+noIndexNoUrut;
			$('#noKesehatanPasien').val(currentNoIndex);
		}
	}

	function setAnak (value) {
		text = $("#pilihanak :selected").text();
		$('#hubunganPasien').val(text);	
		
		noIndexPuskesmas = $('#noKesehatanPasien').val().substr(0, 2);
		noIndexKelurahan = $('#noKesehatanPasien').val().substr(2, 2);
		noIndexHubungan = value;
		noIndexNoUrut = $('#noKesehatanPasien').val().substr(7, 5);
		currentNoIndex = noIndexPuskesmas+noIndexKelurahan+noIndexHubungan+'-'+noIndexNoUrut;
		$('#noKesehatanPasien').val(currentNoIndex);
	}

	$(function () {	   
		checkSubUnit();
	   $( ".datepicker" ).datepicker({
			format: 'dd-mm-yyyy',
		});
	});
        
        $(function () {	   
		checkSubUnit();
	   $( ".datepicker2" ).datepicker({
			format: 'dd-mm-yyyy',
		});
	});
	
	function checkSubUnit () {
		var chosenUnit = $('#pelayananPasien :selected').text();
		if (chosenUnit == 'KIA') {
			var content = ' <label for="subUnitPelayanan">Jenis KIA</label><select id="subUnitPelayanan" class="form-control" name="subUnitPelayanan">';
			content += '<option value="kia">KIA-Bumil</option>';
			content += '<option value="balita">KIA-Balita</option>';
			content += '<option value="vkkia">KIA-VK KIA</option>';
			content += '<option value="kb">KIA-KB</option>';
            content += '</select>';
			$('#subunit').append(content);
		}
		else {
			$('#subunit').html('');
		}
	}

</script>
<style>
.datepicker {
	z-index: 100000;
}
</style>