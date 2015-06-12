<?php
$inventory = $selectedPuskesmas[0];
?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <header class="panel-heading">
                    <h3 class="panel-title"><?= 'Update Inventaris' ?></h3>
                </header>
                <section class="panel">
                    <div class="panel-body">
                        <form class="form-horizontal bucket-form" method="post" action="<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . "/saveUpdatePuskesmas"; ?>">
                            <input type="text" hidden="hidden" id="selectedIdGedung" name="selectedIdGedung" value="<?php echo $inventory['ID_INVENTARIS']; ?>">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nama Unit</label>
                                <div class="col-sm-9">
                                    <select class="form-control m-bot15" id="inputNoidUnit" name="inputNoidUnit">
                                        <?php
                                        foreach ($allUnit as $row) {
                                            
                                            if( $inventory['ID_UNIT'] == $row['ID_UNIT'] )
                                            {
                                                echo '<option selected value="' . $row['ID_UNIT'] . '_' . $row['NAMA_UNIT'] . '">' . $row['NAMA_UNIT'] . '</option>';
                                            }
                                            else
                                            {
                                                echo '<option value="' . $row['ID_UNIT'] . '_' . $row['NAMA_UNIT'] . '">' . $row['NAMA_UNIT'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Kode</label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputKode" name="inputKode" class="form-control" value="<?php echo $inventory['KODE_BARANG'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nama Barang</label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputNama" name="inputNama" class="form-control" value="<?php echo $inventory['NAMA_BARANG'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No Registrasi</label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputNoreg" name="inputNoreg" class="form-control" value="<?php echo $inventory['NO_REG_BARANG'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Merk Type</label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputMerk" name="inputMerk" class="form-control" value="<?php echo $inventory['MERK_TYPE'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Ukuran CC</label>                        
                                <div class="col-sm-9">
                                    <input type="text" id="inputUkuran" name="inputUkuran" class="form-control" value="<?php echo $inventory['UKURAN_CC'] ?>">
                                </div>
                            </div>                    
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Bahan Barang</label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputBahan" name="inputBahan" class="form-control" value="<?php echo $inventory['BAHAN_BARANG'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tahun Pembelian</label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputTahun" name="inputTahun" class="form-control" value="<?php echo $inventory['TAHUN_PEMBELIAN_BARANG'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No. Pabrik</label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputNoPabrik" name="inputNoPabrik" class="form-control" value="<?php echo $inventory['NOMOR_PABRIK'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No. Rangka</label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputNoRangka" name="inputNoRangka" class="form-control" value="<?php echo $inventory['NOMOR_RANGKA'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No. Mesin</label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputNoMesin" name="inputNoMesin" class="form-control" value="<?php echo $inventory['NOMOR_MESIN'] ?>">
                                    <!--<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No Polisi</label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputNoPolisi" name="inputNoPolisi" class="form-control" value="<?php echo $inventory['NOMOR_POLISI'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No. BPKB</label>                        
                                <div class="col-sm-9">
                                    <input type="text" id="inputNoBPKB" name="inputNoBPKB" class="form-control" value="<?php echo $inventory['NOMOR_BPKB'] ?>">
                                </div>
                            </div>                    
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Cara Perolehan</label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputPerolehan" name="inputPerolehan" class="form-control" value="<?php echo $inventory['CARA_PEROLEHAN_BARANG'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Harga</label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputHarga" name="inputHarga" class="form-control" value="<?php echo $inventory['HARGA_BARANG'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <input type="text" id="inputKet" name="inputKet" class="form-control" value="<?php echo $inventory['KETERANGAN_BARANG'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-9">
                                    <input class="btn btn-primary pull-right" type="submit" value="submit" name="submit">
                                </div>

                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <header class="panel-heading">
                    <h3 class="panel-title"><?= 'Daftar Inventaris' ?></h3>
                </header>
                <section class="panel">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-sm-12 adv-table editable-table pull-right">
                                <div class="clearfix">
                                </div>
                                <div class="space15"></div>
                                <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Ubah</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($allPuskesmas)) : ?>
                                            <?php foreach ($allPuskesmas as $row): ?>
                                                <tr><!-- set class using counter i -->
                                                    <td><?php echo $row['KODE_BARANG']; ?></td> <!-- set class using kode obat -->
                                                    <td id="namaGedung<?php echo $row['ID_INVENTARIS']; ?>"><?php echo $row['NAMA_BARANG']; ?></td> <!-- set class using kode obat -->
                                                    <td>
                                                        <a href="<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . "/updateInventory?id=" . $row['ID_INVENTARIS']; ?>">
                                                            <button  type="button" class="btn btn-primary">Edit</button>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) . "/removeInventory?id=" . $row['ID_INVENTARIS']; ?>">
                                                            <button  type="button" class="btn btn-danger">Hapus</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach;
                                        endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div> 
</div>