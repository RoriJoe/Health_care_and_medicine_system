<!-- css pagination -->
<style> 
    ul.tsc_pagination { margin:4px 0; padding:0px; height:100%; overflow:hidden; font:12px 'Tahoma'; list-style-type:none; }
    ul.tsc_pagination li { float:left; margin:0px; padding:0px; margin-left:5px; }

    ul.tsc_pagination li a { color:black; display:block; text-decoration:none; padding:7px 10px 7px 10px; }


    ul.tsc_paginationA li a { color:#FFFFFF; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px; }

    ul.tsc_paginationA01 li a { color:#474747; border:solid 1px #B6B6B6; padding:6px 9px 6px 9px; background:#E6E6E6; background:-moz-linear-gradient(top, #FFFFFF 1px, #F3F3F3 1px, #E6E6E6); background:-webkit-gradient(linear, 0 0, 0 100%, color-stop(0.02, #FFFFFF), color-stop(0.02, #F3F3F3), color-stop(1, #E6E6E6)); }
    ul.tsc_paginationA01 li:hover a,
    ul.tsc_paginationA01 li.current a { background:#FFFFFF; }
</style>
<div class="container">
    <div class="row">
      <div class="col-lg-12">
            <div class="panel panel-primary">
                <header class="panel-heading">
                    <h3 class="panel-title"><?= 'Riwayat Resep Obat '.$namaPasien[0]['NAMA_PASIEN'] ?></h3>
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-12 adv-table editable-table ">
                            <div class="clearfix">
                            </div>
                            <div class="space15"></div>
                            <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Tanggal Resep</th>
                                    <th>Detail Resep</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php for($i=0; $i<sizeof($riwayat); $i++): ?>
                                    <tr>
                                        <td><?php $count=$i+1; echo $count; ?></td>
                                        <td><?= $riwayat[$i]['TANGGAL_TRANSAKSI'] ?></td>
                                    <?php
                                    $id_riwayat_rm= $riwayat[$i]['ID_RIWAYAT_RM'];
                                    if($riwayat[$i]['FLAG_KONFIRMASI']==0){ ?>
                                        <td>                        
                                            <button class="btn btn-primary pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/showTransResep/'.$riwayat[$i]['ID_TRANSAKSI'].'/'.$riwayat[$i]['ID_RIWAYAT_RM'] ?>';">Lihat</button>
                                        </td>
                                        <td><button class="btn btn-warning pull-left">Belum ditebus</button> </td>
                                    <?php
                                    }
                                    else if($riwayat[$i]['FLAG_KONFIRMASI']==1){ ?>
                                        <td>                        
                                            <button class="btn btn-primary pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/showTransResep/'.$riwayat[$i]['ID_TRANSAKSI'].'/'.$riwayat[$i]['ID_RIWAYAT_RM'] ?>';">Lihat</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-info pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/showTransResep/'.$tebusan[$id_riwayat_rm].'/'.$riwayat[$i]['ID_RIWAYAT_RM'] ?>';">Lihat Tebusan</button>
                                        </td>
                                    <?php
                                    }
                                    else if($riwayat[$i]['FLAG_KONFIRMASI']==2){ ?>
                                        <td>                        
                                            <button class="btn btn-primary pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/showTransResep/'.$riwayat[$i]['ID_TRANSAKSI'].'/'.$riwayat[$i]['ID_RIWAYAT_RM'] ?>';">Lihat</button>
                                        </td>
                                        <td><button data-toggle="modal" href="#myModal" onclick="showAlasan('<?= $riwayat[$i]['KETERANGAN_TRANSAKSI_OBAT']; ?>')" class="btn btn-danger pull-center">Dibatalkan</button></td>                    
                                    <?php
                                    } 
                                    ?>
                                    </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12"><?= $links; ?></div>
                    </div>
                </div>
            </div>
      </div>
    </div>
</div>

<script>
    function showAlasan(KETERANGAN_TRANSAKSI_OBAT){
        $('.KETERANGAN_TRANSAKSI_OBAT').val(KETERANGAN_TRANSAKSI_OBAT);
    }
</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="pembatalan" class="form-horizontal bucket-form" method="post" action="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/resepPasien/batal' ?>">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Alasan Pembatalan Resep Obat</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea class="form-control KETERANGAN_TRANSAKSI_OBAT" name="KETERANGAN_TRANSAKSI_OBAT"  placeholder="Masukkan alasan pembatalan obat" rows="10" readonly="true"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-danger" type="button">Keluar</button>
            </div>
        </div>
        </form>
    </div>
</div>
<!-- modal -->