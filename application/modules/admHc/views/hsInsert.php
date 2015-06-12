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
<div class="col-lg-9">
			<h1>Memasukkan data Pelayanan Kesehatan</h1>
      <section class="panel">
          
            <div style="display: none;" class="modal fade in" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel" aria-hidden="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Konfirmasi</h4>
                    </div>
                    <div class="modal-body">

                        Apakah Anda yakin menghapus entri ?

                    </div>
                    <div class="modal-footer">
                    <form class="form-vertical" method="post" action="<?php echo base_url(); ?>index.php/hClinic/hClinic/removePuskesmas">
                    <div class="form-group">
                    <input type="text" id="selected" name="selected" hidden="hidden"/> 
                    <button data-dismiss="modal" class="btn btn-default" type="button">Tutup</button>
                    <button class="btn btn-danger" type="submit">Hapus</button>
                    </div>
                    </form>
                    </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <form class="form-horizontal bucket-form" method="post" action="<?php echo base_url(); ?>index.php/admHc/hsAdmHc/addHServices">
                    <div class="col-sm-9">
						
					<div class="form-group">
						<label class="col-sm-3 control-label">Kategori Layanan Kesehatan</label>
						<select class="col-sm-6 input-sm" id="inputIdSCategory" name="inputIdSCategory">
						<?php if(isset($allSCategory)): ?>
						<?php foreach($allSCategory as $row): ?>
							<option value="<?php echo $row['ID_KATEGORI_LAYANAN'] ?>"><?php echo $row['NAMA_KATEGORI_LAYANAN'] ?></option>
							<?php endforeach; endif; ?>
						</select>
					</div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Nama Layanan Kesehatan</label>
                        <div class="col-sm-9">
                            <input type="text" id="inputNamaLayananKesehatan" name="inputNamaLayananKesehatan" class="form-control">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Jasa Sarana Kesehatan</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputJasaSarana" name="inputJasaSarana" class="form-control">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Jasa Layanan Kesehatan</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputJasaLayanan" name="inputJasaLayanan" class="form-control">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Keterangan</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputKeterangan" name="inputKeterangan" class="form-control">
                        </div>
                    </div>
                    <input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
					</div>
                </form>
            </div>
        </section>
  </div>    