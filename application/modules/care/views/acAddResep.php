<div class="container">
    <div class="row">
      <div class="col-lg-12">
            <div class="panel panel-primary">
                <header class="panel-heading">
                    <h3 class="panel-title"><?= 'Resep Obat '.$namaPasien[0]['NAMA_PASIEN'] ?></h3>
                </header>
                <div class="panel-body">
                    <div class="col-sm-4">
                        <form class="form-inline">
                            <div class="input-group" style="margin-bottom:20px;">
                                <input id="oi1" type="text" class="form-control" placeholder="Kata Kunci Utama">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" onclick="renderTable()" type="button">Pencarian Obat</button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <br/>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <ul class="nav nav-pills">
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Filter Fields <b class="caret"></b> </a>
                                    <ul class="dropdown-menu stop-propagation" style="overflow:auto;max-height:450px;padding:10px;">
                                        <div id="filter-list"></div>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Row Label Fields <b class="caret"></b> </a>
                                    <ul class="dropdown-menu stop-propagation" style="overflow:auto;max-height:450px;padding:10px;">
                                        <div id="row-label-fields"></div>
                                    </ul>
                                </li>
                            </ul>
                            <hr/>
                            <h3 class="oxigenfontblue">Hasilnya</h3>
                            <span class="hide-on-print" id="pivot-detail"></span>
                            <hr/>
                            <div style="" id="results"></div>
                        </div>
                    </div>
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
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th>Jumlah_sehari</th>
                            <th>Lama_hari</th>
                            <th>Signa</th>
                            <th>Deskripsi</th> <!-- Detail obat (Jumlah dan Deskripsi Obat) -->
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="list_obat">
                        </tbody>
                    </table>
                    <br/><br/>
                    <form class="form-horizontal bucket-form" method="post" action="<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/addResepPasien' ?>">
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal Resep</label>
                            <div class="col-sm-3">
                                <input name="transaksi" class="datepicker form-control form-control-inline default-date-picker"  size="16" type="text" value="<?= date('d-m-Y') ?>" />
                                <span class="help-block">Pilih Tanggal</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3"></label>
                            <div class="col-sm-3">
                                <input type="hidden" name="dari" value="<?= $dari_id ?>">
                                <input type="hidden" name="ke" value="<?= $ke_id ?>">
                                <input type="hidden" name="jenis_transaksi" value="16"> <!-- id jenis transaksi Resep Obat Pasien -->
                                <input type="hidden" name="flag_konfirmasi" value="0" /> <!-- flag=0 belum ditebus -->
                                <input type="hidden" name="id_riwayat_rm" value="<?= $this->uri->segment(5, 0) ?>" /> <!-- id riwayat -->
                                <input type="hidden" name="total_kodeObat" class="total_kodeObat" value="" /> <!-- total id obat -->
                                <input type="hidden" name="total_jumlahSehari" class="total_jumlahSehari" value="" /> <!-- total jumlah obat Sehari -->
                                <input type="hidden" name="total_lamaHari" class="total_lamaHari" value="" /> <!-- total lama hari -->
                                <input type="hidden" name="total_deskripsiObat" class="total_deskripsiObat" value="" /> <!-- total deskripsi -->
                                <input type="hidden" name="total_signa" class="total_signa" value="" /> <!-- tanggal transaksi -->
                                <input type="hidden" name="transaksi_now" class="" value="<?= date('d-m-Y') ?>" /> <!-- tanggal transaksi -->
                                <input class="btn btn-primary pull-right" type="submit" value="Buat Resep" name="submit">
                            </div>
                        </div>
                    </form>
                </div>
          </div>
      </div>
    </div>
</div>

<!-- Modal Select Obat -->
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
                        <input class="form-control kodeObat" type="hidden" name="kodeObat" value="" readonly="true">
                        <div class="form-group">
                            <label>Nama Obat</label>
                            <input class="form-control namaObat" type="text" name="namaObat" value="" readonly="true">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input class="form-control satuanObat" type="text" name="satuanObat" value="" readonly="true">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Signa</label>
                                    <input class="form-control signa" type="text" name="signa" value="" placeholder="Signa">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jumlah Sehari</label>
                                    <input class="form-control jumlahSehari" type="text" name="jumlahSehari" value="" placeholder="Jumlah Sehari">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Lama Hari</label>
                                    <input class="form-control lamaHari" type="text" name="lamaHari" value="" placeholder="Lama Hari">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Obat</label>
                            <textarea class="form-control deskripsiObat" id="message" name="deskripsiObat" placeholder="Deskripsi Obat" style="height:100px;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-danger" type="button">Keluar</button>
                <button data-dismiss="modal" class="btn btn-primary" type="button" onclick="selectObat($('.kodeObat').val(), $('.namaObat').val(), $('.satuanObat').val(), $('.jumlahSehari').val(), $('.lamaHari').val(), $('.deskripsiObat').val(), $('.signa').val())">Tambah</button>
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
    
    function setObat(id_obat,nama_obat,satObat){
        $('.kodeObat').val(id_obat);
        $('.namaObat').val(nama_obat);
        $('.satuanObat').val(satObat);
        $('.jumlahSehari').val('');
        $('.lamaHari').val('');
        $('.deskripsiObat').val('');
        $('.signa').val('');
    }
    
    function selectObat(id_obat, namaObat, satuanObat, jumlahSehari, lamaHari, deskripsiObat, signa){
//        alert( deskripsiObat+" "+signa);
//        var totalPermintaan= Number(jumlahSehari)*Number(lamaHari);
//        if(Number(stok)<=Number(totalPermintaan)){
//            alert("Permintaan Resep Obat Melebihi Stok Apotik!");
//        }
//        else {
            choose(id_obat, namaObat, jumlahSehari, satuanObat, lamaHari, deskripsiObat, signa);
//        }
    }
</script>

<script type="text/javascript" src="<?php echo base_url();?>assets/newui/js/pilihObatResep.js"></script>
<script type="text/javascript">
    var fields = [{
            name : 'NOMOR',
            type : 'string',
            filterable : true
        },{
            name : 'NAMA OBAT',
            type : 'string',
            filterable : true
        },{
            name : 'SATUAN',
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
        $.ajax({
            type : "POST",
            url : '<?php echo base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/searchObatMaster'; ?>',
            data: kapsul,
            success : function(dataCheck) {
//                alert(dataCheck);
                jso = dataCheck;
                setupPivot({
                    json : jso,
                    fields : fields,
                    rowLabels : ["NOMOR", "NAMA OBAT", "SATUAN", "KELOLA"]
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

<!-- Modal2 for DETAIL -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                            <label>Nama Obat</label>
                            <input class="form-control namaObat2" type="text" name="namaObat2" value="" readonly="true">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input class="form-control satuanObat2" type="text" name="satuanObat2" value="" readonly="true">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Signa</label>
                                    <input class="form-control signa2" type="text" name="signa2" value="" readonly="true">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jumlah Sehari</label>
                                    <input class="form-control jumlahSehari2" type="text" name="jumlahSehari2" value="" placeholder="Jumlah Sehari" readonly="true">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Lama Hari</label>
                                    <input class="form-control lamaHari2" type="text" name="lamaHari2" value="" placeholder="Lama Hari" readonly="true">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Obat</label>
                            <textarea class="form-control deskripsiObat2" id="message" name="deskripsiObat2" placeholder="" style="height:100px;" readonly="true"></textarea>
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
<!-- modal2 -->