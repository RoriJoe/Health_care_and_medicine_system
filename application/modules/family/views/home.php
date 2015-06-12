<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Data Antrian Poli KIA</h3>
                </div>
                <div class="panel-body">
                    <table style="width: 100%;" class="table table-bordered table-responsive">
                        <tr> 
                            <td style="background-color: #C3FFB5">Hijau</td>
                            <td colspan=2>Dari Loket</td>
                        </tr>

                        <tr> 
                            <td style="background-color: yellow">Kuning</td>
                            <td colspan=2>Dari Poli Lain</td>
                        </tr>
                    </table>
                    <div style="height: 700px; overflow-y: scroll;">
                        <table id="tabelAntrian" style="width: 100%;" class="table table-responsive">
                            <tbody>
                                <?php if (isset($queues)) : ?>
                                    <?php foreach ($queues as $key => $row) : ?>
                                        <tr id="row<?php echo $row['id_antrian_unit']; ?>" style="background-color: <?php echo ($row['flag_intern'] == '0')?'#C3FFB5':'yellow'; ?>">
                                            <td>
                                                <?php
                                                echo $key + 1;
                                                ?>
                                            </td>				
                                            <td><?php echo $row['nama_pasien']; ?></td>
                                            <td><button type="button" class="btn btn-xs btn-success" id="<?php echo $row['id_riwayat_rm']; ?>_<?php echo $row['id_antrian_unit']; ?>" onclick="getPatient(<?php echo $row['id_riwayat_rm']; ?>,<?php echo $row['id_antrian_unit']; ?>)"><i class="fa fa-check"></i></button></td>
                                        </tr>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <section class="slice bg-2 p-15">
                <h3>Kunjungan Pasien Poli KIA</h3>
            </section>	
            <div class="col-md-12">                            
                <div class="form-header">
                    <h4>Profil Pasien</h4>
                </div>
                <div class="form-body" >
                    <div class=" alert alert-info" id="data_pas" hidden="hidden">
                        <div class="row form-group">
                            <div class="col-md-3 form-group">
                                <label >No. Rekam Medik</label>
                                <input class="form-control" id="norekammedik" readonly>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Nama Pasien</label>
                                    <input class="form-control" id="namapasien" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <div>
                                    <label >Umur</label>
                                    <input class="form-control" id="umurpasien" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Jenis Kelamin</label>
                                    <input class="form-control" id="jkpasien" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6 form-group">
                                <label >Alamat</label>
                                <input class="form-control" id="alamatpasien" readonly>
                            </div>							
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6 form-group">
                                <label >Kunjungan Terakhir</label>
                                <input class="form-control" id="kunjunganpasien" readonly>
                            </div>							
                        </div>
<!--                        <div class="row form-group">
                            <div class="col-md-12">
                                <strong><a id="linknya" type='button' class='btn btn-xs btn-warning' style='color: white' href="" target='_blank'>Lihat Data Riwayat Kunjungan Pasien</a></strong>
                            </div>
                        </div>-->
                        <div class="row form-group">
                            <div class="col-md-12">
                                <button class="btn btn-primary goToBalita" type="button">Halaman Anak-Balita</button>
                                <button class="btn btn-primary goToBumil" type="button">Halaman Ibu Hamil</button>
                                <button class="btn btn-primary goToKb" type="button">Halaman KB</button>
                                <button class="btn btn-primary goToVKKIA" type="button">Halaman VK KIA</button>
                            </div>
                        </div>
                    </div>  
                    <!--<hr></hr>-->
<!--                    <div class="form-header">
                        <h4>Form Riwayat Rekam Medik</h4>
                    </div>-->
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

                                <?php
                            endif;
                            $error_msg = null;
                            ?>
<?php endif; ?>
                        <!-- end of error Message; -->
