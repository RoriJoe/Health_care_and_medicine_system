
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <section class="slice bg-2 p-15">
                <h3>Riwayat Kunjungan Pasien <?php if (isset($data_rrm)) : echo '- ' . $data_rrm[0]->NAMA_PASIEN ; endif;  ?></h3>
            </section>	&nbsp;

                <div class="col-md-4">
					<br>
                    <input type="hidden" value="<?php echo $id_rm ?>" id="id_rm"/>
                    <label >Jumlah Data</label>
                    <select class="form-control" onchange="renderTable()" id="rangedata" name="rangedata">
                        <option value="100" selected>100 Riwayat Terakhir</option>
                        <option value="250">250 Riwayat Terakhir</option>
                        <option value="350">350 Riwayat Terakhir</option>
                        <option value="">Semua Data</option>
                    </select>
					<br>
                </div>
				
				
                <div class="col-lg-12">
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
                    <div  id="results"></div>
                </div>

        </div>
    </div>
	<br>
<br>
</div>

<script type="text/javascript">
	$(function () {
		renderTable();
	});

    var fields = [
		{
            name: 'NOMOR',
            type: 'string',
            filterable: true
        },{
            name: 'TANGGAL KUNJUNGAN',
            type: 'string',
            filterable: true
        },{
            name: 'DETIL',
            type: 'string',
            filterable: true
        }
    ]

    function renderTable()
    {
        var kapsul = {};
        kapsul.teksnya = {};
        kapsul.teksnya.id_rm = $("#id_rm").val();
        kapsul.teksnya.range = document.getElementById("rangedata").value;
        
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>/getSearch2',
            data: kapsul,
            success: function (dataCheck) {
//                alert(dataCheck);
				
				
                jso = dataCheck;
                setupPivot({
                    json: jso,
                    fields: fields,
                    rowLabels: ["NOMOR", "TANGGAL KUNJUNGAN", "DETIL"]                           
                })
                $('.stop-propagation').click(function (event) {
                    event.stopPropagation();
                });

            },
            error: function (xhr, status, error) {
                // alert ("Error");
            }
        });
    }
</script>