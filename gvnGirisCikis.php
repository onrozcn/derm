<?php
require_once('source/settings.php');
require_once('source/settings-login.php');
checkPermissionPage(array('superadmin', 'admin', 'gvnAracGiriscikisPage'));
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
                            <!--Begin::Row-->
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <!--begin::Portlet-->
                                    <div class="kt-portlet">
                                        <div class="kt-portlet__head">
                                            <div class="kt-portlet__head-label">
                                                <span class="kt-portlet__head-icon"><i class="fad fa-garage-car"></i></span>
                                                <h3 class="kt-portlet__head-title">Giriş Çıkış</h3>
                                            </div>
                                            <div class="kt-portlet__head-toolbar">
                                                <div class="kt-portlet__head-actions">
                                                    <? if (checkPermission(array('superadmin', 'admin', 'gvnAracGiriscikisAdd'))) { ?>
                                                    <a href="javascript:;" class="btn btn-outline-brand btn-sm" onclick="GirisCikisFormModal(1, 0, 1);"><i class="fas fa-car"></i><span class="d-none d-md-inline-block">Araç Kayıt Ekle</span></a>
                                                    <a href="javascript:;" class="btn btn-outline-brand btn-sm" onclick="GirisCikisFormModal(1, 0, 3);"><i class="fas fa-truck"></i><span class="d-none d-md-inline-block">Kamyon Kayıt Ekle</span></a>
                                                    <a href="javascript:;" class="btn btn-outline-brand btn-sm" onclick="GirisCikisFormModal(1, 0, 4);"><i class="fas fa-truck-container"></i><span class="d-none d-md-inline-block">Hammadde Kayıt Ekle</span></a>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-portlet__body">


                                            <div class="row form-group justify-content-center mb-2">
                                                <div class="col-lg-6 col-xl-4">
                                                    <form name="searchForm">
                                                        <div class="form-group">
                                                            <label>Tarih Aralığı</label>
                                                            <div class="input-group">
                                                                <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="<?=Html5DateTimeLocalEncode(date("Y-m-d 00:00:00"));?>" step="0" autocomplete="off"/>
                                                                <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="<?=Html5DateTimeLocalEncode(date("Y-m-d 23:59:59"));;?>" step="0" autocomplete="off"/>
                                                                <div class="input-group-append"><button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i> </button></div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>





                                            <div id="girisCikisTablo"></div>


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

<?php require_once('includes/modals/mdl-gvn-giriscikis-kaydet.php'); ?>


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
<script src="assets/js/modalGenerater.js" type="text/javascript"></script>
<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->

<!--end::Page Vendors -->

<!--begin::foot-codes -->
<?php require_once('includes/foot-codes.php'); ?>
<!--end::foot-codes -->

<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/parameter.js?v=<?=$siteJsVersion?>" type="text/javascript"></script>
<script src="assets/js/pages/gvnGirisCikis.js?v=<?=$siteJsVersion?>" type="text/javascript"></script>
<!--end::Page Scripts -->


</body>

<!-- end::Body -->
</html>