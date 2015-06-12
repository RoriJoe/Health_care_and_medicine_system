<script type="text/javascript" src="<?= base_url() . 'assets/newui/assets/highchart' ?>/js/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('#grafik').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'GRAFIK LAPORAN BULANAN PELAYANAN RAWAT INAP'
            }
//            ,subtitle: {
//                text: ''
//            }
            ,series: [{
                name: 'Detail Uraian',
                data: [
                    <?= $riBedDetail[0]['BIASA']+$riBedDetail[0]['KHUSUS']+$riBedDetail[0]['PONED'] ?>, 
                    <?= $riVSDetail[0]['Baru'] ?>, 
                    <?= $riC[0]['BIASA']+$riC[0]['KHUSUS']+$riC[0]['PONED'] ?>, 
                    <?= $riVC[0]['BPJS']+$riVC[0]['SKM']+$riVC[0]['Umum'] ?>, 
                    <?= $riRIH[0]['hUmum']+$riRIH[0]['hSKM']+$riRIH[0]['hBPJS'] ?>,
                    <?= $rikeluar[0]['RIKELUARSEMBUH']+$rikeluar[0]['RIKELUARMENINGGAL']+$rikeluar[0]['RIKELUARPAKSA']+$rikeluar[0]['RIKELUARRUJUKAN'] ?>,
                    <?= $riPoned[0]['Materna']+$riPoned[0]['Neonata']+$riPoned[0]['Normal']+$riPoned[0]['Baru'] ?>
                ]
            }]
            ,xAxis: {
                labels: {
                    style: {
                        color: '#525151',
                        font: '15px Helvetica',
                        fontWeight: 'bold'
                    }
                },
                categories: [
                    'Jumlah Tempat Tidur (TT) untuk fasilitas Rawat Inap',
                    'Jumlah kunjungan Rawat Inap Baru',
                    'Jumlah kunjungan Rawat Inap',
                    'Jumlah penderita berdasarkan jenis kunjungan',
                    'Jumlah Hari Perawatan (HP)',
                    'Jumlah penderita yang keluar',
                    'Pelayanan PONED (khusus Puskesmas PONED)'
                ],
                title: {
                    text: 'Uraian',
                    style: {
                            fontSize: '20px'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah',
                    align: 'middle',
                    style: {
                            fontSize: '20px'
                    }
                },
                labels: {
                    style: {
                        color: '#525151',
                        font: '15px Helvetica',
                        fontWeight: 'bold'
                    },
                    overflow: 'justify',
                }
            }
            ,plotOptions: {
                series: {
                    pointWidth: 35
                },
                bar: {
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '20px'
                        }
                    }
                }
            }
            ,legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                shadow: true
            },
            credits: {
                enabled: false
            }
        });
    });
</script>
<script src="<?= base_url() . 'assets/newui/assets/highchart' ?>/js/highcharts.js"></script>
<script src="<?= base_url() . 'assets/newui/assets/highchart' ?>/js/modules/exporting.js"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div style="border-color: red;border-style: solid;border-width: 5px;width: 300px;padding: 10px;">
                <?php 
                    $jumhariperawatan = ($riRIH[0]['hUmum']+$riRIH[0]['hSKM']+$riRIH[0]['hBPJS']);
                    $jumpenderitakeluar = ($rikeluar[0]['RIKELUARSEMBUH']+$rikeluar[0]['RIKELUARMENINGGAL']+$rikeluar[0]['RIKELUARPAKSA']+$rikeluar[0]['RIKELUARRUJUKAN']);
                    $jumlahBed = $riBedDetail[0]['BIASA']+$riBedDetail[0]['KHUSUS']+$riBedDetail[0]['PONED'];
                    $jumlahri = $riC[0]['BIASA']+$riC[0]['KHUSUS']+$riC[0]['PONED'];

                    if($jumlahri == 0)
                    $alos = 0;
                    else
                    $alos = number_format(($jumhariperawatan/$jumlahri), 2, '.', '');;

                    if($jumlahBed == 0)
                    $bto = 0;
                    else
                    $bto = number_format(($jumpenderitakeluar/$jumlahBed), 2, '.', '');;

                    if($jumpenderitakeluar == 0)
                    $toi = 0;
                    else
                    $toi = number_format(((($jumlahBed*cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun))-$jumhariperawatan)/$jumpenderitakeluar), 2, '.', '');

                    if($riBedDetail[0]['BIASA']+$riBedDetail[0]['KHUSUS']+$riBedDetail[0]['PONED'] == 0)
                    $val = 0;
                    else
                    $val= number_format(((($riRIH[0]['hUmum']+$riRIH[0]['hSKM']+$riRIH[0]['hBPJS'])/(($riBedDetail[0]['BIASA']+$riBedDetail[0]['KHUSUS']+$riBedDetail[0]['PONED'])*cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun)))*100), 2, '.', '');

                    echo 'Bed Occupancy Rate (BOR) : '.$val.'%<br/>';
                    echo 'Average Length of Stay (ALOS) : '.$alos.'%<br/>';
                    echo 'Bed Turn Over (BTO) : '.$bto.'%<br/>';
                    echo 'Turn Over Interval (TOI) : '.$toi.'%<br/>';
                ?>
            </div>

            <div id="grafik" style="min-width: 310px; max-width: 90%; height: 90%; margin: 0 auto"></div>

        </div>
    </div>
</div>