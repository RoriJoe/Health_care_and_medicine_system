
<div class="container">	
    <div class="row">
        <section>
            <div class="col-md-3">
                <div class="panel panel-primary" >
                    <div class="panel-heading">
                        <h3 class="panel-title">Notifikasi</h3>
                    </div>
                    <div class="panel-body" style="height: 700px; overflow-y: scroll">
                    <?php
                    if (isset($notifStok)) {
                        foreach ($notifStok as $sisaStok) {
                            $mydate2 = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
                            $mydate1 = DateTime::createFromFormat('Y-m-d', $sisaStok['EXPIRED_DATE']);
                            if (diffInMonths($mydate1, $mydate2) <= 1) {
                                echo '<div class="alert alert-danger"><strong>Peringatan!</strong><i> ' . $sisaStok['NAMA_OBAT'] . '</i> Batch ' .
                                $sisaStok['NOMOR_BATCH'] . ' kadaluarsa pada ' . $mydate1->format('d-M-Y') . ' </div>';
                            }
                            if($sisaStok['STOK_OBAT_SEKARANG']<=100){
                                echo '<div class="alert alert-warning"><strong>Perhatian!</strong> Stok obat <i>' . $sisaStok['NAMA_OBAT'] . '</i> Batch ' .
                                $sisaStok['NOMOR_BATCH'] . ' mulai menipis.</div>';
                            }
                        }
                    }
                    ?>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <!-- Error Message -->  
                <?php if (isset($error_msg)) : ?>

                    <?php if ($error_msg == "success") : ?>

                        <div class="alert alert-success fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong>Berhasil!</strong>
                        </div>
                    <?php elseif ($error_msg == "failed") : ?>
                        <div class="alert alert-block alert-danger fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong>Gagal!</strong>
                        </div>

                    <?php endif;
                    $error_msg = null; ?>
                <?php endif; ?>                      
                <!-- end of error MEssage; -->

                <section class="slice bg-2 p-15">
                    <h3><?= $jenisTrans[0]['NAMA_JENIS'] ?></h3>
                </section>

                <div class="row">
                    <form class="form-light padding-15" action="<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2); ?>/addDrugsOut/<?= $jenisTrans[0]['ID_JENISTRANSAKSI'] ?>" method="post">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="inputPuskesmas">Pilih Tujuan Pengiriman</label>
                                <select required class="form-control" id="inputPuskesmas" name="inputPuskesmas" onchange="cekInputPuskesmas(this.value)">
                                    <?php foreach ($allUnit as $row): ?>
                                        <option value="<?php echo $row['ID_UNIT']; ?>"><?php echo $row['NAMA_UNIT']; ?></option>
                                    <?php endforeach; ?>                
                                </select>
                            </div>
                            <div class="col-md-12" id="divinputSumberLain" hidden="hidden">
                                <input class="form-control" id="inputSumberLain" name="inputSumberLain" placeholder="Masukkan Tujuan Lain selain Puskesmas">
                            </div>
                        </div> 
                        <br>

                        <div class="col-md-12">
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <span class="hide-on-print" id="pivot-detail"></span>
                                    <div id="results"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Detail Pengiriman Obat</label>
                                            <table class="table table-striped table-comparison table-responsive">
                                                <thead>
                                                    <tr>				
                                                        <th>NAMA OBAT</th>			
                                                        <th>NO. BATCH</th>
                                                        <th>TGL. KADALUARSA</th>
                                                        <th>JUMLAH</th>
                                                        <th>HAPUS</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodyDetailPenambahan">

                                                </tbody>
                                            </table> 
                                        </div>               
                                    </div>						
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pull-right"> 									
                                        <div hidden="hidden" class="form-group">
                                            <label for="inputTransaksi" >Tanggal Transaksi</label>
                                            <input required id="inputTransaksi" name="inputTransaksi" class="form-control form-control-inline input-medium datepicker" value="<?php date_default_timezone_set("Asia/Jakarta"); echo date('d-m-Y'); ?>" type="text">                          
                                        </div>
                                        <button disabled="disabled" id="submitKulak" class="btn btn-two pull-right" type="submit">Selesai</button>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                &nbsp;
                <br>
                <br>
                <br>
                <br> 
                <br>
                <br>    
            </div>	
        </section>
    </div>
