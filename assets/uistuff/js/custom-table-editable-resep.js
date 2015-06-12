var requestObat= [];
var jmlObat;
var satObat;

function choose(kodeObat, namaObat, satuanObat, jumlahSehari, lamaHari, deskripsiObat){
    if(typeof requestObat['kodeObat']=='undefined'){
        requestObat['kodeObat']= [];
        requestObat['namaObat']= [];
        requestObat['satuanObat']= [];
        requestObat['jumlahSehari']= [];
        requestObat['lamaHari']= [];
        requestObat['deskripsiObat']= [];
    }
    var indexArray = requestObat['kodeObat'].indexOf(kodeObat);
    if (indexArray > -1) {
        requestObat['jumlahSehari'][indexArray]= Number(jumlahSehari);
        requestObat['lamaHari'][indexArray]= Number(lamaHari);
        requestObat['deskripsiObat'][indexArray]= Number(deskripsiObat);
    }
    else {
        requestObat['kodeObat'].push(kodeObat);
        requestObat['namaObat'].push(namaObat);
        requestObat['satuanObat'].push(satuanObat);
        requestObat['jumlahSehari'].push(jumlahSehari);
        requestObat['lamaHari'].push(lamaHari);
        requestObat['deskripsiObat'].push(deskripsiObat);
    }
    var total_kodeObat= JSON.stringify(requestObat['kodeObat']);
    var total_jumlahSehari= JSON.stringify(requestObat['jumlahSehari']);
    var total_lamaHari= JSON.stringify(requestObat['lamaHari']);
    var total_deskripsiObat= JSON.stringify(requestObat['deskripsiObat']);
    $('.total_kodeObat').val(total_kodeObat);
    $('.total_jumlahSehari').val(total_jumlahSehari);
    $('.total_lamaHari').val(total_lamaHari);
    $('.total_deskripsiObat').val(total_deskripsiObat);
    drawContentTable(requestObat['kodeObat'], requestObat['namaObat'], requestObat['satuanObat'], requestObat['jumlahSehari'], requestObat['lamaHari'], requestObat['deskripsiObat']);
}

function drawContentTable(kodeObat, namaObat, satuanObat, jumlahSehari, lamaHari, deskripsiObat){
    $(".list_obat").html("");
    for(var i=0; i<requestObat['kodeObat'].length; i++){
        var tmpCount= i+1;
        $(".list_obat").append(
            '<tr>'+
            '<td>'+tmpCount+'</td>'+
            '<td>'+namaObat[i]+'</td>'+
            '<td>'+satuanObat[i]+'</td>'+
            '<td>'+jumlahSehari[i]+'</td>'+
            '<td>'+lamaHari[i]+'</td>'+
            '<td><button class="btn btn-info popUp '+kodeObat[i]+'" data-toggle="modal" href="#myModal2" onclick="getDesc(\''+kodeObat[i]+'\',\''+namaObat[i]+'\',\''+deskripsiObat[i]+'\')">Detail</button></td>'+
            '<td><button class="btn btn-danger '+kodeObat[i]+'" onclick="deleteRow(\''+kodeObat[i]+'\',\''+namaObat[i]+'\',this)">Hapus</button></td>'+
            '<tr/>'
        );
    }
}

function getDesc(kodeObat, namaObat, deskripsiObat){
    var indexArray = requestObat['kodeObat'].indexOf(kodeObat);
        if (indexArray > -1) {
            $('.namaObat2').val(requestObat['namaObat'][indexArray]);
            $('.satuanObat2').val(requestObat['satuanObat'][indexArray]);
            $('.jumlahSehari2').val(requestObat['jumlahSehari'][indexArray]);
            $('.lamaHari2').val(requestObat['lamaHari'][indexArray]);
            $('.deskripsiObat2').val(requestObat['deskripsiObat'][indexArray]);
    }
}

