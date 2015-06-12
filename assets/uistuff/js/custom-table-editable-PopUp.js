var requestObat= [];
var kodeObat;
var batch;
var jmlObat;
var satObat;
var expired;
var sisa;

function choose(detil_to, nama_obat){
    if(typeof requestObat['id']=='undefined'){
        requestObat['id']= [];
        requestObat['nama']= [];
        requestObat['jumlah']= [];
        requestObat['satuan']= [];
        requestObat['kodeObat']= [];
        requestObat['batch']= [];
        requestObat['expired']= [];
        requestObat['sisa']= [];
    }
    var indexArray = requestObat['id'].indexOf(detil_to);
    if (indexArray > -1) {
        requestObat['jumlah'][indexArray]= Number(jmlObat);
    }
    else {
        requestObat['id'].push(detil_to);
        requestObat['nama'].push(nama_obat);
        requestObat['jumlah'].push(jmlObat);
        requestObat['satuan'].push(satObat);
        requestObat['kodeObat'].push(kodeObat);
        requestObat['batch'].push(batch);
        requestObat['expired'].push(expired);
        requestObat['sisa'].push(sisa);
    }
}

function drawObat(){
    if(typeof requestObat['id'] != 'undefined') {
        var length = requestObat['id'].length;
        if(length > 0){
            for(var i=0; i<requestObat['id'].length; i++){
                var isIssetObat= $( ".startHere" ).hasClass( "kode_"+requestObat['id'][i] );
                if(isIssetObat){
                    $('.kode_'+requestObat['id'][i]).html(
                        '<td style="display: none" class="idObat">'+requestObat['kodeObat'][i]+'</td>'+
                        '<td class="batch">'+requestObat['batch'][i]+'</td>'+
                        '<td class="nama_'+requestObat['id'][i]+'">'+requestObat['nama'][i]+'</td>'+
                        '<td>'+requestObat['satuan'][i]+'</td>'+
                        '<td class="sisaStok">'+requestObat['sisa'][i]+'</td>'+
                        '<td class="jml_'+requestObat['id'][i]+' totalJml">'+requestObat['jumlah'][i]+'</td>'+
                        '<td class="">'+requestObat['expired'][i]+'</td>'+
                        '<td class="mge_'+requestObat['id'][i]+'">'+
                            '<input type="button" class="btn-danger" onclick="deleteObat(\''+requestObat['id'][i]+'\')" value="Hapus" /> | '+
                            '<input type="button" class="btn-info" onclick="updateObat(\''+requestObat['id'][i]+'\')" value="Ubah" />'+
                        '</td>'
                    );
                }
                else {
                    $(".obatBody").append(
                        '<tr class="startHere kode_'+requestObat['id'][i]+'">'+
                            '<td style="display: none" class="idObat">'+requestObat['kodeObat'][i]+'</td>'+
                            '<td class="batch">'+requestObat['batch'][i]+'</td>'+
                            '<td class="nama_'+requestObat['id'][i]+'">'+requestObat['nama'][i]+'</td>'+
                            '<td>'+requestObat['satuan'][i]+'</td>'+
                            '<td class="sisaStok">'+requestObat['sisa'][i]+'</td>'+
                            '<td class="jml_'+requestObat['id'][i]+' totalJml">'+requestObat['jumlah'][i]+'</td>'+
                            '<td class="">'+requestObat['expired'][i]+'</td>'+
                            '<td class="mge_'+requestObat['id'][i]+'">'+
                                '<input type="button" class="btn-danger" onclick="deleteObat(\''+requestObat['id'][i]+'\')" value="Hapus" /> | '+
                                '<input type="button" class="btn-info" onclick="updateObat(\''+requestObat['id'][i]+'\')" value="Ubah" />'+
                            '</td>'+
                        '<tr/>'
                    );
                }
            }
        }
    }
}

function cancelObat(id){
    if (confirm("Ubah data obat?")) {
        $('.mge1_'+id).html('<a class="edit btn btn-danger fa fa-minus-square" href="javascript:;" style="color:white;"> Ubah</a>');
        $('.jml1_'+id).text('0');
            var indexArray = requestObat['id'].indexOf(id);
            if (indexArray > -1) {
                requestObat['id'].splice(indexArray, 1);
                requestObat['nama'].splice(indexArray, 1);
                requestObat['jumlah'].splice(indexArray, 1);
                requestObat['satuan'].splice(indexArray, 1);
                requestObat['kodeObat'].splice(indexArray, 1);
                requestObat['batch'].splice(indexArray, 1);
                requestObat['expired'].splice(indexArray, 1);
                requestObat['sisa'].splice(indexArray, 1);
            }
        }
}


function clear(id){
    var saveJml= 0;
    if(typeof requestObat['id'] != 'undefined') {
        var indexArray = requestObat['id'].indexOf(id);
    }
    if(indexArray > -1){
        saveJml= requestObat['jumlah'][indexArray]
    }
    $('.clear_'+id).remove();
    $('.jml1_'+id).text(saveJml);
    $('.mge1_'+id).html('<a class="edit btn btn-danger fa fa-minus-square" href="javascript:;" style="color:white;"> Ubah</a>');
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

            var tmp1;
            var tmp2;
            var tmp_check;
            function editRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0]= aData[0]; //id detil to
                kodeObat= aData[1]; //id obat
                batch= aData[2];    //no batch
                jqTds[3]= aData[3]; //nama obat
                satObat= aData[4];  //satuan
                sisa= aData[5];     //sisa stok
                expired= aData[6];  //expired date
                jqTds[7].innerHTML = '<input id="count_drug" style="width:100px;" type="text" class="isianJml form-control small" value="'+0+'">';
                jqTds[8].innerHTML = '<a class="edit btn btn-primary fa fa-plus-square" href="" style="color:white">Tambah</a>';
                jqTds[9].innerHTML = '<a class="clear_'+aData[2]+' btn btn-primary fa fa-plus-square" href="javascript:clear(\''+aData[2]+'\')"  style="color:white;">Cancel</a>';
                tmp1= aData[2];
                tmp2= aData[3];
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                jmlObat= Number($('#count_drug').val());
                if(sisa>jmlObat){
                    oTable.fnUpdate(Number($('#count_drug').val()), nRow, 7, false);
                    oTable.fnUpdate('<a class="cancelObat_'+tmp1+' btn btn-primary fa fa-check-square" href="javascript:cancelObat(\''+tmp1+'\');" style="color:white;">Terpilih</a>', nRow, 8, false);
                    oTable.fnUpdate('', nRow, 9, false);
                    oTable.fnDraw();
                    choose(tmp1, tmp2);
                    $('#count_drug').val('');
                }
                else {
                    oTable.fnUpdate(0, nRow, 7, false);
                    oTable.fnUpdate('<a class="edit btn btn-danger fa fa-minus-square" href="javascript:;" style="color:white;"> Ubah</a>', nRow, 8, false);
                    oTable.fnUpdate('', nRow, 9, false);
                    oTable.fnDraw();
                    alert("Pengiriman "+tmp2+"\nMelebih Stok yang Tersedia\nJumlah Stok Obat Sekarang: "+sisa);
                    $('#count_drug').val('');
                }
            }

            function cancelEditRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[4].value, nRow, 7, false);
                oTable.fnUpdate('<a class="edit" href="">Ubah</a>', nRow, 8, false);
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