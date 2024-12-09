<?php
$activetab  = ' kt-menu__item--here ';
$activemenu = ' kt-menu__item--active ';
$checkactive = basename($_SERVER['REQUEST_URI'], '?' . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
$activeurl = explode('?', $checkactive)[0];
/*
if (strpos($checkactive, '.php') !== true) {
   $checkactive = 'index.php';
}
*/

$qs = (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '');

$pageTitle = '';
$pageBreadcrumbs = '';

function menuActiveCheck($tab) {
	global $checkactive, $activetab, $activeurl, $qs, $pageTitle, $pageBreadcrumbs;
	foreach($tab as $t){
		if($checkactive==$t['link'] . $qs || (isset($t['subs']) && in_array($activeurl, $t['subs']))){
			$pageTitle = $t['title'];
			$pageBreadcrumbs = '<a href="' . $t['link']  . '" class="kt-subheader__breadcrumbs-link">' . $t['title']  . '</a> <span class="kt-hidden kt-subheader__breadcrumbs-separator"></span>';
		}
	}
}

function menuTabCheck($tab) {
	global $checkactive, $activetab, $activeurl, $qs, $pageTitle;
	foreach($tab as $t){
		if($checkactive==$t['link'] . $qs || (isset($t['subs']) && in_array($activeurl, $t['subs']))){
			echo $activetab;
			$pageTitle = $t['title'];
		}
	}
}

function menuItemCheck($menu) {
	global $checkactive, $activemenu, $activeurl, $qs, $pageTitle;
	/*if(isset($menu['subs'])){
		print_r($menu);
		echo $activemenu;
	}*/
	if ($checkactive == $menu['link'] . $qs || (isset($menu['subs']) && in_array($activeurl, $menu['subs']))) {
		echo $activemenu;
	} 
}

function TabPermissionCheck($tab) {
    foreach ($tab as $d) {
        foreach ($d['permission'] as $key => $value) {
            $tabPerms[] =  $value;
        }
    }
    return array_unique($tabPerms);
}

function TabItemPermissionCheck($item) {
    foreach ($item as $key => $value) {
        $tabItemPerms[] =  $value;
    }
    return array_unique($tabItemPerms);
}

function ParamCatPermissionCheck($cat) {
    foreach ($cat as $d) {
        foreach ($d['permission'] as $key => $value) {
            $paramCatPerms[] =  $value;
        }
    }
    return array_unique($paramCatPerms);
}

function ParamItemPermissionCheck($item) {
    foreach ($item as $key => $value) {
        $paramItemPerms[] =  $value;
    }
    return array_unique($paramItemPerms);
}

$tabPanel = array(
	array(
		'link'  => 'index.php',
		'title' => 'Anasayfa',
		'icon'  => 'fal fa-tachometer-alt',
		'breadcrumbs'  => 'onur breadcrumbs',
        'permission'  => '',
		'subs' => array('derm'),
	),
);

$tabHammadde = array(
    array(
        'link'  => 'hamGiris.php',
        'title' => 'Hammadde Giriş',
        'icon'  => 'fal fa-cube',
        'permission'  => array('superadmin', 'admin', 'hamGirisPageView'),
    ),
);


$tabOdemeler = array(
    array(
        'link'  => 'odmOdemeTakip.php',
        'title' => 'Ödeme Takip',
        'icon'  => 'fad fa-money-bill-alt',
        'permission'  => array('superadmin', 'admin', 'odmOdemeTakipPageView'),
    ),
    array(
        'link'  => 'odmOdemeTakip.php?pm=odemeKaydetModal',
        'title' => 'Ödeme Ekle',
        'icon'  => 'fal fa-money-bill-alt',
        'permission'  => array('superadmin', 'admin', 'odmOdemeTakipAction'),
    ),
);


$tabDepo = array(
    array(
        'link'  => 'depYakit.php',
        'title' => 'Yakıt',
        'icon'  => 'fad fa-gas-pump',
        'permission'  => array('superadmin', 'admin', 'depYakitPageView'),
    ),
    array(
        'link'  => 'depYakit.php?pt=yakitCikisTab&pm=yakitCikisModal',
        'title' => 'Yakıt Çıkış Ekle',
        'icon'  => 'fal fa-gas-pump',
        'permission'  => array('superadmin', 'admin', 'depYakitCikisAdd'),
    ),
    array(
        'link'  => 'depYakit.php?pt=yakitGirisTab&pm=yakitGirisModal',
        'title' => 'Yakıt Giriş Ekle',
        'icon'  => 'fal fa-gas-pump',
        'permission'  => array('superadmin', 'admin', 'depYakitGirisAdd'),
    ),
    array(
        'link'  => 'depRaporCikis.php',
        'title' => 'Yakıt Çıkış Rapor',
        'icon'  => 'fal fa-file-chart-column',
        'permission'  => array('superadmin', 'admin', 'depRaporCikisPageView'),
    ),
);

$tabGuvenlik = array(
    array(
        'link'  => 'gvnGirisCikis.php',
        'title' => 'Giriş Çıkış',
        'icon'  => 'fad fa-garage-car',
        'permission'  => array('superadmin', 'admin', 'gvnAracGiriscikisPage'),
    ),
);

$tabAyarlar = array(
    'user-list' => array(
        'link'  => 'user-list.php',
        'title' => 'Kullanıcı Listesi',
        'icon'  => 'fal fa-users',
        'permission'  => array('superadmin', 'admin'),
    ),
    'user-profile' => array(
        'link'  => 'user-profile.php',
        'title' => 'Kullanıcı Ekle',
        'icon'  => 'fal fa-user-plus',
        'permission'  => array('superadmin', 'admin'),
    ),
    'parameters' => array(
        'link'  => 'parameters.php',
        'title' => 'Parametreler',
        'icon'  => 'fal fa-network-wired',
        'subs' => array('parameter.php'),
        'permission'  => array('superadmin', 'admin', 'odmParameterManage', 'hamParameterManage', 'depParameterManage'),
    ),
    'wid-imza' => array(
        'link'  => 'wid-imza.php',
        'title' => 'İmza',
        'icon'  => 'fal fa-signature',
        'permission'  => array('superadmin', 'admin'),
    ),
    'backup' => array(
        'link'  => 'backup.php',
        'title' => 'Yedekleme',
        'icon'  => 'fal fa-hdd',
        'permission'  => array('superadmin', 'admin'),
    ),
    'settings' => array(
        'link'  => 'settings.php',
        'title' => 'Ayarlar',
        'icon'  => 'fal fa-cogs',
        'permission'  => array('superadmin', 'admin'),
    ),
);

$tabTools = array(
	array(
		'link'  => '../metronic.derm/',
		'title' => 'ORG Tema',
		'icon'  => 'flaticon-support',
        'permission'  => 'admin',
	),
);


// title gelmesi için
menuActiveCheck($tabPanel);
menuActiveCheck($tabHammadde);
menuActiveCheck($tabOdemeler);
menuActiveCheck($tabDepo);
menuActiveCheck($tabGuvenlik);
menuActiveCheck($tabAyarlar);
menuActiveCheck($tabTools);