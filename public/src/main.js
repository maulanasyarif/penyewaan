$(document).ready(function(){
    __fetchJam();
    __loadItem();
    __onChange();
    __loadTransaksi(null);
    __clickJam();
    __submit();
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }
    
    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("date").setAttribute("min", today);
})

var jam = [
    "06:00",
    "07:00", 
    "08:00", 
    "09:00", 
    "10:00", 
    "11:00", 
    "12:00", 
    "13:00", 
    "14:00", 
    "15:00", 
    "16:00", 
    "17:00", 
    "18:00", 
    "19:00", 
    "20:00", 
    "21:00", 
    "22:00",
    "24:00"
    ];
function __fetchJam()
{
    var htm = ``
    $.each(jam, function(k, v){
        htm = `
        <button id="btn" class="btn btn-sm btn-info mt-1 btn-jam" dt=${v}>${v}</button>
        `
        $('#jam').append(htm)
    })
}

function __loadItem()
{
    $.ajax({
        url: `/customer/item`,
        type: 'GET',
        dataType: 'JSON',
        beforeSend: function() {
        },
        success: function(res) {
            if(res.code == 200){
                if(res.data.length>0){
                    var htm = ``;
                    $.each(res.data, function(k, v){
                        htm += `
                            <option value="${v.id}" dt="${v.name}">${v.name} | ${v.price}</option>
                        `
                    })

                    $('[name="item_id"]').html(htm)
                }
            }
        },
        error: function(err) {
        },
        complete: function() {
        },
    })
}

function __onChange()
{
    var opt = {}
    $(document).on('change', '[name]', function(){
        $('#option').find('[name]').each(function(k, v){
            opt[$(v).attr('name')] = $(v).val()
        })
        $('#tgl').html(opt.tanggal)
        __loadTransaksi(opt)
        __getItem(opt.item_id)
    })
}

function __getItem(id)
{
    var dt = {item_id:id}
    $.ajax({
        url: `/customer/item`,
        type: 'GET',
        dataType: 'JSON',
        data: dt,
        beforeSend: function() {
        },
        success: function(res) {
            if(res.code == 200){
                $('span#item').html(res.data[0].name)
                $('span#harga').html(`${res.data[0].price}`)
            }
        },
        error: function(err) {
        },
        complete: function() {
        },
    })
}

function __loadTransaksi(data)
{
    var param = data;

    //contoh
    // var pending = [
    //     "06:00",
    //     "07:00", 
    //     "08:00", 
    //     "09:00",
    // ];

    var success = [
        "10:00", 
        "11:00", 
        "12:00", 
        "13:00",
    ];

    // if(pending.length>0){
    //     $.each(pending, function(k, v){
    //         $(document).find(`.btn-jam[dt="${v}"]`).removeClass('btn-info').addClass('btn-warning').attr('disabled', true)
    //     })
    // }

    if(success.length>0){
        $.each(success, function(k, v){
            $(document).find(`.btn-jam[dt="${v}"]`).removeClass('btn-info').addClass('btn-success').attr('disabled', true)
        })
    }


    // $.ajax({
    //     url: ``,
    //     type: 'GET',
    //     dataType: 'JSON',
    //     data: param,
    //     beforeSend: function() {
    //     },
    //     success: function(res) {
    //         if(res.code == 200){
    //             if(res.data.length>0){
    //                 var htm = ``;
    //                 // looping transaksi booking / pending
    //             }
    //         }
    //     },
    //     error: function(err) {
    //     },
    //     complete: function() {
    //     },
    // })
}

var arrJam = [];
function __clickJam()
{
    $(document).on('click', '#btn', '#jam', function(e){
        e.preventDefault();
        $(this).attr('disabled', true)
        arrJam.push($(this).attr('dt'))
        var length = arrJam.length;
        __jam(length)
    })
}

function __jam(data)
{   
    if(arrJam.length>0){
        var htm =  ``;
        $.each(arrJam, function(k, v){
            htm += `${v}, `
        })
        $('#detail_jam').html(htm)
    }
    var jumlah = data;
    var harga = $(document).find('span[id="harga"]').text()
    $('#total').html(harga * jumlah)
    $('#total_jam').html(`${jumlah} Jam`)
}

function __submit()
{
    var data = {}
    $(document).on('click', '#btn-submit', function(){
        var menu  = $(document).find('select[name="item_id"]').val()
        var tanggal = $(document).find('input[name="tanggal"]').val()
        var jam = arrJam;

        data.menu_id = menu
        data.jam = jam
        data.tanggal = tanggal
        console.log(data)

        // $.ajax({
        //     url: ``,
        //     type: 'POST',
        //     dataType: 'JSON',
        //     data: data,
        //     beforeSend: function() {
        //     },
        //     success: function(res) {
        //         if(res.code == 200){
        //             if(res.data.length>0){
        //                
        //             }
        //         }
        //     },
        //     error: function(err) {
        //     },
        //     complete: function() {
        //     },
    // })
    })
}