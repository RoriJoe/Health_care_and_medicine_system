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
            <h3>Permintaan Obat oleh Puskesmas </h3>
    </section>
	<br>
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
<div class="form-group">
	    <label for="">Daftar Permintaan Obat</label>
		<div style="overflow-y: scroll; height:200px;">
		<table class="table table-comparison table-responsive" >
			<thead >
			<tr>	
			<th>NO.</th>
			<th>NAMA UNIT</th>
			<th>NAMA PUSKESMAS</th>
			<th>TGL. PERMINTAAN</th>	
			<th>PILIH</th>                                    
			</tr>
			</thead>			
			<tbody id="tabelRequest" name="tabelRequest">                                
			<?php if (isset($allRequest)) :?>
			<?php $counter=1; foreach ($allRequest as $row): ?>
			<tr id="row<?php echo $row['ID_TRANSAKSI'] ?>">
			<td><?php echo $counter; $counter++; ?></td>
			<td><?php echo $row['NAMA_UNIT'] ?></td>
			<td><?php echo $row['NAMA_GEDUNG'] ?></td>
			<td><?php echo $row['TANGGAL_TRANSAKSI'] ?></td>
			<td>
					<input hidden="hidden" type="text" id="idUnit<?php echo $row['ID_TRANSAKSI'] ?>" name="idUnit<?php echo $row['ID_TRANSAKSI'] ?>" value="<?php echo $row['ID_UNIT']?>">
					<button class="btn btn-success" type="submit" id="<?php echo $row['ID_TRANSAKSI']; ?>" onclick="showDetailRequest(this.id, <?php echo $row['ID_JENISTRANSAKSI']; ?>)"><i class="fa fa-check"></i></button>		
			</td>
			</tr>
			<?php endforeach; else:?>
			<tr><td colspan=5 align="center">Kosong</td></tr>
			<?php endif; ?>
			</tbody>
		</table>
		</div>
</div>
<div class="row" id="detail" hidden="hidden">
	<form class="form-light padding-15" action="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/addDrugsOutHC" method="post">
	<div class="col-md-12">
		<div class="form-group">				
				<div id="tabelDetailRequest">
				</div>
				<div id="peringatan">
				</div>
		</div>
	</div>
	<div class="col-md-3 pull-right">
		<div hidden="hidden" class="form-group">
			<label for="inputTransaksi">Tanggal Transaksi</label>
			<input id="inputTransaksi" name="inputTransaksi" class="form-control datepicker" size="16" value="<?php date_default_timezone_set("Asia/Jakarta"); echo date('d-m-Y'); ?>" type="text">
			<input id="inputIdTransaksi" name="inputIdTransaksi" hidden="hidden">
			<input id="inputJenisTransaksi" name="inputJenisTransaksi" hidden="hidden">
			<input id="inputUnit" name="inputUnit" hidden="hidden">
		</div>
		<button id="kirimCITO" class="btn btn-two pull-right" type="submit">Setujui</button>
	</div>
	</form>
</div>
<br>
<br>
</div>
</div>  
</div>
</div>

<script>
// function showDetailRequest (value) {
	// $('#tabelRequest tbody tr').css("background-color","transparent");
	// $('#row'+value).css("background-color","#e1f8ff");
	
	// $('#inputIdTransaksi').val(value);
	// $('#inputUnit').val($('#idUnit'+value).val());
	
	
	// var link = "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/showDetailRequest'; ?>";
	
	// $.ajax({
        // type: "POST",
        // url: link,
        // data: {id : value},
        // success: function(data){   
			// var objData = eval (data);				
			// var content = '<table class="table table-bordered table-striped table-comparison table-responsive"><thead><tr><th>ID Obat</th><th>Nama Obat</th><th>Batch</th><th>Jumlah</th><th>Stok Obat Sekarang</th></thead><tbody>';
				// $.each(objData, function(index, value) {        
                    // content += '<tr><td>'+value.ID_OBAT+'</td>';     
                    // content += '<td>'+value.NAMA_OBAT+'</td>';
					// content += '<td>'+value.NOMOR_BATCH+'</td>';
					// var jmlobat = parseInt (value.JUMLAH_OBAT);
					// var stoksekarang = parseInt (value.STOK_OBAT_SEKARANG);
					// if (jmlobat>stoksekarang) {
                    // content += '<td><input required id="obat-'+value.ID_OBAT+'-'+value.NOMOR_BATCH+'" name="obat-'+value.ID_OBAT+'-'+value.NOMOR_BATCH+'" max='+value.STOK_OBAT_SEKARANG+' class="form-control" value='+value.JUMLAH_OBAT+'></td>';   
					// }
					// else {
						// content += '<td>'+value.JUMLAH_OBAT+'</td>';   
					// }
					// content += '<td>'+value.STOK_OBAT_SEKARANG+'</td></tr>';
                // });
				// content += '</tbody></table>';
				// $( "#tabelDetailRequest" ).html('');
				// $( "#tabelDetailRequest" ).append( content );  		
				// $('#detail').show();
				// $('#detail').scrollTop( '100%' );				
        // },
        // error: function(e){
            // alert("Error");
        // }
    // });
// }

