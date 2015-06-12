<?php
$row = $selectedDepartment[0];
?>
<div class="row">
  <div class="col-lg-6">
      <section class="panel">
            <header class="panel-heading">
                Perubahan Data Jabatan
            </header>
            <div class="panel-body">
                <form class="form-horizontal bucket-form" method="post" action="<?php echo base_url(); ?>index.php/department/dControl/saveUpdateDepartment">
                    <input type="text" hidden="hidden" id="selectedIdDepartment" name="selectedIdDepartment" value="<?php echo $row['ID_JABATAN']; ?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-6">
                            <input type="text" id="inputNamaDepartment" name="inputNamaDepartment" value="<?php echo $row['NAMA_JABATAN']; ?>" class="form-control">
                        </div>
                    </div>
                    <input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
                </form>
            </div>
        </section>
  </div> 