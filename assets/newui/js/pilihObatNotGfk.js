var requestObat= [];
var detil_id;
var id_obat;
var nama_obat;
var jmlObat;
var satObat;
var expObat;
var batch;
var anggaran;

function choose(detil_id, id_obat, batch, nama_obat, jmlObat, satObat, expObat, anggaran, anggaranText){
    if(typeof requestObat['detil_id']=='undefined'){
        requestObat['detil_id']= [];
        requestObat['id_obat']= [];
        requestObat['batch']= [];
        requestObat['nama']= [];
        requestObat['jumlah']= [];
        requestObat['satuan']= [];
        requestObat['expired']= [];
        requestObat['anggaran']= [];
        requestObat['anggaranText']= [];
    }
    var indexArray = requestObat['detil_id'].indexOf(detil_id);
    if (indexArray > -1) {
        requestObat['jumlah'][indexArray]= Number(jmlObat);
        requestObat['batch'][indexArray]= Number(batch);
        requestObat['anggaran'][indexArray]= Number(anggaran);
        requestObat['anggaranText'][indexArray]= anggaranText;
    }
    else {
        requestObat['detil_id'].push(detil_id);
        requestObat['id_obat'].push(id_obat);
        requestObat['batch'].push(batch);
        requestObat['nama'].push(nama_obat);
        requestObat['jumlah'].push(jmlObat);
        requestObat['satuan'].push(satObat);
        requestObat['expired'].push(expObat);
        requestObat['anggaran'].push(anggaran);
        requestObat['anggaranText'].push(anggaranText);
    }
    var newTotalObat= JSON.stringify(requestObat['id_obat']);
    var newTotalBatch= JSON.stringify(requestObat['batch']);
    var newJumlahObat= JSON.stringify(requestObat['jumlah']);
    var newExpired= JSON.stringify(requestObat['expired']);
    var newAnggaran= JSON.stringify(requestObat['anggaran']);
    $('.total_kodeObat').val(newTotalObat);
    $('.total_batch').val(newTotalBatch);
    $('.total_jumlahObat').val(newJumlahObat);
    $('.total_expired').val(newExpired);
    $('.total_anggaran').val(newAnggaran);
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
            '<td>'+requestObat['anggaranText'][i]+'</td>'+
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
        requestObat['anggaran'].splice(indexArray, 1);
        requestObat['anggaranText'].splice(indexArray, 1);
    }
    var newTotalObat= JSON.stringify(requestObat['id_obat']);
    var newTotalBatch= JSON.stringify(requestObat['batch']);
    var newJumlahObat= JSON.stringify(requestObat['jumlah']);
    var newExpired= JSON.stringify(requestObat['expired']);
    var newAnggaran= JSON.stringify(requestObat['anggaran']);
    $('.total_kodeObat').val(newTotalObat);
    $('.total_batch').val(newTotalBatch);
    $('.total_jumlahObat').val(newJumlahObat);
    $('.total_expired').val(newExpired);
    $('.total_anggaran').val(newAnggaran);
    drawContentTable(requestObat);
    var row = link.parentNode.parentNode;
    var table = row.parentNode; 
    table.removeChild(row); 
}