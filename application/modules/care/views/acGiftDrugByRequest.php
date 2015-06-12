<div class="row">
  <div class="col-lg-12">
      <section class="panel">
            <header class="panel-heading">
                <?php echo $jenisTransNama.' '; if($this->uri->segment(2, 0)=='lo') echo $ke_nama ?>
            </header>
            <div class="panel-body">
                <form id="kirimObat" class="form-horizontal bucket-form" method="post" action="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/addRequest' ?>">
                    <div class="form-group">
                        <div class="col-sm-8">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Kelola</th>
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
                                        <td class="<?= "nama_".$kodeObat ?>"><?= $detTrans[$i]['NAMA_OBAT'] ?></td> <!-- set class using kode obat -->
                                        <td><?= $detTrans[$i]['SATUAN'] ?></td>
                                        <td class="<?= 'jml_'.$kodeObat ?> totalJml"><?= $detTrans[$i]['JUMLAH_OBAT'] ?></td> <!-- set class using kode obat -->
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
                                <div class="col-sm-4">
                                    <input class="btn btn-info pull-left popUp" type="button" onclick="" value="Tambah Obat" data-toggle="modal" href="#myModal" />
                                </div>
                                <div class="col-sm-6">
                                    <input class="btn btn-primary pull-left" type="button" value="Setujui dan Kirim" onclick="submitObat();">
                                </div>
                                <br/><br/>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="col-sm-3 control-label">Tanggal</label>
                                    <div class="col-sm-9">
                                        <input name="transaksi" class="datepicker form-control form-control-inline default-date-picker"  size="16" type="text" value="<?= date('d-m-Y') ?>" />
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
                        </div>
                        <input type="hidden" name="flag" value="<?= $flag ?>">
                        <input type="hidden" name="jenis_transaksi" value="<?= $jenisTransId ?>">
                        <input type="hidden" name="jenis_lokasi" value="<?= $jenisLokasi ?>">
                        <input type="hidden" name="total_kodeObat" class="total_kodeObat" value="" /> <!-- total id obat -->
                        <input type="hidden" name="total_jumlahObat" class="total_jumlahObat" value="" /> <!-- total jumlah obat -->
                        <input type="hidden" name="transaksi_now" class="" value="<?= date('d-m-Y') ?>" /> <!-- tanggal transaksi -->
                    </div>
                </form>
            </div>
        </section>
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
                <table class="table table-striped table-hover table-bordered" id="editable-sample">         
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Obat</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Ubah</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php for($i=0; $i<sizeof($allObat); $i++): ?>
                        <?php
                            $kodeObat= $allObat[$i]['ID_OBAT'];  //set kode obat
                        ?>
                        <tr>
                            <td class="<?= "kode1_".$kodeObat ?>"><?= $allObat[$i]['ID_OBAT'] ?></td> <!-- set class using kode obat -->
                            <td class="<?= "nama1_".$kodeObat ?>"><?= $allObat[$i]['NAMA_OBAT'] ?></td> <!-- set class using kode obat -->
                            <td class=""><?= $allObat[$i]['SATUAN'] ?></td>
                            <td class="<?= 'jml1_'.$kodeObat ?>">0</td> <!-- set class using kode obat -->
                            <td class="<?= 'mge1_'.$kodeObat ?>"><a class="edit" href="javascript:;"><i class="fa fa-minus-square" style="color:red;"></i>Ubah</a></td>
                            <td></td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                </table>
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
        if (confirm("Setujui dan kirim obat ?")) {
            var requestObat= [];
            requestObat['id']= [];
            requestObat['jumlah']= [];
            $('#kirimObat .startHere').each(function() {
                var idObat = $(this).find(".idObat").html();
                var jmlObat = $(this).find(".totalJml").html();
                if(typeof idObat != "undefined" && typeof jmlObat != "undefined"){
                    console.log("ID:"+idObat);
                    console.log("JML:"+jmlObat);
                    requestObat['id'].push(idObat);
                    requestObat['jumlah'].push(jmlObat);
                }
            });
            var newTotalObat= JSON.stringify(requestObat['id'])
            var newJumlahObat= JSON.stringify(requestObat['jumlah'])
            $('.total_kodeObat').val(newTotalObat);
            $('.total_jumlahObat').val(newJumlahObat);
            $("#kirimObat").submit();
        }
        return false;
    }
</script>