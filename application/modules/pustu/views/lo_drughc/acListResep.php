<?php
for($i=0; $i<sizeof($resep); $i++):
    if(isset($resep[$i]['NAMA_PASIEN'])){
        $idPasien= $resep[$i]['ID_PASIEN'];
        $namaPasien= $resep[$i]['NAMA_PASIEN'];
        $tanggalTrans= $resep[$i]['TANGGAL_TRANSAKSI'];
        $riwayatRM= $resep[$i]['ID_RIWAYAT_RM'];
        $idTransResep= $resep[$i]['ID_TRANSAKSI_RESEP'];
    }
endfor;
?>
<div class="container">
    <div class="row">
      <div class="col-lg-12">
            <div class="panel panel-primary">
                <header class="panel-heading">
                    <h3 class="panel-title"><?= 'Resep Obat '.$namaPasien.' '.$tanggalTrans ?></h3>
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-1">
                            <button data-toggle="modal" href="#myModal" class="btn btn-danger pull-left" onclick="dialog('<?= $tanggalTrans ?>','<?= $idTransResep ?>','<?= $riwayatRM ?>','<?= $idPasien ?>','<?= $namaPasien ?>')" >Batalkan</button>
                        </div>
                        <div class="col-sm-2">
                            <button class="setujui btn btn-primary pull-left"  onclick="setujui('<?= $tanggalTrans ?>','<?= $idTransResep ?>','<?= $riwayatRM ?>','<?= $idPasien ?>','<?= $namaPasien ?>');" >Setujui dan Buat Tebusan Obat</button>
                        </div>
                            <br/><br/>
                        <div class="col-sm-12">
                            Pemberi Resep: <b><?= $pemberiResep[0]['NAMA_AKUN'] ?></b><br/>
                            Unit/Pelayanan: <b><?= $pemberiResep[0]['NAMA_UNIT'] ?></b><br/>
                            <div class="clearfix">
                            </div>
                            <div class="space15"></div>
                            <table class="table table-bordered" >
                                <thead>
                                <tr>
                                    <th>Batch</th>
                                    <th>Nama Obat</th>
                                    <th>Satuan</th>
                                    <th>Pemakaian (perhari)</th>
                                    <th>Lama Penggunaan</th>
                                    <th>Signa</th>
                                    <th>Deskripsi Obat</th>
                                    <th>Jumlah Obat Diberikan</th>
                                </tr>
                                </thead>
                                <tbody class="bodyTable">
                                    <?php
                                    $flagError=0;
                                    for($i=0; $i<sizeof($resep); $i++):
                                        if(isset($resep[$i]['statsTidakAda']) && $resep[$i]['statsTidakAda']==1){ 
                                            $flagError=1;?>
                                            <tr style="background: red;color:white">
                                                <td colspan="8"><?= 'Stok obat '.$resep[$i]['namaTidakAda'].' tidak tersedia' ?></td>
                                            </tr>
                                    <?php }
                                        else {
                                            if(isset($resep[$i]['statsKurang']) && $resep[$i]['statsKurang']==1){ 
                                                $flagError=1;?>
                                                <tr style="background: yellow">
                                                    <td colspan="8"><?= 'Stok obat '.$resep[$i]['namaKurang'].' tidak mencukupi' ?></td>
                                                </tr>
                                    <?php   }
                                            else if($resep[$i]['statsKurang']==0 && $resep[$i]['statsTidakAda']==0){
                                                $kode= $resep[$i]['NOMOR_BATCH'];?>
                                                <tr class="startHere <?= 'kodeName_'.$kode ?>" style="<?php // echo $bg.';'.$font ?>">
                                                    <td><?= $resep[$i]['NOMOR_BATCH'] ?></td>
                                                    <td><?= $resep[$i]['NAMA_OBAT'] ?></td>
                                                    <td><?= $resep[$i]['SATUAN'] ?></td>
                                                    <td><?= $resep[$i]['JUMLAH_SEHARI'].'x' ?></td>
                                                    <td><?= $resep[$i]['LAMA_HARI'] ?></td>
                                                    <td><?= $resep[$i]['SIGNA'] ?></td>
                                                    <td><?= $resep[$i]['DESKRIPSI_OP'] ?></td>
                                                    <td><?= $resep[$i]['STOK_OBAT_SEKARANG'] ?></td>
                                                </tr>
                                    <?php   }
                                        }
                                    endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
</div>

<script>
    $(function () {
        var disable= <?= $flagError ?>;
        if(disable){
            $(".setujui").attr('disabled','disabled');
        }
    });
    
    function setujui(tanggal, idTransaksiResep, idRiwayatRM, idPasien, namaPasien){
        if (confirm("Setujui tebusan obat "+namaPasien+" "+tanggal)) {
            location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0) ?>'+'/createTebusan/'+idTransaksiResep+'/'+idRiwayatRM+'/'+idPasien;
        }
        return false;
    }
    
    function dialog(tanggal, idTransaksiResep, idRiwayatRM, idPasien, namaPasien){
        $('.tanggal').val(tanggal);
        $('.idTransaksiResep').val(idTransaksiResep);
        $('.idRiwayatRM').val(idRiwayatRM);
        $('.idPasien').val(idPasien);
        $('.namaPasien').val(namaPasien);
        $('.KETERANGAN_TRANSAKSI_OBAT').val('');
    }
    
    function batal(tanggal, idTransaksiResep, idRiwayatRM, idPasien, namaPasien){
        if (confirm("Apakah anda yakin tebusan obat "+namaPasien+" "+tanggal+" akan dibatalkan?")) {
            $("#pembatalan").submit();
        }
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
                    <div class="col-lg-12">
                        <input type="hidden" class="tanggal" name="tanggal" readonly="true">
                        <input type="hidden" class="idTransaksiResep" name="idTransaksiResep" readonly="true">
                        <input type="hidden" class="idRiwayatRM" name="idRiwayatRM" readonly="true">
                        <input type="hidden" class="idPasien" name="idPasien" readonly="true">
                        <input type="hidden" class="namaPasien" name="namaPasien" readonly="true">
                        <div class="form-group">
                            <textarea class="form-control KETERANGAN_TRANSAKSI_OBAT" name="KETERANGAN_TRANSAKSI_OBAT"  placeholder="Masukkan alasan pembatalan obat" style="height:100px;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-danger" type="button">Keluar</button>
                <button data-dismiss="modal" class="btn btn-primary" type="button" onclick="batal($('.tanggal').val(), $('.idTransaksiResep').val(), $('.idRiwayatRM').val(), $('.idPasien').val(), $('.namaPasien').val())">Simpan</button>
            </div>
        </div>
        </form>
    </div>
</div>
<!-- modal -->