<!--                        <div id="detail_riwayat" class="alert alert-info" hidden="hidden">
                            <form id="FormHomePoliumum" method="post" action="<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0); ?>/updateDataKIA">
                                <input id="id_rrm" name="id_rrm" type="hidden">
                                <input id="ID_PASIEN" name="ID_PASIEN" type="hidden">
                                <input id="hidden_noantrian" name="hidden_noantrian" type="hidden">
                                <input id="UMUR_SAAT_INI" name="UMUR_SAAT_INI" type="hidden">
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tinggi">Tinggi Badan</label>
                                            <input required class="form-control" id="TINGGIBADAN_PASIEN" name="TINGGIBADAN_PASIEN" placeholder="dalam centimeter" type="number">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="berat">Berat Badan</label>
                                            <input required class="form-control" id="BERATBADAN_PASIEN" name="BERATBADAN_PASIEN" placeholder="dalam kilogram" type="number">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sistol">Tekanan Darah Atas</label>
                                            <input required class="form-control" id="SISTOL_PASIEN" name="SISTOL_PASIEN" placeholder="sistol" type="number">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="diastol">Tekanan Darah Bawah</label>
                                            <input required class="form-control" id="DIASTOL_PASIEN" name="DIASTOL_PASIEN" placeholder="diastol" type="number">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="suhu">Suhu Badan</label>
                                            <input required class="form-control" id="SUHU_BADAN" name="SUHU_BADAN" placeholder="dalam celcius" type="number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="keluhan">Anamnesa/Keluhan</label><br>
                                            <textarea required rows="1" style="height: 100px; resize: none" class="form-control" id="keluhan" name="keluhan" placeholder="Keluhan Pasien, pisahkan dengan koma. Contoh: mual, muntah"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kasus">Status Kasus</label><br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input required id="NAMA_STATUS_KASUS" name="NAMA_STATUS_KASUS" type="radio" value="BARU"> BARU
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input required id="NAMA_STATUS_KASUS" name="NAMA_STATUS_KASUS" type="radio" value="LAMA"> LAMA
                                                </div>
                                            </div>
                                        </div>
                                    </div>	
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rawat">Status Perawatan</label><br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input required id="rawat1" name="STAT_RAWAT_JALAN" type="radio" value="0"> Rawat Jalan
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input required id="rawat2" name="STAT_RAWAT_JALAN" type="radio" value="1"> Rawat Inap
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input required id="rawat3" name="STAT_RAWAT_JALAN" type="radio" value="2"> Dirujuk
                                                    <input style="display: none" class="form-control" placeholder="Tempat Rujukan" id="TEMPAT_RUJUKAN" name="TEMPAT_RUJUKAN" type="text" value="">									
                                                </div>
                                            </div>
                                        </div>
                                    </div>									
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="kasus">Sumber Pembayaran : &nbsp;</label><label id="sumberbayar"></label>
                                            <input type="hidden" name="pembayaranPasien" id="pembayaranPasien" value="" />
                                        </div>
                                    </div>					
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Diagnosa Utama (ICD X)</label><br>
                                            <div class="input-group">
                                                <input required id="queryicd" name="queryicd" class="form-control" placeholder="Masukkan kata pencarian utama" type="text">
                                                <span class="input-group-btn">									
                                                    <button style="" class="btn btn-primary" type="button" onclick="renderTable()">Cari Kode ICD X</button>
                                                     <a class="btn btn-two" type="button" onclick="getICD()">Go!</a> 
                                                </span>
                                            </div>
                                        </div>			
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <ul class="nav nav-pills">
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
                                        </ul>
                                        <span class="hide-on-print" id="pivot-detail"></span>
                                        <div style="" id="results"></div>
                                    </div>
                                    &nbsp;
                                </div>
                                <div class="row form-group">
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
                                <div class="row form-group">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="keluhan">Diagnosa Keterangan</label><br>
                                            <textarea required rows="1" style="height: 100px; resize:none;" class="form-control" id="diagnosa" name="diagnosa" placeholder="Keterangan Diagnosa Pasien"></textarea>
                                        </div>
                                    </div>							
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="layananKesehatan">Layanan Kesehatan</label><br>
                                            <div class="input-group">
                                                <select id="layananKesehatan" class="form-control" name="layananKesehatan">
                                                    <option value="">Pilih Layanan Kesehatan</option>
                                                    <?php foreach ($layanan as $row) : ?>
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
                                <div class="row form-group">
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
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Sedang Hamil</label>
                                        <select class="form-control" id="FLAG_HAMIL" name="FLAG_HAMIL" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Hamil ke-</label>
                                        <input class="form-control" type="number" name="HAMIL_KE" value="" placeholder="HAMIL_KE">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-8">
                                        <label>Penyakit Ibu Hamil</label>
                                        <textarea rows="1" style="height: 100px" class="form-control" id="PENYAKIT_BUMIL" name="PENYAKIT_BUMIL" placeholder="Keluhan Pasien, pisahkan dengan koma. Contoh: mual, muntah"></textarea>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Gagal Hamil</label>
                                        <select class="form-control" id="FLAG_GAGAL_HAMIL" name="FLAG_GAGAL_HAMIL" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Meniggal dalam Kandungan</label>
                                        <select class="form-control" id="MATI_DLM_KANDUNGAN" name="MATI_DLM_KANDUNGAN" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Lahir dengan Vakum</label>
                                        <select class="form-control" id="LAHIR_DGN_VAKUM" name="LAHIR_DGN_VAKUM" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Lahir dengan Infus Tranfusi</label>
                                        <select class="form-control" id="LAHIR_DGN_INFUS_TRANSFUSI" name="LAHIR_DGN_INFUS_TRANSFUSI" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Operasi Sesar</label>
                                        <select class="form-control" id="OP_SESAR" name="OP_SESAR" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Lahir dengan uri dirogoh</label>
                                        <select class="form-control" id="LAHIR_DGN_URI_DIROGOH" name="LAHIR_DGN_URI_DIROGOH" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Umur Kehamilan</label>
                                        <input class="form-control" type="text" name="UMUR_KEHAMILAN" value="" placeholder="UMUR_KEHAMILAN">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Ibu Hamil Bengkak</label>
                                        <select class="form-control" id="BUMIL_BENGKAK" name="BUMIL_BENGKAK" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Ibu Hamil Darah Tingi</label>
                                        <select class="form-control" id="BUMIL_DARAH_TINGGI" name="BUMIL_DARAH_TINGGI" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Kembar Lebih 2</label>
                                        <select class="form-control" id="FLAG_KEMBAR2_LEBIH" name="FLAG_KEMBAR2_LEBIH" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Kembar Air</label>
                                        <select class="form-control" id="FLAG_KEMBAR_AIR" name="FLAG_KEMBAR_AIR" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>KEHAMILAN_LEBIH_BULAN</label>
                                        <input class="form-control" type="number" name="KEHAMILAN_LEBIH_BULAN" value="" placeholder="KEHAMILAN_LEBIH_BULAN">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Letak Sungsang Lintang Kepala</label>
                                        <select class="form-control" id="LETAK_SUNGSANG" name="LETAK_SUNGSANG" onchange="">
                                            <option value="1" checked="true">Letak Kepala</option>
                                            <option value="2">Letak Sungsang</option>
                                            <option value="3">Letak Lintang</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Pendarahan Kehamilan Dalam</label>
                                        <select class="form-control" id="PENDARAHAN_KEHAMILAN_IN" name="PENDARAHAN_KEHAMILAN_IN" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Preeklampsia Berat</label>
                                        <select class="form-control" id="PREEKLAMPSIA_BERAT" name="PREEKLAMPSIA_BERAT" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Status Obstetri</label>
                                        <input class="form-control" type="text" name="STATUS_OBSTETRI" value="" placeholder="STATUS_OBSTETRI">
                                    </div>
                                    <div class="col-md-4">
                                        <label>TAKSIRAN_PERSALINAN</label>
                                        <input name="TAKSIRAN_PERSALINAN" class="form-control form-control-inline default-date-picker"  size="16" type="text" value="<?= date('m-d-Y') ?>" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>Tempat Lahir</label>
                                        <input class="form-control" type="text" name="TEMPAT_LAHIR" value="" placeholder="TEMPAT_LAHIR">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Hamil Kelainan</label>
                                        <select class="form-control" id="VK_HAMIL_KELAINAN" name="VK_HAMIL_KELAINAN" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Nifas Kelainan</label>
                                        <select class="form-control" id="VK_NIFAS_KELAINAN" name="VK_NIFAS_KELAINAN" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Lahir Kelainan</label>
                                        <select class="form-control" id="VK_LAHIR_KELAINAN" name="VK_LAHIR_KELAINAN" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Maternal Kelainan</label>
                                        <select class="form-control" id="VK_MATERNAL_RISTI" name="VK_MATERNAL_RISTI" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Neonatal Kelainan</label>
                                        <select class="form-control" id="VK_NEONATAL_RISTI" name="VK_NEONATAL_RISTI" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Terakhir Haid</label>
                                        <input name="TERKAHIR_HAID" class="form-control form-control-inline default-date-picker"  size="16" type="text" value="<?= date('m-d-Y') ?>" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Siklus Haid</label>
                                        <input class="form-control" type="text" name="SIKLUS_HAID" value="" placeholder="SIKLUS_HAID">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Imunisasi TT</label>
                                        <select class="form-control" id="FLAG_IMUNISASI_TT" name="FLAG_IMUNISASI_TT" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Tanggal Imunisasi TT</label>
                                        <input name="TANGGAL_IMUN_TT" class="form-control form-control-inline default-date-picker"  size="16" type="text" value="<?= date('m-d-Y') ?>" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Vitamin A Ibu</label>
                                        <select class="form-control" id="FLAG_VIT_A_IBU" name="FLAG_VIT_A_IBU" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Tanggal Vitamin A Ibu</label>
                                        <input name="TANGGAL_VIT_A_IBU" class="form-control form-control-inline default-date-picker"  size="16" type="text" value="<?= date('m-d-Y') ?>" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>Angka HB</label>
                                        <input class="form-control" type="number" name="ANGKA_HB" value="" placeholder="ANGKA_HB">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Angka LILA</label>
                                        <input class="form-control" type="number" name="ANGKA_LILA" value="" placeholder="ANGKA_LILA">
                                    </div>
                                    <div class="col-md-4">
                                        <label>KIE PPIA</label>
                                        <select class="form-control" id="FLAG_KIE_PPIA" name="FLAG_KIE_PPIA" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Kunjungan Ibu Hamil ke-</label>
                                        <input class="form-control" type="number" name="KUNJUNGAN_BUMIL_KE" value="" placeholder="KUNJUNGAN_BUMIL_KE">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>BCG</label>
                                        <select class="form-control" id="FLAG_BCG" name="FLAG_BCG" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Vitamin A Anak</label>
                                        <select class="form-control" id="FLAG_VIT_A_ANAK" name="FLAG_VIT_A_ANAK" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>HBO</label>
                                        <select class="form-control" id="FLAG_HBO" name="FLAG_HBO" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label>Polio</label>
                                        <select class="form-control" id="FLAG_POLIO" name="FLAG_POLIO" onchange="">
                                            <option value="1" checked="true">Pertama</option>
                                            <option value="2">Kedua</option>
                                            <option value="3">Ketiga</option>
                                            <option value="4">Keempat</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>DPT Combo</label>
                                        <select class="form-control" id="FLAG_DPT_COMBO" name="FLAG_DPT_COMBO" onchange="">
                                            <option value="1" checked="true">Pertama</option>
                                            <option value="2">Kedua</option>
                                            <option value="3">Ketiga</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Campak</label>
                                        <select class="form-control" id="FLAG_CAMPAK" name="FLAG_CAMPAK" onchange="">
                                            <option value="0" checked="true">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <br/>
                                        <input name="flagbutton" id="flagbutton" value="" type="hidden">
                                        <button onclick="CheckLaborat(1)" type="button" class="btn btn-primary">Simpan & Kembali ke Antrian Pasien</button>
                                        <button onclick="CheckLaborat(2)" type="button" class="btn btn-primary">Simpan & Buat Resep</button>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal2" type="button">Simpan & Arahkan ke Poli Lain</button>
                                        <button class="btn btn-primary " data-toggle="modal" data-target="#myModal" type="button">Arahkan ke Poli Lain</button>
                                        <input type="hidden" name="id_unit_tujuan" id="id_unit_tujuan"/>
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-4">
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal save riwayat and change unit -->
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
                        <select name="save_unit" id="save_unit" class="form-control">
                            <?php foreach ($unit as $r) { ?>
                                <option value="<?php echo $r['ID_UNIT'] ?>"><?php echo $r['NAMA_UNIT'] ?></option>
<?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button onclick="CheckLaborat2(3)" type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->

<!-- modal change unit -->
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
                        <select name="unit" id="unit" class="form-control">													
                            <?php foreach ($unit as $r) { ?>
                                <option value="<?php echo $r['ID_UNIT'] ?>"><?php echo $r['NAMA_UNIT'] ?></option>
<?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button onclick="CheckLaborat(4)" type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->

<script type="text/javascript">
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
        if ($("#queryicd").val() == "")
            return;

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
            url: '<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/getSearch'; ?>',
            data: kapsul,
            success: function(dataCheck) {
                jso = dataCheck;
                setupPivot({
                    json: jso,
                    fields: fields,
                    rowLabels: ["KODE ICD X", "ENGLISH NAME", "INDONESIAN NAME", "KELOLA"]
                            //rowLabels : ["ID OBAT","KODE OBAT","NAMA OBAT","SATUAN"]
                })
                $('.stop-propagation').click(function(event) {
                    event.stopPropagation();
                });
            },
            error: function(xhr, status, error) {
                alert('error');
            }
        });
    }
