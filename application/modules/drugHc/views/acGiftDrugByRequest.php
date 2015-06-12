<div class="container">	
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <header class="panel-heading">
                <h3 class="panel-title"><?php echo $jenisTransNama.' '; if($this->uri->segment(2, 0)=='lo') echo $ke_nama ?></h3>
            </header>
            <div class="panel-body">
                <form id="kirimObat" class="form-horizontal bucket-form" method="post" action="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/addRequest' ?>">
                    <div class="form-group">
                        <div class="col-sm-8">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="display: none">id obat</th>
                                    <th>Batch</th>
                                    <th>Nama</th>
                                    <th>Satuan</th>
                                    <th>Sisa_Stok</th>
                                    <th>Pengiriman</th>
                                    <th>Expired</th>
                                    <th>Kelola</th>
                                </tr>
                                </thead>
                                <tbody class="obatBody">
                                <?php for($i=0; $i<sizeof($detTrans); $i++): ?>
                                    <?php
                                        $kodeObat= $detTrans[$i]['NOMOR_BATCH'];
                                        $count=$i+1;
                                        $bg= ($detTrans[$i]['STOK']<=$detTrans[$i]['JUMLAH_OBAT'])?'background:yellow':'';
                                        $font= ($detTrans[$i]['STOK']<=$detTrans[$i]['JUMLAH_OBAT'])?'color:red':'';
                                    ?>
                                    <tr class="startHere <?= "kode_".$kodeObat ?>" style="<?= $bg ?>" >
                                        <td style="display: none" class="idObat"><?= $detTrans[$i]['ID_OBAT'] ?></td>
                                        <td class="batch"><?= $detTrans[$i]['NOMOR_BATCH'] ?></td>
                                        <td class="<?= "nama_".$kodeObat ?>"><?= $detTrans[$i]['NAMA_OBAT'] ?></td> 
                                        <td><?= $detTrans[$i]['SATUAN'] ?></td>
                                        <td class="<?= 'sisaStok_'.$kodeObat ?> sisaStok" style="<?= $font ?>">
                                            <?= $detTrans[$i]['STOK'] ?>
                                        </td> 
                                        <td class="<?= 'jml_'.$kodeObat ?> totalJml" style="<?= $font ?>">
                                            <?= $detTrans[$i]['JUMLAH_OBAT'] ?>
                                        </td> 
                                        <td class=""><?= $detTrans[$i]['EXPIRED_DATE'] ?></td>
                                        <td class="<?= 'mge_'.$kodeObat ?>">
                                            <input type="button" class="btn-danger" onclick="deleteObat('<?= $kodeObat ?>')" value="Hapus" /> |
                                            <input type="button" class="btn-info" onclick="updateObat('<?= $kodeObat ?>')" value="Ubah" />
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="col-sm-3 control-label">Tanggal</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="transaksi" class="datepicker form-control default-date-picker"  size="16" value="<?= date('d-m-Y') ?>" />
                                        <span class="help-block">Pilih Tanggal</span>
                                    </div>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="col-sm-3 control-label">Dari</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="dari" value="<?= $dari_id ?>">
                                        <input type="text" class="form-control" value="<?= $dari_nama ?>" readonly="true">
                                    </div>
                                    <br/><br/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="col-sm-3 control-label">ke</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="ke" value="<?= $ke_id ?>">
                                        <input type="text" class="form-control" value="<?= $ke_nama ?>" readonly="true">
                                    </div>   
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-sm-4">
                                    <input class="btn btn-info pull-left popUp" type="button" onclick="" value="Tambah Obat" data-toggle="modal" href="#myModal" />
                                </div>
                                <div class="col-sm-6">
                                    <input class="btn btn-primary pull-left" type="button" value="Setujui dan Kirim" onclick="submitObat();">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="jenis_transaksi" value="<?= $jenisTransId ?>">
                        <input type="hidden" name="flag_konfirmasi" value="0">
                        <input type="hidden" name="id_rujukan" value="<?= $flag ?>">
                        <input type="hidden" name="total_kodeObat" class="total_kodeObat" value="" /> <!-- total id obat -->
                        <input type="hidden" name="total_batch" class="total_batch" value="" /><!-- total_batch -->
                        <input type="hidden" name="total_jumlahObat" class="total_jumlahObat" value="" /> <!-- total jumlah obat -->
                        <input type="hidden" name="transaksi_now" class="" value="<?= date('d-m-Y') ?>" /> <!-- tanggal transaksi -->
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
                <h4 class="modal-title">Daftar Pilihan Obat</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                <table class="table table-striped table-hover table-bordered" id="editable-sample">         
                    <thead>
                        <tr>
                            <th style="display: none">ID_DETIL</th>
                            <th style="display: none">Kode</th>
                            <th>No<br/>Batch</th>
                            <th>Nama Obat</th>
                            <th style="display: none">Satuan</th>
                            <th style="display: none" >Sisa</th>
                            <th style="" >Expired_Date<br/>(Y - m - d)</th>
                            <th>Jml Kirim</th>
                            <th>Kelola</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($allObat as $val): ?>
                        <?php
                            $kodeObat= $val->NOMOR_BATCH; 
                        ?>
                        <tr>
                            <td style="display: none" class="<?= "detilID_".$kodeObat ?>"><?= $val->ID_DETIL_TO ?></td>
                            <td style="display: none" class="<?= "kode1_".$kodeObat ?>"><?= $val->ID_OBAT ?></td>
                            <td class="<?= "batch_".$kodeObat ?>"><?= $val->NOMOR_BATCH ?></td> 
                            <td class="<?= "nama1_".$kodeObat ?>"><?= $val->NAMA_OBAT.' ('.$val->SATUAN.')' ?></td> 
                            <td style="display: none" class=""><?= $val->SATUAN ?></td>
                            <td style="display: none"  class="<?= "stok_".$kodeObat ?>"><?= $val->STOK ?></td>
                            <td style=""  class="<?= "expired_".$kodeObat ?>"><?= $val->EXPIRED_DATE ?></td> 
                            <td class="<?= 'jml1_'.$kodeObat ?>">0</td>
                            <td class="<?= 'mge1_'.$kodeObat ?>">
                                <a class="edit btn btn-danger fa fa-minus-square" href="javascript:;" style="color:white;"> Ubah</a>
                            </td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div></div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-danger" type="button">Keluar</button>
                <button data-dismiss="modal" class="btn btn-primary" type="button" onclick="drawObat()">Tambah</button>
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

