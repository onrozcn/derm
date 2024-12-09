<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
<div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
	<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
		<ul class="kt-menu__nav ">



            <li class="kt-menu__item kt-menu__item--rel <?menuTabCheck($tabPanel)?>">
                <a href="index.php" class="kt-menu__link"><span class="kt-menu__link-text">Panel</span></a>
            </li>

            <? if(checkPermission(TabPermissionCheck($tabHammadde))) { ?>
                <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--rel <?menuTabCheck($tabHammadde)?>" data-ktmenu-submenu-toggle="click">
                    <a href="#" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Hammadde</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                        <ul class="kt-menu__subnav">
                            <? foreach($tabHammadde as $data){ ?>
                                <? if(checkPermission(TabItemPermissionCheck($data['permission']))) { ?>
                                    <li class="kt-menu__item <?menuItemCheck($data)?>"><a href="<?=$data['link']?>" class="kt-menu__link"><i class="kt-menu__link-icon <?=$data['icon']?>"></i><span class="kt-menu__link-text"><?=$data['title']?></span></a></li>
                                <? } ?>
                            <? } ?>
                        </ul>
                    </div>
                </li>
            <? } ?>
            <? if(checkPermission(TabPermissionCheck($tabOdemeler))) { ?>
                <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--rel <?menuTabCheck($tabOdemeler)?>" data-ktmenu-submenu-toggle="click">
                    <a href="#" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Ödemeler</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                        <ul class="kt-menu__subnav">
                            <? foreach($tabOdemeler as $data){ ?>
                                <? if(checkPermission(TabItemPermissionCheck($data['permission']))) { ?>
                                    <li class="kt-menu__item <?menuItemCheck($data)?>"><a href="<?=$data['link']?>" class="kt-menu__link"><i class="kt-menu__link-icon <?=$data['icon']?>"></i><span class="kt-menu__link-text"><?=$data['title']?></span></a></li>
                                <? } ?>
                            <? } ?>
                        </ul>
                    </div>
                </li>
            <? } ?>

            <? if(checkPermission(TabPermissionCheck($tabDepo))) { ?>
                <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--rel <?menuTabCheck($tabDepo)?>" data-ktmenu-submenu-toggle="click">
                    <a href="#" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Depo</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                        <ul class="kt-menu__subnav">
                            <? foreach($tabDepo as $data){ ?>
                                <? if(checkPermission(TabItemPermissionCheck($data['permission']))) { ?>
                                    <li class="kt-menu__item <?menuItemCheck($data)?>"><a href="<?=$data['link']?>" class="kt-menu__link"><i class="kt-menu__link-icon <?=$data['icon']?>"></i><span class="kt-menu__link-text"><?=$data['title']?></span></a></li>
                                <? } ?>
                            <? } ?>
                        </ul>
                    </div>
                </li>
            <? } ?>

            <? if(checkPermission(TabPermissionCheck($tabGuvenlik))) { ?>
                <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--rel <?menuTabCheck($tabGuvenlik)?>" data-ktmenu-submenu-toggle="click">
                    <a href="#" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Güvenlik</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                        <ul class="kt-menu__subnav">
                            <? foreach($tabGuvenlik as $data){ ?>
                                <? if(checkPermission(TabItemPermissionCheck($data['permission']))) { ?>
                                    <li class="kt-menu__item <?menuItemCheck($data)?>"><a href="<?=$data['link']?>" class="kt-menu__link"><i class="kt-menu__link-icon <?=$data['icon']?>"></i><span class="kt-menu__link-text"><?=$data['title']?></span></a></li>
                                <? } ?>
                            <? } ?>
                        </ul>
                    </div>
                </li>
            <? } ?>

            <? if(checkPermission(TabPermissionCheck($tabAyarlar))) { ?>
            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel <?menuTabCheck($tabAyarlar)?>" data-ktmenu-submenu-toggle="click">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Ayarlar</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">

                        <? if ( checkPermission(TabItemPermissionCheck($tabAyarlar['user-list']['permission'])) || checkPermission(TabItemPermissionCheck($tabAyarlar['user-profile']['permission'])) ) { ?>
                        <li class="kt-menu__item kt-menu__item--submenu <?menuItemCheck($tabAyarlar['user-list'])?> <?menuItemCheck($tabAyarlar['user-profile'])?>" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-start-up"></i><span class="kt-menu__link-text">Kullanıcılar</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                <ul class="kt-menu__subnav">
                                    <? if(checkPermission(TabItemPermissionCheck($tabAyarlar['user-list']['permission']))) { ?>
                                    <li class="kt-menu__item <?menuItemCheck($tabAyarlar['user-list'])?>"><a href="<?=$tabAyarlar['user-list']['link']?>" class="kt-menu__link "><i class="kt-menu__link-icon <?=$tabAyarlar['user-list']['icon']?>"><span></span></i><span class="kt-menu__link-text"><?=$tabAyarlar['user-list']['title']?></span></a></li>
                                    <? } ?>
                                    <? if(checkPermission(TabItemPermissionCheck($tabAyarlar['user-profile']['permission']))) { ?>
                                    <li class="kt-menu__item <?menuItemCheck($tabAyarlar['user-profile'])?>"><a href="<?=$tabAyarlar['user-profile']['link']?>" class="kt-menu__link "><i class="kt-menu__link-icon <?=$tabAyarlar['user-profile']['icon']?>"><span></span></i><span class="kt-menu__link-text"><?=$tabAyarlar['user-profile']['title']?></span></a></li>
                                    <? } ?>
                                </ul>
                            </div>
                        </li>
                        <? } ?>
                        <? if(checkPermission(TabItemPermissionCheck($tabAyarlar['parameters']['permission']))) { ?>
                        <li class="kt-menu__item <?menuItemCheck($tabAyarlar['parameters'])?>"><a href="<?=$tabAyarlar['parameters']['link']?>" class="kt-menu__link"><i class="kt-menu__link-icon <?=$tabAyarlar['parameters']['icon']?>"></i><span class="kt-menu__link-text"><?=$tabAyarlar['parameters']['title']?></span></a></li>
                        <? } ?>
                        <? if(checkPermission(TabItemPermissionCheck($tabAyarlar['wid-imza']['permission']))) { ?>
                        <li class="kt-menu__item <?menuItemCheck($tabAyarlar['wid-imza'])?>"><a href="<?=$tabAyarlar['wid-imza']['link']?>" class="kt-menu__link"><i class="kt-menu__link-icon <?=$tabAyarlar['wid-imza']['icon']?>"></i><span class="kt-menu__link-text"><?=$tabAyarlar['wid-imza']['title']?></span></a></li>
                        <? } ?>
                        <? if(checkPermission(TabItemPermissionCheck($tabAyarlar['backup']['permission']))) { ?>
                        <li class="kt-menu__item <?menuItemCheck($tabAyarlar['backup'])?>"><a href="<?=$tabAyarlar['backup']['link']?>" class="kt-menu__link"><i class="kt-menu__link-icon <?=$tabAyarlar['backup']['icon']?>"></i><span class="kt-menu__link-text"><?=$tabAyarlar['backup']['title']?></span></a></li>
                        <? } ?>


                        <? if(checkPermission(TabItemPermissionCheck($tabAyarlar['settings']['permission']))) { ?>
                        <li class="kt-menu__item kt-menu__item--submenu <?menuItemCheck($tabAyarlar['settings'])?> <?menuItemCheck($tabAyarlar['settings'])?>" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-start-up"></i><span class="kt-menu__link-text"><?=$tabAyarlar['settings']['title']?></span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
                                <ul class="kt-menu__subnav">
                                    <? foreach ($settings_model as $key => $value) { if (!$value['hidden']) { ?>
                                        <li class="kt-menu__item"><a href="settings.php?id=<?=$key?>" class="kt-menu__link "><i class="kt-menu__link-icon <?=$value['icon']?>"><span></span></i><span class="kt-menu__link-text"><?=$value['title']?></span></a></li>
                                    <? } } ?>
                                </ul>
                            </div>
                        </li>
                        <? } ?>













                    </ul>
                </div>
            </li>
            <? } ?>

            <? if(checkPermission(array('superadmin', 'admin'))) { ?>
            <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--rel <?menuTabCheck($tabTools)?>" data-ktmenu-submenu-toggle="hover">
                <a href="#" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Tools</span><i class="kt-menu__hor-arrow la la-angle-down"></i><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                    <ul class="kt-menu__subnav">
                        <? foreach($tabTools as $data){ ?>
                            <? if(checkPermission(array('superadmin', 'admin', $data['permission']))) { ?>
                            <li class="kt-menu__item <?menuItemCheck($data)?>"><a href="<?=$data['link']?>" class="kt-menu__link"><i class="kt-menu__link-icon <?=$data['icon']?>"></i><span class="kt-menu__link-text"><?=$data['title']?></span></a></li>
                            <? } ?>
                        <? } ?>
                    </ul>
                </div>
            </li>
            <? } ?>


		</ul>
	</div>
</div>