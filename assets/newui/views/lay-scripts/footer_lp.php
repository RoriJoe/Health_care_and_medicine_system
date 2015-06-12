
<!-- JavaScript -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/modernizr.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.easing.js"></script>


<!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
<![endif]-->

<!-- Plugins -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/masonry/masonry.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/page-scroller/jquery.ui.totop.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/mixitup/jquery.mixitup.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/mixitup/jquery.mixitup.init.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/easy-pie-chart/jquery.easypiechart.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/waypoints/waypoints.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/sticky/jquery.sticky.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.wp.custom.js"></script>
<!--<script type="text/javascript" src="js/jquery.wp.switcher.js"></script>-->
<script src="<?php echo base_url(); ?>assets/newui/assets/layerslider/js/greensock.js" type="text/javascript"></script>
 
<!-- LayerSlider script files -->
<script src="<?php echo base_url(); ?>assets/newui/assets/layerslider/js/layerslider.transitions.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/newui/assets/layerslider/js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script>
<!-- Initializing the slider -->
<script>
    jQuery("#layerslider").layerSlider({
        pauseOnHover: true,
        autoPlayVideos: false,
        skinsPath: '<?php echo base_url(); ?>assets/newui/assets/layerslider/skins/',
        responsive: false,
        responsiveUnder: 1280,
        layersContainer: 1280,
        skin: 'v5',
        hoverPrevNext: false,
    });
</script>


<!-- -->
	
<script src="<?php echo base_url();?>assets/newui/assets/pivot/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/newui/assets/pivot/jquery-2.1.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/newui/assets/pivot/pivot.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/newui/assets/pivot/jquery_pivot.js"></script>
<!-- pivot stuff -->
<script type="text/javascript" async="" src="<?php echo base_url();?>assets/newui/assets/pivot/c.js"></script>
<script async="" src="<?php echo base_url();?>assets/newui/assets/pivot/analytics.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/newui/assets/pivot/subnav.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/newui/assets/pivot/accounting.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/newjquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/dataTables.bootstrap.js"></script>

<script>
// function setupPivot(input){
    // input.callbacks = {afterUpdateResults: function(){
      // $('#results > table').dataTable({
        // "sDom": "<'row'<'col-md-6'l><'col-md-6'f>>t<'row'<'col-md-6'i><'col-md-6'p>>",
        // "iDisplayLength": 5,
        // "aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "All"]],
        // "oLanguage": {
          // "sLengthMenu": "_MENU_ records per page"
        // }
      // });
    // }};
    // $('#pivot-demo').pivot_display('setup', input);
// }
</script>

<!-- PIVOT -->


<!-- custom script -->
<script>

// function editPatient (id, nik, nama, gender, tempat, tanggal, alamat, rt, rw, kelurahan, kecamatan, kota, nosehat, telepon1, telepon2, kk, pendidikan, darah, agama ) {
	
	// $('#selectedAgamaPasien').val(agama);
	// $('#selectedGenderPasien').val(gender);
	// $('#selectedDarahPasien').val(darah);
	
	// $('#selectedIdPasien').val(nik);
    // $('#selectedNamaPasien').val(nama);
    // $('#selectedAlamatPasien').val(alamat);
    // $('#selectedTeleponPasien1').val(telepon1);    
	// $('#selectedTeleponPasien2').val(telepon2);   
	// $('#selectedNomorKKPasien').val(kk);   
	// $('#selectedKelurahanPasien').val(kelurahan);   
	// $('#selectedKecamatanPasien').val(kecamatan);   
	// $('#selectedPendidikanPasien').val(pendidikan);   
	// $('#selectedTanggalLahirPasien').val(tanggal);

	// // $("#selectedAgamaPasien option").each(function() {
		// // if($(this).text() == agama) {
			// // $(this).attr('selected', 'selected');            
		  // // }                        
	// // });
	// // $("#selectedGenderPasien option").each(function() {
		// // if($(this).text() == gender) {
			// // $(this).attr('selected', 'selected');            
		  // // }                        
	// // });
	// // $("#selectedDarahPasien option").each(function() {
		// // if($(this).text() == darah) {
			// // $(this).attr('selected', 'selected');            
		  // // }                        
	// // });
	  
// }

// function removePatient (id) {
	// var split = id.split('_');
    // var item = document.getElementById('nama'+split[0]).value;
    // document.getElementById('deletedItem').innerHTML = item;
    // document.getElementById('selected').value = split[0]; 
// }
 
// function antriPasien (id, nik, nama,gender, tempat, tanggal, alamat, rt, rw, kelurahan, kecamatan, kota, nosehat) {
	// document.getElementById('nikAntrian').innerHTML = nik;
	// document.getElementById('namaAntrian').innerHTML = nama +" ("+ gender+")";
	// document.getElementById('ttlAntrian').innerHTML = tempat + "/" + tanggal;
	// $('#tanggal').val (tanggal);
	// document.getElementById('alamatAntrian').innerHTML = alamat +
	// " RT. " + rt +" RW. "+ rw +", Kelurahan " + kelurahan + ", Kecamatan "+ kecamatan + ", Kota " + kota;
	// document.getElementById('noSehatAntrian').innerHTML = nosehat;
	// document.getElementById('layanan').hidden = "";
	
	// document.getElementById('no').value = id; 
// }
</script>

<script>

// $(function () {
   // renderTable();
   // $( ".datepicker" ).datepicker({
		// format: 'dd-mm-yyyy',
	// });

// });

</script>
