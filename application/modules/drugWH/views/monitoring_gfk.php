
<!-- Pop up Edit -->
<div style="display: none;" class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
			        <div class="modal-content">
			            <div class="modal-header alert alert-info">
			                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			                <h4 class="modal-title">Ubah Data Obat</h4>
			            </div>
			            <div class="modal-body">
			                <div class="position-center">
			                <form class="form-horizontal" method="post" action="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/updateDrugsGFK">
			                <div class="form-group">                                
								<label for="selectedIdObat" class="col-lg-3 col-sm-3 control-label">Kode Obat</label>
								<div class="col-lg-8">
								<input readonly class="form-control" id="selectedIdObat" name="selectedIdObat" type="text">             
			                </div>
			                </div>
			                <div class="form-group">
								<label for="selectedNamaObat" class="col-lg-3 col-sm-3 control-label">Nama Obat</label>
								<div class="col-lg-8">
								<input class="form-control" id="selectedNamaObat" name="selectedNamaObat" type="text">
								</div>
			                </div>
			                <div class="form-group">
								<label for="selectedSatuanObat" class="col-lg-3 col-sm-3 control-label">Satuan Obat</label>
								<div class="col-lg-8">
								<input class="form-control" id="selectedSatuanObat" name="selectedSatuanObat" type="text">
								</div>
			                </div>
			                <div class="form-group">
								<label for="selectedJmlObatMin" class="col-lg-3 col-sm-3 control-label">Jml Obat Min</label>
								<div class="col-lg-8">
								<input class="form-control" placeholder="Masukkan Jumlah Obat Minimum" id="selectedJmlObatMin" name="selectedJmlObatMin" /> 
								</div>
			                </div>
			                <div class="form-group">                                    
			                <div class="col-lg-offset-3 col-lg-9">
			                <button data-dismiss="modal" class="btn btn-default" type="button">Tutup</button>
			                <button type="submit" class="btn btn-info">Simpan</button>
			                </div>
			                </div>
			                </form>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
<!-- Eof Popup edit -->
            
<!-- Pop up delete confirmation -->      
<div style="display: none;" class="modal fade in" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel" aria-hidden="false">
<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header alert alert-warning">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h4 class="modal-title">Konfirmasi</h4>
	</div>
	<div class="modal-body">

		Apakah Anda yakin menghapus entri <strong id="deletedItem"></strong> ?
		
	</div>
	<div class="modal-footer">
	<form class="form-vertical" method="post" action="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/deleteDrugsGFK">
	<div class="form-group">
	<input type="text" id="selected" name="selected" hidden="hidden"/> 
	<button data-dismiss="modal" class="btn btn-default" type="button">Tutup</button>
	<button class="btn btn-warning" type="submit">Hapus</button>
	</div>
	</form>
	</div>
	</div>
</div>
</div>                            
<!-- Eof Delete -->  

<!-- Pop up detail-->      
<div style="display: none;" class="modal fade in" id="detailObatModal" tabindex="-1" role="dialog" aria-labelledby="detailObatModal" aria-hidden="false">
<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header alert alert-warning">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h4 class="modal-title">Detail Obat per Batch</h4>
	</div>
	<div class="modal-body" style="height: 300px; overflow-y: scroll;">
		<table class="table table-striped table-comparision table-responsive">				
			<thead>
				<tr>				
					<th>Nama Obat</th>											
					<th>No.Batch</th>
					<th>Sumber Anggaran</th>
					<th>Stok Saat Ini</th>
					<th>Tanggal Kadaluarsa</th>
					<th>Buang</th>
				</tr>
			</thead>
			<tbody id="bodyDetailObat">

			</tbody>			
		</table> 
		<div id="alertPembuangan">
			
		</div>
	</div>
	</div>
</div>
</div>                            
<!-- Eof Detail -->  



