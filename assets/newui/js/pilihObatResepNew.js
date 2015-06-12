var requestObat= [];
var detil_id;
var id_obat;
var nama_obat;
var jmlObat;
var satObat;
var expObat;
var batch;
var lamaHari;
var deskripsiObat;
var signa;

function choose(detil_id, id_obat, batch, nama_obat, jmlObat, satObat, expObat, lamaHari, deskripsiObat, signa){
    if(typeof requestObat['detil_id']=='undefined'){
        requestObat['detil_id']= [];
        requestObat['id_obat']= [];
        requestObat['batch']= [];
        requestObat['nama']= [];
        requestObat['jumlah']= [];
        requestObat['satuan']= [];
        requestObat['expired']= [];
        requestObat['lamaHari']= [];
        requestObat['deskripsiObat']= [];
        requestObat['signa']= [];
    }
    var indexArray = requestObat['detil_id'].indexOf(detil_id);
    if (indexArray > -1) {
        requestObat['jumlah'][indexArray]= Number(jmlObat);
        requestObat['lamaHari'][indexArray]= Number(lamaHari);
        requestObat['deskripsiObat'][indexArray]= deskripsiObat;
        requestObat['signa'][indexArray]= signa;
    }
    else {
        requestObat['detil_id'].push(detil_id);
        requestObat['id_obat'].push(id_obat);
        requestObat['batch'].push(batch);
        requestObat['nama'].push(nama_obat);
        requestObat['jumlah'].push(jmlObat);
        requestObat['satuan'].push(satObat);
        requestObat['expired'].push(expObat);
        requestObat['lamaHari'].push(lamaHari);
        requestObat['deskripsiObat'].push(deskripsiObat);
        requestObat['signa'].push(signa);
    }
    var newTotalObat= JSON.stringify(requestObat['id_obat']);
    var newTotalBatch= JSON.stringify(requestObat['batch']);
    var newJumlahObat= JSON.stringify(requestObat['jumlah']);
    var newTotallamaHari= JSON.stringify(requestObat['lamaHari']);
    var newDeskripsiObat= JSON.stringify(requestObat['deskripsiObat']);
    var newSigna= JSON.stringify(requestObat['signa']);
    $('.total_kodeObat').val(newTotalObat);
    $('.total_batch').val(newTotalBatch);
    $('.total_jumlahSehari').val(newJumlahObat);
    $('.total_lamaHari').val(newTotallamaHari);
    $('.total_deskripsiObat').val(newDeskripsiObat);
    $('.total_signa').val(newSigna);
    drawContentTable(requestObat);
}

function drawContentTable(requestObat){
    $(".list_obat").html("");
    for(var i=0; i<requestObat['detil_id'].length; i++){
        var tmpCount= i+1;
        $(".list_obat").append(
            '<tr>'+
            '<td>'+tmpCount+'</td>'+
            '<td>'+requestObat['batch'][i]+'</td>'+
            '<td>'+requestObat['nama'][i]+'</td>'+
            '<td>'+requestObat['satuan'][i]+'</td>'+
            '<td>'+requestObat['jumlah'][i]+'</td>'+
            '<td>'+requestObat['lamaHari'][i]+'</td>'+
            '<td>'+requestObat['signa'][i]+'</td>'+
            '<td><button class="btn btn-info" data-toggle=\"modal\" href=\"#myModal2\" onclick=\"detailObat(\''+requestObat['nama'][i]+'\',\''+requestObat['satuan'][i]+'\',\''+requestObat['jumlah'][i]+'\',\''+requestObat['lamaHari'][i]+'\',\''+requestObat['deskripsiObat'][i]+'\',\''+requestObat['signa'][i]+'\')\">Detail</button></td>'+
            '<td><button class="btn btn-danger '+requestObat['detil_id'][i]+'" onclick="deleteRow(\''+requestObat['detil_id'][i]+'\',\''+requestObat['nama'][i]+'\',this)">Hapus</button></td>'+
            '<tr/>'
        );
    }
}

function detailObat(nama, satuan, jml, lama, deskripsi, signa){
    $('.namaObat2').val(nama);
    $('.satuanObat2').val(satuan);
    $('.jumlahSehari2').val(jml);
    $('.lamaHari2').val(lama);
    $('.deskripsiObat2').val(deskripsi);
    $('.signa2').val(signa);
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
        requestObat['lamaHari'].splice(indexArray, 1);
        requestObat['deskripsiObat'].splice(indexArray, 1);
        requestObat['signa'].splice(indexArray, 1);
    }
    var newTotalObat= JSON.stringify(requestObat['id_obat']);
    var newTotalBatch= JSON.stringify(requestObat['batch']);
    var newJumlahObat= JSON.stringify(requestObat['jumlah']);
    var newTotallamaHari= JSON.stringify(requestObat['lamaHari']);
    var newDeskripsiObat= JSON.stringify(requestObat['deskripsiObat']);
    var newSigna= JSON.stringify(requestObat['signa']);
    $('.total_kodeObat').val(newTotalObat);
    $('.total_batch').val(newTotalBatch);
    $('.total_jumlahSehari').val(newJumlahObat);
    $('.total_lamaHari').val(newTotallamaHari);
    $('.total_deskripsiObat').val(newDeskripsiObat);
    $('.total_signa').val(newSigna);
    drawContentTable(requestObat);
    var row = link.parentNode.parentNode;
    var table = row.parentNode; 
    table.removeChild(row); 
}