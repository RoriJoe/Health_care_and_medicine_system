<?php //var_dump($beds); ?>

			<div class="col-md-12">
				<div class="row form-group">
					<form id="FormTambahRuangan" method="post" action="<?php echo base_url(); ?>care/addNewRoom">
					<div class="form-group">
							<label >Nama Ruangan</label>
							<input class="form-control" id="ruangan" name="ruangan" type="text">
					</div>
						<div class="form-group">
							<input class="btn btn-primary" value="Tambah" type="submit">
						</div>
					</form>
				</div>
			</div>
			
			<div class="col-md-12">
				<hr>
				<form id="FormTambahTT" method="post" action="<?php echo base_url(); ?>care/ri/addNewBed"
				<div class="row form-group">					
					<div class="form-group">
							<label >Kategori Tempat Tidur</label>
							<select required class="form-control" id="kategoritt" name="kategoritt" >
								<option selected value="">Pilih Kategori Tempat Tidur</option>
								<?php if (isset($bedcat)) : ?>
								<?php 
									foreach ($bedcat as $row ):
								?>
								<option value="<?php echo $row['ID_KAT_TT']; ?>"> <?php echo $row['NAMA_KATEGORI_TT']; ?> </option>
								<?php endforeach; endif; ?>
							</select>
					</div>
					<div class="form-group">
							<label >Ruangan</label>
							<select required class="form-control" id="ruangantt" name="ruangantt" >
								<option selected value="">Pilih Ruangan</option>
								<?php if (isset($rooms)) : ?>
								<?php 
									foreach ($rooms as $row ):
								?>
								<option value="<?php echo $row['ID_RUANGAN_RI']; ?>"> <?php echo $row['NAMA_RUANGAN_RI']; ?> </option>
								<?php endforeach; endif; ?>
							</select>
					</div>
					<div class="form-group">
							<label >Nomor Tempat Tidur</label>
							<input required placeholder="Masukkan Nomor Tempat Tidur" class="form-control" id="nomortt" name="nomortt" type="text">
					</div>
					<div class="form-group">
						<input class="btn btn-primary" value="Tambah" type="submit">
					</div>					
				</div>
				</form>
			</div>