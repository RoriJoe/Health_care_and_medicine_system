
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery-ui-1.9.2.custom.min.js"></script>

<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-switch.js"></script>

<!-- date time picker -->
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-daterangepicker/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/uistuff/js/advanced-form.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/data-tables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/data-tables/DT_bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/custom-table-editable-PopUp.js"></script>

<script>
    jQuery(document).ready(function() {
        EditableTable.init();
        $('.total_kodeObat').val('');
        $('.total_jumlahObat').val('');
    });
</script>



<!-- JavaScript -->
<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.js"></script>-->
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