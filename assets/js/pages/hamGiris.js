$(document).ready(function () {
    $('#page').val('last');
    HamGirisTabloGetir('screen', 1);
});

/// begin clone
function CloneIt(elemId, destinationElem) {
    destinationElem.append($('#' + elemId).html());
    if (destinationElem.find('.remove-first').length>= 1) {
        if (destinationElem.find('.remove-first').length == 1 && destinationElem.find('.clone_content').length == 1) {
            destinationElem.find('.remove-first').html('');
        }
    }
}

function DeleteClone(elem) {
    elem.parent().remove();
}

function ResetClone() {
    $('.clone_content').slice(2).remove(); // ilk iki class haric sil
}

function Clone() {
    CloneIt('clone_packing', $('#packings_list'));
    // var lastClone = $('#packings_list .clone_content').last().find('.packing-item-code');
}

function CloneWiz() {
    var count = $('input[name="wiz_tas_adet"]').val();
    var sefer_no = $('input[name="nakliye_sefer_no"]').val();
    var irsaliye_no = $('input[name="wiz_irsaliye_no"]').val();
    var tas_ocak_id = $('select[name="wiz_tas_ocak_id"]').val();
    var tas_tur_id = $('select[name="wiz_tas_tur_id"]').val();
    var tas_kalite_id = $('select[name="wiz_tas_kalite_id"]').val();


    var arr = {
        count: count,
        sefer_no: sefer_no,
        irsaliye_no: irsaliye_no,
        tas_ocak_id: tas_ocak_id,
        tas_tur_id: tas_tur_id,
        tas_kalite_id: tas_kalite_id
    };

    for (let i = 1; i < count; i++) {
        CloneItWiz('clone_packing', $('#packings_list'), arr);
    }


}

function CloneItWiz(elemId, destinationElem, arr) {
    destinationElem.append($('#' + elemId).html());
    if (destinationElem.find('.remove-first').length>= 1) {
        if (destinationElem.find('.remove-first').length == 1 && destinationElem.find('.clone_content').length == 1) {
            destinationElem.find('.remove-first').html('');
        }
    }

    $('input[name="tas_irsaliye_no[]"]').val(arr['irsaliye_no']);
    $('select[name="tas_ocak_id[]"]').val(arr['tas_ocak_id']);
    $('select[name="tas_tur_id[]"]').val(arr['tas_tur_id']);
    $('select[name="tas_kalite_id[]"]').val(arr['tas_kalite_id']);

    var count = arr['count'];
    FabrikaTasNoGenerator(count, arr['sefer_no']);

    setTimeout(function(){ $(".modal-body").animate({ scrollTop: $('.modal-body').height() }, 300); }, 0);
}

function FabrikaTasNoGenerator(coun, tas_sefer_no){
    var destinput = document.querySelectorAll('input[name="tas_fabrika_no[]');
    for (var i = 0; i < destinput.length; i++) {
        destinput[i].value = tas_sefer_no + '-' + i;
    }
}
// end clone

function LastSeferNoBul(){
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: siteUrl + 'actions/hamGiris.php?Action=LastSeferNoBul',
        success : function (response) {
            if (response != '') {
                $('input[name="nakliye_sefer_no').val(response.nakliye_sefer_no);
                $('#nakliye_sefer_no_feedback').html('<i class="fas fa-fw fa-check"></i> Son Sefer No veritabanından alındı.').fadeOut( 600 ).fadeIn( 700 );
            }
            else {
                toastr.error('Veri cekilirken hata meydana geldi.');
            }
        },
        error   : function () {
            alert('An error occurred while processing data.');
        }
    });
    return false;
}










