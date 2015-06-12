<div class="container">	
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <header class="panel-heading">
                    <h3 class="panel-title"><?php echo 'Penerimaan Obat dari '.$dari_nama.' ke '.$ke_nama ?></h3>
                </header>
                <div class="panel-body">
                    <form id="kirimObat" class="form-horizontal bucket-form" method="post" action="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/addRequest' ?>">
                        <div class="form-group">
                            <div class="col-sm-8">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>No Batch</th>
                                        <th>Nama Obat</th>
                                        <th>Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Expired</th>
                                    </tr>
                                    </thead>
                                    <tbody class="obatBody">
                                    <?php for($i=0; $i<sizeof($detTrans); $i++): ?>
                                        <?php
                                            $kodeObat= $detTrans[$i]['ID_OBAT'];  //set kode obat
                                            $count=$i+1;
                                        ?>
                                        <tr class="startHere <?= "kode_".$kodeObat ?>">
                                            <td style="display: none" class="idObat"><?= $kodeObat ?></td>
                                            <td class="batch"><?= $detTrans[$i]['NOMOR_BATCH'] ?></td>
                                            <td class="<?= "nama_".$kodeObat ?>"><?= $detTrans[$i]['NAMA_OBAT'] ?></td> 
                                            <td><?= $detTrans[$i]['SATUAN'] ?></td>
                                            <td class="<?= 'jml_'.$kodeObat ?> totalJml"><?= $detTrans[$i]['JUMLAH_OBAT'] ?></td> 
                                            <td class=""><?= $detTrans[$i]['EXPIRED_DATE'] ?></td>
                                        </tr>
                                    <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label pull-left">Tanggal Penerimaan</label>
                                        <div class="col-sm-7">
                                            <input name="transaksi" class="form-control"  size="16" type="text" value="<?= date('d-m-Y') ?>" readonly="true"/>
                                            <span class="help-block">Pilih Tanggal</span>
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Dari</label>
                                        <div class="col-sm-7">
                                            <input type="hidden" name="dari" value="<?= $dari_id ?>">
                                            <input type="text" class="form-control" value="<?= $dari_nama ?>" readonly="true">
                                        </div>
                                        <br/><br/>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">ke</label>
                                        <div class="col-sm-7">
                                            <input type="hidden" name="ke" value="<?= $ke_id ?>">
                                            <input type="text" class="form-control" value="<?= $ke_nama ?>" readonly="true">
                                        </div>   
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input class="btn btn-primary pull-left" type="button" value="Setujui dan Terima" onclick="submitObat();">
                                        </div>
                                    </div>
                                    </div>
                                    <input type="hidden" name="jenis_transaksi" value="<?= $jenisTransId ?>">
                                    <input type="hidden" name="flag_konfirmasi" value="1">
                                    <input type="hidden" name="id_rujukan" value="<?= $flag ?>">
                                    <input type="hidden" name="total_kodeObat" class="total_kodeObat" value="" /> <!-- total id obat -->
                                    <input type="hidden" name="total_batch" class="total_batch" value="" /><!-- total_batch -->
                                    <input type="hidden" name="total_jumlahObat" class="total_jumlahObat" value="" /> <!-- total jumlah obat -->
                                    <input type="hidden" name="transaksi_now" class="" value="<?= date('d-m-Y') ?>" /> <!-- tanggal transaksi -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $( ".datepicker" ).datepicker({
                format: 'dd-mm-yyyy',
        });
    });
</script>

<script>
    function deleteObat(idObat){
        var namaObat= $(".nama_"+idObat).text().toString();
        if (confirm("Hapus obat "+namaObat+"?")) {
            $('.kode_'+idObat).remove();
        }
        return false;
    }
    
    function updateObat(idObat){
        var currentJumlah= $('.jml_'+idObat).text();
        $('.jml_'+idObat).html('<input type="text" value="'+currentJumlah+'" class="newJml_'+idObat+'" name="newJml" />');
        $('.mge_'+idObat).html('<input type="button" class="btn-primary" onclick="save('+idObat+')" value="Simpan" />');
    }
    
    function save(idObat){
        var newJml= Number($('.newJml_'+idObat).val());
        $('.jml_'+idObat).html(newJml);
        $('.mge_'+idObat).html(
        '<input type="button" class="btn-danger" onclick="deleteObat(\''+idObat+'\')" value="Hapus" /> | '+
        '<input type="button" class="btn-info" onclick="updateObat(\''+idObat+'\')" value="Ubah" />');
    }
    
    function submitObat(){
        if (confirm("Setujui dan terima obat ?")) {
            var requestObat= [];
            requestObat['id']= [];
            requestObat['jumlah']= [];
            requestObat['batch']= [];
            $('#kirimObat .startHere').each(function() {
                var idObat = $(this).find(".idObat").html();
                var jmlObat = $(this).find(".totalJml").html();
                var batch= $(this).find(".batch").html();
                if(typeof idObat != "undefined" && typeof jmlObat != "undefined"){
                    console.log("ID:"+idObat);
                    console.log("JML:"+jmlObat);
                    console.log("batch:"+batch);
                    requestObat['id'].push(idObat);
                    requestObat['jumlah'].push(jmlObat);
                    requestObat['batch'].push(batch);
                }
            });
            var newTotalObat= JSON.stringify(requestObat['id'])
            var newJumlahObat= JSON.stringify(requestObat['jumlah'])
            var newBatch= JSON.stringify(requestObat['batch'])
            $('.total_kodeObat').val(newTotalObat);
            $('.total_jumlahObat').val(newJumlahObat);
            $('.total_batch').val(newBatch);
            $("#kirimObat").submit();
        }
        return false;
    }
</script>