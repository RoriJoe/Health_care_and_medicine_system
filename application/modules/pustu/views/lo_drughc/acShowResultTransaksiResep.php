<div class="container">
<div class="row">
  <div class="col-lg-12">
        <div class="panel panel-primary">
            <header class="panel-heading">
                <h3 class="panel-title"><?= $jenisTrans[0]['NAMA_JENIS'].' '.$namaPasien ?></h3>
            </header>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Tanggal :</label>
                    <div class="col-sm-7">
                        <label class="">
                            <?php 
                                $mydate = date_create_from_format('Y-m-d', $trans[0]['TANGGAL_TRANSAKSI'] );
                                echo date_format($mydate, 'd F Y');
                            ?>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 adv-table editable-table ">
                        <div class="clearfix">
                        </div>
                        <div class="space15"></div>
                        <table class="table table-bordered" id="">
                            <thead>
                            <tr>
                                <th>Batch</th>
                                <th>Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Jumlah Sehari</th>
                                <th>Lama Hari</th>
                                <th>Signa</th>
                                <th>Deskripsi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php for($i=0; $i<sizeof($listNamObat); $i++): ?>
                                <?php
                                    $count= $i+1;
                                ?>
                                <tr>
                                    <td><?= $listBatch[$i] ?></td>
                                    <td><?= $listNamObat[$i] ?></td>
                                    <td><?= $listJmlObat[$i] ?></td>
                                    <td><?= $listSatObat[$i] ?></td>
                                    <td><?= $listJmlSehari[$i] ?></td>
                                    <td><?= $listLamaHari[$i] ?></td>
                                    <td><?= $listSigna[$i] ?></td>
                                    <td><?= $listDeskObat[$i] ?></td>
                                </tr>
                            <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
  </div>
</div>
</div>