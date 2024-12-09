<?php require_once('includes/modals/mdl-gnl-ipucu.php'); ?>

<a id="pageButtonUp"></a>
<a id="pageButtonDown"></a>
<script type="text/javascript">
    var scrBtnUp   = $('#pageButtonUp');
    var scrBtnDown = $('#pageButtonDown');

    $(window).scroll(function() {
        if ($(window).scrollTop() > 300) {
            scrBtnUp.addClass('show');
        } else {
            scrBtnUp.removeClass('show');
        }
    });

    $(window).scroll(function() {
        if ($(window).scrollTop() > $(document).height() - $(window).height() - 10) {
            scrBtnDown.removeClass('show');
        } else {
            scrBtnDown.addClass('show');
        }
    });

    $('#pageButtonUp').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:0}, '300');
    });

    $('#pageButtonDown').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:$(document).height()}, '300');
    });
</script>


<script type="text/javascript">
    function ShowLoading(type) {
        if (type=='screen') {
            $('body').append('<div id="loading-base" style="background-color:white"><div id="loading-box"><i class="fad fa-spinner fa-spin"></i><div class="text">Yükleniyor</div></div></div>');
        } else if (type=='xlsx') {
            $('body').append('<div id="loading-base" style="background-color:green"><div id="loading-box"><i class="far fa-file-excel"></i><div class="text">Excel\'e Aktarılıyor</div></div></div>');
        } else if (type=='pdf') {
            $('body').append('<div id="loading-base" style="background-color:red"><div id="loading-box"><i class="far fa-file-pdf"></i><div class="text">PDF\'e Aktarılıyor</div></div></div>');
        } else if (type=='print') {
            $('body').append('<div id="loading-base" style="background-color:red"><div id="loading-box"><i class="far fa-print"></i><div class="text">Yazdırma Önizleme Hazırlanıyor</div></div></div>');
        }

        $('body').addClass('loading-start-blur');
    }
    function HideLoading() {
        $('#loading-base').remove();
        $('body').removeClass('loading-start-blur');
    }
</script>


<!--<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0" type="text/javascript"></script>-->
<script src="assets/plugins/FileSaver.js-2.0.4/dist/FileSaver.min.js" type="text/javascript"></script>
<script src="assets/plugins/global/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/plugins/global/jquery.hotkeys.js" type="text/javascript"></script>
<script src="assets/plugins/global/jquery.raty-fa.js" type="text/javascript"></script>
<script src="assets/plugins/global/jquery.floatThead.min.js" type="text/javascript"></script>

<script src="assets/js/scripts.inputmask.js?v=<?=$siteJsVersion?>" type="text/javascript"></script>


<? if ($localorweb == 1) { ?>
<script src="service_worker_check.js?v=<?=$siteJsVersion?>"></script>
<script src="service_worker_main.js?v=<?=$siteJsVersion?>"></script>
<? } ?>
<!--<script type="text/javascript" src="assets/js/stay_standalone.js"></script>-->


<!--*---------------------------------------------------------------------------*-->
<!--* firma select -->
<!--*---------------------------------------------------------------------------*-->
<script type="text/javascript">
    function SelectFirm(firmId, requesturl) {
        $.ajax({
            dataType: "json",
            type    : 'POST',
            url     : '<?=$siteUrl?>actions/switch-firm.php',
            data    : {
                firmId
            },
            success : function (response) {
                if (response !== '') {
                    $('#firmMessagePlaceHolder').html(response.message);
                    if (response.result === 'ok') {
                        toastr[response.notifyType](response.notifyMessage, response.notifyTitle);
                        setTimeout(function () {
                            window.location.href = '<?=$_SESSION["requesturl"]?>';
                        }, 2000);
                    }
                    else {
                        toastr.error(response.message, 'Hata');
                    }
                }
                else {
                    toastr.error('Hata oluştu lütfen tekrar deneyin', 'Hata');
                }
            }
        });
    }
