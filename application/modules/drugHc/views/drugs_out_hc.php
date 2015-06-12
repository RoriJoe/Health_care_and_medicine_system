<div class="container">	
    <div class="row">
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
            <section class="slice bg-2 p-15">
                <h3><?= $jenisTrans[0]['NAMA_JENIS'] ?></h3>
            </section>
            <br>
            <!-- Error Message -->  
            <?php if (isset($error_msg)) : 
                if ($error_msg == "success") : ?>
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
                $error_msg = null;
            endif; ?>
            <div class="row" id="detail">
                <form class="form-light padding-15" action="<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2); ?>/addDrugsOutHC/<?= $jenisTrans[0]['ID_JENISTRANSAKSI'] ?>" method="post">
                    <div class="col-md-12">
                        <div class="form-group">				
                            <div id="tabelDetailRequest">
                            </div>
                            <div id="peringatan">
                            </div>
                        </div>
                    </div>
                    <input id="idObat" name="idObat" type="hidden"/>
                    <input id="jmlObat" name="jmlObat" type="hidden"/>
                    <div class="col-md-3 pull-right">
                        <div hidden="hidden" class="form-group">
                            <label for="inputTransaksi">Tanggal Transaksi</label>
                            <input id="inputTransaksi" name="inputTransaksi" class="form-control datepicker" size="16" value="<?php date_default_timezone_set("Asia/Jakarta"); echo date('d-m-Y'); ?>" type="text">
                            <input id="inputIdTransaksi" name="inputIdTransaksi" type="text" value="<?= $this->uri->segment(5); ?>">
                            <input id="inputUnit" name="inputUnit" type="text" value="<?= $this->uri->segment(6); ?>">
                        </div>
                        <button id="kirimCITO" class="btn btn-two pull-right" type="submit">Kirim</button><br/><br/><br/><br/>
                    </div>
                </form>
            </div>
        </div>  
    </div>
</div>

<script>
    var idTransaksi= <?= $this->uri->segment(5) ?>;
    $(function () {
        showDetailRequest(idTransaksi);
    });
    
    var arrayFlagObatAdaStok= [];
    var arrayFlagObatKurangStok= [];
    var nama_obat= [];
    var idObat= [];
    var jmlObat= [];
    sessionStorage.clear();
    function showDetailRequest(value) {
        var transid = value;
        $("#tabelDetailRequest").html('');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2).'/showDetailRequest'; ?>",
            data: {id: value},
            success: function(data) {
//                 alert(data);
                var objData = eval(data);
                var content = '<br><label for="">Detail Permintaan Obat</label><table class="table table-striped table-comparison table-responsive"><thead><tr><th>KODE OBAT</th><th>NAMA OBAT</th><th>SATUAN</th><th>STOK SEKARANG</th><th>JUMLAH </th><th>KELOLA</th></thead><tbody id="bodyChoosed">';
//                var flagAdaDiStok = false;
                var flagKurangDariStok = false;
                $.each(objData, function(index, value) {
                    // obat tidak ada
                    nama_obat[value.ID_OBAT]= value.NAMA_OBAT;
                    idObat.push(value.ID_OBAT);
                    jmlObat.push(value.JUMLAH_OBAT);
                    $("#idObat").val(idObat);
                    $("#jmlObat").val(jmlObat);
                    sessionStorage["nama_obat"] = JSON.stringify(nama_obat);
                    if (value.KODE_OBAT) {
                        arrayFlagObatAdaStok[value.ID_OBAT]= false;
                        sessionStorage["ada"] = JSON.stringify(arrayFlagObatAdaStok);
                    } else {
                        arrayFlagObatAdaStok[value.ID_OBAT]= true;
                        sessionStorage["ada"] = JSON.stringify(arrayFlagObatAdaStok);
                    }

                    if (parseInt(value.JUMLAH_OBAT) <= parseInt(value.TOTAL)) {
                        arrayFlagObatKurangStok[value.ID_OBAT]= false;
                        sessionStorage["kurang"] = JSON.stringify(arrayFlagObatKurangStok);
                    } else {
                        arrayFlagObatKurangStok[value.ID_OBAT]= true;
                        sessionStorage["kurang"] = JSON.stringify(arrayFlagObatKurangStok);
                    }
                   
                    var kodeObat = "", satuan = "", total = "";
                    if (value.KODE_OBAT)
                        kodeObat = value.KODE_OBAT;
                    if (value.SATUAN)
                        satuan = value.SATUAN;
                    if (value.TOTAL)
                        total = value.TOTAL;

                    content += '<tr id="obat-' + value.ID_OBAT + '">';
                    content += '<td>' + kodeObat + '</td>';
                    content += '<td>' + value.NAMA_OBAT + '</td>';
                    content += '<td>' + satuan + '</td>';
                    content += '<td><input id="stok-' + value.ID_OBAT + '" readonly class="form-control" value="' + total + '"></td>';
                    content += '<td><form><input id="total-' + value.ID_OBAT + '" readonly class="form-control" value="' + value.JUMLAH_OBAT + '"></td>';
                    if (!arrayFlagObatAdaStok[value.ID_OBAT]) {
                        content += '<td><input type="button" id="ubah-' + value.ID_OBAT + '" class="btn btn-warning" onclick="editJumlah(' + value.ID_OBAT + ')" value="UBAH"><input type="button" style="display: none" id="simpan-' + value.ID_OBAT + '" class="btn btn-info" onclick="simpanJumlah(' + value.ID_OBAT + ',' + transid + ')" value="SIMPAN"><input type="button" class="btn btn-danger" onclick="hapusJumlah(' + value.ID_OBAT + ',' + transid + ')" value="HAPUS"></form></td>';
                    }
                    else {
                        content += '<td><input type="button" class="btn btn-danger" onclick="hapusJumlah(' + value.ID_OBAT + ',' + transid + ')" value="HAPUS"></form></td>';
                    }

                    content += '</td></tr>';
                });
                content += '</tbody></table>';
                $("#tabelDetailRequest").append(content);
                $("#detail").show();
                
                var temp=  JSON.parse(sessionStorage["nama_obat"]);
                for (x in temp){
                    if(temp[x]!=null) nama_obat[x]=temp[x];
                }

                var temp=  JSON.parse(sessionStorage["ada"]);
                for (x in temp){
                    if(temp[x]!=null) arrayFlagObatAdaStok[x]=temp[x];
                }

                var temp=  JSON.parse(sessionStorage["kurang"]);
                for (x in temp){
                    if(temp[x]!=null) arrayFlagObatKurangStok[x]=temp[x];
                }
                    
                warningObat();
                
            }
