$(document).ready(function () {
    $('#page').val('last');
    GuvenlikGirisCikisTabloGetir('screen', 1);
});


$('form[name=searchForm]').submit(function () {
    const start_date = $('#start_date').val();
    const end_date = $('#end_date').val();
    GuvenlikGirisCikisTabloGetir('screen', 1, start_date, end_date);
    return false;
});




$('form[name=girisCikisActionForm]').submit(function () {
    const start_date = $('#start_date').val();
    const end_date = $('#end_date').val();

    var form = $(this);
    var action = form.attr('action');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: action,
        data: form.serialize(),
        success: function (response) {
            if (response.result != '') {
                if (response.result == 'empty') {
                    toastr.warning(response.message, 'Uyarı');
                }
                if (response.result == 'ok') {
                    $('#girisCikisActionModal').modal('hide');
                    toastr.success(response.message, 'Başarılı');
                    GuvenlikGirisCikisTabloGetir('screen', 1, start_date, end_date);
                }
                if (response.result == 'fail') {
                    toastr.error(response.message, 'Hata');
                }
            }
            else {
                toastr.error('QVeri gönderilirken hata oluştu', 'Hata');
            }
        },
        error: function () {
            toastr.error('Veri gönderilirken hata oluştu', 'Hata');
        }
    });
    return false;
});



