
<!-- JavaScript -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/modernizr.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.easing.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/modernizr.custom.js"></script>

<!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
<![endif]-->

<!-- Plugins -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/masonry/masonry.js"></script><!--
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/page-scroller/jquery.ui.totop.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/mixitup/jquery.mixitup.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/mixitup/jquery.mixitup.init.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/easy-pie-chart/jquery.easypiechart.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/waypoints/waypoints.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/sticky/jquery.sticky.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/js/jquery.wp.custom.js"></script>
<script type="text/javascript" src="js/jquery.wp.switcher.js"></script>-->
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
<script type="text/javascript" src="<?php echo base_url();?>assets/newui/assets/pivot/pivot.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/newui/assets/pivot/jquery_pivot.js"></script>
<!-- pivot stuff -->
<script type="text/javascript" async="" src="<?php echo base_url();?>assets/newui/assets/pivot/c.js"></script>
<script async="" src="<?php echo base_url();?>assets/newui/assets/pivot/analytics.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/newui/assets/pivot/subnav.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>assets/newui/assets/pivot/accounting.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/newjquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/dataTables.bootstrap.js"></script>
<!-- PIVOT -->
 <!--date time picker--> 
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-daterangepicker/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/advanced-form.js"></script>

<script>
    function setupPivot(input){
        input.callbacks = {afterUpdateResults: function(){
          $('#results > table').dataTable({
            "sDom": "<'row'<'col-md-6'l><'col-md-6'f>>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "oLanguage": {
              "sLengthMenu": "_MENU_ records per page"
            }
          });
        }};
        $('#pivot-demo').pivot_display('setup', input);
		$("#pivot-table").class("table-responsive");
    }
    
</script>



