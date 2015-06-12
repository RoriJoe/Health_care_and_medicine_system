<div class="container">
    <div class="row">
        <div class="col-md-12">
            <section class="slice bg-2 p-15">
                <h4><?= 'Pilihan Poli '.$namaUnit ?></h4>
            </section> &nbsp;
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button style="height: 80px;" class="btn btn-primary pull-right col-md-3" onclick="location.href='<?= base_url().$this->uri->segment(1, 0) . '/kia/dataRiwayat/kia'; ?>'">Poli Ibu Hamil</button>;
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <button style="height: 80px;" class="btn btn-primary col-md-3" onclick="location.href='<?= base_url().$this->uri->segment(1, 0) . '/kia/dataRiwayat/vkkia'; ?>'">Poli VK KIA</button>
                        </div>
                    </div>					
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button style="height: 80px;" class="btn btn-primary pull-right col-md-3" onclick="location.href='<?= base_url().$this->uri->segment(1, 0) . '/kia/dataRiwayat/balita'; ?>'">Poli Anak-Balita</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <button style="height: 80px;" class="btn btn-primary col-md-3" onclick="location.href='<?= base_url().$this->uri->segment(1, 0) . '/kia/dataRiwayat/kb'; ?>'">Poli KB</button>
                        </div>
                    </div>					
                </div>
            </div>
        </div>
    </div>
</div>