</div>

<!-- Pop up add -->      
<div style="display: none;" class="modal fade in" id="addStocksModal" tabindex="-1" role="dialog" aria-labelledby="addStocksModal" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Obat Yang Dikirim</h4>
            </div>
            <div class="modal-body">
                <div class="position-center">
                    <form id="FormTambahObatOut" class="form-light padding-15" method="POST">
                        <div hidden="hidden" class="form-group">
                            <label for="inputNomor" class="col-lg-4 col-sm-4 control-label">Nomor Obat</label>
                            <div class="col-lg-8">
                                <input readonly class="form-control" id="inputNomor"  name="inputNomor" type="text">             
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputNama" class="col-lg-4 col-sm-4 control-label">Nama Obat</label>
                            <div class="col-lg-8">
                                <input readonly class="form-control" id="inputNama" name="inputNama" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputJumlah" class="col-lg-4 col-sm-4 control-label">Jumlah Obat</label>
                            <div class="col-lg-8">
                                <input required placeholder="Masukkan Jumlah Obat" class="form-control" id="inputJumlah" name="inputJumlah" type="number">     
                                <label id="inputRekomendasi">Rekomendasi: </label>
                            </div>				
                        </div>              			
                        <div class="form-group">
                            <input type="text" id="selected" name="selected" hidden="hidden"/> 
                            <button data-dismiss="modal" class="btn btn-danger col-lg-offset-8" id="closemodal" type="button">Tutup</button>
                            <button class="btn btn-primary" type="submit">Tambah</button>
                        </div>			
                    </form>
                    <div id="alertPenambahan"></div>
                </div>
            </div>
        </div>
    </div>
</div>                            
<!-- Eof add --> 

