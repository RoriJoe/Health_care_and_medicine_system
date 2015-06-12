<?php
$row = $selectedAkun[0];
?>
<div class="container">
<div class="row">
	<form class="form-horizontal bucket-form" id="formInput" method="post" action="<?php echo base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/saveOwnUpdateAccount' ?>">
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Ubah Profil' ?></h3>
			</header>
			<section class="panel">
				<input hidden=true type="text" id="selectedAkun" name="selectedAkun" value="<?php echo $row['ID_AKUN']; ?>">
			<div class="panel-body">
				<div class="col-lg-12">
					<section class="panel">
						<div class="form-group">
                            <label class="col-sm-3 control-label">No Identitas</label>
                            <div class="col-sm-9">
                                <input type="text" id="inputNoid" name="inputNoid" class="form-control" value="<?php echo $row['NOID']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" id="inputNama" name="inputNama" class="form-control" value="<?php echo $row['NAMA_AKUN']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Alamat</label>
                            <div class="col-sm-9">
                                <input type="text" id="inputAlamat" name="inputAlamat" class="form-control" value="<?php echo $row['ALAMAT']; ?>">
                                <!--<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jenis Kelamin</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                        <input <?php if($row['JENIS_KELAMIN']=="L") echo "checked=true"; ?> type="radio" id="inputSex" name="inputSex" value="L">Laki-Laki<br>
                                        <input <?php if($row['JENIS_KELAMIN']=="P") echo "checked=true"; ?> type="radio" id="inputSex" name="inputSex" value="P">Perempuan
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Telepon</label>                        
                            <div class="col-sm-9">
                                <input type="text" id="inputTelepon" name="inputTelepon" class="form-control" value="<?php echo $row['TELEPON']; ?>">
                            </div>
                        </div>                    
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Handphone</label>
                            <div class="col-sm-9">
                                <input type="text" id="inputHandphone" name="inputHandphone" class="form-control" value="<?php echo $row['HP']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" id="inputEmail" name="inputEmail" class="form-control" value="<?php echo $row['EMAIL']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Agama</label>
                            <div class="col-sm-9">
                                <input type="text" id="inputAgama" name="inputAgama" class="form-control" value="<?php echo $row['AGAMA']; ?>">
                            </div>
                        </div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Jabatan</label>
							<div class="col-sm-9">
								<select class="form-control m-bot15" id="inputJabatan" name="inputJabatan" readonly>
									<?php if(isset($allDepartment)){ ?>
									<?php foreach($allDepartment as $department){ ?>
										<?php if($row['ID_JABATAN'] == $department['ID_JABATAN']) 
												echo '<option selected=true value='.$department['ID_JABATAN'].'">'.$department['NAMA_JABATAN'].'</option>';
										   else
												echo '<option value='.$department['ID_JABATAN'].'">'.$department['NAMA_JABATAN'].'</option>';
										?>
										
									<?php }} ?>
								</select>
							 </div>
						 </div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Pangkat</label>
							<div class="col-sm-9">
								<select class="form-control m-bot15" id="inputPangkat" name="inputPangkat" readonly>
									<?php if(isset($allRank)){?>
									<?php foreach($allRank as $rank){ ?>
										<?php if($rank['ID_PANGKAT'] == $rank['ID_PANGKAT']) 
												echo '<option selected=true value='.$rank['ID_PANGKAT'].'">'.$rank['NAMA_PANGKAT'].'</option>';
										   else
												echo '<option value='.$rank['ID_PANGKAT'].'">'.$rank['NAMA_PANGKAT'].'</option>';
										?>
									<?php }} ?>
								</select>
							 </div>
						 </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status Pegawai</label>
                            <div class="col-sm-9">
                                <select class="form-control m-bot15" id="inputStatus" name="inputStatus" readonly>
                                    <option <?php if($row['STATUS_PEGAWAI']=="PNS") echo "selected=true"; ?> value="PNS">PNS</option>
                                    <option <?php if($row['STATUS_PEGAWAI']=="Magang") echo "selected=true"; ?> value="Magang">Magang</option>
                                    <option <?php if($row['STATUS_PEGAWAI']=="Sukarelawan") echo "selected=true"; ?> checked="true" value="Sukarelawan">Sukarelawan</option>
                                    <option <?php if($row['STATUS_PEGAWAI']=="PPT") echo "selected=true"; ?> value="PTT">PTT</option>
                                </select>
                            </div>
                        </div> 
						<input class="btn btn-primary pull-right" type="submit" value="Ubah" id="submit" name="submit">
					 </section>
				</div>
			</div>
			</section>
		</div>
		</div>
		<div class="col-lg-6">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Ubah Password' ?></h3>
			</header>
			<section class="panel">
				<input hidden=true type="text" id="selectedAkun" name="selectedAkun" value="<?php echo $row['ID_AKUN']; ?>">
			<div class="panel-body">
				<div class="col-lg-12">
					<section class="panel">
						<div class="form-group">
                            <label class="col-sm-3">Password Sekarang</label>
                            <div class="col-sm-9">
                                <input type="password" id="inputOld" name="inputOld" class="form-control" placeholder="Masukkan Password Sekarang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">Konfirmasi Password</label>
                            <div class="col-sm-9">
                                <input type="password" id="inputCheck" name="inputCheck" class="form-control" placeholder="Masukkan Password Sekarang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">Password Baru</label>
                            <div class="col-sm-9">
                                <input type="password" id="inputNew" name="inputNew" class="form-control" placeholder="Masukkan Password Terbaru">
                                <!--<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>-->
                            </div>
                        </div>
					 </section>
				</div>
			</div>
			</section>
		</div>
		</div>
	</div>
	</div>
	<input type="hidden" id="rowNum" name="rowNum">
	</form>
	</div>
