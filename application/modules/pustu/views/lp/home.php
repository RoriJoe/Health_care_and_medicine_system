<div class="container">
    <div class="row">	
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Data Pasien</h3>
                </div>
                <div class="panel-body" >
                    <label>Nomor Identitas Pasien :</label><br>
                    <div id="nikAntrian" class="alert alert-success"></div>
                    <label>Nama Pasien :</label><br>
                    <div id="namaAntrian" class="alert alert-success"></div> 
                    <label>Tempat/Tanggal Lahir :</label><br>
                    <div id="ttlAntrian" class="alert alert-success"></div>
                    <label>Alamat :</label><br>
                    <div id="alamatAntrian" class="alert alert-success"></div>
                    <label>Nomor Index :</label><br>
                    <div id="noSehatAntrian" class="alert alert-success"></div>
                    <div id="layanan" hidden="hidden">
                        <form method="post" action="<?php echo base_url(); ?>index.php/pustu/lp/oldRegistration">
                            <input class="" type="text" id="tanggal" name="tanggal" hidden="hidden">
                            <div class="form-group">
                                <label for="pembayaranPasien">Sumber Pembayaran</label>
                                <select required id="pembayaranPasien" class="form-control" name="pembayaranPasien">
                                    <option value="">Pilih Sumber Pembayaran Pasien</option>
                                    <?php foreach ($payment as $row) : ?>
                                        <option value="<?php echo $row['ID_SUMBER'] ?>"><?php echo $row['NAMA_SUMBER_PEMBAYARAN'] ?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                            <input type="text" id="no" name="no" hidden="hidden">
                            <div class="form-group">
                                <label for="pelayananPasien">Unit Pelayanan Yang Dituju</label>
                                <select required id="pelayananPasien" class="form-control" name="pelayananPasien" onchange="checkSubUnit()">
                                    <option value="">Pilih Unit</option>
                                    <option value="<?= $idUnit . '_pu' ?>">Poli Umum</option>
                                    <option value="<?= $idUnit . '_kia' ?>">Poli KIA-Ibu Hamil</option>
                                    <option value="<?= $idUnit . '_vkkia' ?>">Poli KIA-VK KIA</option>
                                    <option value="<?= $idUnit . '_balita' ?>">Poli KIA-Anak Balita</option>
                                    <option value="<?= $idUnit . '_kb' ?>">Poli KIA-KB</option>
                                </select> 
                            </div>
                            <div class="form-group">
                                <label >Tanggal Antrian</label>
                                <input required class="form-control datepicker" id="tanggalAntrian" name="tanggalAntrian" placeholder="Contoh: 31-08-2014" value="<?php echo date('d-m-Y'); ?>">
                            </div>
                            <div class="form-group">
                                <label >Waktu Antrian</label>
                                <input required class="form-control" name="waktuAntrian" type="text" value="<?php
                                $time = date('H:i:s');
                                echo $time
                                ?>" placeholder="Format 24 Jam: Jam:Menit:detik , contoh: 21:15:55">
                                <!--<time datetime=""></time>-->
                            </div>
                            <br>
                            <button class="btn btn-two pull-right" type="submit">Daftar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <section class="slice bg-2 p-15">
                    <h4>Pendaftaran Pasien </h4>
            </section> &nbsp;
            <!-- Error Message -->  
            <?php if (isset($error_msg)) :
                if ($error_msg == "success") : ?>
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
                $error_msg = null;
            endif; ?>
            <!-- end of error Message; -->
            <div>
                <a  class="btn btn-success" style="color: white" href="<?php echo base_url(); ?>pustu/lp/newPatient"> Pasien Baru <i class="fa fa-plus"></i> </a>                    
                <div>
                    <br>
                    <div>
                        <span class="hide-on-print" id="pivot-detail"></span>
                        <div id="results"></div>
                    </div>
                </div>
            </div>
        </div>
	<br>
	<br>

        <!-- MODAL -->
        <div style="display: none;" class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alert alert-warning">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                        <h4 class="modal-title">Ubah Data Pasien</h4>
                    </div>
                    <div class="modal-body">
                        <div class="position-center">
                            <form method="post" action="<?php echo base_url(); ?>index.php/pustu/lp/update">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="selectedIdPasien">Nomor Identitas</label>
                                            <input readonly class="form-control" id="selectedIdPasien" name="selectedIdPasien" placeholder="Nomor KTP" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="selectedNamaPasien">Nama Lengkap</label>
                                            <input class="form-control" id="selectedNamaPasien" name="selectedNamaPasien" placeholder="Masukkan Nama Lengkap Pasien" type="text">
                                        </div>
                                    </div>					
                                </div>				
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="selectedAlamatPasien">Alamat Lengkap</label>
                                            <input class="form-control" id="selectedAlamatPasien" name="selectedAlamatPasien" placeholder="Masukkan Alamat Lengkap Pasien" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="selectedTanggalLahirPasien">Tanggal Lahir</label><br/>
                                            <input class="form-control datepicker" id="selectedTanggalLahirPasien" name="selectedTanggalLahirPasien" placeholder="Masukkan Tanggal Lahir">
                                        </div>
                                    </div>	
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selectedPendidikanPasien">Pendidikan</label><br/>
                                            <input class="form-control" id="selectedPendidikanPasien" name="selectedPendidikanPasien" placeholder="Masukkan Pendidikan" type="text">
                                        </div>
                                   </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selectedTeleponPasien1">Telepon 1</label>
                                            <input class="form-control" id="selectedTeleponPasien1" name="selectedTeleponPasien1" placeholder="Masukkan Nomor Telepon" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selectedTeleponPasien2">Telepon 2</label>
                                            <input class="form-control" id="selectedTeleponPasien2" name="selectedTeleponPasien2" placeholder="Masukkan Nomor Telepon" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selectedGenderPasien">Gender</label><br/>
                                            <select class="form-control" id="selectedGenderPasien" name="selectedGenderPasien">
                                                <option value="Laki-Laki">Laki-Laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selectedAgamaPasien">Agama</label><br/>
                                            <select class="form-control" id="selectedAgamaPasien" name="selectedAgamaPasien">
                                                <option value="">Silahkan Pilih</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Kristen">Katolik</option>
                                                <option value="Kristen">Protestan</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Budha">Budha</option>
                                                <option value="Budha">Khonghucu</option>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selectedDarahPasien">Golongan Darah</label><br/>
                                            <select class="form-control" id="selectedDarahPasien" name="selectedDarahPasien">
                                                <option selected value="">Tidak Tahu</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="AB">AB</option>
                                                <option value="O">O</option>											
                                            </select> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="selectedNomorKKPasien">Nama Kepala Keluarga</label>
                                            <input class="form-control" id="selectedNomorKKPasien" name="selectedNomorKKPasien" placeholder="Masukkan Nomor Kartu Keluarga Pasien" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="selectedKelurahanPasien">Kelurahan</label><br/>
                                            <input class="form-control" id="selectedKelurahanPasien" name="selectedKelurahanPasien" placeholder="Masukkan Kelurahan" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="selectedKecamatanPasien">Kecamatan</label><br/>
                                            <input class="form-control" id="selectedKecamatanPasien" name="selectedKecamatanPasien" placeholder="Masukkan Kecamatan" type="text">
                                        </div>
                                    </div>	
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-warning pull-right" type="submit">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pop up delete confirmation -->      
        <div style="display: none;" class="modal fade in" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel" aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
                        <h4 class="modal-title">Konfirmasi</h4>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin menghapus entri <strong id="deletedItem"></strong> ?
                    </div>
                    <div class="modal-footer">
                        <form class="form-vertical" method="post" action="<?php echo base_url(); ?>index.php/pustu/lp/remove">
                            <div class="form-group">
                                <input type="text" id="selected" name="selected" hidden="hidden"/> 
                                <button data-dismiss="modal" class="btn btn-default" type="button">Tutup</button>
                                <button class="btn btn-danger" type="submit">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Eof Delete -->  

