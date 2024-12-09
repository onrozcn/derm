<?php
/**
 * Created by PhpStorm.
 * User: Serhat Yılmaz Pc
 * Date: 7.7.2016
 * Time: 16:18
 */
require_once('../source/settings.php');
require_once('../source/settings-model.php');
if (!isset($_SESSION['logged'])) {
	header('location:' . $siteUrl . 'index.php');
	die();
}
if (isset($_POST['settingstype'])) {
	$settingstype = $_POST['settingstype'];
}
else {
	header('location:' . $siteUrl . 'index.php');
	die();
}
$action = (isset($_GET['Action']) && !empty($_GET['Action'])) ? MysqlSecureText($_GET['Action']) : '';
if ($action == 'SaveSettingsForm') {
	SaveSettingsForm(MysqlSecureText($settingstype), $_POST);
}

function SaveSettingsForm($settingstype, $post)
{
	global $settings_model;
	$emptyfield = false;
	$p = $settings_model[$settingstype];
	foreach ($p['fields'] as $f) {
		if (!$f['empty'] && $f['required'] && empty($post[$f['name']])) {
			$emptyfield = true;
			break;
		}
	}
	if ($emptyfield) {
		JsonResult('empty', 'Please fill in all required fields', 0);
	}
	else {
		$fields = array();
		$values = array();
		foreach ($p['fields'] as $f) {
			if (!$f['empty']) {
				$val = MysqlSecureText2($post[$f['name']]);
				if (isset($f['dotfix']) && $f['dotfix']) {
					$val = DotFix($val);
				}
				if ($f['name'] != 'id') {
					$fields[] = $f['name'];
					$values[] = $val;
				}
			}
		}
		$errors = 0;
		foreach ($p['fields'] as $f) {
			if (!$f['empty']) {
				if (GetRowCountWithSingleWhere('settings', 'type=' . $settingstype . ' and name="' . $f['name'] . '"') > 0) {
					if (!UpdateTable2WithSingleWhere2('settings', array('value'), array($post[$f['name']]), 'name="' . $f['name'] . '" and type=' . $settingstype)) {
						$errors++;
					}
				}
				else {
					if (!AddToTable('settings', array('type', 'name', 'value'), array($settingstype, $f['name'], $post[$f['name']]), false)) {
						$errors++;
					}
				}
			}
		}

		if ($errors <= 0) {
			JsonResult('ok', 'Kayıt başarıyla güncellendi', 0);
		}
		else {
			JsonResult('fail', 'Güncelleme sırasında hata oluştu', 0);
		}

	}
}