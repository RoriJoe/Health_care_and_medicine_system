<div class="container">
    <div class="row">
        <div class="col-md-12">
            <section class="slice bg-2 p-15">
                <h3>Kunjungan Pasien Poli KIA-VK KIA </h3>
            </section> &nbsp;
            &nbsp;
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Data Antrian Pasien</h3>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-body" >						
                                <div class="alert alert-info" id="data_pas" hidden="hidden"> 
                                    <h4>PROFIL PASIEN</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                        <label >No. Rekam Medik</label>
                                                        <input class="form-control" type="text" id="norekammedik" name="norekammedik" readonly="true">
                                                </div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                        <label >Nama Pasien</label>
                                                        <input class="form-control" type="text" id="NAMA_PASIEN" name="NAMA_PASIEN" readonly="true">
                                                </div>
                                        </div>
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                        <label >Jenis Kelamin</label>
                                                        <input class="form-control" type="text" id="GENDER_PASIEN" name="GENDER_PASIEN" readonly="true">
                                                </div>
                                        </div>
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                        <label >Umur Pasien</label>
                                                        <input class="form-control" type="text" name="umurpasien" id="umurpasien" readonly>
                                                </div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                        <label >Alamat Pasien</label>
                                                        <input class="form-control" type="text" id="ALAMAT_PASIEN" name="ALAMAT_PASIEN" readonly="true">
                                                </div>
                                        </div>
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                        <label >Kunjungan Terakhir</label>
                                                        <input class="form-control" id="kunjunganpasien" readonly>
                                                </div>							
                                        </div>                           
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form-body" >
                                        <div class="alert alert-info" id="tabelLab" hidden="hidden">         
                                                <h4>PEMERIKSAAN LAB</h4>
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
                    </div>
                    <div class="col-md-12 alert alert-info" id="detail_riwayat" hidden="hidden">
                        <form id="FormHomePoliumum" method="post" action="<?php echo base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/updateDataVKKIA'; ?>">
                            <input id="ID_SUMBER" name="ID_SUMBER" type="hidden" value="" />
                            <input id="id_rrm" name="id_rrm" type="hidden" value="">
                            <input id="ID_PASIEN" name="ID_PASIEN" type="hidden" value="">
                            <input id="hidden_noantrian" name="hidden_noantrian" type="hidden" value="">
                            <input id="UMUR_SAAT_INI" name="UMUR_SAAT_INI" type="hidden" >
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tinggi">Cuma Kontrol</label>
                                    <select class="form-control" id="CUMA_KONTROL" name="CUMA_KONTROL">
                                        <option value="0" checked="true">Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tinggi">Tinggi Badan</label>
                                    <input required min="0" class="form-control" id="TINGGIBADAN_PASIEN" name="TINGGIBADAN_PASIEN" placeholder="dalam centimeter" type="number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="berat">Berat Badan</label>
                                    <input required min="0" class="form-control" id="BERATBADAN_PASIEN" name="BERATBADAN_PASIEN" placeholder="dalam kilogram" type="number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sistol">Tekanan Darah Atas</label>
                                    <input required min="0" class="form-control" id="SISTOL_PASIEN" name="SISTOL_PASIEN" placeholder="sistol" type="number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="diastol">Tekanan Darah Bawah</label>
                                    <input required min="0" class="form-control" id="DIASTOL_PASIEN" name="DIASTOL_PASIEN" placeholder="diastol" type="number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="suhu">Suhu Badan</label>
                                    <input required min="0" class="form-control" id="SUHU_BADAN" name="SUHU_BADAN" placeholder="dalam celcius" type="number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jantung">Detak Jantung</label>
                                    <input required min="0" class="form-control" id="DETAK_JANTUNG" name="DETAK_JANTUNG" placeholder="Detak Jantung" type="number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="napas">Napas Per Menit</label>
                                    <input required min="0" class="form-control" id="NAPAS_PER_MENIT" name="NAPAS_PER_MENIT" placeholder="Napas Per Menit" type="number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keluhan">Anamnesa/Keluhan</label><br>
                                    <textarea rows="1" style="height: 100px; resize: none" class="form-control" id="keluhan" name="keluhan" placeholder="Keluhan Pasien, pisahkan dengan koma. Contoh: mual, muntah"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Diagnosa Utama (ICD X)</label><br>
                                    <div class="input-group">
                                        <input required id="queryicd" name="queryicd" class="form-control" placeholder="Masukkan kata pencarian utama" type="text">
                                        <span class="input-group-btn">									
                                            <button style="" class="btn btn-primary" type="button" onclick="renderTable()">Cari Kode ICD X</button>
                                            <!-- <a class="btn btn-two" type="button" onclick="getICD()">Go!</a> -->
                                        </span>
                                    </div>
                                </div>			
                            </div>
                            <div class="col-md-12">
                                <span class="hide-on-print" id="pivot-detail"></span>
                                <div style="" id="results"></div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Daftar ICD X yang dipilih</label><br>
                                    <table style="width: 100%; " class="table-responsive">
                                        <tbody id="bodyChoosedICD">

                                        </tbody>
                                    </table>
                                </div>			
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="keluhan">Diagnosa Keterangan</label><br>
                                    <textarea rows="1" style="height: 100px; resize:none;" class="form-control" id="diagnosa" name="diagnosa" placeholder="Keterangan Diagnosa Pasien"></textarea>
                                </div>
                            </div>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Daftar Layanan Kesehatan yang dipilih</label><br>
                                    <table style="width: 100%; " class="table-responsive">
                                        <tbody id="bodyChoosedLayanan">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
                            <div class="col-md-12"><hr/></div>
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
                            <div class="col-md-4">
                                <label>Ibu Hamil Darah Tingi</label>
                                <select class="form-control" id="BUMIL_DARAH_TINGGI" name="BUMIL_DARAH_TINGGI" onchange="">
                                    <option value="0" checked="true">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Jumlah Anak Lahir</label>
                                <input min="0" max="5" class="form-control" type="number" name="JML_ANAK_LAHIR" placeholder="Jumlah Anak yg Lahir">
                            </div>
                            <div class="col-md-4">
                                <label>Kembar Lebih 2</label>
                                <select class="form-control" id="FLAG_KEMBAR2_LEBIH" name="FLAG_KEMBAR2_LEBIH" onchange="">
                                    <option value="0" checked="true">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Jenis Kelamin Bayi Lahir 1</label>
                                <select class="form-control" id="JK_BAYI_LAHIR" name="JK_BAYI_LAHIR" onchange="">
                                    <option value="l" checked="true">Laki-laki</option>
                                    <option value="p">Perempuan</option>
                                </select>
                            </div>
                            <div class="bayi_lahir_lebih_1" style="display:none">
                                <div class="col-md-4">
                                    <label>Jenis Kelamin Bayi Lahir 2</label>
                                    <select class="form-control" id="JK_BAYI_LAHIR2" name="JK_BAYI_LAHIR2">
                                        <option value="" checked="true">Pilih Jenis Kelamin Anak</option>
                                        <option value="l">Laki-laki</option>
                                        <option value="p">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Jenis Kelamin Bayi Lahir 3</label>
                                    <select class="form-control" id="JK_BAYI_LAHIR3" name="JK_BAYI_LAHIR3">
                                        <option value="" checked="true">Pilih Jenis Kelamin Anak</option>
                                        <option value="l">Laki-laki</option>
                                        <option value="p">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Jenis Kelamin Bayi Lahir 4</label>
                                    <select class="form-control" id="JK_BAYI_LAHIR4" name="JK_BAYI_LAHIR4">
                                        <option value="" checked="true">Pilih Jenis Kelamin Anak</option>
                                        <option value="l">Laki-laki</option>
                                        <option value="p">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Jenis Kelamin Bayi Lahir 5</label>
                                    <select class="form-control" id="JK_BAYI_LAHIR5" name="JK_BAYI_LAHIR5">
                                        <option value="" checked="true">Pilih Jenis Kelamin Anak</option>
                                        <option value="l">Laki-laki</option>
                                        <option value="p">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Kehamilan Lebih Bulan</label>
                                <input min="0" class="form-control" type="number" name="KEHAMILAN_LEBIH_BULAN" value="" placeholder="Kehamilan Lebih Bulan">
                            </div>
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
                            <div class="col-md-12"><hr/></div>
                            <div class="col-md-8 alert alert-warning">
                                <h3>18 Penapisan</h3>
                                <?php foreach ($skoring as $key=>$value): ?>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <?php $text= $value['NAMA_SKOR'] ?>
                                        <input class="skor_data_master data_kia_skor_<?= $key ?>" type="checkbox" name="data_kia_skor_<?= $key ?>" value="<?= '1-'.$value['ID_DATA_MASTER'] ?>"><?php echo '<label>'.$text.'</label>' ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <label>Bila didapatkan 1 atau lebih tanda di atas Persalinan harus di Rumah Sakit</label>
                            </div>
                            <div class="col-md-8 alert alert-warning">
                                <div class="form-group">
                                    <label class="skor_akhir">Jumlah Skor: 0</label><br>
                                    <label class="rujukan">Rujukan: Rujukan: Rumah / Polindes/ Puskesmas</label><br>
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
                            <div class="col-md-12"><hr/></div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input name="flagbutton" id="flagbutton" value="" type="hidden">
                                    <button onclick="CheckLaborat(1)" type="button" class="btn btn-primary">Simpan & Kembali ke Antrian Pasien</button>
                                    <button onclick="CheckLaborat(2)" type="button" class="btn btn-primary">Simpan & Buat Resep</button><br><br>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal2" type="button">Simpan & Arahkan ke Poli Lain</button>
                                    <button class="btn btn-primary " data-toggle="modal" data-target="#myModal" type="button">Arahkan ke Poli Lain</button>
                                </div>
                            </div>
                            <input type="hidden" name="id_unit_tujuan" id="id_unit_tujuan"/>
                            <input type="text" name="tanggalAntrian" id="tanggalAntrian"/>
                            <input type="text" name="waktuAntrian" id="waktuAntrian"/>
                        </form>
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
                            <?php foreach ($unit as $r) { 
                                $pos = strpos($r['NAMA_UNIT'], 'KIA');
                                if($pos !== false){ ?>
                                    <option value="<?= $r['ID_UNIT'] . '_balita' ?>">Poli KIA-Anak Balita</option>
                                    <option value="<?= $r['ID_UNIT'] . '_kia' ?>">Poli KIA-Ibu Hamil</option>
                                    <option value="<?= $r['ID_UNIT'] . '_vkkia' ?>">Poli KIA-VK KIA</option>
                                    <option value="<?= $r['ID_UNIT'] . '_kb' ?>">Poli KIA-KB</option>
                                <?php } else { ?>
                                    <option value="<?php echo $r['ID_UNIT'] ?>"><?php echo $r['NAMA_UNIT'] ?></option>
                                <?php }
                                } ?>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <label>Tanggal Kunjungan</label>
                        <input class="form-control datepicker" id="tanggalAntrianTemp" name="tanggalAntrianTemp" value="<?= date('d:m:Y') ?>" placeholder="Masukkan Tanggal Antrian">
                    </div>
                    <div class="col-lg-6">
                        <label>Waktu Antrian</label>
                        <input required class="form-control" id="waktuAntrianTemp" name="waktuAntrianTemp" type="text" value="<?php
                        $time = date('H:i:s');
                        echo $time
                        ?>" placeholder="Format 24 Jam: Jam:Menit:detik , contoh: 21:15:55">
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
                        <input type="hidden" name="pembayaranPasien" id="pembayaranPasien" value="" />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <select name="unit" id="unit" class="form-control">													
                            <?php foreach ($unit as $r) { 
                                $pos = strpos($r['NAMA_UNIT'], 'KIA');
                                if($pos !== false){ ?>
                                    <option value="<?= $r['ID_UNIT'] . '_balita' ?>">Poli KIA-Anak Balita</option>
                                    <option value="<?= $r['ID_UNIT'] . '_kia' ?>">Poli KIA-Ibu Hamil</option>
                                    <option value="<?= $r['ID_UNIT'] . '_vkkia' ?>">Poli KIA-VK KIA</option>
                                    <option value="<?= $r['ID_UNIT'] . '_kb' ?>">Poli KIA-KB</option>
                                <?php } else { ?>
                                    <option value="<?php echo $r['ID_UNIT'] ?>"><?php echo $r['NAMA_UNIT'] ?></option>
                                <?php }
                                } ?>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6">
                        <label>Tanggal Kunjungan</label>
                        <input class="form-control datepicker" id="tanggalAntrianTemp2" name="tanggalAntrianTemp2" value="<?= date('d:m:Y') ?>" placeholder="Masukkan Tanggal Antrian">
                    </div>
                    <div class="col-lg-6">
                        <label>Waktu Antrian</label>
                        <input required class="form-control" id="waktuAntrianTemp2" name="waktuAntrianTemp2" type="text" value="<?php
                        $time = date('H:i:s');
                        echo $time
                        ?>" placeholder="Format 24 Jam: Jam:Menit:detik , contoh: 21:15:55">
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