$('form[name=hamGirisActionForm]').submit(function () {
    var form = $(this);
    $.ajax({
        dataType: "json",
        type    : 'POST',
        url     : form.attr('action'),
        data    : form.serialize(),
        success : function (cevap) {
            if (cevap != '') {
                //alert(cevap.message);
                if (cevap.id > 0) {
                    toastr.success(cevap.message, 'Success');
                    $('#hamGirisActionModal').modal('hide');
                    toastr.options.timeOut = 10000;
                    $('#rs_id').val(cevap.id);
                    HamGirisTabloGetir('screen', 1);
                    //history.pushState(null, null, siteUrl + 'rs-ship-add.php?id=' + cevap.id);
                    LoadRsPackings();
                }
                else {
                    toastr.error(cevap.message, 'Error', { timeOut: 9999 } );
                }
            }
        },
        error   : function () {
            alert('An error occurred while processing data.');
        }
    });
    return false;
});


function LoadRsPackings() {
    var id = $('#rs_id').val();
    if (id > 0) {
        $.ajax({
            type   : 'POST',
            url    : siteUrl + 'actions/rs-ship.php?Action=RSGetPackings',
            data   : {
                'id': id
            },
            success: function (cevap) {
                if (cevap != '') {
                    $('#packings_list .clone_content').each(function () {
                        $(this).remove();
                    });
                    $('#packings_list').append(cevap);
                    $('#packings_list .clone_content').each(function () {
                        var item_code = $(this).find('.packing-item-code');
                        ComponentsTypeahead.init(item_code, skuList);
                    });
                }
                else {
                    Clone();
                }
            },
            error  : function () {
                Clone();
            }
        });
    }
    else {
        Clone();
    }
}



$('body').on('change','select[name="tas_tur_id[]"]', function(){
    if ($(this).val() == 2) {
        $(this).parent().parent().find('input[name="tas_en[]"]').prop( "disabled", true );
        $(this).parent().parent().find('input[name="tas_boy[]"]').prop( "disabled", true );
        $(this).parent().parent().find('input[name="tas_yukseklik[]"]').prop( "disabled", true );
    } else {
        $(this).parent().parent().find('input[name="tas_en[]"]').prop( "disabled", false );
        $(this).parent().parent().find('input[name="tas_boy[]"]').prop( "disabled", false );
        $(this).parent().parent().find('input[name="tas_yukseklik[]"]').prop( "disabled", false );
    }
})

$('body').on('change','select[name="wiz_tas_ocak_id"]', function(){
    var elem      = $(this);
    var dest_elem = $('select[name="wiz_tas_tur_id"]');
    var ocak_id    = $(this).val();

    $('select[name="wiz_tas_kalite_id"]').prop( "disabled", true );
    $(elem).parent().parent().find('select[name="wiz_tas_tur_id"]').find('option').remove();

    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: siteUrl + 'actions/hamGiris.php?Action=TasOcakIdToTur&ocak_id=' + ocak_id,
        success: function (response) {
            if (response !== '') {
                $(dest_elem).append(response);
            }
            else {
                toastr.error('', 'Hata');
            }
        },
        error: function () {
            swal.fire({type: 'error', title: 'Oops...', text: 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'})
        }
    });
})

$('body').on('change','select[name="wiz_tas_tur_id"]', function(){
    var elem      = $(this);
    var dest_elem = $('select[name="wiz_tas_kalite_id"]');
    var ocak_id    = $('select[name="wiz_tas_ocak_id"]').val();
    var tur_id    = $(this).val();

    $('select[name="wiz_tas_kalite_id"]').prop( "disabled", false );
    $(elem).parent().parent().find('select[name="wiz_tas_kalite_id"]').find('option').remove();

    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: siteUrl + 'actions/hamGiris.php?Action=TasTurIdToKalite&tur_id=' + tur_id + '&ocak_id=' + ocak_id,
        success: function (response) {
            if (response !== '') {
                $(dest_elem).append(response);
            }
            else {
                toastr.error('', 'Hata');
            }
        },
        error: function () {
            swal.fire({type: 'error', title: 'Oops...', text: 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'})
        }
    });
})


























