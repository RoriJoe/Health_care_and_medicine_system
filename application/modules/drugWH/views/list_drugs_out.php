
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

		<section class="slice bg-2 p-15">
			<h3>Daftar Pengiriman Obat</h3>
		</section> 
		<br>
		<div style="overflow-y: scroll; height:300px;">
		<table class="table table-comparison table-responsive">
			<thead>
			<tr>	
			<th>TUJUAN PENGIRIMAN</th>
			<th>TANGGAL PENGIRIMAN</th>
			<th>LIHAT DETAIL</th>
			<th>BATALKAN</th>
			</tr>
			</thead>
			<tbody id="tabelRequest"> 
				
					<?php if (isset($obatKeluar)) {
						foreach ($obatKeluar as $row) {	
							echo '<tr id="row'.$row['ID_TRANSAKSI'].'">';
							echo '<td>';							
							$tujuan = ''; 
							if ($row['NAMA_GEDUNG']) $tujuan = $row['NAMA_GEDUNG'];
							else $tujuan = $row['NAMA_TRANSAKSI_SUMBER_LAIN'];					
							echo $tujuan;
							echo '</td>';
							echo '<td>'.$row['TANGGAL_TRANSAKSI'].'</td>';
							echo '<td><button class="btn btn-success" onclick="showDetailRequest(\''.$row['ID_TRANSAKSI'].'\',\''.$tujuan.'\',\''.$row['TANGGAL_TRANSAKSI'].'\')"><i class="fa fa-check"></i></button></td>';
							echo '<td><button class="btn btn-danger" onclick="cancelRequest('.$row['ID_TRANSAKSI'].')"><i class="fa fa-cut"></i></button></td>';
							echo '</tr>';
						}
					}
					else echo '<td colspan=3 align="center">Kosong</td>';
					?>					

			</tbody>
		</table>
		</div>
		<div id="tabelDetailRequest">
		</div>
	</div>	
</section>

</div>
</div>



<!-- Pop up add -->      
<div style="display: none;" class="modal fade in" id="addStocksModal" tabindex="-1" role="dialog" aria-labelledby="addStocksModal" aria-hidden="false">
<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h4 class="modal-title">Obat Yang Dikirim</h4>
	</div>
	<div class="modal-body">
		<div class="position-center">
			<form id="FormTambahObatOut" class="form-light padding-15" method="POST">
			<div hidden="hidden" class="form-group">
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
			
			<!--<div class="form-group">
				<label for="inputSumberAnggaran" class="col-lg-4 col-sm-4 control-label">Sumber Anggaran</label>
				<div class="col-lg-8">
                                <input readonly class="form-control" id="inputSumberAnggaran" name="inputSumberAnggaran" value="" type="hidden">
                                <input readonly class="form-control" id="namaSumberAnggaran" name="namaSumberAnggaran" value="" type="text">

<!--				<select readonly required class="form-control" id="inputSumberAnggaran" name="inputSumberAnggaran">
				<option selected value="">Silahkan Pilih Sumber Anggaran</option>
					<?php //if (isset($allSource)) :?>
                    <?php //foreach ($allSource as $row): ?>                                        
                    <option value="<?php //echo $row['ID_SUMBER_ANGGARAN_OBAT']?>"><?php //echo $row['NAMA_SUMBER_ANGGARAN_OBAT'] ?></option>
					<?php //endforeach; endif; ?>
				</select> -->
			<!--
				</div>
			</div>
               -->  
			<div class="form-group">
				<label for="inputJumlah" class="col-lg-4 col-sm-4 control-label">Jumlah Obat</label>
				<div class="col-lg-8">
				<input required placeholder="Masukkan Jumlah Obat" class="form-control" id="inputJumlah" name="inputJumlah" type="number">     
				<label id="inputRekomendasi">Rekomendasi: </label>
				</div>				
			</div>
			<!--  
			<div class="form-group">
			   <label for="inputKadaluarsa"class="col-lg-4 col-sm-4 control-label" >Tanggal Kadaluarsa</label>
			   <div class="col-lg-8">
			   <input readonly required id="inputKadaluarsa" name="inputKadaluarsa" class="form-control form-control-inline input-medium" size="16" value="" type="date">                          
			   </div>
			</div>
			
			<div class="form-group">
				<label for="inputBatch" class="col-lg-4 col-sm-4 control-label">Nomor Batch</label>
				<div class="col-lg-8">
				<input readonly required class="form-control" placeholder="Masukkan Nomor Batch" id="inputBatch" name="inputBatch" type="text">
				</div>
			</div>
             -->                			
			<div class="form-group">
				<input type="text" id="selected" name="selected" hidden="hidden"/> 
				<button data-dismiss="modal" class="btn btn-default col-lg-offset-8" id="closemodal" type="button">Tutup</button>
				<button class="btn btn-danger" type="submit">Tambah</button>
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

