<div class="container">	



<div class="col-md-3">
	<div class="panel panel-primary" >
		<!-- Panel Heading -->
		<div class="panel-heading">
			<h3 class="panel-title">Notifikasi</h3>
		</div>
		<!-- End of Panel Heading -->
		
		<!-- Panel Body -->
		<div class="panel-body" style="height: 700px; overflow-y: scroll">
			<!-- Notifikasi Obat Hampir Kadaluarsa dan Stok Menipis -->
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
			<!-- End of Notifikasi -->
		</div>		
		<!-- End of Panel Body -->
	</div>
</div>

<div class="col-md-9">
	<div class="row form-group">
		<div class="col-md-12">
			
			<!-- Error Message -->  
			<?php if (isset($error_msg)) : ?>
				<?php if ($error_msg == "success") : ?>
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
				?>
			<?php endif; ?>                     
			<!-- End of Error Message -->
			
			
			<section class="slice bg-2 p-15">
				<h3>Pemasukan Obat Gudang Farmasi Kabupaten </h3>
			</section>	
		</div>
	</div>
	
	<form class="form-light padding-15" action="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/addDrugsIn" method="post">
	
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="inputNoIDTransaksi">Nomor Dokumen Obat Masuk</label>
				<input required id="inputNoIDTransaksi" name="inputNoIDTransaksi" class="form-control form-control-inline input-medium" type="text" placeholder="Masukkan Nomor Dokumen">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">														
				<label for="inputTransaksi" >Tanggal Transaksi</label>
				<input required id="inputTransaksi" name="inputTransaksi" class="form-control form-control-inline input-medium datepicker" type="text" value="<?php date_default_timezone_set("Asia/Jakarta"); echo date('d-m-Y'); ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div id="cekid">						
			</div>
		</div>
	</div>
	<hr>
	<!-- Pivot Obat Masuk -->
	<div class="row form-group">
		<div class="col-md-12">
			<span class="hide-on-print" id="pivot-detail"></span>
			<div id="results"></div>
		</div>   
	</div>
	<!-- End of Pivot Obat Masuk -->
	
	<hr>
	
	<!-- Detail Penambahan Obat -->
	
	<div class="row form-group" >
		<div class="col-md-12">	
			<label for="" >Detail Penambahan Obat</label>
			<table id="detailTambah" class="table table-striped table-comparison table-responsive">				
				<thead>
					<tr>				
						<th>Nama Obat</th>			
						<th>No.Batch</th>
						<th>Tgl. Kadaluarsa</th>
						<th>Jumlah</th>
						<th>Harga Satuan</th>
						<th>Harga Total</th>
						<th>Penyedia</th>
						<th>Hapus</th>
					</tr>
				</thead>
				<tbody id="bodyDetailPenambahan">

				</tbody>
			</table> 
		</div>	
	</div>
	<!-- End of Detail Penambahan Obat -->
	
	<div class="row form-group">
		<div class="col-md-4 pull-right">
			<button id="submitKulak" class="btn btn-two pull-right" type="submit">Selesai</button>
		</div>
	</div>
	</form>
</div>	
    
	
</div>
<!-- End of Container -->



