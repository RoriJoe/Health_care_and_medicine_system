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

<script>

    function myFunction (id) {
        //alert (id);        
        document.getElementById('selectedIdObat').value = id;
        document.getElementById('selectedKodeObat').value = document.getElementById('kodeObat'+id).value;
        document.getElementById('selectedNamaObat').value = document.getElementById('namaObat'+id).value;
        document.getElementById('selectedSatuanObat').value = document.getElementById('satuanObat'+id).value;        
    }
    
    function myFunction2 (id) {
        var split = id.split('_');
        var item = document.getElementById('namaGedung'+split[0]).value;
        document.getElementById('deletedItem').innerHTML = item;
        document.getElementById('selected').value = split[0];
    }
    
</script>