<style>
    .datepicker {
        z-index: 100000;
    }
</style>
<script>
    $(function () {
        $radios.filter('[value=0]').prop('checked', true);
        $('.skor_data_master').attr('checked', false); // Unchecks it
        $( ".datepicker" ).datepicker({
                format: 'dd-mm-yyyy',
        });
    });
    
    $('#FLAG_KEMBAR2_LEBIH').change(function() {
        var val= $( "#FLAG_KEMBAR2_LEBIH option:selected" ).val();
        if(val>0){
            $('.bayi_lahir_lebih_1').attr("style",'display:block');
        }
        else {
            $('.bayi_lahir_lebih_1').attr("style",'display:none');
        }
    });
            
    var size_skor_kia= <?php echo sizeof($skoring) ?>;
    var $radios = $('input:radio[name=STAT_RAWAT_JALAN]');
    $('.skor_data_master').click(function() {
        var jml_skor= 0;
        for(var i=0; i<size_skor_kia; i++){
            $checkBoxVal= $('.data_kia_skor_'+i).val().split("-");
            if($('.skor_data_master')[i].checked){
                jml_skor= Number(jml_skor) + Number($checkBoxVal[0]);
            }
        }
        $('.skor_akhir').text('Jumlah Skor: '+jml_skor);
        if(jml_skor>=1){
            $('.rujukan').text('Rujukan: Rumah Sakit');
            $radios.filter('[value=2]').prop('checked', true);
            $('#TEMPAT_RUJUKAN').attr("style",'display:block');
        }
    })
    
    $('input:radio[name=NAMA_STATUS_KASUS]:nth(1)').attr('checked',true);
    $('input:radio[name=STAT_RAWAT_JALAN]:nth(0)').attr('checked',true);
    
    $('#rawat1').click(function() {
        $('#TEMPAT_RUJUKAN').attr("style",'display:none');
    });
    $('#rawat2').click(function() {
        $('#TEMPAT_RUJUKAN').attr("style",'display:none');
    });
    $('#rawat3').click(function() {
        $('#TEMPAT_RUJUKAN').attr("style",'display:block');
    });
    
    function CheckLaborat (value) {
	$('#flagbutton').val(value);
	var str = $('#unit :selected').text();
        $('#id_unit_tujuan').val($('#unit :selected').val());
        $('#tanggalAntrian').val($('#tanggalAntrianTemp2 :selected').val());
        $('#waktuAntrian').val($('#waktuAntrianTemp2 :selected').val());
	if (str.toLowerCase().indexOf("laborat") >= 0 ) {
		id_rrm = $('#id_rrm').val();
		id_antrian = $('#hidden_noantrian').val();
		id_unit_tujuan = $('#id_unit_tujuan').val();
		window.location = "<?php echo base_url() .$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/toLaborat/' ?>" + id_rrm+"/"+id_antrian+"/"+id_unit_tujuan;
	}
	else {
		$('#FormHomePoliumum').submit();
	}
    }
    
    function CheckLaborat2 (value) {
	$('#flagbutton').val(value);
	var str = $('#save_unit :selected').text();
        $('#id_unit_tujuan').val($('#save_unit :selected').val());
        $('#tanggalAntrian').val($('#tanggalAntrianTemp :selected').val());
        $('#waktuAntrian').val($('#waktuAntrianTemp :selected').val());
	if (str.toLowerCase().indexOf("laborat") >= 0 ) {
		id_rrm = $('#id_rrm').val();
		id_antrian = $('#hidden_noantrian').val();
		id_unit_tujuan = $('#id_unit_tujuan').val();
		window.location = "<?php echo base_url() .$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/toLaborat/' ?>" + id_rrm+"/"+id_antrian+"/"+id_unit_tujuan;
	}
	else {
		$('#FormHomePoliumum').submit();
	}
    }
