<div class="container">	
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <header class="panel-heading">
                <h3 class="panel-title"><?= 'Daftar '.$jenisTransNama1 ?></h3>
            </header>
            <div class="panel-body">
                <?php if($this->uri->segment(4, 0)=='permintaan_apotik'){ ?>
                <button class="btn btn-primary pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/obatKeluar/newApotik' ?>';">Pengiriman Baru</button>
                <?php }else if($this->uri->segment(4, 0)=='permintaan_pustu'){ ?>
                <button class="btn btn-primary pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/obatKeluar/newPustu/' ?>';">Pengiriman Baru</button>
                <?php }else if($this->uri->segment(4, 0)=='daftar_permintaan' && $this->uri->segment(2, 0)=='lo'){ ?>
                <button class="btn btn-primary pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/obatKeluar/pengurangan' ?>';">Pengiriman Baru</button>
                <?php } ?>
                <br/><br/>
                <table class="table table-striped table-hover table-bordered" id="editable-sample">
                    <thead>
                    <tr>
                        <th>No</th>
                        <?php if($this->uri->segment(4, 0)!='permintaan_apotik') echo '<th>Unit</th>'; ?>
                        <th>Tanggal</th>
                        <th>Detail</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php for($i=0; $i<sizeof($permintaan); $i++): ?>
                        <tr>
                            <td><?php $count=$i+1; echo $count; ?></td>
                            <?php if($this->uri->segment(4, 0)!='permintaan_apotik') echo '<td>'.$unit[$i][0]['NAMA_UNIT'].'</td>'; ?>
                            <td><?= $permintaan[$i]['TANGGAL_TRANSAKSI'] ?></td>
                            <td>
                                <?php if($this->uri->segment(4, 0)=='permintaan_apotik'){ ?>
                                <button class="btn <?php echo (isset($flag[$i][0]['FLAG_KONFIRMASI']))?'btn-primary':'btn-danger' ?> pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/obatKeluar/detail_apotik/'.$permintaan[$i]['ID_TRANSAKSI'].'/'.$permintaan[$i]['TRANSAKSI_UNIT_DARI'] ?>';" <?php echo (isset($flag[$i][0]['FLAG_KONFIRMASI']))?'disabled':'' ?>><?php echo (isset($flag[$i][0]['FLAG_KONFIRMASI']))?'Terkirim':'Pending' ?></button>
                                <?php }else if($this->uri->segment(4, 0)=='permintaan_pustu'){ ?>
                                <button class="btn <?php echo (isset($flag[$i][0]['FLAG_KONFIRMASI']))?'btn-primary':'btn-danger' ?> pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/obatKeluar/detail_pustu/'.$permintaan[$i]['ID_TRANSAKSI'].'/'.$permintaan[$i]['TRANSAKSI_UNIT_DARI'] ?>';" <?php echo (isset($flag[$i][0]['FLAG_KONFIRMASI']))?'disabled':'' ?>><?php echo (isset($flag[$i][0]['FLAG_KONFIRMASI']))?'Terkirim':'Pending' ?></button>
                                <?php }else if($this->uri->segment(4, 0)=='daftar_permintaan' && $this->uri->segment(2, 0)=='lo'){ ?>
                                <button class="btn <?php echo (isset($flag[$i][0]['FLAG_KONFIRMASI']))?'btn-primary':'btn-danger' ?> pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/obatKeluar/detail_transaksi/'.$permintaan[$i]['ID_TRANSAKSI'].'/'.$permintaan[$i]['TRANSAKSI_UNIT_DARI'] ?>';" <?php echo (isset($flag[$i][0]['FLAG_KONFIRMASI']))?'disabled':'' ?>><?php echo (isset($flag[$i][0]['FLAG_KONFIRMASI']))?'Terkirim':'Pending' ?></button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>