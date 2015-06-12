<div class="container">	
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <header class="panel-heading">
                <h3 class="panel-title"><?= 'Daftar '.$jenisTransNama1 ?></h3>
            </header>
            <div class="panel-body">
                <table class="table table-striped table-hover table-bordered" id="editable-sample">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Detail</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php for($i=0; $i<sizeof($pengiriman); $i++): ?>
                        <tr>
                            <td><?php $count=$i+1; echo $count; ?></td>
                            <td><?= $pengiriman[$i]['TANGGAL_TRANSAKSI'] ?></td>
                            <td>
                                <button class="btn <?php echo (isset($flag[$i][0]['FLAG_KONFIRMASI']))?'btn-primary':'btn-danger' ?> pull-left"  onclick="location.href ='<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/obatMasuk/detail/'.$pengiriman[$i]['ID_TRANSAKSI'].'/'.$pengiriman[$i]['TRANSAKSI_UNIT_DARI'] ?>';" <?php echo (isset($flag[$i][0]['FLAG_KONFIRMASI']))?'disabled':'' ?>><?php echo (isset($flag[$i][0]['FLAG_KONFIRMASI']))?'Terkirim':'Pending' ?></button>
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