</script>

<script>
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

                    $('#bodyChoosedICD').append('<tr id="'+value+'"><td><input id="icd-'+value+'" name="icd-'+value+'" readonly class="form-control" type="text" value="'+parsedData.INDONESIAN_NAME+'"></td><td><button onclick="removeSelectedICD('+value+')" class="btn btn-warning" type="button">Hapus</button></td><td><strong>Status Kasus :</strong></td><td><input id="kasus-'+value+'" name="kasus-'+value+'" type="radio" value="BARU">Baru</td><td><input id="kasus-'+value+'" name="kasus-'+value+'" type="radio" value="LAMA">Lama</td></tr>');
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

<script>
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
</script>

<script>
    function getPatient(rrm, id_antrian) {
        $("#data_pas").hide();
        $("#detail_riwayat").hide();

//        $('#tabelAntrian tbody tr').css("background-color", "transparent");
//        $('#row' + id_antrian).css("background-color", "#e1f8ff");

        $("#id_rrm").val(rrm);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/getPatientData'; ?>",
            data: {id: rrm},
            success: function(data) {
                if (data) {
//                     alert (data);
                    dataObj = jQuery.parseJSON(data);
                    $("#detail_riwayat").show();
                    $("#norekammedik").val(dataObj.noid_pasien);
                    $("#ID_PASIEN").val(dataObj.id_pasien);
                    $("#NAMA_PASIEN").val(dataObj.nama_pasien);
                    $("#umurpasien").val(Math.floor(dataObj.umur / 12) + " Th");
                    $("#UMUR_SAAT_INI").val(dataObj.umur);
                    $("#GENDER_PASIEN").val(dataObj.gender_pasien);
                    $("#ALAMAT_PASIEN").val(dataObj.alamat_pasien);
                    $("#kunjunganpasien").val(dataObj.WAKTU_ANTRIAN_UNIT);
                    $('#linknya').attr("href", "<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . '/patientMRH/'; ?>" + dataObj.id_rekammedik);
                    $("#hidden_noantrian").val(id_antrian);
                    $("#data_pas").show();
                    $("#ID_SUMBER").val(dataObj.ID_SUMBER);
                    $("#sumberbayar").text(dataObj.NAMA_SUMBER_PEMBAYARAN);
                    getLabResult(rrm);
                }
            }
//            ,error: function(e) {
//                alert(e.message);
//            }
        });
    }
    
    function getLabResult(rrm) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/getLabResult'; ?>",
            data: {id: rrm},
            success: function(data) {
//                alert(data);
                if (data) {
                    var dataObj = eval(data);
                    $('#bodyHasilLab').html('');
                    var content = '';
                    $.each(dataObj, function(index, value) {
                        hasiltest = ifNull(value.HASIL_TES_LAB);
                        tanggaltest = ifNull(value.TANGGAL_TES_LAB);
                        content += '<tr><td>' + value.NAMA_PEM_LABORAT + '</td><td>' + hasiltest + '</td><td>' + tanggaltest + '</td></tr>';
                    });
                    $('#bodyHasilLab').append(content);
                }
                else {
                    $('#bodyHasilLab').html('');
                    var content = '<tr><td colspan=3><center>Kosong<center></td></tr>';
                    $('#bodyHasilLab').append(content);
                }
                $('#tabelLab').show();
            }
//            ,error: function(e) {
//                alert('Error!');
//            }
        });
    }
    
    function ifNull(value) {
        if (!value) {
            return '-';
        }
        else
            return value;
    }
	
	function removeAntrian (rrm, id_antrian) {
		if (confirm("Apakah Anda yakin menghapus antrian ini?") == true ){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/removeDataAntrian'; ?>",
				data: {id_rrm : rrm, id_antrian : id_antrian},
				success: function(data){
					if (data.length > 0) {
						window.location = "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4);?>";
					}
				},
				error: function(e){
				}
			});
		}
	}	
</script>