function showDetailRequest (value, jenistrans) {
	$('#tabelRequest tr').css("background-color","transparent");
	$('#row'+value).css("background-color","#e1f8ff");
	$( "#kirimCITO" ).show();
	
	// alert (value);
	
	$('#inputIdTransaksi').val(value);
	$('#inputUnit').val($('#idUnit'+value).val());
	
	var transid = value;
	
	$( "#detail" ).hide();
	$( "#tabelDetailRequest" ).html('');
	$.ajax({
        type: "POST",
        url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showDetailRequest",
        data: {id : value},
        success: function(data){   
			// alert(data);
			var objData = eval (data);				
			var content = '<br><label for="">';
			
			$('#inputJenisTransaksi').val (jenistrans);
			if (jenistrans == 14) content += '<strong>Detail Permintaan CITO</strong>';
			else if (jenistrans ==  23) content += '<strong>Detail Retur Obat</strong>';
			
			content += '</label><table class="table table-striped table-comparison table-responsive"><thead><tr><th>KODE OBAT</th><th>NAMA OBAT</th><th>SATUAN</th><th>STOK SEKARANG</th><th>JUMLAH </th><th>KELOLA</th></thead><tbody id="bodyChoosed">';
			var flagAdaDiStok = false;
			var flagKurangDariStok = false;
				$.each(objData, function(index, value) {        
				
                    content += '<tr id="obat-'+value.ID_OBAT+'">';  					
					
					var kodeObat = "", satuan = "", total = "";
					if (value.KODE_OBAT) kodeObat = value.KODE_OBAT;
					if (value.SATUAN) satuan = value.SATUAN;
					if (value.TOTAL) total =value.TOTAL ;
					
					content += '<td>'+kodeObat+'</td>';
                    content += '<td>'+value.NAMA_OBAT+'</td>';					
					content += '<td>'+satuan+'</td>';										
					content += '<td><input id="stok-'+value.ID_OBAT+'" readonly class="form-control" value="'+total+'"></td>';
					content += '<td><form><input id="total-'+value.ID_OBAT+'" readonly class="form-control" value="'+value.JUMLAH_OBAT+'"></td>';
					if (!flagAdaDiStok){
					content += '<td><input type="button" id="ubah-'+value.ID_OBAT+'" class="btn btn-warning" onclick="editJumlah('+value.ID_OBAT+')" value="UBAH"><input type="button" style="display: none" id="simpan-'+value.ID_OBAT+'" class="btn btn-info" onclick="simpanJumlah('+value.ID_OBAT+','+transid+')" value="SIMPAN"><input type="button" class="btn btn-danger" onclick="hapusJumlah('+value.ID_OBAT+','+transid+')" value="HAPUS"></form></td>';					
					}
					else  {
						content += '<td><input type="button" class="btn btn-danger" onclick="hapusJumlah('+value.ID_OBAT+','+transid+')" value="HAPUS"></form></td>';
					}
					
					content += '</td></tr>';					
                });
				content += '</tbody></table>';				
				$( "#tabelDetailRequest" ).append( content );  	
				$( "#detail" ).show();	
				bandingkanStok();
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

function bandingkanStok () {
	var stok = [];
	$("input[id^='stok']").each(function(){
	   if (this.value) stok.push(this.value);
	   else stok.push("-1");
	});
	
	var total = [];
	$("input[id^='total']").each(function(){
	    if (this.value) total.push(this.value);
	   else total.push("-1");
	});

	var tanda = false;
	var tandaTidakAda = false;
	
	for ( var i = 0; i < stok.length; i = i + 1 ) {
		if ( parseInt(stok[i]) < 0 || parseInt(total[i]) < 0) {
			tandaTidakAda = true;
			break;
		}
		if ( parseInt(stok[i]) < parseInt(total[i]) ){ tanda = true; break; }
	}
	
	// console.log(tanda);
	$( "#peringatan" ).html('');
	if (tandaTidakAda) {
		$( "#peringatan" ).append("<div class='alert alert-danger'>Obat tidak ditemukan</div>");
		$( "#kirimCITO" ).attr("disabled", true);
	}	
	else if (tanda) {		
		$( "#peringatan" ).append("<div class='alert alert-warning'>Jumlah Permintaan Melebihi Jumlah Stok</div>");
		$( "#kirimCITO" ).attr("disabled", true);
	}
	else {
		$( "#kirimCITO" ).removeAttr("disabled");
	}
}

function simpanJumlah (idobat, idtrans) {
	bandingkanStok();

	$('#total-'+idobat).attr('readonly', true);
	$('#ubah-'+idobat).show();
	$('#simpan-'+idobat).hide();
	
	var total = $('#total-'+idobat).val();

	$.ajax({
        type: "POST",
        url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/updateRequestCITO",
        data: {id_obat : idobat, id_transaksi: idtrans, total: total},
        success: function(){
			alert ("Jumlah Pengiriman Berhasil Disimpan");
		},
		error: function(){}
	});
}


function hapusJumlah (idobat, idtrans) {
	if (confirm("Peringatan! Apakah Anda yakin menghapus entri ini?") == true ){ 
		$('#total-'+idobat).attr('readonly', true);
		$('#ubah-'+idobat).show();
		$('#simpan-'+idobat).hide();
		
		var total = $('#total-'+idobat).val();
		
		$('#bodyChoosed').find('#obat-'+idobat).remove();
		
		$c = 0;
		$("input[id^='stok']").each(function(){
		   $c++;
		});
		if ($c==0){
			$('#tabelDetailRequest').html('');
			$( "#kirimCITO" ).hide();
		}
	}
}


$(function () {
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
                