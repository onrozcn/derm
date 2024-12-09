<?php
require_once('source/settings.php');
require_once('source/settings-login.php');
//checkPermissionPage(array('superadmin', 'admin', 'hamParameterManage'));
checkPermissionPage($tabAyarlar['parameters']['permission']);
?>
<!DOCTYPE html>
<html lang="tr">
    <!-- begin::Head -->
    <head>
        <base href="">
        <meta charset="utf-8" />
        <title>dERM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!--begin::Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Asap+Condensed:500">
        <!--end::Fonts -->

        <!--begin::Page Vendors Styles(used by this page) -->

        <!--end::Page Vendors Styles -->

        <!--begin::Global Theme Styles(used by all pages) -->
        <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
        <!--end::Global Theme Styles -->

        <!--begin::Layout Skins(used by all pages) -->

        <!--end::Layout Skins -->

        <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />

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


                                        <? foreach ($parameters as $pkey => $pvalue) {

                                       if (checkPermission(ParamCatPermissionCheck($pvalue['categoryFields']))) { ?>

                                        <div class="col-12 as">
                                            <!--begin::Portlet-->
                                            <div class="kt-portlet">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                        <h3 class="kt-portlet__head-title">
                                                            <?=$pvalue['categoryTitle']?>
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                    <!--begin::Section-->
                                                    <div class="kt-section">
                                                        <div class="kt-section__content kt-section__content--border kt-section__content--fit">

                                                            <!--begin: Grid Nav -->
                                                            <div class="kt-grid-nav kt-grid-nav--skin-light">

                                                                <?
                                                                $count = 1;
                                                                foreach($pvalue['categoryFields'] as $key => $value) {


                                                                    $url = (isset($value['url']) && !empty($value['url'])) ? $value['url'] : ($siteUrl . 'parameter.php?cat='.$pkey.'&parameter=' . $key); ?>

                                                                    <? if ($count%4 == 1) {
                                                                        echo '<div class="kt-grid-nav__row">';
                                                                    } ?>

                                                                    <? if (checkPermission(ParamItemPermissionCheck($value['permission']))) { ?>
                                                                    <a href="<?=$url?>" class="kt-grid-nav__item">
                                                                        <i class="kt-grid-nav__icon <?=$value['icon']?>"></i>
                                                                        <span class="kt-grid-nav__title"><?=$value['title']?></span>
                                                                        <span class="kt-grid-nav__desc">eCommerce</span>
                                                                    </a>
                                                                    <? } ?>

                                                                    <? if ($count%4 == 0) {
                                                                        echo '</div>';
                                                                    }
                                                                    $count++;
                                                                }

                                                                if ($count%4 != 1) echo '</div>'; //Eger 4 e tam bolunmuyorsa sona div ekle
                                                                ?>

                                                            </div>
                                                            <!--end: Grid Nav -->
                                                        </div>
                                                    </div>
                                                    <!--end::Section-->
                                                </div>
                                            </div>
                                            <!--end::Portlet-->
                                        </div>
                                        <? } } ?>


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


		<!--end::Page Scripts -->

        <!--begin::foot-codes -->
        <?php require_once('includes/foot-codes.php'); ?>
        <!--end::foot-codes -->
	</body>

	<!-- end::Body -->
</html>