<?php
if(isset($selectedHServices[0]))
$row = $selectedHServices[0];
?>
<div class="pg-opt pin">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Welcome, Administrator</h2>
                </div>            
            </div>
        </div>
</div>
  
<div class="row">
<div class="col-lg-6">
      <section class="panel">
	  <h1>Memasukkan data Pelayanan Kesehatan</h1>
			<div class="panel-body">
                <form class="form-horizontal bucket-form" method="post" action="<?php echo base_url(); ?>index.php/admHc/hsAdmHc/saveUpdateHServices">
                    <input type="text" hidden="hidden" id="selectedIdHServices" name="selectedIdHServices" value="<?php echo $row['ID_LAYANAN_KES']; ?>">
                    <div class="form-group">
						<label class="col-sm-3 control-label">Kategori Layanan Kesehatan</label>
						<select class="col-sm-6 input-sm" id="inputIdSCategory" name="inputIdSCategory">
						<?php if(isset($allSCategory)): ?>
						<?php foreach($allSCategory as $rowSCategory): ?>
							<option <?php if($row['ID_KATEGORI_LAYANAN'] == $rowSCategory['ID_KATEGORI_LAYANAN']) echo 'selected = true'; ?> value="<?php echo $rowSCategory['ID_KATEGORI_LAYANAN'] ?>"><?php echo $rowSCategory['NAMA_KATEGORI_LAYANAN'] ?></option>
							<?php endforeach; endif; ?>
						</select>
					</div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Nama Layanan Kesehatan</label>
                        <div class="col-sm-9">
                            <input type="text" id="inputNamaLayananKesehatan" name="inputNamaLayananKesehatan" value="<?php echo $row['NAMA_LAYANAN_KES'] ?>" class="form-control">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Jasa Sarana Kesehatan</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputJasaSarana" name="inputJasaSarana" value="<?php echo $row['JASA_SARANA_KES'] ?>" class="form-control">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Jasa Layanan Kesehatan</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputJasaLayanan" name="inputJasaLayanan" value="<?php echo $row['JASA_LAYANAN_KES'] ?>" class="form-control">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Keterangan</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputKeterangan" name="inputKeterangan" value="<?php echo $row['KETERANGAN_LAYANAN_KES'] ?>" class="form-control">
                        </div>
                    </div>
                    <input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
                </form>
            </div>
        </section>
  </div> 