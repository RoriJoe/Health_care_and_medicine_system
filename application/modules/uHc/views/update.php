<?php
	$unit = $selectedUnit[0];
?>
<section class="slice bg-2 p-15">
        <div class="cta-wr">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <h4>Detail Unit </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
<div class="row">
	<div class="panel-body">
		<section class="panel">
			<div class="col-md-6">
				<form class="form-horizontal bucket-form" method="post" action="<?php echo base_url().'index.php/uHc/'.$this->uri->segment(2, 0).'/saveUpdateUnit' ?>">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama Puskesmas</label>
						<div class="col-sm-9">
							<select class="form-control m-bot15" id="inputIdGedung" name="inputIdGedung">
							<?php if(isset($allPuskesmas)): ?>
							<?php foreach($allPuskesmas as $row): ?>
								<option value="<?php echo $row['ID_GEDUNG'] ?>"><?php echo $row['NAMA_GEDUNG'] ?></option>
								<?php endforeach; endif; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">No Identitas Unit</label>
						<div class="col-sm-9">
							<input type="text" id="inputNoidUnit" name="inputNoidUnit" class="form-control" value="<?php echo $unit['ID_UNIT'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama</label>
						<div class="col-sm-9">
							<input type="text" id="inputNamaUnit" name="inputNamaUnit" class="form-control" value="<?php echo $unit['NAMA_UNIT'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Alamat</label>
						<div class="col-sm-9">
							<input type="text" id="inputJalan" name="inputJalan" class="form-control" value="<?php echo $unit['JALAN_UNIT'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Kelurahan</label>
						<div class="col-sm-9">
							<input type="text" id="inputKelurahan" name="inputKelurahan" class="form-control" value="<?php echo $unit['KELURAHAN_UNIT'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Kecamatan</label>                        
						<div class="col-sm-9">
							<input type="text" id="inputKecamatan" name="inputKecamatan" class="form-control" value="<?php echo $unit['KECAMATAN_UNIT'];?>">
						</div>
					</div>                    
					<div class="form-group">
						<label class="col-sm-3 control-label">Kabupaten</label>
						<div class="col-sm-9">
							<input type="text" id="inputKabupaten" name="inputKabupaten" class="form-control" value="<?php echo $unit['KABUPATEN_UNIT'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Provinsi</label>
						<div class="col-sm-9">
							<input type="text" id="inputProvinsi" name="inputProvinsi" class="form-control" value="<?php echo $unit['PROVINSI_UNIT'];?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-9">
							<input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<table class="table table-striped table-hover table-bordered" id="editable-sample">
						<thead>
						<tr>
							<th>Nama</th>
							<th>Alamat</th>
							<th>Kelurahan</th>
							<th>Kecamatan</th>
							<th>Kabupaten</th>
							<th>Provinsi</th>
							<th>Ubah</th>
						</tr>
						</thead>
						<tbody>
						<?php if (isset($allUnit)) :?>
						<?php foreach ($allUnit as $row): ?>
							<tr><!-- set class using counter i -->
								<td id="namaGedung<?php echo $row['ID_UNIT'];?>" value="<?php echo $row['NAMA_UNIT'];?>"><?php echo $row['NAMA_UNIT'];?></td> <!-- set class using kode obat -->
								<td><?php echo $row['JALAN_UNIT'];?></td> <!-- set class using kode obat -->
								<td><?php echo $row['KELURAHAN_UNIT'];?></td>
								<td><?php echo $row['KECAMATAN_UNIT'];?></td>
								<td><?php echo $row['KABUPATEN_UNIT'];?></td>
								<td><?php echo $row['PROVINSI_UNIT'];?></td>
								<td>
									<button class="btn btn-primary pull-left"  onclick="location.href ='<?= base_url().'index.php/uHc/'.$this->uri->segment(2, 0).'/updateUnit?id='.$row['ID_UNIT'] ?>';" >Detail</button>
								</td>
							</tr>
						<?php endforeach; endif;?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
