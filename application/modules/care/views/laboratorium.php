
<div class="container">
<div class="row">
	<div class="col-md-12">
	<section class="slice bg-2 p-15">
         <h3>Pemeriksaan Laboratorium</h3>
    </section>	&nbsp;
	</div>
	<div class="col-md-6">
		<!--<ul class="nav nav-pills">
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
		</ul>-->
		<span class="hide-on-print" id="pivot-detail"></span>
		<div style="" id="results"></div>
	</div>
	
	<form method="post" action="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/insertCekLaborat">
	
	<input type="hidden" id="id_rrm" name="id_rrm" type="text" value="<?php echo $this->uri->segment(4, 0); ?>">
	<input type="hidden" id="id_unit_tujuan" name="id_unit_tujuan" type="text" value="<?php echo $this->uri->segment(5, 0); ?>">
	<div class="col-md-6">
		<div class="form-group">
			<label for="">Detail</label><br>
			<table style="width: 100%; " class="table-responsive">
				<tbody id="bodyChoosedPemeriksaan">
					
				</tbody>
			</table>
		</div>
		<button id="confirmBtn" type="submit" class="btn btn-success" >Simpan</button>
	</div>
	
	
	</form>

</div>
</div>

<br>

<script type="text/javascript">
$(function () {
	renderTable();
	cekPemeriksaan();
});

var fields = [{
		name: 'NAMA PEM LABORAT',
		type: 'string',
		filterable: true
	}, {
		name: 'PILIH',
		type: 'string',
		filterable: true
	}
];
	
/*function setupPivot(input){
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
}*/

function renderTable()
{
	var jso;

	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showLaborat',
		success: function (dataCheck) {
			// alert(dataCheck);

			jso = dataCheck;
			setupPivot({
				json: jso,
				fields: fields,
				rowLabels: ["NAMA PEM LABORAT", "PILIH"]
						//rowLabels : ["ID OBAT","KODE OBAT","NAMA OBAT","SATUAN"]
			})
			$('.stop-propagation').click(function (event) {
				event.stopPropagation();
			});
		},
		error: function (xhr, status, error) {
			// var err = eval("(" + xhr.responseText + ")");
			// alert(err.Message);
		}
	});
}


function addPemeriksaanLaborat (id, namapemeriksaan) {
	// alert(id+namapemeriksaan);
	$('#bodyChoosedPemeriksaan').append('<tr id="'+id+'"><td><input id="'+id+'" name="'+id+'" readonly class="form-control" type="text" value="'+namapemeriksaan+'"></td><td><button onclick="removeSelectedPemeriksaan(\''+id+'\')" class="btn btn-warning" type="button">Hapus</button></td></tr>');
	cekPemeriksaan();
}

function removeSelectedPemeriksaan (value) {
	$('#bodyChoosedPemeriksaan').find('#'+value+'').remove();
	cekPemeriksaan();
}

function cekPemeriksaan () {
	var kamarTerpilih = $('#bodyChoosedPemeriksaan');			
	if (kamarTerpilih.children().length == 0) {
		$("#confirmBtn").attr("disabled", "disabled");
	}
	else $("#confirmBtn").removeAttr("disabled");
}

</script>  
 



