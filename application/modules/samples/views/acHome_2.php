<script src="<?php echo base_url(); ?>assets/newui/assets/pivot/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/newui/assets/pivot/jquery-2.1.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/pivot.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/jquery_pivot.js"></script>
<!-- pivot stuff -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/newui/assets/pivot/bootstrap.min.css" type="text/css">
<script type="text/javascript" async="" src="<?php echo base_url(); ?>assets/newui/assets/pivot/c.js"></script>
<script async="" src="<?php echo base_url(); ?>assets/newui/assets/pivot/analytics.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/subnav.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/accounting.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/dataTables.bootstrap.js"></script>
<div class="row">
    <div class="col-lg-6">
        <section class="panel">
            <header class="panel-heading">
                Kepala Puskesmas
            </header>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Kata Kunci Utama</label>
                    <div class="col-sm-6">
                        <input id="oi1" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-6">
                        <button onclick="renderTable()" value="Cari">Cari</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-lg-6">

    </div>
</div>
<section class="slice p-15">
    <div class="cta-wr">
        <div class="container">
            <div class="row">
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
                    <div style="overflow-x: scroll" id="results"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function fungsi_alert(v1, v2, v3, v4, v5)
    {
        alert(v1 + ' ' + v2 + ' ' + v3 + ' ' + v4 + ' ' + v5);
    }
    
    var fields = [
		{
            name: 'NOMOR',
            type: 'string',
            filterable: true
        },{
            name: 'CATEGORY',
            type: 'string',
            filterable: true
        }, {
            name: 'SUBCATEGORY',
            type: 'string',
            filterable: true
        }, {
            name: 'ENGLISH NAME',
            type: 'string',
            filterable: true
        }, {
            name: 'INDONESIAN NAME',
            type: 'string',
            filterable: true
        }, {
            name: 'KELOLA',
            type: 'string',
            filterable: true
        },
    ]

    function setupPivot(input) {
        input.callbacks = {
            afterUpdateResults: function () {
                $('#results > table').dataTable({
                    "sDom": "<'row'<'span6'l><'span6'f>>t<'row'<'span6'i><'span6'p>>",
                    "iDisplayLength": 25,
                    "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sLengthMenu": "_MENU_ records per page"
                    }
                });
            }
        };
        $('#pivot-demo').pivot_display('setup', input);
    }
    ; 
	
	function renderTable()
    {
        var jso;
        var data_pos = $("#oi1").val();
        var kapsul = {};
        kapsul.teksnya = {};
        kapsul.teksnya.tanda = $("#oi1").val();
        //alert(kapsul.teksnya.tanda);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/samples/getSearch',
            data: kapsul,
            success: function (dataCheck) {
                alert(dataCheck);
                jso = dataCheck;
                setupPivot({
                    json: jso,
                    fields: fields,
                    rowLabels: ["NOMOR", "CATEGORY", "SUBCATEGORY", "ENGLISH NAME", "INDONESIAN NAME", "KELOLA"]
                })
                $('.stop-propagation').click(function (event) {
                    event.stopPropagation();
                });

            }
        });
    }

   
</script>    
