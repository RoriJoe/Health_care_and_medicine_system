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
        <div class="col-md-12">
            <div class="panel panel-primary">
                <header class="panel-heading">
                    <h3 class="panel-title"><?= $jenisTransNama ?></h3>
                </header>
                <div class="panel-body">
                    <div class="col-sm-12 adv-table editable-table ">
                        <div class="clearfix">
                        </div>
                        <div class="space15"></div>
                        <table class="table table-striped table-hover table-bordered" id="editable-sample">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Transaksi</th>
                                <th>Dari</th>
                                <?php if ($this->uri->segment(4, 0)!='pemakaian'){ ?>
                                <th>Ke</th>
                                <?php } ?>
                                <th>Kelola</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php for($i=0; $i<sizeof($dataTrans); $i++): ?>
                                <tr>
                                    <td><?php $count=$i+1; echo $count; ?></td>
                                    <td><?= $dataTrans[$i]['TANGGAL_TRANSAKSI'] ?></td>
                                    <td><?php if(!empty($dataTrans[$i]['dari']))echo $dataTrans[$i]['dari']; else echo $dataTrans[$i]['NAMA_TRANSAKSI_SUMBER_LAIN']; ?></td>
                                    <?php if ($this->uri->segment(4, 0)!='pemakaian'){ ?>
                                    <td><?= $dataTrans[$i]['ke'] ?></td>
                                    <?php } ?>
                                    <td>
                                        <button class="btn btn-primary pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/showTrans/'.$dataTrans[$i]['ID_TRANSAKSI']  ?>';" >Detail</button>
                                    </td>
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Detail Obat</h4>
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
                                    <label>Jumlah <?= $tipeTrans ?></label>
                                    <input class="form-control pesan" type="text" name="pesan" value="" placeholder="Jumlah Permintaan">
                                    <input class="form-control jmlObat" type="hidden" name="jmlObat" value="" readonly="true">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input class="form-control satObat" type="text" name="satObat" value="" readonly="true">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-danger" type="button">Keluar</button>
            </div>
        </div>
    </div>
</div>
<!-- modal -->

<!--<script type="text/javascript" src="<?php echo base_url();?>assets/newui/js/pilihObatByRequest.js"></script>-->

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
    
    function selectObat(detil_id, id_obat, batch, nama_obat, expObat, pesan, jmlObat, satObat){
        choose(detil_id, id_obat, batch, nama_obat, Number(pesan), satObat, expObat);
    }
    
    var fields = [{
            name : 'NOMOR BATCH',
            type : 'string',
            filterable : true
        },{
            name : 'NAMA OBAT',
            type : 'string',
            filterable : true
        },{
//            name : 'STOK',
//            type : 'string',
//            filterable : true
//        },{
            name : 'SATUAN',
            type : 'string',
            filterable : true
        },{
            name : 'EXPIRED DATE',
            type : 'string',
            filterable : true
        },{
            name : 'KELOLA',
            type : 'string',
            filterable : true
        }
    ]
	
    function renderTable(){
        var jso;
        var data_pos = $("#oi1").val();
        var kapsul = {};
        kapsul.teksnya = {};
        kapsul.teksnya.tanda = $("#oi1").val();
        //alert(kapsul.teksnya.tanda);
        $.ajax({
            type : "POST",
            url : '<?php echo base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/searchRiwayat/'.$idUnit;  //id unit ?>',
            data: kapsul,
            success : function(dataCheck) {
//                alert(dataCheck);
                jso = dataCheck;
                setupPivot({
                    json : jso,
                    fields : fields,
                    rowLabels : ["NOMOR BATCH", "NAMA OBAT",/*"STOK",*/"SATUAN","EXPIRED DATE", "KELOLA"]
                })
                $('.stop-propagation').click(function(event) {
                    event.stopPropagation();
                });
            }
//            ,error: function (xhr, ajaxOptions, thrownError) {
//              alert(xhr.status);
//              alert(thrownError);
//              alert(xhr.responseText);
//            }
        });
    }
</script>