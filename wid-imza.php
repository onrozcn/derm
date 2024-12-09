<?php
require_once('source/settings.php');
require_once('source/settings-login.php');
checkPermissionPage(array('superadmin', 'admin'));

$id = (isset($_GET['id']) && !empty($_GET['id'])) ? MysqlSecureText($_GET['id']) : 0;

?>
<?php
if (!empty($_REQUEST['Sender'])):
    $sender = $_REQUEST['Sender'];
    $layout = file_get_contents('./includes/imza-template.html', FILE_USE_INCLUDE_PATH);

    foreach ($sender as $key => $value) {
        $key         = strtoupper($key);
        $start_if    = strpos($layout, '[[IF-' . $key . ']]');
        $end_if      = strpos($layout, '[[ENDIF-' . $key . ']]');
        $length      = strlen('[[ENDIF-' . $key . ']]');

        if (!empty($value)) {
            // Add the value at its proper location.
            $layout = str_replace('[[IF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[ENDIF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[' . $key . ']]', $value, $layout);
        } elseif (is_numeric($start_if)) {
            // Remove the placeholder and brackets if there is an if-statement but no value.
            $layout = str_replace(substr($layout, $start_if, $end_if - $start_if + $length), '', $layout);
        } else {
            // Remove the placeholder if there is no value.
            $layout = str_replace('[[' . $key . ']]', '', $layout);
        }
    }

    // Clean up any leftover placeholders. This is useful for booleans,
    // which are not submitted if left unchecked.
    $layout = preg_replace("/\[\[IF-(.*?)\]\]([\s\S]*?)\[\[ENDIF-(.*?)\]\]/u", "", $layout);

    if (!empty($_REQUEST['download'])) {
        header('Content-Description: File Transfer');
        header('Content-Type: text/html');
        header('Content-Disposition: attachment; filename=benim-imzam.htm');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
    }

    echo $layout;