<!-- Pop up throw confirmation -->      
<div style="display: none;" class="modal fade in" id="buangModal" tabindex="-1" role="dialog" aria-labelledby="buangModalLabel" aria-hidden="false">
<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header alert alert-danger">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h4 class="modal-title">Konfirmasi</h4>
	</div>
	<div class="modal-body">
	
		Apakah Anda yakin membuang <strong id="throwedItem"></strong> ?				

	</div>
	<div class="modal-footer">
		<form id="FormPembuangan" class="form-vertical" method="post"/ action=""> 
		<!-- action="<?php //echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/throwDrugsGFK">-->						
			<div class="form-group">
				<input type="text" id="selectedThrowedItem" name="selectedThrowedItem" hidden="hidden"/> 
				<input type="text" id="selectedBatchItem" name="selectedBatchItem" hidden="hidden"/> 
				<input type="text" id="selectedNamaItem" name="selectedNamaItem" hidden="hidden"/>
				<button data-dismiss="modal" class="btn btn-default" type="button">Tutup</button>
				<button data-dismiss="modal" class="btn btn-danger" type="submit">Buang</button>
			</div>
		</form>
	</div>
	</div>
</div>
</div>                            
<!-- Eof Throw --> 


<!-- Pop up isian tambah obat baru -->
                <div style="display: none;" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header alert alert-success">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Tambah Jenis Obat Baru</h4>
                            </div>
                            <div class="modal-body">
                                <div class="position-center">
                                <form class="form-horizontal" method="post" action="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/addDrugsGFK">
                                <div class="form-group">
                                <label for="inputKode" class="col-lg-2 col-sm-2 control-label">Kode</label>
                                <div class="col-lg-10">
                                <input class="form-control" id="inputKodeObat"  name="inputKode" type="text">             
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputNama" class="col-lg-2 col-sm-2 control-label">Nama</label>
                                <div class="col-lg-10">
                                <input class="form-control" id="inputNamaObat" name="inputNama" type="text">
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputSatuan" class="col-lg-2 col-sm-2 control-label">Satuan</label>
                                <div class="col-lg-10">
                                <input class="form-control" id="inputSatuanObat" name="inputSatuan" type="text">
                                </div>
                                </div>
                                <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-primary btn-success">Tambah</button>
                                </div>
                                </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!-- End of Modal -->  

<div class="container">	
<div class="row">
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

	<section class="slice bg-2 p-15">
		<h3>Jumlah Stok dan Daftar Obat</h3>
    </section>&nbsp;
	
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
<!-- end of error Message; -->
<div>  
<div class="row">
<div class="col-md-6">
	<a style="color: white" type="button" class="btn btn-success"  data-toggle="modal" href="#myModal"> Tambah Obat <i class="fa fa-plus"></i> </a>
</div>

<div class="col-md-6">

</div>
</div>
&nbsp;

<div class="row form-group">
	<div class="col-md-12">
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
		<div id="results"></div>
	</div>
	&nbsp;
</div>




<hr>
	<form class="form-light padding-15" action="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/addDrugsThrowed" method="post">
	<div class="row form-group" >
	<div class="col-md-8">	
		<label for="" >Detail Obat Rusak dan Kadaluarsa yang Dipilih</label>
		<table class="table table-striped table-comparision table-responsive" id="detailBuang">				
			<thead>
				<tr>				
					<th>NAMA OBAT</th>			
					<th>NO. BATCH</th>
					<th>JUMLAH</th>
					<th>HAPUS</th>
				</tr>
			</thead>
			<tbody id="bodyDetailPenambahan">

			</tbody>
		</table> 

	</div>
	<div class="col-md-4">
			<div class="form-group">
				<label for="inputAlasan">Keterangan</label>
				<input required id="inputAlasan" name="inputAlasan" class="form-control" placeholder="Masukkan Alasan">
			</div>
			<div hidden="hidden" class="form-group">																	
				<label for="inputTransaksi" >Tanggal Input</label>
				<input id="inputTransaksi" name="inputTransaksi" class="form-control" type="text" value="<?php date_default_timezone_set("Asia/Jakarta"); echo date('d-m-Y'); ?>">
			</div>
			
			<button id="submitKulak" class="btn btn-two pull-right" type="submit">Selesai</button>		
	</div>
	</form>
</div>



<br>
<br>
<br>
<br>




