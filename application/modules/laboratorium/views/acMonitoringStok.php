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
//                            if($sisaStok['STOK_OBAT_SEKARANG']<=100){
//                                echo '<div class="alert alert-warning"><strong>Perhatian!</strong> Stok obat <i>' . $sisaStok['NAMA_OBAT'] . '</i> Batch ' .
//                                $sisaStok['NOMOR_BATCH'] . ' mulai menipis.</div>';
//                            }
                        }
                    }
                    
                    if (isset($notifMinStok)) {
                        foreach ($notifMinStok as $sisaStok) {
                            if ($sisaStok['STOK_MIN'] <= 30) {
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
          <div class="panel panel-primary">
              <header class="panel-heading">
                  <h3 class="panel-title"><?= 'Daftar Stok '.$namaUnit.' Sekarang' ?></h3>
              </header>
              <div class="panel-body">
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
</div>

<script>
    var fields = [{
            name : 'NOMOR BATCH',
            type : 'string',
            filterable : true
        },{
            name : 'NAMA OBAT',
            type : 'string',
            filterable : true
        },{
            name : 'STOK',
            type : 'string',
            filterable : true
        },{
            name : 'SATUAN',
            type : 'string',
            filterable : true
        },{
            name : 'EXPIRED DATE',
            type : 'string',
            filterable : true
        }
    ]
    
    $(document).ready(function(){
        var jso;
        $.ajax({
            type : "POST",
            url : '<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/searchObat/'.$idUnit; ?>',
            success : function(dataCheck) {
//                alert(dataCheck);
                jso = dataCheck;
                setupPivot({
                    json : jso,
                    fields : fields,
                    rowLabels : ["NOMOR BATCH", "NAMA OBAT","STOK","SATUAN","EXPIRED DATE"]
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
    });
</script>