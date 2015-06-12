<!--Core js-->
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/bs3/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery.nicescroll.js"></script>

<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery.isotope.js"></script>

<!--Easy Pie Chart-->
<script src="<?php echo base_url(); ?>assets/uistuff/js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="<?php echo base_url(); ?>assets/uistuff/js/sparkline/jquery.sparkline.js"></script>
<!--jQuery Flot Chart-->
<!--<script src="<?php echo base_url(); ?>assets/uistuff/js/flot-chart/jquery.flot.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/flot-chart/jquery.flot.resize.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/flot-chart/jquery.flot.pie.resize.js"></script>-->


<!--common script init for all pages-->
<script src="<?php echo base_url(); ?>assets/uistuff/js/scripts.js"></script>

<script type="text/javascript">
    $(function() {
        var $container = $('#gallery');
        $container.isotope({
            itemSelector: '.item',
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });

        // filter items when filter link is clicked
        $('#filters a').click(function() {
            var selector = $(this).attr('data-filter');
            $container.isotope({filter: selector});
            return false;
        });
    });
</script>