<?php
$i=1;
?>

<!-- Pop up isian tambah Kategori Pelayanan baru -->
                <div style="display: none;" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Tambah Sumber Pembayaran Baru</h4>
                            </div>
                            <div class="modal-body">
                                <div class="position-center">
                                <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/admHc/scAdmHc/addSCategory">
                                <div class="form-group">
                                <label for="inputKode" class="col-lg-2 col-sm-2 control-label">Nama Kategori Layanan</label>
                                <div class="col-lg-10">
                                <input class="form-control" id="inputNamaKategoriLayanan"  name="inputNamaKategoriLayanan" type="text">             
                                </div> 
                                </div>
                                <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                                </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!-- End of Modal -->

<div class="row">
	<div class="panel-body">
		<div class="col-lg-6">
		    <section class="panel">
				<div class="panel-body">
					<a style="color: white;" type="button" class="btn btn-success"  data-toggle="modal" href="#myModal"> Tambah Kategori Layanan <i class="fa fa-plus"></i> </a>
				</div>
			</section>
		</div>
		<div class="col-lg-9">
		  <section class="panel">

				<div style="display: none;" class="modal fade in" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel" aria-hidden="false">
					<div class="modal-dialog">
						<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title">Konfirmasi</h4>
						</div>
						<div class="modal-body">

							Apakah Anda yakin menghapus entri ?

						</div>
						<div class="modal-footer">
						<form class="form-vertical" method="post" action="<?php echo base_url(); ?>index.php/account/control/removeAccount">
						<div class="form-group">
						<input type="text" id="selected" name="selected" hidden="hidden"/> 
						<button data-dismiss="modal" class="btn btn-default" type="button">Tutup</button>
						<button class="btn btn-danger" type="submit">Hapus</button>
						</div>
						</form>
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
										<th>Kategori Layanan</th>
										<th></th>
									</tr>
									</thead>
									<tbody>
									<?php if (isset($allCategory)) :?>
									<?php foreach ($allCategory as $row): ?>
										<tr>
											<td><?php echo $i; ?></td> 
											<?php $i++; ?>
											<td id="namaGedung<?php echo $row['ID_KATEGORI_LAYANAN'];?>" value="<?php echo $row['NAMA_KATEGORI_LAYANAN'];?>"><?php echo $row['NAMA_KATEGORI_LAYANAN'];?></td> 
											<td align="center">
												<button class="btn btn-primary pull-left"  onclick="location.href ='<?= base_url().'index.php/admHC/scAdmHC/updateSCategory?id='.$row['ID_KATEGORI_LAYANAN'] ?>';" >Edit</button>
											</td>
										</tr>
									<?php endforeach; endif;?>
									</tbody>
								</table>
							</div>
						</div>
			</section>
		</div>
	</div>
</div>