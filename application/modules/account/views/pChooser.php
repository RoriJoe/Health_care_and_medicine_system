<div class="col-lg-12">
  <section class="panel">
        <header class="panel-heading">
            Request Obat
        </header>
        <div class="panel-body">
            <form class="form-horizontal bucket-form"  action="<?php echo base_url() ?>index.php/puskesmas/updatePuskesmas" method="post">
                <?php
//                    for($i=0; $i<sizeof($temp); $i++){
//                        echo $temp[$i].'<br/>';
//                    }
                ?>
                <div class="form-group">
                    <div class="col-sm-12 adv-table editable-table ">
                        <div class="clearfix">
                        </div>
                        <div class="space15"></div>
                        <table class="table table-striped table-hover table-bordered" id="editable-sample">
                            <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Kelurahan</th>
                                <th>Kecamatan</th>
                                <th>Kabupaten</th>
                                <th>Provinsi</th>
                                <th>Ubah</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php for($i=0; $i<10; $i++): ?>
                                <?php
                                    $kodeObat= $i;  //set kode obat
                                    $stats= 0;  //set status default is null
                                ?>
                                <tr><!-- set class using counter i -->
                                    <td class="<?= "kode_".$kodeObat ?>"><?= $kodeObat ?></td> <!-- set class using kode obat -->
                                    <td class="<?= "nama_".$kodeObat ?>"><?= $i.'ABC'; ?></td> <!-- set class using kode obat -->
                                    <td class="<?= 'alm_'.$kodeObat ?>">0</td> <!-- set class using kode obat -->
                                    <td class="<?= 'kel_'.$kodeObat ?>">0</td>
                                    <td class="<?= 'kec_'.$kodeObat ?>">0</td>
                                    <td class="<?= 'kab_'.$kodeObat ?>">0</td>
                                    <td class="<?= 'prov_'.$kodeObat ?>">0</td>
                                    <td><a href="<?php echo base_url() ?>index.php/puskesmas/updatePuskesmas">Edit</a></td>
                                    <td></td>
                                </tr>
                            <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<div class="row">
  <div class="col-lg-6">
      <section class="panel">
            <header class="panel-heading">
                Kepala Puskesmas
            </header>
            <div class="panel-body">
                <form class="form-horizontal bucket-form" method="get">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Alamat</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control">
                            <!--<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kelurahan</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kecamatan</label>                        
                        <div class="col-sm-6">
                            <input type="text" class="form-control">
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kabupaten</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Provinsi</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
                </form>
            </div>
        </section>
  </div>    
