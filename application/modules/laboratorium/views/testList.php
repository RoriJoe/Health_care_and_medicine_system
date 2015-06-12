
<div class="container">
    <div class="row form-group">
        <div class="col-md-4">
            <a style="color: white" type="button" class="btn btn-success" data-toggle="modal" href="#myModal2"> Tambah Data Pengujian <i class="fa fa-plus"></i> </a>
        </div>
        <div class="col-md-8"></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Daftar Pengujian Lab</h3>
                </div>
                <div class="panel-body">
                    <div style="height: 300px; overflow-y: scroll;">
                        <table style="width: 100%;" class="table table-striped table-responsive" id="tabelUji">
                            <thead>
                            <th>Pengujian</th>
                            <th>Spesimen</th>
                            <th>Kategori Pengujian</th>
                            <th>Nilai Normal</th>
                            <th>Satuan Hasil</th>
                            <th></th>
                            <tbody >
                                <?php
                                $r = 1;
                                if (isset($mastertestlist)) :
                                    ?>
                                    <?php foreach ($mastertestlist as $row) : ?>
                                        <tr>		
                                            <td><?php echo $row->NAMA_PEM_LABORAT; ?></td>
                                            <td><?php echo $row->NAMA_SPESIMEN; ?> </td>			
                                            <td><?php echo $row->NAMA_KP_LABORAT; ?></td>
                                            <td><?php echo $row->NILAI_NORMAL_UJI; ?></td>
                                            <td><?php echo $row->SATUAN_HASIL_UJI; ?></td>
                                            <td><button onclick="parse(<?php echo $row->ID_PEM_LABORAT.',\''.$row->NAMA_PEM_LABORAT.'\',\''.$row->NAMA_SPESIMEN.'\','.$row->ID_KAT_SPES.','.$row->ID_KP_LABORAT.',\''.$row->NAMA_KP_LABORAT.'\',\''.$row->NILAI_NORMAL_UJI.'\',\''.$row->SATUAN_HASIL_UJI.'\'';?>)" class="btn btn-primary" data-toggle="modal" href="#myModal">Ubah</button></td>
                                        </tr>
                                        <?php
                                        $r++;
                                    endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display: none;" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header alert alert-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Ubah Data Master Pengujian Lab</h4>
            </div>
            <div class="modal-body">
                <div class="position-center">
                    <form class="form-horizontal" method="post" action="<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/updateTest'; ?>">
                        <div class="form-group">
                            <div class="col-lg-4">
                                <label >Nama Pengujian</label>
                            </div>
                            <div class="col-lg-8">
                                <input required class="form-control" id="namaUji"  name="namaUji" type="text">             
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-4">
                                <label >Spesimen</label>
                            </div>
                            <div class="col-lg-8">
                                <!--<input class="form-control" id="spesimen" name="spesimen" type="text">-->
                                <select required class="form-control" name="spesimen" id="spesimen">
                                    <?php foreach ($spesimen as $v) { ?>
                                        <option value="<?php echo $v->ID_KAT_SPES; ?>"><?php echo $v->NAMA_SPESIMEN; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-lg-4">
                                <label >Kategori Pengujian</label>
                            </div>
                            <div class="col-lg-8">
                                <!--<input class="form-control" id="katUji" name="katUji" type="text">-->
                                <select required class="form-control" name="katUji" id="katUji">
                                    <?php foreach ($katPem as $v) { ?>
                                        <option value="<?php echo $v->ID_KP_LABORAT; ?>"><?php echo $v->NAMA_KP_LABORAT; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-lg-4">
                                <label >Nilai Normal</label>
                            </div>
                            <div class="col-lg-8">
                                <input required class="form-control" id="nilaiNormal" name="nilaiNormal" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-4">
                                <label >Satuan</label>
                            </div>
                            <div class="col-lg-8">
                                <input required class="form-control" id="satuan" name="satuan" type="text">
                            </div>
                        </div>
                        <input class="form-control" id="idpengujian" name="idpengujian" type="hidden">
                        <div class="form-group">
                            <div class="col-lg-4">
                                
                            </div>
                            <div class="col-lg-8">
                                <button type="submit" class="btn btn-primary btn-success">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display: none;" class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header alert alert-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Tambah Data Pengujian Lab</h4>
            </div>
            <div class="modal-body">
                <div class="position-center">
                    <form class="form-horizontal" method="post" action="<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/insertTest'; ?>">
                        <div class="form-group">
                            <div class="col-lg-4">
                                <label >Nama Pengujian</label>
                            </div>
                            <div class="col-lg-8">
                                <input required class="form-control" id="namaUji2"  name="namaUji2" type="text">             
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-4">
                                <label >Spesimen</label>
                            </div>
                            <div class="col-lg-8">
                                <!--<input class="form-control" id="spesimen" name="spesimen" type="text">-->
                                <select required class="form-control" name="spesimen2" id="spesimen2">
                                    <?php foreach ($spesimen as $v) { ?>
                                        <option value="<?php echo $v->ID_KAT_SPES; ?>"><?php echo $v->NAMA_SPESIMEN; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-lg-4">
                                <label >Kategori Pengujian</label>
                            </div>
                            <div class="col-lg-8">
                                <!--<input class="form-control" id="katUji" name="katUji" type="text">-->
                                <select required class="form-control" name="katUji2" id="katUji2">
                                    <?php foreach ($katPem as $v) { ?>
                                        <option value="<?php echo $v->ID_KP_LABORAT; ?>"><?php echo $v->NAMA_KP_LABORAT; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-lg-4">
                                <label >Nilai Normal</label>
                            </div>
                            <div class="col-lg-8">
                                <input required class="form-control" id="nilaiNormal2" name="nilaiNormal2" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-4">
                                <label >Satuan</label>
                            </div>
                            <div class="col-lg-8">
                                <input required class="form-control" id="satuan2" name="satuan2" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-4">
                                
                            </div>
                            <div class="col-lg-8">
                                <button type="submit" class="btn btn-primary btn-success">Tambah Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function parse(idpem,namapem,namaspes,idkatspes,idkplab,namakplab,nilainormal,satuan)
    {
        $('#idpengujian').val(idpem);
        $('#namaUji').val(namapem);
        $('#nilaiNormal').val(nilainormal);
        $('#satuan').val(satuan);
        $("#spesimen").val(idkatspes);
        $("#katUji").val(idkplab);
        
    }
</script>

