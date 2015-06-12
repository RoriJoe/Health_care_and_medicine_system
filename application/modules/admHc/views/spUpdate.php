<?php
if(isset($selectedSPayment[0]))
$row = $selectedSPayment[0];
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
	  <h1>Memasukkan data Sumber Pembayaran</h1>
			<div class="panel-body">
                <form class="form-horizontal bucket-form" method="post" action="<?php echo base_url(); ?>index.php/admHc/spAdmHc/saveUpdateSPayment">
                    <input type="text" hidden="hidden" id="selectedSPayment" name="selectedSPayment" value="<?php echo $row['ID_SUMBER']; ?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Sumber Pembayaran</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputNamaSumberPembayaran" name="inputNamaSumberPembayaran" value="<?php echo $row['NAMA_SUMBER_PEMBAYARAN']; ?>" class="form-control">
                        </div>
                    </div>
                    <input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
                </form>
            </div>
        </section>
  </div> 