function GuvenlikGirisCikisTabloGetir(type, page, start_date, end_date) {
    ShowLoading(type);
    $.ajax({
        type: 'POST',
        url: siteUrl + 'actions/gvnGirisCikis.php?Action=GuvenlikGirisCikisTabloGetir',
        data: {
            'type': type,
            'page': page,
            'start_date': start_date,
            'end_date': end_date
        },
        dataType: (type == 'xlsx' || type == 'pdf' || type == 'print') ? 'json' : 'html',
        success: function (response) {
            HideLoading();
            if (response !== '') {
                if (type == 'screen') {
                    $('#girisCikisTablo').html(response);

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




function GirisCikisFormModal(type=1, id=0, kind = 1) { // [type 1 ekle - 2 duzenle - 3 arac cikis] [kind 1,2 arac - 3 cop - 4 hammadde]
    GirisCikisFormModalSifirla();
    modalId= '#girisCikisActionModal'
    if (type==1) {
        var title = 'Giriş Çıkış Ekle';
    } else if (type==2) {
        var title = 'Giriş Çıkış Düzenle';
    } else if (type==3) {
        var title = 'Araç Çıkış Kaydet';
    }

    $(modalId + ' .modal-title').html(title);

    if (type==1) { // ekle
        if (kind==1 || kind==2) { // misafir, sirket
            $('#girisfield').show();
            $('#cikisfield').hide();
            $('#infofields').show();
            $('#copfields').hide();
            $('#hammaddefields').hide();
            $('#aciklamagirisfields').show();
            $('#aciklamacikisfields').hide();
            $('#arac_tur').find('option').remove().end().append('<option value="0">Seçiniz</option><option value="1">Misafir Araç</option><option value="2">Şirket Aracı</option>').val(0);
        } else if (kind==3) { // cop
            $('#girisfield').hide();
            $('#cikisfield').show();
            $('#infofields').show();
            $('#copfields').show();
            $('#hammaddefields').hide();
            $('#aciklamagirisfields').show();
            $('#aciklamacikisfields').hide();
            $('#arac_tur').find('option').remove().end().append('<option value="3">Çöp Aracı</option>').val(3);
        } else if (kind==4) { // hammadde
            $('#girisfield').show();
            $('#cikisfield').hide();
            $('#infofields').show();
            $('#copfields').hide();
            $('#hammaddefields').show();
            $('#aciklamagirisfields').show();
            $('#aciklamacikisfields').hide();
            $('#arac_tur').find('option').remove().end().append('<option value="4">Hammade Aracı</option>').val(4);
        }
    } else if (type==2) { // duzenle
        if (kind==1 || kind==2) { // misafir, sirket
            $('#girisfield').show();
            $('#cikisfield').show();
            $('#infofields').show();
            $('#copfields').hide();
            $('#hammaddefields').hide();
            $('#aciklamagirisfields').show();
            $('#aciklamacikisfields').show();
            $('#arac_tur').find('option').remove().end().append('<option value="0">Seçiniz</option><option value="1">Misafir Araç</option><option value="2">Şirket Aracı</option>');
        } else if (kind==3) { // cop
            $('#girisfield').show();
            $('#cikisfield').show();
            $('#infofields').show();
            $('#copfields').show();
            $('#hammaddefields').hide();
            $('#aciklamagirisfields').show();
            $('#aciklamacikisfields').show();
            $('#arac_tur').find('option').remove().end().append('<option value="3">Çöp Aracı</option>');
        } else if (kind==4) { // hammadde
            $('#girisfield').show();
            $('#cikisfield').show();
            $('#infofields').show();
            $('#copfields').hide();
            $('#hammaddefields').show();
            $('#aciklamagirisfields').show();
            $('#aciklamacikisfields').show();
            $('#arac_tur').find('option').remove().end().append('<option value="4">Hammade Aracı</option>');
        }
    } else if (type==3) { //cikis
        if (kind==1 || kind==2) { // misafir, sirket
            $('#girisfield').hide();
            $('#cikisfield').show();
            $('#infofields').hide();
            $('#copfields').hide();
            $('#hammaddefields').hide();
            $('#aciklamagirisfields').hide();
            $('#aciklamacikisfields').show();
            $('#arac_tur').find('option').remove().end().append('<option value="0">Seçiniz</option><option value="1">Misafir Araç</option><option value="2">Şirket Aracı</option>');
        } else if (kind==3) { // cop
            $('#girisfield').show();
            $('#cikisfield').hide();
            $('#infofields').hide();
            $('#copfields').show();
            $('#hammaddefields').hide();
            $('#aciklamagirisfields').hide();
            $('#aciklamacikisfields').show();
            $('#arac_tur').find('option').remove().end().append('<option value="3">Çöp Aracı</option>');
        } else if (kind==4) { // hammadde
            $('#girisfield').hide();
            $('#cikisfield').show();
            $('#infofields').hide();
            $('#copfields').hide();
            $('#hammaddefields').hide();
            $('#aciklamagirisfields').hide();
            $('#aciklamacikisfields').show();
            $('#arac_tur').find('option').remove().end().append('<option value="4">Hammade Aracı</option>');
        }
    }
    $(modalId).modal('show');
}

function GirisCikisFormModalSifirla() {
    $('form[name=girisCikisActionForm]').trigger("reset"); // hidden alanlari resetlemiyor
    $("input[type=hidden]").val(''); // hidden alanlari resetle
}



function GuvenlikGirisCikisKayitGetir(type=1, id=0, kind = 1) {
    GirisCikisFormModalSifirla();
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
                $('#aciklamagiris').val(response.aciklamagiris);
                $('#aciklamacikis').val(response.aciklamacikis);

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

function GuvenlikGirisCikisKayitSil(id) {
    const start_date = $('#start_date').val();
    const end_date = $('#end_date').val();


    swal.fire({
        title: "Emin misiniz?",
        html: 'Bu kaydı <b><span>silmek</span></b> istediginize emin misniz?',
        type: "question",
        buttonsStyling: false,
        confirmButtonText: "<i class='far fa-trash-alt'></i> Evet, Sil!",
        confirmButtonClass: "btn btn-danger",
        showCancelButton: true,
        cancelButtonText: "<i class='fal fa-times-circle'></i> İptal",
        cancelButtonClass: "btn btn-default"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: siteUrl + 'actions/gvnGirisCikis.php?Action=GuvenlikGirisCikisKayitSil',
                data: {
                    'id': id
                },
                success: function (response) {
                    if (response.result == 'ok') {
                        toastr.success(response.message, 'Başarılı');
                        GuvenlikGirisCikisTabloGetir('screen', 1, start_date, end_date);
                    } else {
                        toastr.error(response.message, 'Hata');
                    }
                },
                error: function () {
                    swal.fire({type: 'error', title: 'Oops...', text: 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'})
                }
            });
        }
    })



}




