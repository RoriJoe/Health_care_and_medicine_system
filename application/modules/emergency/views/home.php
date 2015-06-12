<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Data Antrian UGD</h3>
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
                <h3>Kunjungan Pasien UGD</h3>
            </section>	
            <div>                            
                <div class="row">	
                        <br/>
                        <div class="col-md-6">
                                <div class="form-header">
                                        <h4>PROFIL PASIEN</h4>
                                </div>
                                <div class="form-body " >
                                        <div class="alert alert-info" id="data_pas" hidden="hidden">
                                                <div class="row">
                                                        <div class="col-md-6 form-group">
                                                                        <label><u>NOMOR IDENTITAS</u></label>
                                                                        <input class="form-control" id="norekammedik" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                                <div class="form-group">
                                                                        <label><u>NAMA</u></label>
                                                                        <input class="form-control" id="namapasien" readonly>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="row">
                                                        <div class="col-md-6  form-group">
                                                                <label><u>UMUR</u></label>
                                                                <input class="form-control" id="umurpasien" readonly>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                                <label><u>JENIS KELAMIN</u></label>
                                                                <input class="form-control" id="jkpasien" readonly>
                                                        </div>  
                                                </div>
                                                <div class="row">
                                                        <div class="col-md-12 form-group">
                                                                <label><u>ALAMAT</u></label>
                                                                <input class="form-control" id="alamatpasien" readonly>
                                                        </div>							
                                                </div>
                                                <div class="row">
                                                        <div class="col-md-12 form-group">
                                                                <label><u>KUNJUNGAN TERAKHIR</u></label>
                                                                <input class="form-control" id="kunjunganpasien" readonly>
                                                        </div>							
                                                </div>
                                                <div class="row">
                                                        <div class="col-md-6">
                                                                <strong><a id="linknya" type='button' class='btn btn-xs btn-warning' style='color: white' href="" target='_blank'>Lihat Data Riwayat Kunjungan Pasien</a></strong>
                                                        </div>
                                                </div>
                                        </div>  
                                </div> 
                        </div>
                        <div class="col-md-6">
                                <div class="form-header">
                                        <h4>PEMERIKSAAN LAB</h4>
                                </div>
                                <div class="form-body alert alert-info" id="tabelLab" hidden="hidden">
                                        <table class="table table-bordered table-striped table-comparison table-responsive">
                                                <thead>
                                                        <tr>	
                                                                <th>NAMA PEMERIKSAAN LAB</th>
                                                                <th>HASIL TES</th>
                                                                <th>TANGGAL TES LAB</th>
                                                        </tr>
                                                </thead>
                                                <tbody id="bodyHasilLab">  
                                                        <tr><td colspan=3><center>Kosong<center></td></tr>
                                                </tbody>
                                        </table>
                                </div>
                        </div>
                    </div>
                    <hr></hr>
                    <div class="form-header">
                            <h4>FORM RIWAYAT REKAM MEDIK</h4>
                    </div>
                    <div class="form-body">
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
                        $error_msg = null;
                    endif; ?>
                    <!-- end of error Message; -->
						
                    <div id="detail_riwayat" class="alert alert-info" hidden="hidden">
                        <form id="FormHomePoliumum" method="post" action="<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/updateRMHistory'; ?>">
                            <input id="id_rrm" name="id_rrm" hidden="hidden">							
                            <div class="row">
                                <div class="col-md-3 form-group">
                                        <label for="tinggi">Cuma Kontrol</label>
                                        <select autofocus class="form-control" id="CUMA_KONTROL" name="CUMA_KONTROL">
                                                <option value="0" checked="true">Tidak</option>
                                                <option value="1">Ya</option>
                                        </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="tinggi">Tinggi Badan</label>
                                    <input class="form-control" id="tinggi" name="tinggi" placeholder="dalam Centimeter" type="number" min="0">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="berat">Berat Badan</label>
                                        <input class="form-control" id="berat" name="berat" placeholder="dalam Kilogram" type="number" min="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sistol">Tekanan Darah Atas</label>
                                        <input class="form-control" id="sistol" name="sistol" placeholder="Sistol" type="number" min="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="diastol">Tekanan Darah Bawah</label>
                                        <input class="form-control" id="diastol" name="diastol" placeholder="Diastol" type="number" min="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="suhu">Suhu</label>
                                        <input class="form-control" id="suhu" name="suhu" placeholder="derajat Celcius" type="number" min="0">
										<!--<input class="form-control" id="umur" name="umur" placeholder="suhu badan dalam Celcius" type="hidden">-->
                                    </div>									
                                </div>		
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jantung">Detak Jantung</label><br>
                                        <input class="form-control" id="jantung" name="jantung" placeholder="Detak Jantung" type="number" min="0">									
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="napas">Napas per Menit</label>
                                            <input class="form-control" id="napas" name="napas" placeholder="Napas/menit" type="number" min="0">										
                                        </div>
                                    </div>									
                                </div>
                            </div>	
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="keluhan">Anamnesa/Keluhan</label><br>
                                        <textarea rows="1" style="height: 110px; resize: none" class="form-control" id="keluhan" name="keluhan" placeholder="Keluhan Pasien dipisahkan dengan koma Contoh: mual,muntah,masuk angin"></textarea>
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
                                    <span class="hide-on-print" id="pivot-detail"></span>
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
                                        <textarea rows="1" style="height: 50px; resize:none;" class="form-control" id="diagnosa" name="diagnosa" placeholder="Keterangan Diagnosa Pasien"></textarea>
                                    </div>
                                </div>							
                            </div>		
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="layananKesehatan">Layanan Kesehatan</label><br>
                                        <div class="input-group">
                                                <select id="layananKesehatan" class="form-control" name="layananKesehatan">
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
                            <input type="hidden" id="hidden_noantrian" name="hidden_noantrian" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kunjungan">Kunjungan Pasien</label><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input checked id="kunjungan" name="kunjungan" type="radio" value="BARU"> Baru
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input id="kunjungan" name="kunjungan" type="radio" value="LAMA"> Lama
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input id="kunjungan" name="kunjungan" type="radio" value="LAMA"> KKL
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <br>
                                                <label for="">Sumber Pembayaran : &nbsp;</label><label id="sumberbayar"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>	
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rawat">Status Perawatan</label><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input checked id="rawat" name="rawat" type="radio" value="0"> Rawat Jalan
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input id="rawat" name="rawat" type="radio" value="1"> Rawat Inap
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input id="rawat" name="rawat" type="radio" value="2"> Dirujuk
                                                <input class="form-control" placeholder="Tempat Rujukan, Contoh: Rumah Sakit Dharma" id="rujuk" name="rujuk" type="text" value="">									
                                            </div>
                                        </div>
                                    </div>
                                </div>									
                            </div>   
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="berat">Laka Lantas</label>
                                        <select class="form-control" id="UGD_LAKA_LANTAS" name="UGD_LAKA_LANTAS" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="berat">Jenis Laka Lantas</label>
                                        <select class="form-control" id="JENIS_LAKALANTAS" name="JENIS_LAKALANTAS" onchange="">
                                            <option value="1" checked="true">Luka Ringan</option>
                                            <option value="2">Luka Berat</option>
                                            <option value="3">Mati</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="berat">Penyakit Potensi KLB</label>
                                        <select class="form-control" id="UGD_PENYAKIT_POTENSI_KLB" name="UGD_PENYAKIT_POTENSI_KLB" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="berat">Sakit Lain</label>
                                        <select class="form-control" id="UGD_SAKIT_LAIN" name="UGD_SAKIT_LAIN" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="UGD_MATERNAL">UGD Maternal</label>
                                        <input min="0" required class="form-control" id="UGD_MATERNAL" name="UGD_MATERNAL" type="number">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="UGD_NEONATAL">UGD Neonatal</label>
                                        <input min="0" required class="form-control" id="UGD_NEONATAL" name="UGD_NEONATAL" type="number">
                                    </div>
                                </div>
                            </div>		
                            <div class="row">    
                                <div class="col-md-12">
                                    <input name="flagbutton" id="flagbutton" value="" type="hidden">
                                    <button onclick="CheckLaborat(1)" type="button" class="btn btn-primary">Simpan & Kembali ke Antrian Pasien</button>
                                    <button onclick="CheckLaborat(2)" type="button" class="btn btn-primary">Simpan & Buat Resep</button><br><br>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal2" type="button">Simpan & Arahkan ke Poli Lain</button>
                                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Simpan & Arahkan Pasien ke Poli Lain</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <select name="unit3" id="unit3" class="form-control" onchange="checkSubUnit3()">
                                                                    <?php foreach ($unit as $r) { ?>
                                                                            <option value="<?php echo $r['ID_UNIT'] ?>"><?php echo $r['NAMA_UNIT'] ?></option>
                                                                    <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="subunit3">
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-6">
                                                            <label>Tanggal Kunjungan</label>
                                                            <input class="form-control datepicker" id="tanggalAntrian" name="tanggalAntrian" value="<?= date('d:m:Y') ?>" placeholder="Masukkan Tanggal Lahir">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>Waktu Antrian</label>
                                                            <input required class="form-control" name="waktuAntrian" type="text" value="<?php
                                                            $time = date('H:i:s');
                                                            echo $time
                                                            ?>" placeholder="Format 24 Jam: Jam:Menit:detik , contoh: 21:15:55">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                    <button onclick="CheckLaborat(3)" type="button" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary " data-toggle="modal" data-target="#myModal" type="button">Arahkan ke Poli Lain</button> 
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Arahkan Pasien ke Poli Lain</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <input type="hidden" name="pembayaranPasien" id="pembayaranPasien" value="" />
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <select name="unit4" id="unit4" class="form-control" onchange="checkSubUnit4()">													
                                                                    <?php foreach ($unit as $r) { ?>
                                                                            <option value="<?php echo $r['ID_UNIT'] ?>"><?php echo $r['NAMA_UNIT'] ?></option>
                                                                    <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="subunit4">
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-6">
                                                            <label>Tanggal Kunjungan</label>
                                                            <input class="form-control datepicker" id="tanggalAntrian2" name="tanggalAntrian2" value="<?= date('d:m:Y') ?>" placeholder="Masukkan Tanggal Antrian">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>Waktu Antrian</label>
                                                            <input required class="form-control" name="waktuAntrian2" type="text" value="<?php
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
                    </div>
                <br>
                </div>            
            </div>
        </div>
    </div>
</div>

<style>
    .datepicker {
        z-index: 100000;
    }
</style>
<script type="text/javascript">
    $(function () {
        $(".datepicker").datepicker({
            format: 'dd-mm-yyyy',
        });
    });
    
    function checkSubUnit3 () {
            var chosenUnit = $('#unit3 :selected').text();
            if (chosenUnit == 'KIA') {
                    var content = '<select id="subUnitPelayanan3" class="form-control" name="subUnitPelayanan3">';
                    content += '<option value="kia">KIA-Bumil</option>';
                    content += '<option value="balita">KIA-Balita</option>';
                    content += '<option value="vkkia">KIA-VK KIA</option>';
                    content += '<option value="kb">KIA-KB</option>';
        content += '</select>';
                    $('#subunit3').append(content);
            }
            else {
                    $('#subunit3').html('');
            }
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

        // alert(kapsul.teksnya.tanda);
        // alert(kapsul.teksnya);
        // alert(kapsul);

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/getSearch'; ?>',
            data: kapsul,
            success: function (dataCheck) {
                jso = dataCheck;
                mySetupPivot({
                    json: jso,
                    fields: fields,
                    rowLabels: ["KODE ICD X", "ENGLISH NAME", "INDONESIAN NAME", "KELOLA"]
                            //rowLabels : ["ID OBAT","KODE OBAT","NAMA OBAT","SATUAN"]
                })
                $('.stop-propagation').click(function (event) {
                    event.stopPropagation();
                });
            },
            error: function (xhr, status, error) {
               // alert ('error');
            }
        });
    }
