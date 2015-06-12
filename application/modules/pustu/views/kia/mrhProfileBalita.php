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
                <h3>Riwayat Anak-Balita</h3>
                <table class="table table-bordered table-striped table-comparison table-responsive">
                    <?php if (isset($data)) :
                        foreach ($data[0] as $key => $value) :
                            if(!empty($value) && $key!='ID_RIWAYAT_RM' && $key!='ID_DATA_KIA' 
                                    && $key!='ID_ANAK_BALITA' && $key!='ID_DATA_VKKIA'){
                                $key= strtoupper($key);
                                $key= str_replace("FLAG_", "", $key);
                                if($value==1) $value="Ya";
                    ?>
                            <tr>
                                <td><strong><?php echo str_replace("_", " ", $key) ?></strong></td>
                                <td><?php echo $value; ?></td>
                            </tr>
                    <?php
                            }
                        endforeach; 
                    endif;
                    ?>
                </table>

                <hr></hr>
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

                                        <?php if ($key == "UMUR_SAAT_INI") : ?>
                                            <input readonly class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" type="text" value="<?php echo (floor((int) $value)) . " th ";
                                        echo ((int) $value % 12) . " bulan" ?>">
                                        <?php else : ?>
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