<div class="container">
<div class="row" >
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Pendaftaran Puskesmas' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
				<div class="form-group">
					<form class="form-horizontal bucket-form" id="formInput" method="post" action="<?php echo base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/addPuskesmasSIK'; ?>">
						<div class="form-group">
							<label class="col-sm-3 control-label">No Identitas</label>
							<div class="col-sm-9">
								<input type="text" id="inputNoidGedung" name="inputNoidGedung" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nama</label>
							<div class="col-sm-9">
								<input type="text" id="inputNamaGedung" name="inputNamaGedung" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Alamat</label>
							<div class="col-sm-9">
								<input type="text" id="inputJalan" name="inputJalan" class="form-control">
								<!--<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>-->
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Kelurahan</label>
							<div class="col-sm-9">
								<input type="text" id="inputKelurahan" name="inputKelurahan" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Kecamatan</label>                        
							<div class="col-sm-9">
								<input type="text" id="inputKecamatan" name="inputKecamatan" class="form-control">
							</div>
						</div>                    
						<div class="form-group">
							<label class="col-sm-3 control-label">Kabupaten</label>
							<div class="col-sm-9">
								<input type="text" id="inputKabupaten" name="inputKabupaten" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Provinsi</label>
							<div class="col-sm-9">
								<input type="text" id="inputProvinsi" name="inputProvinsi" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Kepala Puskesmas</label>
							<div class="col-sm-9">
								<select class="form-control m-bot15" id="inputKP" name="inputKP">
									<?php
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
									<?php
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
									<?php
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
								<input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
							</div>
						</div>
					</form>
				</div>
			</div>
			</section>
		</div>
  </div>  
<div class="col-lg-6">  
<div class="col-lg-12">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Data Puskesmas' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-12 adv-table editable-table pull-right">
                        <div class="clearfix">
                        </div>
                        <div class="space15"></div>
                        <table class="table table-striped table-hover table-bordered" id="editable-sample">
                            <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Ubah</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($allPuskesmas)) :?>
                            <?php foreach ($allPuskesmas as $row): ?>
                                <tr><!-- set class using counter i -->
                                    <td><?php echo $row['NOID_GEDUNG'];?></td> <!-- set class using kode obat -->
                                    <td id="namaGedung<?php echo $row['ID_GEDUNG'];?>"><?php echo $row['NAMA_GEDUNG'];?></td> <!-- set class using kode obat -->
                                    <td>
                                        <a href="<?php echo base_url().'index.php/hClinic/'.$this->uri->segment(2, 0).'/updatePuskesmas?id='.$row['ID_GEDUNG']?>">
                                            <button  type="button" data-dismiss="modal" aria-hidden="true">Edit</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
			</div>
			</section>
		</div>
</div>
<div class="col-lg-12">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Data Gudang Farmasi Kabupaten' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-12 adv-table editable-table pull-right">
                        <div class="clearfix">
                        </div>
                        <div class="space15"></div>
                        <table class="table table-striped table-hover table-bordered" id="editable-sample">
                            <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Ubah</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($gfk)) :?>
                            <?php foreach ($gfk as $row): ?>
                                <tr><!-- set class using counter i -->
                                    <td><?php echo $row['NOID_GEDUNG'];?></td> <!-- set class using kode obat -->
                                    <td id="namaGedung<?php echo $row['ID_GEDUNG'];?>"><?php echo $row['NAMA_GEDUNG'];?></td> <!-- set class using kode obat -->
                                    <td>
                                        <a href="<?php echo base_url().'index.php/hClinic/'.$this->uri->segment(2, 0).'/updatePuskesmas?id='.$row['ID_GEDUNG']?>">
                                            <button  type="button" data-dismiss="modal" aria-hidden="true">Edit</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
			</div>
			</section>
		</div>
</div>
<div class="col-lg-12">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Data Dinas Kesehatan' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-12 adv-table editable-table pull-right">
                        <div class="clearfix">
                        </div>
                        <div class="space15"></div>
                        <table class="table table-striped table-hover table-bordered" id="editable-sample">
                            <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Ubah</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($dinas)) :?>
                            <?php foreach ($dinas as $row): ?>
                                <tr><!-- set class using counter i -->
                                    <td><?php echo $row['NOID_GEDUNG'];?></td> <!-- set class using kode obat -->
                                    <td id="namaGedung<?php echo $row['ID_GEDUNG'];?>"><?php echo $row['NAMA_GEDUNG'];?></td> <!-- set class using kode obat -->
                                    <td>
                                        <a href="<?php echo base_url().'index.php/hClinic/'.$this->uri->segment(2, 0).'/updatePuskesmas?id='.$row['ID_GEDUNG']?>">
                                            <button  type="button" data-dismiss="modal" aria-hidden="true">Edit</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
			</div>
			</section>
		</div>
</div>
</div>
</div>
</div>
<script>
function doconfirm()
{
    job=confirm("Are you sure to delete permanently?");
    if(job!=true)
    {
        return false;
    }
}


	$('#formInput').submit(function(e){
		if ( $( "#inputKP" ).val() == '' || $( "#inputAP" ).val() == '' || $( "#inputGOP" ).val() == '') {
		alert("Masukkan Penanggung Jawab Puskesmas");
		e.preventDefault();
		}
	})
</script>