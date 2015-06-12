
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Data Antrian Laboratorium</h3>
                </div>
                <div class="panel-body">
                    <div style="height: 300px; overflow-y: scroll;">
                        <table style="width: 100%;" class="table table-striped table-responsive">
                            <thead>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Gol Darah</th>
                            <th>Tanggal Lahir</th>
                            <th>Waktu Antrian</th>
                            <th>Pilih</th>
                            </thead>
                            <tbody>
                                <?php $r = 1;
                                if (isset($queues)) : ?>
                                <?php foreach ($queues as $row) : ?>
                                    <form method="post" action="<?php echo base_url(); ?>laboratorium/lab/fillResult">
                                        <tr>
                                            <td><?php echo $r; ?> <input id="idrrm" name="idrrm" type="hidden" value="<?php echo $row['id_riwayat_rm']; ?>"></td>				
                                            <td><?php echo $row['nama_pasien']; ?></td>
                                            <td><?php echo $row['GENDER_PASIEN']; ?> </td>
                                            <td><?php echo $row['GOL_DARAH_PASIEN']; ?> <input id="idantrian" name="idantrian" type="hidden" value="<?php echo $row['id_antrian_unit']; ?>"></td>
                                            <td><?php echo $row['TGL_LAHIR_PASIEN']; ?></td>
                                            <td><?php echo $row['waktu_antrian_unit']; ?></td>
                                            <td><button type="submit" class="btn btn-xs btn-success" ><i class="fa fa-check"></i></button></td>
                                            
                                            
                                        </tr>
                                    </form>
                                    <?php $r++;
                                endforeach;
                            endif;
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