</script>    

<script>
function ifNull (value) {
	if (!value){
		return '-';
	}
	else return value;
}


function getLabResult (rrm) {
	// alert (rrm);
	var link = "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/getLabResult'; ?>";
	// alert (link);
		
	$.ajax({
		type: "POST",
		url: "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/getLabResult'; ?>",
		data: {id : rrm},
		success: function(data){
			// alert (data);
			if (data) {
				var dataObj = eval (data);
				$('#bodyHasilLab').html('');
				var content = '';
				$.each(dataObj, function(index, value) {
					hasiltest = ifNull (value.HASIL_TES_LAB);
					tanggaltest = ifNull (value.TANGGAL_TES_LAB);
					content += '<tr><td>' + value.NAMA_PEM_LABORAT +'</td><td>'+hasiltest+'</td><td>'+tanggaltest+'</td></tr>';
				});		
				$('#bodyHasilLab').append (content);			
			}
			else  {
				$('#bodyHasilLab').html('');
				var content = '<tr><td colspan=3><center>Kosong<center></td></tr>';
				$('#bodyHasilLab').append (content);	
			}
			$('#tabelLab').show();
		},
		error: function(e){ 
			// alert ('Error Hasil Laboratorium!');
		}
	});
}

function getPatHistory (rrm) {
	$.ajax({
		type: "POST",
		url: "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/getPatientHistory'; ?>",
		data: {id : rrm},
		success: function(data){   	
			// alert (data);			
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
                // alert(e.message);
        }
	});
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

function getPatient (rrm, id_antrian) {
	$("#data_pas").hide();
	$("#detail_riwayat").hide();
	$('#tabelLab').hide();
	// alert(rrm+" "+id_antrian);
	
	// $('#tabelAntrian tbody tr').css("background-color","transparent");
	// $('#row'+id_antrian).css("background-color","#e1f8ff");
	
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
				getLabResult(rrm);
			}			
		},
		error: function(e){
                // alert(e.message);
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
			
			$('#bodyChoosedICD').append('<tr id="'+value+'"><td><input id="icd-'+value+'" name="icd-'+value+'" readonly class="form-control" type="text" value="'+parsedData.INDONESIAN_NAME+'"></td><td><button onclick="removeSelectedICD('+value+')" class="btn btn-warning" type="button">Hapus</button></td><td><strong>Status Kasus :</strong></td><td><input id="kasus-'+value+'" name="kasus-'+value+'" type="radio" value="BARU">Baru</td><td><input id="kasus-'+value+'" name="kasus-'+value+'" type="radio" value="LAMA">Lama</td></tr>');
		},
		error: function(e){
			// alert(e.message);
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

function CheckLaborat (value) {
	$('#flagbutton').val(value);
		
	var str = $('#unit'+value+' :selected').text();
	if (str.toLowerCase().indexOf("laborat") >= 0 ) {
		// alert ("Ke "+$('#unit'+value+' :selected').text());
		id_rrm = $('#id_rrm').val();
		id_antrian = $('#hidden_noantrian').val();
		id_unit_tujuan = $('#unit'+value).val();
		window.location = "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/toLaborat/'; ?>" + id_rrm+"/"+id_antrian+"/"+id_unit_tujuan;
	}
	else {
		$('#FormHomePoliumum').submit();
	}
}

</script>  