var deleteRow = function (kodeObat, namaObat, link) {
    var indexArray = requestObat['kodeObat'].indexOf(kodeObat);
    if (indexArray > -1) {
        requestObat['kodeObat'].splice(indexArray, 1);
        requestObat['namaObat'].splice(indexArray, 1);
        requestObat['satuanObat'].splice(indexArray, 1);
        requestObat['jumlahSehari'].splice(indexArray, 1);
        requestObat['lamaHari'].splice(indexArray, 1);
        requestObat['deskripsiObat'].splice(indexArray, 1);
    }
    var total_kodeObat= JSON.stringify(requestObat['kodeObat']);
    var total_jumlahSehari= JSON.stringify(requestObat['jumlahSehari']);
    var total_lamaHari= JSON.stringify(requestObat['lamaHari']);
    var total_deskripsiObat= JSON.stringify(requestObat['deskripsiObat']);
    $('.total_kodeObat').val(total_kodeObat);
    $('.total_jumlahSehari').val(total_jumlahSehari);
    $('.total_lamaHari').val(total_lamaHari);
    $('.total_deskripsiObat').val(total_deskripsiObat);
    drawContentTable(requestObat['kodeObat'], requestObat['namaObat'], requestObat['satuanObat'], requestObat['jumlahSehari'], requestObat['lamaHari'], requestObat['deskripsiObat']);
    var row = link.parentNode.parentNode;
    var table = row.parentNode; 
    table.removeChild(row); 
}

var EditableTable = function () {

    return {

        //main function to initiate the module
        init: function () {
            function restoreRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    oTable.fnUpdate(aData[i], nRow, i, false);
                }

                oTable.fnDraw();
            }

            var tmp;
            var tmp1;
            var tmp2;
            var tmp3;
            function editRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0]= aData[0];
                jqTds[1]= aData[1];
                jqTds[2]= aData[2];
                satObat= aData[2];
                tmp1= aData[0];
                tmp2= aData[1];
                tmp3= aData[2];
                $('.kodeObat').val(tmp1);
                $('.namaObat').val(tmp2);
                $('.satuanObat').val(tmp3);
                var indexArray = requestObat['kodeObat'].indexOf(tmp1);
                if (indexArray > -1) {
                    $('.jumlahSehari').val(requestObat['jumlahSehari'][indexArray]);
                    $('.lamaHari').val(requestObat['lamaHari'][indexArray]);
                    $('.deskripsiObat').val(requestObat['deskripsiObat'][indexArray]);
                }
                else {
                    $('.jumlahSehari').val('');
                    $('.lamaHari').val('');
                    $('.deskripsiObat').val('');
                }
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                jmlObat= Number($('#count_drug').val());
                oTable.fnUpdate(Number($('#count_drug').val()), nRow, 3, false);
                oTable.fnUpdate('<a class="edit" href="">Pilih</a>', nRow, 4, false);
                oTable.fnUpdate(''+tmp+'', nRow, 5, false);
                oTable.fnDraw();
                choose(tmp1, tmp2);
            }

            function cancelEditRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                oTable.fnUpdate('<a class="edit" href="">Pilih</a>', nRow, 4, false);
                oTable.fnDraw();
            }

            var oTable = $('#editable-sample').dataTable({
                "aLengthMenu": [
                    [10, 15, 20, -1],
                    [10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 10,
                "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records per page",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });

            jQuery('#editable-sample_wrapper .dataTables_filter input').addClass("form-control medium"); // modify table search input
            jQuery('#editable-sample_wrapper .dataTables_length select').addClass("form-control xsmall"); // modify table per page dropdown

            var nEditing = null;

            $('#editable-sample_new').click(function (e) {
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '', '', '',
                        '<a class="edit" href="">Edit</a>', '<a class="cancel" data-mode="new" href="">Cancel</a>'
                ]);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
            });

            $('#editable-sample a.delete').live('click', function (e) {
                e.preventDefault();

                if (confirm("Are you sure to delete this row ?") == false) {
                    return;
                }

                var nRow = $(this).parents('tr')[0];
                oTable.fnDeleteRow(nRow);
                console.log("Deleted! Do not forget to do some ajax to sync with backend :)");
            });

            $('#editable-sample a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);
                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                }
            });

            $('#editable-sample a.edit').live('click', function (e) {
                e.preventDefault();

                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];

                if (nEditing !== null && nEditing != nRow) {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    restoreRow(oTable, nEditing);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                } else if (nEditing == nRow && this.innerHTML == "Tambah") {
                    /* Editing this row and want to save it */
                    saveRow(oTable, nEditing);
                    nEditing = null;
                    console.log("Updated! Do not forget to do some ajax to sync with backend :)");
                } else {
                    /* No edit in progress - let's start one */
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
            });
        }

    };

}();