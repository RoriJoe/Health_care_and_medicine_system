<script src="<?php echo base_url(); ?>assets/newui/assets/pivot/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/newui/assets/pivot/jquery-2.1.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/pivot.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/jquery_pivot.js"></script>
<!-- pivot stuff -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/newui/assets/pivot/bootstrap.min.css" type="text/css">
<script type="text/javascript" async="" src="<?php echo base_url(); ?>assets/newui/assets/pivot/c.js"></script>
<script async="" src="<?php echo base_url(); ?>assets/newui/assets/pivot/analytics.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/subnav.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/accounting.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/newui/assets/pivot/dataTables.bootstrap.js"></script>

<div class="container">
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Daftar Pengujian Lab</h3>
                </div>
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

                    <hr/>
                    <span class="hide-on-print" id="pivot-detail"></span>
                    <hr/>
                    <div style="overflow-x: scroll" id="results"></div>
                </div>
            </div>
        </div>
        <div class="col-md-1">

        </div>
    </div>
    <div class="row">
        <form method="post" action="<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/updateTestValue'; ?>">
            <div class="col-md-1">
                <input type="hidden" id="idrrm" name="idrrm" value="<?php echo $idrrm; ?>"/>
                <input type="hidden" name="idantrian" value="<?php echo $idantrian; ?>"/>
            </div>
            <div class="col-md-10">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Daftar Uji Lab Pasien : 
                            <?php $r = 1;
                            if (isset($testlist)) : echo $testlist[0]['NAMA_PASIEN'];
                            endif; 
                            ?> 
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div style="height: 300px; overflow-y: scroll;">
                            <table style="width: 100%;" class="table table-striped table-responsive" id="tabelUji">
                                <thead>
                                <th>Pengujian</th>
                                <th>Spesimen</th>
                                <th>Kategori Pengujian</th>
                                <th>Hasil</th>
                                <th>Tanggal</th>
                                </thead>
                                <tbody >
                                    <?php
                                    $r = 1;
                                    if (isset($testlist)) :
                                        foreach ($testlist as $row) : ?>
                                            <tr>		
                                                <td><?php echo $row['NAMA_PEM_LABORAT']; ?></td>
                                                <td><?php echo $row['NAMA_SPESIMEN']; ?> </td>			
                                                <td><?php echo $row['NAMA_KP_LABORAT']; ?></td>
                                                <td>
                                                    <input class="form-control" name="result_<?php echo $row['ID_CEK_LABORAT']; ?>" type="text" value="">
                                                </td>
                                                <td>
                                                    <!--<input type="date" class="form-control" name="tglresult_<?php echo $row['ID_CEK_LABORAT']; ?>" />-->
                                                    <input name="tglresult_<?php echo $row['ID_CEK_LABORAT']; ?>" class="datepicker form-control form-control-inline default-date-picker" size="16" type="text" value="<?= date('d-m-Y') ?>" />
                                                </td>
                                            </tr>
                                            <?php
                                            $r++;
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>
                                <input class="form-control" id="jmlbaru" name="jmlbaru" type="hidden" value="">
                            </table>
                        </div>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal2" type="button">Simpan & Arahkan ke Poli Lain</button>
                    </div>
                </div>
            </div>
            <div class="col-md-1">

            </div>
            <!-- modal save riwayat and change unit -->
            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Simpan & Arahkan Pasien ke Poli Lain</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <select name="save_unit" id="save_unit" class="form-control">
                                        <?php
                                            foreach ($listUnit as $r) { 
                                            $pos = strpos($r['NAMA_UNIT'], 'KIA');
                                            if($pos !== false){ ?>
                                                <option value="<?= $r['ID_UNIT'] . '_balita' ?>">Poli KIA-Anak Balita</option>
                                                <option value="<?= $r['ID_UNIT'] . '_kia' ?>">Poli KIA-Ibu Hamil</option>
                                                <option value="<?= $r['ID_UNIT'] . '_vkkia' ?>">Poli KIA-VK KIA</option>
                                                <option value="<?= $r['ID_UNIT'] . '_kb' ?>">Poli KIA-KB</option>
                                            <?php } else { ?>
                                                <option value="<?php echo $r['ID_UNIT'] ?>"><?php echo $r['NAMA_UNIT'] ?></option>
                                            <?php }
                                            } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                            <input type="submit" class="btn btn-primary" value="Simpan" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal -->
        </form>
    </div>
</div>

    <script type="text/javascript">
        $(function () {
            $( ".datepicker" ).datepicker({
                    format: 'dd-mm-yyyy',
            });
        });
        
        var count = 0;
        var arr = [];
        function fungsi_alert(idpemlaborat, namauji, namakplaborat, spesimen)
        {
            if(document.getElementById('idpemlaborat'+idpemlaborat))
            {
                alert('Pengujian "'+namauji+'" Telah Dipilih');
            }
            else
            {
                count=count+1;
                $('#tabelUji').find('tbody').append(
                        '<tr id="row' + count + '">'+
                            '<td>' + namauji + '</td><td>' + spesimen + '</td>'+
                            '<td>' + namakplaborat + '</td>'+
                            '<td>'+
                                '<input class="form-control" name="valuebaru'+count+'" type="text" value="">'+
                                '<input class="form-control" id="idpemlaborat'+idpemlaborat+'" name="idpemlaborat'+count+'" type="hidden" value="'+idpemlaborat+'">'+
                            '</td>'+
                            '<td>'+
                                '<input name="tanggalbaru'+count+'" class="datepicker form-control form-control-inline default-date-picker" size="16" type="text" value="<?= date('d-m-Y') ?>" />'+
                            '</td>'+
                            '<td><button type="button" class="btn btn-warning" onclick=\"clearTest(\'row' + count + '\')\" >Hapus</button></td>'+
                        '</tr>');
                $('#jmlbaru').val(count);
            }
        };

        function clearTest(id)
        {
            count=count-1;
            $('#' + id + '').remove();
            
            $('#jmlbaru').val(count);
        };
        
        var fields = [
            {
                name: 'NAMA PENGUJIAN',
                type: 'string',
                filterable: true
            }
            , {
                name: 'KELOLA',
                type: 'string',
                filterable: true
            }
        ];

        function setupPivot(input) {
            input.callbacks = {
                afterUpdateResults: function () {
                    $('#results > table').dataTable({
                        "sDom": "<'row'<'span6'l><'span6'f>>t<'row'<'span6'i><'span6'p>>",
                        "iDisplayLength": 25,
                        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                        "sPaginationType": "bootstrap",
                        "oLanguage": {
                            "sLengthMenu": "_MENU_ records per page"
                        }
                    });
                }
            };
            $('#pivot-demo').pivot_display('setup', input);
        };

        $(document).ready(function () {
            var kapsul = {};
            kapsul.teksnya = {};
            kapsul.teksnya.idunit = <?php echo $this->session->userdata['telah_masuk']['idunit'] ?>;
            kapsul.teksnya.idrrm = $('#idrrm').val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>laboratorium/lab/getSearch',
                data: kapsul,
                success: function (dataCheck) {
                    //(dataCheck);
                    jso = dataCheck;
                    setupPivot({
                        json: jso,
                        fields: fields,
                        rowLabels: ["NAMA PENGUJIAN", "KELOLA"]
                    })
                    $('.stop-propagation').click(function (event) {
                        event.stopPropagation();
                    });
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            });

        });
        
        function saving(){
        }
    </script>