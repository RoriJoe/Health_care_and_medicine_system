
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
			
			if (isset($allStocks)) {
				$arr_sudah_dicek = array();
				foreach ($allStocks as $sisaStok) {
					$mydate2 = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
					$mydate1 = DateTime::createFromFormat('Y-m-d', $sisaStok['EXPIRED_DATE']);
					if (diffInMonths ($mydate1, $mydate2) <= 1){
						echo '<div class="alert alert-danger"><strong>Peringatan!</strong><i> '.$sisaStok['NAMA_OBAT'].'</i> Batch '.
						$sisaStok['NOMOR_BATCH'].' kadaluarsa pada '.$mydate1->format('d-M-Y').' </div>';
					}
					
					if (in_array( $sisaStok['ID_OBAT'], $arr_sudah_dicek, true) == false) {
						if ($sisaStok['TOTAL'] <= $sisaStok['JML_OBAT_MIN']) {
							echo '<div class="alert alert-warning"><strong>Perhatian!</strong> Stok obat <i>'.$sisaStok['NAMA_OBAT'].'</i> mulai menipis.</div>';
							$arr_sudah_dicek[] = $sisaStok['ID_OBAT'];
						}
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
			<button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>
			<strong>Berhasil!</strong>
		</div>
		<?php elseif ($error_msg == "failed") :?>
		<div class="alert alert-block alert-danger fade in">
			<button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>
			<strong>Gagal!</strong>
		</div>	
		<?php endif; $error_msg = null; ?>
	<?php endif; ?>                      
	<!-- End of error Message; -->

	<section class="slice bg-2 p-15">
        <h3>Rekap Distribusi Obat<br><?php if (isset($namaGedung)){ 
		$nama = explode('%20', $namaGedung); 
		echo $nama[0].' '.$nama[1].'<br>'; 
		
		$tgl = DateTime::createFromFormat('d-m-Y', $this->uri->segment(5));
		echo $tgl->format('d-M-Y');
		}?></h3>
    </section>
	<br>		
		<div class="row">
			<div class="col-md-12">
				<table class="table table-striped table-comparison table-responsive">
				<thead >
				<tr>	
					<th>NO.</th>
					<th>NO. LPLPO</th> 
					<th>JENIS OBAT</th>
					<th>SATUAN</th>
					<th>TOTAL</th>
				</tr>
				</thead>
				<tbody id="puskesmasTotal" name="puskesmasTotal">  
					<?php if (isset($rekapDetail)) {
							$index = 1;
							foreach ($rekapDetail as $row){
								echo '<tr><td>'.$index.'</td>';
								echo '<td>'.$row['KODE_OBAT'].'</td>';
								echo '<td>'.$row['NAMA_OBAT'].'</td>';
								echo '<td>'.$row['SATUAN'].'</td>';
								echo '<td>'.$row['TOTAL'].'</td></tr>';
								$index++;
							}						
						}
					?>					
				</tbody>
			</table>
			</div>
		</div>
</div>	
</section>
</div>
</div>

<script>
function getPuskesmasTerlibat (date, divarea) {
	$("#"+divarea).html ('');
	$.ajax({
		type: "POST",
		url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showRecapDO",
		data: {tanggal: date},
		success: function(response){  		
			var content = '';
			if (response != 'null') {
			var objData = eval (response);
			$.each(objData, function(index, value) { 
				content += '<tr><td>'+value.NAMA_GEDUNG+'</td>';
				content += '<td><a id="linknya" type="button" class="btn btn-xs btn-warning" style="color: white" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showDetailDO/'+value.ID_UNIT+'/'+date+'" target="_blank"><i class="fa fa-search"></i></a></td></tr>';
			});			
			}
			else {
				content += '<tr><td colspan=3><center>Kosong<center></td></tr>';
			}
			$("#"+divarea).append (content);
			
		},
		error: function(){
			// alert ("Error occured!");
		}
	});
}

function getTotalTerlibat (tanggal1, tanggal2) {
	$("#puskesmasTotal").html ('');
	$.ajax({
		type: "POST",
		url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showTotalDO",
		data: {tanggal1: tanggal1, tanggal2: tanggal2},
		success: function(response){  		
			// alert (response);
			if (response == 'null') {
				$("#puskesmasTotal").append ('<tr><td colspan=5><center>Kosong<center></td></tr>');
				return;
			}
			var objData = eval (response);
			var content = '';
			var counter = 1;
			$.each(objData, function(index, value) { 				
				content += '<tr><td>'+counter+'</td>';
				content += '<td>'+value.KODE_OBAT+'</td>';
				content += '<td>'+value.NAMA_OBAT+'</td>';
				content += '<td>'+value.SATUAN+'</td>';
				content += '<td>'+value.TOTAL+'</td></tr>';
				counter++;
			});			
			$("#puskesmasTotal").append (content);
		},
		error: function(){
			// alert ("Error occured!");
		}
	});
}

$("#FormRekapDO").submit(function(event) {
	tanggal1 = $('#tanggalPertama').val();
	tanggal2 = $('#tanggalKedua').val();			
	
	getPuskesmasTerlibat(tanggal1, 'puskesmasTerlibat1');
	getPuskesmasTerlibat(tanggal2, 'puskesmasTerlibat2');
	getTotalTerlibat(tanggal1, tanggal2);
	event.preventDefault();
});

var fields = [
	 {
	 name : 'NAMA OBAT',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'SUMBER ANGGARAN',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'STOK SAAT INI',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'TANGGAL KADALUARSA',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'NOMOR BATCH',
	 type : 'string',
	 filterable : true
	 },{
		name : 'PILIH',
		type : 'string',
		filterable : false
	 }
];

function renderTable()
{
	var jso;

	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showAllDrugsGFKOut',
		success: function (dataCheck) {
		    // alert(dataCheck);

			jso = dataCheck;
			setupPivot({
				json: jso,
				fields: fields,
				rowLabels: ["NAMA OBAT","SUMBER ANGGARAN", "STOK SAAT INI", "TANGGAL KADALUARSA", "NOMOR BATCH","PILIH"]
			})
			$('.stop-propagation').click(function (event) {
				event.stopPropagation();
			});
		},
		error: function (xhr, status, error) {
			// alert("error bung "+ xhr.responseText);
		}
	});
}

$(function () {
	renderTable();
	$( ".datepicker" ).datepicker({
		format: 'dd-mm-yyyy',
	});
});
</script> 

<style>
.datepicker {
	z-index: 100000;
}
</style>
