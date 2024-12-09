<?php
require_once('source/settings.php');
require_once('source/settings-login.php');
checkPermissionPage(array('superadmin', 'admin'));

$userId = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : 0;
$tabName = (isset($_GET['tabName']) && !empty($_GET['tabName'])) ? $_GET['tabName'] : 'profileOverview';

if ($userId > 0) {

    $user = GetSingleDataFromTable('users', $userId);
    if (empty($user)) {
        header('location:' . $siteUrl . 'user-list.php');
    }
    $user['avatar'] = (isset($user['avatar']) && !empty($user['avatar'])) ? $siteUrl . $setting['avatar_image_location'] . $user['avatar'] : $siteUrl . 'assets/img/avatar/default.jpg';
    $user['permission'] = GetUserPermissions($user['permissions']);
    $user['permissionOfFirm'] = GetUserPermissionsOfFirm($user);
    $user['firmPermission'] = GetUserFirmPermissions($user['firmpermissions']);
    $user['firmList'] = GetUserFirmList($user['firmpermissions']);
}

$firmList = GetListDataFromTable($firmParamTableName, '*', 'id');
?>
<!DOCTYPE html>
<html lang="tr">
<!-- begin::Head -->
<head>
    <?php require_once('includes/head-codes.php'); ?>
</head>
<!-- end::Head -->

