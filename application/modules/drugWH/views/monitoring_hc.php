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
				<h3>Daftar Obat Puskesmas</h3>
		</section>&nbsp;

		<br>
		<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="inputPuskesmas">Pilih Puskesmas</label>
				<select class="form-control" id="inputPuskesmas" name="inputPuskesmas" onchange="showUnitsHC(this.value)">
				<option selected value="-1">Silahkan Pilih Puskesmas</option>
					<?php if (isset($allGedung)) :?>
					<?php foreach ($allGedung as $row): ?>                                        
					<option value="<?php echo $row['ID_GEDUNG']?>"><?php echo $row['NAMA_GEDUNG'] ?></option>
					<?php endforeach; endif; ?>
				</select>
			</div>								
		</div>
		<div class="col-md-6">				
				<div class="form-group" id="dropdownUnits" hidden="hidden">
					
				</div>			
		</div>
		</div>
		<div>
		<div class="form-group" id="tabelObatPuskesmas" style="height: 550px; overflow-y: scroll;" hidden="hidden">
					
		</div>			
		<div id="tabelKosong" style="height: 550px; overflow-y: scroll;">
			<table class="table table-striped table-comparison table-responsive">
				<thead >
				<tr>	
				<th>NOMOR LPLPO</th>
				<th>NAMA OBAT</th>
				<th>SATUAN</th>
				<th>JUMLAH</th>
				</tr>
				</thead>
				<tbody> 
					<tr>
						<td colspan=4 align="center">Kosong</td>
					</tr>
				</tbody>
			</table>
		</div>
		</div>
	</div>  

</div>
</div>

<script>

function showUnitsHC (value){
	$( "#tabelObatPuskesmas" ).html('');
	$( "#dropdownUnits" ).html('');
	 $.ajax({
		type: "POST",
		url: "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/showUnitsHC",
		data: {id : value},
		success: function(data){   
			var dataObj = eval(data);				
			var content = '<label for="inputUnit">Pilih Unit</label><select onchange="showUnitStocksHC(this.value)" class="form-control" id="inputUnit" name="inputUnit"><option selected value="-1">Silahkan Pilih Unit</option><option value="semua_'+value+'">Semua</option>';
			$.each(dataObj, function(index, value) {        
				content += '<option value="'+value.ID_UNIT+'">'+value.NAMA_UNIT+'</option>';      
			});
			content += '</select>';	
			
			$( "#dropdownUnits" ).append( content );  			
			$( "#dropdownUnits" ).show();
		},
		error: function(e){
			// alert(e.message)
		}
	});
}

function showUnitStocksHC (value) {		
	if (value == -1) return;
	
	if (value.indexOf("semua") >= 0) {
		link = "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->		segment(2); ?>/showStocksHC";		
		splitted = value.split('_');
		value = splitted[1];
	}
	else link = "<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->		segment(2); ?>/showUnitStocksHC";
	
	$( "#tabelObatPuskesmas" ).html('');
	
	$.ajax({
		type: "POST",
		url: link,
		data: {id : value},
		success: function(data){  			
		if (data) {			
			var objData = eval (data);
			var content = '<table class="table table-striped table-comparison table-responsive" ><thead ><tr><th>NOMOR LPLPO</th><th>NAMA OBAT</th><th>SATUAN</th><th>JUMLAH</th></tr></thead><tbody>';
			$.each(objData, function(index, value) {        
				content += '<tr><td>'+value.KODE_OBAT+'</td>';     
				content += '<td>'+value.NAMA_OBAT+'</td>';
				content += '<td>'+value.SATUAN+'</td>';
				content += '<td>'+value.TOTAL+'</td></tr>';   
			});
			content += '</tbody></table>';
			$( "#tabelObatPuskesmas" ).html('');
			$( "#tabelObatPuskesmas" ).append( content );  		
			$('#tabelObatPuskesmas').show();
			$('#tabelKosong').hide();
		}
		else {
			$('#tabelObatPuskesmas').hide();
			$('#tabelKosong').show();
		}}
		,
		error: function(e){
			// alert(e.message)
		}
	});
}

</script>