</script>
<!--*---------------------------------------------------------------------------*-->
<!--* datepicker init -->
<!--*---------------------------------------------------------------------------*-->
<script type="text/javascript">
    $.fn.datepicker.dates['tr'] = {
        days: ["Pazar", "Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi"],
        daysShort: ["Pzr", "Pts", "Sal", "Çar", "Per", "Cum", "Cts"],
        daysMin: ["Pz", "Pt", "Sa", "Ça", "Pe", "Cu", "Ct"],
        months: ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
        monthsShort: ["Oca", "Şub", "Mar", "Nis", "May", "Haz", "Tem", "Ağu", "Eyl", "Eki", "Kas", "Ara"],
        today: "Bugün",
        clear: "Temizle",
        weekStart: 1,
        titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
        format: "dd/mm/yyyy"
    };

    jQuery(document).ready(function () {
        $('.datepicker').each(function () {
            var dpicker = $(this);
            var picker = {
                init: function () {
                    dpicker.datepicker({
                        language      : 'tr',
                        autoclose     : true,
                        todayBtn      : "linked",
                        clearBtn      : true,
                        todayHighlight: true,
                        templates     : {
                            leftArrow : '<i class="la la-angle-left"></i>',
                            rightArrow: '<i class="la la-angle-right"></i>'
                        }
                    })
                }
            };
            picker.init();
        });
    });
</script>
<!--*---------------------------------------------------------------------------*-->
<!--* datetimepicker init -->
<!--*---------------------------------------------------------------------------*-->
<script type="text/javascript">
    jQuery(document).ready(function () {
        $('.datetimepicker').each(function () {
            var dtpicker = $(this);
            var datetimepicker = {
                init: function () {
                    dtpicker.datetimepicker({
                        autoclose     : true,
                        format        : 'dd/mm/yyyy hh:ii:ss',
                        language      : 'tr',
                        weekStart     : 1,
                        todayBtn      : "linked",
                        clearBtn      : true,
                        todayHighlight: true
                    })
                }
            };
            datetimepicker.init();
        });
    });
</script>
<!--*---------------------------------------------------------------------------*-->
<!--* page modal yukleme sayfa ile birlikte -->
<!--*---------------------------------------------------------------------------*-->
<?php $pm = (isset($_GET['pm']) && !empty($_GET['pm'])) ? $_GET['pm'] : '';
if($pm != '') { ?>
    <script type="application/javascript">
        $(function () {
            setTimeout(function() {
                $('#<?=$pm?>').modal('show');
            }, 1000);
        });
    </script>
<?php } ?>
<!--*---------------------------------------------------------------------------*-->
<!--* page tab yukleme sayfa ile birlikte -->
<!--*---------------------------------------------------------------------------*-->
<? $pt = (isset($_GET['pt']) && !empty($_GET['pt'])) ? $_GET['pt'] : '';
if($pt != '') { ?>
    <script type="application/javascript">
        $(function () {
            $("#myTab li a[href$='<?=$pt?>']").tab('show');
        });
    </script>
<? } else { ?>
    <script type="application/javascript">
        $(function () {
            $('#myTab li:first-child a').tab('show')
        });
    </script>
<? } ?>
<!--*---------------------------------------------------------------------------*-->
<!--* clipboard -->
<!--*---------------------------------------------------------------------------*-->
<script type="application/javascript">
    jQuery(document).ready(function() {
        var clipboard = new ClipboardJS('[data-clipboard=true]');
        clipboard.on('success', function(e) {
            //e.clearSelection();
            //console.log(e);
            toastr.success(e.text, 'Kopyalandı');
        });
        clipboard.on('error', function(e) {
            console.error('Action:', e.action);
            console.error('Trigger:', e.trigger);
        });
    });
</script>
<!--*---------------------------------------------------------------------------*-->
<!--* hotkeys -->
<!--*---------------------------------------------------------------------------*-->
<script type="application/javascript">
    <? /*
    let hotkeys = [];
    <?php if (isset($pages[GetPhpPageName()])) {
    $page = $pages[GetPhpPageName()];

    if (isset($page['hotkeys']) && !empty($page['hotkeys'])) {
    foreach ($page['hotkeys'] as $key => $hotkey) { ?>
    hotkeys.push({key: '<?php echo $key;?>', event: () => <?php echo $hotkey['event'] ?>});
    <?php }
    }
    } ?>

    hotkeys.forEach(hotkey => {
        $(document).bind('keydown', hotkey.key, function() {
            hotkey.event.call();
            return false;
        });
    });
    */ ?>

    let hotkeys = [];
    <?php if (isset($pages[GetPhpPageName()])) {
    $page = $pages[GetPhpPageName()];

    if (isset($page['hotkeys']) && !empty($page['hotkeys'])) {
    foreach ($page['hotkeys'] as $key => $hotkey) { ?>
    hotkeys.push({key: '<?php echo $key;?>', event: () => <?php echo $hotkey['event'] ?>});
    <?php }
    }
    } ?>

    hotkeys.forEach(hotkey => {
        $(document).bind('keydown', hotkey.key, function() {
            hotkey.event.call();
            return false;
        });
    });
