// <!-- JavaScript -->
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/bootstrap/js/bootstrap.min.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/modernizr.custom.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.mousewheel-3.0.6.pack.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.cookie.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.easing.js"></script>


// <!--[if lt IE 9]>
    // <script src="js/html5shiv.js"></script>
    // <script src="js/respond.min.js"></script>
// <![endif]-->

// <!-- Plugins -->
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/masonry/masonry.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/page-scroller/jquery.ui.totop.min.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/mixitup/jquery.mixitup.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/mixitup/jquery.mixitup.init.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/easy-pie-chart/jquery.easypiechart.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/waypoints/waypoints.min.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/sticky/jquery.sticky.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.wp.custom.js"></script>
// <!--<script type="text/javascript" src="js/jquery.wp.switcher.js"></script>-->
// <script src="<?php echo base_url(); ?>assets/newui/assets/layerslider/js/greensock.js" type="text/javascript"></script>
 
// <!-- LayerSlider script files -->
// <script src="<?php echo base_url(); ?>assets/newui/assets/layerslider/js/layerslider.transitions.js" type="text/javascript"></script>
// <script src="<?php echo base_url(); ?>assets/newui/assets/layerslider/js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script>
// <!-- Initializing the slider -->
	// <script>
		// jQuery("#layerslider").layerSlider({
			// pauseOnHover: true,
			// autoPlayVideos: false,
			// skinsPath: '<?php echo base_url(); ?>assets/newui/assets/layerslider/skins/',
			// responsive: false,
			// responsiveUnder: 1280,
			// layersContainer: 1280,
			// skin: 'v5',
			// hoverPrevNext: false,
		// });
	// </script>

// <!-- -->
	
// <script src="<?php echo base_url();?>assets/newui/assets/pivot/jquery.min.js" type="text/javascript"></script>
// <script src="<?php echo base_url();?>assets/newui/assets/pivot/jquery-2.1.1.min.js" type="text/javascript"></script>
// <script type="text/javascript" src="<?php echo base_url();?>assets/newui/assets/pivot/pivot.js"></script>
// <script type="text/javascript" src="<?php echo base_url();?>assets/newui/assets/pivot/jquery_pivot.js"></script>
// <!-- pivot stuff -->
// <script type="text/javascript" async="" src="<?php echo base_url();?>assets/newui/assets/pivot/c.js"></script>
// <script async="" src="<?php echo base_url();?>assets/newui/assets/pivot/analytics.js"></script>
// <script type="text/javascript" src="<?php echo base_url();?>assets/newui/assets/pivot/subnav.js"></script>
// <script type="text/javascript" src="<?php echo base_url();?>assets/newui/assets/pivot/accounting.min.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/newjquery.dataTables.min.js"></script>
// <script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/dataTables.bootstrap.js"></script>
// <!-- PIVOT -->


// <script>
// function ICDChoosed (value) {
	// $.ajax({
		// type: "POST",
		// url: "<?php echo base_url() .'care/showICDById'; ?>",
		// data: {id : value},
		// success: function(data){   	
				// var parsedData = JSON.parse(data);
				// $('#bodyChoosedICD').append('<tr id="'+value+'"><td><input id="icd-'+value+'" name="icd-'+value+'" readonly class="form-control" type="text" value="'+parsedData.INDONESIAN_NAME+'"></td><td><button onclick="removeSelectedICD('+value+')" class="btn btn-warning" type="button">Hapus</button></td></tr>');
		// },
		// error: function(e){
                // alert(e.message);
        // }
	// });
// }

// function removeSelectedICD (value) {
	
	// $('#bodyChoosedICD').find('#'+value+'').remove();
// }
// </script>

// <script>

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

// function getPatient (rrm, id_antrian) {
	// // alert("rrm " +rrm +"antri"+ id_antrian);
	// // $('#id_antrian').val(id_antrian);

	// $("#data_pas").hide();
	// $("#detail_riwayat").hide();
	
	// $('#tabelAntrian tbody tr').css("background-color","transparent");
	// $('#row'+id_antrian).css("background-color","#e1f8ff");
	
	// $("#id_rrm").val(rrm);
	
	// $.ajax({
		// type: "POST",
		// url: "<?php echo base_url() .'care/getPatientData'; ?>",
		// data: {id : rrm},
		// success: function(data){   		
			// // alert (data);
			// if (data) {
				// // alert (data);
				// dataObj = jQuery.parseJSON(data);				
				// $("#detail_riwayat").show();
                                // $("#norekammedik").val(dataObj.noid_pasien);
                                // $("#namapasien").val(dataObj.nama_pasien);
                                // $("#umurpasien").val(Math.floor(dataObj.umur/12)+" Th");
								// $("#umur").val(dataObj.umur);
                                // $("#jkpasien").val(dataObj.gender_pasien);
                                // $("#alamatpasien").val(dataObj.alamat_pasien);
								// $("#kunjunganpasien").val(dataObj.WAKTU_ANTRIAN_UNIT);
                                // $('#linknya').attr("href","<?php echo base_url() .'poliumum/pu/patientMRH/'; ?>"+dataObj.id_rekammedik);
				// $("#hidden_noantrian").val(id_antrian);
				// $("#data_pas").show();
                                // $("#pembayaranPasien").val(dataObj.ID_SUMBER);
                                // $("#sumberbayar").text(dataObj.NAMA_SUMBER_PEMBAYARAN)
			// }
		// },
		// error: function(e){
                // alert(e.message);
        // }
	// });
// }

// function LayananChoosed () {
	// value = $('#layananKesehatan').val();
	// if (value != "") {
	// name = $('#layananKesehatan :selected').text();
	// $('#bodyChoosedLayanan').append('<tr id="layanan-'+value+'"><td><input id="layanan-'+value+'" name="layanan-'+value+'" readonly class="form-control" type="text" value="'+name+'"></td><td><button onclick="removeSelectedLayanan(\'layanan-'+value+'\')" class="btn btn-warning" type="button">Hapus</button></td></tr>');
	// }
// }

// function removeSelectedLayanan (value) {
	// // alert(value);
	// $('#bodyChoosedLayanan').find('#'+value+'').remove();
// }

// </script>
