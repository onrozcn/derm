$(document).ready(function () {
    $('#page').val('last');
    $('form[name=filtrele]').submit();
    initializeDR();
});

function shortcutTum() {
    $('#page').val('last');
    $('#orderBy').val(1);
    $('#ff_durum').selectpicker('val', [0,1]);
    $('form[name=filtrele]').submit();
}

function shortcutOdenecek() {
    $('#page').val(0);
    $('#orderBy').val(2);
    $('#ff_durum').selectpicker('val', [0]);
    $('form[name=filtrele]').submit();
}

function shortcutOdenmis() {
    $('#page').val(0);
    $('#orderBy').val(3);
    $('#ff_durum').selectpicker('val', [1]);
    $('form[name=filtrele]').submit();
}

function shortcutKayitSirali() {
    $('#page').val(0);
    $('#orderBy').val(4);
    $('#ff_durum').selectpicker('val', [0]);
    $('form[name=filtrele]').submit();
}

function shortcutOdemeOncelik(value) {
    $('#page').val(0);
    $('#orderBy').val(5);
    $('#ff_oncelik').selectpicker('val', value);
    $('form[name=filtrele]').submit();
}


function searchToFullScreen(){
    $('form[name=advancedSearchForm]').appendTo('#searchModalBody');
    $("#searchModal").modal('show');
}

$('#searchModal').on('hidden.bs.modal', function () {
    $('form[name=advancedSearchForm]').appendTo('#advancedSearchUpLevel');
})



$('form[name=quickSearchForm]').submit(function () {
    $('#page').val(0);
    $('#ff_quickSearch').val($('#ff_quickSearch_front').val());
    $('form[name=filtrele]').submit();
    return false;
});

$('form[name=advancedSearchForm]').submit(function () {
    $('#page').val(0);
    $('#ff_borcluId').selectpicker('val', $('#advancedSearch_borclu_id').val());
    $('#ff_kategoriId').selectpicker('val', $('#advancedSearch_kategori_id').val());
    $('#ff_odemeyeri_id').val($('#advancedSearch_alacakli_id').val());
    $('#ff_odemeyeri_typeahead').val($('#advancedSearch_alacakli_typeahead').val());
    $('#ff_durum').selectpicker('val', $('#advancedSearch_durum').val());
    $("#searchModal").modal('hide');
    $('form[name=filtrele]').submit();
    return false;
});


function searchReset() {
    // var page     = $('#odemeTakipTablo_page').val();
    // var showMode = $('#odemeTakipTablo_showMode').val();
    // var search   = $('#odemeTakipTablo_search').val('');
    // advancedSearch
    $('#advancedSearch_borclu_id').val('');
    $('#advancedSearch_vadeDR').val('');
    $('#advancedSearch_kategori_id').val('');
    $('#advancedSearch_alacakli_id').val('');
    $('#advancedSearch_alacakli_typeahead').val('');
    $('#advancedSearch_alacakli_typeahead').removeClass('is-valid').removeClass('is-invalid');
    // filter
    $('#page').val('last');
    $('#orderBy').val(1);
    $('#ff_quickSearch').val();
    $('#ff_kategoriId').selectpicker('selectAll');
    $('#ff_evrakno').val('');
    $('#ff_borcluId').selectpicker('selectAll');
    $('#ff_odemeyeri_id').val('');
    $('#ff_odemeyeri_typeahead').val('');
    $('#ff_odemeyeri_typeahead').removeClass('is-valid').removeClass('is-invalid');
    $('#ff_dovizId').selectpicker('selectAll');
    $('#ff_vadeDR').val('');
    $('#ff_vadeDRInput').val('');
    $('#ff_talep').selectpicker('selectAll');
    $('#ff_oncelik').selectpicker('selectAll');
    $('#ff_yontem').selectpicker('selectAll');
    $('#ff_odendigiDR').val('');
    $('#ff_odendigiDRInput').val('');
    $('#ff_durum').selectpicker('selectAll');

    $('form[name=filtrele]').submit();

}

function searchResetFirma() {
    // var page     = $('#odemeTakipTablo_page').val();
    // var showMode = $('#odemeTakipTablo_showMode').val();
    // var search   = $('#odemeTakipTablo_search').val('');
    // advancedSearch
    $('#advancedSearch_alacakli_id').val('');
    $('#advancedSearch_alacakli_typeahead').val('');
    $('#advancedSearch_alacakli_typeahead').removeClass('is-valid').removeClass('is-invalid');
    // filter
    $('#ff_odemeyeri_id').val('');
    $('#ff_odemeyeri_typeahead').val('');
    $('#ff_odemeyeri_typeahead').removeClass('is-valid').removeClass('is-invalid');
    $('form[name=filtrele]').submit();

}