<script>
    var fields = [{
            name: 'NOMOR',
            type: 'string',
            filterable: true
        },{
            name: 'NOMOR IDENTITAS',
            type: 'string',
            filterable: true
        }, {
            name: 'NAMA PASIEN',
            type: 'string',
            filterable: true
        }, {
            name: 'ALAMAT PASIEN',
            type: 'string',
            filterable: true
        },{
            name: 'NAMA KK PASIEN',
            type: 'string',
            filterable: false
        },{
            name: 'PILIH',
            type: 'string',
            filterable: false
        },{
            name: 'UBAH',
            type: 'string',
            filterable: false
        }
    ];

    function renderTable()
    {
        var jso;
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().'pustu/lp/showOldPatients'; ?>',
            success: function (dataCheck) {
                // alert(dataCheck);

                jso = dataCheck;
                setupPivot({
                    json: jso,
                    fields: fields,
                    rowLabels: ["NOMOR", "NOMOR IDENTITAS", "NAMA PASIEN", "ALAMAT PASIEN", "NAMA KK PASIEN", "PILIH", "UBAH"]
                })
                $('.stop-propagation').click(function (event) {
                    event.stopPropagation();
                });
            }
//            ,error: function (xhr, status, error) {
//                alert("error bung " + xhr.responseText);
//            }
        });
    }

    function checkSubUnit () {
        var chosenUnit = $('#pelayananPasien :selected').text();
        if (chosenUnit == 'KIA') {
            var content = '<select id="subUnitPelayanan" class="form-control" name="subUnitPelayanan">';
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

    function editPatient (id, nik, nama, gender, tempat, tanggal, alamat, rt, rw, kelurahan, kecamatan, kota, nosehat, telepon1, telepon2, kk, pendidikan, darah, agama ) {
        $('#selectedAgamaPasien').val(agama);
        $('#selectedGenderPasien').val(gender);
        $('#selectedDarahPasien').val(darah);
        $('#selectedIdPasien').val(nik);
        $('#selectedNamaPasien').val(nama);
        $('#selectedAlamatPasien').val(alamat);
        $('#selectedTeleponPasien1').val(telepon1);    
        $('#selectedTeleponPasien2').val(telepon2);   
        $('#selectedNomorKKPasien').val(kk);   
        $('#selectedKelurahanPasien').val(kelurahan);   
        $('#selectedKecamatanPasien').val(kecamatan);   
        $('#selectedPendidikanPasien').val(pendidikan);   
        $('#selectedTanggalLahirPasien').val(tanggal);
    }

    function removePatient (id) {
        var split = id.split('_');
        var item = document.getElementById('nama'+split[0]).value;
        document.getElementById('deletedItem').innerHTML = item;
        document.getElementById('selected').value = split[0]; 
    }

    function antriPasien (id, nik, nama,gender, tempat, tanggal, alamat, rt, rw, kelurahan, kecamatan, kota, nosehat) {
        document.getElementById('nikAntrian').innerHTML = nik;
        document.getElementById('namaAntrian').innerHTML = nama +" ("+ gender+")";
        document.getElementById('ttlAntrian').innerHTML = tempat + "/" + tanggal;
        $('#tanggal').val(tanggal);
        document.getElementById('alamatAntrian').innerHTML = alamat +
        " RT. " + rt +" RW. "+ rw +", Kelurahan " + kelurahan + ", Kecamatan "+ kecamatan + ", Kota " + kota;
        document.getElementById('noSehatAntrian').innerHTML = nosehat;
        document.getElementById('layanan').hidden = "";
        document.getElementById('no').value = id; 
    }
    
    function change(time, first, second, third){
        var r = time.match(/^\s*([0-9]+)\s*-\s*([0-9]+)\s*-\s*([0-9]+)(.*)$/);
        return r[first]+"-"+r[second]+"-"+r[third];
    }

    $(function () {
        renderTable();
        checkSubUnit ();
        $( ".datepicker" ).datepicker({
                format: 'dd-mm-yyyy',
        });
        $("#pivot-table").class("table-responsive");
    });
</script>

<style>
    .datepicker {
            z-index: 100000;
    }
</style>
