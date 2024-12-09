<?php
require_once('source/settings.php');
require_once('source/settings-login.php');
checkPermissionPage(array('superadmin', 'admin', 'hamGirisPageView'));

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

                                        <div class="col-xl-12 col-lg-12 order-xl-last">

                                            <div class="kt-portlet">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                        <h3 class="kt-portlet__head-title">
                                                            Hammadde Giriş
                                                        </h3>
                                                    </div>
                                                    <div class="kt-portlet__head-toolbar">
                                                        <div class="kt-portlet__head-actions">
                                                           <a href="javascript:;" class="btn btn-outline-brand btn-sm" onclick="HammaddeFormModal(1);"><i class="fas fa-truck-container"></i><span class="d-none d-md-inline-block">Hammadde Kayıt Ekle</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                    <div class="row">
                                                        <div id="hamGirisTablo" class="col-12"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>








                                    </div>

                                    <!--End::Row-->













                                    <div id="clone_packing" class="kt-hidden">
                                        <?php GetRsShipPacking('0', '', '', '', ''); ?>
                                    </div>

                                    <? function GetRsShipPacking($id, $quantity, $item_code, $note, $first_time = false) {

                                        global $CurrentFirm, $CurrentUser;
                                    ?>
                                        <!-- begin new clone -->
                                        <div class="border clone_content mb-3 pt-4">
                                            <div class="col-12">
                                                <div class="form-row">
                                                    <input type="hidden" name="hgt_id[]" value="<?php echo $id; ?>"/>

                                                    <div class="col-md-1 col-12 text-center my-auto remove-first">
                                                        <?php if (!$first_time) { ?>
                                                        <span onclick="DeleteClone($(this).parent().parent().parent());" style="font-size: 15px !important;"><i class="fa fa-2x fa-trash"></i></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="form-group col-md-1 col-6">
                                                        <label>Ocak</label>
                                                        <select class="form-control" name="tas_ocak_id[]">
                                                            <option value="0">Seçiniz</option>
                                                            <? $param_ham_ocaklar = GetListDataFromTableWithSingleWhere('param_ham_ocaklar', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                                            foreach ($param_ham_ocaklar as $data) { ?>
                                                                <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['tag']?></option>
                                                            <? } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-1 col-6">
                                                        <label>Tür</label>
                                                        <select class="form-control rty" name="tas_tur_id[]">
                                                            <option value="0">Seçiniz</option>
                                                            <? $param_ham_turler = GetListDataFromTableWithSingleWhere('param_ham_turler', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                                            foreach ($param_ham_turler as $data) { ?>
                                                                <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['tag']?></option>
                                                            <? } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-1 col-6">
                                                        <label>Kalite</label>
                                                        <select class="form-control" name="tas_kalite_id[]">
                                                            <option value="0">Seçiniz</option>
                                                            <? $param_ham_kaliteler = GetListDataFromTableWithSingleWhere('param_ham_kaliteler', '*', 'sort_order', 'active=1 AND sirket_id=' . $CurrentFirm['id']);
                                                            foreach ($param_ham_kaliteler as $data) { ?>
                                                                <option value="<?= $data['id'] ?>"<? echo $data['id'] == $data ? ' selected="selected"' : ''; ?>><?=$data['isim']?></option>
                                                            <? } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-1 col-6">
                                                        <label>Tonaj</label>
                                                        <input type="number" class="form-control" name="tas_tonaj[]" autocomplete="off"/>
                                                    </div>

                                                    <div class="form-group col-md-1 col-6">
                                                        <label>Ocak Taş No</label>
                                                        <input type="text" class="form-control" name="tas_ocak_no[]" autocomplete="off"/>
                                                    </div>
                                                    <div class="form-group col-md-1 col-6">
                                                        <label>Fabrika Taş No</label>
                                                        <input type="text" class="form-control" name="tas_fabrika_no[]" autocomplete="off"/>
                                                    </div>
                                                    <div class="form-group col-md-1 col-4">
                                                        <label>En</label>
                                                        <input type="number" class="form-control tas_en" name="tas_en[]" autocomplete="off"/>
                                                    </div>
                                                    <div class="form-group col-md-1 col-4">
                                                        <label>Boy</label>
                                                        <input type="number" class="form-control" name="tas_boy[]" autocomplete="off"/>
                                                    </div>
                                                    <div class="form-group col-md-1 col-4">
                                                        <label>Yükseklik</label>
                                                        <input type="number" class="form-control" name="tas_yukseklik[]" autocomplete="off"/>
                                                    </div>
                                                    <div class="form-group col-md-1 col-4">
                                                        <label>İrsaliye No</label>
                                                        <input type="text" class="form-control" name="tas_irsaliye_no[]" autocomplete="off"/>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <!-- end new clone -->


                                    <?php } ?>
















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

        <?php require_once('includes/modals/mdl-ham-giris.php'); ?>


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
        <script src="assets/js/pages/hamGiris.js?v=<?=$siteJsVersion?>" type="text/javascript"></script>
		<!--end::Page Scripts -->

        <!--begin::foot-codes -->
        <?php require_once('includes/foot-codes.php'); ?>
        <!--end::foot-codes -->
	</body>

	<!-- end::Body -->
</html>