<script>
	function tes(){
        $("#oi2").val($("#oi1").val());
    }
</script>
<div class="row">
  <div class="col-lg-6">
      <section class="panel">
            <header class="panel-heading">
                Kepala Puskesmas
            </header>
            <div class="panel-body">
                <form class="form-horizontal bucket-form" method="get">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-6">
                            <input oninput="tes()" id="oi1" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nomor Identitas</label>
                        <div class="col-sm-6">
                            <input id="oi2" type="text" class="form-control">
                            <!--<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Alamat</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control round-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Golongan Darah</label>
                        <div class="col-sm-6">
                            <input class="form-control" id="focusedInput" type="text" value="This is focused...">
                        </div>
                    </div>
                    
                </form>
            </div>
        </section>
  </div>
    <div class="col-lg-6">
      <section class="panel">
            <header class="panel-heading">
                Registrasi Pasien Lama
            </header>
            <div class="panel-body">
                <form class="form-horizontal bucket-form" method="get">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nomor Identitas</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control">
                            <!--<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Alamat</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control round-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Golongan Darah</label>
                        <div class="col-sm-6">
                            <input class="form-control" id="focusedInput" type="text" value="This is focused...">
                        </div>
                    </div>
                    
                </form>
            </div>
        </section>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/list.min.js"></script>