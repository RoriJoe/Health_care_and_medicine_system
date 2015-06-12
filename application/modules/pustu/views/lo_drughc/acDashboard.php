<div class="container">
    <div class="row">
      <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= 'Dashboard '.$namaUnit ?></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button style="height: 80px;" class="btn btn-primary pull-right col-md-3" onclick="location.href='<?= base_url().$this->uri->segment(1, 0).'/lp' ?>'">Loket Pendaftaran</button>;
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <button style="height: 80px;" class="btn btn-primary col-md-3" onclick="location.href='<?= base_url().$this->uri->segment(1, 0).'/pu' ?>'">Poli Umum</button>
                            </div>
                        </div>					
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button style="height: 80px;" class="btn btn-primary pull-right col-md-3" onclick="location.href='<?= base_url().$this->uri->segment(1, 0).'/kia/dataRiwayat/dashboard' ?>'">Poli KIA</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <button style="height: 80px;" class="btn btn-primary col-md-3" onclick="location.href='<?= base_url().$this->uri->segment(1, 0).'/lo' ?>'">Loket Obat</button>
                            </div>
                        </div>					
                    </div>
                </div>
            </div>
      </div>
    </div>
</div>