<?php
if(isset($selectedRank[0]))
$row = $selectedRank[0];
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
			<div class="panel-body">
                <form class="form-horizontal bucket-form" method="post" action="<?php echo base_url(); ?>index.php/admHc/rAdmHc/saveUpdateRank">
                    <input type="text" hidden="hidden" id="selectedRank" name="selectedRank" value="<?php echo $row['ID_PANGKAT']; ?>">
					<div class="form-group">
                        <label class="col-sm-3 control-label">Nama Pangkat</label>
                        <div class="col-sm-9">
                            <input type="text" id="inputNamaPangkat" name="inputNamaPangkat" value="<?php echo $row['NAMA_PANGKAT'] ?>" class="form-control">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Golongan</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputGolongan" name="inputGolongan" value="<?php echo $row['GOLONGAN'] ?>" class="form-control">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Ruang</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputRuang" name="inputRuang" value="<?php echo $row['RUANG'] ?>" class="form-control">
                        </div>
                    </div>
                    <input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
                </form>
            </div>
        </section>
  </div> 