<!-- begin::Body -->
<body style="background-image: url(<?= $CurrentFirm['bg'] ?>)"
      class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">
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
                            <div class="row" data-sticky-container>
                                <div class="col-lg-6 col-xl-3">
                                    <div class="kt-portlet sticky" data-sticky="true" data-margin-top="100px" data-sticky-for="1023" data-sticky-class="kt-sticky">






                                        <div class="kt-portlet__body kt-portlet__body--fit">



                                            <div class="kt-widget kt-widget--user-profile-1 kt-margin-20">
                                                <div class="kt-widget__head">
                                                    <div class="kt-widget__media">
                                                        <img src="<?= $CurrentUser['avatar'] ?>">
                                                    </div>
                                                    <div class="kt-widget__content">
                                                        <div class="kt-widget__section">
                                                            <a href="javascript:;" class="kt-widget__username">
                                                                <?= isset($user) ? $user['name'] : '' ?> <?= isset($user) ? $user['surname'] : '' ?><i class="flaticon2-correct kt-font-success"></i>
                                                            </a>
                                                            <span class="kt-widget__subtitle"><?= isset($user) ? $user['username'] : '' ?></span>

                                                        </div>
                                                        <div class="kt-widget__action">
                                                            <button type="button" class="btn btn-info btn-sm">chat</button>&nbsp;
                                                            <button type="button" class="btn btn-success btn-sm">takip et</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-widget__body">
                                                    <div class="kt-widget__content">
                                                        <div class="kt-widget__info">
                                                            <span class="kt-widget__label">kullanıcı ID:</span>
                                                            <a href="javascript:;" class="kt-widget__data"><?= isset($user) ? $user['id'] : 'TANIMSIZ' ?></a>
                                                        </div>
                                                        <div class="kt-widget__info">
                                                            <span class="kt-widget__label">email:</span>
                                                            <? if (!empty($user['mail_address'])) { ?>
                                                                <a href="javascript:;" class="kt-widget__data"><?=$user['mail_address']?></a>
                                                            <? } else { ?>
                                                                <a href="javascript:;" class="kt-widget__data kt-font-danger">Email Tanımlı Değil</a>
                                                            <? } ?>
                                                        </div>
                                                        <div class="kt-widget__info">
                                                            <span class="kt-widget__label">telefon:</span>
                                                            <? if (!empty($user['phone'])) { ?>
                                                                <a href="javascript:;" class="kt-widget__data"><?=$user['phone']?></a>
                                                            <? } else { ?>
                                                                <a href="javascript:;" class="kt-widget__data kt-font-danger">Telefon Tanımlı Değil</a>
                                                            <? } ?>
                                                        </div>
                                                        <div class="kt-widget__info">
                                                            <span class="kt-widget__label">doğum tarihi:</span>
                                                            <a href="javascript:;" class="kt-widget__data"><?= isset($user) ? DateFormat($user['birthday'],'d/m/Y') : 'TANIMSIZ' ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <ul class="kt-nav kt-nav--bold kt-nav--md-space kt-nav--v3 kt-margin-t-20 kt-margin-b-20 nav nav-tabs" role="tablist">
                                                <li class="kt-nav__item">
                                                    <a class="kt-nav__link" data-toggle="tab" href="#overview" role="tab" aria-selected="false">
                                                        <span class="kt-nav__link-icon"><i class="fal fa-ellipsis-h-alt"></i></span>
                                                        <span class="kt-nav__link-text">Özet</span>
                                                    </a>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a class="kt-nav__link" data-toggle="tab" href="#userProfile" role="tab" aria-selected="false">
                                                        <span class="kt-nav__link-icon"><i class="fal fa-user"></i></span>
                                                        <span class="kt-nav__link-text">Kullanıcı Bilgileri</span>
                                                    </a>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a class="kt-nav__link" data-toggle="tab" href="#userPassword" role="tab" aria-selected="false">
                                                        <span class="kt-nav__link-icon"><i class="fal fa-key"></i></span>
                                                        <span class="kt-nav__link-text">Şifre İşlemleri</span>
                                                    </a>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a class="kt-nav__link" data-toggle="tab" href="#userAvatar" role="tab" aria-selected="false">
                                                        <span class="kt-nav__link-icon"><i class="fal fa-user-circle"></i></span>
                                                        <span class="kt-nav__link-text">Kullanıcı Resmi</span>
                                                    </a>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a class="kt-nav__link" data-toggle="tab" href="#userFirmPermissions" role="tab" aria-selected="false">
                                                        <span class="kt-nav__link-icon"><i class="fas fa-user-cog"></i></span>
                                                        <span class="kt-nav__link-text">Şirket Yetkileri</span>
                                                    </a>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a class="kt-nav__link" data-toggle="tab" href="#userPermissions" role="tab" aria-selected="false">
                                                        <span class="kt-nav__link-icon"><i class="fal fa-user-cog"></i></span>
                                                        <span class="kt-nav__link-text">Genel Yetkiler</span>
                                                    </a>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a class="kt-nav__link" data-toggle="tab" href="#userSignature" role="tab" aria-selected="false">
                                                        <span class="kt-nav__link-icon"><i class="fa fa-signature"></i></span>
                                                        <span class="kt-nav__link-text">İmza</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-9">
                                        <div class="kt-portlet kt-portlet--tabs" >
                                            <div class="kt-portlet__body">
                                                <div class="tab-content">
                                                    <div class="tab-pane usersection" id="overview">
                                                    </div>
                                                    <div class="tab-pane usersection" id="userProfile">
                                                        <h5>Kullanıcı Bilgileri</h5>
                                                        <hr class="kt-padding-5">
                                                        <form class="kt-form" name="userProfile">
                                                            <input type="hidden" name="id" value="<?= $userId ?>"/>

                                                            <div class="form-group row">
                                                                <div class="col-lg-6">
                                                                    <label>Kullanıcı Adı</label>
                                                                    <input type="text" class="form-control" name="username" value="<?= isset($user['username']) ? $user['username'] : '' ?>" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-lg-4">
                                                                    <label>İsim</label>
                                                                    <input type="text" class="form-control" name="name" value="<?= isset($user['name']) ? $user['name'] : '' ?>" autocomplete="off">
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label>Soyisim</label>
                                                                    <input type="text" class="form-control" name="surname" value="<?= isset($user['surname']) ? $user['surname'] : '' ?>" autocomplete="off">
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label>Doğum Günü</label>
                                                                    <div class="input-group date">
                                                                        <input type="text" class="form-control" value="<?= DateFormat((isset($user['birthday']) ? $user['birthday'] : date('Y-m-d')), 'd/m/Y') ?>" id="birthdayDate" name="birthdayDate"/>
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><i class="la la-calendar"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-lg-6">
                                                                    <label>Email</label>
                                                                    <input type="email" class="form-control" name="email" value="<?= isset($user['mail_address']) ? $user['mail_address'] : '' ?>" autocomplete="off">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label>Telegram ChatId</label>
                                                                    <input type="text" class="form-control" name="telegram_chatid" value="<?= isset($user['telegram_chatid']) ? $user['telegram_chatid'] : '' ?>" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="kt-form__actions">
                                                                <button type="submit" class="btn btn-primary">Kaydet</button>
                                                                <button type="reset" class="btn btn-secondary">İptal</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane usersection" id="userPassword">
                                                        <h5>Şifre İşlemleri</h5>
                                                        <hr class="kt-padding-5">
                                                        <form class="kt-form" name="userPassword">
                                                            <div class="form-group form-group-last">
                                                                <div class="alert alert-secondary" role="alert">
                                                                    <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                                                                    <div class="alert-text">
                                                                        Güvenlik gerekçesiyle kullanıcının mevcut şifresini görüntüleyemiyorsunuz. Dilerseniz kullanıcıya yeni şifre tanımlayabilirsiniz.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="id" value="<?= $userId ?>"/>
                                                            <div class="form-group row">
                                                                <div class="col-lg-6">
                                                                    <label>Şifre</label>
                                                                    <input type="password" class="form-control" name="password" value="" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-lg-6">
                                                                    <label>Şifre Tekrar</label>
                                                                    <input type="password" class="form-control" name="password2" value="" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="kt-form__actions">
                                                                <button type="submit" class="btn btn-primary">Kaydet</button>
                                                                <button type="reset" class="btn btn-secondary">İptal</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane usersection" id="userAvatar">
                                                        <div class="kt-portlet kt-callout kt-callout--info kt-callout--diagonal-bg">
                                                            <div class="kt-portlet__body">
                                                                <div class="kt-callout__body">
                                                                    <div class="kt-callout__content">
                                                                        <h3 class="kt-callout__title">Kullanıcı Resmi</h3>
                                                                        <p class="kt-callout__desc">Yakında gelecek güncellemeyle sisteme eklenecek!</p>
                                                                    </div>
                                                                    <div class="kt-callout__action">
                                                                        <a href="javascript:;" class="btn btn-custom btn-bold btn-upper btn-font-sm  btn-info">Yakında</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane usersection" id="userFirmPermissions">
                                                        <h5>Firma Yetkileri</h5>
                                                        <hr class="kt-padding-5">
                                                        <form class="kt-form" name="userFirmPermissions">
                                                            <input type="hidden" name="id" value="<?= $userId ?>"/>
                                                            <div class="form-group form-group-marginless">
                                                                <label>Yetkilendirmek istediğiniz şirketleri seçiniz</label>
                                                                <div class="row">
                                                                    <? foreach ($firmList as $firm) { ?>
                                                                    <div class="col-lg">
                                                                        <label class="kt-option">
																		<span class="kt-option__control">
																			<span class="kt-radio">
                                                                                <input type="checkbox" name="firmPermission[]"  value="<?= $firm['id'] ?>" <?= (isset($user) && $user['firmPermission'][$firm['id']] == '1') ? ' checked' : ''; ?>>
																				<span></span>
																			</span>
																		</span>
                                                                            <span class="kt-option__label">
																			<span class="kt-option__head">
																				<span class="kt-option__title"><?= $firm['tag'] ?></span>
																				<span class="kt-option__focus"><img width="90px" src="assets/img/complogo/ocb-logo.png" title=""></span>
																			</span>
																			<span class="kt-option__body"><?= $firm['unvan'] ?></span>
																		</span>
                                                                        </label>
                                                                    </div>
                                                                    <? } ?>
                                                                </div>
                                                            </div>
                                                            <div class="kt-form__actions">
                                                                <button type="submit" class="btn btn-primary">Kaydet</button>
                                                                <button type="reset" class="btn btn-secondary">İptal</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane usersection" id="userPermissions">

                                                        <form class="kt-form" name="userPermissions">
                                                            <input type="hidden" name="id" value="<?= $userId ?>"/>


                                                                <h5>Genel Yetkiler</h5>
                                                                <hr class="kt-padding-5">



                                                                <? foreach ($PermissionList as $permission) { ?>
                                                                <div class="kt-portlet kt-portlet--bordered">
                                                                    <div class="kt-portlet__head">
                                                                        <div class="kt-portlet__head-label">
                                                                            <h3 class="kt-portlet__head-title"><?= $permission['cat_name'] ?></h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="kt-portlet__body">
                                                                        <div class="form-group form-group-marginless">
                                                                            <div class="row">
                                                                                <? foreach ($permission['fields'] as $pf) { ?>
                                                                                    <div class="col-lg">
                                                                                        <label class="kt-option">
                                                                            <span class="kt-option__control">
                                                                                <span class="kt-radio">
                                                                                    <input type="checkbox" value="1" name="<?php echo $pf[0] ?>" <?= (isset($user) && isset($user['permission'][$pf[0]]) && $user['permission'][$pf[0]] == '1') ? ' checked="checked"' : ''; ?>>
                                                                                    <span></span>
                                                                                </span>
                                                                            </span>
                                                                                            <span class="kt-option__label">
                                                                                <span class="kt-option__head">
                                                                                    <span class="kt-option__title"><?= $pf[1] ?></span>
                                                                                    <span class="kt-option__focus"></span>
                                                                                </span>
                                                                                <span class="kt-option__body"><?= $pf[2] ?></span>
                                                                            </span>
                                                                                        </label>
                                                                                    </div>
                                                                                <? } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <? } ?>






                                                            <h5>Firma Yetkileri</h5>
                                                            <hr class="kt-padding-5">


                                                            <div class="kt-portlet kt-portlet--tabs kt-portlet--bordered">
                                                                <div class="kt-portlet__head">
                                                                    <div class="kt-portlet__head-toolbar">
                                                                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-brand nav-tabs-line-2x nav-tabs-line-right nav-tabs-bold" role="tablist">
                                                                            <?php $userFirmCounter = 0;
                                                                            foreach ($user['firmList'] as $userFirm) { ?>
                                                                                <li class="nav-item m-tabs__item">
                                                                                    <a class="nav-link <?php echo $userFirmCounter == 0 ? ' active' : ''; ?>"
                                                                                       data-toggle="tab" href="#userPermissionFirm<?php echo $userFirm['id'] ?>"
                                                                                       role="tab" aria-selected="<?php echo $userFirmCounter == 0 ? 'true' : 'false'; ?>">
                                                                                        &nbsp;&nbsp;<?php echo $userFirm['tag'] ?>&nbsp;&nbsp;
                                                                                    </a>
                                                                                </li>
                                                                                <?php $userFirmCounter++;
                                                                            } ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="kt-portlet__body">
                                                                    <div class="tab-content">
                                                                        <?php $userFirmCounter = 0;
                                                                        foreach ($user['firmList'] as $userFirm) { ?>
                                                                            <div class="tab-pane <? if ($userFirmCounter==0) { echo ' active'; }?> onur" id="userPermissionFirm<?php echo $userFirm['id'] ?>" role="tabpanel">
                                                                                <h6><?php echo $userFirm['unvan'] ?> (<?php echo $userFirm['tag'] ?>) Yetkileri</h6>
                                                                                <?php foreach ($PermissionListOfFirm as $permissionOfFirm) { ?>
                                                                                    <label class="pt-lg-4"><h5><?= $permissionOfFirm['cat_name'] ?></h5></label>
                                                                                    <div class="row equal">
                                                                                        <? foreach ($permissionOfFirm['fields'] as $pf) { ?>
                                                                                            <div class="col-lg-4">
                                                                                                <label class="kt-option">
                                                                                                    <span class="kt-option__control">
                                                                                                        <span class="kt-radio">
                                                                                                            <input type="checkbox" value="1" name="<?php echo $pf[0] ?>_<?php echo $userFirm['id'] ?>" <?= (isset($user) && isset($user['permissionOfFirm'][$userFirm['id']][$pf[0]]) && $user['permissionOfFirm'][$userFirm['id']][$pf[0]] == '1') ? ' checked="checked"' : ''; ?>>
                                                                                                            <span></span>
                                                                                                        </span>
                                                                                                    </span>
                                                                                                    <span class="kt-option__label">
                                                                                                        <span class="kt-option__head">
                                                                                                            <span class="kt-option__title"><?= $pf[1] ?></span>
                                                                                                            <span class="kt-option__focus"></span>
                                                                                                        </span>
                                                                                                        <span class="kt-option__body"><?= $pf[2] ?></span>
                                                                                                    </span>
                                                                                                </label>
                                                                                            </div>
                                                                                        <? } ?>
                                                                                    </div>
                                                                                    <div class="kt-separator kt-separator--fit"></div>
                                                                                <? } ?>
                                                                            </div>
                                                                            <?php $userFirmCounter++;
                                                                        } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="kt-form__actions">
                                                                <button type="submit" class="btn btn-primary">Kaydet</button>
                                                                <button type="reset" class="btn btn-secondary">İptal</button>
                                                            </div>
                                                        </form></div>
                                                    <div class="tab-pane usersection" id="userSignature">
                                                        <div class="kt-portlet kt-callout kt-callout--info kt-callout--diagonal-bg">
                                                            <div class="kt-portlet__body">
                                                                <div class="kt-callout__body">
                                                                    <div class="kt-callout__content">
                                                                        <h3 class="kt-callout__title">Mail İmza</h3>
                                                                        <p class="kt-callout__desc">Yakında gelecek güncellemeyle sisteme eklenecek!</p>
                                                                    </div>
                                                                    <div class="kt-callout__action">
                                                                        <a href="javascript:;" class="btn btn-custom btn-bold btn-upper btn-font-sm  btn-info">Yakında</a>
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

                        <!-- end:: Content -->




                        <? /*


                        <!-- begin:: Content -->
                        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                            <!--Begin::Row-->
                            <div class="row">
                                <div class="col-xl-2">
                                    <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height">

                                        <div class="m-portlet__body pt-lg-4 text-center">
                                            <div class="row">
                                                <div class="col-md-12 mb-lg-3">
                                                    <img src="<?= $CurrentUser['avatar'] ?>" height="150px"
                                                         width="150px">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 m--space-30 m--font-bolder">
                                                    <?= isset($user) ? $user['name'] : '' ?> <?= isset($user) ? $user['surname'] : '' ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-10">

                                    <div class="m-portlet m-portlet--tabs">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text">
                                                        <?= (isset($user) ? 'Kullanıcı Düzenle' : 'Kullanıcı Ekle') ?>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="m-portlet__head-tools">
                                                <ul class="nav nav-tabs m-tabs-line m-tabs-line--right" role="tablist">
                                                    <li class="nav-item m-tabs__item">
                                                        <a class="nav-link m-tabs__link active" data-toggle="tab"
                                                           href="#userProfile" role="tab" aria-selected="true">
                                                            <i class="flaticon-user-ok"></i>
                                                            Profil Bilgileri
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-tabs__item">
                                                        <a class="nav-link m-tabs__link" data-toggle="tab"
                                                           href="#userAvatar" role="tab" aria-selected="false">
                                                            <i class="flaticon-profile-1"></i>
                                                            Profil Resmi
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-tabs__item">
                                                        <a class="nav-link m-tabs__link" data-toggle="tab"
                                                           href="#userPassword" role="tab" aria-selected="false">
                                                            <i class="flaticon-cogwheel-2"></i>
                                                            Şifre İşlemleri
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-tabs__item">
                                                        <a class="nav-link m-tabs__link" data-toggle="tab"
                                                           href="#userPermissions" role="tab" aria-selected="false">
                                                            <i class="flaticon-user-settings"></i>
                                                            Yetkiler
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-tabs__item">
                                                        <a class="nav-link m-tabs__link" data-toggle="tab"
                                                           href="#userFirmPermissions" role="tab" aria-selected="false">
                                                            <i class="flaticon-user-settings"></i>
                                                            Şirketler
                                                        </a>
                                                    </li>
                                                    <li class="nav-item m-tabs__item">
                                                        <a class="nav-link m-tabs__link" data-toggle="tab"
                                                           href="#userSignature" role="tab" aria-selected="false">
                                                            <i class="flaticon-technology-1"></i>
                                                            İmza
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="userProfile" role="tabpanel">
                                                    <form name="userProfile" role="form"
                                                          class="m-form m-form--fit m-form--label-align-right">
                                                        <input type="hidden" name="id" value="<?= $userId ?>"/>
                                                        <div class="form-group m-form__group row">
                                                            <div class="col-lg-6">
                                                                <label>
                                                                    Kullanıcı Adı
                                                                </label>
                                                                <input type="text"
                                                                       class="form-control m-input m-input--solid"
                                                                       name="username"
                                                                       value="<?= isset($user['username']) ? $user['username'] : '' ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group m-form__group row">
                                                            <div class="col-lg-6">
                                                                <label>
                                                                    İsim
                                                                </label>
                                                                <input type="text"
                                                                       class="form-control m-input m-input--solid"
                                                                       name="name"
                                                                       value="<?= isset($user['name']) ? $user['name'] : '' ?>">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="">
                                                                    Soyisim
                                                                </label>
                                                                <input type="text"
                                                                       class="form-control m-input m-input--solid"
                                                                       name="surname"
                                                                       value="<?= isset($user['surname']) ? $user['surname'] : '' ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group m-form__group row">
                                                            <div class="col-lg-6">
                                                                <label>
                                                                    Email
                                                                </label>
                                                                <input type="email"
                                                                       class="form-control m-input m-input--solid"
                                                                       name="email"
                                                                       value="<?= isset($user['email']) ? $user['email'] : '' ?>">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>
                                                                    Doğum Günü
                                                                </label>
                                                                <div class="input-group date">
                                                                    <input type="text"
                                                                           class="form-control m-input m-input--solid"
                                                                           value="<?= DateFormat((isset($user['birthday']) ? $user['birthday'] : date('Y-m-d')), 'd/m/Y') ?>"
                                                                           id="birthdayDate" name="birthdayDate"/>
                                                                    <div class="input-group-append">
																	<span class="input-group-text">
																		<i class="la la-calendar"></i>
																	</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="m-portlet__foot m-portlet__foot--fit">
                                                            <div class="m-form__actions">
                                                                <button type="submit" class="btn btn-success">
                                                                    Kaydet
                                                                </button>
                                                                <button type="reset" class="btn btn-secondary">
                                                                    İptal
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="tab-pane" id="userAvatar" role="tabpanel">
                                                    <div class="m-dropzone dropzone"
                                                         action="inc/api/dropzone/upload.php" id="m-dropzone-one">
                                                        <div class="m-dropzone__msg dz-message needsclick">
                                                            <h3 class="m-dropzone__msg-title">
                                                                Drop files here or click to upload.
                                                            </h3>
                                                            <span class="m-dropzone__msg-desc">
															This is just a demo dropzone. Selected files are
															<strong>
																not
															</strong>
															actually uploaded.
														</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="userPassword" role="tabpanel">
                                                    <form name="userPassword" role="form"
                                                          class="m-form m-form--fit m-form--label-align-right">
                                                        <div class="alert m-alert m-alert--default" role="alert">
                                                            Güvenlik gerekçesiyle kullanıcının mevcut şifresini
                                                            görüntüleyemiyorsunuz. Dilerseniz kullanıcıya yeni şifre
                                                            tanımlayabilirsiniz.
                                                        </div>
                                                        <input type="hidden" name="id" value="<?= $userId ?>"/>
                                                        <div class="form-group m-form__group row">
                                                            <div class="col-lg-6">
                                                                <label>
                                                                    Şifre
                                                                </label>
                                                                <input type="password"
                                                                       class="form-control m-input m-input--solid"
                                                                       name="password">
                                                            </div>
                                                        </div>

                                                        <div class="form-group m-form__group row">
                                                            <div class="col-lg-6">
                                                                <label>
                                                                    Şifre Tekrar
                                                                </label>
                                                                <input type="password"
                                                                       class="form-control m-input m-input--solid"
                                                                       name="password2">
                                                            </div>
                                                        </div>

                                                        <div class="m-portlet__foot m-portlet__foot--fit">
                                                            <div class="m-form__actions">
                                                                <button type="submit" class="btn btn-success">
                                                                    Kaydet
                                                                </button>
                                                                <button type="reset" class="btn btn-secondary">
                                                                    İptal
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="tab-pane" id="userPermissions" role="tabpanel">
                                                    <form name="userPermissions" role="form"
                                                          class="m-form m-form--fit m-form--label-align-right">
                                                        <input type="hidden" name="id" value="<?= $userId ?>"/>
                                                        <h3>Genel Yekiler</h3>
                                                        <? foreach ($PermissionList as $permission) { ?>
                                                            <label class="pt-lg-4">
                                                                <h5><?= $permission['cat_name'] ?></h5>
                                                            </label>
                                                            <div class="row equal">
                                                                <? foreach ($permission['fields'] as $pf) { ?>
                                                                    <? if ($pf[0] == 'empty') { ?>
                                                                        <div class="col-md-6 col-lg-4"
                                                                             style="height: 40px">
                                                                            <div class="form-group">
                                                                                <label class="uniform-inline">
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    <? } else { ?>

                                                                        <div class="col-md-3 mb-4">

                                                                            <label class="m-option">
																<span class="m-option__control">
																	<span class="m-checkbox m-checkbox--brand m-checkbox--check-bold">
																		<input type="checkbox" name="<?php echo $pf[0] ?>"
                                                                               value="1" <?= (isset($user) && isset($user['permission'][$pf[0]]) && $user['permission'][$pf[0]] == '1') ? ' checked="checked"' : ''; ?>>
																		<span></span>
																	</span>
																</span>
                                                                                <span class="m-option__label">
																	<span class="m-option__head">
																		<span class="m-option__title">
																			<?= $pf[1] ?>
																		</span>
																	</span>
                                                                                                            <br/>
																	<span class="m-option__body small">
																		<?= $pf[2] ?>
																	</span>
																</span>
                                                                            </label>
                                                                        </div>
                                                                    <? } ?>
                                                                <? } ?>
                                                            </div>
                                                            <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space"></div>
                                                        <? } ?>

                                                        <h3>Firma Yetkileri</h3>
                                                        <div class="alert alert-info">
                                                            <span><i class="fa fa-info-circle"></i>&nbsp;Kullanıcıya farklı bir şirkette yetki verdikten sonra, buradaki yetkilerini düzenleyebilmek için sayfayı yenileyiniz.</span>
                                                        </div>
                                                        <div class="m-portlet m-portlet--tabs">
                                                            <div class="m-portlet__head">
                                                                <div class="m-portlet__head-tools">
                                                                    <ul class="nav nav-tabs m-tabs-line m-tabs-line--right"
                                                                        role="tablist">
                                                                        <?php $userFirmCounter = 0;
                                                                        foreach ($user['firmList'] as $userFirm) { ?>
                                                                            <li class="nav-item m-tabs__item">
                                                                                <a class="nav-link m-tabs__link<?php echo $userFirmCounter == 0 ? ' active' : ''; ?>"
                                                                                   data-toggle="tab"
                                                                                   href="#userPermissionFirm<?php echo $userFirm['id'] ?>"
                                                                                   role="tab"
                                                                                   aria-selected="<?php echo $userFirmCounter == 0 ? 'true' : 'false'; ?>">
                                                                                    <img width="16px"
                                                                                         src="<?= $firm['logo'] ?>"
                                                                                         title=""/>
                                                                                    <?php echo $userFirm['tag'] ?>
                                                                                </a>
                                                                            </li>
                                                                            <?php $userFirmCounter++;
                                                                        } ?>
                                                                    </ul>
                                                                </div>
                                                                <div class="m-portlet__body">
                                                                    <div class="tab-content">
                                                                        <!-- Site dön-->
                                                                        <?php $userFirmCounter = 0;
                                                                        foreach ($user['firmList'] as $userFirm) { ?>
                                                                            <div class="tab-pane<?php echo $userFirmCounter == 0 ? ' active' : ''; ?>"
                                                                                 id="userPermissionFirm<?php echo $userFirm['id'] ?>"
                                                                                 role="tabpanel">
                                                                                <h4><?php echo $userFirm['unvan'] ?>
                                                                                    (<?php echo $userFirm['tag'] ?>)
                                                                                    Yetkileri</h4>
                                                                                <?php foreach ($PermissionListOfFirm as $permissionOfFirm) { ?>
                                                                                    <label class="pt-lg-4">
                                                                                        <h5><?= $permissionOfFirm['cat_name'] ?></h5>
                                                                                    </label>
                                                                                    <div class="row equal">
                                                                                        <? foreach ($permissionOfFirm['fields'] as $pf) { ?>
                                                                                            <? if ($pf[0] == 'empty') { ?>
                                                                                                <div class="col-md-6 col-lg-4"
                                                                                                     style="height: 40px">
                                                                                                    <div class="form-group">
                                                                                                        <label class="uniform-inline">
                                                                                                        </label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            <? } else { ?>

                                                                                                <div class="col-md-3 mb-4">

                                                                                                    <label class="m-option">
																<span class="m-option__control">
																	<span class="m-checkbox m-checkbox--brand m-checkbox--check-bold">
																		<input type="checkbox" name="<?php echo $pf[0] ?>_<?php echo $userFirm['id'] ?>"
                                                                               value="1" <?= (isset($user) && isset($user['permissionOfFirm'][$userFirm['id']][$pf[0]]) && $user['permissionOfFirm'][$userFirm['id']][$pf[0]] == '1') ? ' checked="checked"' : ''; ?>>
																		<span></span>
																	</span>
																</span>
                                                                                                        <span class="m-option__label">
																	<span class="m-option__head">
																		<span class="m-option__title">
																			<?= $pf[1] ?>
																		</span>
																	</span>
                                                                                                            <br/>
																	<span class="m-option__body small">
																		<?= $pf[2] ?>
																	</span>
																</span>
                                                                                                    </label>
                                                                                                </div>
                                                                                            <? } ?>
                                                                                        <? } ?>
                                                                                    </div>
                                                                                    <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space"></div>
                                                                                <? } ?>
                                                                            </div>

                                                                            <?php $userFirmCounter++;
                                                                        } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="m-portlet__foot m-portlet__foot--fit">
                                                            <div class="m-form__actions">
                                                                <button type="submit" class="btn btn-success">
                                                                    Kaydet
                                                                </button>
                                                                <button type="reset" class="btn btn-secondary">
                                                                    İptal
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="tab-pane" id="userFirmPermissions" role="tabpanel">
                                                    <form name="userFirmPermissions" role="form"
                                                          class="m-form m-form--fit m-form--label-align-right">
                                                        <input type="hidden" name="id" value="<?= $userId ?>"/>

                                                        <label class="pt-lg-4">
                                                            <h5>Firma Yetkileri</h5>
                                                        </label>
                                                        <div class="row equal">
                                                            <? foreach ($firmList as $firm) { ?>
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="m-option">
																<span class="m-option__control">
																	<span class="m-checkbox m-checkbox--brand m-checkbox--check-bold">
																		<input type="checkbox" name="firmPermission[]"
                                                                               value="<?= $firm['id'] ?>" <?= (isset($user) && $user['firmPermission'][$firm['id']] == '1') ? ' checked="checked"' : ''; ?>>
																		<span></span>
																	</span>
																</span>
                                                                        <span class="m-option__label">
																	<span class="m-option__head">
																		<span class="m-option__title">
																			<?= $firm['tag'] ?>
																		</span>
																	</span>
																	<span class="m-option__body">
																		<?= $firm['unvan'] ?>
																	</span>
																</span>
                                                                    </label>
                                                                </div>
                                                            <? } ?>
                                                        </div>
                                                        <div class="m-portlet__foot m-portlet__foot--fit">
                                                            <div class="m-form__actions">
                                                                <button type="submit" class="btn btn-success">
                                                                    Kaydet
                                                                </button>
                                                                <button type="reset" class="btn btn-secondary">
                                                                    İptal
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="userSignature" role="tabpanel">
                                                    qqqqqqqq
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <!--End::Row-->
                        </div>
                        <!-- end:: Content -->

 */ ?>
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
<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->

<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/user-profile.js" type="text/javascript"></script>
<!--end::Page Scripts -->

<!--begin::foot-codes -->
<script>

    // sayfa hash yonlendirme
    var url = window.location.href;
    var activeTab = url.substring(url.indexOf("#") + 1);
    $(".usersection").removeClass("active in");
    $("#" + activeTab).addClass("active in");
    $('a[href="#'+ activeTab +'"]').parent().addClass("active");







    // navigasyon active/passive
    $(".kt-nav__item").on("click", function(){
        $(".kt-nav__item").removeClass("active").addClass('onur');
        $(this).addClass("active");
    });
</script>
<?php require_once('includes/foot-codes.php'); ?>
<!--end::foot-codes -->
</body>

<!-- end::Body -->
</html>