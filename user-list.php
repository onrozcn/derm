<?php
require_once('source/settings.php');
require_once('source/settings-login.php');
checkPermissionPage(array('superadmin', 'admin'));

$userStatus = (isset($_GET['userStatus'])) ? $_GET['userStatus'] : 1;
$users = GetListDataFromTableWithSingleWhere('users', '*', 'name<>"" desc, id, name, surname, username', 'active='.$userStatus, false);
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
                                                        <h3 class="kt-portlet__head-title"><?=($userStatus==1?'Aktif':'Pasif')?> Kullanıcılar</h3>
                                                    </div>
                                                    <div class="kt-portlet__head-toolbar">
                                                        <div class="kt-portlet__head-actions">
                                                            <a href="<?=($userStatus==1?'user-list.php?userStatus=0':'user-list.php?userStatus=1')?>" class="btn btn-sm <?=($userStatus==1?'btn-warning':'btn-success')?>">
                                                                <i class="flaticon-users"></i>&nbsp;<?=($userStatus==1?'Pasif Kullanıcıları Göster':'Aktif Kullanıcıları Göster')?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                    <div class="row">
                                                        <? foreach ($users as $user) { ?>
                                                        <!--Begin::User Profil Area -->
                                                        <div id="userProfile-<?=$user['id']?>" class="col-xl-3">
                                                            <!--Begin::Portlet-->
                                                            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--skin-solid kt-bg-light-brand">
                                                                <div class="kt-portlet__head kt-portlet__head--noborder">
                                                                    <div class="kt-portlet__head-label">
                                                                        <h3 class="kt-portlet__head-title">
                                                                        </h3>
                                                                    </div>
                                                                    <div class="kt-portlet__head-toolbar">
                                                                        <a href="#" class="btn btn-icon" data-toggle="dropdown"><i class="flaticon-more-1 kt-font-brand"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <ul class="kt-nav">
                                                                                <li class="kt-nav__item">
                                                                                    <a href="user-profile.php?id=<?=$user['id']?>#overview" class="kt-nav__link"><i class="kt-nav__link-icon fal fa-ellipsis-h-alt"></i><span class="kt-nav__link-text">Özet</span></a>
                                                                                </li>
                                                                                <li class="kt-nav__item">
                                                                                    <a href="user-profile.php?id=<?=$user['id']?>#userProfile" class="kt-nav__link"><i class="kt-nav__link-icon fal fa-user"></i><span class="kt-nav__link-text">Kullanıcı Bilgileri</span></a>
                                                                                </li>
                                                                                <li class="kt-nav__item">
                                                                                    <a href="user-profile.php?id=<?=$user['id']?>#userPassword" class="kt-nav__link"><i class="kt-nav__link-icon fal fa-key"></i><span class="kt-nav__link-text">Şifre İşlemleri</span></a>
                                                                                </li>
                                                                                <li class="kt-nav__item">
                                                                                    <a href="user-profile.php?id=<?=$user['id']?>#userAvatar" class="kt-nav__link"><i class="kt-nav__link-icon fal fa-user-circle"></i><span class="kt-nav__link-text">Kullanıcı Resmi</span></a>
                                                                                </li>
                                                                                <li class="kt-nav__item">
                                                                                    <a href="user-profile.php?id=<?=$user['id']?>#userFirmPermissions" class="kt-nav__link"><i class="kt-nav__link-icon fas fa-user-cog"></i><span class="kt-nav__link-text">Şirket Yetkileri</span></a>
                                                                                </li>
                                                                                <li class="kt-nav__item">
                                                                                    <a href="user-profile.php?id=<?=$user['id']?>#userPermissions" class="kt-nav__link"><i class="kt-nav__link-icon fal fa-user-cog"></i><span class="kt-nav__link-text">Genel Yetkiler</span></a>
                                                                                </li>
                                                                                <li class="kt-nav__item">
                                                                                    <a href="user-profile.php?id=<?=$user['id']?>#userSignature" class="kt-nav__link"><i class="kt-nav__link-icon fa fa-signature"></i><span class="kt-nav__link-text">İmza</span></a>
                                                                                </li>

                                                                                <div class="dropdown-divider"></div>

                                                                                <? if ($userStatus==0) { ?>
                                                                                    <li class="kt-nav__item">
                                                                                        <a href="javascript:;" onclick="inactiveUser(<?=$user['id']?>)"class="kt-nav__link"><i class="kt-nav__link-icon flaticon2-settings"></i><span class="kt-nav__link-text">Aktife Çevir</span></a>
                                                                                    </li>
                                                                                <? } else if ($userStatus==1) {?>
                                                                                    <li class="kt-nav__item">
                                                                                        <a href="javascript:;" onclick="activeUser(<?=$user['id']?>)"class="kt-nav__link"><i class="kt-nav__link-icon flaticon2-settings"></i><span class="kt-nav__link-text">Pasife Çevir</span></a>
                                                                                    </li>
                                                                                <? } ?>
                                                                                <li class="kt-nav__item disabled">
                                                                                    <a href="#" class="kt-nav__link disabled"><i class="kt-nav__link-icon flaticon2-settings"></i><span class="kt-nav__link-text">Kullanıcıyı Sil</span></a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="kt-portlet__body">
                                                                    <!--begin::Widget -->
                                                                    <div class="kt-widget kt-widget--user-profile-2">
                                                                        <div class="kt-widget__head">
                                                                            <div class="kt-widget__media">
                                                                                <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest"><?=mb_substr($user['name'], 0, 1, 'UTF-8')?><?=mb_substr($user['surname'], 0, 1, 'UTF-8')?></div>
                                                                            </div>
                                                                            <div class="kt-widget__info">
                                                                                <span class="kt-widget__username"><?=$user['name'] . ' ' . $user['surname']?></span>
                                                                                <span class="kt-widget__desc"><?=$user['username']?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="kt-widget__body">
                                                                            <div class="kt-widget__section"></div>
                                                                            <div class="kt-widget__item">
                                                                                <div class="kt-widget__contact">
                                                                                    <span class="kt-widget__label">kullanıcı ID:</span>
                                                                                    <a href="javascript:;" class="kt-widget__data"><?=$user['id']?></a>
                                                                                </div>
                                                                                <div class="kt-widget__contact">
                                                                                    <span class="kt-widget__label">email:</span>
                                                                                    <? if (!empty($user['mail_address'])) { ?>
                                                                                    <a href="javascript:;" class="kt-widget__data"><?=$user['mail_address']?></a>
                                                                                    <? } else { ?>
                                                                                    <a href="javascript:;" class="kt-widget__data kt-font-danger">Email Tanımlı Değil</a>
                                                                                    <? } ?>
                                                                                </div>
                                                                                <div class="kt-widget__contact">
                                                                                    <span class="kt-widget__label">telefon:</span>
                                                                                    <? if (!empty($user['phone'])) { ?>
                                                                                        <a href="javascript:;" class="kt-widget__data"><?=$user['phone']?></a>
                                                                                    <? } else { ?>
                                                                                        <a href="javascript:;" class="kt-widget__data kt-font-danger">Telefon Tanımlı Değil</a>
                                                                                    <? } ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- <div class="kt-widget__footer"></div>-->
                                                                    </div>
                                                                    <!--end::Widget -->
                                                                </div>
                                                            </div>
                                                            <!--End::Portlet-->
                                                        </div>
                                                        <!--END::User Profil Area -->
                                                        <? } ?>
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
        <script src="assets/js/pages/user-list.js" type="text/javascript"></script>
		<!--end::Page Scripts -->

        <!--begin::foot-codes -->
        <?php require_once('includes/foot-codes.php'); ?>
        <!--end::foot-codes -->
	</body>

	<!-- end::Body -->
</html>