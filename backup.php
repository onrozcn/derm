<?php
require_once('source/settings.php');
require_once('source/settings-login.php');
checkPermissionPage(array('superadmin', 'admin'));
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
                            <div class="row">
                                <div class="col-12">
                                    <div class="kt-portlet">
                                        <div class="kt-portlet__body">
                                            <div class="row">

                                                <div class="col-xl-4">
                                                    <div class="kt-portlet kt-portlet--height-fluid">
                                                        <div class="kt-portlet__head">
                                                            <div class="kt-portlet__head-label">
                                                                <h3 class="kt-portlet__head-title">FTP+SQL Yedekleri</h3>
                                                            </div>
                                                            <div class="kt-portlet__head-toolbar">
                                                                <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                                                                    <li class="nav-item">
                                                                        <a href="javascript:;" class="btn btn-outline-brand btn-sm" onclick="BackupAdd(1);"><i class="fa fa-hdd"></i>FTP + SQL Yedekle</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="kt-portlet__body">
                                                            <div class="tab-content">
                                                                <div class="tab-pane active" id="ftp_tab" aria-expanded="true">
                                                                    <div class="kt-widget4">
                                                                        <? $path = 'backups/ftp+sql/';
                                                                        if (!file_exists($path)) {
                                                                            mkdir($path, 0777, true);
                                                                        }
                                                                        $files = scandir($path, 1);
                                                                        $files = array_diff(scandir($path), array('.', '..', '.gitignore'));
                                                                        foreach ($files as $file) { ?>
                                                                        <div class="kt-widget4__item">
                                                                            <span class="kt-widget4__icon"><i class="fa fa-file-archive"></i></span>
                                                                            <a href="<?=$siteUrl . $path . $file ?>" class="kt-widget4__title kt-widget4__title--light"><?=$file?></a>
                                                                            <span class="kt-widget4__number kt-font-info"><a href="javascript:;" class="btn btn-danger btn-sm" onclick="BackupRemove(1, '<?=$file?>')"><i class="fa fa-trash"></i>Sil</a></span>
                                                                        </div>
                                                                        <? } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>




                                                <div class="col-xl-4">
                                                    <div class="kt-portlet kt-portlet--height-fluid">
                                                        <div class="kt-portlet__head">
                                                            <div class="kt-portlet__head-label">
                                                                <h3 class="kt-portlet__head-title">SQL Yedekleri</h3>
                                                            </div>
                                                            <div class="kt-portlet__head-toolbar">
                                                                <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                                                                    <li class="nav-item">
                                                                        <a href="javascript:;" class="btn btn-outline-brand btn-sm" onclick="BackupAdd(2);"><i class="fa fa-hdd"></i>SQL Yedekle</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="kt-portlet__body">
                                                            <div class="tab-content">
                                                                <div class="tab-pane active" id="sql_tab" aria-expanded="true">
                                                                    <div class="kt-widget4">
                                                                    <? $path = 'backups/sql/';
                                                                    if (!file_exists($path)) {
                                                                        mkdir($path, 0777, true);
                                                                    }
                                                                    $files = scandir($path, 1);
                                                                    $files = array_diff(scandir($path), array('.', '..', '.gitignore'));
                                                                    foreach ($files as $file) { ?>
                                                                    <div class="kt-widget4__item">
                                                                        <span class="kt-widget4__icon"><i class="fa fa-database"></i></span>
                                                                        <a href="<?=$siteUrl . $path . $file ?>" class="kt-widget4__title kt-widget4__title--light"><?=$file?></a>
                                                                        <span class="kt-widget4__number kt-font-info"><a href="javascript:;" class="btn btn-danger btn-sm" onclick="BackupRemove(2, '<?=$file?>')"><i class="fa fa-trash"></i>Sil</a></span>
                                                                    </div>
                                                                    <? } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4">
                                                    <div class="kt-portlet kt-portlet--height-fluid">
                                                        <div class="kt-portlet__head">
                                                            <div class="kt-portlet__head-label">
                                                                <h3 class="kt-portlet__head-title">FTP Yedekleri</h3>
                                                            </div>
                                                            <div class="kt-portlet__head-toolbar">
                                                                <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                                                                    <li class="nav-item">
                                                                        <a href="javascript:;" class="btn btn-outline-brand btn-sm" onclick="BackupAdd(3);"><i class="fa fa-hdd"></i>FTP Yedekle</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="kt-portlet__body">
                                                            <div class="tab-content">
                                                                <div class="tab-pane active" id="ftp_tab" aria-expanded="true">
                                                                    <div class="kt-widget4">
                                                                        <? $path = 'backups/ftp/';
                                                                        if (!file_exists($path)) {
                                                                            mkdir($path, 0777, true);
                                                                        }
                                                                        $files = scandir($path, 1);
                                                                        $files = array_diff(scandir($path), array('.', '..', '.gitignore'));
                                                                        foreach ($files as $file) { ?>
                                                                        <div class="kt-widget4__item">
                                                                            <span class="kt-widget4__icon"><i class="fa fa-folders"></i></span>
                                                                            <a href="<?=$siteUrl . $path . $file ?>" class="kt-widget4__title kt-widget4__title--light"><?=$file?></a>
                                                                            <span class="kt-widget4__number kt-font-info"><a href="javascript:;" class="btn btn-danger btn-sm" onclick="BackupRemove(3, '<?=$file?>')"><i class="fa fa-trash"></i>Sil</a></span>
                                                                        </div>
                                                                        <? } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
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
<script src="assets/js/pages/backup.js" type="text/javascript"></script>
<!--end::Page Scripts -->

<!--begin::foot-codes -->
<?php require_once('includes/foot-codes.php'); ?>
<!--end::foot-codes -->
</body>

<!-- end::Body -->
</html>