$(document).ready(function () {
    yakitCikisTablo(1);
});

function yakitCikisTablo(page, all, tarihStartEnd, tankId, aracId, teslimEden) {
    $('#yakitCikisTablo').html('<div class="derm-loading"></div>');
    all = all || 0;
    $.ajax({
        type: 'POST',
        url: siteUrl + 'actions/depYakitCikis.php?Action=yakitCikisTablo',
        data: {
            'page': page,
            'all': all,
            'tarihStartEnd': tarihStartEnd,
            'tankId': tankId,
            'aracId': aracId,
            'teslimEden': teslimEden
        },
        success: function (response) {
            if (response !== '') {
                $('#yakitCikisTablo').html(response);
                $('#yakitCikisTablo_page').val(page);
            }
            else {
                toastr.error('Veri gönderilirken hata oluştu', 'Hata');
            }
        },
        error: function () {
            toastr.error('Veri gönderilirken hata oluştu', 'Hata');
        }
    });
}

function yakitFis() {
    $('#yakitFisModal').modal('show');
}

function yakitCikisDuzenle(id) {
    yakitCikisSifirla();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: siteUrl + 'actions/depYakitCikis.php?Action=yakitCikisGetir',
        data: {
            'id': id
        },
        success: function (response) {
            if (response.result == 'ok') {
                $('#yakitCikis_id').val(response.id);
                $('#yakitCikis_tank_id').val(response.tank_id);
                $('#yakitCikis_tarih').datepicker('update', response.tarih);
                $('#yakitCikis_arac_id').val(response.arac_id);
                $('#yakitCikis_ilk_km').val(response.ilk_km);
                $('#yakitCikis_son_km').val(response.son_km);
                $('#yakitCikis_litre').val(response.litre);
                $('#yakitCikis_teslim_eden_id').val(response.teslim_eden_id);
                $('#yakitCikis_aciklama').val(response.aciklama);
                $('#yakitCikisModal').modal('show');
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

function yakitCikisSifirla() {
    $('#yakitCikis_id').val('0');
    $('#yakitCikis_tank_id').val(0);
    $('#yakitCikis_tarih').val('');
    $('#yakitCikis_arac_id').val(0);
    $('#yakitCikis_ilk_km').val('');
    $('#yakitCikis_ilk_km_formgroup').removeClass('has-success').removeClass('has-warning').removeClass('has-danger');
    $('#yakitCikis_ilk_km_feedback').html('');
    $('#yakitCikis_son_km').val('');
    $('#yakitCikis_litre').val('');
    $('#yakitCikis_teslim_eden_id').val(0);
    $('#yakitCikis_aciklama').val('');
}

function yakitCikisSil(id) {
    swal.fire({
        title: "Emin misiniz?",
        text: "Bu işlemi daha sonra geri alamazsınız!",
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
                url: siteUrl + 'actions/depYakitCikis.php?Action=yakitCikisSil',
                data: {
                    'id': id
                },
                success: function (response) {
                    if (response.result == 'ok') {
                        toastr.success(response.message, response.title);
                        var page = $('#yakitCikisTablo_page').val();
                        yakitCikisTablo(page);
                        RefreshDepoHighChart(response.selector, response.tank_id);
                    } else {
                        toastr.error(response.message, response.title);
                    }
                },
                error: function () {
                    swal.fire({type: 'error', title: 'Oops...', text: 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'})
                }
            });
        }
    })
}


$('form[name=yakitCikisForm]').submit(function () {
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
                    toastr.warning(response.message, response.title);
                }
                if (response.result == 'ok') {
                    toastr.success(response.message, response.title);
                    $('#yakitCikisModal').modal('hide');
                    var page = $('#yakitCikisTablo_page').val();
                    yakitCikisTablo(page);
                    // fuelWidget.dispose();
                    RefreshDepoHighChart(response.selector, response.tank_id);
                }
                if (response.result == 'duplicate') {
                    toastr.warning(response.message, response.title);
                }
                if (response.result == 'fail') {
                    toastr.error(response.message, response.title);
                }
            }
            else {
                toastr.error('Veri gönderilirken hata oluştu', 'Hata');
            }
        },
        error: function () {
            toastr.error('Veri gönderilirken hata oluştu', 'Hata');
        }
    });
    return false;
});

$(function(){
       $('#yakitCikis_arac_id').change(function(){
        var id = this.value;
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: siteUrl + 'actions/depYakitCikis.php?Action=aracIdSonKmFind',
            data: {
                'id': id
            },
            success: function (response) {
                if (response.result == 'ok') {
                    $('#yakitCikis_ilk_son_km_formgroup').show();
                    $('#yakitCikis_ilk_km').val(response.value);
                    $('#yakitCikis_ilk_km_formgroup').removeClass('has-warning').removeClass('has-danger').addClass('has-success');
                    $('#yakitCikis_ilk_km_feedback').html('<i class="fas fa-fw fa-check"></i> Son KM veritabanından alındı.').fadeOut( 300 ).fadeIn( 400 );
                } else if (response.result == 'empty') {
                    $('#yakitCikis_ilk_son_km_formgroup').show();
                    $('#yakitCikis_ilk_km').val(response.value);
                    $('#yakitCikis_ilk_km_formgroup').removeClass('has-success').removeClass('has-danger').addClass('has-warning');
                    $('#yakitCikis_ilk_km_feedback').html('<i class="fas fa-fw fa-exclamation-triangle"></i> Bu aracın ilk kaydını yapıyorsunuz.');
                } else if (response.result == 'select') {
                    $('#yakitCikis_ilk_son_km_formgroup').show();
                    $('#yakitCikis_ilk_km').val(response.value);
                    $('#yakitCikis_ilk_km_formgroup').removeClass('has-success').removeClass('has-warning').addClass('has-danger');
                    $('#yakitCikis_ilk_km_feedback').html('<i class="fas fa-fw fa-info-circle"></i> Lütfen bir araç seçiniz.');
                } else if (response.result == 'muhtelif') {
                    $('#yakitCikis_ilk_son_km_formgroup').hide();
                    $('#yakitCikis_ilk_km').val(response.value);
                    $('#yakitCikis_son_km').val(response.value);

                }
            },
            error: function () {
                alert('fonksiyon hatasi');
            }
        });
        return false;
    }).change();
});