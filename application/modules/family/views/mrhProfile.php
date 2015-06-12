<div class="container">
    <div class="row">
        <div class="col-md-12">
            <section class="slice bg-2 p-15">
                <h3>Profil Kunjungan Pasien <?php if (isset($profil)) : echo '- ' . $profil[0]['NAMA_PASIEN']; endif;?></h3>
            </section>
            <div class="col-md-6">
                <h3>Profil Pasien</h3>
                <table class="table table-bordered table-striped table-comparison table-responsive">
                    <tbody>  
                        <?php if (isset($profil)) : ?>
                                <?php foreach ($profil[0] as $key => $value) : 
                                    if(!empty($value)):?>
                                <tr>
                                    <?php if ($key == "ID_SUAMI") $key = "NAMA_SUAMI"; ?>
                                    <?php if ($key == "ID_ISTRI") $key = "NAMA_ISTRI"; ?>
                                    <?php if ($key == "ID_AYAH") $key = "NAMA_AYAH"; ?>
                                    <?php if ($key == "ID_IBU") $key = "NAMA_IBU"; ?>
                                    <?php if ($key == "NO_KESEHATAN_PASIEN") 
                                        $key = "NOMOR_INDEX_PASIEN"; ?>
                                    <td><strong><?php echo str_replace("_", " ", $key); ?></strong></td>
                                    <td><?php echo $value; ?></td>
                                </tr>
                                <?php endif;
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
                
                <hr></hr>
                <h3>Layanan</h3>
                <table class="table table-bordered table-striped table-comparison table-responsive">
                    <thead>
                        <tr>	
                            <th>NAMA LAYANAN KESEHATAN</th>
                        </tr>
                    </thead>
                    <tbody>  
                        <?php if (isset($tindakan)) :
                            foreach ($tindakan as $row) : ?>
                                <tr>
                                    <td><?php echo $row['NAMA_LAYANAN_KES'] ?></td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>                      
                    </tbody>
                </table>
                
                <hr></hr>
                <h3>Pemeriksaan Lab</h3>
                <table class="table table-bordered table-striped table-comparison table-responsive">
                    <thead>
                        <tr>	
                            <th>NAMA PEMERIKSAAN LAB</th>
                            <th>HASIL TES</th>
                            <th>TANGGAL TES LAB</th>
                        </tr>
                    </thead>
                    <tbody>  
                        <?php if (isset($laborat)) :
                            foreach ($laborat as $row) : ?>
                                <tr>
                                    <td><?php echo $row['NAMA_PEM_LABORAT'] ?></td>
                                    <td><?php echo $row['HASIL_TES_LAB'] ?></td>
                                    <td><?php echo $row['TANGGAL_TES_LAB'] ?></td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>                      
                    </tbody>
                </table>
                
                <hr></hr>
                <h3>ICD </h3>
                <table class="table table-bordered table-striped table-comparison table-responsive">
                    <thead>
                        <tr>	
                            <th>KODE ICD X</th>
                            <th>NAMA ICD</th>
                            <th>DIAGNOSA KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>  
                        <?php if (isset($icd)) :
                            foreach ($icd as $row) : ?>
                                <tr>
                                    <td><?php echo $row['CATEGORY'] ?>.<?php echo $row['SUBCATEGORY'] ?></td>
                                    <td><?php echo $row['INDONESIAN_NAME'] ?></td>
                                    <td><?php echo $row['DESKRIPSI_DP'] ?></td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>                      
                    </tbody>
                </table>
                
                <?php if (!empty($dataKia)) : ?>
                <hr></hr>
                <h3>Riwayat Ibu Hamil</h3>
                <table class="table table-bordered table-striped table-comparison table-responsive">
                    <?php 
                        $flag_imun=0;
                        $flag_vit=0;
                        foreach ($dataKia[0] as $key => $value) :
                            if(!empty($value) && $key!='ID_RIWAYAT_RM' && $key!='ID_DATA_KIA' 
                                    && $key!='ID_ANAK_BALITA' && $key!='ID_DATA_VKKIA'){
                                $key= strtoupper($key);
                                $key= str_replace("FLAG_", "", $key);
                                if($value==1) $value="Ya";
                                if($key=='LETAK_SUNGSANG_LINTANG_KEPALA'){
                                    if($value=='1')$value='Letak Kepala';
                                    else if($value=='2')$value='Letak Sungsang';
                                    else if($value=='3')$value='Letak Lintang';
                                    else $value='Belum Dapat Ditentukan';
                                }
                                if($key=="IMUNISASI_TT") $flag_imun=1;
                                if($key=="VIT_A_IBU") $flag_vit=1;
                                if($key=="TANGGAL_IMUN_TT" && $flag_imun==1){
                            ?>
                                <tr>
                                    <td><strong><?php echo str_replace("_", " ", $key) ?></strong></td>
                                    <td><?php echo $value; ?></td>
                                </tr>
                            <?php
                                }
                                else if($key=="TANGGAL_VIT_A_IBU" && $flag_vit==1){
                                ?>
                                <tr>
                                    <td><strong><?php echo str_replace("_", " ", $key) ?></strong></td>
                                    <td><?php echo $value; ?></td>
                                </tr>
                            <?php
                                }
                                else if($key!="TANGGAL_VIT_A_IBU" && $key!="TANGGAL_IMUN_TT"){
                                ?>
                                <tr>
                                    <td><strong><?php echo str_replace("_", " ", $key) ?></strong></td>
                                    <td><?php echo $value; ?></td>
                                </tr>
                    <?php
                                }
                            }
                        endforeach; 
                    ?>
                </table>
                <?php endif;
                if (!empty($dataBalita)) : ?>
                <hr></hr>
                <h3>Riwayat Anak-Balita</h3>
                <table class="table table-bordered table-striped table-comparison table-responsive">
                    <?php 
                        foreach ($dataBalita[0] as $key => $value) :
                            if(!empty($value) && $key!='ID_RIWAYAT_RM' && $key!='ID_DATA_KIA' 
                                    && $key!='ID_ANAK_BALITA' && $key!='ID_DATA_VKKIA'){
                                $key= strtoupper($key);
                                $key= str_replace("FLAG_", "", $key);
                                if($value=="1") $value="Ya";
                    ?>
                                <tr>
                                    <td><strong><?php echo str_replace("_", " ", $key) ?></strong></td>
                                    <td><?php echo $value; ?></td>
                                </tr>
                    <?php
                            }
                        endforeach; 
                    ?>
                </table>
                <?php endif; 
                if (!empty($dataVkkia)) : ?>
                <hr></hr>
                <h3>Riwayat VK KIA</h3>
                <table class="table table-bordered table-striped table-comparison table-responsive">
                    <?php 
                        foreach ($dataVkkia[0] as $key => $value) :
                            if(!empty($value) && $key!='ID_RIWAYAT_RM' && $key!='ID_DATA_KIA' 
                                    && $key!='ID_ANAK_BALITA' && $key!='ID_DATA_VKKIA'){
                                $key= strtoupper($key);
                                $key= str_replace("FLAG_", "", $key);
                                $key= str_replace("VK_", "", $key);
                                if($value==1) $value="Ya";
                                if($value=='l') $value="Laki-laki";
                                else if($value=='p') $value="Perempuan";
                    ?>
                            <tr>
                                <td><strong><?php echo str_replace("_", " ", $key) ?></strong></td>
                                <td><?php echo $value; ?></td>
                            </tr>
                    <?php
                            }
                        endforeach;
                    ?>
                </table>
                <?php endif;
                if (!empty($dataKb)) :?>
                <hr></hr>
                <h3>Riwayat KB</h3>
                <table class="table table-bordered table-striped table-comparison table-responsive">
                    <?php 
                        foreach ($dataKb[0] as $key => $value) :
                            if(!empty($value) && $key!='ID_RIWAYAT_RM' && $key!='ID_ALAT_KONTRASEPSI_YG_BOLEH' 
                                    && $key!='ID_ALAT_KONTRASEPSI_SEBELUMNYA' && $key!='ID_ALAT_KB'){
                                $key= strtoupper($key);
                                $key= str_replace("KB_", "", $key);
                                if($key=='STAT_PESERTA_KB'){
                                    if($value='1') $value='Baru pertama kali';
                                    else if($value='2') $value='Pernah pakai alat KB berhenti sesudah bersalin/keguguran';
                                }
                                if($key=='PENYAKIT_SEBELUMNYA_SKUNING' ||
                                   $key=='PENYAKIT_SEBELUMNYA_PERVAGINAM' || 
                                   $key=='PENYAKIT_SEBELUMNYA_KEPUTIHAN' || 
                                   $key=='PENYAKIT_SEBELUMNYA_TUMOR' ||
                                   $key=='KEADAAN_UMUM' ||
                                   $key=='TANDA2_RADANG' ||
                                   $key=='TUMOR_GINEKOLOGI' ||
                                   $key=='TANDA_DIABET' ||
                                   $key=='KELAINAN_PEMBEKUAN_DARAH' ||
                                   $key=='RADANG_ORCHITIS_EPIDIDYMITIS' ||
                                   $key=='FLAG_SEDANG_KB' ||
                                   $key=='TUMOR_GINEKOLOGI_TAMBAHAN' ||
                                   $key=='DIDUGA_HAMIL' ||
                                   $key=='FLAG_MENYUSUI') 
                                    $value='Ya';
                                if($key=='POSISI_RAHIM'){
                                    if($value=='1') $value='Retrofleksi';
                                    else if($value=='2') $value='Anterfleksi';
                                }
                                if($key=='SEBELUM' && $key=='BOLEH' && $key=='BOLEH') $key=$key.' SEBELUMNYA';
                                if($key=='UMUR_ANAK_TERKECIL') $value= (floor($value / 12)). " th ".((int) $value % 12) . " bulan" ;
                    ?>
                            <tr>
                                <td><strong><?php echo str_replace("_", " ", $key) ?></strong></td>
                                <td><?php echo $value; ?></td>
                            </tr>
                    <?php
                            }
                        endforeach; 
                    ?>
                </table>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <h3>Riwayat Rekam Medik</h3>
                    <input type="hidden" id="id_rrm" name="id_rrm" value="<?php echo $idrrm; ?>">
                    <?php if (isset($riwayat_rm)) :
                        foreach ($riwayat_rm[0] as $key => $value) :
                            if ($key == "TANGGAL_RIWAYAT_RM") : ?>
                                <div class="form-group">
                                    <label for="<?php echo $key; ?>"><?php echo "TANGGAL KUNJUNGAN" ?></label><br>
                                    <input readonly class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" type="date" value="<?php echo $value; ?>">
                                </div>
                        <?php endif;
                        endforeach;
                    endif;
                    ?>
                    <?php if (isset($riwayat_rm)) : ?>
                        <?php foreach ($riwayat_rm[0] as $key => $value) :
                                if(!empty($value)):
                                    if ($key != "ID_RIWAYAT_RM" && $key != "ID_REKAMMEDIK" && $key != "FLAG_HAMIL" && $key != "ID_LAYANAN_KES" && $key != "ID_SUMBER" && $key != "FLAG_OPNAME" && $key != "TANGGAL_RIWAYAT_RM") : ?>

                                    <div class="form-group">
                                        <label for="<?php echo $key; ?>"><?php echo str_replace("_", " ", $key); ?></label><br>
                                        
                                        <?php if($key == "CUMA_KONTROL" && $value==1){ ?>
                                            <input readonly class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" type="text" value="Ya";
                                        <?php } ?>
                                        <?php if ($key == "UMUR_SAAT_INI") : ?>
                                            <input readonly class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" type="text" value="<?php echo (floor((int) $value)) . " th ";
                                        echo ((int) $value % 12) . " bulan" ?>">
                                        <?php
                                        else : ?>
                                            <input readonly class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" type="text" value="<?php echo $value; ?><?php if ($key == "SUHU_BADAN") echo " Celcius"; ?><?php if ($key == "BERATBADAN_PASIEN") echo " Kg"; ?><?php if ($key == "TINGGIBADAN_PASIEN") echo " cm"; ?>">
                                    <?php endif; ?>
                                    </div>
                                <?php 
                                    endif;
                                endif; ?>
                            <?php
                        endforeach;
                    endif;
                    ?>                
            </div>
        </div>
    </div>
</div>

<br><br>