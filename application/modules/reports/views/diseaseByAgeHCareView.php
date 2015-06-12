<div class="container">
<div class="row" >
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Cetak Per Penyakit' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
				<div class="form-group">
					
					<form class="form-horizontal bucket-form" method="post" action="<?php echo base_url().'reports/'.$this->uri->segment(2, 0).'/diseaseByAgeHCare'; ?>" target="_blank">
						<div class="form-group">
							<label class="col-sm-3 control-label">Kode ICD</label>
							<div class="col-sm-9">
								<input type="text" id="kodeIcd" name="kodeIcd" class="form-control" readonly/>
								<input type="hidden" id="inputIcd" name="inputIcd" class="form-control" />
								<input type="hidden" id="namapenyakit" name="namapenyakit" class="form-control" />
							</div>
						</div>
						
							<div class="form-group">
								<label class="col-sm-3 control-label">Diagnosa Utama (ICD X)</label>
								<div style="padding:0px;margin:0px" class="col-sm-9">
										<div class="col-lg-7">					
										<input id="queryicd" name="queryicd" class="form-control" placeholder="Masukkan kata pencarian utama" type="text">	</div>
										<div class="col-lg-2">					
										<button style="" class="btn btn-primary" type="button" onclick="renderTable()">Cari Kode ICD X</button>
										<!-- <a class="btn btn-two" type="button" onclick="getICD()">Go!</a> -->                  
										</div>
                                    <span class="hide-on-print" id="pivot-detail"></span>
                                    </br><div style="" id="results"></div>                     
								</div>
							</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Dari</label>
							<div class="col-sm-9">
								<input type="text" id="inputDari" name="inputDari" class="form-control datepicker"  size="16" value="<?= date('Y-m-d') ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Hingga</label>
							<div class="col-sm-9">
								<input type="text" id="inputHingga" name="inputHingga" class="form-control datepicker"  size="16" value="<?= date('Y-m-d') ?>">
							</div>
						</div>	
						<input class="btn btn-primary pull-right" type="submit" value="Cetak" name="submit">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script>
$(function () {
	$( ".datepicker" ).datepicker({
		format: 'yyyy-mm-dd',
	});
});

var fields = [
		{
            name: 'KODE ICD X',
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
        }
    ]

	
function fillICD(icd)
{
	var splitter = icd.split("_");
	$('#kodeIcd').val(splitter[1]);
	$('#inputIcd').val(splitter[0]);
	$('#namapenyakit').val(splitter[2]);
}

	function renderTable()
    {
		if ($("#queryicd").val() == "") return;
		
		var data_pos = $("#queryicd").val()
        var jso;
        var data_pos = $("#queryicd").val();
        var kapsul = {};
        kapsul.teksnya = {};
        kapsul.teksnya.tanda = $("#queryicd").val();

        // alert(kapsul.teksnya.tanda);
        // alert(kapsul.teksnya);
        // alert(kapsul);

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/getSearch'; ?>',
            data: kapsul,
            success: function (dataCheck) {
				//alert('dfdfdhdhf '+dataCheck);
                jso = dataCheck;
                mySetupPivot({
                    json: jso,
                    fields: fields,
                    rowLabels: ["KODE ICD X", "ENGLISH NAME", "INDONESIAN NAME", "KELOLA"]
                            //rowLabels : ["ID OBAT","KODE OBAT","NAMA OBAT","SATUAN"]
                })
                $('.stop-propagation').click(function (event) {
                    event.stopPropagation();
                });
            }/*
			,error: function (xhr, ajaxOptions, thrownError) {
             alert(xhr.status);
             alert(thrownError);
             alert(xhr.responseText);
           }*/
        });
    }
	
	function mySetupPivot(input){
		input.callbacks = {afterUpdateResults: function(){
		  $('#results > table').dataTable({
			"sDom": "<'row'<'col-md-6'l><'col-md-6'f>>t<'row'<'col-md-6'i><'col-md-6'p>>",
			"iDisplayLength": 5,
			"aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "All"]],
			"oLanguage": {
			  "sLengthMenu": "_MENU_ records per page"
			}
		  });
		}};
		$('#pivot-demo').pivot_display('setup', input);
	}
</script>