</script>

<script type="text/javascript">
    $('input:radio[name=NAMA_STATUS_KASUS]:nth(1)').attr('checked', true);
    $('input:radio[name=STAT_RAWAT_JALAN]:nth(0)').attr('checked', true);

    $('#rawat1').click(function() {
        $('#TEMPAT_RUJUKAN').attr("style", 'display:none');
    });
    $('#rawat2').click(function() {
        $('#TEMPAT_RUJUKAN').attr("style", 'display:none');
    });
    $('#rawat3').click(function() {
        $('#TEMPAT_RUJUKAN').attr("style", 'display:block');
    });

    function CheckLaborat(value) {
        $('#flagbutton').val(value);
        var str = $('#unit :selected').text();
        $('#id_unit_tujuan').val($('#unit :selected').val());
        if (str.toLowerCase().indexOf("laborat") >= 0) {
            id_rrm = $('#id_rrm').val();
            id_antrian = $('#hidden_noantrian').val();
            id_unit_tujuan = $('#id_unit_tujuan').val();
            window.location = "<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/toLaborat/' ?>" + id_rrm + "/" + id_antrian + "/" + id_unit_tujuan;
        }
        else {
            $('#FormHomePoliumum').submit();
        }
    }

    function CheckLaborat2(value) {
        $('#flagbutton').val(value);
        var str = $('#save_unit :selected').text();
        $('#id_unit_tujuan').val($('#save_unit :selected').val());
        if (str.toLowerCase().indexOf("laborat") >= 0) {
            id_rrm = $('#id_rrm').val();
            id_antrian = $('#hidden_noantrian').val();
            id_unit_tujuan = $('#id_unit_tujuan').val();
            window.location = "<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/toLaborat/' ?>" + id_rrm + "/" + id_antrian + "/" + id_unit_tujuan;
        }
        else {
            $('#FormHomePoliumum').submit();
        }
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
        if ($("#queryicd").val() == "")
            return;

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
            url: '<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0); ?>/getSearch',
            data: kapsul,
            success: function(dataCheck) {
//                 alert(dataCheck);
                jso = dataCheck;
                setupPivot({
                    json: jso,
                    fields: fields,
                    rowLabels: ["KODE ICD X", "ENGLISH NAME", "INDONESIAN NAME", "KELOLA"]
                            //rowLabels : ["ID OBAT","KODE OBAT","NAMA OBAT","SATUAN"]
                })
                $('.stop-propagation').click(function(event) {
                    event.stopPropagation();
                });
            }
//            ,error: function(xhr, ajaxOptions, thrownError) {
//                alert(xhr.status);
//                alert(thrownError);
//                alert(xhr.responseText);
//            }
        });
    }
    
    function getICD() {
        var value = $('#queryicd').val();

        $("#bodyICD").html('');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/showICD'; ?>",
            data: {query: value},
            success: function(data) {
                if (data) {
                    var dataObj = eval(data);
                    var content;
                    $.each(dataObj, function(index, value) {
                        content += '<tr><td>' + value.ID_ICD + '</td>';
                        content += '<td>' + value.INDONESIAN_NAME + '</td>';
                        var name = value.INDONESIAN_NAME.split(' ').join('+');
                        content += '<td><button type="button" class="btn btn-xs btn-success" name="' + name + '" id="' + value.ID_ICD + '" onclick="chooseICD(this.id, this.name)"><i class="fa fa-check"></i></button></td></tr>"';
                    });
                    $("#bodyICD").append(content);
                }
            },
            error: function(e) {
                alert(e.message);
            }
        });
    }

    function chooseICD(value, name) {
        var penyakit = name.split('+').join(' ');
        $('#bodyChoosedICD').append('<tr><td><input id="' + value + '" name="' + value + '" readonly class="form-control" type="text" value="' + penyakit + '"></td>&nbsp<td><button class="btn btn-warning" type="button">Hapus</button></td></tr>');
    }

    function ICDChoosed (value) {
	$.ajax({
		type: "POST",
		url: "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/showICDById'; ?>",
		data: {id : value},
		success: function(data){   	
			var parsedData = JSON.parse(data);
			
			$('#bodyChoosedICD').append('<tr id="'+value+'"><td><input id="icd-'+value+'" name="icd-'+value+'" readonly class="form-control" type="text" value="'+parsedData.INDONESIAN_NAME+'"></td><td><button onclick="removeSelectedICD('+value+')" class="btn btn-warning" type="button">Hapus</button></td></tr>');
		},
		error: function(e){
			alert(e.message);
        }
	});
    }

    function removeSelectedICD(value) {

        $('#bodyChoosedICD').find('#' + value + '').remove();
    }
