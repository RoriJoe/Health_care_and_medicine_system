<?php
$i=1;
?>

<!-- Pop up UPDATE Sumber Pembayaran-->
                <div style="display: none;" class="modal fade" id="updateData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Ubah Tempat Tidur</h4>
                            </div>
                            <div class="modal-body">
                                <div class="position-center">
                                <form class="form-horizontal">
                                <div class="form-group">
                                <label for="inputKode" class="col-lg-2 col-sm-2 control-label">No Tempat Tidur</label>
                                <div class="col-lg-10">
                                <input class="form-control" id="updateNoTT"  name="updateNoTT" type="text">             
                                </div> 
                                </div>
                                <div class="form-group">
                                <label for="inputKode" class="col-lg-2 col-sm-2 control-label">Kategori Tempat Tidur</label>
                                <div class="col-lg-10">   
									<select class="form-control m-bot15" id="updateIdKTT" name="updateIdKTT">
										<?php 
											foreach($allCategoryTT as $row)
											{
												echo '<option value="'.$row['ID_KAT_TT'].'_'.$row['NAMA_KATEGORI_TT'].'">'.$row['NAMA_KATEGORI_TT'].'</option>';
											}
										?>
									</select>         
                                </div> 
                                </div>
                                <div class="form-group">
                                <label for="inputKode" class="col-lg-2 col-sm-2 control-label">Nama Ruangan</label>
                                <div class="col-lg-10"> 
									<select class="form-control m-bot15" id="updateIdRRI" name="updateIdRRI">
										<?php 
											foreach($allHRoom as $row)
											{
												echo '<option value="'.$row['ID_RUANGAN_RI'].'_'.$row['NAMA_RUANGAN_RI'].'">'.$row['NAMA_RUANGAN_RI'].'</option>';
											}
										?>
									</select>        
                                </div> 
                                </div>
                                <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                <button type="button" onClick=saveUpdate() class="btn btn-primary">Simpan</button>
                                </div>
                                </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!-- End of Modal -->

<!-- Pop up isian tambah Jabatan baru -->
                <div style="display: none;" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Tambah Tempat Tidur</h4>
                            </div>
                            <div class="modal-body">
                                <div class="position-center">
                                <form class="form-horizontal" method="post" action="<?php echo base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/addBR/' ?>">
                                <div class="form-group">
                                <label for="inputKode" class="col-lg-2 col-sm-2 control-label">No Tempat Tidur</label>
                                <div class="col-lg-10">
                                <input class="form-control" id="inputNoTT"  name="inputNoTT" type="text">             
                                </div> 
                                </div>
								<div class="form-group">
                                <label for="inputKode" class="col-lg-2 col-sm-2 control-label">Kategori Tempat Tidur</label>
                                <div class="col-lg-10">
									<select class="form-control m-bot15" id="inputIdKTT" name="inputIdKTT">
										<?php 
											foreach($allCategoryTT as $row)
											{
												echo '<option value="'.$row['ID_KAT_TT'].'_'.$row['NAMA_KATEGORI_TT'].'">'.$row['NAMA_KATEGORI_TT'].'</option>';
											}
										?>
									</select>								
                                </div> 
                                </div>
								<div class="form-group">
                                <label for="inputKode" class="col-lg-2 col-sm-2">Nama Ruangan</label>
                                <div class="col-lg-10"> 
									<select class="form-control m-bot15" id="inputIdRRI" name="inputIdRRI">
										<?php 
											foreach($allHRoom as $row)
											{
												echo '<option value="'.$row['ID_RUANGAN_RI'].'_'.$row['NAMA_RUANGAN_RI'].'">'.$row['NAMA_RUANGAN_RI'].'</option>';
											}
										?>
									</select>								
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
<div class="container">
<div class="row">
	<div class="panel-body">
		<div class="col-lg-6">
		    <section class="panel">
				<div class="panel-body">
					<a style="color: white;" type="button" class="btn btn-success"  data-toggle="modal" href="#myModal"> Tambah Tempat Tidur <i class="fa fa-plus"></i> </a>
				</div>
			</section>
		</div>
		<div class="col-lg-12">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Daftar Ruangan' ?></h3>
			</header>
			<section class="panel">
			<div class="panel-body">
				<ul class="nav nav-pills">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"> Filter Fields <b class="caret"></b> </a>
						<ul class="dropdown-menu stop-propagation" style="overflow:auto;max-height:450px;padding:10px;">
							<div id="filter-list"></div>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"> Row Label Fields <b class="caret"></b> </a>
						<ul class="dropdown-menu stop-propagation" style="overflow:auto;max-height:450px;padding:10px;">
							<div id="row-label-fields"></div>
						</ul>
					</li>
				</ul>
				<span class="hide-on-print" id="pivot-detail"></span>
				<div id="results"></div>
			</div>
			</section>
		</div>
		</div>
	</div>
</div>
</div>
<script>
var currentId;

var fields = [
		 {
		 name : 'NOMOR TEMPAT TIDUR',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'NAMA KATEGORI',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'NAMA RUANGAN',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'KELOLA',
		 type : 'string',
		 filterable : true
		 }
];

$( document ).ready(function() {
    var jso;
			$.ajax({
				type: "POST",
				url: "<?php echo base_url() .$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/getBedroom'; ?>",
				success: function (dataCheck) {
					if (dataCheck) {
						jso = dataCheck;
						setupPivot({
							json: jso,
							fields: fields,
							rowLabels: ["NOMOR TEMPAT TIDUR","NAMA KATEGORI","NAMA RUANGAN","KELOLA"]
						})
						$('.stop-propagation').click(function (event) {
							event.stopPropagation();
						});
					}
				}
				,error: function (xhr, ajaxOptions, thrownError) {
				   }
			});
});

function update(id)
{
	var temp = id.split("_");
	document.getElementById('updateNoTT').value = temp[1];
	document.getElementById('updateIdKTT').value = temp[2];
	document.getElementById('updateIdRRI').value = temp[3];
	currentId = temp[0];
}

function saveUpdate()
{
	$.ajax({
		type : "POST",
		url : '<?= base_url().$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/saveUpdateBR/'; ?>',
		data : {selectedTT:currentId, updateNoTT:document.getElementById('updateNoTT').value, updateIdKTT:document.getElementById('updateIdKTT').value, updateIdRRI:document.getElementById('updateIdRRI').value},
		success : function() {
			var jso;
			$.ajax({
				type: "POST",
				url: "<?php echo base_url() .$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/getBedroom'; ?>",
				success: function (dataCheck) {
					if (dataCheck) {
						jso = dataCheck;
						setupPivot({
							json: jso,
							fields: fields,
							rowLabels: ["NOMOR TEMPAT TIDUR","NAMA KATEGORI","NAMA RUANGAN","KELOLA"]
						})
						$('.stop-propagation').click(function (event) {
							event.stopPropagation();
						});
					}
				}
				,error: function (xhr, ajaxOptions, thrownError) {
				   }
			});
		},
		error: function(){						
		}
	});
}
</script>