</div>

<script>    
	var arrayHA = new Array();
	var arrayUnit = new Array();
	var currentHa = '';
	var numTask =0;
	
	$( document ).ready(function() {
		<?php if($check == 'passError') echo 'alert("Perubahan Password Gagal");'; ?>
		
	});
	
	function createHA(stringHA)
	{
		var splitUnit = stringHA.split("_");
		arrayUnit[arrayUnit.length] = splitUnit[0];
		
		if($('#inputUnit').val().indexOf('Admin') !== -1)
			var insert = '<tr><td>Admin Puskesmas - '+splitUnit[1]+'<input type="hidden" name="unit'+numTask+'" value=adm'+splitUnit[0]+'></td><td><button data-dismiss="modal" class="btn btn-primary" id="'+arrayUnit.length+'" type="button" onclick=deleteAssignment(this.id)>Hapus</button></td></tr>';
			else
			var insert = '<tr><td>'+splitUnit[1]+' - '+splitUnit[1]+'<input type="hidden" name="unit'+numTask+'" value='+splitUnit[0]+'></td><td><button data-dismiss="modal" class="btn btn-primary" id="'+arrayUnit.length+'" type="button" onclick=deleteAssignment(this.id)>Hapus</button></td></tr>';
		table.innerHTML = table.innerHTML+insert;
	}
	function myCreateFunction() {
		numTask += 1;
		var table = document.getElementById("insertData");
		var splitUnit = $('#inputUnit').val().split("_");
		arrayUnit[arrayUnit.length] = splitUnit[0];
		
		if($('#inputUnit').val().indexOf('Admin') !== -1)
			var insert = '<tr><td>Admin Puskesmas - '+splitUnit[1]+'<input type="hidden" name="unit'+numTask+'" value=adm'+splitUnit[0]+'></td><td><button data-dismiss="modal" class="btn btn-primary" id="'+arrayUnit.length+'" type="button" onclick=deleteAssignment(this.id)>Hapus</button></td></tr>';
			else
			var insert = '<tr><td>'+splitUnit[1]+' - '+splitUnit[1]+'<input type="hidden" name="unit'+numTask+'" value='+splitUnit[0]+'></td><td><button data-dismiss="modal" class="btn btn-primary" id="'+arrayUnit.length+'" type="button" onclick=deleteAssignment(this.id)>Hapus</button></td></tr>';
		table.innerHTML = table.innerHTML+insert;
		document.getElementById("rowNum").value = numTask;
	}

	$("#sendAssignment").click(function () {
			var tempHA ='';
			var tempUnit = '';
			var index = 0;
			for(index = 0;index<arrayHA.length;index++){
				tempHA += arrayHA[index]+',';
				tempUnit += arrayUnit[index]+',';
			}
			
			$.ajax({
			traditional: true,
			url: '<?php echo base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/addTask' ?>',
			type: "POST",
			data: { dataHA:tempHA,dataUnit:tempUnit,dataAkun:$('#inputNoid').val() },
			success: function(){
				alert('Penambahan Berhasil');
			},
			error: function (jqXHR, exception) {
				alert('Penambahan Gagal');
			}
		});
	});
	
	function deleteAssignment(arrayNumber) {
		arrayHA.splice(arrayNumber, 1);
		arrayUnit.splice(arrayNumber, 1);
		document.getElementById("assTable").deleteRow(arrayNumber);
	}
	function myShowPenugasan() {
		$.ajax({
		   url:'<?php echo base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/addAccount' ?>',
		   type: 'POST',
		   data: $("#formInput").serialize(),
		   success: function(){
				currentHa = <?php echo $this->session->userdata['telah_masuk']['idha'] ?>;
				if(currentHa != 19)
				{
					document.getElementById("penugasan").hidden = false;
					document.getElementById("inputNoid").readOnly = true;
					document.getElementById("inputNama").readOnly = true;
					document.getElementById("inputAlamat").readOnly = true;
					document.getElementById("inputSex").readOnly = true;
					document.getElementById("inputTelepon").readOnly = true;
					document.getElementById("inputHandphone").readOnly = true;
					document.getElementById("inputEmail").readOnly = true;
					document.getElementById("inputAgama").readOnly = true;
					document.getElementById("inputStatus").readOnly = true;
				}				
		   },
		   error: function(){
			   alert("Input Kembali")
			}
		});
	}
</script>