</script>    



<script type="text/javascript">
    var fields_layanan = [
        {
            name: 'ID LAYANAN KES',
            type: 'string',
            filterable: true
        }, {
            name: 'NAMA LAYANAN KES',
            type: 'string',
            filterable: true
        }, {
            name: 'JASA SARANA KES',
            type: 'string',
            filterable: true
        }, {
            name: 'JASA LAYANAN KES',
            type: 'string',
            filterable: true
        }, {
            name: 'KETERANGAN LAYANAN KES',
            type: 'string',
            filterable: true
        },
    ]

    function renderTableLayanan()
    {
        var jso;

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0); ?>/showHealthServices',
            success: function(dataCheck) {
                // alert(dataCheck);

                jso = dataCheck;
                setupPivotLayanan({
                    json: jso,
                    fields: fields_layanan,
                    rowLabels: ["ID LAYANAN KES", "NAMA LAYANAN KES", "JASA SARANA KES", "JASA LAYANAN KES"]
                })
                $('.stop-propagation').click(function(event) {
                    event.stopPropagation();
                });
            }
//            ,error: function(xhr, status, error) {
//                var err = eval("(" + xhr.responseText + ")");
//                alert(err.Message);
//            }
        });
    }
    
    function LayananChoosed() {
        value = $('#layananKesehatan').val();
        if (value != "") {
            name = $('#layananKesehatan :selected').text();

            $('#bodyChoosedLayanan').append('<tr id="layanan-' + value + '"><td><input id="layanan-' + value + '" name="layanan-' + value + '" readonly class="form-control" type="text" value="' + name + '"></td><td><button onclick="removeSelectedLayanan(\'layanan-' + value + '\')" class="btn btn-warning" type="button">Hapus</button></td></tr>');
        }
    }

    function removeSelectedLayanan(value) {
        $('#bodyChoosedLayanan').find('#' + value + '').remove();
    }    
