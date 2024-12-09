<?php
require_once('source/settings.php');
require_once('source/settings-login.php');
checkPermissionPage(array('superadmin', 'admin', 'odmOdemeTakipPageView'));
?>
<!DOCTYPE html>
<html lang="tr">
<!-- begin::Head -->
<head>
    <?php require_once('includes/head-codes.php'); ?>
    <style>
        .derm-table {
            white-space: nowrap !important;
            font-size: 0.875rem;
        }
    </style>
</head>
<!-- end::Head -->

<!-- begin::Body -->
<body style="background-image: url(<?= $CurrentFirm['bg'] ?>)" class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">
<!-- begin:: Page -->

<!-- begin:: Header Mobile -->
<?php require_once('includes/header-mobile.php'); ?>
<!-- end:: Header Mobile -->

<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

            <!-- begin:: Header -->
            <?php require_once('includes/header.php'); ?>

            <!-- end:: Header -->
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
                <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch"
                     id="kt_body">
                    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                        <!-- begin:: Subheader -->
                        <?php require_once('includes/subheader.php'); ?>

                        <!-- end:: Subheader -->

                        <!-- begin:: Content -->
                        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">


                            <?
                            DovizKuruYKB()

                            ?>

                            <!--Begin::Row-->
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <!--begin::Portlet-->
                                    <div class="kt-portlet">
                                        <div class="kt-portlet__head">
                                            <div class="kt-portlet__head-label">
                                                <span class="kt-portlet__head-icon"><i class="fal fa-money-bill-alt"></i></span>
                                                <h3 class="kt-portlet__head-title">Ödeme Takip</h3>
                                            </div>
                                            <div class="kt-portlet__head-toolbar">
                                                <div class="kt-portlet__head-actions">
                                                    <a href="javascript:;" class="btn btn-outline-brand btn-sm" onclick="odemeTakipWidget();" ><i class="fal fa-chart-bar"></i><span class="d-none d-md-inline-block">Tablo Goster</span></a>
                                                    <a href="javascript:;" class="btn btn-outline-brand btn-sm" onclick="odemeFormEkle();"><i class="fal fa-plus"></i><span class="d-none d-md-inline-block">Ekle</span></a>
                                                    <a href="javascript:;" class="btn btn-outline-brand btn-sm" onclick="filtreleGetir();"><i class="fal fa-filter"></i><span class="d-none d-md-inline-block">Filtrele</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-portlet__body">

                                            <div class="row form-group justify-content-xl-center mb-0">



                                                <div class="col-xl-2 col-10">
                                                    <form name="quickSearchForm">
                                                    <div class="form-group">
                                                        <label>Hızlı Arama</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fal fa-search kt-font-brand"></i></span></div>
                                                            <input type="text" class="form-control" id="ff_quickSearch_front" placeholder="ID, Ödeme Yeri yada Cinsine göre ara..." autocomplete="off"/>
                                                            <div class="input-group-append"><button class="btn btn-secondary" type="submit">ARA</button></div>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>


                                                <div class="col-xl-1 col-2 text-center kt-mt-25">
                                                    <button type="button" class="btn btn-info btn-icon btn-elevate btn-elevate-air btn-circle btn-blockQ" onclick="searchReset()"><i class="fal fa-undo"></i></button>
                                                    <button type="button" class="btn btn-info btn-icon btn-elevate btn-elevate-air btn-circle btn-blockQ" onclick="searchResetFirma()"><i class="fal fa-building"></i></button>
                                                </div>


                                                <div class="col-xl-6 col-12" id="advancedSearchUpLevel">
                                                    <form name="advancedSearchForm">
                                                    <div class="form-group">
                                                        <label>Gelişmiş Arama</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fal fa-calendar kt-font-brand"></i></span></div>
                                                            <div class="input-group-prepend">
                                                                <input type="text" class="form-control" id="advancedSearch_vadeDR" autocomplete="off">
                                                            </div>

                                                            <div class="input-group-prepend">
                                                                <select class="form-control input-group-text" name="advancedSearch_borclu_id" id="advancedSearch_borclu_id">
                                                                    <option value="">Hepsi</option>
                                                                    <? $data = GetListDataFromTable('param_odm_borclusirketler', '*', 'id');
                                                                    foreach ($data as $d) { ?>
                                                                        <option value="<?=$d['id']?>"><?=$d['tag']?></option>
                                                                    <? } ?>
                                                                </select>
                                                            </div>
                                                            <div class="input-group-prepend">
                                                                <select class="form-control input-group-text" name="advancedSearch_kategori_id" id="advancedSearch_kategori_id">
                                                                    <option value="">Hepsi</option>
                                                                    <? $data = GetListDataFromTable('param_odm_kategoriler', '*', 'id');
                                                                    foreach ($data as $d) { ?>
                                                                        <option value="<?=$d['id']?>"><?=$d['kategori']?></option>
                                                                    <? } ?>
                                                                </select>
                                                            </div>
                                                            <div class="typeahead form-control" style="border: 0; padding: 0px">
                                                                <div id="scrollable-dropdown-menu">
                                                                    <div class="kt-input-icon kt-input-icon--right">
                                                                        <input type="text" class="form-control" id="advancedSearch_alacakli_typeahead" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-top-right-radius: 0;border-bottom-right-radius: 0;" onClick="this.select();" autocomplete="off"/>
                                                                        <span class="kt-input-icon__icon kt-input-icon__icon--right"><span id="ff_odemeyeri"></span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <select class="form-control input-group-text" name="advancedSearch_durum" id="advancedSearch_durum">
                                                                    <option value="">Hepsi</option>
                                                                    <option value="0">Ödenmedi</option>
                                                                    <option value="1">Ödendi</option>
                                                                </select>
                                                            </div>
                                                            <span id="advancedSearch_alacakli_validation"></span>
                                                            <input type="hidden" class="form-control" id="advancedSearch_alacakli_id" autocomplete="off"/>
                                                            <div class="input-group-append"><button class="btn btn-secondary" type="submit">ARA</button></div>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>

                                                <div class="col-xl-3 col-12 p-0 order-xl-last  order-md-first order-sm-first order-first">
                                                    <div class="kt-widget1">
                                                        <div class="kt-widget1__item">
                                                            <div class="kt-widget1__info">
                                                                <div class="btn-group">
                                                                    <a href="javascript:;" onclick="oncekiAnlikKurGetir();" class="btn btn-outline-brand" data-toggle="modal" data-target="#anlikKurGuncelleManuelModal">
                                                                        <i class="fal fa-edit"></i><span>Manuel Kur</span></a>
                                                                    <a href="javascript:;" class="btn btn-outline-brand" onclick="anlikKurGuncelleOtoYKB();">
                                                                        <i class="fal fa-sync-alt" id="spinIconId" style="padding-left: 0.35rem;"></i><span>YKB Kur</span></a>
                                                                </div>
                                                            </div>
                                                            <span class="kt-badge kt-badge--inline kt-badge--dark" style="font-size: 1.4rem;font-weight: 600;color: #fff;">$=<span id="anlikKurValueUSD"><?= FloatFormat($DovizKuruUSD, 4) ?></span> TL</span>
                                                            </br>
                                                            <span class="kt-badge kt-badge--inline kt-badge--dark" style="font-size: 1.4rem;font-weight: 600;color: #fff;">€=<span id="anlikKurValueEUR"><?= FloatFormat($DovizKuruEUR, 4) ?></span> TL</span>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
















    <?php





    $to = array(
        'onrozcn@hotmail.com' => 'onur11', 'onur@dekordogaltas.com' => 'onur22'
    );

    // Send2Email($CurrentFirm, $to, '', '', '', 'deneme konusu', 'deneme icerigi');

    ?>

















                                            <div id="odemeTakipWidget"></div>
                                            <input type="hidden" id="odemeTakipTablo_page" value="1">
                                            <input type="hidden" id="odemeTakipTablo_showMode" value="1">
                                            <input type="hidden" id="odemeTakipTablo_search" value="">

                                            <div id="odemeTakipTablo"></div>





                                        </div>
                                    </div>
                                    <!--end::Portlet-->
                                </div>
                            </div>
                            <!--End::Row-->


                        </div>

                        <!-- end:: Content -->
                    </div>
                </div>
            </div>

            <!-- begin:: Footer -->
            <?php require_once('includes/footer.php'); ?>
            <!-- end:: Footer -->
        </div>
    </div>
