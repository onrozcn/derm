<?php
require_once('source/settings.php');
require_once('source/settings-login.php');
checkPermissionPage(array('superadmin', 'admin', 'depYakitPageView'));
?>
<!DOCTYPE html>
<html lang="tr">
    <!-- begin::Head -->
    <head>
        <?php require_once('includes/head-codes.php'); ?>
    </head>
    <!-- end::Head -->

	<!-- begin::Body -->
	<body style="background-image: url(<?=$CurrentFirm['bg']?>)"  class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">
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

										<div class="col-xl-9 col-lg-12 order-xl-last">

                                            <!--begin::Portlet-->
                                            <div class="kt-portlet kt-portlet--tabs">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                        <h3 class="kt-portlet__head-title">
                                                            Hareketler
                                                        </h3>
                                                    </div>
                                                    <div class="kt-portlet__head-toolbar">
                                                        <ul id="myTab" class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-right nav-tabs-line-brand" role="tablist">
                                                            <? if (checkPermission(array('superadmin', 'admin', 'depYakitCikisTabView'))) { ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-toggle="tab" href="#yakitCikisTab" role="tab"><i class="fas fa-sign-out-alt"></i><span class="d-none d-lg-block">Yakıt </span>&nbsp;Çıkış</a>
                                                            </li>
                                                            <? } ?>
                                                            <? if (checkPermission(array('superadmin', 'admin', 'depYakitGirisTabView'))) { ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link " data-toggle="tab" href="#yakitGirisTab" role="tab"><i class="fas fa-sign-in-alt"></i><span class="d-none d-lg-block">Yakıt </span>&nbsp;Giriş</a>
                                                            </li>
                                                            <? } ?>
                                                            <? if (checkPermission(array('superadmin', 'admin', 'depYakitGirisAdd', 'depYakitCikisAdd'))) { ?>
                                                            <li class="nav-item dropdown">
                                                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true"><i class="fab fa-microsoft"></i><span class="d-none d-lg-block">İşlemler</span></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <? if (checkPermission(array('superadmin', 'admin', 'depYakitCikisAdd'))) { ?>
                                                                    <a class="dropdown-item" onclick="yakitCikisSifirla();" data-toggle="modal" data-target="#yakitCikisModal">
                                                                        <i class="fas fa-sign-out-alt"></i> Çıkış Ekle
                                                                    </a>
                                                                    <? } ?>
                                                                    <? if (checkPermission(array('superadmin', 'admin', 'depYakitGirisAdd'))) { ?>
                                                                    <a class="dropdown-item" onclick="yakitGirisSifirla();" data-toggle="modal" data-target="#yakitGirisModal">
                                                                        <i class="fas fa-sign-in-alt"></i> Giriş Ekle
                                                                    </a>
                                                                    <? } ?>
                                                                </div>
                                                            </li>
                                                            <? } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                    <div class="tab-content">
                                                        <? if (checkPermission(array('superadmin', 'admin', 'depYakitCikisTabView'))) { ?>
                                                        <div class="tab-pane" id="yakitCikisTab">

                                                            <?php require_once('includes/filters/depYakitGiris.php'); ?>

                                                            <input type="hidden" id="yakitCikisTablo_page" value="1">
                                                            <div id="yakitCikisTablo"></div>
                                                        </div>
                                                        <? } ?>

                                                        <? if (checkPermission(array('superadmin', 'admin', 'depYakitGirisTabView'))) { ?>
                                                        <div class="tab-pane" id="yakitGirisTab">
                                                            <div id="yakitGirisTablo"></div>
                                                        </div>
                                                        <? } ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--end::Portlet-->

                                        </div>


<!--                                        <div class="col-xl-3 col-lg-12 order-xl-first">-->
<!--                                            <div class="kt-portlet">-->
<!--                                                <div class="kt-portlet__head">-->
<!--                                                    <div class="kt-portlet__head-label">-->
<!--                                                        <h3 class="kt-portlet__head-title">Mazot Tankı</h3>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                                <div id="DepoHighChart" class="kt-portlet__body"></div>-->
<!--                                            </div>-->
<!--                                            <div class="kt-portlet">-->
<!--                                                <div class="kt-portlet__head">-->
<!--                                                    <div class="kt-portlet__head-label">-->
<!--                                                        <h3 class="kt-portlet__head-title">Yakıt Tüketim Top 10</h3>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                                <div id="YakitTuketimHighChart" class="kt-portlet__body"></div>-->
<!--                                            </div>-->
<!--                                        </div>-->

                                        <div class="col-xl-3 col-lg-12 order-xl-first">
                                            <div class="kt-portlet">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                        <h3 class="kt-portlet__head-title">Mazot Tankı</h3>
                                                    </div>
                                                </div>


