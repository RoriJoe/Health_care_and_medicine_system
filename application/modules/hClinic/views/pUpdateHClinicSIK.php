<?php
$row = $selectedPuskesmas[0];
?>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<div class="panel-body">
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<header class="panel-heading">
							<h3 class="panel-title"><?= 'Data Puskesmas' ?></h3>
						</header>
						<section class="panel">
							<div class="panel-body">
								<form class="form-horizontal bucket-form"  method="post" action="<?php echo base_url().'index.php/HClinic/'.$this->uri->segment(2, 0).'/saveUpdatePuskesmas' ?>">
									<input type="text" hidden="hidden" id="selectedIdGedung" name="selectedIdGedung" value="<?php echo $row['ID_GEDUNG']; ?>">
									<div class="form-group">
										<label class="col-sm-3 control-label">No Identitas</label>
										<div class="col-sm-9">
											<input type="text" id="inputNoidGedung" name="inputNoidGedung" value="<?php echo $row['NOID_GEDUNG']; ?>" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Nama</label>
										<div class="col-sm-9">
											<input type="text" id="inputNamaGedung" name="inputNamaGedung" value="<?php echo $row['NAMA_GEDUNG']; ?>" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Alamat</label>
										<div class="col-sm-9">
											<input type="text" id="inputJalan" name="inputJalan" value="<?php echo $row['JALAN_GEDUNG']; ?>" class="form-control">
											<!--<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>-->
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Kelurahan</label>
										<div class="col-sm-9">
											<input type="text" id="inputKelurahan" name="inputKelurahan" value="<?php echo $row['KELURAHAN_GEDUNG']; ?>" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Kecamatan</label>                        
										<div class="col-sm-9">
											<input type="text" id="inputKecamatan" name="inputKecamatan" value="<?php echo $row['KECAMATAN_GEDUNG']; ?>" class="form-control">
										</div>
									</div>                    
									<div class="form-group">
										<label class="col-sm-3 control-label">Kabupaten</label>
										<div class="col-sm-9">
											<input type="text" id="inputKabupaten" name="inputKabupaten" value="<?php echo $row['KABUPATEN_GEDUNG']; ?>" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Provinsi</label>
										<div class="col-sm-9">
											<input type="text" id="inputProvinsi" name="inputProvinsi" value="<?php echo $row['PROVINSI_GEDUNG']; ?>" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Kepala Puskesmas</label>
										<div class="col-sm-9">
											<select class="form-control m-bot15" id="inputKP" name="inputKP">
												<option value=''>Tidak Ada</option>
												<?php
													if(isset($KP[0]['ID_AKUN']))
													echo '<option selected value="'.$KP[0]['ID_AKUN'].'">'.$KP[0]['NAMA_AKUN'].'</option>';
													foreach($allAvailableAcc as $avacc)
													{
														echo '<option value="'.$avacc['ID_AKUN'].'">'.$avacc['NAMA_AKUN'].'</option>';
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Admin Puskesmas</label>
										<div class="col-sm-9">
											<select class="form-control m-bot15" id="inputAP" name="inputAP">
													<option value=''>Tidak Ada</option>
												<?php
													if(isset($AP[0]['ID_AKUN']))
													echo '<option selected value="'.$AP[0]['ID_AKUN'].'">'.$AP[0]['NAMA_AKUN'].'</option>';
													foreach($allAvailableAcc as $avacc)
													{
														echo '<option value="'.$avacc['ID_AKUN'].'">'.$avacc['NAMA_AKUN'].'</option>';
													}
												?>
											</select>
										</div>
									</div>		
									<div class="form-group">
										<label class="col-sm-3 control-label">Gudang Obat Puskesmas</label>
										<div class="col-sm-9">
											<select class="form-control m-bot15" id="inputGOP" name="inputGOP">
													<option value=''>Tidak Ada</option>
												<?php
													if(isset($GOP[0]['ID_AKUN']))
													echo '<option selected value="'.$GOP[0]['ID_AKUN'].'">'.$GOP[0]['NAMA_AKUN'].'</option>';
													foreach($allAvailableAcc as $avacc)
													{
														echo '<option value="'.$avacc['ID_AKUN'].'">'.$avacc['NAMA_AKUN'].'</option>';
													}
												?>
											</select>
										</div>
									</div>				
									<div class="form-group">
										<div class="col-sm-9">
											<input class="btn btn-primary pull-right" type="submit" value="update" name="submit">
										</div>
									</div>
								</form>
							</div>
						</section>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<script>
$('#formInput').submit(function(e){
		if ( $( "#inputKP" ).val() == '' || $( "#inputAP" ).val() == '' || $( "#inputGOP" ).val() == '') {
		alert("Masukkan Penanggung Jawab Puskesmas");
		e.preventDefault();
		}
	})
</script>