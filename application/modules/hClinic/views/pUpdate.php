<?php
$row = $selectedPuskesmas[0];
?>
<div class="row">
    <section class="slice bg-2 p-15">
        <div class="cta-wr">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <h4>Perubahan Data <?php echo $row['NAMA_GEDUNG']; ?></h4>
                    </div>
                    <div class="col-md-3">
                    <form class="form-inline">
                        <div class="input-group">
                            <input class="form-control" placeholder="Masukkan kata pencarian" type="text">
                            <span class="input-group-btn">
                                <button class="btn btn-two" type="button">Go!</button>
                            </span>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </section>
  <div class="col-lg-5">
      <section class="panel">
            <div class="panel-body">
                <form class="form-horizontal bucket-form" method="post" action="<?php echo base_url(); ?>index.php/hClinic/hClinic/saveUpdatePuskesmas">
                    <input type="text" hidden="hidden" id="selectedIdGedung" name="selectedIdGedung" value="<?php echo $row['ID_GEDUNG']; ?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No Identitas</label>
                        <div class="col-sm-9">
                            <input type="text" id="inputNoidGedung" name="inputNoidGedung" value="<?php echo $row['NOID_GEDUNG']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" id="inputNamaGedung" name="inputNamaGedung" value="<?php echo $row['NAMA_GEDUNG']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Alamat</label>
                        <div class="col-sm-9">
                            <input type="text" id="inputJalan" name="inputJalan" value="<?php echo $row['JALAN_GEDUNG']; ?>" class="form-control">
                            <!--<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kelurahan</label>
                        <div class="col-sm-9">
                            <input type="text" id="inputKelurahan" name="inputKelurahan" value="<?php echo $row['KELURAHAN_GEDUNG']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kecamatan</label>                        
                        <div class="col-sm-9">
                            <input type="text" id="inputKecamatan" name="inputKecamatan" value="<?php echo $row['KECAMATAN_GEDUNG']; ?>" class="form-control">
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kabupaten</label>
                        <div class="col-sm-9">
                            <input type="text" id="inputKabupaten" name="inputKabupaten" value="<?php echo $row['KABUPATEN_GEDUNG']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Provinsi</label>
                        <div class="col-sm-9">
                            <input type="text" id="inputProvinsi" name="inputProvinsi" value="<?php echo $row['PROVINSI_GEDUNG']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9">
                            <input class="btn btn-primary pull-right" type="submit" value="update" name="submit">
                        </div>
                    </div>
                </form>
            </div>
        </section>
  </div>
  <div class="col-lg-7">
  <section class="panel">
        <header class="panel-heading">
            Daftar Puskesmas
        </header>

        <div class="panel-body">



                <?php
//                    for($i=0; $i<sizeof($temp); $i++){
//                        echo $temp[$i].'<br/>';
//                    }
                ?>
                <div class="form-group">
                    <div class="col-sm-12 adv-table editable-table pull-right">
                        <div class="clearfix">
                        </div>
                        <div class="space15"></div>
                        <table class="table table-striped table-hover table-bordered" id="editable-sample">
                            <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Ubah</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($allPuskesmas)) :?>
                            <?php foreach ($allPuskesmas as $row): ?>
                                <tr><!-- set class using counter i -->
                                    <td><?php echo $row['NOID_GEDUNG'];?></td> <!-- set class using kode obat -->
                                    <td id="namaGedung<?php echo $row['ID_GEDUNG'];?>"><?php echo $row['NAMA_GEDUNG'];?></td> <!-- set class using kode obat -->
                                    <td>
                                        <a href="<?php echo base_url() ?>index.php/hClinic/updatePuskesmas?id=<?php echo $row['ID_GEDUNG'];?>">
                                            <button  type="button" data-dismiss="modal" aria-hidden="true">Edit</button>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn" data-toggle="modal" href="#deleteConfirmModal" id="<?php echo $row['ID_GEDUNG']?>_" onclick="myFunction2(this.id)">
                                            ×
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </section>
</div> 
</div>