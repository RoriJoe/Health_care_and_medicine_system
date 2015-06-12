<?php
	$unit = $selectedUnit[0];
?>
<div class="container">
<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Pendaftaran Unit' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
				<form class="form-horizontal bucket-form" method="post" action="<?php echo base_url().'index.php/uHc/'.$this->uri->segment(2, 0).'/saveUpdateUnit' ?>">
					
					<input type="hidden" id="inputIdUnit" name="inputIdUnit" class="form-control" value="<?php echo $unit['ID_UNIT'];?>">
					<div class="form-group">
						<label class="col-sm-3 control-label">Tipe Unit</label>
						<div class="col-sm-9">
							<select class="form-control m-bot15" id="inputTipeUnit" name="inputTipeUnit" onchange="checkAddress()">
							<?php if(isset($unitOption)): ?>
							<?php foreach($unitOption as $row): ?>
								<option value="1_<?php echo $row ?>"><?php echo $row ?></option>
								<?php endforeach; endif; ?>
								<?php if(stristr($selectedUnitName,"Pustu")) echo '<option value="2_Pustu">Pustu / Polindes / Ponkesdes</option>'; else echo '<option value="1_'.$selectedUnitName.'">'.$selectedUnitName.'</option><option value="2_Pustu">Pustu</option>' ?>
								<div id="addUnit"></div>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">No Identitas Unit</label>
						<div class="col-sm-9">
							<input type="text" id="inputNoidUnit" name="inputNoidUnit" class="form-control" value="<?php echo $unit['NOID_UNIT'];?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama</label>
                                                <div class="col-sm-4">
                                                    <select required name="namaAwalan" class="form-control" >
                                                    <?php 
                                                        $temp = explode('Pustu ', $unit['NAMA_UNIT']);  
                                                        $temp2 = explode('Polindes ', $unit['NAMA_UNIT']); 
                                                        $temp3 = explode('Ponkesdes ', $unit['NAMA_UNIT']); 
                                                        if(!empty($temp[1]))
                                                        {
                                                        ?>
                                                            <option selected value="Pustu">Pustu</option>
                                                            <option value="Polindes">Polindes</option>
                                                            <option value="Ponkesdes">Ponkesdes</option>
                                                            </select>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <input required type="text" id="inputNamaUnit" name="inputNamaUnit" class="form-control" value="<?php $temp = explode('Pustu ', $unit['NAMA_UNIT']); echo $temp[1];?>" placeholder="Namanya Saja" >
                                                            </div>
                                                        <?php
                                                        }
                                                        else if(!empty($temp2[1]))
                                                        { 
                                                        ?>
                                                            <option value="Pustu">Pustu</option>
                                                            <option selected value="Polindes">Polindes</option>
                                                            <option value="Ponkesdes">Ponkesdes</option>
                                                            </select>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <input required type="text" id="inputNamaUnit" name="inputNamaUnit" class="form-control" value="<?php $temp = explode('Polindes ', $unit['NAMA_UNIT']); echo $temp[1];?>" placeholder="Namanya Saja" >
                                                            </div>
                                                        <?php
                                                        }
                                                        else if(!empty($temp3[1]))
                                                        { 
                                                        ?>
                                                            <option value="Pustu">Pustu</option>
                                                            <option value="Polindes">Polindes</option>
                                                            <option selected value="Ponkesdes">Ponkesdes</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <input required type="text" id="inputNamaUnit" name="inputNamaUnit" class="form-control" value="<?php $temp = explode('Ponkesdes ', $unit['NAMA_UNIT']); echo $temp[1];?>" placeholder="Namanya Saja" >
                                                            </div>
                                                        <?php
                                                        }
                                                    ?>
                                                    
<!--						<div class="col-sm-9">
                                                    <input required type="text" id="inputNamaUnit" name="inputNamaUnit" class="form-control" value="<?php $temp = explode('Pustu ', $unit['NAMA_UNIT']); echo $temp[1];?>" placeholder="Nama Saja, Tanpa Pustu / Semacamnya" >
						</div>-->
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Alamat</label>
						<div class="col-sm-9">
							<input required type="text" id="inputJalan" name="inputJalan" class="form-control" value="<?php echo $unit['JALAN_UNIT'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Kelurahan</label>
						<div class="col-sm-9">
							<input required type="text" id="inputKelurahan" name="inputKelurahan" class="form-control" value="<?php echo $unit['KELURAHAN_UNIT'];?>">
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
						<div class="col-sm-12">
							<input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
						</div>
					</div>
				</form>
			</div>
			</section>
		</div>
	</div>
			<div class="col-lg-6">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Data Poli Sekarang' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
				<div class="form-group">
					<table class="table table-striped table-hover table-bordered" id="editable-sample">
						<thead>
						</thead>
						<tbody>
						<?php if (isset($allPoli)) :?>
						<?php foreach ($allPoli as $row): ?>
							<tr><!-- set class using counter i -->
								<td id="namaGedung<?php echo $row['ID_UNIT'];?>" value="<?php echo $row['NAMA_UNIT'];?>"><?php echo $row['NAMA_UNIT'];?></td> <!-- set class using kode obat -->
							</tr>
						<?php endforeach; endif;?>
						</tbody>
					</table>
				</div>
			</div>
			</section>
        </div>
    </div>
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Data Pustu / Polindes / Ponkesdes Sekarang' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
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
						<?php if (isset($allPustu)) :?>
						<?php foreach ($allPustu as $row): ?>
							<tr><!-- set class using counter i -->
								<td id="namaGedung<?php echo $row['ID_UNIT'];?>" value="<?php echo $row['NAMA_UNIT'];?>"><?php echo $row['NAMA_UNIT'];?></td> <!-- set class using kode obat -->
								<td><?php echo $row['JALAN_UNIT'];?></td> <!-- set class using kode obat -->
								<td><?php echo $row['KELURAHAN_UNIT'];?></td>
								<td><?php echo $row['KECAMATAN_UNIT'];?></td>
								<td><?php echo $row['KABUPATEN_UNIT'];?></td>
								<td><?php echo $row['PROVINSI_UNIT'];?></td>
								<td>
									<button class="btn btn-primary pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/updateUnit?id='.$row['ID_UNIT'] ?>';" >Detail</button>
								</td>
								<!--
								<td>
									<a class="btn" data-toggle="modal" href="#deleteConfirmModal" id="<?php echo $row['ID_UNIT']?>_" onclick="myFunction2(this.id)">
										�
									</a>
								</td>
								-->
							</tr>
						<?php endforeach; endif;?>
						</tbody>
					</table>
				</div>
			</div>
			</section>
        </div>
    </div>
</div>
</div>
<script>
function checkAddress()
{
	var selectedUnitType = document.getElementById("inputTipeUnit").value
	var unitType = selectedUnitType.split("_");
	if(unitType[0] == 2)
		document.getElementById('inputNamaUnit').readOnly = false;
	$('#inputNamaUnit').val(unitType[1]);
}
</script>