$(document).ready(function(){
    odmOdemeTakipAliciListTypeaheadGoster('#advancedSearch_alacakli_id','#advancedSearch_alacakli_typeahead', '#advancedSearch_alacakli_validation','#advancedSearch_alacakli_search');
    odmOdemeTakipAliciListTypeaheadGoster('#ff_odemeyeri_id','#ff_odemeyeri_typeahead', '#ff_odemeyeri_validation','#ff_odemeyeri_search');
});







function odmOdemeTakipAliciListTypeaheadGizle() {
    $("#odeme_odemeyeri_typeahead").typeahead("destroy");
}


function odmOdemeTakipAliciListTypeaheadGoster(fakeInputId,typeaheadId,validationId,searchId) {
    var fakeInputIdQ = fakeInputId;
    var typeaheadIdQ = typeaheadId;
    var validationIdQ = validationId;
    var searchIdQ = searchId;

    var urlRoot = siteUrl + 'actions/typeaheadDatas.php?Action=odmOdemeTakipAliciList';
    var todos = {
        url: urlRoot + '',
        cache: false,
        display: false,
        prepare: function (query, settings) {
            settings.url += '&search=' + query;
            return settings;
        },
        filter: function (data) {
            return $.map(data, function (obj) {
                //console.log(obj)
                return {
                    id: obj.id,
                    unvan: obj.unvan
                };
            });
        }
    };

    var taSource = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('unvan'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        identify: function (obj) {
            return obj.unvan;
        },
        remote: todos
    });

    taSource.initialize(true);

    $(typeaheadIdQ).typeahead({
        hint: false,
        highlight: true,
        minLength: 1
    }, {
        limit: 20,
        name: 'myMatches',
        source: taSource,
        templates: {
            empty: [
                '<div class="empty-typeahead kt-font-danger kt-font-boldest"><i class="fal fa-not-equal"></i>',
                'Bulunamadı :(',
                '</div>'
            ].join('\n'),
            suggestion: Handlebars.compile('<div style="width: 600px">{{unvan}}–<span class="kt-font-danger kt-font-boldest">{{id}}</span></div>')
        },
        display: 'unvan',
        autoselect: false
    });

    // typeahead dropdown secilmezse
    $(typeaheadIdQ).on('typeahead:asynccancel', function (e, datum) {
        //console.log(datum);
        $(fakeInputIdQ).val(0);
        $(typeaheadIdQ).addClass('is-invalid').removeClass('is-valid');
        $(validationIdQ).html('<div class="invalid-feedback">Yeni Şirket Oluşturulacak</div>');
    });
    // typeahead dropdown secilirse
    $(typeaheadIdQ).on('typeahead:select', function (e, datum) {
        $(fakeInputIdQ).val(datum.id);
        $(typeaheadIdQ).addClass('is-valid').removeClass('is-invalid');
        $(validationIdQ).html('<div class="valid-feedback">Şirket Başarıyla Seçildi</div>');
    });
    // bilinmeyen state kontrol et
    $(typeaheadIdQ).on('typeahead:selected', function (e, datum) {
        $(fakeInputIdQ).val(datum.id);
        $(typeaheadIdQ).addClass('is-valid').removeClass('is-invalid');
        $(validationIdQ).html('<div class="valid-feedback">Şirket Başarıyla Seçildi</div>');
    });
    // typeahead tab ile secilirse
    $(typeaheadIdQ).on('typeahead:autocomplete', function (e, datum) {
        $(fakeInputIdQ).val(datum.id);
        $(typeaheadIdQ).addClass('is-valid').removeClass('is-invalid');
        $(validationIdQ).html('<div class="valid-feedback">Şirket Başarıyla Seçildi</div>');
    });

    // typeahead spinner
    $(typeaheadIdQ).on('typeahead:asyncrequest', function (e, datum) {
        $(searchIdQ).html('<i class="fas fa-spinner-third fa-spin"></i>');
    });
    $(typeaheadIdQ).on('typeahead:asyncreceive', function (e, datum) {
        $(searchIdQ).html('');
    });
}






$('.selectpicker').selectpicker({ selectAllText: 'Hepsi', deselectAllText: 'Hiçbiri', noneSelectedText: 'Hiçbiri', countSelectedText: '{0} seçili' });




