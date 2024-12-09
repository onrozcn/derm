<?php
require_once('source/settings.php');
require_once('source/settings-login.php');

$cat = (isset($_GET['cat']) && !empty($_GET['cat'])) ? MysqlSecureText($_GET['cat']) : '';
$parameter = (isset($_GET['parameter']) && !empty($_GET['parameter'])) ? MysqlSecureText($_GET['parameter']) : '';
$mode = (isset($_GET['mode']) && !empty($_GET['mode'])) ? MysqlSecureText($_GET['mode']) : 'active';
//if ($CurrentUser['id'] != 1 && $CurrentUser['permission']['param_perm_'.$parameter.''] != 1) {


if (empty($parameter)) {
    header('location:' . $siteUrl . 'parameters.php');
    die();
}
$p = $parameters[$cat]['categoryFields'][$parameter];
checkPermissionPage($p['permission']);
?>
<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->
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
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!--begin::Portlet-->
                                        <div class="kt-portlet">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        <?=$mode=='passive'?'Pasif':'Aktif'?> Parametreler : <?=$p['title']?>
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-actions">
                                                        <button type="button" class="btn btn-sm btn-success" onclick="NewParameterData()">
                                                            <i class="la la-plus"></i>&nbsp;Parametre Ekle
                                                        </button>
                                                        <? if ($mode=='active') { ?>
                                                        <a href="?<? echo http_build_query(array_merge($_GET, array("mode"=>"passive")))?>" class="btn btn-sm btn-warning"><i class="la la-retweet"></i>&nbsp;Pasif Parametreler</a>
                                                        <? } else if ($mode=='passive') { ?>
                                                        <a href="?<? echo http_build_query(array_merge($_GET, array("mode"=>"active")))?>" class="btn btn-sm btn-success"><i class="la la-retweet"></i> Aktif Parametreler</a>
                                                        <? } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__body">

                                                <div class="row justify-content-md-center">
                                                    <div class="col-md-4 mb-4">
                                                        <div class="form-group row">
                                                            <label class="col-3 col-form-label">Arama</label>
                                                            <div class="col-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="search" autocomplete="off" />
                                                                    <div class="input-group-append"><span class="input-group-text" id="basic-addon2"><i class="fal fa-search"></i></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div id="ParameterList"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!--end::Portlet-->
                                    </div>
                                </div>
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
    <input type="hidden" id="cat" value="<?=$cat?>"/>
    <input type="hidden" id="parameter" value="<?=$parameter?>"/>
    <input type="hidden" id="parametertitle" value="<?=$p['title']?>"/>
    <input type="hidden" id="mode" value="<?=$mode?>"/>
    <?php require_once('includes/modals/mdl-gnl-parameter.php'); ?>








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
    <script src="assets/js/scripts.bundle.js" type="text/javascript"></script>

    <!--end::Global Theme Bundle -->

    <!--begin::Page Vendors(used by this page) -->


    <!--end::Page Vendors -->

    <!--begin::Page Scripts(used by this page) -->
    <script src="assets/js/pages/parameter.js" type="text/javascript"></script>

    <!--end::Page Scripts -->

    <!--begin::foot-codes -->
    <?php require_once('includes/foot-codes.php'); ?>
    <!--end::foot-codes -->
</body>

<!-- end::Body -->
</html>