function HamGirisTabloGetir(type, page) {
    ShowLoading(type);
    $.ajax({
        type: 'POST',
        url: siteUrl + 'actions/hamGiris.php?Action=HamGirisTabloGetir',
        data: {
            'type': type,
            'page': page
        },
        dataType: (type == 'xlsx' || type == 'pdf' || type == 'print') ? 'json' : 'html',
        success: function (response) {
            HideLoading();
            if (response !== '') {
                if (type == 'screen') {
                    $('#hamGirisTablo').html(response);


                } else if (type=='xlsx') {
                    saveAs(response.file, response.filename);
                }  else if (type=='pdf') {
                    saveAs(response.file, response.filename);
                } else if (type=='print') {
                    var pdfjsBase64File     = response.file;
                    var pdfjsBase64FileName = response.filename;
                    sessionStorage.setItem('pdfjsBase64File',pdfjsBase64File);
                    sessionStorage.setItem('pdfjsBase64FileName',pdfjsBase64FileName);

                    let r = Math.random().toString(36).substring(7);
                    $('body').append('<div class="modal modal-fs fade" id="' + r + '">' +
                        '<div class="modal-dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<h5 class="modal-title">Yazdırma Önizleme</h5>' +
                        '<button type="button" class="close" data-dismiss="modal" tabindex="-1"></button>' +
                        '</div>' +
                        '<div class="modal-body" style="overflow: hidden !important; padding: 0px !important; bottom: 0px !important;">' +
                        '<iframe src="assets/plugins/pdfjs-2.3.2/web/viewer.html" allowfullscreen frameborder="0" style="overflow:hidden !important; height:100% !important; width:100% !important;"></iframe>' +
                        '</div>' +
                        '</div>' +
                        '</div>');
                    $('#' + r).modal();
                    $('#' + r).on('hidden.bs.modal', function () {
                        $('#' + r).remove();
                    })
                }

            }
            else {
                toastr.error('Veri gönderilirken hata oluştu', 'Hata');
                HideLoading();
            }
        },
        error: function () {
            toastr.error('Veri gönderilirken hata oluştu', 'Hata');
            HideLoading();
        }
    });
}




function HammaddeFormModal(type) { // [type 1 ekle - 2 duzenle]
    LoadRsPackings();
    HamGirisFormModalSifirla();
    LastSeferNoBul();
    modalId= '#hamGirisActionModal'
    if (type==1) {
        var title = 'Hammadde Giriş Ekle';
    } else if (type==2) {
        var title = 'Hammadde Çıkış Düzenle';
    }

    $(modalId + ' .modal-title').html(title);

    $(modalId).modal('show');
}

function HamGirisFormModalSifirla() {
    ResetClone();
    $('form[name=hamGirisActionForm]').trigger("reset"); // hidden alanlari resetlemiyor
    // $("input[type=hidden]").val(''); // hidden alanlari resetle
}



function GuvenlikGirisCikisKayitGetir(type=1, id=0, kind = 1) {
    HamGirisFormModalSifirla();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: siteUrl + 'actions/gvnGirisCikis.php?Action=GuvenlikGirisCikisKayitGetir',
        data: {
            'id': id
        },
        success: function (response) {
            if (response.result == 'ok') {
                GirisCikisFormModal(type, id, kind);
                $('#girisCikis_id').val(response.id);
                $('#giris_tarih').val(response.giris_tarih);
                $('#cikis_tarih').val(response.cikis_tarih);
                $('#arac_tur').val(response.arac_tur);
                $('#plaka').val(response.plaka);
                $('#firma').val(response.firma);
                $('#ad_soyad').val(response.ad_soyad);
                $('#aciklama').val(response.aciklama);

                $('#fis_no').val(response.fis_no);
                $('#km').val(response.km);
                $('#cop_saha').val(response.cop_saha);

                $('#ocak').val(response.ocak);
                $('#tarti1').val(response.tarti1);
                $('#tarti2').val(response.tarti2);



                // $('#girisCikisActionModal').modal('show');
            }
            else {
                toastr.error('', 'Hata');
            }
        },
        error: function () {
            swal.fire({type: 'error', title: 'Oops...', text: 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'})
        }
    });
}