//            ,error: function (xhr, ajaxOptions, thrownError) {
//              alert(xhr.status);
//              alert(thrownError);
//              alert(xhr.responseText);
//            }
        });
    }

    function warningObat(){
        var flag=0;
        var flag1=0;
        for (x in arrayFlagObatAdaStok){
            if(arrayFlagObatAdaStok[x]==true) flag=flag+1;
        }
        for (x in arrayFlagObatKurangStok){
            if(arrayFlagObatKurangStok[x]==true) flag1=flag1+1;
        }
        
        $("#peringatan").html('');
        for (x in arrayFlagObatAdaStok){
            if (arrayFlagObatAdaStok[x]) {
                $("#peringatan").append("<div class='alert alert-danger'>Obat "+nama_obat[x]+" tidak dapat ditemukan</div>");
                $("#kirimCITO").attr("disabled", true);
            }
            else {
                if(flag<=0) $("#kirimCITO").removeAttr("disabled");
            }
        }
        
        for (x in arrayFlagObatKurangStok){
            if (arrayFlagObatKurangStok[x]) {
                $("#peringatan").append("<div class='alert alert-warning'>Jumlah permintaan "+nama_obat[x]+" melebihi jumlah stok</div>");
                $("#kirimCITO").attr("disabled", true);
            }
            else {
                if(flag1<=0) $("#kirimCITO").removeAttr("disabled");
            }
        }
    }

    function editJumlah(idobat) {
        $('#total-' + idobat).attr('readonly', false);
        $('#ubah-' + idobat).hide();
        $('#simpan-' + idobat).show();
    }
    
    function simpanJumlah(idobat, idtrans) {
        $('#total-' + idobat).attr('readonly', true);
        $('#ubah-' + idobat).show();
        $('#simpan-' + idobat).hide();

        var index = idObat.indexOf(String(idobat));
        jmlObat[index]= Number($('#total-' + idobat).val());
        $("#jmlObat").val(jmlObat);
        if(Number($('#total-' + idobat).val()) < Number($('#stok-' + idobat).val())){
            arrayFlagObatKurangStok[idobat]=false;
        }
        else {
            arrayFlagObatKurangStok[idobat]=true;
        }
        warningObat();
        
    }

    function hapusJumlah(idobat, idtrans) {
        $('#total-' + idobat).attr('readonly', true);
        $('#ubah-' + idobat).show();
        $('#simpan-' + idobat).hide();
        $('#bodyChoosed').find('#obat-' + idobat).remove();
        arrayFlagObatKurangStok[idobat]=false;
        arrayFlagObatAdaStok[idobat]=false;
        warningObat();
        var index = idObat.indexOf(String(idobat));
        idObat.splice(index,1)
        jmlObat.splice(index,1)
        $('#idObat').val(idObat);
        $('#jmlObat').val(jmlObat);
    }

    $(function() {
        $(".datepicker").datepicker({
            format: 'dd-mm-yyyy',
        });
    });
</script>

<style>
    .datepicker {
        z-index: 100000;
    }
</style>