</script>   

<script>
    function getPatient(rrm, id_antrian) {
        $("#data_pas").hide();
        $("#detail_riwayat").hide();

        $('#tabelAntrian tbody tr').css("background-color", "transparent");
        $('#row' + id_antrian).css("background-color", "#e1f8ff");

        $("#id_rrm").val(rrm);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/getPatientData'; ?>",
            data: {id: rrm},
            success: function(data) {
                if (data) {
//                     alert (data);
                    dataObj = jQuery.parseJSON(data);
                    $(".goToBumil").attr("onclick", "window.location.href='<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/dataRiwayat/bumil/'; ?>" + id_antrian + "/" + dataObj.id_pasien + "'")
                    $(".goToVKKIA").attr("onclick", "window.location.href='<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/dataRiwayat/vkkia/'; ?>" + id_antrian + "/" + dataObj.id_pasien + "'")
                    $(".goToBalita").attr("onclick", "window.location.href='<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/dataRiwayat/balita/'; ?>" + id_antrian + "/" + dataObj.id_pasien + "'")
                    $(".goToKb").attr("onclick", "window.location.href='<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/dataRiwayat/kb/'; ?>" + id_antrian + "/" + dataObj.id_pasien + "'")
                    $("#detail_riwayat").show();
                    $("#norekammedik").val(dataObj.noid_pasien);
                    $("#ID_PASIEN").val(dataObj.id_pasien);
                    $("#namapasien").val(dataObj.nama_pasien);
                    $("#umurpasien").val(Math.floor(dataObj.umur / 12) + " Th");
                    $("#UMUR_SAAT_INI").val(dataObj.umur);
                    $("#jkpasien").val(dataObj.gender_pasien);
                    $("#alamatpasien").val(dataObj.alamat_pasien);
                    $("#kunjunganpasien").val(dataObj.WAKTU_ANTRIAN_UNIT);
                    $('#linknya').attr("href", "<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/patientMRH/'; ?>" + dataObj.id_rekammedik);
                    $("#hidden_noantrian").val(id_antrian);
                    $("#data_pas").show();
                    $("#pembayaranPasien").val(dataObj.ID_SUMBER);
                    $("#sumberbayar").text(dataObj.NAMA_SUMBER_PEMBAYARAN)
                }
            }
//            ,error: function(e) {
//                alert(e.message);
//            }
        });
    }
</script>