</div>

<!-- end:: Page -->

<?php require_once('includes/modals/mdl-odm-odeme-kaydet.php'); ?>
<?php require_once('includes/modals/mdl-odm-odeme-onayla.php'); ?>
<?php require_once('includes/modals/mdl-odm-odeme-plan.php'); ?>
<?php require_once('includes/modals/mdl-anlikkurguncelle.php'); ?>
<?php require_once('includes/modals/mdl-gnl-filter.php'); ?>
<?php require_once('includes/modals/mdl-gnl-search.php'); ?>
<?php require_once('includes/modals/mdl-gnl-fis.php'); ?>
<?php require_once('includes/modals/mdl-gnl-parameter.php'); ?>


<!-- begin::Quick Panel -->
<?php require_once('includes/header-topbar-quickpanel.php'); ?>
<!-- end::Quick Panel -->

<!-- begin::Sticky Toolbar -->
<? /* if(checkPermission(array('superadmin', 'admin'))) { ?>
        <?php require_once('includes/header-topbar-stickytoolbar.php'); ?>
        <? } */ ?>
<!-- end::Sticky Toolbar -->


<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#716aca",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<script src="assets/js/scripts.bundle.js" type="text/javascript"></script>
<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->

<!--end::Page Vendors -->

<!--begin::foot-codes -->
<?php require_once('includes/foot-codes.php'); ?>
<!--end::foot-codes -->

