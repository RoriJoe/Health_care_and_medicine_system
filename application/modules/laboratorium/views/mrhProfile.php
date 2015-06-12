<div class="container">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary" onclick='window.location.href = "<?= base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/profileMRHpdf/' . $this->uri->segment(4) ?>";'>Cetak Hasil Uji Lab</button>
            <br/><br/>
            <section class="slice bg-2 p-15">
                <h3>Hasil Uji Lab Pasien <?php if (isset($profil)) : echo '- ' . $profil[0]['NAMA_PASIEN'];
endif; ?></h3>
            </section>	&nbsp;
            <div class="col-md-12">
                <h3>Profil Pasien</h3>
                <table class="table table-bordered table-striped table-comparison table-responsive">
                    <tbody>
                        <tr>
                            <td><strong>Nomor Index</strong></td>
                            <td><?php echo $profil[0]['NOID_REKAMMEDIK']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Nama Pasien</strong></td>
                            <td><?php echo $profil[0]['NAMA_PASIEN']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tgl Lahir</strong></td>
                            <td><?php echo $profil[0]['TGL_LAHIR_PASIEN']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td><?php echo $profil[0]['GENDER_PASIEN']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td><?php echo $profil[0]['ALAMAT_PASIEN'].', '.$profil[0]['KECAMATAN_PASIEN'].', '.$profil[0]['KOTA_PASIEN']; ?></td>
                        </tr>
                    </tbody>
                </table>

                <!--                <hr></hr>
                                <h3>Layanan</h3>
                                <table class="table table-bordered table-striped table-comparison table-responsive">
                                    <thead>
                                        <tr>	
                                            <th>NAMA LAYANAN KESEHATAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>  
                <?php if (isset($tindakan)) :
                    foreach ($tindakan as $row) :
                        ?>
                                                        <tr>
                                                            <td><?php echo $row['NAMA_LAYANAN_KES'] ?></td>
                                                        </tr>
                        <?php
                    endforeach;
                endif;
                ?>                      
                                    </tbody>
                                </table>-->

                <hr/>
                <h3>Pemeriksaan Lab</h3>
                <table class="table table-bordered table-striped table-comparison table-responsive">
                    <thead>
                        <tr>	
                            <th>PEMERIKSAAN</th>
                            <th>SPESIMEN</th>
                            <th>KATEGORI PENGUJIAN</th>
                            <th>HASIL TES</th>
                            <th>SATUAN</th>
                            <th>NILAI NORMAL</th>
                            <th>TANGGAL TES</th>
                        </tr>
                    </thead>
                    <tbody>  
<?php if (isset($laborat)) :
    foreach ($laborat as $row) :
        ?>
                                <tr>
                                    <td><?php echo $row['NAMA_PEM_LABORAT'] ?></td>
                                    <td><?php echo $row['NAMA_SPESIMEN'] ?></td>
                                    <td><?php echo $row['NAMA_KP_LABORAT'] ?></td>
                                    <td><?php echo $row['HASIL_TES_LAB'] ?></td>
                                    <td><?php echo $row['SATUAN_HASIL_UJI'] ?></td>
                                    <td><?php echo $row['NILAI_NORMAL_UJI'] ?></td>
                                    <td><?php echo $row['TANGGAL_TES_LAB'] ?></td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>                      
                    </tbody>
                </table>

                <!--                <hr/>
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
    foreach ($icd as $row) :
        ?>
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
                            </div>-->

                <!--            <div class="col-md-6">
                                <h3>Riwayat Rekam Medik</h3>
<?php if (isset($riwayat_rm)) : ?>
    <?php foreach ($riwayat_rm[0] as $key => $value) :
        if ($key == "TANGGAL_RIWAYAT_RM") :
            ?>
                                                            <div class="form-group">
                                                                <label for="<?php echo $key; ?>"><?php echo "TANGGAL KUNJUNGAN" ?></label><br>
                                                                <input readonly class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" type="date" value="<?php echo $value; ?>">
                                                            </div>
                        <?php
                        endif;
                    endforeach;
                endif;
                ?>
                <?php if (isset($riwayat_rm)) : ?>
                    <?php
                    foreach ($riwayat_rm[0] as $key => $value) :
                        if (!empty($value)):
                            if ($key != "ID_RIWAYAT_RM" && $key != "ID_REKAMMEDIK" && $key != "FLAG_HAMIL" && $key != "ID_LAYANAN_KES" && $key != "ID_SUMBER" && $key != "STAT_RAWAT_JALAN" && $key != "FLAG_OPNAME" && $key != "TANGGAL_RIWAYAT_RM") :
                                ?>
                                                                    <div class="form-group">
                                                                        <label for="<?php echo $key; ?>"><?php echo str_replace("_", " ", $key); ?></label><br>
                                <?php if ($key == "UMUR_SAAT_INI") : ?>
                                                                                <input readonly class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" type="text" value="<?php echo (floor((int) $value / 12)) . " th ";
                    echo ((int) $value % 12) . " bulan" ?>">
                <?php else : ?>
                                                                                <input readonly class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" type="text" value="<?php echo $value; ?><?php if ($key == "SUHU_BADAN") echo " Celcius"; ?><?php if ($key == "BERATBADAN_PASIEN") echo " Kg"; ?><?php if ($key == "TINGGIBADAN_PASIEN") echo " cm"; ?>">
                <?php endif; ?>
                                                                    </div>
            <?php
            endif;
        endif;
    endforeach;
endif;
?>
                            </div>	-->

            </div>
        </div>
    </div>

    <br><br>