</script>
<!--*---------------------------------------------------------------------------*-->
<!--* moments month names -->
<!--*---------------------------------------------------------------------------*-->
<script type="application/javascript">
    moment.locale('tr', {
        months: 'Ocak_Şubat_Mart_Nisan_Mayıs_Haziran_Temmuz_Ağustos_Eylül_Ekim_Kasım_Aralık'.split(
            '_'
        ),
        monthsShort: 'Oca_Şub_Mar_Nis_May_Haz_Tem_Ağu_Eyl_Eki_Kas_Ara'.split('_'),
        weekdays: 'Pazar_Pazartesi_Salı_Çarşamba_Perşembe_Cuma_Cumartesi'.split(
            '_'
        ),
        weekdaysShort: 'Paz_Pts_Sal_Çar_Per_Cum_Cts'.split('_'),
        weekdaysMin: 'Pz_Pt_Sa_Ça_Pe_Cu_Ct'.split('_'),
        meridiem: function (hours, minutes, isLower) {
            if (hours < 12) {
                return isLower ? 'öö' : 'ÖÖ';
            } else {
                return isLower ? 'ös' : 'ÖS';
            }
        },
        meridiemParse: /öö|ÖÖ|ös|ÖS/,
        isPM: function (input) {
            return input === 'ös' || input === 'ÖS';
        },
        longDateFormat: {
            LT: 'HH:mm',
            LTS: 'HH:mm:ss',
            L: 'DD.MM.YYYY',
            LL: 'D MMMM YYYY',
            LLL: 'D MMMM YYYY HH:mm',
            LLLL: 'dddd, D MMMM YYYY HH:mm',
        },
        calendar: {
            sameDay: '[bugün saat] LT',
            nextDay: '[yarın saat] LT',
            nextWeek: '[gelecek] dddd [saat] LT',
            lastDay: '[dün] LT',
            lastWeek: '[geçen] dddd [saat] LT',
            sameElse: 'L',
        },
        relativeTime: {
            future: '%s sonra',
            past: '%s önce',
            s: 'birkaç saniye',
            ss: '%d saniye',
            m: 'bir dakika',
            mm: '%d dakika',
            h: 'bir saat',
            hh: '%d saat',
            d: 'bir gün',
            dd: '%d gün',
            M: 'bir ay',
            MM: '%d ay',
            y: 'bir yıl',
            yy: '%d yıl',
        },
        ordinal: function (number, period) {
            switch (period) {
                case 'd':
                case 'D':
                case 'Do':
                case 'DD':
                    return number;
                default:
                    if (number === 0) {
                        // special case for zero
                        return number + "'ıncı";
                    }
                    var a = number % 10,
                        b = (number % 100) - a,
                        c = number >= 100 ? 100 : null;
                    return number + (suffixes$4[a] || suffixes$4[b] || suffixes$4[c]);
            }
        },
        week: {
            dow: 1, // Monday is the first day of the week.
            doy: 7, // The week that contains Jan 7th is the first week of the year.
        },
    });

    moment.locale('tr');
    var currMonthName  = moment().format('MMMM');
    var subtract1MonthName  = moment().subtract(1, "month").format('MMMM');
    var subtract2MonthName  = moment().subtract(2, "month").format('MMMM');
    var subtract3MonthName  = moment().subtract(3, "month").format('MMMM');
    var subtract4MonthName  = moment().subtract(4, "month").format('MMMM');
    var subtract5MonthName  = moment().subtract(5, "month").format('MMMM');
    var subtract6MonthName  = moment().subtract(6, "month").format('MMMM');
    var add1MonthName  = moment().add(1, "month").format('MMMM');
    var add2MonthName  = moment().add(2, "month").format('MMMM');
    var add3MonthName  = moment().add(3, "month").format('MMMM');
    var add4MonthName  = moment().add(4, "month").format('MMMM');
    var add5MonthName  = moment().add(5, "month").format('MMMM');
    var add6MonthName  = moment().add(6, "month").format('MMMM');
</script>
