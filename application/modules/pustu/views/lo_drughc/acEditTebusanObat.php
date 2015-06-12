<div class="container">	
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <header class="panel-heading">
                    <h3 class="panel-title">Perubahan Resep Obat</h3>
                </header>
                <div class="panel-body">
                    <h3 class="needObat"><?= 'Membutuhkan Obat Sebanyak '.$dataSebelumnya['JUMLAH_OBAT'].' ('.$listObat[0]['SATUAN'].')' ?></h3>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Batch</th>
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th>Expired</th>
                            <th>Sisa_Stok</th>
                            <th>Kelola</th>
                        </tr>
                        </thead>
                        <tbody class="listObatMaster">
                            <?php for($key=0; $key<sizeof($listObat); $key++): ?>
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td><?= $listObat[$key]['NOMOR_BATCH'] ?></td>
                                <td><?= $listObat[$key]['NAMA_OBAT'] ?></td>
                                <td><?= $listObat[$key]['SATUAN'] ?></td>
                                <td><?= $listObat[$key]['EXPIRED_DATE'] ?></td>
                                <td><?= $listObat[$key]['STOK'] ?></td>
                                <td>
                                    <button data-toggle="modal" href="#myModal" onclick="setObat('<?= $listObat[$key]['ID_DETIL_TO'] ?>','<?= $listObat[$key]['ID_OBAT'] ?>','<?= $listObat[$key]['NOMOR_BATCH'] ?>','<?= $listObat[$key]['NAMA_OBAT'] ?>','<?= $listObat[$key]['STOK'] ?>','<?= $listObat[$key]['SATUAN'] ?>','<?= $listObat[$key]['EXPIRED_DATE'] ?>')" class="btn btn-primary">Pilih</button>
                                </td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
      </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <header class="panel-heading">
                    <h3 class="panel-title">Obat yang dipilih</h3>
                </header>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Batch</th>
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Expired</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="list_obat">
                        </tbody>
                    </table>
                    <br/><br/>
                    <form class="form-horizontal bucket-form" method="post" action="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/resepPasien/replaceObat/'.$id_detil_to_now ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tanggal</label>
                            <div class="col-sm-3">
                                <input type="text" name="transaksi" class="datepicker form-control default-date-picker"  size="16" value="<?= date('d-m-Y') ?>" />
                                <span class="help-block">Pilih Tanggal</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-3">
                                <!--<input type="hidden" name="jenis_transaksi" value="<?= $jenisTransId ?>">-->
                                <!--<input type="hidden" name="flag_konfirmasi" value="0">-->
                                <input type="hidden" name="total_kodeObat" class="total_kodeObat" value="" /> <!-- total id obat -->
                                <input type="hidden" name="total_batch" class="total_batch" value="" /><!-- total_batch -->
                                <input type="hidden" name="total_jumlahObat" class="total_jumlahObat" value="" /> <!-- total jumlah obat -->
                                <input type="hidden" name="transaksi_now" class="" value="<?= date('m-d-Y') ?>" /> <!-- tanggal transaksi -->
                                <input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title needObat"><?= 'Membutuhkan Obat Sebanyak '.$dataSebelumnya['JUMLAH_OBAT'].' ('.$listObat[0]['SATUAN'].')' ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>No. BATCH</label>
                            <input class="form-control detil_id" type="hidden" name="detil_id" value="" readonly="true">
                            <input class="form-control id_obat" type="hidden" name="id_obat" value="" readonly="true">
                            <input class="form-control batch" type="text" name="batch" value="" readonly="true">
                        </div>
                        <div class="form-group">
                            <label>Nama Obat</label>
                            <input class="form-control nama_obat" type="text" name="nama_obat" value="" readonly="true">
                        </div>
                        <div class="form-group">
                            <label>Expired Date</label>
                            <input class="form-control expObat" type="text" name="expObat" value="" readonly="true">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sisa Stok</label>
                                    <input class="form-control jmlObat" type="text" name="jmlObat" value="" readonly="true">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input class="form-control satObat" type="text" name="satObat" value="" readonly="true">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Pengiriman</label>
                            <input class="form-control pesan" type="text" name="pesan" value="" placeholder="Jumlah Permintaan">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-danger" type="button">Keluar</button>
                <button data-dismiss="modal" class="btn btn-primary" type="button" onclick="selectObat($('.detil_id').val(), $('.id_obat').val(), $('.batch').val(), $('.nama_obat').val(), $('.expObat').val(), $('.pesan').val(), $('.jmlObat').val(), $('.satObat').val())">Tambah</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->

<script>
    $(function () {
        $( ".datepicker" ).datepicker({
                format: 'dd-mm-yyyy',
        });
    });
</script>

<script type="text/javascript" src="<?php echo base_url();?>assets/newui/js/pilihTebusanObat.js"></script>

<script type="text/javascript">
    function setObat(detil_id,id_obat,batch,nama_obat,jmlObat,satObat,expObat)
    {
        $('.detil_id').val(detil_id);
        $('.id_obat').val(id_obat);
        $('.batch').val(batch);
        $('.nama_obat').val(nama_obat);
        $('.pesan').val(0);
        $('.jmlObat').val(jmlObat);
        $('.satObat').val(satObat);
        $('.expObat').val(expObat);
    }
    
    var needCount= Number('<?= $dataSebelumnya['JUMLAH_OBAT'] ?>');
    function selectObat(detil_id, id_obat, batch, nama_obat, expObat, pesan, jmlObat, satObat){
//        alert(detil_id+" "+id_obat+" "+batch+" "+nama_obat+" "+pesan+" "+jmlObat+" "+satObat+" "+expObat);
        if(needCount>=Number(pesan)){
            if(Number(jmlObat)<=Number(pesan)){
                alert("Permintaan Obat Melebihi Stok");
            }
            else {
                choose(detil_id, id_obat, batch, nama_obat, Number(pesan), satObat, expObat);
            }
        }
        else {
            alert("Pengiriman Obat Melebihi Jumlah Permintaan");
        }
    }
    
</script>