function filtreleGetir() {
    $("#filtrele").modal("show");

    $('#filtrele').on('shown.bs.modal', function() {
        $('#odeme_kategori_id').focus();
    })
    // initializeDR();
}




$('form[name=filtrele]').submit(function () {
    const page = $('#page').val();
    const orderBy = $('#orderBy').val();
    const ff_quickSearch = $('#ff_quickSearch').val();
    const ff_kategoriId = $('#ff_kategoriId').val();
    const ff_evrakno = $('#ff_evrakno').val();
    const ff_borcluId = $('#ff_borcluId').val();
    const ff_odemeyeri = $('#ff_odemeyeri_id').val();
    const ff_cinsi = $('#ff_cinsi').val();
    const ff_dovizId = $('#ff_dovizId').val();
    const ff_vadeDR = $('#ff_vadeDRInput').val();
    const ff_talep = $('#ff_talep').val();
    const ff_oncelik = $('#ff_oncelik').val();
    const ff_yontem = $('#ff_yontem').val();
    const ff_odendigiDR = $('#ff_odendigiDRInput').val();
    const ff_durum = $('#ff_durum').val();
    odemeTakipTablo('screen', page, orderBy, ff_quickSearch, ff_kategoriId, ff_evrakno, ff_borcluId, ff_odemeyeri, ff_cinsi, ff_dovizId, ff_vadeDR, ff_talep, ff_oncelik, ff_yontem, ff_odendigiDR, ff_durum);
    return false;
});








