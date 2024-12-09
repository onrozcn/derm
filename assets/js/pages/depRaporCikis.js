$(document).ready(function () {
    $('#page').val('last');
    DepoRaporCikisTabloGetir('screen', 1);
});


$('form[name=searchForm]').submit(function () {
    const start_date = $('#start_date').val();
    const end_date = $('#end_date').val();
    const status = $('#status').val();
    DepoRaporCikisTabloGetir('screen', 1, start_date, end_date, status);
    return false;
});





function DepoRaporCikisTabloGetir(type, page, start_date, end_date, status) {
    ShowLoading(type);
    $.ajax({
        type: 'POST',
        url: siteUrl + 'actions/depRaporCikis.php?Action=DepoRaporCikisTabloGetir',
        data: {
            'type': type,
            'page': page,
            'start_date': start_date,
            'end_date': end_date,
            'status': status
        },
        dataType: (type == 'xlsx' || type == 'pdf' || type == 'print') ? 'json' : 'html',
        success: function (response) {
            HideLoading();
            if (response !== '') {
                if (type == 'screen') {
                    $('#DepoRaporCikisTablo').html(response);

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








