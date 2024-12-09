<?php
require_once('../source/settings.php');
if (!isset($_SESSION['logged'])) {
	header('location:' . $siteUrl . 'index.php');
	die();
}
if (isset($_GET['Action'])) {
	$action = $_GET['Action'];
}
else {
	header('location:' . $siteUrl . 'index.php');
	die();
}

if ($action == 'userProfile') {
	userProfile(
		isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0,
		isset($_POST['username']) ? MysqlSecureText($_POST['username']) : '',
		isset($_POST['name']) ? MysqlSecureText($_POST['name']) : '',
		isset($_POST['surname']) ? MysqlSecureText($_POST['surname']) : '',
		isset($_POST['email']) ? MysqlSecureText($_POST['email']) : '',
		isset($_POST['birthdayDate']) && isItDate($_POST['birthdayDate']) ? JsSlashDateFix(MysqlSecureText($_POST['birthdayDate'])) : '0000-00-00',
		isset($_POST['telegram_chatid']) ? MysqlSecureText($_POST['telegram_chatid']) : ''
	);
}
function userProfile($id, $username, $name, $surname, $email, $birthdayDate, $telegram_chatid)
{
	if (empty($username) || empty($name) || empty($surname)) {
		JsonResult('empty', 'Lütfen zorunla alanları doldurun', $id);
	}
	else {
		$checkUsername = GetRowCountWithSingleWhere('users', 'username="' . $username . '" and id<>' . $id);

		if ($checkUsername > 0) {
			JsonResult('duplicate', 'Bu kullanıcı adını başka bir kullanıcı kullanıyor.', $id);
		}
		else {

			if ($id > 0) {
				if (UpdateTable('users', array('username', 'name', 'surname', 'mail_address', 'birthday', 'telegram_chatid'),
                    array($username, $name, $surname, $email, $birthdayDate, $telegram_chatid),
                    'id', $id)) {
					JsonResult('ok', 'Profil kaydedildi' . $telegram_chatid, $id);
				}
				else {
					JsonResult('fail', 'İşlem sırasında hata oluştuQ', $id);
				}
			}
			else {
				if (AddToTable('users',
					array('username', 'name', 'surname', 'mail_address', 'birthday', 'telegram_chatid'),
					array($username, $name, $surname, $email, $birthdayDate, $telegram_chatid),
					false)) {
					$id = GetMaxIdOfTable('users');
					JsonResult('ok', 'Profil oluşturuldu', $id);
				}
				else {
					JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
				}
			}
		}
	}
}


if ($action == 'userPassword') {
	userPassword(
		isset($_POST['id']) ? MysqlSecureText($_POST['id']) : 0,
		isset($_POST['password']) ? MysqlSecureText($_POST['password']) : '',
		isset($_POST['password2']) ? MysqlSecureText($_POST['password2']) : ''
	);
}
function userPassword($id, $password, $password2)
{
	if (empty($id) || empty($password) || empty($password2)) {
		JsonResult('empty', 'Lütfen zorunla alanları doldurun', $id);
	}
	else if ($password != $password2) {
		JsonResult('notmatch', 'Şifreler eşleşmiyor', $id);
	}
	else {
		$password = md5(MysqlSecureText($password));
		if (UpdateTable2('users', array('password'), array($password), 'id', $id)) {
			JsonResult('ok', 'Şifre kaydedildi', $id);
		}
		else {
			JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
		}
	}
}

if ($action == 'userPermissions') {
	userPermissions($_POST);
}

function userPermissions($post)
{
	if (isset($post['id']) && !empty($post['id']) && is_numeric($post['id']) && $post['id'] > 0) {
		$id = MysqlSecureText($post['id']);

		if(SetUserPermissions($post) && SetUserPermissionsOfFirm($post)) {
            JsonResult('ok', 'Yetkiler kaydedildi', $id);
        } else {
            JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
        }
	}
	else {
		JsonResult('empty', 'Lütfen zorunlu alanları doldurun.', 0);
	}
}

if ($action == 'userFirmPermissions') {
	userFirmPermissions($_POST);
}

function userFirmPermissions($post)
{
	global $CurrentUser, $CurrentFirm;

	if (isset($post['id']) && !empty($post['id']) && is_numeric($post['id']) && $post['id'] > 0) {
		$id = MysqlSecureText($post['id']);

		if($id == $CurrentUser['id'] && (!isset($post['firmPermission']) || empty($post['firmPermission']))){
			JsonResult('fail', 'Kendi kullanıcınızın tüm firma yetkilerini kaldıramazsınız.', $id);
		}

		if($id == $CurrentUser['id'] && isset($post['firmPermission']) && !in_array($CurrentFirm['id'], $post['firmPermission'])){
			JsonResult('fail', 'Aktif firma yetkisini kaldıramazsınız.', $id);
		}

		$permissions = SetUserFirmPermissions($post);

		if (UpdateTable2('users', array('firmpermissions'), array($permissions), 'id', $id)) {
			JsonResult('ok', 'Yetkiler kaydedildi', $id);
		}
		else {
			JsonResult('fail', 'İşlem sırasında hata oluştu', $id);
		}
	}
	else {
		JsonResult('empty', 'Lütfen zorunlu alanları doldurun.', 0);
	}
}