<!-- Pop Up Add -->      
<div style="display: none;" class="modal fade in" id="addStocksModal" tabindex="-1" role="dialog" aria-labelledby="addStocksModal" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header alert alert-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Tambah Stok Obat</h4>
            </div>
			<div class="modal-body">
				<div class="position-center">                               
					<form id="FormTambahObat" class="form-light padding-15" method="POST">
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
                            <label for="inputSumberAnggaran" class="col-lg-4 col-sm-4 control-label">Sumber Anggaran</label>
                            <div class="col-lg-8">
                                <select required class="form-control" id="inputSumberAnggaran" name="inputSumberAnggaran">
                                    <option selected value="">Silahkan Pilih Sumber Anggaran</option>
                                    <?php if (isset($allSource)) : ?>
                                        <?php foreach ($allSource as $row): ?>                                        
                                            <option value="<?php echo $row['ID_SUMBER_ANGGARAN_OBAT'] ?>"><?php echo $row['NAMA_SUMBER_ANGGARAN_OBAT'] ?></option>
                                        <?php endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputJumlah" class="col-lg-4 col-sm-4 control-label">Jumlah Obat</label>
                            <div class="col-lg-8">
                                <input required placeholder="Masukkan Jumlah Obat" class="form-control" id="inputJumlah" name="inputJumlah" type="number" min=1>     
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputKadaluarsa" class="col-lg-4 col-sm-4 control-label" >Tanggal Kadaluarsa</label>
                            <div class="col-lg-8">									
                                <input required id="inputKadaluarsa" name="inputKadaluarsa" class="form-control datepicker" type="text" placeholder="Masukkan Tanggal Kadaluarsa Obat"/>                          
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputBatch" class="col-lg-4 col-sm-4 control-label">Nomor Batch</label>
                            <div class="col-lg-8">
                                <input required class="form-control" placeholder="Masukkan Nomor Batch" id="inputBatch" name="inputBatch" type="text" pattern="^[A-Za-z0-9\s]*" title="Isikan hanya huruf dan angka">
                            </div>
                        </div> 
						<div class="form-group">
                            <label for="inputHargaSatuan" class="col-lg-4 col-sm-4 control-label">Harga Satuan</label>
                            <div class="col-lg-8">
                                <input required class="form-control" placeholder="Masukkan Harga Satuan" id="inputHargaSatuan" name="inputHargaSatuan" type="number">
                            </div>
                        </div> 						
                        <div class="form-group">
                            <label for="inputPenyedia" class="col-lg-4 col-sm-4 control-label">Penyedia</label>
                            <div class="col-lg-8">
                                <input required class="form-control" placeholder="Masukkan Penyedia (Rekanan)" id="inputPenyedia" name="inputPenyedia" type="text"  pattern="^[A-Za-z0-9\s]*" title="Isikan hanya huruf dan angka">
                            </div>
                        </div> 	
						<div class="form-group">
                            <input type="text" id="selected" name="selected" hidden="hidden"/> 
							
                            <button data-dismiss="modal" class="btn btn-default col-lg-offset-8" id="closemodal" type="button">Tutup</button>
                            <button class="btn btn-success" type="submit">Tambah</button>
						</div>
							
					</form>
				</div>
			</div>
        </div>
    </div>
</div>                            
<!-- End Of Pop Up Add -->  





<script type="text/javascript">

function hapusObatTerpilihOM (koderow) {
	$('#detailTambah tbody').find('#'+koderow).remove();
	checkBasket ();
}

function checkBasket () {
	if ($('#detailTambah tbody').children().length != 0) 	
		$('#submitKulak').removeAttr('disabled');
	else $('#submitKulak').attr('disabled', 'disabled');
}

function toAddStocksModal (id, name, kadaluarsa, batch, namaanggaran, anggaran, maxjumlah) {
	var modal = $('#addStocksModal');
	modal.find('#inputNomor').val(id);
	modal.find('#inputNama').val(name);
	modal.find('#addStocksModal inputKadaluarsa').val(kadaluarsa);
	modal.find('#inputBatch').val(batch);
	modal.find('#inputSumberAnggaran').val(anggaran);
	modal.find('#namaSumberAnggaran').val(namaanggaran);	
	modal.find('#inputJumlah').attr('max', maxjumlah);
	modal.find('#inputJumlah').attr('min', 1);
	modal.find('#inputJumlah').val('');
	modal.find('#inputPenyedia').val('');
	modal.find('#inputHargaSatuan').val('');
}

