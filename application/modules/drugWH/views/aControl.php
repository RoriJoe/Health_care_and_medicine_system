<div class="container">
<div class="row">  
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Daftar Pegawai' ?></h3>
			</header>
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
					<form class="form-vertical" method="post" action="<?php echo base_url(); ?>index.php/drugWH/control/removeAccount">
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
			
			<div class="panel-body">
				<div class="col-lg-6">
					<section class="panel">
						<div class="panel-body">
							<a style="color: white;" type="button" class="btn btn-success"  data-toggle="modal" href="<?= base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/createAccount' ?>"> Tambah Akun <i class="fa fa-plus"></i> </a>
						</div>
					</section>
				</div>
				<div class="form-group">
					<table class="table table-striped table-hover table-bordered" id="editable-sample">
						<thead>
						<tr>
							<th>No Identitas</th>
							<th>Nama</th>
							<th>Alamat</th>
							<th>Jenis Kelamin</th>
							<th>Telepon</th>
							<th>Handphone</th>
							<th>Email</th>
							<th>Agama</th>
							<th>Status Pegawai</th>
							<th>Ubah</th>
							<th>Hapus</th>
						</tr>
						</thead>
						<tbody>
						<?php if (isset($allAkun)) :?>
						<?php foreach ($allAkun as $row): ?>
							<tr><!-- set class using counter i -->
								<td><?php echo $row['NOID'];?></td> <!-- set class using kode obat -->
								<td id="namaGedung<?php echo $row['ID_AKUN'];?>" value="<?php echo $row['NAMA_AKUN'];?>"><?php echo $row['NAMA_AKUN'];?></td> <!-- set class using kode obat -->
								<td><?php echo $row['ALAMAT'];?></td> <!-- set class using kode obat -->
								<td><?php echo $row['JENIS_KELAMIN'];?></td>
								<td><?php echo $row['TELEPON'];?></td>
								<td><?php echo $row['HP'];?></td>
								<td><?php echo $row['EMAIL'];?></td>
								<td><?php echo $row['AGAMA'];?></td>
								<td><?php echo $row['STATUS_PEGAWAI'];?></td>
								<td>
									<a href="<?= base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/updateAccount?id='.$row['ID_AKUN'];?>">
										<button  type="button" data-dismiss="modal" aria-hidden="true">Edit</button>
									</a>
								</td>
								<td>
									<a class="btn" data-toggle="modal" href="#deleteConfirmModal" id="<?php echo $row['ID_AKUN']?>_" onclick="myFunction2(this.id)">
										×
									</a>
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
</div>