<!--                                                <div id="DepoHighChart" class="kt-portlet__body"></div>-->

                                                <? $param_dep_tanklar = GetListDataFromTableWithSingleWhere('param_dep_tanklar', '*', 'sort_order', 'active=1 AND tank_hesapla=1 AND sirket_id=' . $CurrentFirm['id']);

                                                foreach ($param_dep_tanklar as $tank) { ?>
                                                    <div id="DepoHighChart<?=$tank['id']?>" class="kt-portlet__body"></div>
                                                <? } ?>




                                            </div>
                                            <div class="kt-portlet">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                        <h3 class="kt-portlet__head-title">Yakıt Tüketim Top 10</h3>
                                                    </div>
                                                </div>
                                                <div id="YakitTuketimHighChart" class="kt-portlet__body"></div>
                                            </div>
                                        </div>








									</div>

									<!--End::Row-->

									<!--Begin::Row-->
									<div class="row">
										<div class="col-xl-6 col-lg-12 order-lg-1 order-xl-1"></div>
										<div class="col-xl-6 col-lg-6 order-lg-1 order-xl-1"></div>
										<div class="col-xl-4 col-lg-6 order-lg-1 order-xl-1"></div>
										<div class="col-xl-4 col-lg-6 order-lg-1 order-xl-1"></div>
										<div class="col-xl-4 col-lg-6 order-lg-1 order-xl-1"></div>
									</div>

									<!--End::Row-->

									<!--Begin::Row-->

									<!--End::Row-->

									<!--Begin::Row-->


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



        <?php require_once('includes/modals/mdl-dep-yakit-giris.php'); ?>
        <?php require_once('includes/modals/mdl-dep-yakit-cikis.php'); ?>



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
        <? require_once('includes/widgets/chart-yakit.php'); ?>
        <? require_once('includes/widgets/chart-yakitTuketimTop.php'); ?>
        <script src="assets/js/pages/depYakitCikis.js?v=<?=$siteJsVersion?>" type="text/javascript"></script>
        <script src="assets/js/pages/depYakitGiris.js?v=<?=$siteJsVersion?>" type="text/javascript"></script>
        <!--end::Page Scripts -->

        <!--begin::foot-codes -->
        <?php require_once('includes/foot-codes.php'); ?>
        <!--end::foot-codes -->







        <script type="text/javascript">

            $('.yakitTabs').first().tab('show');


            $('#filterToggleBtn').click(function () {
                $('#filterToggleBtnText').text(function (i, old) {
                    return old == 'Filtre Göster' ? 'Filtre Gizle' : 'Filtre Göster';
                });
                $('#filterExec').toggle();
            });

            $('#filterExec').click(function () {
                var formFilterTarihStartEnd = $('#formFilterTarihStartEnd').val();
                var formFilterTankId = $('#formFilterTankId').val();
                var formFilterAracId = $('#formFilterAracId').val();
                var formFilterTeslimEden = $('#formFilterTeslimEden').val();
                yakitCikisTablo(1, 1, formFilterTarihStartEnd, formFilterTankId, formFilterAracId, formFilterTeslimEden);
            });


            $('#exportBtnExcel').click(function () {
                $('#yakitCikisTable').tableExport({type: 'xlsx', fileName: 'Yakıt Çıkış', ignoreColumn: [1]});
            });
            $('#exportBtnPdf').click(function () {
                $('#yakitCikisTable').tableExport({type: 'pdf', fileName: 'Yakıt Çıkış', ignoreColumn: [1]});
            });
            $('#exportBtnPng').click(function () {
                $('#yakitCikisTable').tableExport({type: 'png', fileName: 'Yakıt Çıkış', ignoreColumn: [1]});
            });

            $(function () {
                var start = '';
                var end = '';
                $('#formFilterTarih').daterangepicker({
                    //startDate: "",
                    //endDate: "",
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
                        'Bu ay'     : [moment().startOf('month'), moment().endOf('month')],
                        'Son Ay'    : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, function (start, end) {
                    $('#formFilterTarihStartEnd').val(start.format('YYYY-MM-DD') + '/' + end.format('YYYY-MM-DD'));
                });


                $('#formFilterTarih').on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                });
                $('#formFilterTarih').on('cancel.daterangepicker', function (ev, picker) {
                    $(this).val('').datepicker("update");
                    $('#formFilterTarihStartEnd').val('');
                });


            });


            $('.table-responsive').on('show.bs.dropdown', function () {
                $('.table-responsive').css("overflow", "inherit");
            });

            $('.table-responsive').on('hide.bs.dropdown', function () {
                $('.table-responsive').css("overflow", "auto");
            })

        </script>






	</body>

	<!-- end::Body -->
</html>