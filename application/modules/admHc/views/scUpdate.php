<?php
if(isset($selectedSCategory[0]))
$row = $selectedSCategory[0];
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
	  <h1>Memasukkan data Kategori Pelayanan</h1>
			<div class="panel-body">
                <form class="form-horizontal bucket-form" method="post" action="<?php echo base_url(); ?>index.php/admHC/scAdmHC/saveUpdateSCategory">
                    <input type="text" hidden="hidden" id="selectedIdSCategory" name="selectedIdSCategory" value="<?php echo $row['ID_KATEGORI_LAYANAN']; ?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Kategori Layanan</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputNamaKategoriLayanan" name="inputNamaKategoriLayanan" value="<?php echo $row['NAMA_KATEGORI_LAYANAN']; ?>" class="form-control">
                        </div>
                    </div>
                    <input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
                </form>
            </div>
        </section>
  </div> 