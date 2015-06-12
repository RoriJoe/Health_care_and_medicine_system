
<div class="container">
    <div class="row">
      <div class="col-lg-12">
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
                                <li class="dropdown">
                                    <a class="dropdown-toggle " data-toggle="dropdown" href="#"> Unit <b class="caret"></b> </a>
                                    <ul class="dropdown-menu stop-propagation" style="overflow:auto;max-height:150px;padding:10px;">
                                        <?php foreach($allUnit as $row) echo '<li><a id="tombol'.$row['ID_UNIT'].'">'.$row['NAMA_UNIT'].'</a></li>';
											 ?>
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
		function kirim(event) {	 
			var idUnit = event.data;
			$.ajax({
				type : "POST",
				url : '<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/searchMonitoringUnitz/'; ?>' + idUnit,
				success : function(dataCheck) {
					jso = dataCheck;
					setupPivot({
						json : jso,
						fields : fields,
						rowLabels : ["NOMOR BATCH", "NAMA OBAT","STOK","SATUAN","EXPIRED DATE"]
					})
					$('.stop-propagation').click(function(event) {
						event.stopPropagation();
					});
				},
				error: function(){						
						alert('Data Stok Obat Kosong');
				}
			});
		}
		<?php
		foreach ($allUnit as $id) {
			echo "$('#tombol".$id['ID_UNIT']."').click(".$id['ID_UNIT'].", kirim);\n";
		}
		?>
        
    });
	
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
</script>