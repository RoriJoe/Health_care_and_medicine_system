var requestObat= [];
var id_obat;
var nama_obat;
var jmlObat;
var satObat;

function choose(id_obat, nama_obat, jmlObat, satObat){
    if(typeof requestObat['id_obat']=='undefined'){
        requestObat['id_obat']= [];
        requestObat['nama']= [];
        requestObat['jumlah']= [];
        requestObat['satuan']= [];
    }
    var indexArray = requestObat['id_obat'].indexOf(id_obat);
    if (indexArray > -1) {
        requestObat['jumlah'][indexArray]= Number(jmlObat);
    }
    else {
        requestObat['id_obat'].push(id_obat);
        requestObat['nama'].push(nama_obat);
        requestObat['jumlah'].push(jmlObat);
        requestObat['satuan'].push(satObat);
    }
    var newTotalObat= JSON.stringify(requestObat['id_obat']);
    var newJumlahObat= JSON.stringify(requestObat['jumlah']);
    $('.total_kodeObat').val(newTotalObat);
    $('.total_jumlahObat').val(newJumlahObat);
    drawContentTable(requestObat);
}

function drawContentTable(requestObat){
    $(".list_obat").html("");
    for(var i=0; i<requestObat['id_obat'].length; i++){
        var tmpCount= i+1;
        $(".list_obat").append(
            '<tr>'+
            '<td>'+tmpCount+'</td>'+
            '<td>'+requestObat['nama'][i]+'</td>'+
            '<td>'+requestObat['satuan'][i]+'</td>'+
            '<td>'+requestObat['jumlah'][i]+'</td>'+
            '<td><button class="btn btn-danger '+requestObat['id_obat'][i]+'" onclick="deleteRow(\''+requestObat['id_obat'][i]+'\',\''+requestObat['nama'][i]+'\',this)">Hapus</button></td>'+
            '<tr/>'
        );
    }
}

var deleteRow = function (id_obat, nama_obat, link) {
    var indexArray = requestObat['id_obat'].indexOf(id_obat);
    if (indexArray > -1) {
        requestObat['id_obat'].splice(indexArray, 1);
        requestObat['nama'].splice(indexArray, 1);
        requestObat['jumlah'].splice(indexArray, 1);
        requestObat['satuan'].splice(indexArray, 1);
    }
    var newTotalObat= JSON.stringify(requestObat['id_obat']);
    var newJumlahObat= JSON.stringify(requestObat['jumlah']);
    $('.total_kodeObat').val(newTotalObat);
    $('.total_jumlahObat').val(newJumlahObat);
    drawContentTable(requestObat);
    var row = link.parentNode.parentNode;
    var table = row.parentNode; 
    table.removeChild(row); 
}