<!--Core js-->
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/bs3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/hover-dropdown.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery.nicescroll.js"></script>
<!--Easy Pie Chart-->
<script src="<?php echo base_url(); ?>assets/uistuff/js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="<?php echo base_url(); ?>assets/uistuff/js/sparkline/jquery.sparkline.js"></script>
<!--jQuery Flot Chart-->
<script src="<?php echo base_url(); ?>assets/uistuff/js/flot-chart/jquery.flot.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/flot-chart/jquery.flot.resize.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/flot-chart/jquery.flot.pie.resize.js"></script>

<!--common script init for all pages-->
<script src="<?php echo base_url(); ?>assets/uistuff/js/scripts.js"></script>
  
<!-- Dmitri Add -->
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery-ui-1.9.2.custom.min.js"></script>
<script class="include" src="<?php echo base_url(); ?>assets/uistuff/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-switch.js"></script>
<!-- date time picker -->
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-daterangepicker/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<!-- multi select and quick search -->
<!--<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery-multi-select/js/jquery.multi-select.js"></script>-->
<!--<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery-multi-select/js/jquery.quicksearch.js"></script>-->

<!--<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>-->
<!--<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery-tags-input/jquery.tagsinput.js"></script>-->

<!--<script src="<?php echo base_url(); ?>assets/uistuff/js/select2/select2.js"></script>-->
<!--<script src="<?php echo base_url(); ?>assets/uistuff/js/select-init.js"></script>-->
<!-- Dmitri init -->
<script src="<?php echo base_url(); ?>assets/uistuff/js/toggle-init.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/advanced-form.js"></script>
<!--script for this page only-->
<script src="<?php echo base_url(); ?>assets/uistuff/js/data-tables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/data-tables/DT_bootstrap.js"></script>
<!--<script src="<?php echo base_url(); ?>assets/uistuff/js/table-editable.js"></script>-->
<script src="<?php echo base_url(); ?>assets/uistuff/js/custom-table-editable.js"></script>
<!-- END JAVASCRIPTS -->
<script>

    function myFunction (id) {
        //alert (id);        
        document.getElementById('selectedIdObat').value = id;
        document.getElementById('selectedKodeObat').value = document.getElementById('kodeObat'+id).value;
        document.getElementById('selectedNamaObat').value = document.getElementById('namaObat'+id).value;
        document.getElementById('selectedSatuanObat').value = document.getElementById('satuanObat'+id).value;        
    }
    
    function myFunction2 (id) {
        window.alert(id);
        var split = id.split('_');
        window.alert(split);
        var item = document.getElementById('namaGedung'+split[0]).value;
        window.alert(item);
        document.getElementById('deletedItem').innerHTML = item;
        document.getElementById('selected').value = split[0];
    }
    
</script>