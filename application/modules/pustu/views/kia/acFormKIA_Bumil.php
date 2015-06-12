<div class="container">
    <div class="row">
        <div class="col-md-12">
            <section class="slice bg-2 p-15">
                <h3>Kunjungan Pasien Poli KIA-Ibu Hamil </h3>
            </section> &nbsp;
            &nbsp;
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Data Antrian Pasien</h3>
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
                                                    <td><button type="button" class="btn btn-xs btn-danger" onclick="removeAntrian(<?php echo $row['id_riwayat_rm']; ?>,<?php echo $row['id_antrian_unit']; ?>)"><i class="fa fa-cut"></i></button></td>
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
                    <div class="col-md-12 alert alert-warning" id="data_pas" hidden="hidden">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >No. Rekam Medik</label>
                                <input class="form-control" type="text" id="norekammedik" name="norekammedik" readonly="true">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Nama Pasien</label>
                                <input class="form-control" type="text" id="NAMA_PASIEN" name="NAMA_PASIEN" readonly="true">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label >Jenis Kelamin</label>
                                <input class="form-control" type="text" id="GENDER_PASIEN" name="GENDER_PASIEN" readonly="true">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label >Umur Pasien</label>
                                <input class="form-control" type="text" name="umurpasien" id="umurpasien" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Alamat Pasien</label>
                                <input class="form-control" type="text" id="ALAMAT_PASIEN" name="ALAMAT_PASIEN" readonly="true">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Kunjungan Terakhir</label>
                                <input class="form-control" id="kunjunganpasien" readonly>
                            </div>							
                        </div>
                    </div>
                    <div class="col-md-12 alert alert-info" id="detail_riwayat" hidden="hidden">
                        <form id="FormHomePoliumum" method="post" action="<?php echo base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/updateDataBumil'; ?>">
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
                                        </span>
                                    </div>
                                </div>			
                            </div>
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
                                <label>Kunjungan Ibu Hamil ke-</label>
                                <input min="0" class="form-control" type="number" name="KUNJUNGAN_BUMIL_KE" value="" placeholder="Kunjungan Ibu Hamil ke-">
                            </div>
                            <div class="col-md-4">
                                <label>Sedang Hamil</label>
                                <select class="form-control" id="FLAG_HAMIL" name="FLAG_HAMIL" onchange="">
                                    <option value="0" checked="true">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Hamil ke-</label>
                                <input min="0" class="form-control" type="number" name="HAMIL_KE" value="" placeholder="Hamil ke-">
                            </div>
                            <div class="col-md-8">
                                <label>Penyakit Ibu Hamil</label>
                                <textarea rows="1" style="height: 100px" class="form-control" id="PENYAKIT_BUMIL" name="PENYAKIT_BUMIL" placeholder="Penyakit ibu hamil"></textarea>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4">
                                <label>Gagal Hamil</label>
                                <select class="form-control" id="FLAG_GAGAL_HAMIL" name="FLAG_GAGAL_HAMIL" onchange="">
                                    <option value="0" checked="true">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Ibu Hamil Bengkak</label>
                                <select class="form-control" id="BUMIL_BENGKAK" name="BUMIL_BENGKAK" onchange="">
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
                                <label>Letak Sungsang Lintang Kepala</label>
                                <select class="form-control" id="LETAK_SUNGSANG_LINTANG_KEPALA" name="LETAK_SUNGSANG_LINTANG_KEPALA" onchange="">
                                    <option value="1" checked="true">Letak Kepala</option>
                                    <option value="2">Letak Sungsang</option>
                                    <option value="3">Letak Lintang</option>
                                    <option value="">Belum Dapat Ditentukan</option>
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
                            <div class="col-md-4">
                                <label>Siklus Haid</label>
                                <input class="form-control" type="text" name="SIKLUS_HAID" value="" placeholder="Siklus Haid">
                            </div>
                            <div class="col-md-4">
                                <label>Status Obstetri</label>
                                <input class="form-control" type="text" name="STATUS_OBSTETRI" value="" placeholder="STATUS OBSTETRI">
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4">
                                <label>Terakhir Haid</label>
                                <input required name="TERKAHIR_HAID" id="hpht" class="datepicker form-control form-control-inline default-date-picker"  size="16" type="text" value="<?= date('d-m-Y') ?>" />
                            </div>
                            <div class="col-md-4">
                                <label> </label>
                                <input type="button" onclick="generateTafsiran()" class="btn btn-danger form-control" value="Buat Tafsiran Persalinan"/>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4 generate" style="display: none">
                                <label>Usia Kehamilan (Minggu)</label>
                                <input required class="form-control" id="umur_kehamilan" type="text" name="UMUR_KEHAMILAN" value="" placeholder="UMUR_KEHAMILAN">
                            </div>
                            <div class="col-md-4 generate" style="display: none">
                                <label>Hasil Tafsiran Persalinan</label>
                                <input required name="TAKSIRAN_PERSALINAN" id="tafsiran" class="datepicker form-control form-control-inline default-date-picker"  size="16" type="text" value="" />
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4">
                                <label>Imunisasi TT</label>
                                <select class="form-control" id="FLAG_IMUNISASI_TT" name="FLAG_IMUNISASI_TT" onchange="">
                                    <option value="0" checked="true">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Tanggal Imunisasi TT</label>
                                <input name="TANGGAL_IMUN_TT" class="datepicker form-control form-control-inline default-date-picker"  size="16" type="text" value="<?= date('d-m-Y') ?>" />
                            </div>
                            <div class="col-md-12"></div>
                            <div class="form-group">
                                <div class="col-md-3 IMUNISASI_TT" style="display: none">
                                    <input type="checkbox" name="IMUNISASI_T0" value="1">Imunisasi T0
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="RIWAYAT_IMUNISASI_T0" value="1">Riwayat Imunisasi T0
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="form-group">
                                <div class="col-md-3 IMUNISASI_TT" style="display: none">
                                    <input type="checkbox" name="IMUNISASI_T1" value="1">Imunisasi T1
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="RIWAYAT_IMUNISASI_T1" value="1">Riwayat Imunisasi T1
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="form-group">
                                <div class="col-md-3 IMUNISASI_TT" style="display: none">
                                    <input type="checkbox" name="IMUNISASI_T2" value="1">Imunisasi T2
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="RIWAYAT_IMUNISASI_T2" value="1">Riwayat Imunisasi T2
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="form-group">
                                <div class="col-md-3 IMUNISASI_TT" style="display: none">
                                    <input type="checkbox" name="IMUNISASI_T3" value="1">Imunisasi T3
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="RIWAYAT_IMUNISASI_T3" value="1">Riwayat Imunisasi T3
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="form-group">
                                <div class="col-md-3 IMUNISASI_TT" style="display: none">
                                    <input type="checkbox" name="IMUNISASI_T4" value="1">Imunisasi T4
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="RIWAYAT_IMUNISASI_T4" value="1">Riwayat Imunisasi T4
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="form-group">
                                <div class="col-md-3 IMUNISASI_TT" style="display: none">
                                    <input type="checkbox" name="IMUNISASI_T5" value="1">Imunisasi T5
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="RIWAYAT_IMUNISASI_T5" value="1">Riwayat Imunisasi T5
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4">
                                <label>Vitamin A Ibu</label>
                                <select class="form-control" id="FLAG_VIT_A_IBU" name="FLAG_VIT_A_IBU" onchange="">
                                    <option value="0" checked="true">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Tanggal Vitamin A Ibu</label>
                                <input name="TANGGAL_VIT_A_IBU" class="datepicker form-control form-control-inline default-date-picker"  size="16" type="text" value="<?= date('d-m-Y') ?>" />
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4">
                                <label>Angka HB</label>
                                <input min="0" class="form-control" type="number" name="ANGKA_HB" value="" placeholder="ANGKA_HB">
                            </div>
                            <div class="col-md-4">
                                <label>Angka LILA</label>
                                <input min="0" class="form-control" type="number" name="ANGKA_LILA" value="" placeholder="ANGKA_LILA">
                            </div>
                            <div class="col-md-4">
                                <label>KIE PPIA</label>
                                <select class="form-control" id="FLAG_KIE_PPIA" name="FLAG_KIE_PPIA" onchange="">
                                    <option value="0" checked="true">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div class="col-md-12"><hr/></div>
                            <div class="col-md-8 alert alert-warning">
                                <h3>SKOR POEDJI ROCHJATI</h3>
                                <label>Skor Awal Ibu Hamil: 2</label>
                                <?php foreach ($skoring as $key=>$value): ?>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <?php $text= $value['NAMA_SKOR'].' (Skor:'.$value['SKOR'].')' ?>
                                        <input class="skor_data_master data_kia_skor_<?= $key ?>" type="checkbox" name="data_kia_skor_<?= $key ?>" value="<?= $value['SKOR'].'-'.$value['ID_DATA_MASTER'] ?>"><?php if($value['SKOR']>=8) echo '<label>'.$text.'</label>'; else echo $text; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="col-md-8 alert alert-warning">
                                <div class="form-group">
                                    <label class="skor_akhir">Jumlah Skor: 2</label><br>
                                    <label class="rujukan">Rujukan: Rujukan: Rumah / Polindes</label><br>
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
                                    <button onclick="CheckLaborat(2)" type="button" class="btn btn-primary">Simpan & Buat Resep</button>
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
                            <option value="<?= $idUnit . '_pu' ?>">Poli Umum</option>
                            <option value="<?= $idUnit . '_kia' ?>">Poli KIA-Ibu Hamil</option>
                            <option value="<?= $idUnit . '_vkkia' ?>">Poli KIA-VK KIA</option>
                            <option value="<?= $idUnit . '_balita' ?>">Poli KIA-Anak Balita</option>
                            <option value="<?= $idUnit . '_kb' ?>">Poli KIA-KB</option>	
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
                            <option value="<?= $idUnit . '_pu' ?>">Poli Umum</option>
                            <option value="<?= $idUnit . '_kia' ?>">Poli KIA-Ibu Hamil</option>
                            <option value="<?= $idUnit . '_vkkia' ?>">Poli KIA-VK KIA</option>
                            <option value="<?= $idUnit . '_balita' ?>">Poli KIA-Anak Balita</option>
                            <option value="<?= $idUnit . '_kb' ?>">Poli KIA-KB</option>	
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
    
    var size_skor_kia= <?php echo sizeof($skoring) ?>;
    var $radios = $('input:radio[name=STAT_RAWAT_JALAN]');
    $('.skor_data_master').click(function() {
        var jml_skor= 2;
        for(var i=0; i<size_skor_kia; i++){
            $checkBoxVal= $('.data_kia_skor_'+i).val().split("-");
            if($('.skor_data_master')[i].checked){
                jml_skor= Number(jml_skor) + Number($checkBoxVal[0]);
            }
        }
        $('.skor_akhir').text('Jumlah Skor: '+jml_skor);
        if(jml_skor<=2){
            $('.rujukan').text('Rujukan: Rumah / Polindes');
            $radios.filter('[value=0]').prop('checked', true);
            $('#TEMPAT_RUJUKAN').attr("style",'display:none');
        }
        else if(jml_skor>=6 && jml_skor<=10){
            $('.rujukan').text('Rujukan: Polindes / Puskesmas / Rumah Sakit');
            $radios.filter('[value=2]').prop('checked', true);
            $('#TEMPAT_RUJUKAN').attr("style",'display:block');
        }
        else if(jml_skor>=12){
            $('.rujukan').text('Rujukan: Rumah Sakit');
            $radios.filter('[value=2]').prop('checked', true);
            $('#TEMPAT_RUJUKAN').attr("style",'display:block');
        }
    })
    
    $("#FLAG_IMUNISASI_TT").change(function() {
        var flag_imun= $("#FLAG_IMUNISASI_TT option:selected" ).val();
        if(flag_imun==1){
            $(".IMUNISASI_TT").css("display", "block");
        }
        else {
            $(".IMUNISASI_TT").css("display", "none");
        }
    });
    
    var tglRiwayatRM= '';
    function generateTafsiran(){
        $( ".generate" ).css("display", "block");
        var tglRM= new Date(change(tglRiwayatRM, 1, 2, 3)); //set to type date
        tglRM= setTimeZone(tglRM);  //set timezone
        var hpht= new Date(change($("#hpht").val(), 3, 2, 1));  //set to type date
        hpht= setTimeZone(hpht);    //set timezone
        var usia_kehamilan= Math.abs(tglRM - hpht);
        usia_kehamilan= Math.floor(usia_kehamilan/1000);    //convert to seconds
        usia_kehamilan= Math.floor(usia_kehamilan/86400);   //convert to day
        usia_kehamilan= Math.floor(usia_kehamilan/7);       //convert to week
        $("#umur_kehamilan").val(usia_kehamilan);
        var tafsiranKelahiran= new Date(change($("#hpht").val(), 3, 2, 1)); //set to type date
        tafsiranKelahiran= setTimeZone(tafsiranKelahiran);  //set timezone
        tafsiranKelahiran.setDate(tafsiranKelahiran.getDate() + 7);     //date+7
        tafsiranKelahiran.setMonth(tafsiranKelahiran.getMonth() - 3);    //date-3
        tafsiranKelahiran.setFullYear(tafsiranKelahiran.getFullYear() + 1); //year+1
        var stringTafsiranD= tafsiranKelahiran.getDate();
        if(stringTafsiranD<10) stringTafsiranD="0"+stringTafsiranD; //if date<10
        var stringTafsiranM= tafsiranKelahiran.getMonth()+1;
        if(stringTafsiranM<10) stringTafsiranM="0"+stringTafsiranM; //if month<10
        var stringTafsiranY= tafsiranKelahiran.getFullYear();
        $("#tafsiran").val(stringTafsiranD+"-"+stringTafsiranM+"-"+stringTafsiranY);
    }
    
    function change(time, first, second, third){
        var r = time.match(/^\s*([0-9]+)\s*-\s*([0-9]+)\s*-\s*([0-9]+)(.*)$/);
        return r[first]+"-"+r[second]+"-"+r[third];
    }
    
    function setTimeZone(targetTime){
        var timeZone = +7.00; 
        //get the timezone offset from local time in minutes
        var tzDifference = timeZone * 60 + targetTime.getTimezoneOffset();
        //convert the offset to milliseconds, add to targetTime, and make a new Date
        var offsetTime = new Date(targetTime.getTime() + tzDifference * 60 * 1000);
        return offsetTime;
    }
</script>

<script>
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
//                    var tmp= change(dataObj.TANGGAL_RIWAYAT_RM);
                    tglRiwayatRM= dataObj.TANGGAL_RIWAYAT_RM;
                }
            }
//            ,error: function(e) {
//                alert(e.message);
//            }
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
                                window.location = "<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4);?>";
                        }
                },
                error: function(e){
                }
            });
        }	
    }
</script>