else: ?>
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
                                        <? if ($id <= 0) { ?>
                                            <div class="col-lg-12">
                                                <div class="kt-section">
                                                    <div class="kt-section__content kt-section__content--border kt-section__content--fit">
                                                        <div class="kt-grid-nav kt-grid-nav--skin-light">
                                                            <? $count = 1;
                                                            $firmaImza = GetListDataFromTableWithSingleWhere('param_arc_firmaimza', '*', 'sort_order', 'active=1');
                                                            foreach ($firmaImza as $data) {
                                                              if ($count%4 == 1) {
                                                                    echo '<div class="kt-grid-nav__row">';
                                                                } ?>

                                                                <a href="?id=<?=$data['id']?>" class="kt-grid-nav__item">
                                                                    <i class="kt-grid-nav__icon"></i>
                                                                    <span class="kt-grid-nav__title"><?=$data['tag']?></span>
                                                                    <span class="kt-grid-nav__desc">eCommerce</span>
                                                                </a>


                                                                <? if ($count%4 == 0) {
                                                                    echo '</div>';
                                                                }
                                                                $count++;
                                                            }
                                                            if ($count%4 != 1) echo '</div>'; //Eger 4 e tam bolunmuyorsa sona div ekle
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <? } else {
                                            $firma = GetSingleDataFromTableWithSingleWhere('param_arc_firmaimza', 'id=' . $id); ?>


                                        <div class="col-lg-6">
                                            <div class="kt-portlet">
                                                <form role="form" method="post" target="preview" id="form">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="fal fa-file-signature"></i>
                                                    </span>
                                                        <h3 class="kt-portlet__head-title"><?=$firma['tag']?> İmza Hazırlama</h3>
                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                        <div class="m-portlet__body">

                                                            <div class="form-group row">
                                                                <div class="col-lg-4">
                                                                    <label>Ad</label>
                                                                    <input type="text" class="form-control" name="Sender[name]" value="" autocomplete="off" required>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label>Soyad</label>
                                                                    <input type="text" class="form-control" name="Sender[surname]" value="" autocomplete="off" required>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label>Ünvan</label>
                                                                    <input type="text" class="form-control" name="Sender[unvan]" value="" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <div class="col-lg-12">
                                                                    <label>Firma Ünvan</label>
                                                                    <input type="text" class="form-control" value="<?=$firma['unvan']?>" autocomplete="off" disabled>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <div class="col-lg-12">
                                                                    <label>Adres</label>
                                                                    <input type="text" class="form-control" value="<?=$firma['adres']?>" autocomplete="off" disabled>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <div class="col-lg-12">
                                                                    <label>Vergi Dairesi</label>
                                                                    <div class="m-radio-inline">
                                                                        <label class="m-radio">
                                                                            <input type="radio" name="Sender[vergi]" value="0" checked="checked"> Gizle <span></span>
                                                                        </label>
                                                                        <label class="m-radio">
                                                                            <input type="radio" name="Sender[vergi]" value="1"> Göster <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <div class="col-lg-4">
                                                                    <label>Telefon</label>
                                                                    <input type="text" class="form-control phonenumber" name="Sender[phone]" value="<?=$firma['telefon']?>" autocomplete="off">
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label>Fax</label>
                                                                    <input type="text" class="form-control phonenumber" name="Sender[fax]" value="<?=$firma['fax']?>" autocomplete="off">
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label>Mobil</label>
                                                                    <input type="text" class="form-control phonenumber" name="Sender[mobile]" value="" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <div class="col-lg-6">
                                                                    <label>Email</label>
                                                                    <input type="text" class="form-control" name="Sender[email]" value="" autocomplete="off">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label>Web Site</label>
                                                                    <input type="text" class="form-control" name="Sender[web]" value="<?=$firma['web']?>" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <input type="hidden" class="form-control m-input m-input--solid" name="Sender[logourl]" value="<?=$firma['logoUrl']?>">
                                                            <input type="hidden" class="form-control m-input m-input--solid" name="Sender[firmaunvan]" value="<?=$firma['unvan']?>">
                                                            <input type="hidden" class="form-control m-input m-input--solid" name="Sender[address]" value="<?=$firma['adres']?>">
                                                            <input type="hidden" class="form-control m-input m-input--solid" name="Sender[vergidaire]" value="<?=$firma['vergiDaire']?>">
                                                            <input type="hidden" class="form-control m-input m-input--solid" name="Sender[vergino]" value="<?=$firma['vergiNo']?>">

                                                        </div>

                                                </div>
                                                <div class="kt-portlet__foot">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-8 m--valign-middle">
                                                            <kbd>%HOMEDRIVE%%HOMEPATH%\AppData\Roaming\Microsoft\Signatures</kbd>
                                                        </div>
                                                        <div class="col-lg-4 kt-align-right">
                                                            <button id="preview" type="submit" class="btn btn-success"><i class="fal fa-eye"></i> Önizleme</button>
                                                            <button id="download" type="submit" class="btn btn-info"><i class="fal fa-download"></i> İndir</button>
                                                            <input type="hidden" name="download" id="will-download" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div id="previewContainer" class="kt-portlet" style="display:none">
                                                    <div class="kt-portlet__head">
                                                        <div class="kt-portlet__head-label">
														<span class="kt-portlet__head-icon">
															<i class="fal fa-file-signature"></i>
														</span>
                                                            <h3 class="kt-portlet__head-title"><?=$firma['tag']?> İmza Hazırlama</h3>
                                                        </div>
                                                    </div>
                                                    <div class="kt-portlet__body">
                                                        <div class="m-portlet__body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <p class="font-prototype-script-bold">Merhaba,</p>
                                                                    <p class="font-prototype-script-bold">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum vel suscipit nisi. Vivamus sollicitudin vel augue at facilisis. Mauris in dui at ligula aliquet cursus. Vivamus sollicitudin viverra mi a feugiat. Quisque interdum massa libero. In consequat placerat ipsum, vel commodo velit vestibulum sit amet. Sed maximus, ligula eu congue congue, ante sem elementum nibh, at porta urna velit ut justo. Sed semper viverra nisi, volutpat porttitor enim pellentesque vel. Suspendisse malesuada dolor at lectus dignissim, at sollicitudin turpis ornare. Ut aliquam maximus magna, eget tempus lacus tristique vel. Nulla vehicula odio sit amet elit euismod lacinia.</p>
                                                                    <p class="font-prototype-script-bold">Iyi Calısamalar</p>
                                                                </div>
                                                            </div>
                                                            <iframe src="about:blank" name="preview" width="100%" height="250" frameBorder="0"></iframe>
                                                        </div>
                                                    </div>
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
		<script src="assets/js/scripts.bundle.js" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->

		<!--begin::Page Vendors(used by this page) -->

		<!--end::Page Vendors -->

		<!--begin::Page Scripts(used by this page) -->
        <script type="text/javascript">
            $('#preview').click(function() {
                $('#previewContainer').show('slow', function() {
                });

                $("#download").bind( "click", function() {
                    $('#will-download').val('true');
                    $('#form').removeAttr('target').submit();
                });

                $("#preview").bind( "click", function() {
                    $('#will-download').val('');
                    $('#form').attr('target','preview');
                });

            });
        </script>
		<!--end::Page Scripts -->

        <!--begin::foot-codes -->
        <?php require_once('includes/foot-codes.php'); ?>
        <!--end::foot-codes -->
	</body>

	<!-- end::Body -->
</html>
<?php endif;