<script>
    function deleteObat(id){
        var namaObat= $(".nama_"+id).text().toString();
        if (confirm("Hapus obat "+namaObat+"?")) {
            $('.kode_'+id).remove();
        }
        return false;
    }
    
    var tempJml;
    function updateObat(id){
        var currentJumlah= Number($('.jml_'+id).text());
        tempJml= currentJumlah;
        $('.jml_'+id).html('<input type="text" value="'+currentJumlah+'" class="newJml_'+id+'" name="newJml" />');
        $('.mge_'+id).html('<input type="button" class="btn-primary" onclick="saveObat(\''+id+'\')" value="Simpan" />');
    }
    
    function saveObat(id){
        var newJml= Number($('.newJml_'+id).val());
        var stok= Number($('.sisaStok_'+id).text());
        if(stok>newJml){
            $('.kode_'+id).removeAttr( 'style' );   //remove css highlight
            $('.jml_'+id).removeAttr( 'style' );    //remove red color font
            $('.sisaStok_'+id).removeAttr( 'style' );   //remove red color font
            $('.jml_'+id).html(newJml);
            $('.mge_'+id).html(
                '<input type="button" class="btn-danger" onclick="deleteObat(\''+id+'\')" value="Hapus" /> | '+
                '<input type="button" class="btn-info" onclick="updateObat(\''+id+'\')" value="Ubah" />'
            );
        }
        else {
            alert("Melebihi Stok");
            $('.jml_'+id).html(tempJml);
            $('.mge_'+id).html(
                '<input type="button" class="btn-danger" onclick="deleteObat(\''+id+'\')" value="Hapus" /> | '+
                '<input type="button" class="btn-info" onclick="updateObat(\''+id+'\')" value="Ubah" />'
            );
        }
        
    }
    
    function submitObat(){
        if (confirm("Setujui dan kirim obat ?")) {
            var requestObat= [];
            requestObat['id']= [];
            requestObat['jumlah']= [];
            requestObat['batch']= [];
            var flag= 0;
            $('#kirimObat .startHere').each(function() {
                var idObat = $(this).find(".idObat").html();
                var jmlObat = $(this).find(".totalJml").html();
                var batch= $(this).find(".batch").html();
                var sisa_stok= $(this).find(".sisaStok").html();
                if(typeof idObat != "undefined" && typeof jmlObat != "undefined"){
                    requestObat['id'].push(idObat);
                    requestObat['jumlah'].push(Number(jmlObat));
                    requestObat['batch'].push(batch);
                    if(Number(sisa_stok)<=Number(jmlObat)){
                        flag= 1;
                    }
                }
            });
            if(flag!=1){
                var newTotalObat= JSON.stringify(requestObat['id'])
                var newJumlahObat= JSON.stringify(requestObat['jumlah'])
                var newBatch= JSON.stringify(requestObat['batch'])
                $('.total_kodeObat').val(newTotalObat);
                $('.total_jumlahObat').val(newJumlahObat);
                $('.total_batch').val(newBatch);
                $("#kirimObat").submit();
            }
            else {
                alert("Terdapat Pengiriman Obat yang Melebihi Stok");
            }
        }
        return false;
    }
</script>