function showDetailRequest (value, tujuan, tanggalkirim) {
	$('#tabelRequest tr').css("background-color","transparent");
	$('#row'+value).css("background-color","#e1f8ff");
	// alert (value);
	var transid = value;
	
	$( "#tabelDetailRequest" ).html('');
	$.ajax({
        type: "POST",
        url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showDetailRequest",
        data: {id : value},
        success: function(data){   
			// alert(data);
			
			if (data) {			
				var objData = eval (data);				
				var content = '<label><u>DETAIL OBAT</u></label><br><label>Tujuan Pengiriman : '+tujuan+'</label><br><label>Tanggal Pengiriman : '+tanggalkirim+'</label><br>';
				content += '<table class="table table-striped table-comparison table-responsive"><thead><tr><th>NAMA OBAT</th><th>SATUAN</th><th>STOK SEKARANG</th><th>JUMLAH </th><th>KELOLA</th></thead><tbody id="bodyChoosed">';
				$.each(objData, function(index, value) {        
                    content += '<tr id="obat-'+value.ID_OBAT+'">';     
					// content += '<td>'+value.KODE_OBAT+'</td>';
                    content += '<td>'+value.NAMA_OBAT+'</td>';					
					content += '<td>'+value.SATUAN+'</td>';					
					content += '<td>'+value.TOTAL+'</td>';
					content += '<td><input id="total-'+value.ID_OBAT+'" readonly class="form-control" value="'+value.JUMLAH_OBAT+'"></td>';
					content += '<td><input type="button" id="ubah-'+value.ID_OBAT+'" class="btn btn-warning" onclick="editJumlah('+value.ID_OBAT+')" value="UBAH"><input type="button" style="display: none" id="simpan-'+value.ID_OBAT+'" class="btn btn-info" onclick="simpanJumlah('+value.ID_OBAT+','+transid+')" value="SIMPAN">&nbsp;<input type="button" class="btn btn-danger" onclick="hapusJumlah('+value.ID_OBAT+','+transid+')" value="HAPUS"></td>';
					content += '</tr>';					
                });
				content += '</tbody></table>';				
				$( "#tabelDetailRequest" ).append( content );  	
			}
        },
        error: function(e){
            // alert("Error");
        }
    });
}

function editJumlah (idobat) {
	$('#total-'+idobat).attr('readonly', false);
	$('#ubah-'+idobat).hide();
	$('#simpan-'+idobat).show();
}

function simpanJumlah (idobat, idtrans) {
	$('#total-'+idobat).attr('readonly', true);
	$('#ubah-'+idobat).show();
	$('#simpan-'+idobat).hide();
	
	var total = $('#total-'+idobat).val();

	$.ajax({
        type: "POST",
        url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/removeDetailRequest",
        data: {id_obat : idobat, id_transaksi: idtrans, total: total},
        success: function(){
			alert ("Jumlah Pengiriman Berhasil Disimpan");
		},
		error: function(){}
	});
}


function hapusJumlah (idobat, idtrans) {
	if (confirm("Peringatan! Apakah Anda yakin menghapus data pengiriman secara permanen?") == true ){
		$('#total-'+idobat).attr('readonly', true);
		$('#ubah-'+idobat).show();
		$('#simpan-'+idobat).hide();
		
		var total = $('#total-'+idobat).val();
		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/onlyRemoveDetailRequest",
			data: {id_obat : idobat, id_transaksi: idtrans, total: total},
			success: function(ret){
				$('#tabelDetailRequest tbody').find('#obat-'+ret).remove();
			},
			error: function(){}
		});
	}
}

function cancelRequest (idtrans) {
	if (confirm("Peringatan! Apakah Anda yakin membatalkan pengiriman ini?") == true )
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/cancelRequest",
			data: {idtrans : idtrans},
			success: function(ret){				
				window.location = "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3); ?>";
			},
			error: function(){}
		});
	}		
}
</script> 