<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/parameter.js" type="text/javascript"></script>
<script src="assets/js/pages/odmOdemeTakip.js?v=<?=$siteJsVersion?>" type="text/javascript"></script>
<!--end::Page Scripts -->


<script>




    const tableId = '#odemeTakipTable';
    const activeClass = 'table-active';

    let activeRow = 0;
    rePosition();
    allKeydownTrue();

    function allKeydownTrue() {
        //$(document).keydown(function (e) {
        $(document).on("keydown", function (e) {
            if (activeRow > 0) {
                const ths  = $(tableId + ' thead tr').length;
                const rows = $(tableId + ' tbody tr').length;

                // if (e.keyCode == 38) { // move up
                //     activeRow = activeRow > 1 ? activeRow - 1 : 1;
                //     rePosition();
                //     return false;
                // } else if (e.keyCode == 40) { // move down
                //     activeRow = activeRow < rows - 1 ? activeRow + 1 : rows;
                //     rePosition();
                //     return false;
                // }

                if (e.keyCode == 38) { // move up
                    activeRow = activeRow > ths ? activeRow - 1 : ths;
                    rePosition();
                    return false;
                } else if (e.keyCode == 40) { // move down
                    activeRow = activeRow < rows + ths - 1 ? activeRow + 1 : rows + ths -1;
                    rePosition();
                    return false;
                }

            }
        });
    }

    function allKeydownFalse() {
        $(document).off('keydown');
    }

    $('#odemeKaydetModal, #odemeOnayModal').on('shown.bs.modal', function () {
        allKeydownFalse();
    });

    $('#odemeKaydetModal, #odemeOnayModal').on('hidden.bs.modal', function(e) {
        allKeydownTrue();
        hotkeys.forEach(hotkey => {
            $(document).bind('keydown', hotkey.key, function() {
                hotkey.event.call();
                return false;
            });
        });
    });



    $(document).on('click', tableId + ' tbody tr', function () {
        activeRow = $(this).closest('table').find('tr').index(this);
        rePosition();
    });
    

    function rePosition() {
        $('.' + activeClass).removeClass(activeClass);
        $(tableId + ' tr').eq(activeRow).addClass(activeClass);
        $('#actionButtons').removeClass('kt-hidden');
        scrollInView();
    }

    function scrollInView() {
        // const target = $(tableId + ' tr:eq(' + activeRow + ')');
        //
        // if (target.length) {
        //     const top = target.offset().top;
        //     $('html,body').stop().animate({scrollTop: top - 450}, 500);
        //     return false;
        // }
    }


    function getOdemeId() {
        return $(tableId + ' tr.' + activeClass).data('rowid');
    }

    function getBorcluUnvan() {
        return $(tableId + ' tr.' + activeClass).data('rowborclu');
    }
    function getBorcluRenk() {
        return $(tableId + ' tr.' + activeClass).data('rowborclurenk');
    }

    function getAlacakliUnvan() {
        return $(tableId + ' tr.' + activeClass).data('rowalacakli');
    }

    function getTutar() {
        return $(tableId + ' tr.' + activeClass).data('rowtutar');
    }

    function getParaBirimi() {
        return $(tableId + ' tr.' + activeClass).data('rowparabirimi');
    }

    function secimYapiniz() {
        toastr.error('İşlem yapabilmek için seçim yapınız', 'Hata');
    }

    function odemeDuzenleHeader() {
        const id = getOdemeId();

        if (id) {
            odemeDuzenle(id);
        } else {
            secimYapiniz();
        }
    }

    function odemeDuzenleKopyalaHeader() {
        const id = getOdemeId();

        if (id) {
            odemeDuzenle(id, 1);
        } else {
            secimYapiniz();
        }
    }

    function odemeOnayHeader() {
        const id = getOdemeId();

        if (id) {
            odemeOnayGetir(id);
        } else {
            secimYapiniz();
        }
    }

    function odemeSilHeader() {
        const id = getOdemeId();
        const borclu = getBorcluUnvan();
        const borclurenk = getBorcluRenk();
        const alacakli = getAlacakliUnvan();
        const tutar = getTutar();
        const parabirimi = getParaBirimi();

        if (id) {
            odemeSil(id, borclu, borclurenk, alacakli, tutar, parabirimi);
        } else {
            secimYapiniz();
        }
    }

</script>





</body>

<!-- end::Body -->
</html>