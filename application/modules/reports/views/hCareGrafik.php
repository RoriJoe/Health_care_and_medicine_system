<script type="text/javascript" src="<?= base_url() . 'assets/newui/assets/highchart' ?>/js/jquery.min.js"></script>
<style type="text/css">
    /*${demo.css}*/
</style>
<script type="text/javascript">
    $(function() {
        $('#grafik').highcharts({
            chart: {
                type: 'bar',
            },
            title: {
                text: 'GRAFIK LAPORAN BULANAN PELAYANAN KESEHATAN'
            }
//            ,subtitle: {
//                text: ''
//            }
            ,series: [{
                name: 'Detail Uraian',
                data: [
                    <?= $hcarepvisit[0]['KPUSBARU'] ?>, 
                    <?= $hcarepvisit[0]['KPUSLAMA'] ?>, 
                    <?= $hcarerjalan[0]['KBPBARU'] ?>, 
                    <?= $hcarerjalan[0]['KBPLAMA'] ?>, 
                    <?= $hcarekasus[0]['KB']+$hcarekasus[0]['KL']+$hcarekasus[0]['KKL'] ?>,
                    <?= $hcareugd[0]['UGDL']+$hcareugd[0]['UGDP'] ?>,
                    <?= $hcareservice[0]['EKG'] ?>,
                    <?= $hcareservice[0]['USG'] ?>,
                    <?= $hcareservice[0]['umum'] ?>,
                    <?= $hcaresourcepayment[0]['BPJS'] ?>,
                    <?= $hcaresourceservice[0]['KIABPJS']+$hcaresourceservice[0]['GUBPJS'] ?>,
                    <?= $hcaresourceservice[0]['SOURCEUMUM'] ?>,
                    <?= $hcareugd[0]['RUJUK'] ?>
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
                    'Jumlah Kunjungan Puskesmas (baru)', 
                    'Jumlah Kunjungan Puskesmas (lama)', 
                    'Jumlah Kunjungan Rawat Jalan (baru)', 
                    'Jumlah Kunjungan Rawat Jalan (lama)', 
                    'Jumlah kunjungan kasus',
                    'Jumlah penderita gawat darurat yang ditemukan',
                    'Jumlah pemeriksaan EKG/ECG',
                    'Jumlah pemeriksaan USG',
                    'Keuring Kesehatan Umum',
                    'Jumlah peserta BPJS yang terdaftar di Puskesmas',
                    'Jumlah kunjungan BPJS seluruhnya',
                    'Jumlah kunjungan Umum seluruhnya (termasuk BPJS)',
                    'Jumlah rujukan pasien(BPJS) ke Rumah Sakit'
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
            <div id="grafik" style="min-width: 310px; max-width: 90%; height: 90%; margin: 0 auto"></div>

        </div>
    </div>
</div>