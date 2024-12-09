<?php
require_once('source/settings.php');
require_once('source/settings-login.php');
checkPermissionPage(array('superadmin', 'admin'));

$id = (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) ? MysqlSecureText($_GET['id']) : 0;
if ($id <= 0) {
    header('location:' . $siteUrl . 'index.php');
    die();
}
$sets = $settings_model[$id];
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

										<div class="col">
                                            <div class="kt-portlet">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                        <h3 class="kt-portlet__head-title"><?=$sets['title']?></h3>
                                                    </div>
                                                </div>
                                                <form class="kt-form" name="settingsform" method="post" action="actions/settings.php?Action=SaveSettingsForm">
                                                <div class="kt-portlet__body">







                                                    <input type="hidden" name="settingstype" value="<?php echo $id; ?>"/>
                                                    <?php
                                                    $ic = 0;
                                                    $formFields = 0;
                                                    $showns = 0;
                                                    foreach ($sets['fields'] as $f) {
                                                        if ($f['show']) {
                                                            $showns++;
                                                        }
                                                    }
                                                    foreach ($sets['fields'] as $field) {
                                                    if ($ic % 2 == 0 && $field['show']) { ?>
                                                    <div class="row">
                                                        <?php }
                                                        if ($field['show']) { ?>
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group row">
                                                                <div class="col">
                                                                    <?php if (!isset($field['empty']) || (isset($field['empty']) && !$field['empty'])) {
                                                                    $formFields++; ?>

                                                                    <label for="SF<?php echo $field['name']; ?>"><?php echo $field['label']; ?> <?php if ($field['required']) { ?><span class="required">*</span><?php } ?></label>

                                                                    <?php if ($field['type'] == 'varchar') { ?>
                                                                        <input type="text" class="form-control" name="<?php echo $field['name']; ?>" id="SF<?php echo $field['name']; ?>" placeholder="<?php echo $field['label']; ?>" maxlength="<?php echo $field['length']; ?>" value="<?php if (isset($setting[$field['name']])) {
                                                                            echo $setting[$field['name']];
                                                                        } ?>"/>
                                                                        <span class="form-text text-muted"><?php echo $field['desc']; ?></span>
                                                                    <?php } else if ($field['type'] == 'int') { ?>
                                                                        <input type="number" class="form-control" name="<?php echo $field['name']; ?>" id="SF<?php echo $field['name']; ?>" placeholder="<?php echo $field['label']; ?>" maxlength="<?php echo $field['length']; ?>" value="<?php if (isset($setting[$field['name']])) {
                                                                            echo $setting[$field['name']];
                                                                        } ?>"/>
                                                                        <span class="form-text text-muted"><?php echo $field['desc']; ?></span>
                                                                    <?php } else if ($field['type'] == 'bit') { ?>
                                                                        <select class="form-control" name="<?php echo $field['name']; ?>" id="SF<?php echo $field['name']; ?>">
                                                                            <option value="0"<?php if (isset($setting[$field['name']]) && $setting[$field['name']] == 0) {
                                                                                echo ' selected="selected"';
                                                                            } ?>>No
                                                                            </option>
                                                                            <option value="1"<?php if (isset($setting[$field['name']]) && $setting[$field['name']] == 1) {
                                                                                echo ' selected="selected"';
                                                                            } ?>>Yes
                                                                            </option>
                                                                        </select>
                                                                        <span class="form-text text-muted"><?php echo $field['desc']; ?></span>
                                                                    <?php } else if ($field['type'] == 'switch') { ?>
                                                                        <input type="hidden" name="<?=$field['name']?>" value="0">
                                                                        <input type="checkbox" value="1" data-switch="true" data-on-text="AÇIK" data-off-text="KAPALI" name="<?=$field['name']?>" id="SF<?=$field['name']?>" <?=(isset($setting[$field['name']]) && $setting[$field['name']] == 1)?'checked="checked"':'';?>>
                                                                        <span class="form-text text-muted"><?php echo $field['desc']; ?></span>
                                                                    <?php } else if ($field['type'] == 'combobox') { ?>
                                                                        <select class="form-control" name="<?php echo $field['name']; ?>" id="SF<?php echo $field['name']; ?>">
                                                                            <?php foreach ($field['values'] as $val) { ?>
                                                                                <option value="<?php echo $val[0]; ?>"<?php if (isset($setting[$field['name']]) && $setting[$field['name']] == $val[0]) {
                                                                                    echo ' selected="selected"';
                                                                                } ?>><?php echo $val[1]; ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <span class="form-text text-muted"><?php echo $field['desc']; ?></span>
                                                                    <?php } else if ($field['type'] == 'dbcombobox') { ?>
                                                                        <select class="form-control" name="<?php echo $field['name']; ?>" id="SF<?php echo $field['name']; ?>">
                                                                            <?php $tablevalues = GetListDataFromTable($field['table'], $field['valuefield'] . ', ' . $field['textfield'], $field['textfield']);
                                                                            foreach ($tablevalues as $val) { ?>
                                                                                <option value="<?php echo $val[$field['valuefield']]; ?>"<?php if (isset($setting[$field['name']]) && $setting[$field['name']] == $val[$field['valuefield']]) {
                                                                                    echo ' selected="selected"';
                                                                                } ?>><?php echo $val[$field['textfield']]; ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <span class="form-text text-muted"><?php echo $field['desc']; ?></span>
                                                                    <?php } else if ($field['type'] == 'dbmultibox') { ?>
                                                                    <select class="form-control" name="<?php echo $field['name']; ?>" id="SF<?php echo $field['name']; ?>" multiple>
                                                                        <?php $tablevalues = GetListDataFromTable($field['table'], $field['valuefield'] . ', ' . $field['textfield'], $field['textfield']);
                                                                        foreach ($tablevalues as $val) { ?>
                                                                            <option value="<?php echo $val[$field['valuefield']]; ?>"<?php if (isset($setting[$field['name']]) && $setting[$field['name']] == $val[$field['valuefield']]) {
                                                                                echo ' selected="selected"';
                                                                            } ?>><?php echo $val[$field['textfield']]; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <span class="form-text text-muted"><?php echo $field['desc']; ?></span>
                                                                    <?php }
                                                                    } ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                            <?php
                                                        }
                                                        else {
                                                            ?>
                                                            <input type="hidden" name="<?php echo $field['name'] ?>" id="SF<?php echo $field['name'] ?>" value=""/>
                                                            <?php
                                                        }
                                                        if ($field['show']) {
                                                            $ic++;
                                                        }
                                                        if (($ic > 0 && $ic % 2 == 0) || ($ic > 0 && $ic == $showns)) { ?>
                                                            </div>
                                                        <?php }
                                                    } ?>

                                                </div>

                                                <div class="kt-portlet__foot">
                                                    <div class="kt-form__actions">
                                                        <div class="row">
                                                            <? if ($formFields > 0) { ?>
                                                                <div class="col kt-align-right">
                                                                    <button type="submit" class="btn btn-outline-primary m-btn m-btn--icon"><span><i class="fas fa-save"></i><span>Kaydet</span></span></button>
                                                                    <button type="reset" class="btn btn-outline-secondary"><i class="fal fa-times-circle"></i> İptal</button>
                                                                </div>
                                                            <?php }
                                                            else { ?>
                                                                <div class="alert alert-info">
                                                                    <p><i class="fa fa-info-circle"></i>Ayar alanı mevcut değil</p>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                </form>
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
        <script type="text/javascript">
            $("[data-switch=true]").bootstrapSwitch();

            $('form[name=settingsform]').submit(function () {
                var form = $(this);
                $.ajax({
                    type    : 'POST',
                    dataType: 'json',
                    url     : form.attr('action'),
                    data    : form.serialize(),
                    success : function (cevap) {
                        if (cevap.result = 'ok') {
                            toastr.success(cevap.message, 'Başarılı');
                        } else {
                            toastr.error(cevap.message, 'Hata');
                        }
                    }
                });
                return false;
            });

        </script>
		<!--end::Page Scripts -->

        <!--begin::foot-codes -->
        <?php require_once('includes/foot-codes.php'); ?>
        <!--end::foot-codes -->
	</body>

	<!-- end::Body -->
</html>