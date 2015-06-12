<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <header class="panel-heading">
                    <h3 class="panel-title"><?= 'Daftar Pasien' ?></h3>
                </header>
                <div class="panel-body">
                    <div class="form-group">
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
                        <span class="hide-on-print" id="pivot-detail"></span>
                        <div style="" id="results"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $( document ).ready(function() {
        renderTablePatient();
    });
    
    var fields = [{
            name: 'TANGGAL RIWAYAT RM',
            type: 'string',
            filterable: true
        }, {
            name: 'NOMOR REKAM MEDIK',
            type: 'string',
            filterable: true
        }, {
            name: 'NAMA PASIEN',
            type: 'string',
            filterable: true
        }, {
            name: 'ALAMAT PASIEN',
            type: 'string',
            filterable: true
        }, {
            name: 'RIWAYAT RESEP',
            type: 'string',
            filterable: true
        }, {
            name: 'BUAT RESEP',
            type: 'string',
            filterable: true
        }
    ]

    function renderTablePatient()
    {
        var jso;
        $.ajax({
            type: "POST",
            url: '<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0); ?>/showResepPasien',
            success: function(dataCheck) {
//                 alert(dataCheck);
                jso = dataCheck;
                setupPivot({
                    json: jso,
                    fields: fields,
                    rowLabels: ["TANGGAL RIWAYAT RM", "NOMOR REKAM MEDIK", "NAMA PASIEN", "ALAMAT PASIEN", "RIWAYAT RESEP", "BUAT RESEP"]
                            //rowLabels : ["ID OBAT","KODE OBAT","NAMA OBAT","SATUAN"]
                })
                $('.stop-propagation').click(function(event) {
                    event.stopPropagation();
                });
            }
//            ,error: function(xhr, ajaxOptions, thrownError) {
//                alert(xhr.status);
//                alert(thrownError);
//                alert(xhr.responseText);
//            }
        });
    }
</script>