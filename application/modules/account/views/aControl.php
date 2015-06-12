<div class="container">
<div class="row">  
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<header class="panel-heading">
				<h3 class="panel-title"><?= 'Daftar Pegawai' ?></h3>
			</header>
			<section class="panel">
				<div class="col-lg-12">
					<section class="panel">
						<div class="panel-body">
							<a style="color: white;" type="button" class="btn btn-success"  data-toggle="modal" href="<?= base_url().'account/'.$this->uri->segment(2, 0).'/createAccount' ?>"> Tambah Akun <i class="fa fa-plus"></i> </a>
						</div>
					</section>
				</div>
				<div class="panel-body">
					<!--<ul class="nav nav-pills">
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
					</ul>-->
					<span class="hide-on-print" id="pivot-detail"></span>
					<div id="results"></div>
				</div>
			</div>
		</section>
		</div>
	</div>
</div>
</div>
<script>
var fields = [
		 {
		 name : 'NOID',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'NAMA AKUN',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'ALAMAT',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'JENIS KELAMIN',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'HP',
		 type : 'string',
		 filterable : true
		 },{
		 name : 'EMAIL',
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
				url: "<?php echo base_url() .$this->uri->segment(1, 0).'/'.$this->uri->segment(2, 0).'/getAkun'; ?>",
				success: function (dataCheck) {
					if (dataCheck) {
						jso = dataCheck;
						setupPivot({
							json: jso,
							fields: fields,
							rowLabels: ["NOID","NAMA AKUN","ALAMAT","JENIS KELAMIN","HP","EMAIL","KELOLA"]
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
</script>