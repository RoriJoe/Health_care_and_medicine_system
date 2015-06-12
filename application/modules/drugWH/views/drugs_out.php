
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
		<button data-dismiss="alert" class="close close-sm" type="button">
		<i class="fa fa-times"></i>
		</button>
		<strong>Berhasil!</strong>
		</div>
		
		<?php elseif ($error_msg == "failed") :?>
		
		<div class="alert alert-block alert-danger fade in">
		<button data-dismiss="alert" class="close close-sm" type="button">
		<i class="fa fa-times"></i>
		</button>
		<strong>Gagal!</strong>
		</div>
		<?php endif; $error_msg = null; ?>
	<?php endif; ?>                      
	<!-- end of error MEssage; -->

	
	<section class="slice bg-2 p-15">
		<h3>Pengiriman Rutin ke Puskesmas dan Lain-Lain</h3>
	</section>

	
	<div class="row">
	<form class="form-light padding-15" action="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/addDrugsOut" method="post">
		<br>
		<div class="row col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label for="inputPuskesmas">Pilih Tujuan Pengiriman</label>
					<select required class="form-control" id="inputPuskesmas" name="inputPuskesmas" onchange="cekInputPuskesmas(this.value)">
						<option value="" selected>Silahkan Pilih</option>
						<?php foreach ($allGedung as $row): ?>
						<option value="<?php echo $row['ID_UNIT']; ?>"><?php echo $row['NAMA_GEDUNG']; ?></option>
						<?php endforeach; ?>                
						<option value="-1">Lain-Lain</option>
					</select>
				</div>
			</div> 
			<div class="col-md-6">
				<div class="form-group">
				   <label for="inputTransaksi" >Tanggal Transaksi</label>
					<input required id="inputTransaksi" name="inputTransaksi" class="form-control form-control-inline input-medium datepicker" value="<?php date_default_timezone_set("Asia/Jakarta"); echo date('d-m-Y'); ?>" type="text">                          
				</div>
			</div>
		</div>
		
		<div class="row col-md-12">		
			<div class="col-md-6" id="divinputSumberLain" hidden="hidden">
				<label for="inputSumberLain">Masukkan Tujuan Pengiriman Lain</label>
				<input class="form-control" id="inputSumberLain" name="inputSumberLain" placeholder="Masukkan Tujuan Lain selain Puskesmas">
			</div>
		</div>		

		<div class="col-md-12">
		<hr>
			<div class="row form-group">
				<div class="col-md-12">					
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
							<table class="table table-striped table-comparison table-responsive" id="detailTambah">
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
						<button disabled="disabled" id="submitKulak" class="btn btn-two pull-right" type="submit">Selesai</button>										 
					</div> 
				</div>
			</div>
        </div>
	</form>
	</div>
   &nbsp;   

</div>	
</section>
</div>
</div>


<!-- Pop up add -->      
<div style="display: none;" class="modal fade in" id="addStocksModal" tabindex="-1" role="dialog" aria-labelledby="addStocksModal" aria-hidden="false">
<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header alert alert-success">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h4 class="modal-title">Obat Yang Dikirim</h4>
	</div>
	<div class="modal-body">
		<div class="position-center">
			<form id="FormTambahObatOut" class="form-light padding-15" method="POST">
			<!--<div hidden="hidden" class="form-group">-->
			<div class="form-group" hidden="hidden">
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
				<button data-dismiss="modal" class="btn btn-default col-lg-offset-8" id="closemodal" type="button">Tutup</button>
				<button class="btn btn-success" type="submit">Tambah</button>
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

function toAddStocksModal (id, name, maxjumlah) {
	$("#alertPenambahan").html('');
	$('#inputNomor').val(id);
	$('#inputNama').val(name);	
	$('#inputJumlah').attr('max', maxjumlah);
	$('#inputJumlah').attr('min', 1);
	$('#inputJumlah').val('');
	
	var id_puskesmas = $('#inputPuskesmas').val();
	ShowRecommendation (id_puskesmas, id);
}

function checkBasket () {
	if ($('#detailTambah tbody').children().length != 0) 	
		$('#submitKulak').removeAttr('disabled');
	else $('#submitKulak').attr('disabled', 'disabled');
}

function hapusObatTerpilihOK (koderow) {
	$('#detailTambah tbody').find('#'+koderow).remove();
	checkBasket ();
}

function replaceObatTerpilih (koderow) {
	$('#detailTambah > tbody  > tr').each(function() {
		var id = this.id;
		if (id.match("^"+koderow+"_")){
			this.remove();
		}		
	});
}

