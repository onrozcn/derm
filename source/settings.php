<?php
//BEGIN page genarated tim
$gentime = microtime();
$gentime = explode(' ', $gentime);
$gentime = $gentime[1] + $gentime[0];
$genstart = $gentime;
//FOOTER side is in includes/footer.php
//END page genarated time

$sqlHost = 'localhost';
$sqlUser = 'root';
$sqlPass = 'secret';
$sqlName = 'derm';
$sqlPort = '3306';

$localorweb = 0; // 0 local - 1 web
$siteSSL = 0; // 0 pasif - 1 aktif

//BEGIN mysql connection web
if ($localorweb==1) {
    $connectionLocal = array(
        'host' => 'localhost',
        'user' => 'theusamarble_derm',
        'pass' => 'XR-Plus98',
        'name' => 'theusamarble_derm',
        'port' => '3306'
    );
}

//BEGIN mysql connection local
if ($localorweb==0) {
    $connectionLocal = array(
        'host' => $sqlHost,
        'user' => $sqlUser,
        'pass' => $sqlPass,
        'name' => $sqlName,
        'port' => $sqlPort
    );
}

$MysqlConnection = @mysqli_connect($connectionLocal['host'], $connectionLocal['user'], $connectionLocal['pass'], $connectionLocal['name'], $connectionLocal['port']);
if (mysqli_connect_errno()) {
	die('An error occurred while connecting to local database: ' . mysqli_connect_error());
}
$MysqlConnection->set_charset('utf8');
//END mysql connection local

//BEGIN mysql connection cloud
/*
$connectionCloud = array(
	'host' => '95.173.185.155',
	'name' => 'theusamarble_dbcloud',
	'user' => 'theusamarble_usercloud',
	'pass' => '123456',
	'port' => '3306'
);
$MysqlConnectionCloud = @mysqli_connect($connectionCloud['host'], $connectionCloud['user'], $connectionCloud['pass'], $connectionCloud['name'], $DbConnectionInfoCloud['port']);
if (mysqli_connect_errno()) {
	die('An error occurred while connecting to cloud database: ' . mysqli_connect_error());
}
$MysqlConnectionCloud->set_charset('utf8');
*/
//END mysql connection cloud


@$filename = $_SERVER['REQUEST_URI'];
$pself = $_SERVER['PHP_SELF'];

if (preg_match('/source\/settings.php/', $pself)) {
	header('location:../');
	die();
}




date_default_timezone_set('Etc/GMT-3');



if ($siteSSL == 1 ) {
    $httpText = 'https://';
    if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
        $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $location);
        exit;
    }
} else {
    $httpText = 'http://';
}



$derm_id = 1;
$siteName = 'dERM';
$sitePath = '/derm/';
//$sitePath = '/';
$siteCookiePrefix = preg_replace('/\s+/', '', $siteName);
$saltText = 'dermSalt' . $derm_id;
$onlineTime = 30; // minutes
$sitePhpSessionVersion = 'v1_0';
$siteJsVersion = 'v1.0.13';

if ($localorweb==1) {
    @$siteUrl = $httpText . $_SERVER['HTTP_HOST'] . '/';
}

if ($localorweb==0) {
    @$siteUrl = $httpText . $_SERVER['HTTP_HOST'] . $sitePath;
}




$firmParamTableName = 'param_ana_sirketler';

require_once('settings-model.php');
require_once('dbStrings.php');
//require_once('home-sku-list.php');
require_once('permissions.php');
require_once('firm-permissions.php');
require_once('menuactive.php');
require_once('pages.php');

$setting = array();
$settingsdb = GetListDataFromTable('settings', '*', '');
//var_dump($settingsdb);
foreach ($settingsdb as $val) {
	$setting[$val['name']] = $val['value'];
}

require_once('functions.php');
require_once('functions-special.php');
require_once(__DIR__ . '/../source/parameters.php');
require_once(__DIR__ . '/../vendor/autoload.php');


session_name($siteName . $sitePhpSessionVersion);
ob_start();
session_start();

if (isset($_COOKIE[$siteCookiePrefix . 'sessionId' . $sitePhpSessionVersion]) && !isset($_SESSION['userid'])) {
	UserLoginSessionId($_COOKIE[$siteCookiePrefix . 'sessionId' . $sitePhpSessionVersion]);
}

$CurrentUser = array();
$CurrentFirm = array();
if (isset($_SESSION['userid'])) {
	$CurrentUser = GetSingleDataFromTable('users', $_SESSION['userid']);
    $CurrentUser['initial'] = substr(ReplaceFromTR($CurrentUser['name']), 0, 1) . substr(ReplaceFromTR($CurrentUser['surname']), 0, 1);
	$CurrentUser['avatar'] = (isset($CurrentUser['avatar']) && !empty($CurrentUser['avatar'])) ? $siteUrl . $setting['avatar_image_location'] . $CurrentUser['avatar'] : $siteUrl . 'assets/img/avatar/default.jpg';
	$CurrentUser['permission'] = GetUserPermissions($CurrentUser['permissions']);
	$CurrentUser['permissionOfFirm'] = GetUserPermissionsOfFirm($CurrentUser);
	$CurrentUser['firmPermission'] = GetUserFirmPermissions($CurrentUser['firmpermissions']);
	$CurrentUser['firmList'] = GetUserFirmList($CurrentUser['firmpermissions']);

	if (!isset($_SESSION['selectedFirm'])) {
		$_SESSION['selectedFirm'] = 0;
	}

	$CurrentUser['selectedFirm'] = $_SESSION['selectedFirm'];

	if ($CurrentUser['selectedFirm'] > 0) {
		$CurrentFirm = GetSingleDataFromTable($firmParamTableName, $CurrentUser['selectedFirm']);
	}

	UpdateTable2('users', array('datelastonline'), array(date('Y-m-d H:i:s')), 'id', $_SESSION['userid']);
}


/*DOVİZ KURU*/
/*
$getDovizKuruYKB = GetSingleDataFromTableWithSingleWhere('temp', 'name="dovizKurYKB"');
$DovizKuruYKB = $getDovizKuruYKB['value1'];
*/
$getDovizKurlar = GetSingleDataFromTableWithSingleWhere('temp', 'name="dovizKurYKB"');
$DovizKuruUSD = $getDovizKurlar['value1'];
$DovizKuruEUR = $getDovizKurlar['value2'];