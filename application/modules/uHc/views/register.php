<section class="slice bg-2 p-15">
        <div class="cta-wr">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <h4>Pendaftaran Unit </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
<div class="row">
<br>
<div class="col-md-6">
    <form class="form-horizontal bucket-form" method="post" action="<?php echo base_url(); ?>index.php/uHc/uHcControl/addUnit">
        <div class="form-group">
            <label class="col-sm-3 control-label">Nama Puskesmas</label>
            <div class="col-sm-9">
				<select class="form-control input-sm m-bot15" id="inputIdGedung" name="inputIdGedung">
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
                <input type="text" id="inputNoidUnit" name="inputNoidUnit" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Nama</label>
            <div class="col-sm-9">
                <input type="text" id="inputNamaUnit" name="inputNamaUnit" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Alamat</label>
            <div class="col-sm-9">
                <input type="text" id="inputJalan" name="inputJalan" class="form-control">
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
            <div class="col-sm-9">
                <input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
            </div>
        </div>
    </form>
</div>
