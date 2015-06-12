var requestObat= [];
var detil_id;
var id_obat;
var nama_obat;
var jmlObat;
var satObat;
var expObat;
var batch;

function choose(detil_id, id_obat, batch, nama_obat, jmlObat, satObat, expObat){
    if(typeof requestObat['detil_id']=='undefined'){
        requestObat['detil_id']= [];
        requestObat['id_obat']= [];
        requestObat['batch']= [];
        requestObat['nama']= [];
        requestObat['jumlah']= [];
        requestObat['satuan']= [];
        requestObat['expired']= [];
    }
    var indexArray = requestObat['detil_id'].indexOf(detil_id);
    if (indexArray > -1) {
        requestObat['jumlah'][indexArray]= Number(jmlObat);
    }
    else {
        requestObat['detil_id'].push(detil_id);
        requestObat['id_obat'].push(id_obat);
        requestObat['batch'].push(batch);
        requestObat['nama'].push(nama_obat);
        requestObat['jumlah'].push(jmlObat);
        requestObat['satuan'].push(satObat);
        requestObat['expired'].push(expObat);
    }
    var newTotalObat= JSON.stringify(requestObat['id_obat']);
    var newTotalBatch= JSON.stringify(requestObat['batch']);
    var newJumlahObat= JSON.stringify(requestObat['jumlah']);
    $('.total_kodeObat').val(newTotalObat);
    $('.total_batch').val(newTotalBatch);
    $('.total_jumlahObat').val(newJumlahObat);
    drawContentTable(requestObat);
}

function drawContentTable(requestObat){
    $(".list_obat").html("");
    for(var i=0; i<requestObat['detil_id'].length; i++){
        var tmpCount= i+1;
        $(".list_obat").append(
            '<tr>'+
            '<td>'+tmpCount+'</td>'+
//            '<td>'+id_obat[i]+'</td>'+
            '<td>'+requestObat['batch'][i]+'</td>'+
            '<td>'+requestObat['nama'][i]+'</td>'+
            '<td>'+requestObat['satuan'][i]+'</td>'+
            '<td>'+requestObat['jumlah'][i]+'</td>'+
            '<td>'+requestObat['expired'][i]+'</td>'+
            '<td><button class="btn btn-danger '+requestObat['detil_id'][i]+'" onclick="deleteRow(\''+requestObat['detil_id'][i]+'\',\''+requestObat['nama'][i]+'\',this)">Hapus</button></td>'+
            '<tr/>'
        );
    }
}

var deleteRow = function (detil_id, nama_obat, link) {
    var indexArray = requestObat['detil_id'].indexOf(detil_id);
    if (indexArray > -1) {
        requestObat['detil_id'].splice(indexArray, 1);
        requestObat['id_obat'].splice(indexArray, 1);
        requestObat['nama'].splice(indexArray, 1);
        requestObat['jumlah'].splice(indexArray, 1);
        requestObat['satuan'].splice(indexArray, 1);
        requestObat['expired'].splice(indexArray, 1);
        requestObat['batch'].splice(indexArray, 1);
    }
    var newTotalObat= JSON.stringify(requestObat['id_obat']);
    var newTotalBatch= JSON.stringify(requestObat['batch']);
    var newJumlahObat= JSON.stringify(requestObat['jumlah']);
    $('.total_kodeObat').val(newTotalObat);
    $('.total_batch').val(newTotalBatch);
    $('.total_jumlahObat').val(newJumlahObat);
    drawContentTable(requestObat);
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
            var idDetailObat;
            var namaObat;
            function editRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0]= aData[0];//idDetail
                jqTds[1]= aData[1];//Kode Obat
                jqTds[2]= aData[2];//No Batch
                jqTds[3]= aData[3];//Nama Obat
                jqTds[4]= aData[4];//Satuan
                jqTds[6]= aData[6];//Stok Sisa
                detil_id= aData[0];
                id_obat= aData[1];
                batch= aData[2];
                nama_obat= aData[3];
                satObat= aData[4];
                expObat= aData[5];
                jqTds[7].innerHTML = '<input id="count_drug" type="text" class="form-control small" value="' + aData[7] + '" >';
                jqTds[8].innerHTML = '<a class="edit" href="">Tambah</a>';
                jqTds[9].innerHTML = '<a class="cancel" href="">Cancel</a>';
                tmp= aData[9];  //last column
            }

            function saveRow(oTable, nRow) {
                var jumlahObat= Number($('#count_drug').val());
<<<<<<< .mine
                /*if(jumlahObat>=currentStok){    //check max stok
                    alert("Melebihi batas stok "+tmp2+" sejumlah "+currentStok);
                    $('#count_drug').val(0);
//                    $('.jml_'+tmp1).text(0);
                    oTable.fnUpdate(0, nRow, 3, false);
                    oTable.fnUpdate('<a class="edit" href="">Pilih</a>', nRow, 4, false);
                    oTable.fnUpdate('', nRow, 5, false);
                }
                else {*/
=======
//                var currentStok= Number($('.stok_'+idDetailObat).text());
//                if(jumlahObat>=currentStok){    //check max stok
//                    alert("Melebihi batas stok "+namaObat+" sejumlah "+currentStok);
//                    $('#count_drug').val(0);
//                    oTable.fnUpdate(0, nRow, 3, false);
//                    oTable.fnUpdate('<a class="edit" href="">Pilih</a>', nRow, 4, false);
//                    oTable.fnUpdate('', nRow, 5, false);
//                }
//                else {
>>>>>>> .r128
                    var jqInputs = $('input', nRow);
                    jmlObat= Number($('#count_drug').val());
                    oTable.fnUpdate(Number($('#count_drug').val()), nRow, 7, false);
                    oTable.fnUpdate('<a class="edit" href="">Pilih</a>', nRow, 8, false);
                    oTable.fnUpdate(''+tmp+'', nRow, 9, false);
                    oTable.fnDraw();
<<<<<<< .mine
                    choose(tmp1, tmp2);
                //}
=======
//                    choose(idDetailObat, namaObat);
                    choose(detil_id, id_obat, batch, nama_obat, jmlObat, satObat, expObat)
//                }
>>>>>>> .r128
            }

            function cancelEditRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[5].value, nRow, 7, false);
                oTable.fnUpdate('<a class="edit" href="">Pilih</a>', nRow, 8, false);
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