<script>
    function toAddStocksModal(id, name, maxjumlah) {
        $("#alertPenambahan").html('');
        $('#inputNomor').val(id);
        $('#inputNama').val(name);
        $('#inputJumlah').attr('max', maxjumlah);
        $('#inputJumlah').attr('min', 1);
        $('#inputJumlah').val('');

        var id_puskesmas = $('#inputPuskesmas').val();
        ShowRecommendation(id_puskesmas, id);
    }

    function hapusObatTerpilihOK(idobat, nomorbatch) {
        $('#bodyDetailPenambahan').find('#' + idobat + nomorbatch).remove();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2); ?>/removeDrugsDetailOK",
            data: {id_obat: idobat, nomor_batch: nomorbatch},
            success: function() {
            },
            error: function() {
                alert('Error!');
            }
        });

        if ($('#bodyDetailPenambahan').html() == '') {
            $('#submitKulak').attr('disabled', 'disabled');
        }
        else {
            $('#submitKulak').removeAttr('disabled');
        }
    }

    $("#FormTambahObatOut").submit(function(event)
    {
        $("#alertPenambahan").html('');
        var ale = '<div class="alert alert-warning fade in"><button data-dismiss="alert" class="close close-sm" 		type="button"><i class="fa fa-times"></i></button>Tunggu Sebentar</div>';
        $("#alertPenambahan").append(ale);

        $("#bodyDetailPenambahan").html('');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2); ?>/addDrugsDetailOK",
            data: {inputObat: $('#inputNomor').val(), inputJumlah: $('#inputJumlah').val()},
            success: function(response) {
                // alert (response);

                var objData = eval(response);
                console.log(objData);
                var content;

                $.each(objData, function(index, value) {
                    content += '<tr id="' + value.ID_OBAT + value.NOMOR_BATCH + '"><td>' + value.NAMA_OBAT + '</td>';
                    content += '<td>' + value.NOMOR_BATCH + '</td>';
                    content += '<td>' + value.EXPIRED_DATE + '</td>';
                    content += '<td>' + value.STOK_OBAT_SEKARANG + '</td>';
                    content += '<td><a class="btn btn-xs btn-danger" style="color: white" onclick ="hapusObatTerpilihOK(\'' + value.ID_OBAT + '\', \'' + value.NOMOR_BATCH + '\')"><i class="fa fa-cut"></i></a></td></tr>';
                });
                $("#bodyDetailPenambahan").append(content);

                $("#alertPenambahan").html('');
                var ale = '<div class="alert alert-success fade in"><button data-dismiss="alert" class="close close-sm" 		type="button"><i class="fa fa-times"></i></button>Penambahan Berhasil</div>';
                $("#alertPenambahan").append(ale);

                $('#closemodal').click();
                if ($('#bodyDetailPenambahan').html() == '') {
                    $('#submitKulak').attr('disabled', 'disabled');
                }
                else {
                    $('#submitKulak').removeAttr('disabled');
                }
            }
//            ,error: function (xhr, ajaxOptions, thrownError) {
//              alert(xhr.status);
//              alert(thrownError);
//              alert(xhr.responseText);
//            }
        });

        event.preventDefault();
    });

    var fields = [
        {
            name: 'NOMOR',
            type: 'string',
            filterable: true
        }, {
            name: 'NOMOR LPLPO',
            type: 'string',
            filterable: true
        }, {
            name: 'NAMA OBAT',
            type: 'string',
            filterable: true
        }, {
            name: 'TOTAL',
            type: 'string',
            filterable: true
        }, {
            name: 'PILIH',
            type: 'string',
            filterable: false
        }
    ];

    function renderTable()
    {
        var jso;

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2); ?>/showAllDrugsGOPOut',
            success: function(dataCheck) {
                // alert(dataCheck);

                jso = dataCheck;
                setupPivot({
                    json: jso,
                    fields: fields,
                    rowLabels: ["NOMOR", "NOMOR LPLPO", "NAMA OBAT", "TOTAL", "PILIH"]
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

    $(function() {
        renderTable();
        // ShowButtonRecom ();
        $(".datepicker").datepicker({
            format: 'dd-mm-yyyy',
        });
    });

    function ShowButtonRecom() {
        if ($('#inputPuskesmas').val() == '')
            return;

        var id_unit = $('#inputPuskesmas').val();
        $('#ButtonRecom').html('');
        var content = '';
        content += '<a target="_blank" class="btn btn-warning" style="color: white;" href="showRecommendation/' + id_unit + '"><strong>Lihat Rekomendasi</strong></a>';
        $('#ButtonRecom').append(content);
    }

    function ShowRecommendation(id_pus, id_obat) {
        // alert(id_pus + id_obat);
        if (!id_pus) {
            $("#inputRekomendasi").html('Rekomendasi : Tutup dan Pilih Gudang Obat Dahulu');
            return;
        }
//        $.ajax({
//            type: "POST",
//            url: "<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2); ?>/showDataRecom",
//            data: {id: id_pus, id_obat: id_obat},
//            success: function(retVal) {
//                // alert (retVal);
//                if (retVal != 'null') {
//                    var dataObj = JSON.parse(retVal);
//                    if (dataObj.REKOMENDASI > 0) {
//                        $("#inputRekomendasi").html('Rekomendasi: ' + dataObj.REKOMENDASI);
//                    }
//                    else
//                        $("#inputRekomendasi").html('Rekomendasi: Tidak Bisa Ditentukan');
//                }
//                else {
//                    $("#inputRekomendasi").html('Rekomendasi: Belum Ada');
//                }
//            },
//            error: function() {
//                alert('Error!');
//            }
//        });
    }

    function cekInputPuskesmas(value) {
        if (value == -1) {
            $("#divinputSumberLain").show();
        }
        else {
            $("#divinputSumberLain").hide();
        }
    }

</script> 

<style>
    .datepicker {
        z-index: 100000;
    }
</style>
