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
                <form class="form-horizontal bucket-form" method="post" action="<?php echo base_url(); ?>index.php/admHc/rAdmHc/addRank">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Pangkat</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputNamaPangkat" name="inputNamaPangkat" class="form-control">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Golongan</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputGolongan" name="inputGolongan" class="form-control">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Ruang</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputRuang" name="inputRuang" class="form-control">
                        </div>
                    </div>
                    <input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
                </form>
            </div>
        </section>
  </div>    