<script>
	// lihat detail batch masing-masing obat
	function drugsDetailGFK (idobat) {
		$('#alertPembuangan').html('');
		$("#bodyDetailObat").html ('');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showAllDetailObat",
			data: {id_obat: idobat},
			success: function(retVal){ 
				if (retVal.length>0) {
					var objData = eval (retVal);
					var content;
					$.each(objData, function(index, value) { 
						content += '<tr><td>'+value.NAMA_OBAT+'</td>';
						content += '<td>'+value.NOMOR_BATCH+'</td>';	
						content += '<td>'+value.NAMA_SUMBER_ANGGARAN_OBAT+'</td>';	
						content += '<td>'+value.STOK_OBAT_SEKARANG+'</td>';	
						content += '<td>'+value.TANGGAL_KADALUARSA+'</td>';	
						content += '<td><a class="btn btn-xs btn-danger" style="color: white" onclick ="drugsThrowGFK(\''+value.ID_OBAT+'\', \''+value.NAMA_OBAT+'\', \''+value.NOMOR_BATCH+'\', \''+value.STOK_OBAT_SEKARANG+'\')"><i class="fa fa-cut"></i></a></td></tr>';

					});			
					$("#bodyDetailObat").append (content);
				}
			},
			error: function() {
				// alert ('Error!');
			}
		});
	}

	function checkBasket () {
		if ($('#detailBuang tbody').children().length != 0) 	
			$('#submitKulak').removeAttr('disabled');
		else $('#submitKulak').attr('disabled', 'disabled');
	}
	
	function hapusObatTerpilih (koderow) {
		$('#detailBuang tbody').find('#'+koderow).remove();
		checkBasket ();
	}
	
	function drugsThrowGFK (nomor, nama, batch, stok) {
		if ($('#'+nomor+'_'+batch).length != 0){
			hapusObatTerpilih (nomor+'_'+batch);
		}
		
		var content;
		content += '<tr id="'+nomor+'_'+batch+'">';		
				
		content += '<td>'+nama+'</td>';
		content += '<td hidden="hidden"><input value="'+nomor+'_'+batch+'" name="obat'+nomor+batch+'"></td>';
		content += '<td>'+batch+'</td>';
		content += '<td>'+stok+'</td>';	
		content += '<td><a class="btn btn-xs btn-danger" style="color: white" onclick ="hapusObatTerpilih(\''+nomor+'_'+batch+'\')"><i class="fa fa-cut"></i></a></td></tr>';
		
		$("#detailBuang tbody").append (content);
		sortTable();
		
		var alert = '<div class="alert alert-success fade in"><button data-dismiss="alert" class="close close-sm" 		type="button"><i class="fa fa-times"></i></button><strong>Berhasil menambahkan Obat '+nama+' Batch '+batch+'</strong></div>';
		$('#alertPembuangan').html('');
		$('#alertPembuangan').append(alert);
		checkBasket ();		
		
		event.preventDefault();
		document.getElementById('detailBuang').scrollIntoView();
	}

	function drugsEditGFK (id, name, satuan, jmlmin) {
		$('#selectedIdObat').val(id);
		$('#selectedNamaObat').val(name);
		$('#selectedSatuanObat').val(satuan);
		$('#selectedJmlObatMin').val(jmlmin);
	}

	// deprecated
	function drugsRemoveGFK (id, name, batch) {
		document.getElementById('deletedItem').innerHTML = name+" <i>batch "+batch+"</i>";
		document.getElementById('selected').value = id;
	}
	
	function sortTable(){
	  var rows = $('#detailBuang tbody tr').get();

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
		$('#detailBuang').children('tbody').append(row);
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
		name : 'UBAH',
		type : 'string',
		filterable : false
		},{
		name : 'DETAIL',
		type : 'string',
		filterable : false
		}
	];

	function renderTable() {
		$('#results').append ('<div class="alert alert-info">Memuat Daftar Obat...</div>');
		var jso;
		$.ajax({
			type: "POST",
			url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showAllDrugsGFK',
			success: function (dataCheck) {				
				if (dataCheck.length > 0) {
					jso = dataCheck;
					setupPivot({
						json: jso,
						fields: fields,
						rowLabels: ["NAMA OBAT", "TOTAL","UBAH", "DETAIL"]
					})
					$('.stop-propagation').click(function (event) {
					event.stopPropagation();
					});
				} else {
					$('#results').html('');
					$('#results').append ('<div class="alert alert-success">Daftar Obat Kosong!</div>');
				}				
			},
			error: function (xhr, status, error) {
				// alert(status.status+ error + xhr.responseText);
			}
		});
	}

	$(function () {
		renderTable();	
		checkBasket();
		$( ".datepicker" ).datepicker({
			format: 'dd-mm-yyyy',
		});
	});

</script> 