function initializeDR() {
    $('#ff_vadeDR').daterangepicker({
        startDate: false,
        endDate: false,
        buttonClasses  : 'm-btn btn',
        applyClass     : 'btn-primary',
        cancelClass    : 'btn-secondary',
        autoUpdateInput: false,
        locale         : {
            format          : 'DD/MM/YYYY',
            separator       : ' - ',
            applyLabel      : 'Uygula',
            cancelLabel     : 'Temizle',
            fromLabel       : 'From',
            toLabel         : 'To',
            customRangeLabel: 'Özel',
            weekLabel       : 'H',
            daysOfWeek      : ['Pa', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct'],
            monthNames      : ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
            firstDay        : 1
        },
        ranges         : {
            'Bugün'     : [moment(), moment()],
            'Dün'       : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Son 7 Gün' : [moment().subtract(6, 'days'), moment()],
            'Son 30 Gün': [moment().subtract(29, 'days'), moment()],
            'Önceki Ay'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Bu Ay'    : [moment().startOf('month'), moment().endOf('month')],
            [add1MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add2MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add3MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add4MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add5MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add6MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            'Bu Yıl'    : [moment().startOf('year'), moment().endOf('year')],
            '1 Sonraki Yıl': [moment().add(1, 'year').startOf('year'), moment().add(1, 'year').endOf('year')],
            '2 Sonraki Yıl': [moment().add(2, 'year').startOf('year'), moment().add(2, 'year').endOf('year')],
            '3 Sonraki Yıl': [moment().add(3, 'year').startOf('year'), moment().add(3, 'year').endOf('year')],
            '4 Sonraki Yıl': [moment().add(4, 'year').startOf('year'), moment().add(4, 'year').endOf('year')]
        }
    }, function (start, end) {
        $('#ff_vadeDRInput').val(start.format('YYYY-MM-DD') + '/' + end.format('YYYY-MM-DD'));
    });
    $('#ff_vadeDR').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
    $('#ff_vadeDR').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        $('#ff_vadeDRInput').val('');
    });
    /* -------------------------------- */
    $('#ff_odendigiDR').daterangepicker({
        startDate: false,
        endDate: false,
        buttonClasses  : 'm-btn btn',
        applyClass     : 'btn-primary',
        cancelClass    : 'btn-secondary',
        autoUpdateInput: false,
        drops          : 'up',
        locale         : {
            format          : 'DD/MM/YYYY',
            separator       : ' - ',
            applyLabel      : 'Uygula',
            cancelLabel     : 'Temizle',
            fromLabel       : 'From',
            toLabel         : 'To',
            customRangeLabel: 'Özel',
            weekLabel       : 'H',
            daysOfWeek      : ['Pa', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct'],
            monthNames      : ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
            firstDay        : 1
        },
        ranges         : {
            'Bugün'     : [moment(), moment()],
            'Dün'       : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Son 7 Gün' : [moment().subtract(6, 'days'), moment()],
            'Son 30 Gün': [moment().subtract(29, 'days'), moment()],
            'Önceki Ay'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Bu Ay'    : [moment().startOf('month'), moment().endOf('month')],
            [add1MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add2MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add3MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add4MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add5MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add6MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            'Bu Yıl'    : [moment().startOf('year'), moment().endOf('year')],
            '1 Sonraki Yıl': [moment().add(1, 'year').startOf('year'), moment().add(1, 'year').endOf('year')],
            '2 Sonraki Yıl': [moment().add(2, 'year').startOf('year'), moment().add(2, 'year').endOf('year')],
            '3 Sonraki Yıl': [moment().add(3, 'year').startOf('year'), moment().add(3, 'year').endOf('year')],
            '4 Sonraki Yıl': [moment().add(4, 'year').startOf('year'), moment().add(4, 'year').endOf('year')]
        }
    }, function (start, end) {
        $('#ff_odendigiDRInput').val(start.format('YYYY-MM-DD') + '/' + end.format('YYYY-MM-DD'));
    });
    $('#ff_odendigiDR').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
    $('#ff_odendigiDR').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        $('#ff_odendigiDRInput').val('');
    });
    /* -------------------------------- */
    $('#advancedSearch_vadeDR').daterangepicker({
        startDate: false,
        endDate: false,
        buttonClasses  : 'm-btn btn',
        applyClass     : 'btn-primary',
        cancelClass    : 'btn-secondary',
        autoUpdateInput: false,
        locale         : {
            format          : 'DD/MM/YYYY',
            separator       : ' - ',
            applyLabel      : 'Uygula',
            cancelLabel     : 'Temizle',
            fromLabel       : 'From',
            toLabel         : 'To',
            customRangeLabel: 'Özel',
            weekLabel       : 'H',
            daysOfWeek      : ['Pa', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct'],
            monthNames      : ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
            firstDay        : 1
        },
        ranges         : {
            'Bugün'     : [moment(), moment()],
            'Dün'       : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Son 7 Gün' : [moment().subtract(6, 'days'), moment()],
            'Son 30 Gün': [moment().subtract(29, 'days'), moment()],
            'Önceki Ay'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Bu Ay'    : [moment().startOf('month'), moment().endOf('month')],
            [add1MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add2MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add3MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add4MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add5MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            [add6MonthName] : [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            'Bu Yıl'    : [moment().startOf('year'), moment().endOf('year')],
            '1 Sonraki Yıl': [moment().add(1, 'year').startOf('year'), moment().add(1, 'year').endOf('year')],
            '2 Sonraki Yıl': [moment().add(2, 'year').startOf('year'), moment().add(2, 'year').endOf('year')],
            '3 Sonraki Yıl': [moment().add(3, 'year').startOf('year'), moment().add(3, 'year').endOf('year')],
            '4 Sonraki Yıl': [moment().add(4, 'year').startOf('year'), moment().add(4, 'year').endOf('year')]
        }
    }, function (start, end) {
        $('#ff_vadeDRInput').val(start.format('YYYY-MM-DD') + '/' + end.format('YYYY-MM-DD'));
    });
    $('#advancedSearch_vadeDR').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        $('#ff_vadeDR').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
    $('#advancedSearch_vadeDR').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        $('#ff_vadeDRInput').val('');
    });
};



function odemeTakipTablo(type, page, orderBy, ff_quickSearch, ff_kategoriId, ff_evrakno, ff_borcluId, ff_odemeyeri, ff_cinsi, ff_dovizId, ff_vadeDR, ff_talep, ff_oncelik, ff_yontem, ff_odendigiDR, ff_durum) {


    ShowLoading(type);
    $.ajax({
        type: 'POST',
        url: siteUrl + 'actions/odmOdemeTakip.php?Action=odemeTakipTablo',
        data: {
            'type': type,
            'page': page,
            'orderBy': orderBy,
            'ff_quickSearch' : ff_quickSearch,
            'ff_kategoriId' : ff_kategoriId,
            'ff_evrakno' : ff_evrakno,
            'ff_borcluId' : ff_borcluId,
            'ff_odemeyeri' : ff_odemeyeri,
            'ff_cinsi' : ff_cinsi,
            'ff_dovizId' : ff_dovizId,
            'ff_vadeDR' : ff_vadeDR,
            'ff_talep' : ff_talep,
            'ff_oncelik' : ff_oncelik,
            'ff_yontem' : ff_yontem,
            'ff_odendigiDR' : ff_odendigiDR,
            'ff_durum' : ff_durum
        },
        dataType: (type == 'xlsx' || type == 'pdf' || type == 'print') ? 'json' : 'html',
        success: function (response) {
            HideLoading();
            if (response !== '') {
                if (type == 'screen') {
                    $('#odemeTakipTablo').hide().html(response).fadeToggle(1000);
                    $('#odemeTakipTablo_page').val(page);
                    $('#odemeTakipTablo_showMode').val(orderBy);


                    $('.rate_talep').raty({
                        starType: 'i',
                        starOff : 'fal fa-fw fa-phone-rotary',
                        starOn  : 'fas fa-fw fa-phone-rotary',
                        number: 1,
                        cancel: true,
                        cancelHint: 'Sıfırla',
                        noRatedMsg: '',
                        hints: ['1'],
                        score: function() {
                            return $(this).attr('data-score');
                        },
                        readOnly: function() {
                            return $(this).attr('data-readonly');
                        },
                        click: function(score) {
                            odemeTalep(this.id, score);
                        }
                    });

                    $('.rate_oncelik').raty({
                        starType: 'i',
                        starOff : 'fal fa-fw fa-star',
                        starOn  : 'fas fa-fw fa-star',
                        number: 4,
                        cancel: true,
                        cancelHint: 'Sıfırla',
                        noRatedMsg: '',
                        hints: ['1', '2', '3', '4'],
                        score: function() {
                            return $(this).attr('data-score');
                        },
                        readOnly: function() {
                            return $(this).attr('data-readonly');
                        },
                        click: function(score) {
                            odemeOncelik(this.id, score);
                            setTimeout(function(){ odemePlan() }, 200) ;
                        }
                    });

                    $('.rate_durum').raty({
                        starType: 'i',
                        starOff : 'fal fa-fw fa-money-bill',
                        starOn  : 'fas fa-fw fa-money-bill',
                        number: 1,
                        cancel: true,
                        cancelHint: 'Ödenmedi olarak işaretle',
                        noRatedMsg: '',
                        hints: ['Ödendi olarak işaretle'],
                        score: function() {
                            return $(this).attr('data-score');
                        },
                        readOnly: function() {
                            return $(this).attr('data-readonly');
                        },
                        click: function(score) {
                            odemeDurum(this.id, score);
                        }
                    });

                    let $table = $('#odemeTakipTable');
                    $table.floatThead({
                        responsiveContainer: function($table){
                            return $table.closest('.table-responsive');
                        },
                        zIndex: 5,
                        position: 'absolute',
                        top: 60
                    });

                } else if (type=='xlsx') {
                    saveAs(response.file, response.filename);
                } else if (type=='pdf') {
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




function oncekiAnlikKurGetir() {
    var getAnlikKurDegerUSD = $('#anlikKurValueUSD').text();
    var getAnlikKurDegerEUR = $('#anlikKurValueEUR').text();
    $('#anlikKurManualDegerUSD').val(getAnlikKurDegerUSD);
    $('#anlikKurManualDegerEUR').val(getAnlikKurDegerEUR);
}

function anlikKurGuncelleOtoYKB() {
    $("#spinIconId").addClass("fa-spin");
    var divHeight =$("#odemeTakipTablo").height();
    $('#odemeTakipTablo').html('<div class="derm-loading" style="height:' +  divHeight + 'px"></div>');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: siteUrl + 'actions/odmOdemeTakip.php?Action=anlikKurGuncelleOtoYKB',
        success: function (response) {
            if (response.result == 'ok') {
                toastr.success(response.message, 'Başarılı');
                $('#anlikKurValueUSD').addClass('kt-animate-fade-in-up');
                $('#anlikKurValueUSD').html(response.anlikKurValueUSD);
                $('#anlikKurValueEUR').addClass('kt-animate-fade-in-up');
                $('#anlikKurValueEUR').html(response.anlikKurValueEUR);
                $('form[name=filtrele]').submit();
                $("#spinIconId").removeClass("fa-spin");
            } else {
                toastr.error(response.message, 'Hata');
            }
        },
        error: function () {
            swal.fire({type: 'error', title: 'Oops...', text: 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'})
            $("#spinIconId").removeClass("fa-spin");
        }
    });

    // setTimeout(function(){
    //     $("#spinIconId").removeClass("fa-spin");
    // }, 1000);
}



$('form[name=anlikKurGuncelleManuelForm]').submit(function () {
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
                    $('#anlikKurGuncelleManuelModal').modal('hide');
                    $('#anlikKurValueUSD').addClass('kt-animate-fade-in-up');
                    $('#anlikKurValueEUR').addClass('kt-animate-fade-in-up');
                    $('#anlikKurValueUSD').html(response.anlikKurValueUSD);
                    $('#anlikKurValueEUR').html(response.anlikKurValueEUR);
                    $('form[name=filtrele]').submit();
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


$('form[name=odemeForm]').submit(function () {
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
                    $('#odemeKaydetModal').modal('hide');
                    $('form[name=filtrele]').submit();
                    // scrollDownToBottom();

                    /* FIS Goster */
                    var odemeyeriid = $('#odeme_odemeyeri_id').val();
                    var borcluid    = $('#odeme_borclu_sirket_id').val();
                    $('#mdl-gnl-fis').modal('show');
                    firmaLastTransaction(odemeyeriid, borcluid, "mdl-gnl-fis-body", response.id);



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

function odemeDuzenle(id= 0, mode = 0) {
    // mode = 0 duzenle
    // mode = 1 kopyala

    odemeFormSifirla();
    if (mode == 1) {
        $('#odeme_title').html('Kaydı Kopyala');
    }
    else {
        $('#odeme_title').html('Kaydı Düzenle: ' + id);
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: siteUrl + 'actions/odmOdemeTakip.php?Action=odemeDuzenle',
        data: {
            'id': id
        },
        success: function (response) {
            if (response.result == 'ok') {
                if (response.durum == 1) {
                    toastr.warning('Ödenmiş kaydı düzenleyemezsiniz', 'Uyarı');
                } else {
                    if (mode != 1) {
                        $('#odeme_id').val(response.id);
                    }
                    $('#odeme_kategori_id').val(response.kategori_id);
                    $('#odeme_evrak_no').val(response.evrak_no);
                    $('#odeme_borclu_sirket_id').val(response.borclusirket_id);
                    $('#odeme_odemeyeri_typeahead').typeahead('val', response.odemeyeri_typeahead);
                    $('#odeme_odemeyeri_id').val(response.odemeyeri_id);
                    $('#odeme_cinsi').val(response.cinsi);
                    $('#odeme_tutar_formul').val(response.tutar_formul);
                    $('#odeme_parabirimi_id').val(response.parabirimi_id);
                    $('#odeme_kur').val(response.kur);
                    $('#odeme_vade_tarihi').datepicker('update', response.vade_tarih);
                    $('#odeme_odendigi_tarih').datepicker('update', response.odendigi_tarih);
                    $('#odeme_yontemi_id').val(response.odeme_yontemi_id);
                    $('#odeme_duzenli_odeme').val(response.duzenli_odeme);
                    if (response.oncelik >= 1) {
                        $('#planAlert').removeClass('kt-hidden');
                    }
                    $('#odemeKaydetModal').modal('show');
                    $('#odeme_kategori_id').focus();
                }
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

$('form[name=odemeOnayForm]').submit(function () {
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
                    $('#odemeOnayModal').modal('hide');
                    $('form[name=filtrele]').submit();
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

function odemeOnayGetir(id) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: siteUrl + 'actions/odmOdemeTakip.php?Action=odemeOnayGetir',
        data: {
            'id': id
        },
        success: function (response) {
            if (response.result == 'ok') {
                $('#odeme_onay_id').val(response.odeme_onay_id);
                $('#odeme_durum').val(response.durum);
                $('#borclualan').html(response.borclutag);
                $('#alacaklialan').html(response.alacaklifirma);
                $('#tutaralan').html(response.tutar);
                $('#parabirimialan').html(response.parabirimi);
                $('#odeme_onay_kur').val(response.kur);
                $('#odeme_onay_odendigi_tarih').datepicker('update', response.odendigi_tarih);
                $('#odeme_onay_yontemi_id').val(response.odeme_yontemi_id);
                $('#odeme_onay_banka').val(response.odeme_onay_banka);
                $('#odeme_onay_iban').val(response.odeme_onay_iban);
                $('#odemeOnayModal').modal('show');
                $('#odemeOnayModal').on('shown.bs.modal', function() {
                    $('#odeme_onay_kur').focus().select();
                })
                if(response.durum == 1) {
                    $('#odemeOnayIptalLoaction').html('<span class="kt-badge kt-badge--inline kt-badge--danger" onclick="odemeOnayIptal(' + response.odeme_onay_id + ')" style="width: 65px;">İptal Et</span>')
                }
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

function odemeOnayIptal(id) {
    swal.fire({
        title: "Emin misiniz?",
        text: 'Ödemeyi iptal etmek istiyormusunuz?',
        type: "question",
        buttonsStyling: false,
        confirmButtonText: "<i class='far fa-trash-alt'></i> Evet",
        confirmButtonClass: "btn btn-danger",
        showCancelButton: true,
        cancelButtonText: "<i class='fal fa-times-circle'></i> İptal",
        cancelButtonClass: "btn btn-default"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: siteUrl + 'actions/odmOdemeTakip.php?Action=odemeOnayIptal',
                data: {
                    'id': id
                },
                success: function (response) {
                    if (response.result != '') {
                        if (response.result == 'empty') {
                            toastr.warning(response.message, 'Uyarı');
                        }
                        if (response.result == 'ok') {
                            toastr.success(response.message, 'Başarılı');
                            $('#odemeOnayModal').modal('hide');
                            $('form[name=filtrele]').submit();
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
                    swal.fire({type: 'error', title: 'Oops...', text: 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'})
                }
            });
        }
    })
}




function odemeFormEkle() {
    odemeFormSifirla();
    $("#odemeKaydetModal").modal("show");
    $('#odemeKaydetModal').on('shown.bs.modal', function() {
        $('#odeme_kategori_id').focus();
    });
}


function odemeFormSifirla() {
    $('#odeme_id').val('');
    $('form[name=odemeForm]').trigger("reset");
    $('#odeme_title').html('Yeni Kayıt Ekle');
    $('#odeme_odemeyeri_typeahead_form_text').html('');
    $('#planAlert').addClass('kt-hidden');
    $('#firmaLastTransactionTableModal').html('');
    $('#odeme_odemeyeri_typeahead').val('');
    $('#odeme_odemeyeri_typeahead').removeClass('is-valid').removeClass('is-invalid');
    odmOdemeTakipAliciListTypeaheadGizle();
    odmOdemeTakipAliciListTypeaheadGoster('#odeme_odemeyeri_id', '#odeme_odemeyeri_typeahead', '#odeme_odemeyeri_typeahead_validation', '#odeme_odemeyeri_typeahead_search');
}


function odemeSil(id, borclu, borclurenk, alacakli, tutar, parabirimi) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: siteUrl + 'actions/odmOdemeTakip.php?Action=odemeSilGetData',
        data: {
            'id': id
        },
        success: function (response) {
            if (response.result == 'ok') {
                if (response.durum == 1) {
                    toastr.warning('Ödenmiş kaydı silemezsiniz', 'Uyarı');
                } else {
                    swal.fire({
                        title: "Emin misiniz?",
                        backdrop: response.borclurenk,
                        html: '<b><span>' + response.borclu + '</span></b> şirketinin <br/><br/>' + '<b>' + response.alacakli + '</b><br/><br/> şirketine <b><br/><br/>' + response.tutar + ' ' + response.parabirimi + '</b></br><br/> olan borcunu silmek uzeresiniz.',
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
                                url: siteUrl + 'actions/odmOdemeTakip.php?Action=odemeSil',
                                data: {
                                    'id': id
                                },
                                success: function (response) {
                                    if (response.result == 'ok') {
                                        toastr.success(response.message, 'Başarılı');
                                        $('form[name=filtrele]').submit();
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
            } else {
                toastr.error(response.message, 'Hata');
            }
        },
        error: function () {
            swal.fire({type: 'error', title: 'Oops...', text: 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'})
        }
    });
}

function odemeOncelik(id, value) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: siteUrl + 'actions/odmOdemeTakip.php?Action=odemeOncelik',
        data: {
            'id': id,
            'value': value
        },
        success: function (response) {
            if (response.result == 'ok') {
                toastr.success(response.message, 'Başarılı');
            } else {
                toastr.error(response.message, 'Hata');
            }
        },
        error: function () {
            swal.fire({type: 'error', title: 'Oops...', text: 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'})
        }
    });
}

function odemeTalep(id, value) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: siteUrl + 'actions/odmOdemeTakip.php?Action=odemeTalep',
        data: {
            'id': id,
            'value': value
        },
        success: function (response) {
            if (response.result == 'ok') {
                toastr.success(response.message, 'Başarılı');
            } else {
                toastr.error(response.message, 'Hata');
            }
        },
        error: function () {
            swal.fire({type: 'error', title: 'Oops...', text: 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'})
        }
    });
}

function odemePlan() {
    $.ajax({
        type: 'POST',
        url: siteUrl + 'actions/odmOdemeTakip.php?Action=odemePlan',
        success: function (response) {
            if (response !== '') {
                $("#odemePlanModal").modal("show");
                $("#odemePlanModalBody").html(response);
                $("#odemePlanModal").draggable({
                    handle: ".modal-header"
                });
            } else {
                toastr.error('Veri gönderilirken hata oluştu', 'Hata');
            }
        }
    });
    return false;
}

function odemeDurum(id, value) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: siteUrl + 'actions/odmOdemeTakip.php?Action=odemeDurum',
        data: {
            'id': id,
            'value': value
        },
        success: function (response) {
            if (response.result == 'ok') {
                toastr.success(response.message, 'Başarılı');
            } else {
                toastr.error(response.message, 'Hata');
            }
        },
        error: function () {
            swal.fire({type: 'error', title: 'Oops...', text: 'Bir hata oluştu, lütfen daha sonra tekrar deneyin.'})
        }
    });
}

function firmaLastTransaction(odemeyeriid, borcluid, targetcontainerId, id=0) {
    var odemeyeriid = $('#odeme_odemeyeri_id').val();
    var borcluid    = $('#odeme_borclu_sirket_id').val();
    $.ajax({
        type: 'POST',
        url: siteUrl + 'actions/odmOdemeTakip.php?Action=firmaLastTransaction',
        data: {
            'odemeyeriid': odemeyeriid,
            'borcluid': borcluid,
            'id': id
        },
        success: function (response) {
            if (response !== '') {
                $('#' + targetcontainerId).hide().html(response).fadeToggle(1000);
            } else {
                toastr.error('Veri gönderilirken hata oluştu', 'Hata');
            }
        }
    });
    return false;
}


$('#odeme_odemeyeri_typeahead').on('typeahead:change', function (e, datum) {
    var odemeyeriid = $('#odeme_odemeyeri_id').val();
    var borcluid    = $('#odeme_borclu_sirket_id').val();
    firmaLastTransaction(odemeyeriid, borcluid, "firmaLastTransactionTableModal");
}).change();

$('#odeme_borclu_sirket_id').on('change', function() {
    var odemeyeriid = $('#odeme_odemeyeri_id').val();
    var borcluid    = $('#odeme_borclu_sirket_id').val();
    firmaLastTransaction(odemeyeriid, borcluid, "firmaLastTransactionTableModal");
});

//KONTROL EDILCEK
$('#odeme_cinsi').on('focus', function() {
    var id = $('#odeme_odemeyeri_id').val();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: siteUrl + 'actions/odmOdemeTakip.php?Action=firmaDefaults',
        data: {
            'id': id
        },
        success: function (response) {
            // newcompany tespit
            if (response.result == 'newcompany') {
                $('#odeme_cinsi').val('');
            } else {
                // son cins tespit
                if (response.soncins_result == 'ok') {
                    $('#odeme_cinsi').val(response.soncins_value);
                    $('#odeme_cinsi').select();
                } else if (response.soncins_result == 'empty') {
                    $('#odeme_cinsi').val(response.soncins_value);
                    $('#odeme_cinsi').select();
                }
                // duzenli odeme tespit
                if (response.duzenliodeme_result == 'ok') {
                    $('#odeme_duzenli_odeme').val(response.duzenliodeme_value);
                } else if (response.soncins_result == 'newcompany') {
                    $('#odeme_duzenli_odeme').val(response.duzenliodeme_value);
                } else if (response.soncins_result == 'empty') {
                    $('#odeme_duzenli_odeme').val(response.duzenliodeme_value);
                }
            }
        },
        error: function () {
            alert('fonksiyon hatasi');
        }
    });
    return false;
}).change();







function odemeTakipWidget(sirketId) {
    $('#odemeTakipWidget').html('<div class="derm-loading"></div>');
    $.ajax({
        type: 'POST',
        url: siteUrl + 'actions/odmOdemeTakip.php?Action=odemeTakipWidget',
        data: {
            'sirketId': sirketId
        },
        success: function (response) {
            if (response !== '') {
                //$('#odemeTakipWidget').hide().html(response).fadeToggle(100);
                $('#odemeTakipWidget').fadeOut(2).html(response).fadeToggle(1);
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

function scrollDownToBottom() {
    setTimeout(function(){ $("html").animate({ scrollTop: $(document).height() }, 1000); }, 1500);
}

function scrollUpToTop() {
    setTimeout(function(){ $("html").animate({ scrollTop: 0 }, 1000); }, 1000);
}



