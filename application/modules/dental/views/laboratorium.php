
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <section class="slice bg-2 p-15">
                <h3>Pemeriksaan Laboratorium</h3>
            </section>	&nbsp;
        </div>
        <div class="col-md-6">
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
            <span class="hide-on-print" id="pivot-detail"></span>
            <div style="" id="results"></div>
        </div>
        <form method="post" action="<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0) ?>/insertCekLaborat">
            <input type="hidden" id="id_rrm" name="id_rrm" type="text" value="<?php echo $this->uri->segment(4, 0); ?>">
            <input type="hidden" id="id_antrian" name="id_antrian" type="text" value="<?php echo $this->uri->segment(5, 0); ?>">
            <input type="hidden" id="id_unit_tujuan" name="id_unit_tujuan" type="text" value="<?php echo $this->uri->segment(6, 0); ?>">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Detail</label><br>
                    <table style="width: 100%; " class="table-responsive">
                        <tbody id="bodyChoosedPemeriksaan">

                        </tbody>
                    </table>
                </div>
                <input type="submit" class="btn btn-success" value="Simpan">
            </div>
        </form>
    </div>
</div>

<br>

<script type="text/javascript">
    $( document ).ready(function() {
        renderTableLaborat();
    });

    var fields = [{
            name: 'NAMA PEM LABORAT',
            type: 'string',
            filterable: true
        }, {
            name: 'PILIH',
            type: 'string',
            filterable: true
        }
    ];

    function setupPivot(input) {
        input.callbacks = {afterUpdateResults: function() {
                $('#results > table').dataTable({
                    "sDom": "<'row'<'col-md-6'l><'col-md-6'f>>t<'row'<'col-md-6'i><'col-md-6'p>>",
                    "iDisplayLength": 5,
                    "aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "All"]],
                    "oLanguage": {
                        "sLengthMenu": "_MENU_ records per page"
                    }
                });
            }};
        $('#pivot-demo').pivot_display('setup', input);
    }

    function renderTableLaborat()
    {
        var jso;
        $.ajax({
            type: "POST",
            url: '<?php echo base_url() . $this->uri->segment(1, 0) . '/' . $this->uri->segment(2, 0); ?>/showLaborat',
            success: function(dataCheck) {
                jso = dataCheck;
                setupPivot({
                    json: jso,
                    fields: fields,
                    rowLabels: ["NAMA PEM LABORAT", "PILIH"]
                })
                $('.stop-propagation').click(function(event) {
                    event.stopPropagation();
                });
            }
//            ,error: function (xhr, ajaxOptions, thrownError) {
//              alert(xhr.status);
//              alert(thrownError);
//              alert(xhr.responseText);
//            }
        });
    }


    function addPemeriksaanLaborat(id, namapemeriksaan) {
        $('#bodyChoosedPemeriksaan').append('<tr id="' + id + '"><td><input id="' + id + '" name="' + id + '" readonly class="form-control" type="text" value="' + namapemeriksaan + '"></td><td><button onclick="removeSelectedPemeriksaan(\'' + id + '\')" class="btn btn-warning" type="button">Hapus</button></td></tr>');
    }

    function removeSelectedPemeriksaan(value) {
        $('#bodyChoosedPemeriksaan').find('#' + value + '').remove();
    }


</script>  