$("#FormTambahObat").submit(function(event) {
	var nomor = $('#inputNomor').val();
	var batch = $('#inputBatch').val();
	if ($('#'+nomor+'_'+batch).length != 0){
		hapusObatTerpilihOM (nomor+'_'+batch);
	}
	
	var content;
	jumlah = parseInt ($('#inputJumlah').val());
	hargasatuan = parseInt ($('#inputHargaSatuan').val());
	hargatotal = jumlah * hargasatuan;
	
	content += '<tr id="'+$('#inputNomor').val()
			+'_'+($('#inputBatch').val()).replace(/\s/g, '')+'">';
			
	content += '<td>'+$('#inputNama').val()+'</td>';
	
	content += '<td hidden="hidden"><input value="'+$('#inputNomor').val()
			+'_'+$('#inputBatch').val()
			+'_'+$('#inputKadaluarsa').val()
			+'_'+$('#inputJumlah').val()
			+'_'+$('#inputHargaSatuan').val()
			+'_'+$('#inputPenyedia').val()
			+'_'+$('#inputSumberAnggaran').val()+'" name="obat'+$('#inputNomor').val()+$('#inputBatch').val()+'"></td>';
			
	content += '<td>'+$('#inputBatch').val()+'</td>';
	content += '<td>'+$('#inputKadaluarsa').val()+'</td>';	
	content += '<td>'+jumlah+'</td>';content += '<td>Rp. '+hargasatuan+'</td>';
	content += '<td>Rp. '+hargatotal+'</td>';								
	content += '<td>'+$('#inputPenyedia').val()+'</td>';
	content += '<td><a class="btn btn-xs btn-warning" style="color: white" onclick ="hapusObatTerpilihOM(\''
			+$('#inputNomor').val()
			+'_'+($('#inputBatch').val()).replace(/\s/g, '')+'\')"><i class="fa fa-cut"></i></a></td></tr>';
	
	$("#detailTambah tbody").append (content);
	$('#closemodal').click();
	checkBasket ();
	sortTable ();
	event.preventDefault();
	document.getElementById('detailTambah').scrollIntoView();
});

var fields = [
	{
		name: 'NAMA OBAT',
		type: 'string',
		filterable: true
	}, {
		name: 'SATUAN',
		type: 'string',
		filterable: true
	}, {
		name: 'PILIH',
		type: 'string',
		filterable: false
	}
];

function renderTable() {
	$('#results').append ('<div class="alert alert-info">Memuat Daftar Obat...</div>');
	var jso;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showAllDrugs',
		success: function (dataCheck) {
			if (dataCheck.length > 0) {
				jso = dataCheck;
				setupPivot({
					json: jso,
					fields: fields,
					rowLabels: [ "NAMA OBAT", "SATUAN", "PILIH"]
				})
				$('.stop-propagation').click(function (event) {
					event.stopPropagation();
				});
			}
			else {
				$('#results').html('');
				$('#results').append ('<div class="alert alert-info">Daftar Obat Kosong!</div>');				
			}
		},
		error: function (xhr, status, error) {
		}
	});
}

$(function () {
	renderTable ();
	checkBasket ();
	$( ".datepicker" ).datepicker({
		format: 'dd-mm-yyyy',
		minDate: '22-12-2014',
	});
});


$( "#inputNoIDTransaksi" ).keyup(function( event ) {
	var id = $( "#inputNoIDTransaksi" ).val();	
	if (id) {
		$.ajax({
			traditional: true,
			url: '<?php echo base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/nikChecker' ?>',
			type: "POST",
			data: { nik: id },
			success: function(dataChecker){
				// alert (dataChecker);
				
				$("#cekid").html('');				
				if (dataChecker != 'null'){
					$("#cekid").append('<div class="alert alert-danger">Nomor Dokumen Sudah Terpakai!</div>');
					$('#submitKulak').attr('disabled', 'disabled');
				}
				else { 
					$("#cekid").append('<div class="alert alert-success">Nomor Dokumen Tersedia</div>');
					$('#submitKulak').removeAttr('disabled');
				}
			},
			error: function (jqXHR, exception) {
				// alert('Error');
			}
		});
	}
	else { 
		$("#cekid").html('');
		checkBasket();
	}
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

</script> 

<style>
.datepicker {
	z-index: 100000;
}
</style>
