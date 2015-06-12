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
        alert (id);        
        document.getElementById('selectedIdObat').value = id;
        document.getElementById('selectedKodeObat').value = document.getElementById('kodeObat'+id).value;
        document.getElementById('selectedNamaObat').value = document.getElementById('namaObat'+id).value;
        document.getElementById('selectedSatuanObat').value = document.getElementById('satuanObat'+id).value;        
    }
    
    function myFunction2 (id) {
        var split = id.split('_');
        var item = document.getElementById('namaObat'+split[0]).value;
        document.getElementById('deletedItem').innerHTML = item;
        document.getElementById('selected').value = split[0];
    }
    
</script>

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
    jQuery(document).ready(function() {
        EditableTable.init();
    });
</script>


<!--

<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/bs3/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery-ui-1.9.2.custom.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/easypiechart/jquery.easypiechart.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery.nicescroll.js"></script>

<script src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-switch.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/jquery-multi-select/js/jquery.quicksearch.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/uistuff/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

<script src="<?php echo base_url(); ?>assets/uistuff/js/jquery-tags-input/jquery.tagsinput.js"></script>

<script src="<?php echo base_url(); ?>assets/uistuff/js/select2/select2.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/select-init.js"></script>

<script src="<?php echo base_url(); ?>assets/uistuff/js/scripts.js"></script>

<script src="<?php echo base_url(); ?>assets/uistuff/js/toggle-init.js"></script>

<script src="<?php echo base_url(); ?>assets/uistuff/js/advanced-form.js"></script>
<!--Easy Pie Chart
<script src="<?php echo base_url(); ?>assets/uistuff/js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart
<script src="<?php echo base_url(); ?>assets/uistuff/js/sparkline/jquery.sparkline.js"></script>
<!--jQuery Flot Chart
<script src="<?php echo base_url(); ?>assets/uistuff/js/flot-chart/jquery.flot.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/flot-chart/jquery.flot.resize.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/flot-chart/jquery.flot.pie.resize.js"></script>
 -->

<script src="<?php echo base_url(); ?>assets/uistuff/js/holong/jquery.battatech.excelexport.js"></script>
<script src="<?php echo base_url(); ?>assets/uistuff/js/holong/jquery.battatech.excelexport.min.js"></script>

<script>

    function showTransaction (value) {
        alert(value);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() .'index.php/drugWH/agfk/getDetailTransaction'; ?>",
            data: {id : value},
            success: function(data){     
                alert(data);
                if (data) {
                    dataObj = eval (data);
                    //alert (dataObj);
                    document.getElementById('inputObatHidden').value = dataObj[0]['id_obat'];
                    document.getElementById('inputObat2').value = dataObj[0]['nama_obat'];
                    document.getElementById('inputJumlah2').value = dataObj[0]['jumlah'];
                    //$('#inputObat2').val(dataObj[0]['nama_obat']);
                }
            },
        });
    }
    
    function showPermintaanByPuskesmas (value) {
        
        if (value == -1) return;
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() .'index.php/drugWH/distribution/getHCRequest'; ?>",
            data: {id : value},
            success: function(data){    
                $("#permintaan_table").show();
                $( "#inputPermintaan" ).html('');
                dataObj = eval (data);
                var content = '<table class="table table-bordered"><thead><tr><th>No. Transaksi</th><th>Pilih</th></tr></thead><tbody>';     
                $.each(dataObj, function(index, value) {        
                    content += '<tr><td>Request#'+value.ID_TRANSAKSI+'</td>';                   
                    content += '<td><a class="btn" data-toggle="modal" href="#" id='+value.ID_TRANSAKSI+' onclick="showDetailPermintaanPuskesmas(this.id)"><i class="fa fa-edit"></i></a></td></tr>';        
                });
                content += '</tbody></table>';
                $( "#inputPermintaan" ).append( content );               
            },
            error: function(e){
                alert(e.message)
            }
        });
    }
    
    function showDetailPermintaanPuskesmas (value) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() .'index.php/drugWH/distribution/getDetailHCRequest'; ?>",
            data: {id : value},
            success: function(data){    
                $("#detail_permintaan_table").show();
                $( "#inputDetailPermintaan" ).html('');
                dataObj = eval (data);
                var content = '<table class="table table-bordered"><thead><tr><th>#</th><th>Nama Obat</th><th>Jumlah</th></tr></thead><tbody>';     
                $.each(dataObj, function(index, value) {        
                    content += '<tr><td>'+value.id_obat+'</td>';     
                    content += '<td>'+value.nama_obat+'</td>';
                    content += '<td>'+value.jumlah_obat+'</td></tr>';
                });
                content += '</tbody></table>';
                $( "#inputDetailPermintaan" ).append( content );  
                $( "#inputIdPermintaan").val(value);
            },
            error: function(e){
                alert(e.message)
            }
        });
    }
    
    function exportTabel () {
        $("#tblExport").btechco_excelexport({
            containerid: "tblExport"
           , datatype: $datatype.Table
        });
    }
</script>