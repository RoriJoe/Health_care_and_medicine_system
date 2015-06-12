<!-- css pagination -->
<style> 
    ul.tsc_pagination { margin:4px 0; padding:0px; height:100%; overflow:hidden; font:12px 'Tahoma'; list-style-type:none; }
    ul.tsc_pagination li { float:left; margin:0px; padding:0px; margin-left:5px; }

    ul.tsc_pagination li a { color:black; display:block; text-decoration:none; padding:7px 10px 7px 10px; }


    ul.tsc_paginationA li a { color:#FFFFFF; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px; }

    ul.tsc_paginationA01 li a { color:#474747; border:solid 1px #B6B6B6; padding:6px 9px 6px 9px; background:#E6E6E6; background:-moz-linear-gradient(top, #FFFFFF 1px, #F3F3F3 1px, #E6E6E6); background:-webkit-gradient(linear, 0 0, 0 100%, color-stop(0.02, #FFFFFF), color-stop(0.02, #F3F3F3), color-stop(1, #E6E6E6)); }
    ul.tsc_paginationA01 li:hover a,
    ul.tsc_paginationA01 li.current a { background:#FFFFFF; }
</style>
<div class="container">
<div class="row">
  <div class="col-lg-12">
        <div class="panel panel-primary">
            <header class="panel-heading">
                <h3 class="panel-title"><?= 'Daftar Pasien' ?></h3>
            </header>
            <div class="panel-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="control-label col-sm-2"><h5>Mulai Tanggal</h5></label>
                            <div class="col-sm-3">
                                <input name="mulai" class="mulai form-control form-control-inline default-date-picker"  size="16" type="text" value="<?php if($this->uri->segment(5, 0)) echo $this->uri->segment(5, 0); else echo date('m-d-Y'); ?>" />
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="control-label col-sm-2"><h5>Hingga Tanggal</h5></label>
                            <div class="col-sm-3">
                                <input name="hingga" class="hingga form-control form-control-inline default-date-picker"  size="16" type="text" value="<?php if($this->uri->segment(6, 0)) echo $this->uri->segment(6, 0); else echo date('m-d-Y',strtotime("+2 week")); ?>" />
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-primary pull-right"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0) ?>'+'/resepPasien/list/'+$('.mulai').val()+'/'+$('.hingga').val()">Ubah Daftar Resep</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 adv-table editable-table ">
                        <div class="clearfix">
                        </div>
                        <div class="space15"></div>
                        <table class="table table-striped table-hover table-bordered" id="editable-sample">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>No Rekam Medik</th>
                                <th>Tanggal Resep</th>
                                <th>Kelola</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php for($i=0; $i<sizeof($pasien); $i++): ?>
                                <tr>
                                    <td><?php $count=$i+1; echo $count; ?></td>
                                    <td><?= $pasien[$i]['NAMA_PASIEN'] ?></td>
                                    <td><?= $pasien[$i]['NOID_REKAMMEDIK'] ?></td>
                                    <td><?= $pasien[$i]['TANGGAL_TRANSAKSI'] ?></td>
                                    <td>
                                        <button class="btn btn-primary pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/resepPasien/detailObat/'.$pasien[$i]['ID_PASIEN'].'/'.$pasien[$i]['ID_TRANSAKSI']  ?>';" >Detail</button>
                                    </td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12"><?= $links; ?></div>
                </div>
            </div>
        </div>
  </div>
</div>
</div>