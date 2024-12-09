<?php
require_once('source/settings.php');
require_once('source/settings-login.php');
?>
<!DOCTYPE html>
<html lang="tr">
<!-- begin::Head -->
<head>
    <?php require_once('includes/head-codes.php'); ?>
</head>
<!-- end::Head -->

<!-- begin::Body -->
<body style="background-image: url(<?=$CurrentFirm['bg']?>)" class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">
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
                <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
                    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                        <!-- begin:: Subheader -->
                        <?php require_once('includes/subheader.php'); ?>
                        <!-- end:: Subheader -->

                        <!-- begin:: Content -->
                        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                            <!--Begin::Row-->

                            <?php
//                            $a=28000;
//                            $b=3;
//                            $kalan=round($a%$b/100,2);
//                            echo $kalan;
//                            $bolum=$a/$b;
//                            $tam=round($bolum,2);
//                            echo "<br>$tam";


                            //phpinfo();




                            ?>

                            <div class="row">
                            <? if (checkPermission(array('superadmin', 'admin', 'homeWidDepo'))) { ?>
<!--                                <div class="col-md-4">-->
<!--                                    <div class="kt-portlet kt-portlet--height-fluid">-->
<!--                                        <div class="kt-portlet__head">-->
<!--                                            <div class="kt-portlet__head-label">-->
<!--                                                <h3 class="kt-portlet__head-title">Mazot Tankı</h3>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <div id="DepoHighChart" class="kt-portlet__body"></div>-->
<!--                                    </div>-->
<!--                                </div>-->

                                <? $param_dep_tanklar = GetListDataFromTableWithSingleWhere('param_dep_tanklar', '*', 'sort_order', 'active=1 AND tank_hesapla=1 AND sirket_id=' . $CurrentFirm['id']);
                                foreach ($param_dep_tanklar as $tank) { ?>
                                <div class="col-md-4">
                                    <div class="kt-portlet kt-portlet--height-fluid">
                                        <div class="kt-portlet__head">
                                            <div class="kt-portlet__head-label">
                                                <h3 class="kt-portlet__head-title"><?=$tank['kisa_isim']?></h3>
                                            </div>
                                        </div>
                                        <div id="DepoHighChart<?=$tank['id']?>" class="kt-portlet__body"></div>
                                    </div>
                                </div>
                                <? } ?>

                                <div class="col-md-4">
                                    <div class="kt-portlet kt-portlet--height-fluid">
                                        <div class="kt-portlet__head">
                                            <div class="kt-portlet__head-label">
                                                <h3 class="kt-portlet__head-title">Ortalama Tüketimler</h3>
                                            </div>
                                        </div>
                                        <div id="YakitOrtalamaHighChart" class="kt-portlet__body"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="kt-portlet kt-portlet--height-fluid">
                                        <div class="kt-portlet__head">
                                            <div class="kt-portlet__head-label">
                                                <h3 class="kt-portlet__head-title">Yakıt Tüketim Top 10</h3>
                                            </div>
                                            <div class="kt-portlet__head-toolbar">
                                                <div class="kt-portlet__head-actions">
                                                    <? $month = time();
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        $month = strtotime('last month', $month);
                                                        $months[] = date("Y-m", $month);
                                                    } ?>
                                                    <select class="form-control" name="YakitTuketimHighChartPeriodInput" id="YakitTuketimHighChartPeriodInput">
                                                        <option value="<?=date('Y-m')?>"><?=date('Y-m')?></option>
                                                        <? foreach ($months as $month) { ?>
                                                            <option value="<?=$month?>"><?=$month?></option>
                                                        <? } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="YakitTuketimHighChart" class="kt-portlet__body"></div>
                                    </div>
                                </div>
                            <? } if (checkPermission(array('superadmin', 'admin', 'homeWidAracgiriscikis'))) { ?>
                                <div class="col-sm-12">
                                    <div class="kt-portlet kt-portlet--height-fluid">
                                        <div class="kt-portlet__head">
                                            <div class="kt-portlet__head-label">
                                                <h3 class="kt-portlet__head-title">Son Araç Giriş Çıkışlar</h3>
                                            </div>
                                        </div>
                                        <div id="chart-container-aracgiriscikis" class="kt-portlet__body"></div>
                                    </div>
                                </div>
                            <? } ?>
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

<!-- begin::Quick Panel -->
<?php require_once('includes/header-topbar-quickpanel.php'); ?>
<!-- end::Quick Panel -->

<!-- begin::Sticky Toolbar -->
<?/* if(checkPermission(array('superadmin', 'admin'))) { ?>
        <?php require_once('includes/header-topbar-stickytoolbar.php'); ?>
        <? } */?>
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
<script src="assets/js/scripts.bundle.js?v=<?=$siteJsVersion?>" type="text/javascript"></script>
<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->

<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
<? require_once('includes/widgets/chart-yakit.php'); ?>
<? require_once('includes/widgets/chart-aracgiriscikis.php'); ?>
<? require_once('includes/widgets/chart-yakitTuketimTop.php'); ?>
<? require_once('includes/widgets/chart-yakitOrtalamaTop.php'); ?>
<!--end::Page Scripts -->

<!--begin::foot-codes -->
<?php require_once('includes/foot-codes.php'); ?>
<!--end::foot-codes -->
</body>

<!-- end::Body -->
</html>