$(document).ready(function () {
    yakitGirisTablo(1);
});

function yakitGirisTablo(page, all) {
    all = all || 0;
    $.ajax({
        type: 'POST',
        url: siteUrl + 'actions/depYakitGiris.php?Action=yakitGirisTablo',
        data: {
            'page': page,
            'all': all
        },
        success: function (response) {
            if (response !== '') {
                $('#yakitGirisTablo').html(response);
                $('#yakitGirisTablo_page').val(page);
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

function yakitGirisDuzenle(id) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: siteUrl + 'actions/depYakitGiris.php?Action=yakitGirisGetir',
        data: {
            'id': id
        },
        success: function (response) {
            if (response.result == 'ok') {
                $('#yakitGiris_id').val(response.id);
                $('#yakitGiris_tank_id').val(response.tank_id);
                $('#yakitGiris_tarih').datepicker('update', response.tarih);
                //$('#yakitGiris_tarih').val(response.tarih);
                $('#yakitGiris_firma').val(response.firma);
                $('#yakitGiris_plaka').val(response.plaka);
                $('#yakitGiris_litre').val(response.litre);
                $('#yakitGiris_litre_reel').val(response.litre_reel);
                $('#yakitGiris_fiyat').val(response.fiyat);
                $('#yakitGiris_iskonto').val(response.iskonto);
                $('#yakitGiris_teslim_alan_id').val(response.teslim_alan_id);
                $('#yakitGirisModal').modal('show');
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

function yakitGirisSifirla() {
    $('#yakitGiris_id').val('0');
    $('#yakitGiris_tarih').val('');
    $('#yakitGiris_firma').val('');
    $('#yakitGiris_plaka').val('');
    $('#yakitGiris_litre').val('');
    $('#yakitGiris_litre_reel').val('');
    $('#yakitGiris_fiyat').val('');
    $('#yakitGiris_iskonto').val('');
    $('#yakitGiris_teslim_alan_id').val('0');
}

function yakitGirisSil(id) {
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
                url: siteUrl + 'actions/depYakitGiris.php?Action=yakitGirisSil',
                data: {
                    'id': id
                },
                success: function (response) {
                    if (response.result == 'ok') {
                        toastr.success(response.message, 'Başarılı');
                        var page = $('#yakitGirisTablo_page').val();
                        yakitGirisTablo(page);
                        RefreshDepoHighChart();
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


$('form[name=yakitGirisForm]').submit(function () {
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
                    toastr.success(response.message, 'Başarılı');
                    $('#yakitGirisModal').modal('hide');
                    var page = $('#yakitGirisTablo_page').val();
                    yakitGirisTablo(page);
                    fuelWidget.dispose();
                    RefreshDepoHighChart();
                }
                if (response.result == 'duplicate') {
                    toastr.warning(response.message, 'Tekrarlanan Veri');
                }
                if (response.result == 'fail') {
                    toastr.error(response.message, 'Hata');
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