$("#FormTambahObatOut").submit(function(event) {
	// waiting....
	$("#alertPenambahan").html('');
	
	var ale = '<div class="alert alert-info fade in">Tunggu Sebentar</div>';
	
	$("#alertPenambahan").append(ale);
	
	var nomorObat = $('#inputNomor').val();
	var jumlahObat = $('#inputJumlah').val();
	
	$.ajax({
		type: "POST",
		url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/addDrugsDetailOK",
		data: { inputObat: nomorObat, inputJumlah: jumlahObat },
		success: function(response){ 
			//alert(response);
			replaceObatTerpilih (nomorObat);
				
			var objData = eval (response);
			var content;
			
			$.each(objData, function(index, value) { 			
				content += '<tr id="'+value.ID_OBAT+'_'+(value.NOMOR_BATCH).replace(/\s/g, '')+'"><td>'+value.NAMA_OBAT+'</td>';
				
				content += '<td hidden="hidden"><input value="'+value.ID_OBAT
						+'_'+value.NOMOR_BATCH
						+'_'+value.EXPIRED_DATE
						+'_'+value.STOK_OBAT_SEKARANG
						+'_'+value.ID_SUMBER_ANGGARAN_OBAT+'" name="obat'+value.ID_OBAT+'_'+(value.NOMOR_BATCH).replace(/\s/g, '')+'"></td>';
				
				content += '<td>'+value.NOMOR_BATCH+'</td>';
				content += '<td>'+value.EXPIRED_DATE+'</td>';
				content += '<td>'+value.STOK_OBAT_SEKARANG+'</td>';				
				content += '<td><a class="btn btn-xs btn-danger" style="color: white" onclick ="hapusObatTerpilihOK(\''+value.ID_OBAT+'_'+(value.NOMOR_BATCH).replace(/\s/g, '')+'\')"><i class="fa fa-cut"></i></a></td></tr>';
			});	
			
			$("#detailTambah tbody").append (content);
			
			$("#alertPenambahan").html('');
			var ale = '<div class="alert alert-success fade in">Penambahan Berhasil</div>';
			$("#alertPenambahan").append(ale);
			
			$('#closemodal').click();
			checkBasket ();
			sortTable ();
		},
		error: function(){
		}
	});
	event.preventDefault();
});


function sortTable(){
  var rows = $('#detailTambah tbody  tr').get();

  rows.sort(function(a, b) {

  var A = $(a).children('td').eq(0).text().toUpperCase();
  var B = $(b).children('td').eq(0).text().toUpperCase();

  if(A < B) {
    return -1;
  }

  if(A > B) {
    return 1;
  }

  return 0;

  });

  $.each(rows, function(index, row) {
    $('#detailTambah').children('tbody').append(row);
  });
}


var fields = [	
	 {
	 name : 'NAMA OBAT',
	 type : 'string',
	 filterable : true
	 },{
	 name : 'TOTAL',
	 type : 'string',
	 filterable : true
	 },{
		name : 'PILIH',
		type : 'string',
		filterable : false
	 }
];

function renderTable () {
	$('#results').append ('<div class="alert alert-info">Memuat Daftar Obat...</div>');
	var jso;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showAllDrugsGFKOut',
		success: function (dataCheck) {
			if (dataCheck.length > 0) {
				jso = dataCheck;
				setupPivot({
					json: jso,
					fields: fields,
					rowLabels: ["NAMA OBAT","TOTAL","PILIH"]
				})
				$('.stop-propagation').click(function (event) {
					event.stopPropagation();
				});
			}
			else {
				$('#results').html ('');
				$('#results').append ('<div class="alert alert-success">Daftar Obat Kosong!</div>');
			}
		},
		error: function (xhr, status, error) {
		}
	});
}

$(function () {
	renderTable();	
	$( ".datepicker" ).datepicker({
		format: 'dd-mm-yyyy',
	});
});

// show rekomendasi 2 bulan
function ShowRecommendation (id_pus, id_obat) {
	if (!id_pus) {
		$("#inputRekomendasi").html('Rekomendasi : Tutup dan Pilih Gudang Obat Dahulu');
		return;
	}
	$.ajax({
		type: "POST",
		url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showDataRecom",
		data: {id: id_pus, id_obat: id_obat},
		success: function(retVal){ 	
			// alert (retVal);
			if (retVal != 'null') {
				var dataObj = JSON.parse(retVal);
				if (dataObj.REKOMENDASI > 0){
					$("#inputRekomendasi").html('Rekomendasi: '+dataObj.REKOMENDASI);
				}
				else $("#inputRekomendasi").html('Rekomendasi: Tidak Bisa Ditentukan');
			}
			else {
				$("#inputRekomendasi").html('Rekomendasi: Belum Ada');
			}
		},
		error: function() {
		}
	});
}

// cek distribusi lain-lain
function cekInputPuskesmas (value) {
	if (value == -1) { $("#divinputSumberLain").show(); }
	else { $("#divinputSumberLain").hide(); }
}

</script> 

<style>
.datepicker {
	z-index: 100000;
}
</style>
