
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <section class="slice bg-2 p-15">
                <h3>Data Kunjungan Pasien Poli Gigi</h3>
            </section>
        </div>
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
            <span class="hide-on-print" id="pivot-detail"></span>
            <div style="" id="results"></div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $( document ).ready(function() {
        renderTablePatient();
    });
    
    var fields = [{
            name: 'NOMOR',
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
            name: 'DETAIL',
            type: 'string',
            filterable: true
        }
    ]

    function renderTablePatient()
    {
        var jso;
        $.ajax({
            type: "POST",
            url: '<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0); ?>/showPatient',
            success: function(dataCheck) {
//                 alert(dataCheck);

                jso = dataCheck;
                setupPivot({
                    json: jso,
                    fields: fields,
                    rowLabels: ["NOMOR", "NOMOR REKAM MEDIK", "NAMA PASIEN", "ALAMAT PASIEN", "DETAIL"]
                })
                $('.stop-propagation').click(function(event) {
                    event.stopPropagation();
                });
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }
        });
    }
</script>    


